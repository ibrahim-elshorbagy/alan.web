<?php

namespace App\Livewire;

use Livewire\Component;

class AdminDashboard extends Component
{
  public $enquiry, $appointment, $activeVcard, $totalRedirectLinks, $totalWpTemplate, $totalOrder, $totalPendingOrder;
  public function mount($enquiry, $appointment, $activeVcard, $totalRedirectLinks, $totalWpTemplate, $totalOrder, $totalPendingOrder)
  {
    $this->enquiry = $enquiry;
    $this->appointment = $appointment;
    $this->activeVcard = $activeVcard;
    $this->totalRedirectLinks = $totalRedirectLinks;
    $this->totalWpTemplate = $totalWpTemplate;
    $this->totalOrder = $totalOrder;
    $this->totalPendingOrder = $totalPendingOrder;
  }
  public function placeholder()
  {
    return view('lazy_loading.admin-dashboard');
  }
  public function render()
  {
    return view('livewire.admin-dashboard');
  }
}
