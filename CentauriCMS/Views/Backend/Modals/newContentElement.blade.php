<ul class="nav nav-tabs" id="new-ce-tabs" role="tablist">
    @foreach($CCE["tabs"] as $tabKey => $tabArr)
        <li class="nav-item waves-effect waves-light{{ $loop->first ? ' active' : '' }}" data-tab-id="{{ $tabKey }}">
            {{ __($tabArr['label']) }}
        </li>
    @endforeach
</ul>

<div class="tab-content card pt-5">
    @foreach($CCE["tabs"] as $tabKey => $tabArr)
        <div class="tab-pane fade {{ $loop->first ? ' show active' : '' }}" data-tab-id="{{ $tabKey }}">
            @foreach($tabArr["elements"] as $ctype)
                <div class="element ci-bs-1 mb-3" data-ctype="{{ $ctype }}">
                    <div class="top waves-effect">
                        @lang("backend/modals.newContentElement.Elements.$ctype")
                    </div>

                    <div class="bottom" style="display: none;">
                        @foreach($CCE["elements"][$ctype] as $field)
                            @if(Str::contains($field, ";"))
                                @php
                                    $splittedFields = explode(";", $field)
                                @endphp

                                <div class="row">
                                    @foreach($splittedFields as $splittedField)
                                        <div class="col">
                                            {!! $CCE["fields"][$splittedField]["_HTML"] !!}
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                @if(isset($CCE["fields"][$field]["type"]) && $CCE["fields"][$field]["type"] != "model")
                                    {!! $CCE["fields"][$field]["_HTML"] !!}
                                @else
                                    <p>
                                        Click the + (Plus) Button in order to configure this element.
                                    </p>
                                @endif
                            @endif
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach
</div>
