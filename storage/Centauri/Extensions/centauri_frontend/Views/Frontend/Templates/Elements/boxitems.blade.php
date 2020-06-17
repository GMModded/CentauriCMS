<div data-contentelement="boxitems" class="z-depth-1-half p-4">
    <div class="row justify-content-center">
        @foreach($element->boxitems as $boxitem)
            <div class="col-12 col-lg-{{ $boxitem->col_desktop }} text-center mb-lg-4">
                <div class="boxitem z-depth-1-half h-100" style="background: linear-gradient(40deg, {{ $boxitem->bgcolor_start }}, {{ $boxitem->bgcolor_end }});">
                    <h5>
                        {{ $boxitem->header }}
                    </h5>

                    <hr style="border-color: white;">

                    <div class="rte-view">
                        {!! $boxitem->description !!}
                    </div>

                    @if($boxitem->link)
                        <div class="btn-link-view mt-4">
                            <div class="row justify-content-end">
                                <div class="col-12 {{ ($boxitem->col_desktop == '' ? 'col-lg-2' : 'borders') }}">
                                    <a 
                                        href="{{ $boxitem->link }}"
                                        role="button"
                                        class="btn w-100 m-0 waves-effect waves-light"
                                        target="_blank"
                                        style="background-color: #ff3aaf;"
                                    >
                                        {{ $boxitem->link_label }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
</div>
