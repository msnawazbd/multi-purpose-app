<?php

namespace App\Http\Livewire\Admin\Testimonials;

use App\Http\Livewire\Admin\AdminComponent;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Auth;

class ListTestimonials extends AdminComponent
{
    public $message, $status, $created_at, $updated_at, $created_by, $updated_by;

    public $testimonialId;
    public $searchKeywords = null;
    public $sortColumnName = 'created_at';
    public $sortDirection = 'desc';

    protected $queryString = ['searchKeywords' => ['except' => '']];

    protected $listeners = [
        'confirmDestroy' => 'confirmDestroy'
    ];

    public function updatedSearchKeywords()
    {
        $this->resetPage();
    }

    public function sortBy($columnName)
    {
        if ($this->sortColumnName === $columnName) {
            $this->sortDirection = $this->swapSortDirection();
        } else {
            $this->sortDirection = 'asc';
        }

        $this->sortColumnName = $columnName;
    }

    public function swapSortDirection()
    {
        return $this->sortDirection === 'asc' ? 'desc' : 'asc';
    }

    public function changeStatus($testimonialId)
    {
        try {
            $testimonial = Testimonial::query()->findOrFail($testimonialId);
            $testimonial->status = $testimonial->status == 1 ? 0 : 1;
            $testimonial->updated_by = Auth::user()->id;
            $testimonial->save();
            $this->dispatchBrowserEvent('success', ['message' => 'Testimonial status changed.']);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => "Operation failed!"]);
            return redirect()->back();
        }
    }

    public function show($testimonialId)
    {
        try {
            $testimonial = Testimonial::query()
                ->with([
                    'createdBy:id,name',
                    'updatedBy:id,name',
                ])
                ->where('id', $testimonialId)
                ->first();

            $this->message = $testimonial->message;
            $this->status = $testimonial->status;
            $this->created_at = $testimonial->created_at ? $testimonial->created_at->toFormattedDate() : 'N/A';
            $this->updated_at = $testimonial->updated_at ? $testimonial->updated_at->toFormattedDate() : 'N/A';
            $this->created_by = $testimonial->createdBy->name;
            $this->updated_by = $testimonial->updatedBy ? $testimonial->updatedBy->name : 'N/A';

            $this->dispatchBrowserEvent('show-view-modal');
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => 'Operation failed!']);
            return redirect()->route('admin.tasks');
        }
    }

    public function destroy($testimonialId)
    {
        $this->testimonialId = $testimonialId;
        $this->dispatchBrowserEvent('show-delete-confirmation');
    }

    public function confirmDestroy()
    {
        try {
            $data = Testimonial::query()->findOrFail($this->testimonialId);
            $data->delete();
            $this->dispatchBrowserEvent('deleted', ['message' => 'Testimonial deleted successfully.']);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => "Operation failed!"]);
            return redirect()->back();
        }
    }

    public function render()
    {
        $testimonials = Testimonial::query()
            ->with([
                'createdBy:id,name'
            ])
            ->where(function ($query) {
                $query->where('message', 'like', '%' . $this->searchKeywords . '%');
            })
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->select(['*'])
            ->paginate(5);

        return view('livewire.admin.testimonials.list-testimonials', [
            'testimonials' => $testimonials
        ]);
    }
}
