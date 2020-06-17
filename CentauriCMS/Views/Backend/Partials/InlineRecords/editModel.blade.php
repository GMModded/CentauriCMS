<div class="bottom" style="display: none;">
    {!! $renderedHtmlFields !!}

    <div class="row">
        <div class="col text-right">
            <button class="btn btn-success waves-effect btn-floating fa-lg mx-0 mr-2" data-trigger="saveModelByUid">
                <i class="fas fa-save" aria-hidden="true"></i>
            </button>

            <button class="btn btn-{{ $model->hidden ? 'info' : 'primary' }} waves-effect btn-floating fa-lg mx-0 mr-2" data-trigger="hideModelByUid">
                <i class="fas fa-{{ $model->hidden ? 'eye-slash' : 'eye' }}" aria-hidden="true"></i>
            </button>

            <button class="btn btn-danger waves-effect btn-floating fa-lg mx-0 mr-2" data-trigger="deleteModelByUid">
                <i class="fas fa-trash" aria-hidden="true"></i>
            </button>
        </div>
    </div>
</div>
