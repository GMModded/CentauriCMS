@extends("Centauri::Backend.Layouts.be_module")

@section("moduleid"){{"be_users"}}@endsection

@section("content")
    <div class="container">
        <div class="row">
            <div class="col-12">
                @section("headertitle") BE-Users @endsection

                <div class="table-wrapper">
                    <table id="be_users" class="table table-dark table-hover ci-bs-2">
                        <thead class="thead-dark">
                            <tr>
                                <th>
                                    Firstname
                                </th>

                                <th>
                                    Lastname
                                </th>

                                <th>
                                    BE-Name
                                </th>

                                <th>
                                    Group(s)
                                </th>

                                <th>
                                    State
                                </th>

                                <th>
                                    Last login
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($data["beusers"] as $beuser)
                                <tr data-uid="{{ $beuser->uid }}">
                                    <td>
                                        {{ $beuser->firstname }}
                                    </td>

                                    <td>
                                        {{ $beuser->lastname }}
                                    </td>

                                    <td>
                                        {{ $beuser->be_name }}
                                    </td>

                                    <td>
                                        {{ $beuser->getGroups() }}
                                    </td>

                                    <td>
                                        {{ $beuser->state }}
                                    </td>

                                    <td>
                                        {{ $beuser->last_login }}
                                    </td>

                                    <td>
                                        <div class="actions">
                                            <div class="d-block d-lg-none action btn btn-primary p-2 waves-effect waves-light" data-action="actions-trigger">
                                                <i class="fas fa-ellipsis-h"></i>
                                            </div>

                                            <div class="d-none d-lg-flex">
                                                <a role="button" class="btn btn-info waves-effect waves-light p-2 mt-0 float-left exec-btn">
                                                    EXEC
                                                </a>

                                                <div class="action btn btn-primary mt-0 p-2 waves-effect waves-light" data-action="edit">
                                                    <i class="fas fa-pen fa-lg"></i>
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

            <div id="schedulermodule_buttons" class="col-12 text-right">
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
