@extends("Centauri::Backend.Layouts.be_module")

@section("moduleid"){{"domains"}}@endsection

@section("content")
    <div class="container">
        <div class="row">
            <div class="col-12">
                @section("headertitle") Domains @endsection

                <div class="table-wrapper">
                    <table id="domains" class="table table-dark table-hover z-depth-1-half">
                        <thead class="thead-dark">
                            <tr>
                                <th>
                                    Rootpage
                                </th>

                                <th>
                                    ID
                                </th>

                                <th>
                                    Domain
                                </th>

                                <th>
                                    @lang("backend/centauri.tables.actions")
                                </th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($data["domainFiles"] as $domainFile)
                                <tr>
                                    <td data-type="rootpage">
                                        @if(isset($domainFile->content->rootpage))
                                            {{ $domainFile->content->rootpage->title }} ({{ $domainFile->content->rootpage->language->title }})
                                        @else
                                            Page #{{ $domainFile->content->rootpageuid }} not found
                                        @endif
                                    </td>

                                    <td data-type="id">
                                        {{ $domainFile->content->id }}
                                    </td>

                                    <td data-type="domain">
                                        {{ $domainFile->content->domain }}
                                    </td>

                                    <td>
                                        <div class="actions">
                                            <div class="action mr-3 p-2 waves-effect" data-action="domain-edit" data-id="{{ $domainFile->content->id }}" data-rootpageuid="{{ $domainFile->content->rootpageuid ?? '' }}">
                                                <i class="fas fa-pen fa-lg"></i>
                                            </div>

                                            <div class="action p-2 waves-effect" data-action="domain-delete" data-id="{{ $domainFile->content->id }}" data-rootpageuid="{{ $domainFile->content->rootpageuid ?? '' }}">
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

            <div id="domainsmodule_buttons" class="col-12 text-right">
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
