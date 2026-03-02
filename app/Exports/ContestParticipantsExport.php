<?php

namespace App\Exports;

use App\Models\ContestParticipant;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class ContestParticipantsExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
  protected int $contestId;
  protected ?string $search;
  protected ?string $dateFrom;
  protected ?string $dateTo;

  private int $rowIndex = 0;

  public function __construct(int $contestId, ?string $search = null, ?string $dateFrom = null, ?string $dateTo = null)
  {
    $this->contestId = $contestId;
    $this->search    = $search;
    $this->dateFrom  = $dateFrom;
    $this->dateTo    = $dateTo;
  }

  public function query()
  {
    $query = ContestParticipant::where('contest_id', $this->contestId);

    if ($this->search) {
      $search = $this->search;
      $query->where(function ($q) use ($search) {
        $q->where('name', 'like', '%' . $search . '%')
          ->orWhere('phone', 'like', '%' . $search . '%');
      });
    }

    if ($this->dateFrom) {
      $query->whereDate('created_at', '>=', $this->dateFrom);
    }

    if ($this->dateTo) {
      $query->whereDate('created_at', '<=', $this->dateTo);
    }

    return $query->orderBy('created_at', 'asc');
  }

  public function headings(): array
  {
    return [
      '#',
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
      $participant->name,
      $participant->phone,
      $participant->created_at->format('Y-m-d H:i'),
      $winnerStatus,
    ];
  }
}
