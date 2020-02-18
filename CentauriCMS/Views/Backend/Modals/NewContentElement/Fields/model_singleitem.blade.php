<div class="accordion z-depth-1 mb-2" data-uid="{{ $uid }}" data-sorting="{{ $sorting }}">
    <div class="top position-relative">
        ###MODEL_CONTENT_TOP###

        <div class="buttons-center">
            <button class="btn btn-success waves-effect waves-light mx-0 mr-2 btn-floating" data-trigger="saveInlineElementBySorting">
                <i class="fas fa-save" aria-hidden="true"></i>
            </button>

            <button class="btn btn-primary waves-effect waves-light mx-0 mr-2 btn-floating" data-trigger="hideInlineElementBySorting">
                <i class="fas fa-eye" aria-hidden="true"></i>
            </button>

            <button class="btn btn-danger waves-effect waves-light mx-0 mr-2 btn-floating" data-trigger="deleteInlineElementBySorting">
                <i class="fas fa-trash" aria-hidden="true"></i>
            </button>
        </div>

        <div class="buttons-right">
            <button class="btn btn-info waves-effect waves-light mx-0 mr-2 btn-floating" data-trigger="sortInlineElementBySorting">
                <i class="fas fa-sort" aria-hidden="true"></i>
            </button>
        </div>
    </div>

    <div class="bottom" style="display: none;">
        ###MODEL_CONTENT_BOTTOM###
    </div>
</div>
