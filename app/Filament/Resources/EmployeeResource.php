<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Filament\Resources\EmployeeResource\RelationManagers;
use App\Models\Employee;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Infolists;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $navigationLabel = 'Employee';

    protected static ?string $navigationGroup = 'Employee Management';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\Section::make('User Name')->schema([
                Forms\Components\TextInput::make('first_name')->required()->maxLength(255),
                Forms\Components\TextInput::make('middle_name')->required()->maxLength(255),
                Forms\Components\TextInput::make('last_name')->required()->maxLength(255),
            ])->columns(3),
            Forms\Components\Section::make('User Address')->schema([
                Forms\Components\Select::make('country_id')
                    ->label('Country')
                    ->relationship(name: 'country', titleAttribute: 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->native(false)
                    ->live()
                    ->afterStateUpdated(function (Set $set)
                    {
                        $set('state_id', null);
                        $set('city_id', null);
                    }),
                Forms\Components\Select::make('state_id')
                    ->label('State')
                    ->relationship(name: 'state', titleAttribute: 'name', modifyQueryUsing: fn(Builder $query, Get $get) => $query->where('country_id', $get('country_id')))
                    ->searchable()
                    ->preload()
                    ->required()
                    ->native(false)
                    ->live()
                    ->afterStateUpdated(function (Set $set)
                    {
                        $set('city_id', null);
                    }),
                Forms\Components\Select::make('city_id')
                    ->label('City')
                    ->relationship(name: 'city', titleAttribute: 'name', modifyQueryUsing: fn(Builder $query, Get $get) => $query->where('state_id', $get('state_id')))
                    ->searchable()
                    ->preload()
                    ->required()
                    ->native(false)
                    ->live(),
                Forms\Components\Select::make('department_id')
                    ->label('Department')
                    ->relationship(name: 'department', titleAttribute: 'name')
                    ->searchable()
                    ->preload()
                    ->required()
                    ->native(false),
                Forms\Components\Textarea::make('address')->required()->maxLength(255),
                Forms\Components\TextInput::make('zip_code')->required()->maxLength(255),
            ])->columns(2),
            Forms\Components\Section::make('Dates')->schema([
                Forms\Components\DatePicker::make('date_of_birth')
                    ->required()
                    ->displayFormat('d/m/Y')
                    ->closeOnDateSelection(),
                Forms\Components\DatePicker::make('date_hired')
                    ->required()
                    ->displayFormat('d/m/Y')
                    ->closeOnDateSelection(),
            ])->columns(2)
        ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            Tables\Columns\TextColumn::make('first_name')->searchable(),
            Tables\Columns\TextColumn::make('last_name')->searchable(),
            Tables\Columns\TextColumn::make('middle_name')->searchable()->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('country.name')->numeric()->sortable()->searchable(),
            Tables\Columns\TextColumn::make('state.name')->numeric()->sortable()->searchable(),
            Tables\Columns\TextColumn::make('city.name')->numeric()->sortable()->searchable(),
            Tables\Columns\TextColumn::make('department.name')->numeric()->sortable()->searchable(),
            Tables\Columns\TextColumn::make('address')->searchable()->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('zip_code')->searchable()->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('date_of_birth')->date()->sortable(),
            Tables\Columns\TextColumn::make('date_hired')
                ->date()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('created_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
            Tables\Columns\TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),
        ])->filters([
            Tables\Filters\SelectFilter::make('Department')
                ->relationship('department', 'name')
                ->searchable()
                ->preload()
                ->label('Filter by Department')
                ->indicator('Department')
        ])->actions([
            Tables\Actions\ViewAction::make(),
            Tables\Actions\EditAction::make(),
        ])->bulkActions([
            Tables\Actions\BulkActionGroup::make([
                Tables\Actions\DeleteBulkAction::make(),
            ]),
        ]);
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist->schema([
            Infolists\Components\Section::make('Name')->schema([
                Infolists\Components\TextEntry::make('first_name'),
                Infolists\Components\TextEntry::make('middle_name'),
                Infolists\Components\TextEntry::make('last_name'),
            ])->columns(3),
            Infolists\Components\Section::make('Address')->schema([
                Infolists\Components\TextEntry::make('country.name'),
                Infolists\Components\TextEntry::make('state.name'),
                Infolists\Components\TextEntry::make('city.name'),
                Infolists\Components\TextEntry::make('department.name'),
                Infolists\Components\TextEntry::make('address'),
                Infolists\Components\TextEntry::make('zip_code'),
            ])->columns(2),
            Infolists\Components\Section::make('Dates')->schema([
                Infolists\Components\TextEntry::make('date_of_birth')->dateTime('d-m-Y'),
                Infolists\Components\TextEntry::make('date_hired')->dateTime('d-m-Y'),
            ])->columns(2)
        ]);
    }

    public static function getRelations(): array
    {
        return [//
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'view' => Pages\ViewEmployee::route('/{record}'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }
}
