@foreach($buttonActions as $buttonAction)
    <button type="button"
            wire:click="executeButtonAction('{{ $buttonAction->getName() }}')"
            @class([
                'w-full md:w-auto py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2',
                'bg-white text-gray-700 focus:ring-primary-500' => $buttonAction->getColor() === 'secondary',
                'bg-red-600 hover:bg-red-700 text-white focus:ring-red-500' => $buttonAction->getColor() === 'danger',
            ])
            class="w-full md:w-auto py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
        {{ $buttonAction->getLabel() }}
    </button>
@endforeach
