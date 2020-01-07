@extends("Centauri::Backend.Layouts.be_module")

@section("moduleid"){{"filelist"}}@endsection

@section("content")
    <div class="container">
        <div class="row">
            <div class="col-12">
                @section("headertitle") @lang("backend/modules.filelist.title") @endsection

                <div class="table-wrapper overflow-auto">
                    <table id="filelist" class="table table-dark table-hover z-depth-1-half mb-0">
                        <thead class="thead-dark">
                            <tr>
                                <th>
                                    UID
                                </th>

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
                                    Size
                                </th>

                                <th>
                                    Actions
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($data["files"] as $file)
                                <tr>
                                    <td data-type="uid">
                                        # {{ $file["uid"] }}
                                    </td>

                                    <td style="max-width: 200px;">
                                        @if($file["cropable"])
                                            <img src="{{ $file["URLpath"] }}" class="img-fluid" />
                                        @endif
                                    </td>

                                    <td data-type="name">
                                        {{ $file["name"] }}
                                    </td>

                                    <td>
                                        {{ $file["type"] }}
                                    </td>

                                    <td data-type="path">
                                        {{ $file["path"] }}
                                    </td>

                                    <td>
                                        {{ $file["size"] }}
                                    </td>

                                    <td>
                                        <div class="actions">
                                            <div class="d-block d-lg-none action p-2 waves-effect" data-action="actions-trigger">
                                                <i class="fas fa-ellipsis-h"></i>
                                            </div>

                                            <div class="d-none d-lg-flex">
                                                <div class="action mr-3 p-2 waves-effect" data-action="file-edit" data-uid="">
                                                    <i class="fas fa-pen fa-lg"></i>
                                                </div>

                                                @if($file["cropable"])
                                                    <div class="action mr-3 p-2 waves-effect" data-action="file-crop" data-uid="">
                                                        <i class="fas fa-crop fa-lg"></i>
                                                    </div>
                                                @endif

                                                <div class="action mr-3 p-2 waves-effect" data-action="file-show" data-uid="">
                                                    <i class="fas fa-eye fa-lg"></i>
                                                </div>

                                                <div class="action p-2 waves-effect" data-action="file-delete" data-uid="">
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
                    <button class="btn btn-primary btn-floating waves-effect waves-light" data-button-type="upload">
                        <i class="fas fa-cloud-upload-alt"></i>

                        <input type="file" id="filelist_upload" onchange="Centauri.Events.Window.OnInputFileChange(this)" />
                    </button>
                </div>

                <button class="btn btn-info btn-floating waves-effect waves-light" data-button-type="refresh">
                    <i class="fas fa-sync-alt"></i>
                </button>
            </div>
        </div>
    </div>
@endsection
