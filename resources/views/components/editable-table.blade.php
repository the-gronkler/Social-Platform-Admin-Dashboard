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
