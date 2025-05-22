@extends('frontend.master', ['activePage' => null])

@section('title', __('My Group Sessions'))

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
        <h2 class="text-center mb-4">My Group Sessions</h2>
        <div class="row">
            @isset($mySocialPlay)
                    <table class="table bg-backGround rounded-sm p-2">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Session Name</th>
                                <th scope="col">Type</th>
                                <th scope="col">Venue</th>
                                <th scope="col">Slots</th>
                                <!-- <th scope="col">Price</th> -->
                                <th scope="col">Session Type</th>
                                <th scope="col">Status</th>
                                <th scope="col">Gender</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($mySocialPlay as $index => $item)
                                            <tr>
                                                <th scope="row">{{ $index + 1 }}</th>
                                                <td>
                                                    <p class="mb-0">{{$item['title']}}</p>
                                                    <small>{{ $item['play_sdate'] }}</small>
                                                </td>
                                                <td>{{$item['category_name'] ?? ''}}</td>
                                                <td><span title="{{$item['venue']}}">{{\Str::limit($item['venue'], 20, '...')}}, {{$item['location']}}</span></td>
                                                <td>{{$item['slots']}}</td>
                                                <!-- <td>₹{{ $item['price'] }}</td> -->
                                                <td>{{ $item['type'] }}</td>
                                                <td><span
                                                        class="badge badge-{{$item['status'] == "Active" ? "success" : "danger"}}">{{$item['status']}}</span>
                                                </td>
                                                <td>{{ $item['gender']}}</td>
                                                <td>
                                                    <a href="{{route('join-users', ['uuid' => $item['play_id']])}}"
                                                        class="btn btn-secondary btn-sm"><i class="fas fa-users fa-sm"></i></a>
                                                    @php
                                                        $inputObj = new stdClass();
                                                        $inputObj->params = 'id=' . $item['play_id'];
                                                        $inputObj->url = route('update-play');
                                                        $editPlay = Common::encryptLink($inputObj);
                                                    @endphp
                                                    <button class="btn btn-primary btn-sm editModal" data-toggle="modal"
                                                        data-target="#socialPlayEdit" data-url="{{$editPlay}}"
                                                        data-catId="{{$item['category_id']}}" data-title="{{$item['title']}}"
                                                        data-start_date="{{$item['start_date']}}" data-end_date="{{$item['end_date']}}" data-gender="{{$item['gender']}}" data-start_time="{{$item['start_time']}}"
                                                        data-skill_level="{{ json_encode($item['skill_level']) }}" data-venue="{{$item['venue']}}"
                                                        data-slots="{{$item['slots']}}" data-price="{{$item['price']}}"
                                                        data-upi_id="{{$item['upi_id']}}" data-type="{{$item['type']}}"
                                                        data-pay_join="{{$item['pay_join']}}" data-note="{{$item['note']}}" data-location="{{$item['location']}}"
                                                        data-status="{{$item['status']}}"><i class="fas fa-pen fa-sm"></i></button>
                                                </td>
                                            </tr>
                            @endforeach
                        </tbody>
                    </table>
            @else
                <p class="text-center">No Group Sessions available.</p>
            @endisset
        </div>
    </div>

    {{-- Group Sessions --}}
    <div class="modal fade" id="socialPlayEdit" tabindex="-1" role="dialog" aria-labelledby="socialPlayEditLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="socialPlayEditLabel">Group Sessions</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="popular-location">
                        <div class="w-auto" style="gap: 10px;">
                            <form id="editSocialPlayForm" action="" autocomplete="off" class="row" method="POST">
                                <div class="mb-3 col-lg-6">
                                    @csrf
                                    <label for="cat_id" class="form-label">Type <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control" id="cat_id" name="cat_id" required>
                                        @php $catData = Common::allEventCategoriesByApi(); @endphp
                                        @isset($catData)
                                            <option value="" selected disabled>Select Type</option>
                                            @foreach ($catData as $item)
                                                <option value="{{$item['id']}}">{{$item['title']}}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>

                                <div class="mb-3 col-lg-6">
                                    <label for="title" class="form-label">Session Name <span
                                            class="text-danger">*</span></label>
                                    <input type="text" placeholder="Enter Session Name" class="form-control" id="title"
                                        name="title" maxlength="225" required>
                                </div>

                                <div class="mb-3 col-lg-6">
                                    <label for="start_date" class="form-label">Start Date <span
                                            class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="start_date" name="start_date" required>
                                </div>

                                <div class="mb-3 col-lg-6">
                                    <label for="end_date" class="form-label">End Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" id="end_date" name="end_date" required>
                                </div>

                                
                                <div class="mb-3 col-lg-12">
                                    <label class="form-label">Select Days <span class="text-danger">*</span></label>
                                    <div class="d-flex">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="days[]" value="Mon" id="dayMon">
                                            <label class="form-check-label" for="dayMon">Mon</label>
                                        </div>
                                        <div class="form-check ml-2">
                                            <input class="form-check-input" type="checkbox" name="days[]" value="Tue" id="dayTue">
                                            <label class="form-check-label" for="dayTue">Tue</label>
                                        </div>
                                        <div class="form-check ml-2">
                                            <input class="form-check-input" type="checkbox" name="days[]" value="Wed" id="dayWed">
                                            <label class="form-check-label" for="dayWed">Wed</label>
                                        </div>
                                        <div class="form-check ml-2">
                                            <input class="form-check-input" type="checkbox" name="days[]" value="Thu" id="dayThu">
                                            <label class="form-check-label" for="dayThu">Thu</label>
                                        </div>
                                        <div class="form-check ml-2">
                                            <input class="form-check-input" type="checkbox" name="days[]" value="Fri" id="dayFri">
                                            <label class="form-check-label" for="dayFri">Fri</label>
                                        </div>
                                        <div class="form-check ml-2">
                                            <input class="form-check-input" type="checkbox" name="days[]" value="Sat" id="daySat">
                                            <label class="form-check-label" for="daySat">Sat</label>
                                        </div>
                                        <div class="form-check ml-2">
                                            <input class="form-check-input" type="checkbox" name="days[]" value="Sun" id="daySun">
                                            <label class="form-check-label" for="daySun">Sun</label>
                                        </div>
                                   </div>
                                </div>

                                <div class="mb-3 col-lg-6">
                                    <label for="start_time" class="form-label">Session Time Slots <span
                                            class="text-danger">*</span></label>
                                    <input type="time" class="form-control" id="start_time" name="start_time" required>
                                </div>

                                <div class="mb-3 col-lg-6">
                                    <label for="venue" class="form-label">Venue Details <span
                                            class="text-danger">*</span></label>
                                    <input type="text" placeholder="Enter Venue" class="form-control" id="venue"
                                        name="venue" maxlength="225" required>
                                </div>

                                <div class="mb-3 col-lg-6">
                                    <label for="location" class="form-label">Select Location <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control" id="location" name="location" required>
                                        @php $locationData = Common::fetchLocation(); @endphp
                                        @isset($locationData)
                                            <option value="" selected disabled>Choose Location</option>
                                            @foreach ($locationData as $item)
                                                <option value="{{$item['city']}}">{{$item['city']}}</option>
                                            @endforeach
                                        @endisset
                                    </select>
                                </div>

                                <div class="mb-3 col-lg-6">
                                    <label for="slots" class="form-label">Slots <span
                                            class="text-danger">*</span></label>
                                    <input type="number" placeholder="Enter no. of slots" class="form-control"
                                        id="slots" name="slots" required>
                                </div>

                                <!-- <div class="mb-3 col-lg-6" id="price-container">
                                    <label for="price" class="form-label">Price Per Slot <span
                                            class="text-danger">*</span></label>
                                    <input type="number" placeholder="Enter Price Per Slot" step="0.01"
                                        class="form-control" id="price" name="price" required>
                                </div> -->

                                <!-- <div class="mb-3 col-lg-6">
                                    <label for="upi_id" class="form-label">UPI ID/ Mobile No.</label>
                                    <input type="text" placeholder="Enter UPI ID/ Mobile No." class="form-control"
                                        id="upi_id" name="upi_id" maxlength="225">
                                </div> -->

                                <div class="mb-3 col-lg-6">
                                    <label for="type" class="form-label">Play Type <span
                                            class="text-danger">*</span></label>
                                    <select class="form-control" id="type" name="type" required>
                                        <option value="online">Online</option>
                                        <option value="offline">Offline</option>
                                    </select>
                                </div>

                                 <div class="mb-3 col-lg-6">
                                    <label for="gender" class="form-label">Gender <span class="text-danger">*</span></label>
                                    <select class="form-control" id="gender" name="gender" required>
                                        <option value="">Select Level</option>
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                        <option value="Any">Any</option>
                                    </select>
                                </div>

                                <div class="mb-3 col-lg-12">
                                    <label for="note" class="form-label">Note</label>
                                    <textarea class="form-control" placeholder="Enter Note" id="note" name="note"
                                        maxlength="500"></textarea>
                                </div>

                                <div class="mb-3 col-lg-12">
                                    <!-- <label for="pay_join" class="form-label">Pay Join <span class="text-danger">*</span></label> -->
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" name="pay_join" role="switch" id="pay_join" checked>
                                        <label class="form-check-label" for="terms">
                                            I agree to the <a href="#">Terms and Conditions</a> <span class="text-danger">*</span>
                                        </label>
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <button type="submit" id="submit-btn" class="text-center btn default-btn w-100">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@include('alert-messages')
@endsection
@push('scripts')
    <script>
    $(document).ready(function () {
        // Initialize select2 for multi-select skills
        var s2 = $("#skill_level").select2({
            placeholder: "Select Skill Level",
            allowClear: true
        });
        
        $(".editModal").click(function () {
            let modal = $("#socialPlayEdit");
            let button = $(this);

            // First, uncheck all checkboxes
            modal.find("input[name='days[]']").prop("checked", false);

            // Loader during data fetch
            let loader = `<div class="text-center" id="modalLoader">
                            <i class="fas fa-spinner fa-spin fa-3x"></i>
                            <p>Loading...</p>
                        </div>`;
            modal.find(".modal-body").prepend(loader);

            $('#editSocialPlayForm').attr('action', button.data('url'));

            // Collect form data from button attributes
            let formData = {
                cat_id: button.data("catid"),
                title: button.data("title"),
                start_date: button.data("start_date"),
                end_date: button.data("end_date"),
                start_time: button.data("start_time"),
                skill_level: button.data("skill_level"),
                venue: button.data("venue"),
                slots: button.data("slots"),
                price: button.data("price"),
                upi_id: button.data("upi_id"),
                type: button.data("type"),
                pay_join: button.data("pay_join"),
                note: button.data("note"),
                gender: button.data("gender"),
                status: button.data("status"),
                location: button.data("location")
            };

            // Populate form fields
            setTimeout(() => {
                // Populate basic fields
                modal.find("#cat_id").val(formData.cat_id).trigger("change");
                modal.find("#title").val(formData.title);
                modal.find("#start_date").val(formData.start_date);
                modal.find("#end_date").val(formData.end_date);
                modal.find("#start_time").val(formData.start_time);
                modal.find("#venue").val(formData.venue);
                modal.find("#slots").val(formData.slots);
                modal.find("#price").val(formData.price);
                modal.find("#upi_id").val(formData.upi_id);
                modal.find("#type").val(formData.type).trigger("change");
                modal.find("#note").val(formData.note);
                modal.find("#location").val(formData.location).trigger("change");
                modal.find("#gender").val(formData.gender).trigger("change");
                // Handle Pay Join checkbox (inverted logic)
                modal.find("#pay_join").prop("checked", formData.pay_join == "1").trigger("change");

               // Parse and set skill levels (used as days here)
                let selectedDays = formData.skill_level;

                // Then, check only the selected days
                if (Array.isArray(selectedDays)) {
                    selectedDays.forEach(function(day) {
                        modal.find(`input[name='days[]'][value='${day}']`).prop("checked", true);
                    });
                }

                // Remove loader
                modal.find("#modalLoader").remove();
            }, 500);
        });

        // FORM validation
        $("#editSocialPlayForm").validate({
            rules: {
                cat_id: { required: true },
                title: { required: true, maxlength: 225 },
                start_date: { required: true, date: true, greaterThanToday: true },
                end_date: { required: true, date: true, greaterThanStartDate: true },
                "days[]": { required: true },
                start_time: { required: true },
                venue: { required: true, maxlength: 225 },
                location: { required: true, maxlength: 225 },
                slots: { required: true, number: true, min: 1 },
                type: { required: true },
                gender: { required: true },
                pay_join: { required: true }
            },
            messages: {
                cat_id: { required: "Please select a play type." },
                title: { required: "Please enter a session name.", maxlength: "Session name cannot exceed 225 characters." },
                start_date: { 
                    required: "Please select a start date.",
                    greaterThanToday: "Start date must be in the future." 
                },
                end_date: { 
                    required: "Please select an end date.",
                    greaterThanStartDate: "End date must be after start date." 
                },
                "days[]": { required: "Please select at least one day." },
                start_time: { required: "Please select a start time." },
                venue: { required: "Please enter venue details.", maxlength: "Venue details cannot exceed 225 characters." },
                location: { required: "Please select a location.", maxlength: "Location cannot exceed 225 characters." },
                slots: { 
                    required: "Please enter the number of slots.", 
                    number: "Please enter a valid number.", 
                    min: "Slots must be at least 1." 
                },
                type: { required: "Please select a session type." },
                gender: { required: "Please select a gender preference." },
                pay_join: { required: "You must agree to the terms and conditions." }
            },
            errorElement: "span",
            errorClass: "text-danger",
            highlight: function (element, errorClass) {
                $(element).addClass("is-invalid");
            },
            unhighlight: function (element, errorClass) {
                $(element).removeClass("is-invalid");
            },
            submitHandler: function (form) {
                // Show the processing indicator
                const submitButton = $("#submit-btn");
                submitButton.prop("disabled", true).text("Processing...");

                // Submit the form
                form.submit();
            }
        });

        // Custom method for validating date is in the future
        $.validator.addMethod("greaterThanToday", function (value, element) {
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            const inputDate = new Date(value);
            return this.optional(element) || inputDate >= today;
        });

        // Custom method for validating end date is after start date
        $.validator.addMethod("greaterThanStartDate", function (value, element) {
            const startDate = new Date($("#start_date").val());
            const endDate = new Date(value);
            return this.optional(element) || endDate >= startDate;
        });

        // Validate checkboxes for days
        $.validator.addClassRules("days-checkbox", {
            required: true
        });

        // Custom error placement for checkboxes
        $("#socialPlayForm").validate({
            errorPlacement: function(error, element) {
                if (element.attr("name") == "days[]") {
                    error.insertAfter(element.closest(".d-flex"));
                } else {
                    error.insertAfter(element);
                }
            }
        });

        // Toggle for terms and conditions
        $("#pay_join").change(function() {
            if ($(this).is(":checked")) {
                $(this).valid();
            }
        });
    });
    </script>
@endpush