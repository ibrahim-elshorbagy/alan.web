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

  // For bulk assignment
  public $assignedUserId = '';

  // For acknowledgment creation
  public $acknowledgmentSalesUserId = '';
  public $acknowledgmentValidationErrors = [];

  // Accordion state - which groups are expanded
  public $expandedGroups = [];

  // Per-group pagination - tracks current page for each group
  public $groupPages = [];
  public $itemsPerGroup = 10;

  protected $queryString = [];

  protected $listeners = [];

  public function updatingPage()
  {
    // Keep selections when changing pages - don't clear them
    // This allows users to select items across multiple pages
  }

  public function updatingPerPage()
  {
    // Keep selections when changing items per page
    // $this->reset(['selected']);
    $this->resetPage();
  }

  public function updatedPerPage()
  {
    // After `perPage` changes, apply it to grouped tables as well
    $this->itemsPerGroup = $this->perPage;
    // Reset group pagination to start (so pages don't point to invalid offsets)
    $this->groupPages = [];
    // Keep selections
    // $this->reset(['selected']);
    $this->resetPage();
  }

  public function mount()
  {
    // Ensure itemsPerGroup follows initial perPage value
    $this->itemsPerGroup = $this->perPage;

    // Auto-set grouping by card type for super admin and sales
    if (auth()->user()->hasRole(['super_admin', 'sales'])) {
      $this->groupByFilter = 'nfc_card';
    }
  }

  public function performSearch()
  {
    $this->resetPage();
  }

  public function updatingStatusFilter()
  {
    // Keep selections when filtering
    // $this->reset(['selected']);
    $this->resetPage();
  }

  public function updatingRedirectTypeFilter()
  {
    // Keep selections when filtering
    // $this->reset(['selected']);
    $this->resetPage();
  }

  public function updatingCardTypeFilter()
  {
    // Keep selections when filtering
    // $this->reset(['selected']);
    $this->resetPage();
  }

  public function updatingAssignedFilter()
  {
    // Keep selections when filtering
    // $this->reset(['selected']);
    $this->resetPage();
  }

  public function updatingGroupByFilter()
  {
    // Keep selections when changing grouping
    // Only reset expanded groups and group pages
    $this->reset(['expandedGroups', 'groupPages']);
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
    // When sorting, reset per-group pagination but keep selections
    $this->groupPages = [];
    // $this->reset(['selected']);
    $this->resetPage();
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
    // Keep selections when toggling groups
    // $this->reset(['selected']);
  }

  public function nextGroupPage($groupKey)
  {
    if (!isset($this->groupPages[$groupKey])) {
      $this->groupPages[$groupKey] = 1;
    }
    $this->groupPages[$groupKey]++;
    // Keep selections when changing group pages
    // $this->reset(['selected']);
  }

  public function prevGroupPage($groupKey)
  {
    if (!isset($this->groupPages[$groupKey])) {
      $this->groupPages[$groupKey] = 1;
    }
    if ($this->groupPages[$groupKey] > 1) {
      $this->groupPages[$groupKey]--;
    }
    // Keep selections when changing group pages
    // $this->reset(['selected']);
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

    // Get the actual user ID (considering impersonation)
    $actualUserId = auth()->user()->isImpersonated()
      ? app('impersonate')->getImpersonatorId()
      : auth()->id();

    $redirectLinks = RedirectLink::whereIn('id', $selectedIds)->get();
    $updated = 0;

    foreach ($redirectLinks as $redirectLink) {
      // Skip if already received
      if ($redirectLink->received_status == RedirectLink::RECEIVED_STATUS_RECEIVED) {
        continue;
      }

      $redirectLink->update([
        'received_status' => RedirectLink::RECEIVED_STATUS_RECEIVED,
      ]);

      // Log received status change
      $redirectLink->logHistory(
        'received_status_changed',
        __('messages.redirect_links.not_received'),
        __('messages.redirect_links.received'),
        $actualUserId,
        __('messages.redirect_links.history.received_status_changed', [
          'old' => __('messages.redirect_links.not_received'),
          'new' => __('messages.redirect_links.received')
        ])
      );

      $updated++;
    }

    if ($updated > 0) {
      session()->flash('success', __('messages.redirect_links.marked_as_received') . ' (' . $updated . ' links)');
    } else {
      session()->flash('error', __('messages.redirect_links.no_links_marked'));
    }

    $this->selected = [];
  }

  public function bulkAssign()
  {
    // Allow both super_admin and sales to bulk assign
    if (!auth()->user()->hasRole('super_admin') && !auth()->user()->hasRole('sales')) {
      session()->flash('error', __('messages.common.unauthorized'));
      return;
    }

    $selectedIds = $this->selected;
    $assignedUserId = $this->assignedUserId;

    if (empty($selectedIds)) {
      session()->flash('error', __('messages.redirect_links.no_items_selected'));
      return;
    }

    if (empty($assignedUserId)) {
      session()->flash('error', __('messages.redirect_links.please_select_user'));
      return;
    }

    // Get the actual user ID (considering impersonation)
    $actualUserId = auth()->user()->isImpersonated()
      ? app('impersonate')->getImpersonatorId()
      : auth()->id();

    // For sales, only allow reassigning their own assigned links
    if (auth()->user()->hasRole('sales')) {
      $redirectLinks = RedirectLink::whereIn('id', $selectedIds)
        ->where('assigned_id', auth()->id())
        ->get();
    } else {
      $redirectLinks = RedirectLink::whereIn('id', $selectedIds)->get();
    }

    if ($redirectLinks->isEmpty()) {
      session()->flash('error', __('messages.redirect_links.no_links_to_assign'));
      return;
    }

    $newAssignedUser = User::find($assignedUserId);
    $updated = 0;

    foreach ($redirectLinks as $redirectLink) {
      $oldAssignedId = $redirectLink->assigned_id;
      $oldAssignedUser = $oldAssignedId ? $redirectLink->assignedUser : null;

      // Update assignment
      $redirectLink->update([
        'assigned_id' => $assignedUserId,
        // If sales is reassigning, reset received status to NOT_RECEIVED
        'received_status' => RedirectLink::RECEIVED_STATUS_NOT_RECEIVED,
      ]);

      // Log assignment change history
      $redirectLink->logHistory(
        'assigned_id_changed',
        $oldAssignedUser ? ($oldAssignedUser->first_name . ' ' . $oldAssignedUser->last_name) : __('messages.redirect_links.history.none'),
        $newAssignedUser->first_name . ' ' . $newAssignedUser->last_name,
        $actualUserId,
        __('messages.redirect_links.history.assigned_changed', [
          'old' => $oldAssignedUser ? ($oldAssignedUser->first_name . ' ' . $oldAssignedUser->last_name) : __('messages.redirect_links.history.none'),
          'new' => $newAssignedUser->first_name . ' ' . $newAssignedUser->last_name
        ])
      );

      // If sales is reassigning, log received status reset
      if (auth()->user()->hasRole('sales') && $redirectLink->received_status != RedirectLink::RECEIVED_STATUS_NOT_RECEIVED) {
        $redirectLink->logHistory(
          'received_status_changed',
          __('messages.redirect_links.received'),
          __('messages.redirect_links.not_received'),
          $actualUserId,
          __('messages.redirect_links.history.received_status_changed', [
            'old' => __('messages.redirect_links.received'),
            'new' => __('messages.redirect_links.not_received')
          ])
        );
      }

      $updated++;
    }

    if ($updated > 0) {
      session()->flash('success', __('messages.redirect_links.assigned_successfully') . ' (' . $updated . ' ' . __('messages.redirect_links.links') . ')');
    } else {
      session()->flash('error', __('messages.redirect_links.no_links_assigned'));
    }

    // Reset assigned user after successful assignment
    $this->assignedUserId = '';
    $this->resetPage();
  }

  public function createAcknowledgment()
  {
    // Only super_admin can create acknowledgments
    if (!auth()->user()->hasRole('super_admin')) {
      session()->flash('error', __('messages.common.unauthorized'));
      return;
    }

    $selectedIds = $this->selected;
    $salesUserId = $this->acknowledgmentSalesUserId;

    if (empty($selectedIds)) {
      session()->flash('error', __('messages.redirect_links.no_items_selected'));
      return;
    }

    // Get selected redirect links
    $redirectLinks = RedirectLink::whereIn('id', $selectedIds)->get();

    if ($redirectLinks->isEmpty()) {
      session()->flash('error', __('messages.redirect_links.no_items_selected'));
      return;
    }

    // VALIDATION: Check if sales rep is selected and cards belong to them and aren't already acknowledged
    $this->acknowledgmentValidationErrors = [];
    $invalidCards = [];

    // Check if sales representative is selected
    if (empty($salesUserId)) {
      $this->acknowledgmentValidationErrors[] = [
        'type' => 'no_sales_rep',
        'message' => __('messages.redirect_links.please_select_sales_representative')
      ];
      $this->dispatch('showAcknowledgmentValidationErrors');
      return;
    }

    // Get all existing acknowledgments with their redirect_link_ids
    $existingAcknowledgments = \App\Models\RedirectLinkAcknowledgment::all();
    $alreadyAcknowledgedIds = [];
    foreach ($existingAcknowledgments as $ack) {
      $ackIds = is_string($ack->redirect_link_ids) ? json_decode($ack->redirect_link_ids, true) : $ack->redirect_link_ids;
      if (is_array($ackIds)) {
        $alreadyAcknowledgedIds = array_merge($alreadyAcknowledgedIds, $ackIds);
      }
    }

    foreach ($redirectLinks as $link) {
      $errors = [];

      // Check if card belongs to selected sales representative
      if ($link->assigned_id != $salesUserId) {
        $errors[] = __('messages.redirect_links.card_not_owned');
      }

      // Check if card is already in another acknowledgment
      if (in_array($link->id, $alreadyAcknowledgedIds)) {
        $errors[] = __('messages.redirect_links.card_already_in_acknowledgment');
      }

      if (!empty($errors)) {
        $invalidCards[] = [
          'uri' => $link->uri,
          'id' => $link->id,
          'errors' => $errors
        ];
      }
    }

    // If validation errors, just return (modal stays open, shows errors)
    if (!empty($invalidCards)) {
      $this->acknowledgmentValidationErrors = $invalidCards;
      return;
    }

    // Calculate totals
    $totalPrice = $redirectLinks->sum('price');
    $totalSalesPrice = $redirectLinks->sum('sales_price');
    $totalCount = $redirectLinks->count();

    // Create acknowledgment
    $acknowledgment = \App\Models\RedirectLinkAcknowledgment::create([
      'sales_user_id' => $salesUserId,
      'created_by' => auth()->id(),
      'redirect_link_ids' => $selectedIds,
      'total_price' => $totalPrice,
      'total_sales_price' => $totalSalesPrice,
      'total_count' => $totalCount,
    ]);

    // Get the actual user ID (considering impersonation)
    $actualUserId = auth()->user()->isImpersonated()
      ? app('impersonate')->getImpersonatorId()
      : auth()->id();

    // Log history for each card added to the acknowledgment
    foreach ($redirectLinks as $link) {
      $link->logHistory(
        'added_to_acknowledgment',
        __('messages.redirect_links.history.none'),
        '#' . $acknowledgment->id,
        $actualUserId,
        __('messages.redirect_links.history.added_to_acknowledgment', [
          'acknowledgment_id' => $acknowledgment->id
        ])
      );
    }

    // Clear everything
    $this->acknowledgmentValidationErrors = [];
    $this->acknowledgmentSalesUserId = '';
    $this->selected = [];

    // Set success message and redirect (modal closes automatically on redirect)
    session()->flash('success', __('messages.acknowledgment_created'));
    return redirect()->route('acknowledgments.view', $acknowledgment->id);
  }

  public function clearAcknowledgmentErrors()
  {
    $this->acknowledgmentValidationErrors = [];
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
    // Clear selections after restore
    // $this->selected = [];
    $this->resetPage();
  }

  public function markAsReceived($id)
  {
    $redirectLink = RedirectLink::findOrFail($id);

    if (auth()->user()->hasRole('sales') && $redirectLink->assigned_id == auth()->id() && $redirectLink->received_status == RedirectLink::RECEIVED_STATUS_NOT_RECEIVED) {
      // Get the actual user ID (considering impersonation)
      $actualUserId = auth()->user()->isImpersonated()
        ? app('impersonate')->getImpersonatorId()
        : auth()->id();

      $redirectLink->update([
        'received_status' => RedirectLink::RECEIVED_STATUS_RECEIVED,
      ]);

      // Log received status change
      $redirectLink->logHistory(
        'received_status_changed',
        __('messages.redirect_links.not_received'),
        __('messages.redirect_links.received'),
        $actualUserId,
        __('messages.redirect_links.history.received_status_changed', [
          'old' => __('messages.redirect_links.not_received'),
          'new' => __('messages.redirect_links.received')
        ])
      );
    }
  }

  public function delete($id)
  {
    try {
      $redirectLink = RedirectLink::findOrFail($id);

      // Check permissions
      if (auth()->user()->hasRole('sales')) {
        // Sales cannot delete at all
        session()->flash('error', __('messages.common.unauthorized'));
        return;
      }

      // Super admin cannot delete links with user_id
      if (auth()->user()->hasRole('super_admin') && $redirectLink->user_id !== null) {
        session()->flash('error', __('messages.redirect_links.cannot_delete_assigned_link'));
        return;
      }

      $redirectLink->delete();

      // Remove from selected if it was selected
      $this->selected = array_values(array_filter($this->selected, fn($selectedId) => $selectedId != $id));

      session()->flash('success', __('messages.redirect_links.deleted_successfully'));

      // Refresh without page reload

    } catch (\Exception $e) {
      session()->flash('error', __('messages.common.something_went_wrong'));
    }
  }

  public function deleteSelected()
  {
    try {
      $selectedIds = $this->selected;

      if (empty($selectedIds)) {
        session()->flash('error', __('messages.common.no_records_selected'));
        return;
      }

      // Check permissions
      if (auth()->user()->hasRole('sales')) {
        // Sales cannot delete at all
        session()->flash('error', __('messages.common.unauthorized'));
        return;
      }

      // Build query based on user role
      $query = RedirectLink::whereIn('id', $selectedIds);

      // For super admin, exclude links with user_id
      if (auth()->user()->hasRole('super_admin')) {
        $query->whereNull('user_id');
      }

      $count = $query->count();

      if ($count === 0) {
        session()->flash('error', __('messages.redirect_links.no_eligible_links_to_delete'));
        return;
      }

      $query->delete();

      // Clear selections after delete
      $this->selected = [];

      session()->flash('success', __('messages.redirect_links.deleted_count', ['count' => $count]));

      // Refresh without page reload

    } catch (\Exception $e) {
      session()->flash('error', __('messages.common.something_went_wrong'));
    }
  }

  public function bulkDelete()
  {
    // Alias for deleteSelected for consistency
    $this->deleteSelected();
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
    // Keep selections when resetting filters
    // Users might want to keep their selections even when clearing filters
    // $this->selected = [];
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
      $searchTerms = array_map('trim', preg_split('/\s*-\s*|\s+|\n+/', $this->searchQuery));
      $searchTerms = array_filter($searchTerms);
      if (!empty($searchTerms)) {
        $query->where(function ($q) use ($searchTerms) {
          foreach ($searchTerms as $term) {
            $q->orWhere('uri', '=', $term)
              ->orWhere('id', '=', $term);
          }
          if (count($searchTerms) == 1) {
            $q->orWhereHas('user', function ($userQ) use ($searchTerms) {
              $userQ->where('first_name', 'like', '%' . $searchTerms[0] . '%')
                ->orWhere('last_name', 'like', '%' . $searchTerms[0] . '%');
            });
          }
        });
      }
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
    if ($this->groupByFilter === '' || !in_array($this->groupByFilter, $this->getAllowedGroupByOptions())) {
      return null;
    }

    // Limit to 500 items for better performance
    $rows = $this->getQuery()->limit(500)->get();

    $grouped = null;

    switch ($this->groupByFilter) {
      case 'redirect_type':
        $grouped = $rows->groupBy('redirect_link_type');
        break;
      case 'nfc_card':
        $grouped = $rows->groupBy('nfcs_id');
        break;
      case 'sales_rep':
        $grouped = $rows->groupBy('assigned_id');
        break;
      default:
        return null;
    }

    // Sort groups by name in ascending order
    return $grouped->sortBy(function ($group, $key) {
      return $this->getGroupName($key);
    });
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
      $searchTerms = array_map('trim', preg_split('/\s*-\s*|\s+|\n+/', $this->searchQuery));
      $searchTerms = array_filter($searchTerms);
      if (!empty($searchTerms)) {
        $query->where(function ($q) use ($searchTerms) {
          foreach ($searchTerms as $term) {
            $q->orWhere('uri', 'like', '%' . $term . '%')
              ->orWhere('id', 'like', '%' . $term . '%');
          }
          if (count($searchTerms) == 1) {
            $q->orWhereHas('user', function ($userQ) use ($searchTerms) {
              $userQ->where('first_name', 'like', '%' . $searchTerms[0] . '%')
                ->orWhere('last_name', 'like', '%' . $searchTerms[0] . '%');
            });
          }
        });
      }
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
      $searchTerms = array_map('trim', preg_split('/\s*-\s*|\s+|\n+/', $this->searchQuery));
      $searchTerms = array_filter($searchTerms);
      if (!empty($searchTerms)) {
        $query->where(function ($q) use ($searchTerms) {
          foreach ($searchTerms as $term) {
            $q->orWhere('uri', 'like', '%' . $term . '%')
              ->orWhere('id', 'like', '%' . $term . '%');
          }
          if (count($searchTerms) == 1) {
            $q->orWhereHas('user', function ($userQ) use ($searchTerms) {
              $userQ->where('first_name', 'like', '%' . $searchTerms[0] . '%')
                ->orWhere('last_name', 'like', '%' . $searchTerms[0] . '%');
            });
          }
        });
      }
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
      $searchTerms = array_map('trim', preg_split('/\s*-\s*|\s+|\n+/', $this->searchQuery));
      $searchTerms = array_filter($searchTerms);
      if (!empty($searchTerms)) {
        $query->where(function ($q) use ($searchTerms) {
          foreach ($searchTerms as $term) {
            $q->orWhere('uri', 'like', '%' . $term . '%')
              ->orWhere('id', 'like', '%' . $term . '%');
          }
          if (count($searchTerms) == 1) {
            $q->orWhereHas('user', function ($userQ) use ($searchTerms) {
              $userQ->where('first_name', 'like', '%' . $searchTerms[0] . '%')
                ->orWhere('last_name', 'like', '%' . $searchTerms[0] . '%');
            });
          }
        });
      }
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

  public function getAllowedGroupByOptions()
  {
    $options = ['redirect_type', 'nfc_card'];
    if (auth()->user()->hasRole('super_admin')) {
      $options[] = 'sales_rep';
    }
    return $options;
  }

  public function getSelectedUris()
  {
    if (empty($this->selected)) return [];
    return RedirectLink::whereIn('id', $this->selected)->pluck('uri')->toArray();
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
      'allowedGroupByOptions' => $this->getAllowedGroupByOptions(),
      'totalPurchasePrice' => $this->getTotalPurchasePrice(),
      'totalSalesPrice' => $this->getTotalSalesPrice(),
      'totalCount' => $this->getTotalCount(),
      'selectedUris' => $this->getSelectedUris(),
    ]);
  }
}
