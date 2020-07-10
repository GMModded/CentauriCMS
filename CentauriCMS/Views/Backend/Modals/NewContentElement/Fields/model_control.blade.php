<div 
    class="accordions inline-records mt-2"
    data-type="{{ $modelType }}"
    data-type-parent="{{ $modelTypeParent }}"
>
    <label>
        {{ $modelLabel }}
    </label>

    @if(!isset($noModelContent))
        <a href="#" role="button" class="btn btn-default waves-effect waves-light create-new-inline px-4" data-name="{{ $modelType }}" data-parentuid="{{ $modelParentUid }}">
            <i class="fas fa-plus mr-1"></i>

            @if(isset($modelCreateNewButtonName) && !is_null($modelCreateNewButtonName))
                {{ $modelCreateNewButtonName }}
            @else
                Create
            @endif
        </a>

        ###MODEL_CONTENT###
    @else
        <p>
            <b>
                >
            </b> 

            Click on the create-button in order to create for this record new {{ $modelLabel }}-Items
        </p>
    @endif
</div>
