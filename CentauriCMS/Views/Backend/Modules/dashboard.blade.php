@extends("Centauri::Backend.Layouts.be_module")

@section("moduleid"){{"dashboard"}}@endsection
@section("headertitle") @lang("backend/modules.dashboard.title") @endsection

@section("content")
    <div class="container mb-5">
		<div class="row">
			<div class="col-12 col-lg-8">
				<div class="card shadow mb-4 w-100">
					<div class="card-header py-3">
						<h6 class="m-0 font-weight-bold text-primary">
							System
						</h6>
					</div>

					<div class="card-body">
						<div class="row">
							<div class="col-md-6 mb-4">
								<a href="{{ url('/centauri/domains') }}" data-module="true" data-moduleid="domains">
									<div class="card w-100 border-left-success shadow h-100 py-2 waves-effect">
										<div class="card-body">
											<div class="row no-gutters align-items-center">
												<div class="col mr-2">
													<div class="text-xs font-weight-bold text-success text-uppercase mb-1">
														Domains
													</div>

													<div class="h5 mb-0 font-weight-bold text-gray-800">
														{!! $data["domains"] !!}
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

							<div class="col-md-6 mb-4">
								<a href="{{ url('/centauri/pages') }}" data-module="true" data-moduleid="pages">
									<div class="card w-100 border-left-primary shadow h-100 py-2 waves-effect">
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

							<div class="col-md-6 mb-4">
								<a href="{{ url('/centauri/languages') }}" data-module="true" data-moduleid="languages">
									<div class="card w-100 border-left-warning shadow h-100 py-2 waves-effect">
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
													<i class="fas fa-language fa-2x text-gray-300"></i>
												</div>
											</div>
										</div>
									</div>
								</a>
							</div>

							<div class="col-md-6 mb-4">
								<a href="{{ url('/centauri/notifications') }}" data-module="true" data-moduleid="notifications">
									<div class="card w-100 border-left-danger shadow h-100 py-2 waves-effect">
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
													<i class="fas fa-bell fa-2x text-gray-300"></i>
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

			<div class="col-12 col-lg-4">
				<div class="card shadow mb-4 w-100">
					<div class="card-header py-3">
						<h6 class="m-0 font-weight-bold text-info">
							Errors
						</h6>
					</div>

					<div class="card-body">
						<div class="row">
							<div class="col-12">
								<a href="{{ url('/centauri/system') }}" data-module="true" data-moduleid="system">
									<div class="card w-100 border-left-info shadow h-100 waves-effect">
										<div class="card-body py-2">
											<p class="mb-0 font-weight-bold text-gray-800">
												@if(isset($_errors))
													<u>Attention!</u><br/>

													Your system has n errors!
												@else
													Your system is running without any issues or errors, well done!
												@endif
											</p>
										</div>
									</div>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-12">
				<div class="card shadow mb-4 w-100">
					<div class="card-header py-3">
						<h6 class="m-0 font-weight-bold text-primary">
							Stats & Tracking
						</h6>
					</div>

					<div class="card-body">
						<div class="row">
							<div class="col-12 col-md-6 mb-4">
								<div class="card w-100 border-left-primary shadow h-100 py-2">
									<div class="card-body">
										<div class="font-weight-bold text-xs text-info text-uppercase mb-1 px-3">
											CI-Stats
										</div>

										<div class="row no-gutters align-items-center h-100">
											<div class="col-12">
												<p class="text-center mb-5">
													Stats loading...
												</p>
											</div>

											<canvas id="lineChart_frontendcalls" class="d-none"></canvas>
										</div>
									</div>
								</div>
							</div>

							<div class="col-12 col-md-6 mb-4">
								<div class="card w-100 border-left-info shadow h-100 py-2">
									<div class="card-body">
										<div class="font-weight-bold text-xs text-info text-uppercase mb-1 px-3">
											CI-Tracker
										</div>

										<div class="row no-gutters align-items-center h-100">
											<div class="col-12">
												<p class="text-center mb-5">
													You haven't connected Centauri's Tracking with your Google Analytics yet
												</p>
											</div>
										</div>
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
