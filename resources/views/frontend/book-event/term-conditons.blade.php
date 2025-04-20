@extends('frontend.master', ['activePage' => null])
@section('title', __('Terms & Conditions'))
@section('content')
    <section class="terms-conditions py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-8">
                    <div class="text-center mb-4">
                        <h1 class="display-5 fw-bold mb-2">FitSportsy Terms & Conditions</h1>
                        <p class="lead">Last Updated: {{ date('F j, Y') }}</p>
                    </div>

                    <div class="card shadow-sm border-0 rounded-lg">
                        <div class="card-body p-4 p-md-5">
                            <div class="mb-5">
                                <h3 class="fw-bold mb-2 text-warning">Payment Terms</h3>
                                <ul class="list-unstyled mb-0">
                                    <p class="d-flex mb-3">
                                        <i class="fas fa-check text-warning mt-1 mr-2"></i>
                                        <span>All payments are processed directly through UPI transfers to the event organizer. FitSportsy acts solely as a platform facilitator and is not responsible for payment disputes or refunds.</span>
                                    </p>
                                    <p class="d-flex mb-3">
                                        <i class="fas fa-check text-warning mt-1 mr-2"></i>
                                        <span>Users must verify the exact payment amount and the organizer's UPI ID before completing any transaction.</span>
                                    </p>
                                </ul>
                            </div>

                            <div class="mb-5">
                                <h3 class="fw-bold mb-2 text-warning">Ticket Confirmation</h3>
                                <ul class="list-unstyled mb-0">
                                    <li class="d-flex mb-3">
                                        <i class="fas fa-check text-warning mt-1 mr-2"></i>
                                        <span>For successful ticket confirmation, users must ensure the accuracy of the last 4 digits of their UPI Transaction ID.</span>
                                    </li>
                                    <li class="d-flex mb-3">
                                        <i class="fas fa-check text-warning mt-1 mr-2"></i>
                                        <span>Entry to events may be denied if participants cannot present valid tickets or if payment details are incorrect.</span>
                                    </li>
                                </ul>
                            </div>

                            <div class="mb-5">
                                <h3 class="fw-bold mb-2 text-warning">User Responsibilities</h3>
                                <ul class="list-unstyled mb-0">
                                    <li class="d-flex mb-3">
                                        <i class="fas fa-check text-warning mt-1 mr-2"></i>
                                        <span>Participants are responsible for maintaining the confidentiality of their transaction details.</span>
                                    </li>
                                    <li class="d-flex mb-3">
                                        <i class="fas fa-check text-warning mt-1 mr-2"></i>
                                        <span>Any discrepancies in payment must be reported immediately to the event organizer.</span>
                                    </li>
                                </ul>
                            </div>

                            <div class="mb-5">
                                <h3 class="fw-bold mb-2 text-warning">Customer Support</h3>
                                <p>For any assistance or queries regarding payments, tickets, or event participation, please contact our support team:</p>
                                <div class="d-flex flex-column flex-sm-row gap-3 mt-3">
                                    <a href="mailto:support@fitsportsy.in" class="btn btn-secondary mr-3">
                                        <i class="fas fa-envelope me-2"></i> support@fitsportsy.in
                                    </a>
                                    <a href="tel:+919686314018" class="btn btn-secondary">
                                        <i class="fas fa-phone me-2"></i> +91 9686314018
                                    </a>
                                </div>
                            </div>

                            <div class="alert alert-info mt-3">
                                <p class="mb-0"><strong>Note:</strong> These terms are subject to change without prior notice. Users are encouraged to review them periodically for updates.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection