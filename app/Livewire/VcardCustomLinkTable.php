<?php

namespace App\Livewire;

use Rappasoft\LaravelLivewireTables\Views\Column;
use App\Models\CustomLink;
use Illuminate\Database\Eloquent\Builder;

class VcardCustomLinkTable extends LivewireTableComponent
{
    protected $model = CustomLink::class;

    public bool $showButtonOnHeader = true;

    public string $buttonComponent = 'vcards.custom-link.add-button';

    protected $listeners = ['refresh' => '$refresh'];

    public $vcardId;

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setPageName('vcard-custome-link-table');
        $this->setDefaultSort('created_at', 'desc');
        $this->setColumnSelectStatus(false);
        $this->setQueryStringStatus(false);
        $this->resetPage('vcard-custome-link-table');

        $this->setThAttributes(function (Column $column) {
            if ($column->isField('id')) {
                return [
                    'class' => 'text-center',
                ];
            }
            return [];
        });
    }

    public function columns(): array
    {
        return [
            Column::make(__('messages.custom_links.link_name'), 'link_name')
                ->view('vcards.custom-link.columns.link_name')
                ->sortable()
                ->searchable(),
            Column::make(__('messages.custom_links.link'), 'link')
                ->view('vcards.custom-link.columns.custom_link')
                ->sortable()
                ->searchable(),
            Column::make(__('messages.custom_links.show_as_button'), 'show_as_button')
                ->view('vcards.custom-link.columns.show_as_button'),
            Column::make(__('messages.custom_links.open_in_new_tab'), 'open_new_tab')
                ->view('vcards.custom-link.columns.open_new_tab'),
            Column::make(__('messages.common.action'), 'id')->view('vcards.custom-link.columns.action'),
        ];
    }

    public function builder(): Builder
    {
        return CustomLink::whereVcardId($this->vcardId)->select('custom_links.*');
    }
}
