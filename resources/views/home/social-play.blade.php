@extends('frontend.master', ['activePage' => 'home'])
@section('title', __('Social Play'))
@section('og_data')
<meta name="title" content="@isset($meta_data['meta_title']){{$meta_data['meta_title']}}@endisset" />
<meta name="description" content="@isset($meta_data['meta_description']){{$meta_data['meta_description']}}@endisset" />
<meta name="keywords" content="@isset($meta_data['meta_keyword']){{$meta_data['meta_keyword']}}@endisset " />
@endsection
@section('content')
<style>
    .btn-white {
        background-color: #fff;
        border-radius: 4px;
        color: #000;
    }

    .type_cat {
        padding: 4px 10px !important;
        background: #ffd700;
        color: #000;
        font-size: 14px !important;
        font-weight: 500;
    }

    .location {
        background: #6e6e6e;
        color: #fff;
        border-radius: 20px;
        padding: 4px 10px;
        font-size: 11px !important;
        position: absolute;
        top: -12px;
        right: 10px;
    }

    .category {
        background: #ffd700;
        color: #000000;
        border-radius: 20px;
        padding: 4px 10px !important;
        font-size: 14px !important;
        position: absolute;
        top: 10px;
        left: 7px;
    }
    .catIcon {
        width: 20px !important;
        height: 20px !important;
    }

    .default2-btn {
        background-color: #ff2f31 !important;
        border-color: #ff2f31 !important;
        padding: 7px 10px;
        color: #fff !important;
    }

    .badge-default {
        color: #fff;
        background-color: #6e6e6e;
        padding: 4px 8px;
    }

    .badge-default:hover {
        color: #fff;
        background-color: #06408d;
    }

    .badge-success {
        padding: 3px 8px !important;
    }
</style>
<div class="container my-5">
    <div class="hawan_section">
        <div class="mt-5 mb-3">
            <div class="d-flex justify-content-between align-items-center">
                <div class="h4 mb-0 float-left"> <img width="180px" src="{{asset('/frontend/images/SocialPlay.png')}}" alt="Social Play">  <button class="mx-3 btn social-btn py-2" data-toggle="modal" data-target="#socialPlay">Create</button></div>
                <div class="d-flex align-items-center gap-2">
                    <!-- City Filter -->
                    <select name="city" id="cityFilter" style="min-width: 160px;" class="form-control mr-2">
                        <option value="">Select City</option>
                        @php $catData = Common::fetchLocation(); @endphp
                        @if(count($catData))
                            @foreach ($catData as $item)
                                <option value="{{$item['city']}}">{{$item['city']}}</option>
                            @endforeach
                        @endif
                    </select>

                    <!-- Category Filter -->
                    <select name="category" id="categoryFilter" style="min-width: 160px;" class="form-control mr-2">
                        <option value="">Select Sport</option>
                        @php $catData = Common::allEventCategoriesByApi(); @endphp
                        @if(count($catData))
                            @foreach ($catData as $item)
                                <option value="{{$item['title']}}">{{$item['title']}}</option>
                            @endforeach
                        @endif
                    </select>

                    <!-- Skill Level Filter (optional) -->
                    <select name="skill_level" id="skillLevelFilter" style="min-width: 160px;"
                        class="form-control mr-2">
                        <option value="">Select Skill Level</option>
                        <option value="Beginner">Beginner</option>
                        <option value="Intermediate">Intermediate</option>
                        <option value="Advanced">Advanced</option>
                    </select>

                    <!-- Price Filter (optional) -->
                    <button class="btn btn-primary mr-2 py-2" id="applyFilter">Filter</button>
                    <a href="{{route('social-play')}}" class="btn default2-btn py-2">Reset</a>
                </div>
            </div>
        </div>
        <div id="playData" class="mt-5">
            @isset($social_play)
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
            @endisset
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $(document).ready(function () {
        function fetchSocialPlayData(page = 1) {
            const city = $('#cityFilter').val();
            const category = $('#categoryFilter').val();
            const skill_level = $('#skillLevelFilter').val();
            const limit = "{{$limit}}"; // Use limit dynamically

            $.ajax({
                url: '{{ route("social-play.ajax") }}',
                method: 'GET',
                data: {
                    city: city,
                    category: category,
                    skill_level: skill_level,
                    page: page,
                    limit: limit,
                },
                beforeSend: function() {
                    $('#playData').html('<div class="text-center"><i class="fas fa-spinner fa-spin fa-2x"></i></div>');
                },
                success: function (response) {
                    $('#playData').html(response.html);
                },
                error: function () {
                    alert('Failed to fetch data.');
                }
            });
        }

        // Apply Filter
        $('#applyFilter').on('click', function (e) {
            e.preventDefault();
            fetchSocialPlayData(); // Fetch with filters
        });

        // Pagination Click Event (delegated)
        $(document).on('click', '.paginate-btn', function (e) {
            e.preventDefault();
            const page = $(this).data('page');
            fetchSocialPlayData(page);
        });
    });
</script>
@endpush
