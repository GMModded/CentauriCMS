@extends("Centauri::Backend.Layouts.be_module")

@section("moduleid"){{"schedulers"}}@endsection

@section("content")
    <div class="container">
        <div class="row">
            <div class="col-12">
                @section("headertitle") Schedulers @endsection

                <div class="table-wrapper">
                    <table id="schedulers" class="table table-dark table-hover ci-bs-2">
                        <thead class="thead-dark">
                            <tr>
                                <th>
                                    Name
                                </th>

                                <th>
                                    ID (Namespace)
                                </th>

                                <th>
                                    Last runned
                                </th>

                                <th>
                                    Runs (every/at)
                                </th>

                                <th>
                                    State
                                </th>

                                <th>
                                    Actions
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($data["schedulers"] as $scheduler)
                                <tr data-uid="{{ $scheduler->uid }}">
                                    <td>
                                        {{ $scheduler->name }}
                                    </td>

                                    <td>
                                        {{ $scheduler->namespace }}
                                    </td>

                                    <td>
                                        {{ $scheduler->last_runned ?? "-" }}
                                    </td>

                                    <td>
                                        {{ $scheduler->time ?? "-" }}
                                    </td>

                                    <td>
                                        @php
                                            $class = "success";

                                            switch($scheduler->state) {
                                                case "FAILED":
                                                    $class = "danger";
                                                    break;

                                                case "UNKNOWN":
                                                    $class = "info";
                                                break;

                                                default:
                                                    break;
                                            }

                                            if($scheduler->state == "FAILED") {
                                                $class = "danger";
                                            }
                                        @endphp

                                        <a 
                                            role="button"
                                            class="btn btn-{{ $class }} p-2 m-0 float-left"
                                            disabled
                                        >
                                            {{ $scheduler->state }}
                                        </a>
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
