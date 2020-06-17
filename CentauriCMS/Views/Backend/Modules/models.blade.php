@extends("Centauri::Backend.Layouts.be_module")

@section("moduleid"){{"models"}}@endsection

@section("content")
    <div class="container">
        <div class="row">
            <div class="col-12">
                @section("headertitle") @lang("backend/modules.models.title") @endsection

                <div class="table-wrapper">
                    <table id="models" class="table table-dark table-hover ci-bs-2">
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

                                <th title="Items">
                                    Items
                                </th>

                                <th title="Actions">
                                    Actions
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($data["models"] as $namespace => $model)
                                <tr>
                                    <td data-type="label">
                                        {{ $model["label"] }}
                                    </td>

                                    <td data-type="namespace">
                                        {{ $namespace }}
                                    </td>

                                    <td data-type="loaded" data-value="{{ $model["loaded"] }}">
                                        @if($model["loaded"])
                                            <i class="fas fa-check"></i>
                                        @else
                                            <i class="fas fa-times"></i>
                                        @endif
                                    </td>

                                    <td data-type="items">
                                        {{ count($data["models"][$namespace]) }}
                                    </td>

                                    <td>
                                        <div class="actions">
                                            <div class="d-block d-lg-none action btn btn-primary p-2 waves-effect waves-light" data-action="actions-trigger">
                                                <i class="fas fa-ellipsis-h"></i>
                                            </div>

                                            <div class="d-none d-lg-flex">
                                                <div class="action btn btn-primary p-2 waves-effect waves-light" data-action="models-list" data-uid="1">
                                                    <i class="fas fa-list fa-lg"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="modelsmodule_buttons" class="col-12 text-right">
                <button class="btn btn-primary btn-floating fa-lg waves-effect" data-button-type="create">
                    <i class="fas fa-plus"></i>
                </button>

                <button class="btn btn-info btn-floating fa-lg waves-effect" data-button-type="refresh">
                    <i class="fas fa-sync-alt"></i>
                </button>
            </div>
        </div>
    </div>
@endsection
