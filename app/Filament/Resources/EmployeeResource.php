<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\City;
use Filament\Tables;
use App\Models\State;
use App\Models\Country;
use App\Models\Employee;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Actions\AttachAction;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\EmployeeResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\EmployeeResource\RelationManagers;
// use App\Filament\Resources\EmployeeResource\Widgets\EmployeeStatsOverview;
use App\Filament\Resources\EmployeeResource\RelationManagers\DepartementsRelationManager;
use App\Models\Departement;
use Closure;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-briefcase';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()
                    ->schema([
                        TextInput::make('first_name')
                            ->required()
                            ->maxLength(255),
                        
                        TextInput::make('last_name')
                            ->required()
                            ->maxLength(255),
                        
                        DatePicker::make('birth_date')
                            ->required(),
                        
                        DatePicker::make('date_hired')
                            ->required()
                    ])->columns(2),
                
                Section::make('Address')->schema([

                        Select::make('country_id')
                            ->relationship('country','name')
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(function (callable $set) {
                                $set('state_id',null);
                                $set('city_id',null);
                            })
                            ->columnSpan(2),

                        Select::make('state_id')
                            ->options(function (callable $get) {
                                $country = Country::find($get('country_id'));
                                if(!$country) {
                                    return [];
                                }
                                return $country->states->pluck('name','id');
                            })
                            ->required()
                            ->reactive()
                            ->afterStateUpdated(fn (callable $set) => $set('city_id',null))
                            ->columnSpan(2),
                        
                        Select::make('city_id')
                            ->options(function (callable $get) {
                                $state = State::find($get('state_id'));
                                if(!$state) {
                                    return [];
                                }
                                return $state->cities->pluck('name','id');
                            })
                            ->required()
                            ->columnSpan(2),

                        

                        // Select::make('departement_id')
                        //     ->relationship('departement','name')
                        //     ->required()
                        //     ->columnSpan(2),

                        TextInput::make('address')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(3),
                        
                        TextInput::make('zip_code')
                            ->required()
                            ->maxLength(5)
                            ->columnSpan(1),
                    ])->columns(4),
                    
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('first_name')->sortable()->searchable(),
                TextColumn::make('last_name')->sortable()->searchable(),    
                TextColumn::make('date_hired')->date(),
                TextColumn::make('created_at')->dateTime()
            ])
            ->filters([
                // SelectFilter::make('departement')->relationship('departement','name')
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                AttachAction::make()
                    ->recordTitleAttribute('name')
                    ->preloadRecordSelect(true)
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            DepartementsRelationManager::class,
        ];
    }

    public static function getWidgets(): array
    {
        return [
            // EmployeeStatsOverview::class,
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }    
}
