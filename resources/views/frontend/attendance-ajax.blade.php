<table class="table mb-0">
    <thead class="">
        <tr>
            <th class="text-center">#</th>
            <th>Event</th>
            <th class="text-center">Date</th>
            <th class="text-center">Check-in</th>
            <th class="text-center">Check-out</th>
            <th class="text-center">Status</th>
        </tr>
    </thead>
    <tbody>
        @if (!empty($attendance) && count($attendance) > 0)
            @foreach ($attendance as $key => $item)
                <tr class="border-secondary">
                    <td class="text-center align-middle border">{{ $key + 1 }}</td>
                    <td class="align-middle border">{{ $item['event_title'] }}</td>
                    <td class="text-center align-middle border">{{ date('d M, y', strtotime($item['date'])) }}</td>
                    <td class="text-center align-middle border">{{ date('d M, Y H:i A', strtotime($item['checkin_time'])) }}</td>
                    <td class="text-center align-middle border">
                        @if($item['checkout_time'])
                            {{ date('d M, Y H:i A', strtotime($item['checkout_time'])) }}
                        @else
                            <span class="text-muted">Not checked out</span>
                        @endif
                    </td>
                    <td class="text-center align-middle border">
                        @php
                            $statusClass = [
                                'checked_out' => 'bg-info',
                                'checked_in' => 'bg-success'
                            ][$item['status']] ?? 'bg-primary';
                        @endphp
                        <span class="badge {{ $statusClass }} p-2">
                            {{ ucfirst(str_replace('_', ' ', $item['status'])) }}
                        </span>
                    </td>
                </tr>
            @endforeach
        @else
            <tr>
                <td colspan="6" class="text-center py-4 border">
                    <i class="fas fa-calendar-times fa-2x mb-3"></i><br>
                    No attendance records found for selected filters.
                </td>
            </tr>
        @endif
    </tbody>
</table>