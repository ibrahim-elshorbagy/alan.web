<?php

namespace App\Livewire;

use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\CustomDomain;

class CustomDomainDataTable extends LivewireTableComponent
{
    protected $model = CustomDomain::class;

    protected $listeners = ['refresh' => '$refresh'];

    public bool $showButtonOnHeader = true;

    public string $buttonComponent = 'settings.custom_domains.columns.suggestion_button';
    public function configure(): void
    {
        $this->setPrimaryKey('id');
    }

    public function columns(): array
    {
        return [
            Column::make("Id", "id")->hideIf(1),
            Column::make("Domain", "domain")
                ->searchable()
                ->sortable(),
            Column::make(__("messages.common.user"), "user_id")
                ->view('settings.custom_domains.columns.user_id')
                ->searchable()
                ->sortable(),
            Column::make(__("messages.common.is_active"), 'is_active')
                ->view('settings.custom_domains.columns.is_active'),
            Column::make(__("messages.common.status"), "is_approved")
                ->view('settings.custom_domains.columns.is_approved')
                ->sortable(),
            Column::make(__("messages.vcard.created_at"), "created_at")
                ->view('settings.custom_domains.columns.created_at')
                ->sortable(),
            Column::make(__("messages.mail.notes"), "note")
                ->view('settings.custom_domains.columns.note')
                ->sortable()
                ->searchable(),
        ];
    }
}
