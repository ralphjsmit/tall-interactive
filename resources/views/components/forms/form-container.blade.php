<div class="{{ $applyContainer ? "sm:rounded-md {$attributes->get('maxWidth')}" : '' }}">

    <div class="px-6 py-4">
        {{ $slot }}
    </div>

    {{ $controls }}
</div>
