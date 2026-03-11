<?php

namespace App\Exports;

use App\Models\ContestParticipant;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithTitle;

class ContestSheetExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithTitle
{
  protected int $contestId;
  protected string $contestTitle;
  private int $rowIndex = 0;

  public function __construct(int $contestId, string $contestTitle)
  {
    $this->contestId    = $contestId;
    $this->contestTitle = $contestTitle;
  }

  public function title(): string
  {
    // Excel sheet names: max 31 chars, no: \ / ? * [ ] :
    $safe = preg_replace('/[\/\\\?\*\[\]:\'"]+/', '', $this->contestTitle);
    $safe = trim($safe);

    return mb_substr($safe ?: ('Contest_' . $this->contestId), 0, 31);
  }

  public function query()
  {
    return ContestParticipant::where('contest_id', $this->contestId)
      ->orderBy('created_at', 'asc');
  }

  public function headings(): array
  {
    return [
      '#',
      __('messages.contest.contest_name_col'),
      __('messages.contest.participant_name'),
      __('messages.contest.participant_phone'),
      __('messages.contest.joined_at'),
      __('messages.contest.winner_status'),
    ];
  }

  public function map($participant): array
  {
    $this->rowIndex++;

    $winnerStatus = '-';
    if ($participant->winner_rank) {
      $winnerStatus = __('messages.contest.winner_rank', ['rank' => $participant->winner_rank]);
    }

    return [
      $this->rowIndex,
      $this->contestTitle,
      $participant->name,
      $participant->phone,
      $participant->created_at->format('Y-m-d H:i'),
      $winnerStatus,
    ];
  }
}
