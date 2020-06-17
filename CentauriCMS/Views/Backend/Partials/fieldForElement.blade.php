<div class="fields" style="display: none;">
    {!! $data["HTML"] !!}

    <div class="row">
        <div class="col text-right">
            <button class="btn btn-success fa-lg waves-effect waves-light btn-floating mx-0 mr-2" data-id="save" data-trigger="saveElementByUid">
                <i class="fas fa-save" aria-hidden="true"></i>
            </button>

            <button class="btn btn-{{ $element->hidden ? 'info' : 'primary' }} fa-lg waves-effect waves-light btn-floating mx-0 mr-2" data-id="hide" data-trigger="hideElementByUid">
                <i class="fas fa-{{ $element->hidden ? 'eye-slash' : 'eye' }}" aria-hidden="true"></i>
            </button>

            <button class="btn btn-danger fa-lg waves-effect waves-light btn-floating mx-0 mr-2" data-id="delete" data-trigger="deleteElementByUid">
                <i class="fas fa-trash" aria-hidden="true"></i>
            </button>
        </div>
    </div>
</div>
