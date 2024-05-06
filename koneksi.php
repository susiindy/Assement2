<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pengaduan";

// Membuat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Memeriksa koneksi
if ($conn->connect_error) {
    die("Koneksi gagal: " . $conn->connect_error);
}

// Jika terdapat parameter 'id' dalam URL, maka proses penghapusan data
if(isset($_GET['id'])) {
    // Mendapatkan ID form yang akan dihapus dari parameter URL
    $id= $_GET['id'];

    // Query untuk menghapus data dari tabel berdasarkan ID form
    $sql = "DELETE FROM pengaduan WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(array("message" => "Data berhasil dihapus"));
    } else {
        echo json_encode(array("error" => "Error: " . $sql . "<br>" . $conn->error));
    }
} else {
    // Query untuk mengambil data dari tabel
    $sql = "SELECT id, subjek, deskripsi, status_deskripsi, tanggal_pengaduan, tanggal_pembaruan, pelapor_nama, pelapor_email, departemen_terkait, catatan, lampiran FROM pengaduan";
    $result = $conn->query($sql);

    // Membuat array untuk menyimpan data
    $data = array();

    // Mengambil setiap baris hasil query dan menambahkannya ke dalam array
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }

    // Mengubah array menjadi format JSON dan mencetaknya
    echo json_encode($data);
}

?>