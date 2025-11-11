<< Saya, Umarex Shauma Andromeda, dengan NIM 2400598, mengerjakan TP7 dalam mata kuliah Desain dan Pemrograman Berorientasi Objek. Untuk keberkahan-Nya, maka saya tidak akan melakukan kecurangan seperti yang telah dispesifikasi >>

1. Tema Website

   Tema websitenya adalah "Sports Rental", jadinya sistem peminjaman alat-alat olahraga. Admin dapat melakukan CRUD (Create, Read, Update, Delete) terhadapa data yang ada di db seperti tabel **members**, **equipments**, sama **rentals**.
   
2. Database

   Database yg digunakan bernama **sportsrental_db** yang berfusngis untuk menyimpan seluruh data terkait sistem peminjaman alat olahraga. Database memiliki 3 tabel. Yaitu, **equipments**, **members**, **rentals**.
   
   a. **equipments**
      tabel equipments menimpan informasi tentang alat olahraga yang tersedia. Kolomnya ada:
   - id -> primary key. Dibuat auto increment biar smua alat memiliki kode unik.
   - name -> nama alat olahraga.
   - type -> jenis penggunaan alat (disini aku pakenya indoor/ outdoor).
   - brand -> merek alat olahraganya.
   - stock -> jumlah stock alat yang tersedia
      
   b. **members**
      tabel members berisi data pengguna yang dapat meminjam alat olahraga. Kolomnya ada:
   - id -> primary key. Dibuat auto increment biar smua member memiliki kode unik.
   - name -> nama anggota
   - email -> email anggota
   - phone -> no. telp anggota
   
   c. **rentals**
      tabel rentals menyimpan data peminjaman antara member dan alat olahraga. Kolomnya ada:
   - id -> primary key. Dibuat auto increment biar smua peminjaman memiliki kode unik.
   - equipment_id -> ngambil dari equipments.id (foreign key)
   - member_id -> ngambil dr members.id (foreign key)
   - rent_date -> tanggal alat dipinjam
   - return_date -> tanggal alat dikembalikan

     **Relasi antar tabel**:
     - **members -> rentals**
       One-to-many. Satu member bisa melakukan banyak peminjaman.
       
     - **equipments -> rentals**
       One-to-many. Satu alat bisa dipinjam oleh banyak member.

3. Flowcode
   
   
4. Dokumentasi


https://github.com/user-attachments/assets/6dba9c13-0384-4330-9f9e-8f9acb5c9e90




