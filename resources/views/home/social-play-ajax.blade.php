@if(isset($social_play) && count($social_play))
    <div class="row list-bp">
            @foreach ($social_play as $play)
                <div class="col-xl-4 col-md-4 col-sm-6 mb-3">
                    <div class="card m-card shadow-sm border-0 listcard">
                        <div>
                            <div class="card-body position-relative">
                                <div class="d-flex gap-1 align-items-start mb-3">
                                    <div class="socialImgBox">
                                        <img src="{{env('BACKEND_BASE_URL')."/".$play['user_img']}}" class="profile-img" alt="{{$play['user_name']}}">
                                        @if (isset($play['joinedUsers']) && count($play['joinedUsers']) > 0)
                                            @php
                                                $lastUser = $play['joinedUsers'][count($play['joinedUsers']) - 1];
                                            @endphp
                                            <img src="{{ env('BACKEND_BASE_URL') . '/' . $lastUser['user_img'] }}" class="smallImg" alt="{{ $lastUser['user_name'] }}">
                                        @endif
                                    </div>
                                    <div>
                                        <h4 class="card-title mb-0 text-capitalize social-title">{{$play['play_title']}}</h4>
                                        <small>{{$play['user_name']}} | @if (isset($play['joinedUsers']) && count($play['joinedUsers']))<span class="text-success">{{count($play['joinedUsers'])}}</span>/@endif{{$play['play_slots']}} slots</small>
                                    </div>
                                </div>
                                {{-- <small>Devansh | 25 Karma</small> --}}
                                <div class="my-2">
                                    @isset($play['category_name'])
                                        <a href="{{route('coaching', ['category' => Str::slug($play['category_name'])])}}"
                                            class="d-inline-flex justify-content-center align-items-center badge badge-default fw-normal"><img
                                                src="{{env('BACKEND_BASE_URL') . "/" . $play['category_img']}}"
                                                class="mr-1 catIcon"
                                                alt="{{$play['category_name']}}"><small>{{$play['category_name']}}</small></a>
                                    @endisset
                                    @if(isset($play['pay_join']) && $play['pay_join'] == 1)
                                        <a href="javascript:void(0)"
                                            class="d-inline-flex justify-content-center align-items-center badge badge-success fw-normal"><img
                                                src="{{asset('frontend/images/pay-join-icon.png')}}" class="mr-1 catIcon"
                                                alt="Price Tag"><small>INR {{$play['play_price']}}</small></a>
                                    @endif
                                </div>
                                <p class="card-text mb-2">
                                    <small class="text-dark text-capitalize" title="{{$play['play_place_location']}}"><i
                                            class="fas fa-map-marker-alt pr-1"></i>
                                        {{ Str::lower(strlen($play['play_place_location']) > 40 ? substr($play['play_place_location'], 0, 40) . '...' : $play['play_place_location']) }}
                                    </small>
                                </p>
                                @isset($play['play_skill_level'])
                                    @if (is_array($play['play_skill_level']) && count($play['play_skill_level']))
                                        @foreach ($play['play_skill_level'] as $item)
                                            <span class="badge badge-default">{{$item}}</span>
                                        @endforeach
                                    @endif
                                @endisset
                                <div class="mt-2">
                                    <button class="mt-1 btn btn-outline-white btn-sm mb-1"><i
                                            class="far fa-calendar-alt pr-2"></i> <small>{{$play['play_sdate']}}</small>
                                    </button>
                                    <a href="{{route('play', $play['play_uuid'])}}"
                                        class="mt-1 btn default2-btn btn-sm mb-1 w-100">Join Now</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    {{-- Pagination --}}
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
@else
    <p class="text-center">No Social Play events found.</p>
@endif
