@foreach($buttonActions as $buttonAction)
    <button type="button"
            wire:click="executeButtonAction('{{ $buttonAction->getName() }}')"
            class="w-full md:w-auto bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary-500">
        {{ $buttonAction->getLabel() }}
    </button>
@endforeach
