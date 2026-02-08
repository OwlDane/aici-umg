<x-mail::message>
# Pembayaran Berhasil! ✓

Halo,

Pembayaran Anda telah **BERHASIL** dikonfirmasi.

## Detail Pembayaran

<x-mail::panel>
**Nomor Invoice:** {{ $invoiceNumber }}  
**Nomor Pendaftaran:** {{ $enrollment->enrollment_number }}  
**Program:** {{ $program->name }}  
**Kelas:** {{ $class->name }}  
**Total Dibayar:** {{ formatCurrency($amount) }}  
**Metode Pembayaran:** {{ ucwords(str_replace('_', ' ', $paymentMethod)) }}  
**Tanggal Pembayaran:** {{ formatDateTime($paidAt) }}
</x-mail::panel>

## Status Pendaftaran

Pendaftaran Anda telah dikonfirmasi dan Anda akan segera menerima email terpisah dengan detail jadwal kelas.

<x-mail::button :url="route('payments.show', $payment)">
Lihat Receipt
</x-mail::button>

## Langkah Selanjutnya

1. Cek email konfirmasi pendaftaran untuk detail jadwal
2. Persiapkan peralatan belajar Anda
3. Bergabung dengan grup kelas (link akan dikirim terpisah)
4. Hadir tepat waktu di hari pertama kelas

## Simpan Email Ini

Email ini adalah bukti pembayaran resmi Anda. Simpan untuk referensi di masa mendatang.

Terima kasih atas kepercayaan Anda!

**{{ config('app.name') }}**
</x-mail::message>
