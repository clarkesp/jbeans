<?php

namespace App\Filament\Resources\TeamInvitationResource\Pages;

use App\Filament\Resources\TeamInvitationResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewTeamInvitation extends ViewRecord
{
    protected static string $resource = TeamInvitationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
