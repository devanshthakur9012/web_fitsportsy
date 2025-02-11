@extends('frontend.master', ['activePage' => null])

@section('title', __('Active Tickets'))

@section('content')
<section class="active-tickets mt-5">
    <div class="container">
        <h2 class="text-center mb-4">My Tickets</h2>
        <div class="d-flex justify-content-center gap-2 mb-3">
            <a href="{{route('my-booking',['type'=>'Active'])}}" class="btn btn-{{$status == 'Active' ? 'primary' : 'outline-primary'}} w-50 py-2 mr-2">Active Ticket</a>
            <a href="{{route('my-booking',['type'=>'Completed'])}}" class="btn btn-{{$status == 'Completed' ? 'primary' : 'outline-primary'}} py-2 w-50 ml-2">Completed Ticket</a>
        </div>
        <div class="row">
            @foreach ($myBooing as $item)
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm">
                        <img src="{{env('BACKEND_BASE_URL')}}/{{$item['event_img']}}" alt="Event Image" class="card-img-top" style="height: 200px; object-fit: cover;">
                        <div class="card-body">
                            <h5 class="card-title">{{ $item['event_title'] }}</h5>
                            <p class="card-text">
                                <strong>Event Date:</strong> {{ $item['event_sdate'] }} <br>
                                <strong>Location:</strong> {{ $item['event_place_name'] }} <br>
                                <strong>Ticket Type:</strong> {{ $item['ticket_type'] }} <br>
                                <strong>Status:</strong> 
                                <span class="badge bg-{{ $item['ticket_status'] == 'Booked' ? 'success' : 'danger' }}">
                                    {{ $item['ticket_status'] }}
                                </span>
                                <br>
                                <strong>Total Tickets:</strong> {{ $item['total_ticket'] }} <br>
                                <strong>Booked In:</strong> {{ number_format($item['book_mintues'], 2) }} minutes
                            </p>
                            <!-- View E-ticket Button -->
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <a href="{{ route('ticket-information', ['id' => $item['ticket_id']]) }}" class="btn btn-primary btn-sm">
                                    View/Download E-ticket
                                </a>
                            </div>
                        </div>                        
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
