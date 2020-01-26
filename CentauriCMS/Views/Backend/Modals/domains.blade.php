<div class="row">
    <div class="col-12 col-md-4">
        <select class="mdb-select md-form" id="rootpageuid" required>
            <option value="" selected disabled>
                Please select a rootpage
            </option>

            @foreach($rootpages as $rootpage)
                <option value="{{ $rootpage->uid }}">
                    {{ $rootpage->title }} ({{ $rootpage->language->title }})
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-12 col-md">
        <div class="md-form">
            <input type="text" class="form-control" id="id" required />

            <label for="id">
                ID
            </label>
        </div>
    </div>

    <div class="col-12 col-md">
        <div class="md-form">
            <input type="text" class="form-control" id="domain" required />

            <label for="domain">
                Domain
            </label>
        </div>
    </div>
</div>
