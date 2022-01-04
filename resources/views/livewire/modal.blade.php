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

<div>
    {{-- Modal --}}
    <div class="fixed z-10 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true" x-cloak
         x-data="{ state: $wire.entangle('actionableOpen') }" :class="state ? 'pointer-events-auto' : 'pointer-events-none'">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"
                 x-show="state"
                 x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
                 x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            ></div>

            <!-- This element is to trick the browser into centering the modal contents. -->
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle {{ $maxWidth }} sm:w-full"
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
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="">
                        @if($title)
                            <h3 class="text-lg leading-6 font-bold text-gray-900" id="modal-title">
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
                                <form wire:submit.prevent="submitForm">
                                    <!-- Submission is handled by the buttons below. Nevertheless we still expose the method for submission on enter keystroke. -->
                                    {{ $this->form }}

                                    <button type="submit" class="invisible max-h-0 max-w-0 absolute">Submit</button>
                                </form>
                            @endif


                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button wire:click="submitForm" type="submit" class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-primary-600 text-base font-medium text-white hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500 sm:ml-3 sm:w-auto
                    sm:text-sm">
                        Submit
                    </button>
                    @if($dismissable)
                        <button wire:click="$emit('modal:close', '{{ $actionableId }}')" type="button"
                                class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            {{ $dismissableWith }}
                        </button>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
