@extends("Centauri::Backend.Layouts.be_module")

@section("moduleid"){{"dashboard"}}@endsection

@section("content")
    <div class="container">
        <div class="row">
            <div class="col-12">
                @section("headertitle") @lang("backend/modules.dashboard.title") @endsection

				<div class="container-fluid">
					<div class="row">
						<div class="card shadow mb-4 w-100">
							<div class="card-header py-3">
								<h6 class="m-0 font-weight-bold text-primary">
									System
								</h6>
							</div>

							<div class="card-body">
								<div class="row">
									<div class="col-xl-3 col-md-6 mb-4">
										<a href="{{ url('./centauri/pages') }}" data-module="true" data-moduleid="pages">
											<div class="card border-left-success shadow h-100 py-2 waves-effect">
												<div class="card-body">
													<div class="row no-gutters align-items-center">
														<div class="col mr-2">
															<div class="text-xs font-weight-bold text-success text-uppercase mb-1">
																Root Pages
															</div>
		
															<div class="h5 mb-0 font-weight-bold text-gray-800">
																{!! $data["rootpages"] !!}
															</div>
														</div>
		
														<div class="col-auto">
															<i class="fas fa-globe fa-2x text-gray-300"></i>
														</div>
													</div>
												</div>
											</div>
										</a>
									</div>

									<div class="col-xl-3 col-md-6 mb-4">
										<a href="{{ url('./centauri/pages') }}" data-module="true" data-moduleid="pages">
											<div class="card border-left-primary shadow h-100 py-2 waves-effect">
												<div class="card-body">
													<div class="row no-gutters align-items-center">
														<div class="col mr-2">
															<div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
																Pages
															</div>

															<div class="h5 mb-0 font-weight-bold text-gray-800">
																{!! $data["pages"] !!}
															</div>
														</div>

														<div class="col-auto">
															<i class="fas fa-file fa-2x text-gray-300"></i>
														</div>
													</div>
												</div>
											</div>
										</a>
									</div>

									<div class="col-xl-3 col-md-6 mb-4">
										<a href="{{ url('./centauri/languages') }}" data-module="true" data-moduleid="languages">
											<div class="card border-left-warning shadow h-100 py-2 waves-effect">
												<div class="card-body">
													<div class="row no-gutters align-items-center">
														<div class="col mr-2">
															<div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
																Languages
															</div>

															<div class="h5 mb-0 font-weight-bold text-gray-800">
																{!! $data["languages"] !!}
															</div>
														</div>

														<div class="col-auto">
															<i class="fas fa-calendar fa-2x text-gray-300"></i>
														</div>
													</div>
												</div>
											</div>
										</a>
									</div>

									<div class="col-xl-3 col-md-6 mb-4">
										<a href="{{ url('./centauri/notifications') }}" data-module="true" data-moduleid="notifications">
											<div class="card border-left-danger shadow h-100 py-2 waves-effect">
												<div class="card-body">
													<div class="row no-gutters align-items-center">
														<div class="col mr-2">
															<div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
																Notifications
															</div>

															<div class="h5 mb-0 font-weight-bold text-gray-800">
																{!! $data["notifications"] !!}
															</div>
														</div>

														<div class="col-auto">
															<i class="fas fa-calendar fa-2x text-gray-300"></i>
														</div>
													</div>
												</div>
											</div>
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection



<style>
.text-gray-300 {
	color: #dddfeb!important;
}

.text-gray-800 {
	color: #5a5c69!important;
}

.text-xs {
	font-size: .7rem;
}

.border-left-success {
	border-left: .25rem solid #1cc88a!important;
	border-top: unset !important;
	border-right: unset !important;
	border-bottom: unset !important;
}

.border-left-primary {
	border-left: .25rem solid #4e73df!important;
	border-top: unset !important;
	border-right: unset !important;
	border-bottom: unset !important;
}

.border-left-warning {
	border-left: .25rem solid #f6c23e!important;
	border-top: unset !important;
	border-right: unset !important;
	border-bottom: unset !important;
}

.border-left-danger {
	border-left: .25rem solid #e74a3b!important;
	border-top: unset !important;
	border-right: unset !important;
	border-bottom: unset !important;
}
</style>
