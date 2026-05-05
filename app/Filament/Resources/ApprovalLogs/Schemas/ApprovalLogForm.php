<?php

namespace App\Filament\Resources\ApprovalLogs\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ApprovalLogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('approval_flow_id')
                    ->required()
                    ->numeric(),
                TextInput::make('document_type')
                    ->required(),
                TextInput::make('document_id')
                    ->required()
                    ->numeric(),
                TextInput::make('current_step_order')
                    ->required()
                    ->numeric(),
                TextInput::make('current_approver_id')
                    ->numeric()
                    ->default(null),
                TextInput::make('status')
                    ->required()
                    ->default('pending'),
                DateTimePicker::make('processed_at'),
            ]);
    }
}
