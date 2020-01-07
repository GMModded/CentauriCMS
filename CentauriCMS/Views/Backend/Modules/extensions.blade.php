@extends("Centauri::Backend.Layouts.be_module")

@section("moduleid"){{"extensions"}}@endsection

@section("content")
    <div class="container">
        <div class="row">
            <div class="col-12">
                @section("headertitle") @lang("backend/modules.extensions.title") @endsection

                <div class="table-wrapper">
                    <table id="extensions" class="table table-dark table-hover z-depth-1-half">
                        <thead class="thead-dark">
                            <tr>
                                <th>
                                    ID
                                </th>

                                <th>
                                    Models
                                </th>

                                <th>
                                    State
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($data["extensions"] as $id => $ext)
                                <tr>
                                    <td>
                                        {{ $id }}
                                    </td>

                                    <td>
                                        -
                                    </td>

                                    <td>
                                        {{ $ext["state"] }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="extensionsmodule_buttons" class="col-12 text-right">
                <button class="btn btn-info btn-floating waves-effect waves-light" data-button-type="refresh">
                    <i class="fas fa-sync-alt"></i>
                </button>
            </div>
        </div>
    </div>
@endsection
