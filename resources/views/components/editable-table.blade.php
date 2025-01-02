<table>
    @foreach ($fields as $field)
        <tr>
            <th>{{ $field['label'] }}</th>
            <td>
                <input
                    type="{{ $field['type'] }}"
                    id="{{ $field['id'] }}"
                    name="{{ $field['name'] }}"
                    {!! $field['attributes'] !!}
                    value="{{ $field['value'] }}"
                >

                @error($field['name'])
                <span class="error-message">{{ $message }}</span>
                @enderror
            </td>
        </tr>

    @endforeach
</table>

@if ($errors->any())
    <div class="error-summary">
        <ul class="error-summary">
            @foreach ($errors->all() as $error)
                <li class="error-summary">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
