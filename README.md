### Extra Question

1.  Bagaimana cara menggunakan API untuk mengimplementasikan validasi input pada
    formulir atau fitur input yang ada di online shop? Sebutkan setidaknya dua jenis
    validasi yang akan diterapkan dan cara melakukannya.

        _ANSWER_

        * Validasi Server-Side: Kirimkan data input pengguna ke server melalui API untuk validasi, misalnya: validasi email menggunakan regex dan memeriksa apakah email sudah terdaftar di database.

        * Validasi Client-Side: Gunakan respons API untuk memberikan feedback langsung, misalnya: jika stok barang habis, API akan mengembalikan error dan formulir menampilkan pesan kesalahan.

2.  Jelaskan implementasi mekanisme autentikasi pengguna dalam proyek online shop
    menggunakan API. Apa saja informasi yang akan disimpan terkait akun pengguna,
    dan bagaimana memastikan keamanan autentikasi?

        _ANSWER_

         * Informasi yang Disimpan: Username/email, password yang di-hash (misalnya dengan bcrypt), token autentikasi (seperti JWT), dan metadata seperti tanggal pendaftaran.

        * Keamanan: Gunakan HTTPS, hash password dengan algoritma kuat, dan implementasikan token-based authentication (JWT) dengan expiry time. Tambahkan mekanisme refresh token untuk perpanjangan sesi sehingga tidak perlu lagi melakukan login ulang ke aplikasi.

3.  Bagaimana merencanakan penggunaan API untuk mengintegrasikan fungsi sorting
    dan searching pada online shop? Jelaskan langkah-langkah atau algoritma yang akan
    diterapkan. Selain itu, bagaimana memastikan bahwa semua operasi CRUD (Create,
    Read, Update, Delete) berjalan dengan lancar dan aman?

            _ANSWER_:

             * Langkah-Langkah:

            - API menerima parameter query seperti sort_by (misal: harga, popularitas) dan search (misal: nama produk).
            - Di backend menggunakan query database yang dioptimalkan (misal: ORDER BY untuk sorting dan LIKE atau full-text search untuk pencarian).

            * CRUD

            - Create/Update: Validasi tiap input dan sanitasi data yang dikirim dari frontend sebelum menyimpannya. Jika di laravel kita bisa menggunakan `Validator`
            - Read: Batasi data yang dikembalikan dengan menggunakan pagination dan filtering.
            - Delete: Gunakan soft delete untuk menghindari kehilangan data permanen.
            - Menerapkan otentikasi dan otorisasi untuk memastikan hanya pengguna yang berwenang yang dapat melakukan operasi tertentu.
