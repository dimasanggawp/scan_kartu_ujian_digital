# scan_kartu_ujian_digital
Aplikasi Scan Kartu Ujian ini adalah aplikasi berbasis web yang memanfaatkan library html5-qrcode untuk memindai QR Code pada kartu peserta ujian secara langsung melalui kamera perangkat. Setelah QR berhasil terbaca, aplikasi menampilkan dialog konfirmasi menggunakan SweetAlert sebelum mengirimkan data peserta ke server.

Saat petugas menekan tombol “Kirim data sekarang?”, aplikasi melakukan AJAX request ke endpoint backend (/proses/{decodedText}) untuk memproses data peserta. Jika backend mengembalikan informasi peserta, sistem otomatis melakukan request kedua ke API WhatsApp untuk mengirimkan pesan konfirmasi ke nomor peserta yang diambil dari respons backend. Semua proses — mulai dari pemindaian, konfirmasi, pengiriman ke server, hingga notifikasi WhatsApp — terjadi secara instan tanpa perlu memuat ulang halaman.

Fitur yang terimplementasi dalam kode:
1. Pemindaian QR Code real-time dengan Html5QrcodeScanner (fps 10, jendela pemindaian 250 px).
2. Dialog interaktif SweetAlert sebelum data dikirim.
3. Pengiriman data peserta ke backend melalui AJAX GET.
4. Integrasi otomatis dengan WhatsApp API menggunakan fetch POST untuk mengirim pesan ke peserta.
5. Logging console untuk debugging setiap tahap (hasil scan, URL proses, response backend, response WhatsApp).

Aplikasi ini mendukung proses check-in ujian secara cepat, aman, dan efisien, sekaligus memberikan notifikasi otomatis kepada peserta setelah datanya tercatat.
