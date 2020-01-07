<table class="table table-hover">
    <thead>
        <th>
            Selected
        </th>

        <th>
            Image
        </th>

        <th>
            Name
        </th>

        <th>
            Type
        </th>
    </thead>

    <tbody>
        @foreach($images as $image)
            <tr>
                <td>
                    <div class="form-check">
                        @if(in_array($image->uid, $uidArr))
                            <input type="checkbox" class="form-check-input" id="image_{{ $image->uid }}" checked>
                        @else
                            <input type="checkbox" class="form-check-input" id="image_{{ $image->uid }}">
                        @endif

                        <label class="form-check-label" for="image_{{ $image->uid }}"></label>
                    </div>
                </td>

                <td class="text-center">
                    <img src="{!! ImageBladeHelper::getPath($image->uid) !!}" class="img-fluid" style="max-width: 175px;" />
                </td>

                <td>
                    {{ $image->name }}
                </td>

                <td>
                    {{ $image->type }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
