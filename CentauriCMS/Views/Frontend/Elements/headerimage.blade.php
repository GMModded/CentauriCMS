@foreach($element["image"] as $image)
    <img src="{!! ImageBladeHelper::getPath($image) !!}" class="img-fluid" />
@endforeach
