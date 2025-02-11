@extends('frontend.master', ['activePage' => 'home'])

@php $locationName = ""; @endphp
@isset($location['city'])
    @php $locationName = 'Coachings In '.$location['city'] @endphp
@endisset
@if (isset($location['meta_title']))
    @php $locationName = $location['meta_title']; @endphp
@endif
@section('title', __($locationName))
@section('og_data')
    <meta name="description" content="@isset($location['meta_description']){{$location['meta_description']}}@endisset" />
@endsection
@section('content')
<style>
    .btn-white{
        background-color: #fff;
        border-radius: 4px;
        color: #000;
    }
    .type_cat{
        padding: 4px 10px !important;
        background: #ffd700;
        color: #000;
        font-size: 14px !important;
        font-weight: 500;
    }
    .location{
        background: #6e6e6e;
        color: #fff;
        border-radius: 20px;
        padding: 4px 10px;
        font-size: 11px !important;
        position: absolute;
        top: -12px;
        right: 10px;
    }
    .category{
        background: #ffd700;
        color: #000000;
        border-radius: 20px;
        padding: 4px 10px !important;
        font-size: 14px !important;
        position: absolute;
        top: 10px;
        left: 7px;
    }
    .default2-btn{
        background-color: #ff2f31 !important;
        border-color: #ff2f31 !important;
        padding: 7px 10px;
        color:#fff !important;
    }
</style>
{{-- <div class="pt-3 pb-3 shadow-sm home-slider">
    <div class="osahan-slider">
      
    </div>
</div> --}}
<div class="container my-5">
    <div class="hawan_section">
        <div class="mt-5 mb-3">
            <h1 class="h4 mb-2">{{ ucwords(str_replace('-', ' ', $category)) }} Coaching</h1>
        </div>
        <div id="playData">
           <div class="row list-bp">
                @if(isset($category_tournament) && count($category_tournament))
                    @foreach ($category_tournament as $tour)
                        <div class="col-xl-4 col-md-4 col-sm-6 mb-3">
                            <div class="card m-card shadow-sm border-0 listcard">
                                <div>
                                    <div class="m-card-cover  position-relative">
                                        <img src="{{env('BACKEND_BASE_URL')}}/{{$tour['event_img']}}" class="card-img-top" alt="{{$tour['event_title']}}">
                                        @isset($tour['cid'])
                                            <a href="{{route('coaching',['category'=>Str::slug($tour['category'])])}}" class="my-2"><small class="category">{{$tour['category']}}</small></a>
                                        @endisset
                                    </div>
                                    <div class="card-body position-relative">
                                        <h5 class="card-title mb-2"><u>{{$tour['event_title']}}</u></h5>
                                        <small>{{$tour['event_sdate']}}</small>
                                        <p class="my-2"><small class="location"><i class="fas fa-map-marker-alt pr-1"></i>{{$tour['event_place_name']}}</small></p>
                                        <p class="card-text mb-0">
                                            <small class="text-dark" title="{{$tour['event_place_address']}}"><i class="fas fa-map pr-2"></i>
                                            {{ strlen($tour['event_place_address']) > 50 ? substr($tour['event_place_address'], 0, 50) . '...' : $tour['event_place_address'] }}
                                            </small>
                                        </p>
                                        @php
                                            // Ensure ticket_types exists and is an array
                                            if (isset($tour['ticket_types']) && is_array($tour['ticket_types'])) {
                                                // Sort the array by extracting numeric and alphabetic parts
                                                uksort($tour['ticket_types'], function ($a, $b) {
                                                    // Extract the numeric part of the keys
                                                    $numA = (int) preg_replace('/\D/', '', $a); // Get numbers only
                                                    $numB = (int) preg_replace('/\D/', '', $b); // Get numbers only
                                        
                                                    // Compare numeric parts first
                                                    if ($numA !== $numB) {
                                                        return $numA <=> $numB;
                                                    }
                                        
                                                    // If numeric parts are the same, compare alphabetically (B vs G)
                                                    return strcmp($a, $b);
                                                });
                                            }
                                        @endphp
                                        @isset($tour['ticket_types'])
                                            @foreach ($tour['ticket_types'] as $key => $item)
                                                <span class="badge badge-primary m-1 type_cat" data-toggle="tooltip" data-placement="top" title="{{ $key }}">{{ $item }}</span>
                                            @endforeach
                                        @endisset
                                        <div class="mt-2">
                                            <button class="mt-1 btn btn-outline-white btn-sm mb-1">Package Price : {{$tour['event_ticket_price']}}</button>
                                            @if(strtotime($tour['event_sdate']) < strtotime(date('Y-m-d')))
                                                <a href="javascript:void(0);" class="mt-1 btn default2-btn btn-sm mb-1 w-100">Completed</a>
                                            @else
                                                <a href="{{route('coaching-detail', [Str::slug($tour['event_title']),$tour['event_id']])}}" class="mt-1 btn btn-success btn-sm mb-1 w-100">Book Coaching</a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-center w-100">No Events found.</p>
                @endif
           </div>
           
           <div class="d-flex justify-content-end mt-2 gap-2 pagination-container" style="gap: 4px">
                {{-- Previous Button --}}
                @if ($pagination['current_page'] > 1)
                    <button class="btn btn-primary btn-sm me-2 paginate-btn" data-page="{{ $pagination['current_page'] - 1 }}"
                        id="prevPage">Previous</button>
                @else
                    <button class="btn btn-secondary btn-sm me-2" disabled>Previous</button>
                @endif

                {{-- Page Number Links --}}
                @php
                    $totalPages = $pagination['total_pages'];
                    $currentPage = $pagination['current_page'];
                    $startPage = max(1, $currentPage - 2);
                    $endPage = min($totalPages, $currentPage + 2);
                @endphp

                @if ($startPage > 1)
                    <button class="btn btn-outline-primary btn-sm me-1 px-2 paginate-btn" data-page="1">1</button>
                    @if ($startPage > 2)
                        <span class="btn btn-outline-secondary btn-sm me-1 px-2" disabled>...</span>
                    @endif
                @endif

                @for ($i = $startPage; $i <= $endPage; $i++)
                    <button class="btn px-2 btn-sm paginate-btn {{ $i == $currentPage ? 'btn-primary' : 'btn-outline-primary' }} me-1"
                        data-page="{{ $i }}">
                        {{ $i }}
                    </button>
                @endfor

                @if ($endPage < $totalPages)
                    @if ($endPage < $totalPages - 1)
                        <span class="btn btn-outline-secondary paginate-btn btn-sm me-1 px-2" disabled>...</span>
                    @endif
                    <button class="btn btn-outline-primary paginate-btn btn-sm me-1 px-2"
                        data-page="{{ $totalPages }}">{{ $totalPages }}</button>
                @endif

                {{-- Next Button --}}
                @if ($pagination['current_page'] < $totalPages)
                    <button class="btn btn-primary btn-sm ms-2 paginate-btn" data-page="{{ $pagination['current_page'] + 1 }}"
                        id="nextPage">Next</button>
                @else
                    <button class="btn btn-secondary btn-sm ms-2" disabled>Next</button>
                @endif
            </div>
        </div>
        <div class="mt-4">
            @isset($location['description'])
                <p>{{$location['description']}}</p>
            @endisset
        </div>
    </div>
</div>
@push('scripts')
<script>
    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })
</script>
<script>
      $(document).ready(function () {
        function fetchSocialPlayData(page = 1) {
            const limit = "{{$limit}}";
            $.ajax({
                url: '{{ route("location-coaching-ajax") }}',
                method: 'GET',
                data: {
                    location:"{{$category}}",
                    page: page,
                    limit: limit,
                },
                beforeSend: function () {
                    $('#playData').html('<div class="text-center"><i class="fas fa-spinner fa-spin fa-2x"></i></div>');
                },
                success: function (response) {
                    $('#playData').html(response.html);
                },
                error: function (xhr, status, error) {
                    console.error("AJAX Error:", {
                        status: status,
                        error: error,
                        responseText: xhr.responseText
                    });
                    alert("Failed to fetch data. Check the console for details.");
                }
            });
        }
        // Pagination Click Event (delegated)
        $(document).on('click', '.paginate-btn', function (e) {
            e.preventDefault();
            const page = $(this).data('page');
            fetchSocialPlayData(page);
        });
    });
</script>
@endpush
@endsection
