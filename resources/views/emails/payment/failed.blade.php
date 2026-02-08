<x-mail::message>
# Pembayaran Gagal

Halo,

Kami informasikan bahwa pembayaran Anda **tidak berhasil** diproses.

## Detail Invoice

<x-mail::panel>
**Nomor Invoice:** {{ $invoiceNumber }}  
**Nomor Pendaftaran:** {{ $enrollment->enrollment_number }}  
**Kelas:** {{ $class->name }}  
**Total:** {{ formatCurrency($amount) }}  
**Status:** Gagal
</x-mail::panel>

## Alasan

{{ $reason }}

@if($canRetry)
## Coba Lagi

Anda dapat mencoba melakukan pembayaran kembali dengan membuat invoice baru.

<x-mail::button :url="route('enrollments.show', $enrollment)">
Buat Invoice Baru
</x-mail::button>

## Tips Pembayaran

- Pastikan saldo rekening/e-wallet Anda mencukupi
- Periksa limit transaksi harian Anda
- Gunakan metode pembayaran alternatif jika masalah berlanjut
- Hubungi bank/provider e-wallet Anda jika ada kendala
@else
## Pendaftaran Dibatalkan

Karena pembayaran gagal, pendaftaran Anda telah dibatalkan secara otomatis.

Anda dapat mendaftar kembali kapan saja melalui website kami.

<x-mail::button :url="route('program')">
Lihat Program
</x-mail::button>
@endif

## Butuh Bantuan?

Jika Anda mengalami kesulitan atau memiliki pertanyaan, silakan hubungi kami:
- Email: support@aici-umg.ac.id
- WhatsApp: +62 812-3456-7890

Kami siap membantu Anda!

Terima kasih,  
**{{ config('app.name') }}**
</x-mail::message>
