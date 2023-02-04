@extends('layout')
 
@section('title', 'Drivers')
 
@section('content')
<div class="container">
	<div class="row">
		<div class="col">
			<div class="card">
				<div class="card-body">
					<h1>Drivers</h1>
					<div class="mt-3 mb-3">
						Click "View Details" to show cars available to the driver
					</div>
					<table class="table">
						<thead>
							<tr>
								<th>Driver ID</th>
								<th>Name</th>
								<th>Grades</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($drivers as $driver)
								<tr>
									<td>{{ $driver->id }}</td>
									<td>{{ $driver->name }}</td>
									<td>
										@foreach ($driver->grades()->get() as $grade)
										<span class="badge rounded-pill bg-primary">{{ $grade->name }}</span>
										@endforeach
									</td>
									<td>
										<a href="{{ url('driver/'.$driver->id) }}" class="btn btn-sm btn-primary">View Details</a>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
					{!! $drivers->links() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection