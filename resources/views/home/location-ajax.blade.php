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
                            {{-- <small>{{$tour['event_sdate']}}</small> --}}
                            <p class="my-2"><small class="location"><i class="fas fa-map-marker-alt pr-1"></i>{{$tour['event_place_name']}}</small></p>
                            <p class="card-text mb-2">
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
                                    <span class="badge badge-primary type_cat" data-toggle="tooltip" data-placement="top" title="{{ $key }}">{{ $item }}</span>
                                @endforeach
                            @endisset
                            <div class="mt-2">
                                <button class="btn text-warning btn-sm mb-1 p-0">Package Price : {{$tour['event_ticket_price']}}</button>
                                <!-- <a href="{{route('coaching-detail', [Str::slug($tour['event_title']),$tour['event_id']])}}" class="mt-1 btn btn-success btn-sm mb-1 w-100">Book Coaching</a> -->

                                <div class="d-flex mt-1 mb-1">
                                    @if($tour['play_free_trial'])
                                        @php
                                            $inputObj = new stdClass();
                                            $inputObj->params = 'id='.$tour['event_id'];
                                            $inputObj->url = route('free-trail');
                                            $encLink = Common::encryptLink($inputObj);

                                            $ticket_type_keys = array_keys($tour['ticket_types']);
                                            $data_slots = json_encode(array_keys($tour['ticket_types']));
                                        @endphp
                                        <button class="btn btn-primary btn-sm mr-1 w-50 free_trail_btn" data-url="{{$encLink}}" data-title="{{$tour['event_title']}}"  data-group-location='@json($tour["group_location"])' data-group-short_name='@json($tour["group_short_name"])' data-slots="{{$data_slots}}" style="background:#28a745 !important;" data-toggle="modal" data-target="#freeTrailModal">Try For Free</button>
                                        <a href="{{ route('coaching-detail', [Str::slug($tour['event_title']), $tour['event_id']]) }}" class="btn btn-success btn-sm w-50">Book Coaching</a>
                                    @else
                                        <a href="{{ route('coaching-detail', [Str::slug($tour['event_title']), $tour['event_id']]) }}" class="btn btn-success btn-sm w-100">Book Coaching</a>
                                    @endif
                                </div>
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