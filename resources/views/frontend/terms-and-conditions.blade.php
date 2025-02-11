
@extends('frontend.master', ['activePage' => 'Booking Details'])
@section('title', __('Terms & Conditions'))
@section('content')
@push('styles')
<style>
    
    .policy-content h1 {
        text-align: center;
        color: #fff;
    }
    .policy-content h2 {
        color: #fff;
        margin-top: 20px;
    }
    .policy-content p {
        margin: 10px 0;
    }
    .policy-content ul {
        margin: 10px 0 10px 20px;
    }
    .contact-info {
        margin-top: 20px;
    }
</style>
@endpush
<section class="policy-area section-area">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-12 col-lg-12">
                <div class="card shadow-sm rounded border-0">
                    <div class="card-body policy-content">
                        <h1>{{$page['title']}}</h1>
                        <div>{!!$page['description']!!}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection