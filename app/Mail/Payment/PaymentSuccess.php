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
 * Email notification saat pembayaran berhasil
 * 
 * Dikirim ke student setelah pembayaran dikonfirmasi oleh Xendit
 * Berisi receipt dan informasi kelas
 */
class PaymentSuccess extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public Payment $payment
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
            subject: 'Pembayaran Berhasil - ' . $this->payment->invoice_number,
            tags: ['payment', 'success'],
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
            markdown: 'emails.payment.success',
            with: [
                'payment' => $this->payment,
                'enrollment' => $this->payment->enrollment,
                'class' => $this->payment->enrollment->class,
                'program' => $this->payment->enrollment->class->program,
                'invoiceNumber' => $this->payment->invoice_number,
                'amount' => $this->payment->total_amount,
                'paidAt' => $this->payment->paid_at,
                'paymentMethod' => $this->payment->payment_method,
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
