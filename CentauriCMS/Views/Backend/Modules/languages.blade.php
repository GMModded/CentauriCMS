@extends("Centauri::Backend.Layouts.be_module")

@section("moduleid"){{"languages"}}@endsection

@section("content")
    <div class="container">
        <div class="row">
            <div class="col-12">
                @section("headertitle") @lang("backend/modules.languages.title") @endsection

                <div class="table-wrapper">
                    <table id="languages" class="table table-dark table-hover ci-bs-2">
                        <thead class="thead-dark">
                            <tr>
                                <th>
                                    UID
                                </th>

                                <th>
                                    @lang("backend/centauri.tables.title")
                                </th>

                                <th>
                                    Language Code
                                </th>

                                <th>
                                    Slug
                                </th>

                                <th>
                                    @lang("backend/centauri.tables.actions")
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($data["languages"] as $language)
                                <tr>
                                    <td data-type="uid">
                                        # {{ $language->uid }}
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

                                    <td>
                                        <div class="actions">
                                            <div class="action btn btn-primary p-2 waves-effect waves-light" data-action="language-edit" data-uid="{{ $language->uid }}">
                                                <i class="fas fa-pen fa-lg"></i>
                                            </div>

                                            <div class="action btn btn-danger p-2 waves-effect waves-light" data-action="language-delete" data-uid="{{ $language->uid }}">
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

            <div id="languagemodule_buttons" class="col-12 text-right">
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
