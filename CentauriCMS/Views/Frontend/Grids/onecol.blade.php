@php
    $class = "container";

    if($grid->grid_fullsize) {
        $class .= "-fluid";
    }

    if($grid->grid_space_top) {
        $class .= " $grid->grid_space_top";
    }

    if($grid->grid_space_bottom) {
        $class .= " $grid->grid_space_bottom";
    }

    if($grid->grid_space_left) {
        $class .= " $grid->grid_space_left";
    }

    if($grid->grid_space_right) {
        $class .= " $grid->grid_space_right";
    }
@endphp

<div class="{{ $class }}">
    <div class="row">
        <div class="col-12">
            {!! $renderedColsHTML[0] !!}
        </div>
    </div>
</div>
