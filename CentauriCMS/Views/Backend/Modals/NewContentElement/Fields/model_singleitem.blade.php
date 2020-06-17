<div class="accordion ci-bs-1 mb-2" data-uid="{{ $model->uid }}" data-sorting="{{ $model->sorting }}">
    <div class="top position-relative">
        ###MODEL_CONTENT_TOP###

        <div class="buttons-center">
            @if(!$model->hidden)
                <button class="btn btn-primary fa-lg waves-effect waves-light mx-0 mr-2 btn-floating" data-trigger="hideIRByUid">
                    <i class="fas fa-eye" aria-hidden="true"></i>
                </button>
            @else
                <button class="btn btn-info fa-lg waves-effect waves-light mx-0 mr-2 btn-floating" data-trigger="hideIRByUid">
                    <i class="fas fa-eye-slash" aria-hidden="true"></i>
                </button>
            @endif

            <button class="btn btn-danger fa-lg waves-effect waves-light mx-0 mr-2 btn-floating" data-trigger="deleteIRByUid">
                <i class="fas fa-trash" aria-hidden="true"></i>
            </button>
        </div>
    </div>

    <div class="bottom" style="display: none;">
        ###MODEL_CONTENT_BOTTOM###
    </div>
</div>
