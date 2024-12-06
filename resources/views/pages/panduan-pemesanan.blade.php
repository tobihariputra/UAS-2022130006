@extends('layouts.app')

@section('content')
    <style>
        .content h2 {
            font-weight: bold;
            margin-bottom: 15px;
        }

        .content p {
            font-size: 1.1rem;
            line-height: 1.8;
        }

        .content ul {
            font-size: 1rem;
            margin-top: 10px;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 30px;
        }

        section {
            margin-bottom: 30px;
            text-align: justify;
        }

        h1 {
            font-size: 2rem;
            color: #2c3e50;
        }

        h2 {
            font-size: 1.5rem;
            color: #e74c3c;
        }

        @media (max-width: 768px) {
            h1 {
                font-size: 1.5rem;
            }

            h2 {
                font-size: 1.3rem;
            }

            .content {
                padding: 20px;
            }

            .card-body {
                padding: 15px;
            }
        }

        @media (max-width: 576px) {
            h1 {
                font-size: 1.3rem;
            }

            h2 {
                font-size: 1.1rem;
            }

            .content {
                padding: 15px;
            }

            .card-body {
                padding: 10px;
            }
        }
    </style>

    <div id="ticket-guide" class="container" style="margin-top: 8%; padding: 20px;">
        <div class="card">
            <div class="card-body">
                <h1 class="text-center fw-bold">PANDUAN PEMESANAN TIKET KERETA</h1>
                <p class="text-center text-muted mb-5">Ikuti langkah-langkah berikut untuk memesan tiket kereta dengan mudah.
                </p>

                <div class="content">
                    <section>
                        <h2>1. Masuk ke Halaman Pemesanan</h2>
                        <p>
                            Untuk memulai pemesanan, buka aplikasi atau website kami dan masuk ke halaman "Pemesanan Tiket"
                            yang dapat Anda temukan di menu utama. Anda akan melihat form pemesanan dengan beberapa pilihan
                            untuk mengisi data yang diperlukan.
                        </p>
                    </section>

                    <section>
                        <h2>2. Pilih Rute dan Jadwal Kereta</h2>
                        <p>
                            Pada halaman pemesanan, pilih stasiun asal dan tujuan Anda. Setelah itu, pilih tanggal
                            keberangkatan yang diinginkan. Sistem kami akan menampilkan berbagai jadwal keberangkatan yang
                            tersedia sesuai dengan pilihan Anda.
                        </p>
                        <p>
                            Pastikan untuk memeriksa kembali jadwal kereta sebelum melanjutkan, karena kereta yang tersedia
                            mungkin beragam sesuai dengan waktu yang Anda pilih.
                        </p>
                    </section>

                    <section>
                        <h2>3. Tentukan Kelas Kereta</h2>
                        <p>
                            Pilih kelas kereta yang diinginkan, apakah kelas ekonomi, bisnis, atau eksekutif. Setiap kelas
                            menawarkan kenyamanan dan fasilitas yang berbeda. Anda dapat memilih sesuai dengan preferensi
                            dan anggaran Anda.
                        </p>
                        <p>
                            Harga tiket akan disesuaikan dengan kelas yang dipilih, jadi pastikan memilih kelas yang sesuai
                            dengan kebutuhan perjalanan Anda.
                        </p>
                    </section>

                    <section>
                        <h2>4. Isi Data Penumpang</h2>
                        <p>
                            Setelah memilih jadwal dan kelas kereta, Anda akan diminta untuk mengisi data diri penumpang.
                            Pastikan untuk mengisi nama lengkap, nomor ID, serta informasi kontak dengan benar agar proses
                            pemesanan berjalan lancar.
                        </p>
                        <p>
                            Anda juga akan diminta untuk memilih kursi, jika tersedia, dan memberi informasi khusus mengenai
                            kebutuhan khusus (misalnya, kursi prioritas atau bantuan mobilitas).
                        </p>
                    </section>

                    <section>
                        <h2>5. Pilih Metode Pembayaran</h2>
                        <p>
                            Setelah semua informasi diisi, Anda akan diminta untuk memilih metode pembayaran. Kami
                            menyediakan berbagai pilihan, termasuk transfer bank, kartu kredit, dan e-wallet yang bisa Anda
                            pilih sesuai kenyamanan Anda.
                        </p>
                        <p>
                            Jika Anda menggunakan kartu kredit atau e-wallet, pastikan Anda memiliki cukup saldo atau limit
                            yang tersedia. Setelah pembayaran diterima, tiket akan langsung dikirimkan melalui email atau
                            aplikasi.
                        </p>
                    </section>

                    <section>
                        <h2>6. Konfirmasi Pemesanan</h2>
                        <p>
                            Sebelum melanjutkan, pastikan untuk memeriksa kembali semua data pemesanan, termasuk detail
                            kereta, jadwal, kelas, dan harga tiket. Jika semuanya sudah benar, klik tombol "Konfirmasi
                            Pemesanan" untuk menyelesaikan proses.
                        </p>
                        <p>
                            Anda akan menerima notifikasi atau email konfirmasi pemesanan yang berisi detail tiket dan QR
                            code yang dapat digunakan saat naik kereta.
                        </p>
                    </section>

                    <section>
                        <h2>7. Cek Tiket dan Persiapkan Perjalanan</h2>
                        <p>
                            Setelah konfirmasi pemesanan, pastikan Anda memeriksa kembali tiket yang telah dipesan. Anda
                            dapat mengunduh tiket atau menyimpannya dalam aplikasi untuk kemudahan saat perjalanan. Jangan
                            lupa untuk membawa identitas yang sesuai dengan nama yang tertera pada tiket.
                        </p>
                        <p>
                            Pastikan Anda datang lebih awal ke stasiun untuk proses check-in dan boarding yang lancar.
                        </p>
                    </section>


                    <section>
                        <h2>8. Bantuan Pelanggan</h2>
                        <p>
                            Jika Anda mengalami kesulitan selama proses pemesanan atau memiliki pertanyaan terkait tiket,
                            jangan ragu untuk menghubungi tim layanan pelanggan kami. Kami siap membantu Anda 24/7 melalui
                            chat, email, atau telepon.
                        </p>
                        <p>
                            Untuk informasi lebih lanjut, kunjungi halaman footer atau hubungi kami di <a
                                href="mailto:support@likmi.com">support@likmi.com</a>.
                        </p>
                    </section>

                    <section>
                        <h2>9. Nikmati Perjalanan Anda</h2>
                        <p>
                            Setelah semua proses selesai, Anda hanya perlu menunggu hari keberangkatan. Nikmati perjalanan
                            Anda dengan tenang, dan pastikan untuk selalu mematuhi peraturan di kereta agar perjalanan Anda
                            lebih nyaman dan aman.
                        </p>
                        <p>
                            Terima kasih telah memilih layanan kami! Semoga perjalanan Anda menyenankan dan selamat sampai
                            tujuan.
                        </p>
                    </section>
                </div>
            </div>
        </div>
    </div>
@endsection
