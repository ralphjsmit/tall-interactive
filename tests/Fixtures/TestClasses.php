<?php

use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Testing\Assert;
use RalphJSmit\Tall\Interactive\Forms\Form;

class TestForm extends Form
{
    public static int $submittedTimes = 0;

    public static function getFormSchema(): array
    {
        return [
            TextInput::make('email')->label('Enter your e-mail')->required(),
        ];
    }

    public static function getFormDefaults(): array
    {
        return [
            'email' => '',
            'year' => 2000,
        ];
    }

    public static function submitForm(Collection $formData, object|null $model): void
    {
        static::$submittedTimes++;
        Assert::assertNull($model);
        Assert::assertTrue($formData->isNotEmpty());
        Assert::assertIsArray($formData->all());
    }
}

class AdditionalFormParametersTestForm extends Form
{
    public static array $params = [];
    public static int $initializedTimes = 0;

    public static function getFormSchema(array $params): array
    {
        static::$initializedTimes++;
        static::$params = $params;

        return [];
    }

    public static function getFormDefaults(): array
    {
        return [];
    }
}

class InitializationTestForm extends Form
{
    public static int $expectedFirstParam;
    public static string $expectedSecondParam;
    public static object $expectedThirdParam;
    public static int $initializedTimes = 0;

    public static function getFormSchema(): array
    {
        return [];
    }

    public static function initialize(int $formParam0, $formParam1, object $formParam2): void
    {
        Assert::assertSame(static::$expectedFirstParam, $formParam0);
        Assert::assertSame(static::$expectedSecondParam, $formParam1);
        Assert::assertSame(static::$expectedThirdParam, $formParam2);
        static::$initializedTimes++;
    }

    public static function getFormDefaults(): array
    {
        return [];
    }
}

class User extends Model
{
    protected $guarded = [];
}

class UserForm extends Form
{
    public static $expectedUser;

    public static \Closure $assertionCallable;

    public static function getFormSchema(string $modelPathIfGiven): array
    {
        return [
            TextInput::make("{$modelPathIfGiven}email"),
        ];
    }

    public static function getFormDefaults(): array
    {
        return [];
    }

    public static function submitForm(Collection $formData, object|null $model): void
    {
        Assert::assertSame(get_object_vars(static::$expectedUser), get_object_vars($model));
    }
}
