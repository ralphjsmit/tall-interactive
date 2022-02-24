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

<div class="relative z-[999]">
    {{-- Slide-over --}}
    <div class=" fixed inset-0 overflow-hidden" aria-labelledby="slide-over-title" role="dialog" aria-modal="true" x-cloak
         x-data="{ state: $wire.entangle('actionableOpen') }"
         :class="state ? 'pointer-events-auto' : 'pointer-events-none'">
        <div class="absolute inset-0 overflow-hidden">
            <!-- Background overlay, show/hide based on slide-over state. -->
            <div class="absolute inset-0" aria-hidden="true">
                <div class="fixed inset-y-0 pl-8 sm:pl-16 max-w-full right-0 flex">
                    <div class="w-screen {{ $maxWidth }}"
                         x-transition:enter="transform transition ease-in-out duration-300 sm:duration-500"
                         x-transition:enter-start="translate-x-full"
                         x-transition:enter-end="translate-x-0"
                         x-transition:leave="transform transition ease-in-out duration-300 sm:duration-500"
                         x-transition:leave-start="translate-x-0"
                         x-transition:leave-end="translate-x-full"
                         x-show="state"
                    >
                        <div class="h-full divide-y divide-gray-200 flex flex-col bg-white shadow-xl">
                            <div class="flex-1 h-0 overflow-y-auto">
                                @if($title || $description)
                                    <div class="py-6 px-4 bg-primary-700 sm:px-6">
                                        @if($title)
                                            <div class="flex items-center justify-between">
                                                <h2 class="text-xl font-bold text-white" id="slide-over-title">
                                                    {{ $title }}
                                                </h2>
                                                @if($dismissable)
                                                    <div class="ml-3 h-7 flex items-center">
                                                        <button type="button" wire:click="$emit('slideOver:close', '{{ $actionableId }}')" class="hover:bg-primary-800 rounded-md text-primary-200 hover:text-white focus:outline-none focus:ring-2 focus:ring-white">
                                                            <span class="sr-only">{{ $dismissableWith }}</span>
                                                            <!-- Heroicon name: outline/x -->
                                                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                            </svg>
                                                        </button>
                                                    </div>
                                                @endif
                                            </div>
                                        @endif
                                        @if($description)
                                            <div class="mt-1">
                                                <p class="text-sm text-primary-300">
                                                    {{ $description }}
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                @else
                                    @if($dismissable)
                                        <div class="absolute top-2 right-6 ml-3 h-7 flex items-center">
                                            <button type="button" wire:click="$emit('slideOver:close', '{{ $actionableId }}')" class="hover:bg-gray-100 rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-primary-500">
                                                <span class="sr-only">{{ $dismissableWith }}</span>
                                                <!-- Heroicon name: outline/x -->
                                                <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                    @endif
                                @endif
                                <div class="flex-1 flex flex-col justify-between">
                                    <div class="my-8 px-4 divide-y divide-gray-200 sm:px-6">

                                        @if($formClass)
                                            <form wire:submit.prevent="submit">
                                                <!-- Submission is handled by the buttons below. Nevertheless we still expose the method for submission on enter keystroke. -->
                                                {{ $this->form }}

                                                <button type="submit" class="invisible max-h-0 max-w-0 absolute">Submit</button>
                                            </form>
                                        @elseif($livewire)
                                            @livewire($livewire)
                                        @elseif($slot)
                                            {!! $slot !!}
                                        @endif

                                    </div>
                                </div>
                            </div>
                            @if($showControls)
                                <div class="flex-shrink-0 px-4 py-4 flex justify-end" id="tall-interactive-slide-over-controls">
                                    @if($dismissable)
                                        <button wire:click="$emit('modal:close', '{{ $actionableId }}')" type="submit" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                            {{ $dismissableWith }}
                                        </button>
                                    @endif

                                    @include('tall-interactive::components.forms.button-actions', ['buttonActions' => $this->getButtonActions()])

                                    <button type="submit" wire:click="{{ $formClass ? 'submit': (!$formClass && $slot ? 'submitSlot' : '') }}"
                                            class="ml-4 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                        {{ $submitWith }}
                                    </button>
                                </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
