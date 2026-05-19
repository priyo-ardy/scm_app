<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;

class UsersForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(3)
            ->schema([
                Section::make()
                    ->schema([
                        FileUpload::make('avatar')
                            ->image()
                            ->imageEditor()
                            ->avatar()
                            ->alignCenter()
                            ->visibility('public')
                            ->directory('user-avatar')
                            ->disk('public')
                            ->columnSpanFull()
                            ->imagePreviewHeight('350px')
                            ->removeUploadedFileButtonPosition('right')
                            ->saveRelationshipsUsing(null),
                    ])->columnSpan(1),
                Section::make()
                    ->schema([
                        Select::make('assign_company')
                            ->label('Assign to Company')
                            ->required()
                            ->relationship('companyList', 'name')
                            ->searchable(['slug', 'name'])
                            ->preload()
                            ->nullable(),
                        TextInput::make('name')
                            ->label('Full Name')
                            ->required()
                            ->maxLength(150)
                            ->placeholder('Full name')
                            ->autocomplete(false)
                            ->autofocus(true),
                        TextInput::make('email')
                            ->label('Email Address')
                            ->email()
                            ->unique(ignoreRecord: true)
                            ->required()
                            ->maxLength(150)
                            ->placeholder('Email address')
                            ->autocomplete(false)
                            ->autofocus(false)
                            ->validationMessages([
                                'This email address already registered',
                            ]),
                        TextInput::make('phone')
                            ->label('Phone Number')
                            ->tel()
                            ->maxLength(20)
                            ->placeholder('Phone number')
                            ->autocomplete(false)
                            ->autofocus(false),
                        TextInput::make('password')
                            ->label('Password')
                            ->password()
                            ->revealable()
                            ->required(fn ($context) => $context === 'create')
                            ->dehydrated(fn ($state) => filled($state))
                            ->mutateDehydratedStateUsing(fn ($state) => Hash::make($state))
                            ->columnSpanFull(),
                        Select::make('role')
                            ->label('User Role')
                            ->relationship('roles', 'name')
                            ->native()
                            ->preload()
                            ->searchable()
                            ->required(),
                        Select::make('department_id')
                            ->label('Department')
                            ->relationship('department', 'name')
                            ->searchable()
                            ->native(false)
                            ->live()
                            ->afterStateUpdated(fn (Set $set) => $set('section_id', null))
                            ->preload(),
                        Select::make('section_id')
                            ->label('Section')
                            ->relationship('sectionList', 'name', modifyQueryUsing: fn (Builder $query, Get $get) => $query->where('department_id', $get('department_id')))
                            ->searchable()
                            ->preload()
                            ->native(false),
                        Textarea::make('remark')
                            ->label('Remark')
                            ->placeholder('Additional Information')
                            ->trim()
                            ->disableGrammarly()
                            ->cols(20)
                            ->columnSpanFull()
                            ->rows(5),
                    ])->columnSpan(2),
            ]);
    }
}
