<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketEmail extends Mailable
{
    use Queueable, SerializesModels;

    public $bookingData;
    public $eventDetails;
    public $userDetails;
    public $ticketId;

    public function __construct($bookingData, $eventDetails, $userDetails, $ticketId)
    {
        $this->bookingData = $bookingData;
        $this->eventDetails = $eventDetails;
        $this->userDetails = $userDetails;
        $this->ticketId = $ticketId;
    }

    public function build()
    {
        return $this->subject('Your Booking Confirmation - ' . $this->eventDetails['event_title'])
                    ->view('emails.ticket')
                    ->with([
                        'bookingData' => $this->bookingData,
                        'eventDetails' => $this->eventDetails,
                        'userDetails' => $this->userDetails,
                        'ticketId' => $this->ticketId,
                    ]);
    }
}