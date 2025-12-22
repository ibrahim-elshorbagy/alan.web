<?php

namespace App\Livewire;

use Rappasoft\LaravelLivewireTables\Views\Column;
use Illuminate\Database\Eloquent\Builder;
use App\Models\ContactRequest;

class VcardContact extends LivewireTableComponent
{
    protected $model = ContactRequest::class;

    public bool $showButtonOnHeader = true;

    protected $listeners = ['refresh' => '$refresh', 'resetPageTable'];
    public string $buttonComponent = 'vcards.contact.vcard-contact-pdf-xls-button';

    public $vcardId;

    public function mount($vcardId)
    {
        $this->vcardId = $vcardId;
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setPageName('contact-request-table');
        $this->setDefaultSort('created_at', 'desc');
        $this->setColumnSelectStatus(false);
        $this->setQueryStringStatus(false);
        $this->resetPage('contact-request-table');
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.common.name'), "name")
                ->sortable()->searchable(),
            Column::make(__('messages.common.email'), "email")
                ->sortable()->searchable(),
            Column::make('region_code')->hideIf(true),
            Column::make(__('messages.common.phone'), "phone")
                ->sortable()->searchable()->view('vcards.contact.vcard-contact-column'),
            Column::make(__('messages.vcard.created_at'), "created_at")
                ->sortable(),
        ];
    }

    public function builder(): Builder
    {
        return ContactRequest::where('vcard_id', '=', $this->vcardId);
    }

    public function placeholder()
    {
        return view('lazy_loading/without-listing-skelecton');
    }
}
