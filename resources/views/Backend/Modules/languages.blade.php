<div class="container">
    <div class="row">
        <div class="col-12">
            <h3 id="title">
                Centauri - Languages
            </h3>

            <hr>

            <table id="languages" class="table table-dark table-hover z-depth-1-half">
                <thead class="thead-dark">
                    <tr>
                        <th>
                            UID
                        </th>

                        <th>
                            Flag
                        </th>

                        <th>
                            Title
                        </th>

                        <th>
                            Lang-Code
                        </th>

                        <th>
                            Slug
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
                    @foreach($data["languages"] as $language)
                        <tr>
                            <td data-type="uid">
                                # {{ $language->uid }}
                            </td>

                            <td data-type="flag">
                                <img src="{!! $language->flagsrc !!}" class="img-fluid flag" />
                            </td>

                            <td data-type="title">
                                {{ $language->title }}
                            </td>

                            <td data-type="lang_code">
                                {{ $language->lang_code }}
                            </td>

                            <td data-type="url">
                                @if($language->slug == "")
                                    /
                                @else
                                    {{ $language->slug }}
                                @endif
                            </td>

                            <td data-type="created_at">
                                {{ $language->created_at }}
                            </td>

                            <td data-type="updated_at">
                                {{ $language->updated_at }}
                            </td>

                            <td>
                                <div class="actions">
                                    <div class="action mr-3 p-2 waves-effect" data-action="language-edit" data-uid="{{ $language->uid }}">
                                        <i class="fas fa-pen fa-lg"></i>
                                    </div>

                                    <div class="action p-2 waves-effect" data-action="language-delete" data-uid="{{ $language->uid }}">
                                        <i class="fas fa-trash fa-lg"></i>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div id="languagemodule_buttons" class="col-12 text-right">
            <button class="btn btn-primary btn-floating waves-effect waves-light" data-button-type="create">
                <i class="fas fa-plus"></i>
            </button>

            <button class="btn btn-info btn-floating waves-effect waves-light" data-button-type="refresh">
                <i class="fas fa-sync-alt"></i>
            </button>
        </div>
    </div>
</div>