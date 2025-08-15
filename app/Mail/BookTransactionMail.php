<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class BookTransactionMail extends Mailable
{
    use Queueable, SerializesModels;
    public $readerName;
    public $bookName;
    public $issueDate;
    public $dueDate;
    /**
     * Create a new message instance.
     */
    public function __construct($readerName,$bookName,$issueDate,$dueDate)
    {
        //
        $this->readerName = $readerName;
        $this->bookName = $bookName;
        $this->issueDate = $issueDate;
        $this->dueDate = $dueDate;

    }

    /**
     * Get the message envelope.
     */
   /* public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Book Transaction Mail',
        );
    }*/
    public function build(){
        return $this->subject("Kitap İşlem Bilgilendirmesi")->view('emails.bookTransaction');
    }

    /**
     * Get the message content definition.
     */
    /*public function content(): Content
    {
        return new Content(
            view: 'view.name',
        );
    }*/

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}