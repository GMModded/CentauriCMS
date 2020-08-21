@extends("Centauri::Backend.Layouts.be_module")

@section("moduleid"){{"forms"}}@endsection

@section("content")
    <div class="container">
        <div class="row">
            <div class="col-12">
                @section("headertitle") Forms @endsection

                <div class="table-wrapper">
                    <table id="forms" class="table table-dark table-hover ci-bs-2">
                        <thead class="thead-dark">
                            <tr>
                                <th>
                                    Name
                                </th>

                                <th>
                                    Actions
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($data["forms"] as $form)
                                <tr data-uid="{{ $form->uid }}">
                                    <td class="w-75">
                                        {{ $form->name }}
                                    </td>

                                    <td>
                                        <div class="actions">
                                            <div 
                                                class="action btn btn-primary p-2 waves-effect waves-light"
                                                data-action="edit"
                                            >
                                                <i class="fas fa-pen fa-lg"></i>
                                            </div>

                                            <div 
                                                class="action btn btn-danger p-2 waves-effect waves-light"
                                                data-action="delete"
                                            >
                                                <i class="fas fa-trash fa-lg"></i>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="formsmodule_buttons" class="col-12 text-right">
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
