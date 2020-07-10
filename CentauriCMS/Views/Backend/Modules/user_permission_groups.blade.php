@extends("Centauri::Backend.Layouts.be_module")

@section("moduleid"){{"user_permission_groups"}}@endsection

@section("content")
    <div class="container">
        <div class="row">
            <div class="col-12">
                @section("headertitle") @lang("backend/modules.user_permission_groups.title") @endsection

                
            </div>

            <div id="module_buttons" class="col-12 text-right">
                <button class="btn btn-info btn-floating fa-lg waves-effect" data-button-type="refresh">
                    <i class="fas fa-sync-alt"></i>
                </button>
            </div>
        </div>
    </div>
@endsection
