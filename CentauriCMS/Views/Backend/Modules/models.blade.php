@extends("Centauri::Backend.Layouts.be_module")

@section("moduleid"){{"models"}}@endsection

@section("content")
    <div class="container">
        <div class="row">
            <div class="col-12">
                @section("headertitle") @lang("backend/modules.models.title") @endsection

                <div class="table-wrapper">
                    <table id="extensions" class="table table-dark table-hover z-depth-1-half">
                        <thead class="thead-dark">
                            <tr>
                                <th title="Label">
                                    Label
                                </th>

                                <th title="Namespace">
                                    ID (Namespace)
                                </th>

                                <th title="Loaded">
                                    Loaded
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($data["models"] as $namespace => $model)
                                <tr>
                                    <td>
                                        {{ $model["label"] }}
                                    </td>

                                    <td>
                                        {{ $namespace }}
                                    </td>

                                    <td>
                                        @if($model["loaded"])
                                            <i class="fas fa-check"></i>
                                        @else
                                            <i class="fas fa-times"></i>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="modelsmodule_buttons" class="col-12 text-right">
                <button class="btn btn-primary btn-floating waves-effect waves-light" data-button-type="create">
                    <i class="fas fa-plus"></i>
                </button>

                <button class="btn btn-info btn-floating waves-effect waves-light" data-button-type="refresh">
                    <i class="fas fa-sync-alt"></i>
                </button>
            </div>
        </div>
    </div>
@endsection
