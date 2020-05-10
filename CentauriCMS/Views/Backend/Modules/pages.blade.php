@extends("Centauri::Backend.Layouts.be_module")

@section("moduleid"){{"pages"}}@endsection

@section("content")
    <div class="container">
        <div class="row">
            <div class="col-12">
                @section("headertitle") @lang("backend/modules.pages.title") @endsection

                <div class="table-wrapper">
                    <table id="pages" class="table table-dark table-hover z-depth-1-half">
                        <thead class="thead-dark">
                            <tr>
                                <th>
                                    UID
                                </th>

                                <th>
                                    Language
                                </th>

                                <th>
                                    @lang("backend/centauri.tables.title")
                                </th>

                                <th>
                                    URL
                                </th>

                                <th>
                                    Layout
                                </th>

                                <th>
                                    @lang("backend/centauri.tables.created_at")
                                </th>

                                <th>
                                    @lang("backend/centauri.tables.modified_at")
                                </th>

                                <th>
                                    @lang("backend/centauri.tables.actions")
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @if($data["pages"])
                                @foreach($data["pages"] as $pagesArr)
                                    @foreach($pagesArr as $pageArr)
                                        @foreach($pageArr as $page)
                                            <tr {{ (!$page->page_type == "rootpage" && !$page->page_type == "storage") ? "class=subpage" : "" }}>
                                                <td data-type="uid">
                                                    # {{ $page->uid }}
                                                </td>

                                                <td data-type="lid" data-lid="{{ $page->lid }}">
                                                    <img src="{!! $page->language->flagsrc !!}" class="img-fluid flag ml-md-4" />
                                                </td>

                                                <td data-type="title">
                                                    {{ $page->title }}
                                                </td>

                                                <td data-type="url">
                                                    {{ $page->slugs }}
                                                </td>

                                                <td data-type="be_layout">
                                                    {{ $page->backend_layout }}
                                                </td>

                                                <td data-type="created_at">
                                                    {{ $page->created_at }}
                                                </td>

                                                <td data-type="updated_at">
                                                    {{ $page->updated_at }}
                                                </td>

                                                <td>
                                                    <div class="actions">
                                                        <div class="d-block d-lg-none action p-2 waves-effect waves-light" data-action="actions-trigger">
                                                            <i class="fas fa-ellipsis-h"></i>
                                                        </div>

                                                        <div class="d-none d-lg-flex">
                                                            <div class="action mr-3 p-2 waves-effect waves-light" data-action="page-edit" data-uid="{{ $page->uid }}">
                                                                <i class="fas fa-pen fa-lg"></i>
                                                            </div>

                                                            <div class="action mr-3 p-2 waves-effect waves-light" data-action="page-contentelement-edit" data-uid="{{ $page->uid }}">
                                                                <i class="fab fa-elementor fa-lg"></i>
                                                            </div>

                                                            <div class="action mr-3 p-2 waves-effect waves-light" data-action="page-show" data-uid="{{ $page->uid }}">
                                                                <i class="fas fa-eye fa-lg"></i>
                                                            </div>

                                                            <div class="action mr-3 p-2 waves-effect waves-light" data-action="page-translations" data-uid="{{ $page->uid }}">
                                                                <i class="fas fa-language fa-lg"></i>
                                                            </div>

                                                            <div class="action p-2 waves-effect waves-light" data-action="page-delete" data-uid="{{ $page->uid }}">
                                                                <i class="fas fa-trash fa-lg"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="pagemodule_buttons" class="col-12 text-right">
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
