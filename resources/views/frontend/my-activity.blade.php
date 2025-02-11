@extends('frontend.master', ['activePage' => null])

@section('title', __('My Activity'))

@section('content')
<style>
    .btn-delete {
        background: #ff0000;
        border: 1px solid #ff0000;
        color: #fff;
    }

    .bg-backGround {
        background-color: transparent !important;
        color: #fff;
        border: 1px solid;
    }

    .table td,
    .table th {
        border: 1px solid #dee2e6;
    }
</style>
<section class="active-tickets mb-4 mt-5">
    <div class="container">
        <h2 class="text-center mb-4">My Activity</h2>
        <div class="row">
            @isset($myActivity)
                <table class="table bg-backGround rounded-sm p-2">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Play Title</th>
                            <th scope="col">Category</th>
                            <th scope="col">Timing</th>
                            <th scope="col">Venue</th>
                            <th scope="col">Info</th>
                            <th scope="col">Status</th>
                            <th scope="col">Apply Date</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($myActivity as $index => $item)
                            <tr>
                                <th scope="row">{{ $index + 1 }}</th>
                                <td>{{ $item['title'] }}</td>
                                <td>{{ $item['category_name'] }}</td>
                                <td>{{ $item['play_sdate'] }}</td>
                                <td>{{ $item['venue'] }}</td>
                                <td>
                                    <p class="mb-0">TXT No. : {{$item['txt_number'] ?? "--"}}</p>
                                    <p class="mb-0">Message : {{$item['message'] ?? "--"}}</p>
                                </td>
                                <td>{{ $item['category_name'] }}</td>
                                <td>{{ $item['apply_date'] }}</td>
                                <td>
                                    @if($item['status'] === 'Accepted')
                                        <span class="badge bg-success">Accepted</span>
                                    @elseif($item['status'] === 'Rejected')
                                        <span class="badge bg-danger">Rejected</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-center">No Activity Available.</p>
            @endisset
        </div>
    </div>
</section>
@include('alert-messages')
@endsection
