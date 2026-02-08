<x-mail::message>
# Pendaftaran Berhasil!

Halo **{{ $studentName }}**,

Terima kasih telah mendaftar di **AICI-UMG**. Pendaftaran Anda telah berhasil dibuat.

## Detail Pendaftaran

<x-mail::panel>
**Nomor Pendaftaran:** {{ $enrollmentNumber }}  
**Program:** {{ $program->name }}  
**Kelas:** {{ $class->name }}  
**Biaya:** {{ formatCurrency($class->price) }}
</x-mail::panel>

## Langkah Selanjutnya

Untuk menyelesaikan pendaftaran, silakan lakukan pembayaran melalui link yang akan kami kirimkan dalam email terpisah.

Setelah pembayaran dikonfirmasi, Anda akan menerima email konfirmasi dengan detail jadwal kelas.

<x-mail::button :url="route('enrollments.show', $enrollment)">
Lihat Detail Pendaftaran
</x-mail::button>

## Butuh Bantuan?

Jika Anda memiliki pertanyaan, jangan ragu untuk menghubungi kami:
- Email: support@aici-umg.ac.id
- WhatsApp: +62 812-3456-7890

Terima kasih,  
**{{ config('app.name') }}**
</x-mail::message>
