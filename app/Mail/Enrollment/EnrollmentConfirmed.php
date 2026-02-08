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
 * Email notification saat enrollment dikonfirmasi
 * 
 * Dikirim ke student setelah pembayaran berhasil dan enrollment dikonfirmasi
 * Berisi informasi kelas dan jadwal
 */
class EnrollmentConfirmed extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public Enrollment $enrollment
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
            subject: 'Pendaftaran Dikonfirmasi - ' . $this->enrollment->enrollment_number,
            tags: ['enrollment', 'confirmed'],
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
            markdown: 'emails.enrollment.confirmed',
            with: [
                'enrollment' => $this->enrollment,
                'class' => $this->enrollment->class,
                'program' => $this->enrollment->class->program,
                'schedule' => $this->enrollment->classSchedule,
                'studentName' => $this->enrollment->student_name,
                'enrollmentNumber' => $this->enrollment->enrollment_number,
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
