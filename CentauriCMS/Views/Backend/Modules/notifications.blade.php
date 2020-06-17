@extends("Centauri::Backend.Layouts.be_module")

@section("moduleid"){{"notifications"}}@endsection

@section("content")
    <div class="container">
        <div class="row">
            <div class="col-12">
                @section("headertitle") @lang("backend/modules.notifications.title") @endsection

                <div class="table-wrapper">
                    @if(count($data["notifications"]) > 0)
                        <div class="text-right mb-5">
                            <a 
                                role="button"
                                class="btn btn-danger waves-effect m-0 action"
                                data-ajax="true"
                                data-ajax-handler="Notification"
                                data-ajax-action="deleteAll"
                            >
                                Delete all

                                <i class="fas fa-trash-alt"></i>
                            </a>
                        </div>
                    @endif

                    <table id="notifications" class="table table-dark table-hover ci-bs-2">
                        <thead class="thead-dark">
                            <tr>
                                <th>
                                    Level
                                </th>

                                <th>
                                    @lang("backend/centauri.tables.title")
                                </th>

                                <th>
                                    Text
                                </th>

                                <th>
                                    @lang("backend/centauri.tables.created_at")
                                </th>

                                <th>
                                    @lang("backend/centauri.tables.actions")
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($data["notifications"] as $notification)
                                <tr>
                                    <td class="text-center">
                                        @switch($notification->severity)
                                            @case("WARN")
                                                <i class="fas fa-exclamation-circle"></i>
                                                @break
                                            @case("ERROR")
                                                <i class="fas fa-exclamation-triangle"></i>
                                                @break
                                            @default
                                        @endswitch
                                    </td>

                                    <td>
                                        {{ $notification->title }}
                                    </td>

                                    <td>
                                        {{ $notification->text }}
                                    </td>

                                    <td>
                                        {{ $notification->created_at }}
                                    </td>

                                    <td class="text-center">
                                        <div class="actions">
                                            <div class="d-block d-lg-none action btn btn-primary p-2 waves-effect waves-light" data-action="actions-trigger">
                                                <i class="fas fa-ellipsis-h"></i>
                                            </div>

                                            <div class="d-none d-lg-flex">
                                                <div class="action btn btn-danger mr-3 p-2 waves-effect waves-light" data-action="deleteByUid" data-uid="{{ $notification->uid }}">
                                                    <i class="fas fa-trash fa-lg"></i>
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

            <div id="notificationsmodule_buttons" class="col-12 text-right pb-5">
                <button class="btn btn-info btn-floating fa-lg waves-effect" data-button-type="refresh">
                    <i class="fas fa-sync-alt"></i>
                </button>
            </div>
        </div>
    </div>
@endsection
