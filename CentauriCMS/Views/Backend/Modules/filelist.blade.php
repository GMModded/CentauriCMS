@extends("Centauri::Backend.Layouts.be_module")

@section("moduleid"){{"filelist"}}@endsection

@section("content")
    <div class="container">
        <div class="row">
            <div class="col-12">
                @section("headertitle") @lang("backend/modules.filelist.title") @endsection

                <div class="table-wrapper overflow-auto">
                    <table id="filelist" class="table table-dark table-hover ci-bs-2 mb-0">
                        <thead class="thead-dark">
                            <tr>
                                <th>
                                    Preview
                                </th>

                                <th>
                                    Name
                                </th>

                                <th>
                                    Type
                                </th>

                                <th>
                                    Path
                                </th>

                                <th>
                                    Actions
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($data["files"] as $file)
                                <tr>
                                    <td style="max-width: 200px;">
                                        @if($file["cropable"])
                                            <img src="{{ $file["path"] }}" class="img-fluid" />
                                        @endif
                                    </td>

                                    <td data-type="name">
                                        {{ $file["name"] }}
                                    </td>

                                    <td>
                                        {{ $file["type"] }}
                                    </td>

                                    <td title="UID # {{ $file->uid }}" data-type="path">
                                        {{ $file["path"] }}
                                    </td>

                                    <td>
                                        <div class="actions">
                                            <div class="d-block d-lg-none action btn btn-primary p-2 waves-effect waves-light" data-action="actions-trigger">
                                                <i class="fas fa-ellipsis-h"></i>
                                            </div>

                                            <div class="d-none d-lg-flex">
                                                <div class="action btn btn-default mr-3 p-2 waves-effect waves-light" data-action="file-edit" data-uid="">
                                                    <i class="fas fa-pen fa-lg"></i>
                                                </div>

                                                @if($file["cropable"])
                                                    <div class="action btn btn-default mr-3 p-2 waves-effect waves-light" data-action="file-crop" data-uid="">
                                                        <i class="fas fa-crop fa-lg"></i>
                                                    </div>
                                                @endif

                                                <div class="action btn btn-default btn btn-defaultmr-3 p-2 waves-effect waves-light" data-action="file-show" data-uid="">
                                                    <i class="fas fa-eye fa-lg"></i>
                                                </div>

                                                <div class="action btn btn-default btn btn-defaultp-2 waves-effect waves-light" data-action="file-delete" data-uid="">
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

            <div id="filelistmodule_buttons" class="col-12 text-right">
                <div class="file-field position-absolute" style="right: 80px;">
                    <button class="btn btn-primary btn-floating fa-lg waves-effect waves-light" data-button-type="upload">
                        <i class="fas fa-cloud-upload-alt"></i>

                        <input type="file" id="filelist_upload" onchange="Centauri.Events.Window.OnInputFileChange(this)" />
                    </button>
                </div>

                <button class="btn btn-info btn-floating fa-lg waves-effect waves-light" data-button-type="refresh">
                    <i class="fas fa-sync-alt"></i>
                </button>
            </div>
        </div>
    </div>
@endsection
