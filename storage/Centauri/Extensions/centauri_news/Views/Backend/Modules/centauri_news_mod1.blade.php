<h4>
    News:
</h4>

<ul>
    @foreach($data->models as $model)
        <li>
            <strong>
                {{ $model->title }}
            </strong>
        </li>
    @endforeach
</ul>

{{-- {{ dd($data) }} --}}
