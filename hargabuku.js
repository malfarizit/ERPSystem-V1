// JavaScript Document
//Kelfin Eka Putra Wardani

function harga_	jual(){
	var KodeBUK = document.getElementById('kode_buku');
	var kode_buku = KodeBUK.value;
    var url = "hargabuku.php?kode_buku=" + kode_buku;
    //ambilData(url, "formHarga");
	ambilData(url, "harga_jual");
	}