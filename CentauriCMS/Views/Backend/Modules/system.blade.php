@extends("Centauri::Backend.Layouts.be_module")

@section("moduleid"){{"models"}}@endsection

@section("content")
    <div class="container">
        <div class="row">
            <div class="col-12">
                @section("headertitle") System @endsection

                <a href="#" role="button" class="btn btn-primary waves-effect waves-light" data-ajax="true" data-ajax-handler="Database" data-ajax-action="update">
                    Update Database
                </a>

                <a href="#" role="button" class="btn btn-primary waves-effect waves-light" data-ajax="true" data-ajax-handler="Database" data-ajax-action="syncFiles">
                    Sync Filelist
                </a>
            </div>

            <div id="systemmodule_buttons" class="col-12 text-right">
                <button class="btn btn-info btn-floating waves-effect waves-light" data-button-type="refresh">
                    <i class="fas fa-sync-alt"></i>
                </button>
            </div>
        </div>
    </div>
@endsection
