<?php

namespace RalphJSmit\Tall\Interactive\Livewire\Concerns;

use Filament\Forms\ComponentContainer;
use Filament\Forms\Concerns\InteractsWithForms;
use Illuminate\Support\Collection;
use RalphJSmit\Tall\Interactive\Actions\ButtonAction;

trait HasForm
{
    use CanCallForm;
    use Closeable;
    use HasModel;
    use HasValidation;
    use InteractsWithForms;
    use RegisterListeners;

    public array $data = [];
    public bool $hasConstructedForm = false;
    public array $params = [];
    public bool $shouldFillForm = true;

    public function bootedHasForm(): void
    {
        if ($this->shouldFillForm && $this->formClass) {
            $this->mountForm();
        }

        if ($this->formClass) {
            $this->registerFormMessages();
        }
    }

    public function executeButtonAction(string $buttonActionName): void
    {
        collect($this->call('getButtonActions'))
            ->each(function (ButtonAction $buttonAction) use ($buttonActionName): void {
                if ($buttonAction->getName() !== $buttonActionName) {
                    return;
                }

                $this->call($buttonAction->getAction());
            });
    }

    public function getButtonActions(): array
    {
        return $this->call('getButtonActions') ?: [];
    }

    public function mountHasForm(string $maxWidth = null): void
    {
        $this->maxWidth = $maxWidth ?? '2xl';
    }

    public function submit(): void
    {
        $this->call('submit', [
            'state' => collect($this->form->getState()),
        ]);

        $this->handleFormSubmitted();
    }

    protected function getForms(): array
    {
        return collect()
            ->when($this->formClass, function (Collection $forms): Collection {
                return $forms->put(
                    'form',
                    $this->makeForm()
                        ->schema($this->call('getFormSchema') ?: [])
                        ->tap(function (ComponentContainer $componentContainer): ComponentContainer {
                            if ($this->model) {
                                $componentContainer->model($this->model);
                            }

                            return $componentContainer;
                        })
                        ->statePath('data')
                );
            })
            ->all();
    }

    protected function handleFormSubmitted(): void
    {
        $this->handleCloseOnSubmit();

        if (! $this->model) {
            $this->mountForm();
        }
    }

    protected function mountForm(): void
    {
        $this->call('mount');

        $this->form->fill(
            $this->call('fill')
        );

        $this->shouldFillForm = false;
    }
}
