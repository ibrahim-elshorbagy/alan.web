<?php

namespace App\Exports;

use App\Models\Contest;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class RedirectLinkContestsExport implements WithMultipleSheets
{
  protected int $redirectLinkId;

  public function __construct(int $redirectLinkId)
  {
    $this->redirectLinkId = $redirectLinkId;
  }

  public function sheets(): array
  {
    $contests = Contest::where('redirect_link_id', $this->redirectLinkId)
      ->orderBy('created_at', 'asc')
      ->get();

    return $contests->map(fn($contest) => new ContestSheetExport($contest->id, $contest->title))->all();
  }
}
