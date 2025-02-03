<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Invoice;
use Illuminate\Mail\Attachment;


class SendReceipt extends Mailable
{
    use Queueable, SerializesModels;

    private String $pdfContent;
    private Invoice $invoice;
    /**
     * Create a new message instance.
     */
    public function __construct($invoice, $attachment)
    {
        $this->invoice = $invoice;
        $this->pdfContent = $attachment;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Receipt from Sender',

        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {

        return new Content(
            view: 'mail.invoice.invoice-sent',
            with: [
                'invoice' => $this->invoice,
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [Attachment::fromData(fn() => $this->pdfContent, 'Invoice.pdf')
            ->withMime('application/pdf')];
    }
}
