<x-mail::message>
# Invoice Pembayaran

Halo,

Invoice pembayaran untuk pendaftaran Anda telah dibuat.

## Detail Invoice

<x-mail::panel>
**Nomor Invoice:** {{ $invoiceNumber }}  
**Nomor Pendaftaran:** {{ $enrollment->enrollment_number }}  
**Kelas:** {{ $class->name }}  
**Total Pembayaran:** {{ formatCurrency($amount) }}
</x-mail::panel>

## Batas Waktu Pembayaran

<x-mail::panel>
Invoice ini akan **kadaluarsa** pada:  
**{{ formatDateTime($expiredAt) }}**

Mohon selesaikan pembayaran sebelum batas waktu.
</x-mail::panel>

## Cara Pembayaran

Klik tombol di bawah untuk melakukan pembayaran melalui berbagai metode:
- Transfer Bank (BCA, Mandiri, BNI, BRI)
- E-Wallet (OVO, GoPay, Dana, LinkAja)
- QRIS
- Kartu Kredit/Debit
- Retail Outlet (Alfamart, Indomaret)

<x-mail::button :url="$paymentUrl" color="success">
Bayar Sekarang
</x-mail::button>

## Penting!

- Pastikan Anda menyelesaikan pembayaran sebelum batas waktu
- Setelah pembayaran berhasil, Anda akan menerima email konfirmasi
- Simpan nomor invoice untuk referensi

Jika ada pertanyaan, hubungi kami di support@aici-umg.ac.id

Terima kasih,  
**{{ config('app.name') }}**
</x-mail::message>
