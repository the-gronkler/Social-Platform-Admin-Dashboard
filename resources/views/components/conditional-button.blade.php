<div class="button-tooltip-wrapper">
    @can($action, $model)
        <button type="{{$buttonType}}" class="{{ $cssClass }}">
            {{ $slot }}
        </button>

    @else
        <button type="{{$buttonType}}"
                class="{{ $cssClass }} disabled"
                disabled
                @if($tooltip)
                    title="{{ $tooltip }}"
                @endif
        >{{ $slot }}</button>

        @if($tooltip)
            <span class="tooltip">{{ $tooltip }}</span>
        @endif
    @endcan
</div>
