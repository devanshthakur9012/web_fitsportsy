<table class="table table-bordered text-white mb-3">
    <thead>
        <tr>
            <th>#</th>
            <th>Event</th>
            <th>Date</th>
            <th>Check-in</th>
            <th>Check-out</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody>
        @if (!empty($attendance))
            @foreach ($attendance as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $item['event_title'] }}</td>
                    <td>{{ date('d M, y', strtotime($item['date'])) }}</td>
                    <td>{{ date('d M, Y H:i A', strtotime($item['checkin_time'])) }}</td>
                    <td>{{ date('d M, Y H:i A', strtotime($item['checkout_time'])) }}</td>
                    <td>{{ ucfirst(str_replace('_', ' ', $item['status'])) }}</td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="6" class="text-center">No attendance records found.</td>
            </tr>
        @endif
    </tbody>
</table>