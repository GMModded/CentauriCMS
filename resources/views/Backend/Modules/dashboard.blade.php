<div class="container">
	<div class="row">
		<div class="col-12">
			<div class="row mb-3">
				<div class="col align-items-center d-flex">
					<h3 id="title">
						Centauri » Dashboard
					</h3>
				</div>

				<div class="col col-md-4">
					<div class="md-form">
						<input id="filter" class="form-control" type="text" />

						<label for="filter">
							Search
						</label>
					</div>
				</div>
			</div>

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
									<div class="card border-left-success shadow h-100 py-2">
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
								</div>

								<div class="col-xl-3 col-md-6 mb-4">
									<div class="card border-left-primary shadow h-100 py-2">
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
								</div>

								<div class="col-xl-3 col-md-6 mb-4">
									<div class="card border-left-warning shadow h-100 py-2">
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
								</div>

								<div class="col-xl-3 col-md-6 mb-4">
									<div class="card border-left-danger shadow h-100 py-2">
										<div class="card-body">
											<div class="row no-gutters align-items-center">
												<div class="col mr-2">
													<div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
														Notifications
													</div>

													<div class="h5 mb-0 font-weight-bold text-gray-800">
														-
													</div>
												</div>

												<div class="col-auto">
													<i class="fas fa-calendar fa-2x text-gray-300"></i>
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

			<script>
				//doughnut
				// var ctxD = document.getElementById("doughnutChart").getContext("2d");

				// var myLineChart = new Chart(ctxD, {
				// 	type: "doughnut",

				// 	data: {
				// 		labels: ["Root Pages", "Pages", "Folders (News, Images etc.)"],

				// 		datasets: [{
				// 			data: [300, 50, 100],
				// 			backgroundColor: ["#F7464A", "#46BFBD", "#FDB45C"],
				// 			hoverBackgroundColor: ["#FF5A5E", "#5AD3D1", "#FFC870"]
				// 		}]
				// 	},

				// 	options: {
				// 		responsive: true
				// 	}
				// });
			</script>
		</div>
	</div>
</div>

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
