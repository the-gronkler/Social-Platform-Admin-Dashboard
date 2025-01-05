<div class="button-tooltip-wrapper">
    @can($action, $model)
        <a href="{{ $href }}" class="{{ $linkClass }}">
            {{ $slot }}
        </a>
        <span> allowd</span>

    @else
        <a href="#" class="{{ $linkClass }} disabled"
           @if($tooltip)
               title="{{ $tooltip }}"
           @endif
           onclick="event.preventDefault();"
        >{{ $slot }}</a>

        <span>not allowd</span>
        @if($tooltip)
            <span class="tooltip">{{ $tooltip }}</span>
        @endif
    @endcan
</div>
