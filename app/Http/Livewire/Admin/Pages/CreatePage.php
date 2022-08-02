<?php


namespace App\Http\Livewire\Admin\Pages;

use App\Models\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class CreatePage extends Component
{

    public $state = [];

    public function create()
    {
        $validateData = Validator::make($this->state, [
            'page_name' => 'required|string|max:100',
            'page_title' => 'required|string|max:250',
            'page_details' => 'required|string',
            'status' => 'required|numeric',
            'meta_title' => 'nullable|string|max:250',
            'meta_keywords' => 'nullable|string|max:250',
            'meta_description' => 'nullable|string',
        ])->validate();

        $validateData['created_by'] = Auth::user()->id;
        $validateData['page_slug'] = toFormattedSlug($this->state['page_title']);

        try {
            Page::query()->create($validateData);

            $this->dispatchBrowserEvent('success', ['message' => 'Page created successfully.']);
            return redirect()->route('admin.pages');
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => "Operation failed!"]);
            return redirect()->back();
        }
    }

    public function render()
    {
        return view('livewire.admin.pages.create-page');
    }
}
