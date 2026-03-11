<?php

namespace App\Exports;

use App\Models\Contest;
use App\Models\RedirectLink;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class AllUserContestsExport implements WithMultipleSheets
{
  protected int $userId;

  public function __construct(int $userId)
  {
    $this->userId = $userId;
  }

  public function sheets(): array
  {
    $redirectLinkIds = RedirectLink::where('user_id', $this->userId)->pluck('id');

    $contests = Contest::whereIn('redirect_link_id', $redirectLinkIds)
      ->orderBy('redirect_link_id', 'asc')
      ->orderBy('created_at', 'asc')
      ->get();

    return $contests->map(fn($contest) => new ContestSheetExport($contest->id, $contest->title))->all();
  }
}
