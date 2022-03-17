@php
    $maxWidth = [
        'sm' => 'sm:max-w-sm',
        'md' => 'sm:max-w-md',
        'lg' => 'sm:max-w-lg',
        'xl' => 'sm:max-w-xl',
        '2xl' => 'sm:max-w-2xl',
        '3xl' => 'sm:max-w-3xl',
        '4xl' => 'sm:max-w-4xl',
        '5xl' => 'sm:max-w-5xl',
        '6xl' => 'sm:max-w-6xl',
        '7xl' => 'sm:max-w-7xl',
    ][$maxWidth];
@endphp

{{-- Inline form --}}

<x-tall-interactive::forms.form-container :controlsDesign="$controlsDesign" :maxWidth="$maxWidth" :applyContainer="$container">
    <div class="space-y-8">
        @if($title || $description)
            <div>
                @if($title)
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        {{ $title }}
                    </h3>
                @endif
                @if($description)
                    <p class="mt-1 text-sm text-gray-500">
                        {{ $description }}
                    </p>
                @endif
            </div>
        @endif

        <div class="">

            @if($formClass)
                <form wire:submit.prevent="submit">
                    <!-- Submission is handled by the buttons below. Nevertheless we still expose the method for submission on enter keystroke. -->
                    {{ $this->form }}

                    <button type="submit" class="invisible max-h-0 max-w-0 absolute">Submit</button>
                </form>
            @elseif($livewire)
                @livewire($livewire, $params)
            @elseif($slot)
                {!! $slot !!}
            @endif
        </div>
    </div>

    <x-slot name="controls">
        @if($showControls)
            <x-tall-interactive::forms.controls.base>
                <x-dynamic-component :component="'tall-interactive::forms.controls.' . $controlsDesign">
                    @include('tall-interactive::components.forms.button-actions', ['buttonActions' => $this->getButtonActions()])

                    <button wire:click="{{ $formClass ? 'submit': (!$formClass && $slot ? 'submitSlot' : '') }}" type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary-600 text-base font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2
                    focus:ring-primary-500 sm:ml-3
                    sm:w-auto
                    sm:text-sm">
                        {{ $submitWith }}
                    </button>

                </x-dynamic-component>
            </x-tall-interactive::forms.controls.base>
        @endif
    </x-slot>
</x-tall-interactive::forms.form-container>

