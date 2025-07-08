@extends('frontend.master', ['activePage' => null])
@section('title', __('Active Tickets'))
@section('content')

<section class="my-tickets py-5">
    <div class="container">
        <div class="text-center mb-4">
            <h1 class="h3 font-weight-bold">{{ __('My Tickets') }}</h1>
            <p class="lead text-muted">Manage your event tickets and bookings</p>
        </div>

        <!-- Status Tabs -->
        <div class="d-flex gap-3 mb-4 justify-content-center">
            <a href="{{route('my-booking',['type'=>'Active'])}}" 
                class="btn btn-{{$status == 'Active' ? 'primary' : 'outline-primary'}} px-4 py-2 mr-3"
                style="{{ $status == 'Active' ? 'background-color: #efb507; border-color: #efb507; color: #121212;' : 'border-color: #2f2f2f; color: #efb507;' }}">
                Active Tickets
            </a>
            <a href="{{route('my-booking',['type'=>'Completed'])}}" 
                class="btn btn-{{$status == 'Completed' ? 'primary' : 'outline-primary'}} px-4 py-2"
                style="{{ $status == 'Completed' ? 'background-color: #efb507; border-color: #efb507; color: #121212;' : 'border-color: #2f2f2f; color: #efb507;' }}">
                Completed Tickets
            </a>
        </div>

        <!-- Tickets Grid -->
        <div class="row">
            @forelse ($myBooing as $item)
                <div class="col-md-4 mb-4">
                    <div class="card card-main h-100">
                        <img src="{{env('BACKEND_BASE_URL')}}/{{$item['event_img']}}" 
                             alt="Event Image" 
                             class="card-img-top" 
                             style="height: 200px; object-fit: cover; border-bottom: 1px solid #2f2f2f;">
                        
                        <div class="card-body">
                            <h5 class="card-title text-light"><b>{{ $item['event_title'] }}</b></h5>
                            <div class="card-details text-muted">
                                <p class="mb-2"><strong class="text-light">Event Date:</strong> {{ $item['event_sdate'] }}</p>
                                <p class="mb-2"><strong class="text-light">Location:</strong> {{ $item['event_place_name'] }}</p>
                                <p class="mb-2"><strong class="text-light">Ticket Type:</strong> {{ $item['ticket_type'] }}</p>
                                <p class="mb-2">
                                    <strong class="text-light">Status:</strong> 
                                    <span class="badge text-white {{ $item['ticket_status'] == 'Booked' ? 'bg-success' : 'bg-danger' }}">
                                        {{ $item['ticket_status'] }}
                                    </span>
                                </p>
                                <p class="mb-2"><strong class="text-light">Total Tickets:</strong> {{ $item['total_ticket'] }}</p>
                                <p class="mb-2"><strong class="text-light">Booked In:</strong> {{ number_format($item['book_mintues'], 2) }} minutes</p>
                            </div>
                            
                            <div class="d-flex justify-content-between align-items-center mt-3">
                                <a href="{{ route('ticket-information', ['id' => $item['ticket_id']]) }}" 
                                   class="btn btn-success btn-sm w-100">
                                    <i class="fas fa-ticket-alt mr-2"></i> View/Download E-ticket
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="card card-main text-center p-4">
                        <i class="fas fa-ticket-alt fa-3x mb-3" style="color: #6c757d;"></i>
                        <h4 class="text-muted">No {{ $status }} Tickets Found</h4>
                        <p class="text-muted">You don't have any {{ strtolower($status) }} tickets at the moment.</p>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .my-tickets {
        background-color: #121212;
        color: #fff;
    }

    .card-main{
        background: linear-gradient(to right, #121212, #161616);
        border: 1px solid #2f2f2f;
    }
    
    .my-tickets .card {
        background: none;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .my-tickets .card:hover {
        transform: translateY(-5px);
    }
    
    .my-tickets .btn-outline-primary {
        border-color: #2f2f2f;
        color: #efb507;
    }
    
    .my-tickets .btn-outline-primary:hover {
        background-color: rgba(239, 181, 7, 0.1);
    }
    
    .my-tickets .text-muted {
        color: #6c757d !important;
    }
    
    .my-tickets .badge {
        padding: 0.5em 0.75em;
        font-weight: 500;
    }
</style>
@endpush