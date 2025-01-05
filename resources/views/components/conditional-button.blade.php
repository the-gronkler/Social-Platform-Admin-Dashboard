<div class="button-tooltip-wrapper">
    @can($action, $model)
        <button type="{{$buttonType}}" class="{{ $buttonClass }}">
            {{ $slot }}
        </button>
    @else
        <button type="{{$buttonType}}" class="{{ $buttonClass }} disabled" disabled
                @if($tooltip)
                    title="{{ $tooltip }}"
            @endif
        >
            {{ $slot }}
        </button>
        @if($tooltip)
            <span class="tooltip">{{ $tooltip }}</span>
        @endif

    @endcan
</div>
