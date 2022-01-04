<?php

use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Model;
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

    public static function submitForm(array $formData, object|null $record): void
    {
        static::$submittedTimes++;
        Assert::assertNull($record);
    }
}

class InitializationTestForm extends Form
{
    public static int $expectedFirstParam;
    public static string $expectedSecondParam;
    public static object $expectedThirdParam;

    public static function getFormSchema(): array
    {
        return [];
    }

    public static function getFormDefaults(): array
    {
        return [];
    }

    public static function initialize()
    {
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

    public static function getFormSchema(): array
    {
        return [];
    }

    public static function getFormDefaults(): array
    {
        return [];
    }

    public static function submitForm(array $formData, object|null $record): void
    {
        Assert::assertInstanceOf(User::class, $record);
    }
}
