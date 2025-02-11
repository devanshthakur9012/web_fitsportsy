@extends('frontend.master', ['activePage' => null])

@section('title', __('Join Users'))

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
<section class="active-tickets mt-5">
    <div class="container mb-4">
        <h2 class="text-center mb-4">Joined Users</h2>
        <div class="row">
            <table class="table bg-backGround rounded-sm p-2">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">User Name</th>
                        <th scope="col">Contact Info</th>
                        <th scope="col">TXT Number</th>
                        <th scope="col">Message</th>
                        <th scope="col">Join Status</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @isset($userInfo)
                        @foreach ($userInfo as $index => $item)
                            <tr>
                                <th scope="row">{{ $index + 1 }}</th>

                                {{-- Trim long names and show full name on hover --}}
                                <td title="{{ $item['user_name'] }}">
                                    {{ strlen($item['user_name']) > 30 ? substr($item['user_name'], 0, 30) . '...' : $item['user_name'] }}
                                </td>

                                {{-- Show Email, Mobile, and Txt Number in the same column --}}
                                <td>
                                    <span title="Email: {{ trim($item['user_email']) }}">
                                        📧
                                        {{ strlen(trim($item['user_email'])) > 25 ? substr(trim($item['user_email']), 0, 25) . '...' : trim($item['user_email']) }}
                                    </span><br>
                                    <span title="Mobile: {{ $item['user_mobile'] }}">
                                        📞 {{ $item['user_mobile'] }}
                                    </span><br>
                                </td>

                                <td>{{ $item['txt_number'] ?: '----' }}</td>
                                <td>{{ $item['message'] ?: '----' }}</td>

                                {{-- Badge for join status --}}
                                <td>
                                    @if($item['join_status'] === 'Joined')
                                        <span class="badge bg-success">Joined</span>
                                    @elseif($item['join_status'] === 'Declined')
                                        <span class="badge bg-danger">Declined</span>
                                    @else
                                        <span class="badge bg-warning text-dark">Pending</span>
                                    @endif
                                </td>
                                <td>
                                    @if (!in_array($item['join_status'],['Joined','Declined']))
                                        @php
                                            $inputObj = new stdClass();
                                            $inputObj->params = 'join_id='.$item['join_id']."&status=accept";
                                            $inputObj->url = route('update-join-status');
                                            $accpetUrl = Common::encryptLink($inputObj);
                                            $inputObj->params = 'join_id='.$item['join_id']."&status=decline";
                                            $declineUrl = Common::encryptLink($inputObj);
                                        @endphp
                                        <button class="btn btn-primary bg-success border-0 btn-sm action-btn" data-url="{{$accpetUrl}}" data-status="accept"><i class="fas fa-check"></i>
                                            Approve</button>
                                        <button class="btn btn-danger bg-danger border-0 btn-sm action-btn" data-url="{{$declineUrl}}" data-status="decline"><i class="fas fa-times"></i>
                                            Reject</button> 
                                    @else 
                                      <span class="text-center w-100">--</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="100%" class="text-center">No Users Available.</td>
                        </tr>                    
                    @endisset
                </tbody>
            </table>
        </div>
    </div>
</section>
@include('alert-messages')
@endsection
@push('scripts')
    {{-- Include SweetAlert2 --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll(".action-btn").forEach(button => {
                button.addEventListener("click", function () {
                    let status = this.getAttribute("data-status");
                    let url = this.getAttribute("data-url");
    
                    Swal.fire({
                        title: "Are you sure?",
                        text: "This action can't be reverted!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#28a745",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, proceed!",
                        cancelButtonText: "Cancel"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Redirect to the URL provided in data-url
                            window.location.href = url;
                        }
                    });
                });
            });
        });
    </script>    
@endpush