<table>
    @foreach ($fields as $field)
        <tr>
            <th>{{ $field['label'] }}</th>
            <td>
                <input type="{{ $field['type'] }}" id="{{ $field['name'] }}" name="{{ $field['name'] }}"
                       value="{{ $field['value'] }}" @if($field['readonly']) readonly @endif
                       @foreach ($field['attributes'] ?? [] as $attribute => $value) {{ $attribute }}="{{ $value }}" @endforeach>

                @error($field['name'])
                <span class="error-message">{{ $message }}</span>
                @enderror
            </td>
        </tr>
    @endforeach
</table>
