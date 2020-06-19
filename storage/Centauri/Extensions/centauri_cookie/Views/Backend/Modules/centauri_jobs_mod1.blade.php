<h4>
    Jobs:
</h4>

<ul>
    @foreach($data->models as $model)
        <li>
            <strong>
                {{ $model->name }}
            </strong>
        </li>
    @endforeach
</ul>
