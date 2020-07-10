<ul class="nav nav-tabs" id="new-ce-tabs" role="tablist">
    @foreach($CME["tabs"] as $tabKey => $tabArr)
        <li class="nav-item waves-effect waves-light{{ $loop->first ? ' active' : '' }}" data-tab-id="{{ $tabKey }}">
            {{ __($tabArr["label"]) }}
        </li>
    @endforeach
</ul>

<div class="tab-content card pt-5">
    @foreach($CME["tabs"] as $tabKey => $tabArr)
        <div class="tab-pane fade{{ $loop->first ? ' show active' : '' }}" data-tab-id="{{ $tabKey }}">
            @foreach($tabArr["models"] as $model => $modelArr)
                @if ($tabKey == $modelArr["tab"])
                    <div class="element ci-bs-1 mb-3" data-model="{{ $model }}">
                        <div class="top waves-effect p-3">
                            @lang($modelArr["_NAMESPACE"] . "::backend/modals.models.$model")
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
