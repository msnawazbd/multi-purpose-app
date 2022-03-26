<?php

namespace App\Http\Livewire\Admin\Clients;

use App\Http\Livewire\Admin\AdminComponent;
use App\Models\Client;

class ListClients extends AdminComponent
{
    public $searchKeywords = null;
    public $sortColumnName = 'created_at';
    public $sortDirection = 'desc';

    protected $queryString = ['searchKeywords' => ['except' => '']];

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

    public function render()
    {
        $clients = Client::query()
            ->where(function ($query) {
                $query->where('first_name', 'like', '%' . $this->searchKeywords . '%')
                    ->orWhere('last_name', 'like', '%' . $this->searchKeywords . '%')
                    ->orWhere('mobile', 'like', '%' . $this->searchKeywords . '%')
                    ->orWhere('reference_name', 'like', '%' . $this->searchKeywords . '%')
                    ->orWhere('reference_mobile', 'like', '%' . $this->searchKeywords . '%')
                    ->orWhere('email', 'like', '%' . $this->searchKeywords . '%');
            })
            ->orderBy($this->sortColumnName, $this->sortDirection)
            ->paginate(10);
        return view('livewire.admin.clients.list-clients', [
            'clients' => $clients
        ]);
    }
}
