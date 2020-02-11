<div class="accordions inline-records mt-2" data-type-parent="{{ $modelTypeParent }}" data-type="{{ $modelType }}">
    <label>
        {{ $modelLabel }}
    </label>

    <a href="#" role="button" class="btn btn-default waves-effect waves-light create-new-inline" data-parentuid="{{ $parentuid }}" data-parentname="{{ $modelFieldKeyNameParent }}" data-name="{{ $modelFieldKeyName }}">
        <i class="fas fa-plus mr-1"></i>
        
        @if(isset($modelCreateNewButtonName))
            {{ $modelCreateNewButtonName }}
        @else
            {{ $fieldConfiguration["newItemLabel"] ? $fieldConfiguration["newItemLabel"] : "Create new record" }}
        @endif
    </a>

    ###MODEL_CONTENT###
</div>
