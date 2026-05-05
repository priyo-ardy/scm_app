<?php

namespace App\Filament\Resources\ApprovalLogs\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Schema;

class ApprovalLogInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextEntry::make('approval_flow_id')
                    ->numeric(),
                TextEntry::make('document_type'),
                TextEntry::make('document_id')
                    ->numeric(),
                TextEntry::make('current_step_order')
                    ->numeric(),
                TextEntry::make('current_approver_id')
                    ->numeric()
                    ->placeholder('-'),
                TextEntry::make('status'),
                TextEntry::make('processed_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('created_at')
                    ->dateTime()
                    ->placeholder('-'),
                TextEntry::make('updated_at')
                    ->dateTime()
                    ->placeholder('-'),
            ]);
    }
}
