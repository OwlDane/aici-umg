<?php

namespace App\Mail\Payment;

use App\Models\Payment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;

/**
 * Email notification saat pembayaran gagal
 * 
 * Dikirim ke student setelah pembayaran gagal atau expired
 * Berisi informasi dan instruksi untuk mencoba lagi
 */
class PaymentFailed extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public Payment $payment,
        public ?string $reason = null
    ) {
        $this->onQueue('emails');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(
                config('mail.from.address'),
                config('mail.from.name')
            ),
            replyTo: [
                new Address('support@aici-umg.ac.id', 'AICI-UMG Support'),
            ],
            subject: 'Pembayaran Gagal - ' . $this->payment->invoice_number,
            tags: ['payment', 'failed'],
            metadata: [
                'payment_id' => $this->payment->id,
                'invoice_number' => $this->payment->invoice_number,
            ],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.payment.failed',
            with: [
                'payment' => $this->payment,
                'enrollment' => $this->payment->enrollment,
                'class' => $this->payment->enrollment->class,
                'invoiceNumber' => $this->payment->invoice_number,
                'amount' => $this->payment->total_amount,
                'reason' => $this->reason ?? 'Pembayaran tidak berhasil diproses',
                'canRetry' => $this->payment->enrollment->status->value === 'pending',
            ],
        );
    }

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
