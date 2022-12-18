<?php
include  ('config/koneksi.php');
$db = get_db_conn();

//file yang dipanggil HargaMotor.js
//untuk Mengambil harga Motor pada saat Combo Box Motor terpilih
$kode_buku = $_GET['kode_buku'];
$sql = mysql_query("select harga_jual from buku where kode_buku = '$kode_buku'");
$i = 1;
$harga = mysql_fetch_array($sql);
echo $harga['harga_jual'];
?>