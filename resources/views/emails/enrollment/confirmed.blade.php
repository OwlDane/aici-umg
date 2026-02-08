<x-mail::message>
# Selamat! Pendaftaran Anda Dikonfirmasi 🎉

Halo **{{ $studentName }}**,

Pembayaran Anda telah dikonfirmasi dan pendaftaran Anda telah **BERHASIL**.

## Detail Pendaftaran

<x-mail::panel>
**Nomor Pendaftaran:** {{ $enrollmentNumber }}  
**Program:** {{ $program->name }}  
**Kelas:** {{ $class->name }}  
**Status:** Terkonfirmasi ✓
</x-mail::panel>

@if($schedule)
## Jadwal Kelas

<x-mail::table>
| Hari | Waktu | Lokasi |
|:-----|:------|:-------|
| {{ $schedule->day_of_week }} | {{ $schedule->start_time }} - {{ $schedule->end_time }} | {{ $schedule->location ?? 'TBA' }} |
</x-mail::table>
@endif

## Persiapan Kelas

Berikut beberapa hal yang perlu Anda persiapkan:
- Laptop/komputer untuk pembelajaran
- Koneksi internet yang stabil
- Alat tulis dan buku catatan
- Semangat belajar yang tinggi!

<x-mail::button :url="route('enrollments.show', $enrollment)">
Lihat Detail Lengkap
</x-mail::button>

Kami tunggu kehadiran Anda di kelas!

Terima kasih,  
**{{ config('app.name') }}**
</x-mail::message>
