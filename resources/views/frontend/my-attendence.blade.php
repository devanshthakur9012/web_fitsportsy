@extends('frontend.master', ['activePage' => null])
@section('title', __('My Attendance'))
@section('content')

<section class="my-attendance py-5">
    <div class="container">
        <div class="text-center mb-4">
            <h1 class="h3 font-weight-bold">{{ __('My Attendance') }}</h1>
            <p class="lead text-muted">Track and manage your event attendance records</p>
        </div>

        <!-- Filters Card -->
        <div class="card bg-dark border-secondary mb-4">
            <div class="card-body">
                <form id="attendanceFilterForm">
                    <div class="row">
                        <!-- Event Filter -->
                        <div class="col-md-4 mb-3 mb-md-0">
                            <label for="event_id" class="form-label text-muted">Select Event</label>
                            <select name="event_id" id="event_id" class="form-control text-light border-secondary">
                                <option value="">All Events</option>
                                @isset($events)
                                    @foreach ($events as $event)
                                        <option value="{{ $event['id'] }}" {{ $defaultEvent == $event['id'] ? 'selected' : '' }}>
                                            {{ $event['title'] }}
                                        </option>
                                    @endforeach
                                @endisset
                            </select>
                        </div>

                        <!-- Date Filter -->
                        <div class="col-md-4 mb-3 mb-md-0">
                            <label for="date_filter" class="form-label text-muted">Select Month & Year</label>
                            <input type="month" name="date_filter" id="date_filter" class="form-control text-light border-secondary"
                                   value="{{ request('date_filter', date('Y-m')) }}">
                        </div>

                        <!-- Submit Button -->
                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-primary w-100 py-2" style="background-color: #efb507; border-color: #efb507; color:rgb(251, 251, 251);">
                                <i class="fas fa-filter mr-2"></i> Filter
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Attendance Table -->
        <div id="attendanceTable" class="card bg-dark border-secondary">
            <div class="card-body p-0">
                @include('frontend.attendance-ajax', ['attendance' => $attendance])
            </div>
        </div>

    </div>
</section>

@include('alert-messages')
@endsection

@push('styles')
<style>
    .my-attendance {
        background-color: #121212;
        color: #fff;
    }
    
    .my-attendance .card {
        background: linear-gradient(to right, #121212, #161616);
        border-color: #2f2f2f !important;
    }
    
    .my-attendance .form-control {
        background-color: #1e1e1e;
        border-color: #2f2f2f;
        color: #fff;
    }
    
    .my-attendance .form-control:focus {
        background-color: #1e1e1e;
        border-color: #efb507;
        color: #fff;
        box-shadow: 0 0 0 0.2rem rgba(239, 181, 7, 0.25);
    }
    
    .my-attendance .form-label {
        font-size: 0.85rem;
        font-weight: 500;
    }
    
    .my-attendance .table {
        color: #fff;
        margin-bottom: 0;
    }
    
    .my-attendance .table th {
        background-color: #212121;
        border-color: #2f2f2f !important;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-size: 0.85rem;
    }
    
    .my-attendance .table td {
        border-color: #2f2f2f !important;
        vertical-align: middle;
    }
    
    .my-attendance .table tbody tr:hover {
        background-color: rgba(255, 255, 255, 0.03);
    }
    
    .my-attendance .badge-success {
        background-color: #28a745 !important;
    }
    
    .my-attendance .badge-danger {
        background-color: #dc3545 !important;
    }
    
    .my-attendance .badge-warning {
        background-color: #ffc107 !important;
        color: #121212 !important;
    }
    
    .my-attendance .text-muted {
        color: #6c757d !important;
    }
    
    .my-attendance .pagination .page-item .page-link {
        background-color: #1e1e1e;
        border-color: #2f2f2f;
        color: #efb507;
    }
    
    .my-attendance .pagination .page-item.active .page-link {
        background-color: #efb507;
        border-color: #efb507;
        color: #121212;
    }
    
    .my-attendance .pagination .page-item.disabled .page-link {
        background-color: #1e1e1e;
        border-color: #2f2f2f;
        color: #6c757d;
    }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function () {
        function fetchAttendanceData() {
            const formData = $('#attendanceFilterForm').serialize();

            $.ajax({
                url: '{{ route("attendence-data.ajax") }}',
                method: 'GET',
                data: formData,
                beforeSend: function() {
                    $('#attendanceTable').html(`
                        <div class="card-body">
                            <div class="text-center py-4">
                                <i class="fas fa-spinner fa-spin fa-2x" style="color: #efb507;"></i>
                            </div>
                        </div>
                    `);
                },
                success: function (response) {
                    $('#attendanceTable').html(`
                        <div class="card-body p-0">
                            ${response.html}
                        </div>
                    `);
                },
                error: function () {
                    $('#attendanceTable').html(`
                        <div class="card-body">
                            <div class="alert alert-danger">
                                Failed to fetch attendance data. Please try again.
                            </div>
                        </div>
                    `);
                }
            });
        }

        // Trigger filter on form submission
        $('#attendanceFilterForm').on('submit', function (e) {
            e.preventDefault();
            fetchAttendanceData();
        });

        // Pagination Click Event
        $(document).on('click', '.paginate-btn', function (e) {
            e.preventDefault();
            const page = $(this).data('page');
            fetchAttendanceData(page);
        });
    });
</script>
@endpush