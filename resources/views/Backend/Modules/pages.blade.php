<div class="container">
    <div class="row">
        <div class="col-12">
            <h3 id="title">
                Centauri - Pages
            </h3>

            <hr>

            <table id="pages" class="table table-dark table-hover z-depth-1-half">
                <thead class="thead-dark">
                    <tr>
                        <th>
                            UID
                        </th>

                        <th>
                            Language ID
                        </th>

                        <th>
                            Title
                        </th>

                        <th>
                            URLs
                        </th>

                        <th>
                            Created at
                        </th>

                        <th>
                            Modified at
                        </th>

                        <th>
                            Actions
                        </th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($data["pages"] as $pagesArr)
                        @foreach($pagesArr as $pageArr)
                            @foreach($pageArr as $page)
                                <tr {{ !$page->is_rootpage ? "class=subpage" : "" }}>
                                    <td data-type="uid">
                                        # {{ $page->uid }}
                                    </td>

                                    <td data-type="lid" data-lid="{{ $page->lid }}">
                                        <img src="{!! $page->language["flagsrc"] !!}" class="img-fluid flag" />
                                    </td>

                                    <td data-type="title">
                                        {{ $page->title }}
                                    </td>

                                    <td data-type="url">
                                        {{ $page->slugs }}
                                    </td>

                                    <td data-type="created_at">
                                        {{ $page->created_at }}
                                    </td>

                                    <td data-type="updated_at">
                                        {{ $page->updated_at }}
                                    </td>

                                    <td>
                                        <div class="actions">
                                            <div class="action mr-3 p-2 waves-effect" data-action="page-edit" data-uid="{{ $page->uid }}">
                                                <i class="fas fa-pen fa-lg"></i>
                                            </div>

                                            <div class="action mr-3 p-2 waves-effect" data-action="page-contentelement-edit" data-uid="{{ $page->uid }}">
                                                <i class="fab fa-elementor fa-lg"></i>
                                            </div>

                                            <div class="action mr-3 p-2 waves-effect" data-action="page-show" data-uid="{{ $page->uid }}">
                                                <i class="fas fa-eye fa-lg"></i>
                                            </div>

                                            <div class="action mr-3 p-2 waves-effect" data-action="page-translations" data-uid="{{ $page->uid }}">
                                                <i class="fas fa-language fa-lg"></i>
                                            </div>

                                            <div class="action p-2 waves-effect" data-action="page-delete" data-uid="{{ $page->uid }}">
                                                <i class="fas fa-trash fa-lg"></i>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    @endforeach
                </tbody>
            </table>
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
