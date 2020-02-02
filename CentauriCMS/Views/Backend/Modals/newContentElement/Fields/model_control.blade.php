<div class="accordions inline-records mt-2" data-type="{{ $modelType }}">
    <label>
        {{ $modelLabel }}
    </label>

    <a href="#" role="button" class="btn btn-default waves-effect waves-light create-new-inline" data-name="{{ $modelFieldKeyName }}">
        <i class="fas fa-plus mr-1"></i>
        
        @if(isset($modelCreateNewButtonName))
            {{ $modelCreateNewButtonName }}
        @else
            Create new {{ $fieldConfiguration["newItemLabel"] }}
        @endif
    </a>

    ###MODEL_CONTENT###
</div>
