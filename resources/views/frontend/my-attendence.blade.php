@extends('frontend.master', ['activePage' => null])
@section('title', __('My Attendance'))
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

<section class="active-tickets mb-5 mt-5">
    <div class="container">
        <h2 class="text-center mb-4">My Attendance</h2>

        <!-- Filters -->
        <form id="attendanceFilterForm">
            <div class="row mb-3">
                <!-- Event Filter -->
                <div class="col-md-4">
                    <label for="event_id" class="form-label">Select Event</label>
                    <select name="event_id" id="event_id" class="form-control">
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
                <div class="col-md-4">
                    <label for="date_filter" class="form-label">Select Month & Year</label>
                    <input type="month" name="date_filter" id="date_filter" class="form-control"
                           value="{{ request('date_filter', date('Y-m')) }}">
                </div>

                <!-- Submit Button -->
                <div class="col-md-4 d-flex align-items-end">
                    <button type="submit" class="btn btn-secondary w-100 py-2">Filter</button>
                </div>
            </div>
        </form>

        <!-- Attendance Table -->
        <div id="attendanceTable">
            @include('frontend.attendance-ajax', ['attendance' => $attendance])
        </div>

    </div>
</section>
@include('alert-messages')
@endsection

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
                    $('#attendanceTable').html('<div class="text-center"><i class="fas fa-spinner fa-spin fa-2x"></i></div>');
                },
                success: function (response) {
                    $('#attendanceTable').html(response.html);
                },
                error: function () {
                    alert('Failed to fetch data.');
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