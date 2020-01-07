<ul class="nav nav-tabs md-tabs" id="nCETabs" role="tablist">
    @foreach($CCE["tabs"] as $tabKey => $tabArr)
        <li class="nav-item waves-effect">
            <a class="nav-link{{ $loop->first ? ' active' : '' }}" id="{{ $tabKey }}-tab-md" data-toggle="tab" href="#{{ $tabKey }}-md" role="tab" aria-controls="{{ $tabKey }}-md" aria-selected="true">
                {{ __($tabArr['label']) }}
            </a>
        </li>
    @endforeach
</ul>

<div class="tab-content card pt-5" id="nCEContent">
    @foreach($CCE["tabs"] as $tabKey => $tabArr)
        <div class="tab-pane fade {{ $loop->first ? ' show active' : '' }}" id="{{ $tabKey }}-md" role="tabpanel" aria-labelledby="{{ $tabKey }}-tab-md">
            @foreach($tabArr["elements"] as $ctype)
                <div class="element z-depth-1 mb-3" data-ctype="{{ $ctype }}">
                    <div class="top waves-effect">
                        @lang("backend/modals.newContentElement.Elements.$ctype")
                    </div>

                    <div class="bottom" style="display: none;">
                        @foreach($CCE["elements"][$ctype] as $field)
                            @if(Str::contains($field, ";"))
                                @php $splittedFields = explode(";", $field) @endphp

                                <div class="row">
                                    @foreach($splittedFields as $splittedField)
                                        <div class="col">
                                            {!! $CCE["fields"][$splittedField]["_HTML"] !!}
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                {!! $CCE["fields"][$field]["_HTML"] !!}
                            @endif
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach
</div>
