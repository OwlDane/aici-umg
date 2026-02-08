<?php

namespace App\Mail\Enrollment;

use App\Models\Enrollment;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Queue\SerializesModels;

/**
 * Email notification saat enrollment dibatalkan
 * 
 * Dikirim ke student setelah enrollment dibatalkan
 * Berisi informasi pembatalan dan instruksi refund (jika ada)
 */
class EnrollmentCancelled extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public Enrollment $enrollment,
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
            subject: 'Pendaftaran Dibatalkan - ' . $this->enrollment->enrollment_number,
            tags: ['enrollment', 'cancelled'],
            metadata: [
                'enrollment_id' => $this->enrollment->id,
                'enrollment_number' => $this->enrollment->enrollment_number,
            ],
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            markdown: 'emails.enrollment.cancelled',
            with: [
                'enrollment' => $this->enrollment,
                'class' => $this->enrollment->class,
                'program' => $this->enrollment->class->program,
                'studentName' => $this->enrollment->student_name,
                'enrollmentNumber' => $this->enrollment->enrollment_number,
                'reason' => $this->reason ?? $this->enrollment->cancellation_reason,
                'hasPayment' => $this->enrollment->payment && $this->enrollment->payment->isPaid(),
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
