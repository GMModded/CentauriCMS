@extends("Centauri::Backend.Layouts.be_module")

@section("moduleid"){{"extensions"}}@endsection

@section("content")
    <div class="container">
        <div class="row">
            <div class="col-12">
                @section("headertitle") @lang("backend/modules.extensions.title") @endsection

                <div class="table-wrapper">
                    <table id="extensions" class="table table-dark table-hover ci-bs-2">
                        <thead class="thead-dark">
                            <tr>
                                <th>
                                    ID
                                </th>

                                <th>
                                    Version
                                </th>

                                <th>
                                    State
                                </th>

                                <th>
                                    Author
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($data["extensions"] as $id => $ext)
                                <tr>
                                    <td>
                                        {{ $id }}
                                    </td>

                                    <td>
                                        {{ $ext["version"] ?? "-" }}
                                    </td>

                                    <td>
                                        {{ $ext["state"] }}
                                    </td>

                                    <td>
                                        @if(isset($ext["author_link"]))
                                            <a href="{{ $ext['author_link'] }}" target="_blank">
                                                {{ $ext["author"] ?? "-" }}
                                            </a>
                                        @else
                                            {{ $ext["author"] ?? "-" }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="extensionsmodule_buttons" class="col-12 text-right">
                <button class="btn btn-info btn-floating fa-lg waves-effect" data-button-type="refresh">
                    <i class="fas fa-sync-alt"></i>
                </button>
            </div>
        </div>
    </div>
@endsection
