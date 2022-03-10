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
    {{-- Modal --}}
    <div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" x-cloak
         x-data="{ state: $wire.entangle('actionableOpen') }" :class="state ? 'pointer-events-auto' : 'pointer-events-none'">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:p-0 sm:block">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"
                 x-show="state"
                 x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            ></div>

            <!-- This element is to trick the browser into centering the modal contents. -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white text-black dark:bg-gray-800 dark:text-white rounded-lg text-left shadow-xl transform transition-all sm:my-8 sm:align-middle {{ $maxWidth }} sm:w-[calc(100%-24px)]"
                 x-show="state"
                 x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
                 x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
            >
                @if($dismissable)
                    <div class="hidden sm:block absolute top-0 right-0 pt-4 pr-4">
                        <button type="button" wire:click="$emit('modal:close', '{{ $actionableId }}')" class="bg-none hover:bg-gray-100 p-1 rounded-md text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            <span class="sr-only">{{ $dismissableWith }}</span>

                            <!-- Heroicon name: outline/x -->
                            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>

                        </button>
                    </div>
                @endif
                <div class="px-4 pt-5 pb-4 sm:p-6 sm:pb-4 rounded-t-[inherit]">
                    <div class="">
                        @if($title)
                            <h3 class="text-lg leading-6 font-bold text-gray-900 dark:text-white" id="modal-title">
                                {{ $title }}
                            </h3>
                        @endif
                        @if($description)
                            <div class="">
                                <p class="text-sm text-gray-500">
                                    {{ $description }}
                                </p>
                            </div>
                        @endif
                    </div>
                    <div class="sm:flex sm:items-start">
                        <div class="mt-6 w-full">

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
                    <div class="bg-gray-50 dark:bg-gray-800 px-4 py-3 sm:px-6 flex-shrink-0 flex justify-end gap-2 flex-wrap rounded-b-[inherit]" id="tall-interactive-slide-over-controls">
                        @if($dismissable)
                            <button wire:click="$emit('modal:close', '{{ $actionableId }}')" type="submit" class="w-full md:w-auto bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                                {{ $dismissableWith }}
                            </button>
                        @endif

                        @include('tall-interactive::components.forms.button-actions', ['buttonActions' => $this->getButtonActions()])

                        <button type="submit" wire:click="{{ $formClass ? 'submit': (!$formClass && $slot ? 'submitSlot' : '') }}"
                                class="w-full md:w-auto inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
                            {{ $submitWith }}
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
