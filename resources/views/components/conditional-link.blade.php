<div class="button-tooltip-wrapper">
    @can($action, $model)
        <a href="{{ $href }}" class="{{ $cssClass }}">
            {{ $slot }}
        </a>

    @else
        <a href="#" class="{{ $cssClass }} disabled"
           @if($tooltip)
               title="{{ $tooltip }}"
           @endif
           onclick="event.preventDefault();"
        >{{ $slot }}</a>

        @if($tooltip)
            <span class="tooltip">{{ $tooltip }}</span>
        @endif
    @endcan
</div>
