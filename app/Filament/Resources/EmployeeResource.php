<?php

namespace App\Filament\Resources;

use App\Filament\Resources\EmployeeResource\Pages;
use App\Filament\Resources\EmployeeResource\RelationManagers;
use App\Models\Employee;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
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
            Section::make('User Name')->schema([
                TextInput::make('first_name')->required()->maxLength(255),
                TextInput::make('middle_name')->required()->maxLength(255),
                TextInput::make('last_name')->required()->maxLength(255),
            ])->columns(3),
            Section::make('User Address')->schema([
                TextInput::make('address')->required()->maxLength(255),
                TextInput::make('zip_code')->required()->maxLength(255),
            ])->columns(2),
            TextInput::make('country_id')->required()->numeric(),
            TextInput::make('state_id')->required()->numeric(),
            TextInput::make('city_id')->required()->numeric(),
            TextInput::make('department_id')->required()->numeric(),
            DatePicker::make('date_of_birth')->required(),
            DatePicker::make('date_hired')->required(),
        ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('country_id')->numeric()->sortable(),
            TextColumn::make('state_id')->numeric()->sortable(),
            TextColumn::make('city_id')->numeric()->sortable(),
            TextColumn::make('department_id')->numeric()->sortable(),
            TextColumn::make('first_name')->searchable(),
            TextColumn::make('last_name')->searchable(),
            TextColumn::make('middle_name')->searchable(),
            TextColumn::make('address')->searchable(),
            TextColumn::make('zip_code')->searchable(),
            TextColumn::make('date_of_birth')->date()->sortable(),
            TextColumn::make('date_hired')->date()->sortable(),
            TextColumn::make('created_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            TextColumn::make('updated_at')->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
        ])
        ->filters([
         //
        ])
        ->actions([
            ViewAction::make(),
            EditAction::make(),
        ])
        ->bulkActions([
            BulkActionGroup::make([
                DeleteBulkAction::make(),
            ]),
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
