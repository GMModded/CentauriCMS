@php
    $color_start = $element->colorpicker;

    if(
        !Str::contains($color_start, " ") &&
        !Str::contains($color_start, ", ")
    ) {
        $color_start .= " 33%";
    }
@endphp

<div data-contentelement="titleteaser" data-uid="{{ $element->uid }}">
    <div data-gradient-colorstart="{{ $color_start }}" class="gradient-view" style="white-space: nowrap; width: 100% !important; position: relative;overflow: hidden;background: linear-gradient(40deg, {{ $color_start }}, transparent calc(33% + 3px)); padding: 20px 15px;width: 100%;transition: .66s ease-in-out;">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 class="mb-0" style="color: #fff;">
                        {{ $element->header }}
                    </h1>
                </div>
            </div>
        </div>
    </div>

    <style>
        @media (max-width: 991px) {
            [data-contentelement="titleteaser"][data-uid="{{ $element->uid }}"] .gradient-view {
                background: {{ $color_start }} !important;
            }
        }
    </style>
</div>
