<?php

namespace App\Mail;

use App\Models\Letter;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class LetterNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $letter;

    public function __construct(Letter $letter)
    {
        $this->letter = $letter;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Arsip Surat: ' . $this->letter->judul,
        );
    }

    public function content(): Content
    {
        return new Content(
            markdown: 'emails.letter-notification',
        );
    }

    public function attachments(): array
    {
        return [
            Attachment::fromStorageDisk('public', $this->letter->file_path),
        ];
    }
}