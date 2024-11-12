<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Project;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Filament\Resources\Resource;
use Awcodes\Shout\Components\Shout;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Illuminate\Database\Eloquent\Builder;
use Mokhosh\FilamentRating\Components\Rating;
use Filament\Forms\Components\SpatieTagsInput;
use App\Filament\Resources\ProjectResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Awcodes\FilamentStickyHeader\StickyHeaderPlugin;
use TomatoPHP\FilamentLogger\Facades\FilamentLogger;
use App\Filament\Resources\ProjectResource\RelationManagers;
use IbrahimBougaoua\FilamentRatingStar\Forms\Components\RatingStar;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        // FilamentLogger::log(message:'Your message here');
        return $form
            ->schema([
                TextInput::make('title')->required(),
                TextInput::make('description')->required(),
                FileUpload::make('image')->required()->columnSpanFull(),
                TextInput::make('url')->required()
                    ->url()
                    ->suffixIcon('heroicon-m-globe-alt'),
                TextInput::make('category')->required(),
                Section::make()
                    ->schema([
                        RatingStar::make('rating')
                        ->label('Rating')
                    ]),
                // SpatieTagsInput::make('technologies_id'),
                Checkbox::make('is_primary')->required(),
                Rating::make('rating'),
                // StickyHeaderPlugin::make()
                //     ->floating()
                //     ->colored(),
                Shout::make('so-important')
                    ->content('This is a test')
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('description'),
                Tables\Columns\TextColumn::make('url'),
                Tables\Columns\TextColumn::make('category'),
                Tables\Columns\IconColumn::make('is_primary'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
