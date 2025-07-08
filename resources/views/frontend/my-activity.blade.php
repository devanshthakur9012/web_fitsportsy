@extends('frontend.master', ['activePage' => null])
@section('title', __('My Group Session'))
@section('content')
<section class="group-session py-5">
    <div class="container">
        <div class="text-center mb-4">
            <h1 class="h3 font-weight-bold">{{ __('My Group Session') }}</h1>
            <p class="lead text-muted">View and manage your group session activities</p>
        </div>
        
        <div class="row justify-content-center">
            <div class="col-lg-12">
                @isset($myActivity)
                <div class="table-responsive">
                    <table class="table table-dark rounded-lg overflow-hidden">
                        <thead class="bg-dark">
                            <tr>
                                <th scope="col" class="text-center">#</th>
                                <th scope="col" class="text-center">Session Name</th>
                                <th scope="col" class="text-center">Type</th>
                                <th scope="col" class="text-center">Timing</th>
                                <th scope="col" class="text-center">Venue</th>
                                <th scope="col" class="text-center">Status</th>
                                <th scope="col" class="text-center">Apply Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($myActivity as $index => $item)
                            <tr class="border-secondary">
                                <td scope="row" class="text-center align-middle border">{{ $index + 1 }}</td>
                                <td class="align-middle border">{{ $item['title'] }}</td>
                                <td class="text-center align-middle border">
                                    <span class="badge badge-primary">{{ $item['category_name'] }}</span>
                                </td>
                                <td class="text-center align-middle border">{{ $item['play_sdate'] }}</td>
                                <td class="text-center align-middle border">{{ $item['venue'] }}</td>
                                <td class="text-center align-middle border">
                                    @if($item['status'] === 'Accepted')
                                        <span class="badge bg-success">Accepted</span>
                                    @elseif($item['status'] === 'Rejected')
                                        <span class="badge bg-danger">Rejected</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @endif
                                </td>
                                <td class="text-center align-middle border">{{ $item['apply_date'] }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="card bg-dark text-center p-4 border-secondary">
                    <p class="mb-0 text-muted">No Activity Available.</p>
                </div>
                @endisset
            </div>
        </div>
    </div>
</section>
@include('alert-messages')
@endsection

@push('styles')
<style>
    .group-session {
        background-color: #121212;
    }
    
    .group-session .table {
        background: linear-gradient(to right, #121212, #161616);
        border-color: #2f2f2f !important;
    }
    
    .group-session .table th, 
    .group-session .table td {
        border-color: #2f2f2f !important;
        vertical-align: middle;
    }
    
    .group-session .table thead th {
        background-color: #212121;
        border-bottom: none;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.85rem;
    }
    
    .group-session .table tbody tr:hover {
        background-color: rgba(255, 255, 255, 0.03);
    }
    
    .group-session .badge-primary {
        background-color: #efb507 !important;
        color: #121212;
        font-weight: 500;
    }
    
    .group-session .badge-success {
        background-color: #28a745 !important;
    }
    
    .group-session .badge-danger {
        background-color: #dc3545 !important;
    }
    
    .group-session .badge-warning {
        background-color: #ffc107 !important;
    }
    
    .group-session .rounded-lg {
        border-radius: 0.5rem !important;
    }
    
    .group-session .text-muted {
        color: #6c757d !important;
    }
</style>
@endpush