@extends('layout')
 
@section('title', $car->make.' '. $car->model)
 
@section('content')
<div class="container">
	<div class="row">
		<div class="col">
			<div class="card">
				<div class="card-body">
					<a href="{{ url()->previous() }}" class="btn btn-primary float-end">Go Back</a>
					<h1>{{ $car->make.' '. $car->model }}</h1>
					<table class="table">
						<thead>
							<tr>
								<th>Reservation Start Date</th>
								<th>Reservation Start Time</th>
								<th>Reservation End Date</th>
								<th>Reservation End Time</th>
							</tr>
						</thead>
						<tbody>
							@foreach ($reservations as $reservation)
								<tr>
									<td>{{ date("F d, Y", strtotime($reservation->start)) }}</td>
									<td>{{ date("H:i", strtotime($reservation->start)) }}</td>
									<td>{{ date("F d, Y", strtotime($reservation->end)) }}</td>
									<td>{{ date("H:i", strtotime($reservation->end)) }}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
					{!! $reservations->links() !!}
				</div>
			</div>
		</div>
	</div>
</div>
@endsection