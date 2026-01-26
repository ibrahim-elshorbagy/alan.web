<?php

namespace App\Livewire;

use App\Models\RedirectLink;
use App\Models\User;
use App\Models\Nfc;
use App\Enums\RedirectLinkTypeEnum;
use Livewire\Component;
use Livewire\WithPagination;

class RedirectLinksCustomTable extends Component
{
  use WithPagination;

  protected $paginationTheme = 'bootstrap';

  // Filter properties
  public $statusFilter = '';
  public $redirectTypeFilter = '';
  public $cardTypeFilter = '';
  public $assignedFilter = '';
  public $dateFromFilter = '';
  public $dateToFilter = '';
  public $groupByFilter = '';
  public $searchQuery = '';
  public $perPage = 25;
  public $sortField = 'updated_at';
  public $sortDirection = 'desc';

  // Selected items for bulk actions
  public $selected = [];
  public $selectAll = false;

  // Accordion state - which groups are expanded
  public $expandedGroups = [];

  // Per-group pagination - tracks current page for each group
  public $groupPages = [];
  public $itemsPerGroup = 10;

  protected $queryString = [];

  protected $listeners = ['refresh' => '$refresh'];

  public function updatingPage()
  {
    // Clear selections when changing pages
    $this->reset(['selected', 'selectAll']);
  }

  public function updatingPerPage()
  {
    // Clear selections when changing items per page
    $this->reset(['selected', 'selectAll']);
    $this->resetPage();
  }

  public function updatingSearchQuery()
  {
    $this->reset(['selected', 'selectAll']);
    $this->resetPage();
  }

  public function updatingStatusFilter()
  {
    $this->reset(['selected', 'selectAll']);
    $this->resetPage();
  }

  public function updatingRedirectTypeFilter()
  {
    $this->reset(['selected', 'selectAll']);
    $this->resetPage();
  }

  public function updatingCardTypeFilter()
  {
    $this->reset(['selected', 'selectAll']);
    $this->resetPage();
  }

  public function updatingAssignedFilter()
  {
    $this->reset(['selected', 'selectAll']);
    $this->resetPage();
  }

  public function updatingGroupByFilter()
  {
    $this->reset(['selected', 'selectAll', 'expandedGroups', 'groupPages']);
    $this->resetPage();
  }

  public function sortBy($field)
  {
    if ($this->sortField === $field) {
      $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
    } else {
      $this->sortField = $field;
      $this->sortDirection = 'asc';
    }
  }

  public function toggleSelectAll()
  {
    if ($this->selectAll) {
      // Only select items on current page, not all items
      $currentPageItems = $this->getQuery()->paginate($this->perPage);
      $this->selected = $currentPageItems->pluck('id')->map(fn($id) => (string) $id)->toArray();
    } else {
      $this->selected = [];
    }
  }

  public function toggleGroupSelectAll($groupKey, $items)
  {
    // Convert to collection if it's a string (JSON), array, or already a collection
    if (is_string($items)) {
      $items = collect(json_decode($items, true));
    } elseif (is_array($items)) {
      $items = collect($items);
    }

    // Get IDs from current page of this group
    $itemIds = $items->pluck('id')->map(fn($id) => (string) $id)->toArray();

    // Check if all items in this group page are already selected
    $allSelected = !empty($itemIds) && count(array_intersect($itemIds, $this->selected)) === count($itemIds);

    if ($allSelected) {
      // Deselect all items from this group page
      $this->selected = array_values(array_diff($this->selected, $itemIds));
    } else {
      // Select all items from this group page
      $this->selected = array_unique(array_merge($this->selected, $itemIds));
    }
  }

  public function updatedSelectAll()
  {
    // When selectAll checkbox is toggled, handle the selection
    if ($this->selectAll) {
      // User checked the box - select all items on current page
      if ($this->groupByFilter) {
        // In grouped view, don't auto-select, let user click specific group checkboxes
        $this->selectAll = false;
      } else {
        // In normal view, select current page items
        $currentPageItems = $this->getQuery()->paginate($this->perPage);
        $this->selected = $currentPageItems->pluck('id')->map(fn($id) => (string) $id)->toArray();
      }
    } else {
      // User unchecked the box - clear all selections
      $this->selected = [];
    }
  }

  public function toggleGroup($groupKey)
  {
    if (in_array($groupKey, $this->expandedGroups)) {
      $this->expandedGroups = array_filter($this->expandedGroups, fn($g) => $g !== $groupKey);
    } else {
      $this->expandedGroups[] = $groupKey;
      // Initialize page for this group if not set
      if (!isset($this->groupPages[$groupKey])) {
        $this->groupPages[$groupKey] = 1;
      }
    }
    // Clear selections when toggling groups
    $this->reset(['selected', 'selectAll']);
  }

  public function nextGroupPage($groupKey)
  {
    if (!isset($this->groupPages[$groupKey])) {
      $this->groupPages[$groupKey] = 1;
    }
    $this->groupPages[$groupKey]++;
    // Clear selections when changing group pages
    $this->reset(['selected', 'selectAll']);
  }

  public function prevGroupPage($groupKey)
  {
    if (!isset($this->groupPages[$groupKey])) {
      $this->groupPages[$groupKey] = 1;
    }
    if ($this->groupPages[$groupKey] > 1) {
      $this->groupPages[$groupKey]--;
    }
    // Clear selections when changing group pages
    $this->reset(['selected', 'selectAll']);
  }

  public function getGroupItems($groupKey, $allItems)
  {
    $currentPage = $this->groupPages[$groupKey] ?? 1;
    $offset = ($currentPage - 1) * $this->itemsPerGroup;
    return $allItems->slice($offset, $this->itemsPerGroup);
  }

  public function getGroupTotalPages($groupKey, $allItems)
  {
    return ceil($allItems->count() / $this->itemsPerGroup);
  }

  public function expandAllGroups()
  {
    $groupedData = $this->getGroupedData();
    if ($groupedData) {
      $this->expandedGroups = $groupedData->keys()->map(fn($k) => (string) $k)->toArray();
    }
  }

  public function collapseAllGroups()
  {
    $this->expandedGroups = [];
  }

  public function hasSelected()
  {
    return count($this->selected) > 0;
  }

  public function getSelected()
  {
    return $this->selected;
  }

  public function exportSelected()
  {
    $selectedIds = $this->selected;

    if (empty($selectedIds)) {
      session()->flash('error', __('messages.redirect_links.no_items_selected'));
      return;
    }

    // For sales, ensure they can only export their assigned links
    if (auth()->user()->hasRole('sales')) {
      $selectedIds = RedirectLink::whereIn('id', $selectedIds)
        ->where('assigned_id', auth()->id())
        ->pluck('id')
        ->toArray();

      if (empty($selectedIds)) {
        session()->flash('error', __('messages.redirect_links.no_items_selected'));
        return;
      }
    }

    return redirect()->route('redirect-links.export-selected', ['ids' => implode(',', $selectedIds)]);
  }

  public function markSelectedAsReceived()
  {
    $selectedIds = $this->selected;

    if (empty($selectedIds)) {
      session()->flash('error', __('messages.redirect_links.no_items_selected'));
      return;
    }

    // For sales, ensure they can only mark their assigned links as received
    if (auth()->user()->hasRole('sales')) {
      $selectedIds = RedirectLink::whereIn('id', $selectedIds)
        ->where('assigned_id', auth()->id())
        ->pluck('id')
        ->toArray();

      if (empty($selectedIds)) {
        session()->flash('error', __('messages.redirect_links.no_items_selected'));
        return;
      }
    }

    return redirect()->route('redirect-links.mark-selected-received', ['ids' => implode(',', $selectedIds)]);
  }

  public function syncAndRestore()
  {
    if (!auth()->user()->hasRole('super_admin')) {
      session()->flash('error', __('messages.common.unauthorized'));
      return;
    }

    $selectedIds = $this->selected;

    if (empty($selectedIds)) {
      session()->flash('error', __('messages.redirect_links.no_items_selected'));
      return;
    }

    $updated = RedirectLink::whereIn('id', $selectedIds)
      ->whereNull('user_id')
      ->update(['user_id' => null, 'assigned_id' => null, 'received_status' => RedirectLink::RECEIVED_STATUS_NOT_RECEIVED]);

    if ($updated > 0) {
      session()->flash('success', __('messages.redirect_links.restored_successfully') . ' (' . $updated . ' links)');
    } else {
      session()->flash('error', __('messages.redirect_links.no_links_restored'));
    }

    $this->selected = [];
    $this->resetPage();
  }

  public function markAsReceived($id)
  {
    $redirectLink = RedirectLink::findOrFail($id);

    if (auth()->user()->hasRole('sales') && $redirectLink->assigned_id == auth()->id() && $redirectLink->received_status == RedirectLink::RECEIVED_STATUS_NOT_RECEIVED) {
      $redirectLink->update(['received_status' => RedirectLink::RECEIVED_STATUS_RECEIVED]);
      $this->dispatch('refresh');
    }
  }

  public function resetFilters()
  {
    $this->statusFilter = '';
    $this->redirectTypeFilter = '';
    $this->cardTypeFilter = '';
    $this->assignedFilter = '';
    $this->dateFromFilter = '';
    $this->dateToFilter = '';
    $this->groupByFilter = '';
    $this->searchQuery = '';
    $this->expandedGroups = [];
    $this->resetPage();
  }

  protected function getQuery()
  {
    // Select only necessary columns to reduce data transfer
    $query = RedirectLink::query()
      ->select(
        'id',
        'user_id',
        'assigned_id',
        'nfcs_id',
        'uri',
        'redirect_link_type',
        'status',
        'price',
        'sales_price',
        'received_status',
        'created_at',
        'updated_at'
      )
      // Only load necessary relationship columns
      ->with([
        'user:id,first_name,last_name',
        'assignedUser:id,first_name,last_name',
        'nfc:id,name,price,sales_price'
      ]);

    if (auth()->user()->hasRole('sales')) {
      $query->where('assigned_id', auth()->id());
    }

    // Search
    if ($this->searchQuery !== '') {
      $searchTerm = $this->searchQuery;
      $query->where(function ($q) use ($searchTerm) {
        $q->where('uri', 'like', "{$searchTerm}%") // Changed from %term% to term% for better index usage
          ->orWhereHas('user', function ($userQ) use ($searchTerm) {
            $userQ->where('first_name', 'like', "{$searchTerm}%")
              ->orWhere('last_name', 'like', "{$searchTerm}%");
          });
      });
    }

    // Apply filters
    if ($this->statusFilter !== '') {
      $query->where('status', $this->statusFilter);
    }

    if ($this->redirectTypeFilter !== '') {
      $query->where('redirect_link_type', $this->redirectTypeFilter);
    }

    if ($this->cardTypeFilter !== '') {
      $query->where('nfcs_id', $this->cardTypeFilter);
    }

    if ($this->assignedFilter !== '' && !auth()->user()->hasRole('sales')) {
      $query->where('assigned_id', $this->assignedFilter);
    }

    // Date range filters
    if ($this->dateFromFilter !== '' || $this->dateToFilter !== '') {
      $query->where(function ($q) {
        $q->where(function ($dateQ) {
          if ($this->dateFromFilter !== '') {
            $dateQ->where('redirect_links.created_at', '>=', $this->dateFromFilter . ' 00:00:00');
          }
          if ($this->dateToFilter !== '') {
            $dateQ->where('redirect_links.created_at', '<=', $this->dateToFilter . ' 23:59:59');
          }
        })->orWhere(function ($dateQ) {
          if ($this->dateFromFilter !== '') {
            $dateQ->where('redirect_links.updated_at', '>=', $this->dateFromFilter . ' 00:00:00');
          }
          if ($this->dateToFilter !== '') {
            $dateQ->where('redirect_links.updated_at', '<=', $this->dateToFilter . ' 23:59:59');
          }
        });
      });
    }

    // Apply sorting
    $query->orderBy($this->sortField, $this->sortDirection);

    return $query;
  }

  public function getGroupedData()
  {
    if ($this->groupByFilter === '' || !auth()->user()->hasRole('super_admin')) {
      return null;
    }

    // Limit to 500 items for better performance
    $rows = $this->getQuery()->limit(500)->get();

    switch ($this->groupByFilter) {
      case 'redirect_type':
        return $rows->groupBy('redirect_link_type');
      case 'nfc_card':
        return $rows->groupBy('nfcs_id');
      case 'sales_rep':
        return $rows->groupBy('assigned_id');
      default:
        return null;
    }
  }

  public function getGroupName($groupKey)
  {
    if ($groupKey === null || $groupKey === '') {
      return __('messages.redirect_links.not_assigned');
    }

    switch ($this->groupByFilter) {
      case 'redirect_type':
        try {
          return RedirectLinkTypeEnum::from($groupKey)->label();
        } catch (\Exception $e) {
          return 'Unknown Type';
        }
      case 'nfc_card':
        $nfc = Nfc::find($groupKey);
        return $nfc ? $nfc->name : 'N/A';
      case 'sales_rep':
        $user = User::find($groupKey);
        return $user ? $user->first_name . ' ' . $user->last_name : __('messages.redirect_links.not_assigned');
      default:
        return 'Unknown';
    }
  }

  public function getGroupPurchasePrice($items)
  {
    return $items->sum(fn($row) => $row->price ?? 0);
  }

  public function getGroupSalesPrice($items)
  {
    return $items->sum(fn($row) => $row->sales_price ?? 0);
  }

  public function getTotalPurchasePrice()
  {
    // Create a separate query for sum to avoid conflicts with select
    $query = RedirectLink::query();

    if (auth()->user()->hasRole('sales')) {
      $query->where('assigned_id', auth()->id());
    }

    // Apply same filters
    if ($this->searchQuery !== '') {
      $searchTerm = $this->searchQuery;
      $query->where(function ($q) use ($searchTerm) {
        $q->where('uri', 'like', "{$searchTerm}%")
          ->orWhereHas('user', function ($userQ) use ($searchTerm) {
            $userQ->where('first_name', 'like', "{$searchTerm}%")
              ->orWhere('last_name', 'like', "{$searchTerm}%");
          });
      });
    }

    if ($this->statusFilter !== '') {
      $query->where('status', $this->statusFilter);
    }

    if ($this->redirectTypeFilter !== '') {
      $query->where('redirect_link_type', $this->redirectTypeFilter);
    }

    if ($this->cardTypeFilter !== '') {
      $query->where('nfcs_id', $this->cardTypeFilter);
    }

    if ($this->assignedFilter !== '' && !auth()->user()->hasRole('sales')) {
      $query->where('assigned_id', $this->assignedFilter);
    }

    if ($this->dateFromFilter !== '' || $this->dateToFilter !== '') {
      $query->where(function ($q) {
        $q->where(function ($dateQ) {
          if ($this->dateFromFilter !== '') {
            $dateQ->where('redirect_links.created_at', '>=', $this->dateFromFilter . ' 00:00:00');
          }
          if ($this->dateToFilter !== '') {
            $dateQ->where('redirect_links.created_at', '<=', $this->dateToFilter . ' 23:59:59');
          }
        })->orWhere(function ($dateQ) {
          if ($this->dateFromFilter !== '') {
            $dateQ->where('redirect_links.updated_at', '>=', $this->dateFromFilter . ' 00:00:00');
          }
          if ($this->dateToFilter !== '') {
            $dateQ->where('redirect_links.updated_at', '<=', $this->dateToFilter . ' 23:59:59');
          }
        });
      });
    }

    return $query->sum('price');
  }

  public function getTotalSalesPrice()
  {
    // Create a separate query for sum to avoid conflicts with select
    $query = RedirectLink::query();

    if (auth()->user()->hasRole('sales')) {
      $query->where('assigned_id', auth()->id());
    }

    // Apply same filters as getTotalPurchasePrice
    if ($this->searchQuery !== '') {
      $searchTerm = $this->searchQuery;
      $query->where(function ($q) use ($searchTerm) {
        $q->where('uri', 'like', "{$searchTerm}%")
          ->orWhereHas('user', function ($userQ) use ($searchTerm) {
            $userQ->where('first_name', 'like', "{$searchTerm}%")
              ->orWhere('last_name', 'like', "{$searchTerm}%");
          });
      });
    }

    if ($this->statusFilter !== '') {
      $query->where('status', $this->statusFilter);
    }

    if ($this->redirectTypeFilter !== '') {
      $query->where('redirect_link_type', $this->redirectTypeFilter);
    }

    if ($this->cardTypeFilter !== '') {
      $query->where('nfcs_id', $this->cardTypeFilter);
    }

    if ($this->assignedFilter !== '' && !auth()->user()->hasRole('sales')) {
      $query->where('assigned_id', $this->assignedFilter);
    }

    if ($this->dateFromFilter !== '' || $this->dateToFilter !== '') {
      $query->where(function ($q) {
        $q->where(function ($dateQ) {
          if ($this->dateFromFilter !== '') {
            $dateQ->where('redirect_links.created_at', '>=', $this->dateFromFilter . ' 00:00:00');
          }
          if ($this->dateToFilter !== '') {
            $dateQ->where('redirect_links.created_at', '<=', $this->dateToFilter . ' 23:59:59');
          }
        })->orWhere(function ($dateQ) {
          if ($this->dateFromFilter !== '') {
            $dateQ->where('redirect_links.updated_at', '>=', $this->dateFromFilter . ' 00:00:00');
          }
          if ($this->dateToFilter !== '') {
            $dateQ->where('redirect_links.updated_at', '<=', $this->dateToFilter . ' 23:59:59');
          }
        });
      });
    }

    return $query->sum('sales_price');
  }

  public function getTotalCount()
  {
    // Create a separate query for count
    $query = RedirectLink::query();

    if (auth()->user()->hasRole('sales')) {
      $query->where('assigned_id', auth()->id());
    }

    // Apply same filters
    if ($this->searchQuery !== '') {
      $searchTerm = $this->searchQuery;
      $query->where(function ($q) use ($searchTerm) {
        $q->where('uri', 'like', "{$searchTerm}%")
          ->orWhereHas('user', function ($userQ) use ($searchTerm) {
            $userQ->where('first_name', 'like', "{$searchTerm}%")
              ->orWhere('last_name', 'like', "{$searchTerm}%");
          });
      });
    }

    if ($this->statusFilter !== '') {
      $query->where('status', $this->statusFilter);
    }

    if ($this->redirectTypeFilter !== '') {
      $query->where('redirect_link_type', $this->redirectTypeFilter);
    }

    if ($this->cardTypeFilter !== '') {
      $query->where('nfcs_id', $this->cardTypeFilter);
    }

    if ($this->assignedFilter !== '' && !auth()->user()->hasRole('sales')) {
      $query->where('assigned_id', $this->assignedFilter);
    }

    if ($this->dateFromFilter !== '' || $this->dateToFilter !== '') {
      $query->where(function ($q) {
        $q->where(function ($dateQ) {
          if ($this->dateFromFilter !== '') {
            $dateQ->where('redirect_links.created_at', '>=', $this->dateFromFilter . ' 00:00:00');
          }
          if ($this->dateToFilter !== '') {
            $dateQ->where('redirect_links.created_at', '<=', $this->dateToFilter . ' 23:59:59');
          }
        })->orWhere(function ($dateQ) {
          if ($this->dateFromFilter !== '') {
            $dateQ->where('redirect_links.updated_at', '>=', $this->dateFromFilter . ' 00:00:00');
          }
          if ($this->dateToFilter !== '') {
            $dateQ->where('redirect_links.updated_at', '<=', $this->dateToFilter . ' 23:59:59');
          }
        });
      });
    }

    return $query->count();
  }

  public function getSalesUsers()
  {
    return User::role('sales')->get();
  }

  public function getNfcCards()
  {
    return Nfc::all();
  }

  public function getRedirectTypes()
  {
    return RedirectLinkTypeEnum::cases();
  }

  public function render()
  {
    $groupedData = $this->getGroupedData();
    $isGrouped = $groupedData !== null && count($groupedData) > 0;

    return view('livewire.redirect-links-custom-table', [
      'redirectLinks' => $isGrouped ? null : $this->getQuery()->paginate($this->perPage),
      'groupedData' => $groupedData,
      'isGrouped' => $isGrouped,
      'salesUsers' => $this->getSalesUsers(),
      'nfcCards' => $this->getNfcCards(),
      'redirectTypes' => $this->getRedirectTypes(),
      'totalPurchasePrice' => $this->getTotalPurchasePrice(),
      'totalSalesPrice' => $this->getTotalSalesPrice(),
      'totalCount' => $this->getTotalCount(),
    ]);
  }
}
