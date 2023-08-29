<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class MailHandler extends Mailable
{
    use Queueable, SerializesModels;

    protected $pdf;

    /**
     * Create a new message instance.
     */
    public function __construct($pdfContent)
    {
        $this->pdf = $pdfContent;
    }

    public function build() {
        return $this->subject('Certificate of Appearance')
                    ->view('mail')
                    ->attachData($this->pdf, 'attachment.pdf', [
                        'mime' => 'application/pdf',
                    ]);
    }
}
