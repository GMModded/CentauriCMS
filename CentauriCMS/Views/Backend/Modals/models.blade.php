<ul class="nav nav-tabs md-tabs" id="nCETabs" role="tablist">
    @foreach($CME["tabs"] as $tabKey => $tabArr)
        <li class="nav-item waves-effect">
            <a class="nav-link{{ $loop->first ? ' active' : '' }}" id="{{ $tabKey }}-tab-md" data-toggle="tab" href="#{{ $tabKey }}-md" role="tab" aria-controls="{{ $tabKey }}-md" aria-selected="true">
                {{ __($tabArr["label"]) }}
            </a>
        </li>
    @endforeach
</ul>

<div class="tab-content card pt-5" id="nCEContent">
    @foreach($CME["tabs"] as $tabKey => $tabArr)
        <div class="tab-pane fade {{ $loop->first ? ' show active' : '' }}" id="{{ $tabKey }}-md" role="tabpanel" aria-labelledby="{{ $tabKey }}-tab-md">
            @foreach($tabArr["models"] as $model => $modelArr)
                @if ($tabKey == $modelArr["tab"])
                    <div class="element z-depth-1 mb-3" data-model="{{ $model }}">
                        <div class="top waves-effect p-3">
                            @lang($modelArr['_NAMESPACE'] . "::backend/modals.models.$model")
                        </div>

                        <div class="bottom" style="display: none;">
                            <div class="px-3 pb-1">
                                {!! $modelArr["_HTML"] ?? "" !!}
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>
    @endforeach
</div>
