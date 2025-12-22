<?php

namespace App\Livewire;

use Illuminate\Database\Eloquent\Builder;
use App\Models\WhatsappStoreEmailSubscription;
use Rappasoft\LaravelLivewireTables\Views\Column;

class WhatsappStoreSubscriber extends LivewireTableComponent
{
    protected $model = WhatsappStoreEmailSubscription::class;

    public bool $showButtonOnHeader = false;

    protected $listeners = ['refresh' => '$refresh', 'resetPageTable'];

    public $whatsappStoreId;

    public function mount($whatsappStoreId)
    {
        $this->whatsappStoreId = $whatsappStoreId;
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setPageName('whatsapp-store-email-subscriber-table');
        $this->setDefaultSort('created_at', 'desc');
        $this->setColumnSelectStatus(false);
        $this->setQueryStringStatus(false);
        $this->resetPage('whatsapp-store-email-subscriber-table');
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.common.email'), "email")
                ->searchable()
                ->sortable(),
            Column::make(__('messages.vcard.created_at'), "created_at")
                ->sortable(),
        ];
    }

    public function builder(): Builder
    {
        return WhatsappStoreEmailSubscription::query()->where('whatsapp_store_id', '=', $this->whatsappStoreId);
    }

    public function placeholder()
    {
        return view('lazy_loading/without-listing-skelecton');
    }
}
