<div class="bottom" style="display: none;">
    {!! $renderedHtmlFields !!}

    <div class="row">
        <div class="col text-right">
            <button class="btn btn-success waves-effect waves-light btn-floating mx-0 mr-2" data-id="save" data-trigger="saveModelByUid">
                <i class="fas fa-save" aria-hidden="true"></i>
            </button>

            <button class="btn btn-{{ $model->hidden ? 'info' : 'primary' }} waves-effect waves-light btn-floating mx-0 mr-2" data-id="save" data-trigger="hideModelByUid">
                <i class="fas fa-{{ $model->hidden ? 'eye-slash' : 'eye' }}" aria-hidden="true"></i>
            </button>

            <button class="btn btn-danger waves-effect waves-light btn-floating mx-0 mr-2" data-id="save" data-trigger="deleteModelByUid">
                <i class="fas fa-trash" aria-hidden="true"></i>
            </button>
        </div>
    </div>
</div>
