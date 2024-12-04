@extends('layouts.app')

@section('content')
    <style>
        /* General Styling */
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

        /* Card Styling */
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 30px;
        }

        /* Section Styling */
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

        /* Responsive Styling */
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

    <div id="privacy-policy" class="container" style="margin-top: 8%; padding: 20px;">
        <div class="card">
            <div class="card-body">
                <h1 class="text-center font-weight-bold">KEBIJAKAN DAN PRIVASI</h1>
                <p class="text-center text-muted mb-5">Sistem Pemesanan Tiket Kereta</p>

                <div class="content">
                    <section>
                        <h2>1. Pengumpulan Informasi</h2>
                        <p>
                            Kami mengumpulkan berbagai informasi dari pengguna, termasuk nama, alamat email, nomor telepon,
                            serta informasi pembayaran untuk memastikan pemesanan tiket dapat diproses dengan cepat dan
                            efisien. Data ini digunakan secara eksklusif untuk tujuan pemrosesan transaksi dan verifikasi
                            identitas. Kami menjamin bahwa informasi Anda tidak akan disalahgunakan atau dibagikan kepada
                            pihak ketiga tanpa izin eksplisit dari Anda. Informasi juga digunakan untuk menyediakan fitur
                            yang lebih personal, seperti pengingat jadwal perjalanan atau rekomendasi rute perjalanan yang
                            sering dipilih.
                        </p>
                        <p>
                            Kami juga dapat mengumpulkan data terkait lokasi untuk memberikan layanan berbasis lokasi,
                            seperti mencari stasiun kereta terdekat atau melihat jadwal kereta secara real-time.
                        </p>
                    </section>

                    <section>
                        <h2>2. Penggunaan Informasi</h2>
                        <p>Data yang kami kumpulkan digunakan untuk berbagai keperluan yang bermanfaat bagi pengguna:</p>
                        <ul>
                            <li>Memproses pemesanan tiket dan mengirimkan konfirmasi serta informasi terkait secara
                                elektronik.</li>
                            <li>Menghubungi pengguna untuk memberikan notifikasi penting, seperti perubahan jadwal
                                keberangkatan atau pembatalan perjalanan yang mungkin mempengaruhi pemesanan mereka.</li>
                            <li>Menyediakan penawaran khusus atau diskon berdasarkan riwayat pemesanan dan preferensi
                                pengguna untuk meningkatkan pengalaman perjalanan Anda.</li>
                            <li>Mengirimkan pemberitahuan terkait fitur baru, perbaikan sistem, atau pengumuman penting
                                lainnya yang dapat meningkatkan kenyamanan pengguna.</li>
                            <li>Melakukan analisis tren dan preferensi perjalanan untuk menawarkan rekomendasi atau paket
                                perjalanan yang lebih relevan dengan kebutuhan Anda.</li>
                        </ul>
                    </section>

                    <section>
                        <h2>3. Perlindungan Data</h2>
                        <p>
                            Keamanan data pengguna adalah prioritas utama kami. Kami menggunakan teknologi enkripsi SSL
                            untuk melindungi transaksi keuangan Anda dan memastikan bahwa informasi pribadi tetap aman
                            selama transmisi. Selain itu, akses ke data pribadi Anda hanya diberikan kepada personel yang
                            memerlukan akses untuk melakukan tugas mereka, dan seluruh sistem kami dilindungi oleh firewall
                            yang kuat.
                        </p>
                        <p>
                            Walaupun kami berusaha sebaik mungkin untuk menjaga data Anda, kami tidak dapat menjamin 100%
                            perlindungan terhadap akses yang tidak sah, terutama yang disebabkan oleh kelalaian Anda dalam
                            menjaga kerahasiaan akun dan kata sandi. Oleh karena itu, penting bagi Anda untuk tidak
                            membagikan informasi login Anda dengan pihak lain dan untuk mengubah kata sandi secara berkala.
                        </p>
                        <div class="alert alert-info" role="alert">
                            <strong>Penting:</strong> Jangan berbagi informasi login Anda dengan siapa pun!
                        </div>
                    </section>

                    <section>
                        <h2>4. Cookie dan Teknologi Pelacakan</h2>
                        <p>
                            Kami menggunakan cookie untuk meningkatkan pengalaman Anda saat mengakses situs kami. Cookie
                            membantu kami memahami preferensi pengguna dan menyediakan konten yang lebih relevan. Teknologi
                            pelacakan ini juga memungkinkan kami untuk mengoptimalkan kinerja situs dan menyesuaikan
                            fungsionalitasnya dengan kebutuhan pengguna.
                        </p>
                        <p>
                            Anda memiliki kontrol penuh atas pengaturan cookie melalui pengaturan browser Anda. Meskipun
                            Anda dapat menonaktifkan cookie, harap dicatat bahwa beberapa fitur atau fungsi situs kami
                            mungkin tidak berfungsi dengan baik jika cookie dinonaktifkan.
                        </p>
                    </section>

                    <section>
                        <h2>5. Hak Pengguna</h2>
                        <p>Sebagai pengguna, Anda memiliki sejumlah hak yang dapat Anda manfaatkan terkait dengan data
                            pribadi Anda:</p>
                        <ul>
                            <li>Meminta akses ke informasi pribadi yang kami simpan mengenai Anda dan memperbarui data
                                tersebut jika ada perubahan.</li>
                            <li>Meminta penghapusan data pribadi setelah transaksi selesai, kecuali apabila data tersebut
                                diperlukan untuk kepentingan hukum yang sah.</li>
                            <li>Mengajukan keluhan atau permintaan terkait penggunaan data pribadi Anda kepada kami.</li>
                            <li>Menarik izin Anda untuk memproses data pribadi Anda kapan saja, dengan catatan bahwa
                                beberapa layanan tertentu memerlukan data tersebut untuk dapat berfungsi.</li>
                        </ul>
                    </section>

                    <section>
                        <h2>6. Perubahan Kebijakan</h2>
                        <p>
                            Kami berhak untuk memperbarui kebijakan privasi ini dari waktu ke waktu. Setiap perubahan akan
                            diberitahukan kepada Anda melalui email atau melalui notifikasi yang dapat dilihat pada aplikasi
                            atau situs kami. Dengan melanjutkan penggunaan layanan kami setelah perubahan kebijakan
                            diberlakukan, Anda dianggap telah menerima kebijakan privasi yang telah diperbarui.
                        </p>
                        <p>
                            Kami menyarankan Anda untuk memeriksa halaman ini secara berkala agar tetap mendapatkan
                            informasi terbaru mengenai kebijakan privasi kami.
                        </p>
                    </section>

                    <section>
                        <h2>7. Kontak</h2>
                        <p>
                            Jika Anda memiliki pertanyaan lebih lanjut atau ingin memberikan umpan balik terkait kebijakan
                            privasi ini, Anda dapat menghubungi tim dukungan pelanggan kami melalui halaman kontak kami.
                            Kami akan dengan senang hati
                            memberikan penjelasan lebih lanjut mengenai kebijakan ini.
                        </p>
                    </section>

                    <section>
                        <h2>8. Penyimpanan Data</h2>
                        <p>
                            Data pengguna disimpan dalam database yang aman dan hanya dapat diakses oleh pihak yang memiliki
                            otorisasi. Kami akan menyimpan data Anda selama periode yang diperlukan untuk memenuhi tujuan
                            pengumpulan data tersebut, atau selama yang diwajibkan oleh hukum yang berlaku. Setelah itu,
                            data akan dihapus atau dianonimkan agar tidak dapat diidentifikasi kembali.
                        </p>
                        <p>
                            Kami juga memastikan bahwa setiap data yang tidak lagi diperlukan akan dimusnahkan dengan cara
                            yang aman untuk mencegah penyalahgunaan informasi pribadi.
                        </p>
                    </section>

                    <section>
                        <h2>9. Transfer Data</h2>
                        <p>
                            Jika ada perubahan dalam struktur perusahaan kami, seperti merger atau akuisisi, data pribadi
                            Anda mungkin akan dipindahkan ke pihak ketiga yang terlibat dalam proses tersebut. Kami akan
                            memberi tahu Anda tentang perubahan tersebut dan memastikan bahwa data Anda tetap dilindungi
                            sesuai dengan kebijakan privasi yang ada.
                        </p>
                        <p>
                            Kami juga dapat mengungkapkan data Anda jika diminta oleh pihak berwenang, seperti untuk
                            memenuhi kewajiban hukum atau untuk melindungi hak dan keselamatan kami atau orang lain.
                        </p>
                    </section>

                    <section>
                        <h2>10. Tanggung Jawab Pengguna</h2>
                        <p>
                            Sebagai pengguna layanan kami, Anda memiliki tanggung jawab untuk menjaga kerahasiaan informasi
                            akun Anda dan untuk memastikan bahwa informasi yang Anda berikan adalah akurat dan lengkap. Anda
                            juga diharapkan untuk segera memberitahukan kami jika ada perubahan dalam data pribadi Anda atau
                            jika Anda mencurigai adanya penyalahgunaan akun Anda.
                        </p>
                        <p>
                            Kami juga menghimbau Anda untuk tidak menggunakan layanan kami untuk tujuan yang melanggar hukum
                            atau merugikan pihak lain. Penggunaan yang tidak sah atau melanggar kebijakan dapat
                            mengakibatkan penghentian akses ke layanan kami.
                        </p>
                    </section>
                </div>
            </div>
        </div>
    </div>
@endsection
