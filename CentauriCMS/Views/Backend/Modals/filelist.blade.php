<div id="file-selector" class="inactive">
	@if(!empty($list))
		<div class="col-12">
			<div class="search">
				<div class="md-form">
					<input id="file-selector-search" class="form-control" type="text" />

					<label for="file-selector-search">
						@lang("backend/centauri.search")
					</label>
				</div>
			</div>
		</div>
	@endif

    <div class="items z-depth-1{{ empty($list) ? " h-100" : "" }}">
		@if(empty($list))
			<div class="col-12 h-100">
				<p class="text-center h-100 m-0 d-flex justify-content-center align-items-center">
					Filelist is empty - please upload some files in order to use the File-Selector.
				</p>


			</div>
		@endif

		@foreach($list as $item)
			<div class="item" data-uid="{{ $item->uid }}">
				<div class="wrapper d-flex waves-effect z-depth-1">
					<div class="image-view col-4 px-0">
						<img class="img-fluid" src="{!! ImageBladeHelper::getPath($item->uid) !!}" alt="" />
					</div>

					<div class="text-view col-8">
						<h4 class="title">
							{{ $item->name }}
						</h4>
					</div>
				</div>
			</div>
		@endforeach
	</div>

	<div class="buttons">
		<div class="d-flex">
			@if(!empty($list))
				<div class="col px-2">
					<button class="btn btn-success waves-effect waves-light save">
						<i class="fas fa-check mr-1"></i>

						Select
					</button>
				</div>
			@endif

			<div class="col pl-2 pr-4">
				<button class="btn btn-danger waves-effect waves-light cancel">
					<i class="fas fa-times mr-1"></i>

					Cancel
				</button>
			</div>
		</div>
	</div>
</div>
