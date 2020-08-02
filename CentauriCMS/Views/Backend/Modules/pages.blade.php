@extends("Centauri::Backend.Layouts.be_module")

@section("moduleid"){{"pages"}}@endsection
@section("no_search"){{"1"}}@endsection
@section("module_fullheight"){{"1"}}@endsection
@section("module_fullwidth"){{"1"}}@endsection

@section("content")
    <div class="container-fluid h-100 pb-5">
        <div class="row h-100 pb-5">
            <div class="col-12 h-100">
                @section("headertitle") @lang("backend/modules.pages.title") @endsection

                <div class="d-flex h-100 ci-bs-1">
                    <div id="pagetree" class="col-lg-3 ci-bs-2" style="max-width: 20%; padding: 15px;">
                        @if($data["pageTreeHTML"])
                            {!! $data["pageTreeHTML"] !!}
                        @endisset

                        <div id="pagemodule_buttons" class="col-12 text-center">
                            <button class="btn btn-primary btn-floating fa-lg waves-effect mx-2" data-button-type="create">
                                <i class="fas fa-plus"></i>
                            </button>

                            <button class="btn btn-info btn-floating fa-lg waves-effect mx-2" data-button-type="refresh">
                                <i class="fas fa-sync-alt"></i>
                            </button>
                        </div>
                    </div>

                    <div id="pagecontent" class="col-lg p-3 position-relative" style="overflow-x: hidden; overflow-y: auto;">
                        <h5 class="mb-0 h-100 align-items-center justify-content-center d-flex">
                            @if($data["pageTreeHTML"])
                                Select a page from the pagetree
                            @else
                                Create a new page using the plus-button down below
                            @endif
                        </h5>
                    </div>

                    @if(isset($data["__uid"]))
                        <script type="text/javascript" id="script-preselectitem">
                            var preselectitem = function() {
                                var uid = parseInt("{{ $data['__uid'] }}");
                                var $page = $("#pagetree div[data-uid='" + uid + "']");
                                $page.trigger("click");

                                $("script#script-preselectitem").remove();
                            };
                        </script>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
