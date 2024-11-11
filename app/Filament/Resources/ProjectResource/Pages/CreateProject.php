<?php

namespace App\Filament\Resources\ProjectResource\Pages;

use Filament\Actions;
use Guava\Tutorials\Tutorial;
use Guava\Tutorials\Steps\Step;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\ProjectResource;
use Guava\Tutorials\Contracts\HasTutorials;
use Guava\Tutorials\Concerns\InteractsWithTutorials;

class CreateProject extends CreateRecord implements HasTutorials
{
    protected static string $resource = ProjectResource::class;

    use InteractsWithTutorials;

    public function mount(): void
    {
        parent::mount();

        $this->mountTutorial();
    }

    public function tutorial(Tutorial $tutorial) : Tutorial
    {
        return $tutorial->steps([
            Step::make('name'),
            Step::make('description'),
        ]);
    }
}
