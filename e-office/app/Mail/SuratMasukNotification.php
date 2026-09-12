<?php

namespace App\Mail;

use App\Models\Surat;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SuratMasukNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $surat;

    /**
     * Create a new message instance.
     */
    public function __construct(Surat $surat)
    {
        $this->surat = $surat;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Ada surat masuk baru nih di E-Office',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.surat_notification',
            text: 'emails.surat_notification_plain',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
