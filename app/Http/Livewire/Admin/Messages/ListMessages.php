<?php

namespace App\Http\Livewire\Admin\Messages;

use App\Exports\MessagesExport;
use App\Http\Livewire\Admin\AdminComponent;
use App\Models\Message;

class ListMessages extends AdminComponent
{
    public $messageId;
    public $status = null;
    public $selectedRows = [];
    public $selectPageRows = false;

    protected $queryString = ['status'];

    protected $listeners = [
        'confirmDestroy' => 'confirmDestroy'
    ];

    public function updatedSelectPageRows($value)
    {
        if ($value) {
            $this->selectedRows = $this->messages->pluck('id')->map(function ($id) {
                return (string)$id;
            });
        } else {
            $this->reset(['selectedRows', 'selectPageRows']);
        }
    }

    public function deleteSelectedRows()
    {
        try {
            Message::query()->whereIn('id', $this->selectedRows)->delete();
            $this->dispatchBrowserEvent('deleted', ['message' => 'All selected message got deleted.']);
            $this->reset(['selectedRows', 'selectPageRows']);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => "Operation failed!"]);
            return redirect()->back();
        }
    }

    public function markAllAsPending()
    {
        try {
            Message::query()->whereIn('id', $this->selectedRows)->update(['status' => 'PENDING']);
            $this->dispatchBrowserEvent('success', ['message' => 'Messages marked as pending.']);
            $this->reset(['selectedRows', 'selectPageRows']);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => "Operation failed!"]);
            return redirect()->back();
        }
    }

    public function markAllAsConfirmed()
    {
        try {
            Message::query()->whereIn('id', $this->selectedRows)->update(['status' => 'CONFIRMED']);
            $this->dispatchBrowserEvent('success', ['message' => 'Messages marked as confirmed.']);
            $this->reset(['selectedRows', 'selectPageRows']);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => "Operation failed!"]);
            return redirect()->back();
        }
    }

    public function export()
    {
        return (new MessagesExport($this->selectedRows))->download('messages.xlsx');
    }

    public function destroy($messageId)
    {
        $this->messageId = $messageId;
        $this->dispatchBrowserEvent('show-delete-confirmation');
    }

    public function confirmDestroy()
    {
        try {
            $data = Message::query()->findOrFail($this->messageId);
            $data->delete();
            $this->dispatchBrowserEvent('deleted', ['message' => 'Message deleted successfully.']);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => "Operation failed!"]);
            return redirect()->back();
        }
    }

    public function filterByStatus($status = null)
    {
        $this->resetPage();
        $this->status = $status;
    }

    public function changeStatus($message_id)
    {
        try {
            $message = Message::query()->findOrFail($message_id);
            $message->status = $message->status == 'PENDING' ? 'CONFIRMED' : 'PENDING';
            $message->save();
            $this->dispatchBrowserEvent('success', ['message' => 'Messages status changed.']);
        } catch (\Exception $e) {
            $this->dispatchBrowserEvent('error', ['message' => "Operation failed!"]);
            return redirect()->back();
        }
    }

    public function getMessagesProperty()
    {
        return Message::query()
            ->with([
                //'client'
            ])
            ->when($this->status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(5);
    }

    public function render()
    {
        $messagesCount = Message::query()->count();
        $pendingMessagesCount = Message::query()->where('status', 'PENDING')->count();
        $confirmedMessagesCount = Message::query()->where('status', 'CONFIRMED')->count();
        return view('livewire.admin.messages.list-messages', [
                'messages' => $this->messages,
                'messagesCount' => $messagesCount,
                'pendingMessagesCount' => $pendingMessagesCount,
                'confirmedMessagesCount' => $confirmedMessagesCount,
            ]
        );
    }
}
