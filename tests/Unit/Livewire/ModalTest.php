<?php

use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\MultiSelect;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Livewire\Component;
use Livewire\Livewire;
use RalphJSmit\Tall\Interactive\Forms\Form;
use RalphJSmit\Tall\Interactive\Livewire\Modal;

it('can open the modal', function () {
    $component = Livewire::test(Modal::class, ['id' => 'test-modal']);

    $component
        ->emit('actionable:open', 'test-modal')
        ->assertSet('actionableOpen', true);

    $component
        ->emit('actionable:close', 'test-modal')
        ->assertSet('actionableOpen', false);
});

it('will not open the modal for another identifier', function () {
    $component = Livewire::test(Modal::class, ['id' => 'test-modal']);

    $component
        ->emit('actionable:open', 'another-modal')
        ->assertSet('actionableOpen', false);

    $component
        ->emit('actionable:close', 'another-modal')
        ->assertSet('actionableOpen', false);
});

it('can contain the form', function () {
    $component = Livewire::test(Modal::class, [
        'id' => 'test-modal',
        'form' => '',

    ]);
});

it('will store the maxWidth', function () {
    $component = Livewire::test(Modal::class, [
        'id' => 'test-modal',
        'maxWidth' => '7xl',
    ]);

    $component
        ->emit('actionable:open', 'test-modal')
        ->assertSet('maxWidth', '7xl');
});

it('can receive and display a form component', function () {
    $component = Livewire::test(Modal::class, [
        'id' => 'test-modal',
        'form' => UserForm::class,
    ]);

    $component
        ->assertSet('formClass', UserForm::class);

    $component
        ->assertSee('email')
        ->assertSee('Enter your e-mail');
});

class UserForm extends Form
{
    public static function getFormSchema(Component $livewire = null): array
    {
        return [
            TextInput::make('email')->label('Enter your e-mail'),
            Grid::make([
                TextInput::make('name')->default(0),
                Select::make('select')->options(['a' => 'A', 'b' => 'B']),
            ]),
            Repeater::make('repeater')->schema([
                TextInput::make('surname'),
                MultiSelect::make('multiSelect')->options(['a' => 'A', 'b' => 'B']),
            ]),
            Fieldset::make('fieldset')->schema([
                TextInput::make('fieldsetField')->default(0),
            ]),
            Tabs::make('Tab Heading')->tabs([
                Tabs\Tab::make('My tab')->schema([
                    TextInput::make('Textinput in first tab'),
                ]),
                Tabs\Tab::make('My second tab')->schema([
                    FileUpload::make('test')->label('File-upload in second tab'),
                ]),
            ]),
            Section::make('section')->description('My section')->schema([
                MarkdownEditor::make('markdownEditor')->label('Markdown editor'),
            ]),
            Card::make()->schema([
                Builder::make('builder')->blocks([
                    Builder\Block::make('headingBlock')->schema([
                        TextInput::make('content')
                            ->label('Heading')
                            ->required(),
                        Select::make('level')
                            ->options([
                                'h1' => 'Heading 1',
                                'h2' => 'Heading 2',
                                'h3' => 'Heading 3',
                                'h4' => 'Heading 4',
                                'h5' => 'Heading 5',
                                'h6' => 'Heading 6',
                            ])
                            ->required(),
                    ]),
                ]),
            ]),
        ];
    }
}
