<?php

namespace App\Filament\Resources\UrlResource\Pages;

use App\Filament\Resources\UrlResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Infolists\Infolist;
use Illuminate\Database\Eloquent\Model;

class ViewUrl extends ViewRecord
{
    protected static string $resource = UrlResource::class;

    public function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([]);
    }

}
