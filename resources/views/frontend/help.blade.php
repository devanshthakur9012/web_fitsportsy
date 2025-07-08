@extends('frontend.master', ['activePage' => null])
@section('title', __('Help Center'))
@section('content')
    <section class="help-center py-5">
        <div class="container">
            <div class="text-center mb-4">
                <h1 class="h3 font-weight-bold">{{ __('Help Center') }}</h1>
                <p class="lead text-muted">Find answers to common questions about our services</p>
            </div>
            
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="accordion" id="helpAccordion">
                        @foreach ($help as $item)
                        <div class="card mb-3 border rounded-lg overflow-hidden">
                            <div class="card-header p-0" id="heading{{ $loop->index }}">
                                <h2 class="mb-0">
                                    <button class="btn btn-link btn-block text-left d-flex justify-content-between align-items-center p-3 text-decoration-none" 
                                            type="button" 
                                            data-toggle="collapse" 
                                            data-target="#collapse{{ $loop->index }}" 
                                            aria-expanded="{{ $loop->first ? 'true' : 'false' }}" 
                                            aria-controls="collapse{{ $loop->index }}">
                                        <span class="h5 mb-0 font-weight-bold">
                                            <span class="badge badge-primary mr-2">Q{{ $loop->index + 1 }}</span>
                                            {{ $item['question'] }}
                                        </span>
                                        <i class="fas {{ $loop->first ? 'fa-minus' : 'fa-plus' }}"></i>
                                    </button>
                                </h2>
                            </div>

                            <div id="collapse{{ $loop->index }}" 
                                 class="collapse {{ $loop->first ? 'show' : '' }}" 
                                 aria-labelledby="heading{{ $loop->index }}" 
                                 data-parent="#helpAccordion">
                                <div class="card-body">
                                    <p class="mb-0" style="font-size:18px;">{{ $item['answer'] }}</p>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
<style>
    .help-center .card{
        background:linear-gradient(to right, #121212, #161616) !important;
        border:1px solid #2f2f2f !important;
    }
    .help-center .badge-primary{
        background-color: #efb507 !important;
    }
    .help-center .fa-minus{
        color: #efb507 !important;
    }
    .help-center .fa-plus{
        color: #efb507 !important;
    }
    .help-center .card-header {
        border-bottom: none;
        background: #212121;
    }
    .help-center .btn-link {
        transition: all 0.3s ease;
    }
    .help-center .btn-link:hover {
        color: #0056b3;
    }
    .help-center .btn-link:focus {
        box-shadow: none;
        text-decoration: none;
    }
    .help-center .card {
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        transition: box-shadow 0.3s ease;
    }
    .help-center .card:hover {
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .help-center .badge {
        font-size: 0.8rem;
        padding: 0.35em 0.65em;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        // Toggle plus/minus icons on accordion
        $('#helpAccordion').on('show.bs.collapse', function (e) {
            $(e.target).prev('.card-header').find('i').removeClass('fa-plus').addClass('fa-minus');
        });
        
        $('#helpAccordion').on('hide.bs.collapse', function (e) {
            $(e.target).prev('.card-header').find('i').removeClass('fa-minus').addClass('fa-plus');
        });
    });
</script>
@endpush