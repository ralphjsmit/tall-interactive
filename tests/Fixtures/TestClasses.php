<?php

use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Testing\Assert;
use RalphJSmit\Tall\Interactive\Forms\Form;

class TestForm extends Form
{
    public static int $submittedTimes = 0;

    public function getFormSchema(): array
    {
        return [
            TextInput::make('email')->label('Enter your e-mail')->required(),
            TextInput::make('year')->default(2000),
        ];
    }

    public function submit(Collection $state, object|null $model): void
    {
        static::$submittedTimes++;
        Assert::assertNull($model);
        Assert::assertTrue($state->isNotEmpty());
        Assert::assertIsArray($state->all());
    }
}

class AdditionalFormParametersTestForm extends Form
{
    public static array $params = [];
    public static int $initializedTimes = 0;

    public function getFormSchema(array $params): array
    {
        static::$initializedTimes++;
        static::$params = $params;

        return [];
    }
}

class AdditionalButtonsTestForm extends Form
{
    public static array $formButtons = [];

    public function getButtonActions(): array
    {
        return static::$formButtons;
    }

    public function getFormSchema(array $params): array
    {
        return [];
    }
}

class MountTestForm extends Form
{
    public static int $mountedTimes = 0;
    public static Model $expectedModel;

    public function fill(): array
    {
        return [
            'test' => 'FILLED_FORM_VALUE',
        ];
    }

    public function getFormSchema(): array
    {
        return [
            TextInput::make('test')->default('DEFAULT'),
        ];
    }

    public function mount(array $params, Model $model): void
    {
        Assert::assertSame('test', $params['x']);
        Assert::assertSame(64, $params['y']);
        Assert::assertSame(true, (bool) $params['z']);
        Assert::assertSame(true, (bool) $params['z']);
        Assert::assertSame(static::$expectedModel->attributesToArray(), $model->attributesToArray());
        Assert::assertSame(static::$expectedModel->attributesToArray(), $model->attributesToArray());
        static::$mountedTimes++;
    }
}

class InitializationTestForm extends Form
{
    public static int $expectedFirstParam;
    public static string $expectedSecondParam;
    public static object $expectedThirdParam;
    public static int $initializedTimes = 0;

    public function getFormSchema(): array
    {
        return [];
    }

    public function onOpen(array $eventParams): void
    {
        Assert::assertSame(static::$expectedFirstParam, $eventParams[0]);
        Assert::assertSame(static::$expectedSecondParam, $eventParams[1]);
        Assert::assertSame(static::$expectedThirdParam, $eventParams[2]);
        static::$initializedTimes++;
    }
}

class User extends Model
{
    protected $guarded = [];
}

class UserForm extends Form
{
    public static $expectedUser;

    public static Closure $assertionCallable;

    public function getFormSchema(string $modelPathIfGiven): array
    {
        return [
            TextInput::make("{$modelPathIfGiven}email"),
        ];
    }

    public function submit(Collection $state, object|null $model): void
    {
        Assert::assertSame(
            get_object_vars(static::$expectedUser),
            get_object_vars($model)
        );
    }
}

class DependencyInjectionTestForm extends Form
{
    public int $submittedTimes = 0;

    public function getFormSchema(): array
    {
        return [];
    }

    public function submit(self $formClass): void
    {
        $this->submittedTimes++;

        Assert::assertSame($this, $formClass);
    }
}
