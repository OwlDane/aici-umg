<x-mail::message>
# Pendaftaran Dibatalkan

Halo **{{ $studentName }}**,

Pendaftaran Anda dengan nomor **{{ $enrollmentNumber }}** telah dibatalkan.

## Detail Pendaftaran

<x-mail::panel>
**Nomor Pendaftaran:** {{ $enrollmentNumber }}  
**Program:** {{ $program->name }}  
**Kelas:** {{ $class->name }}  
**Status:** Dibatalkan
</x-mail::panel>

@if($reason)
## Alasan Pembatalan

{{ $reason }}
@endif

@if($hasPayment)
## Informasi Refund

Karena Anda telah melakukan pembayaran, proses refund akan diproses dalam 7-14 hari kerja.

Dana akan dikembalikan ke metode pembayaran yang sama dengan yang Anda gunakan.

Anda akan menerima email konfirmasi setelah refund berhasil diproses.
@endif

## Ingin Mendaftar Lagi?

Anda dapat mendaftar kembali kapan saja melalui website kami.

<x-mail::button :url="route('program')">
Lihat Program Lainnya
</x-mail::button>

Jika ada pertanyaan, silakan hubungi kami di support@aici-umg.ac.id

Terima kasih,  
**{{ config('app.name') }}**
</x-mail::message>
