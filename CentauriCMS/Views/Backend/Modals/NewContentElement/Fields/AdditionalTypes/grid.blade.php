<ul class="nav nav-tabs" id="grid-tabs" role="tablist" style="width: calc(100% - 30px);">
    @if(!is_null($additionalData))
        <li class="nav-item waves-effect waves-light active" data-tab-id="grids-tab-ces">
            Content Elements
        </li>
    @endif

    <li class="nav-item waves-effect waves-light" data-tab-id="grids-tab-config">
        Configuration
    </li>
</ul>

<div class="tab-content card pt-5">
    @if(!is_null($additionalData))
        <div class="tab-pane fade show active" data-tab-id="grids-tab-ces">
            {!! $additionalData["elementsInGridHTML"] !!}
        </div>
    @endif

    <div class="tab-pane fade" data-tab-id="grids-tab-config">
        {!! $additionalData["gridConfigHTML"] !!}
    </div>
</div>
