@extends('layout')
 
@section('title', $driver->name)
 
@section('content')
<div class="container">
	<div class="row">
		<div class="col">
			<div class="card">
				<div class="card-body">
					<a href="{{ url()->previous() }}" class="btn btn-primary float-end">Go Back</a>
					<h1>{{ $driver->name }} <small class="text-muted">is assigned {{ $driver->car->make . ' ' . $driver->car->model }}</small></h1>
					<div class="mt-3 mb-3">
						<span>The driver can reserve the following cars:</span>
						@foreach ($driver->grades as $grade)
							<span class="badge rounded-pill bg-primary">{{ $grade->name }}</span>
						@endforeach
					</div>
					<table class="table">
						<thead>
							<tr>
								<th>Make</th>
								<th>Model</th>
								<th>Grade</th>
								<th>Actions</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($cars as $car)
								<tr>
									<td>{{ $car->make }}</td>
									<td>{{ $car->model }}</td>
									<td>{{ $car->grade->name }}</td>
									<td>
										<a href="{{ url('car/'.$car->id) }}" class="btn btn-sm btn-primary">View Reservations</a>
									</td>
								</tr>
							@endforeach
						</tbody>
					</table>
					{!! $cars->links() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection