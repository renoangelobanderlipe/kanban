<?php

namespace App\Filament\Pages;

use App\Enums\UserStatus;
use App\Models\User;
use Illuminate\Support\Collection;
use Mokhosh\FilamentKanban\Pages\KanbanBoard;

class UsersKanbanBoard extends KanbanBoard
{
  protected static string $recordTitleAttribute = 'name';

  // protected static string $model = Model::class;
  // protected static string $statusEnum = ModelStatus::class;

  protected function statuses(): Collection
  {
    return UserStatus::statuses();
  }

  protected function records(): Collection
  {
    return User::latest('updated_at')->get();
  }

  public function onStatusChanged(int $recordId, string $status, array $fromOrderedIds, array $toOrderedIds): void
  {
    User::find($recordId)->update(['status' => $status]);
  }

  public function onSortChanged(int $recordId, string $status, array $toOrderedIds): void
  {
    User::setNewOrder($toOrderedIds);
  }
}
