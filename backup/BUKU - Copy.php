
<?php
include  ('config/koneksi.php');

$db = get_db_conn();
if(isset($_POST['action'])){
	$kode_buku		= $_POST['kode_buku'];
	$judul			= $_POST['judul'];
	$noisbn 		= $_POST['noisbn'];
	$penulis 		= $_POST['penulis'];
	$penerbit 		= $_POST['penerbit'];
	$tahun 			= $_POST['tahun'];
	$stok 			= $_POST['stok'];
	$harga_jual 	= $_POST['harga_jual'];
	$harga_beli 	= $_POST['harga_beli'];
	$ppn 			= $_POST['ppn'];
	$diskon 		= $_POST['diskon'];
	
	if($_POST['action'] == 'save'){
		
			$fl_name = $_FILES['gambar']['name'];
			$size = ($_FILES['gambar']['size'] / 1024);
			$fl_type = $_FILES['gambar']['type'];
			$tmp = $_FILES['gambar']['tmp_name'];
			$path = "gbr/".$fl_name;
			move_uploaded_file($tmp,$path);
		$qr = mysql_query("INSERT INTO buku(kode_buku,judul,noisbn,penulis,penerbit,tahun,stok,harga_jual,harga_beli,ppn,diskon,gambar) 
		values('".$kode_buku."','".$judul."','".$noisbn."' ,'".$penulis."', '".$penerbit."','".$tahun."','".$stok."','".$harga_jual."','".$harga_beli."','".$ppn."','".$diskon."', '".$path."') ");
		echo mysql_error();
	}
	if($_POST['action'] == 'update'){
		$upd = "kode_buku = '".$kode_buku."',judul = '".$judul."',noisbn = '".$noisbn."', penulis = '".$penulis."', penerbit = '".$penerbit."', tahun = '".$tahun."', stok = '".$stok."', harga_jual = '".$harga_jual."', harga_beli = '".$harga_beli."', ppn = '".$ppn."', diskon = '".$diskon."'";
		if(isset($_FILES['gambar']['name'])){	
			$fl_name = $_FILES['gambar']['name'];
			$size = ($_FILES['gambar']['size'] / 1024);
			$fl_type = $_FILES['gambar']['type'];
			$tmp = $_FILES['gambar']['tmp_name'];
			$path = "gbr/".$fl_name;
			move_uploaded_file($tmp,$path);
			$upd .= ", gambar = '".$path."'";
		}
		$qr = mysql_query("UPDATE buku SET ".$upd." WHERE kode_buku ='".$_POST['kode_buku']."' ");
		echo mysql_error();
	}
}
$act = '';
if(isset($_GET['action'])){
	$act = $_GET['action'];
	$kd = $_GET['kd'];
	if($act =='hapus'){
		$qr = mysql_query("DELETE FROM buku WHERE kode_buku='".$kd."' ");
		header("location:buku.php");
	}
	if($act=='edit'){
		$qr = ''; $r ='';
		// 							0	  1		2			3	4			5	6		7	8		9		10			11		
		$qr = mysql_query("SELECT kode_buku,judul,noisbn,penulis,penerbit,tahun,stok,harga_jual,harga_beli,ppn,diskon, gambar FROM buku WHERE kode_buku='".$kd."' ");	
		$r = mysql_fetch_array($qr);
		$ED['kode_buku'] 		= $r[0];
		$ED['judul'] 		= $r[1];
		$ED['noisbn'] 	= $r[2];
		$ED['penulis']= $r[3];
		$ED['penerbit'] 	= $r[4];
		$ED['tahun'] 	= $r[5];
		$ED['stok']= $r[6];
		$ED['harga_jual'] 	= $r[7];
		$ED['harga_beli'] 	= $r[8];
		$ED['ppn']= $r[9];
		$ED['diskon'] 	= $r[10];
		$ED['gambar'] 	= $r[11];
	}
}

$kd_nw = '';

$qr = ''; $sh= ''; $r ='';
// 							0	  1		2			3	4
$qr = mysql_query("SELECT kode_buku,judul,noisbn,penulis,penerbit,tahun,stok,harga_jual,harga_beli,ppn,diskon,gambar FROM buku order by kode_buku ASC"); 
if($qr){
	while($r = mysql_fetch_array($qr)){
		$sh[$r[0]]['kode_buku'] 		= $r[0];
		$sh[$r[0]]['judul'] 		= $r[1];
		$sh[$r[0]]['noisbn'] 		= $r[2];
		$sh[$r[0]]['penulis'] 	= $r[3];
		$sh[$r[0]]['penerbit'] 	= $r[4];
		$sh[$r[0]]['tahun'] 		= $r[5];
		$sh[$r[0]]['stok'] 	= $r[6];
		$sh[$r[0]]['harga_jual'] 	= $r[7];
		$sh[$r[0]]['harga_beli'] 		= $r[8];
		$sh[$r[0]]['ppn'] 	= $r[9];
		$sh[$r[0]]['diskon'] 	= $r[10];
		$sh[$r[0]]['gambar'] 		= $r[11];
	}
	$qr = '';
	$qr = mysql_query("SELECT max(right(kode_buku,4)) FROM buku");
	$q = mysql_fetch_array($qr);
	$kd_new = 'BUK-'.str_pad(($q[0] + 1),4,'0',STR_PAD_LEFT);
}else{
	$kd_new = 'BUK-001';
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Buku</title>

<?php include 'cssin.html' ?>

<body>
 
<!-- menu -->
<?php
	create_header();
?>
<!-- menu -->

</div>


<div class="content">
  <form action="buku.php" enctype="multipart/form-data"method="post">
             
    <?php
   		if($act=='edit'){
			
			
			//ACTION UNTUK UBAH
	?>
	 		 <table border="0" cellspacing="0" cellpadding="10" align="center" width="100%">
       <tr>
          <td colspan="3" ><div align="center"><B>UBAH</B></div></td>
               	<input type="hidden" name="action" id="action" value="update" />
        <input type="hidden" id="old_kode_buku" name="old_kode_buku" value="<?php echo $ED['kode_buku'] ; ?>" />
      
          </tr>
            <tr> 	
 					<tr valign="baseline">
                      <td nowrap="nowrap" align="right">Kode buku</td>
                      <td>:</td>
                      <td> <input type="text" id="kode_buku" name="kode_buku" value="<?php echo $ED['kode_buku'] ; ?>" readonly="readonly"/></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">judul</td>
                      <td>:</td>
                      <td><input type="text" name="judul" id="judul"  value="<?php echo $ED['judul'] ; ?>"/></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">noisbn</td>
                      <td>:</td>
                      <td><input type="text" name="noisbn"id="NOISBN" value="<?php echo $ED['noisbn'] ; ?>"  /></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">penulis</td>
                      <td>:</td>
                      <td><input type="text" name="penulis" id="penulis" value="<?php echo $ED['penulis'] ; ?>"  /></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">penerbit</td>
                      <td>:</td>
                      <td><input type="text" name="penerbit" id="penerbit" value="<?php echo $ED['penerbit'] ; ?>"  /></td>
                    </tr>
					<tr valign="baseline">
                      <td nowrap="nowrap" align="right">tahun</td>
                      <td>:</td>
                      <td><input type="text" name="tahun" id="tahun" value="<?php echo $ED['tahun'] ; ?>"  /></td>
                    </tr>
					<tr valign="baseline">
                      <td nowrap="nowrap" align="right">stok</td>
                      <td>:</td>
                      <td><input type="text" name="stok" id="stok" value="<?php echo $ED['stok'] ; ?>"  /></td>
                    </tr>
					<tr valign="baseline">
                      <td nowrap="nowrap" align="right">hargajual</td>
                      <td>:</td>
                      <td><input type="text" name="harga_jual" id="harga_jual" value="<?php echo $ED['harga_jual'] ; ?>"  /></td>
                    </tr>
					<tr valign="baseline">
                      <td nowrap="nowrap" align="right">hargabeli</td>
                      <td>:</td>
                      <td><input type="text" name="harga_beli" id="harga_beli"value="<?php echo $ED['harga_beli'] ; ?>"  /></td>
                    </tr>
					<tr valign="baseline">
                      <td nowrap="nowrap" align="right">ppn</td>
                      <td>:</td>
                      <td><input type="text" name="ppn" id="ppn"value="<?php echo $ED['ppn'] ; ?>"  /></td>
                    </tr>
					<tr valign="baseline">
                      <td nowrap="nowrap" align="right">diskon</td>
                      <td>:</td>
                      <td><input type="text" name="diskon" id="diskon"value="<?php echo $ED['diskon'] ; ?>"  /></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Gambar</td>
                      <td>:</td>
                      <td><input type="file" name="gambar" id="gambar" value="<?php echo $ED['merk'] ; ?>"  /></td>
                    </tr>
                    <tr valign="baseline">
                     
                      <td colspan="3"><div align="center"><input type="submit" value="Ubah Data" /></div></td>
                    </tr>
                </form>
                 
       </table>
    <?php	
		}else{
			
			
			
			
			//ACTION UNTUK TAMBAH
	?>
 
    <div class="tampil" >
    <img src="img/newdata.png" />TAMBAH DATA</div>
    <div class="sembunyi">
 	<table border="0" cellspacing="0" cellpadding="10" align="center" width="100%"  >
                 <tr>
          <td colspan="3" ><div align="center"><B>TAMBAH DATA</B></div></td>
          <input type="hidden" name="action" id="action" value="save" />
          </tr>
            <tr> 	
 					<tr valign="baseline" >
                      <td width="29%" align="right" nowrap="nowrap">Kode buku</td>
                      <td width="2%">:</td>
                      <td width="69%"><input type="text" id="kode_buku" name="kode_buku" required="required" value="<?php echo $kd_new; ?>" readonly="readonly" /></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">judu</td>
                      <td>:</td>
                      <td><input type="text" name="judul"id="judul" value="" required="required" /></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">noisbn</td>
                      <td>:</td>
                      <td><input type="text" name="noisbn"id="noisbn" value=""  required="required"/></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">penulis</td>
                      <td>:</td>
                      <td><input type="text" name="penulis" id="penulis"value=""  required="required"/></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">penerbit</td>
                      <td>:</td>
                      <td><input type="text" name="penerbit" id="penerbit"value="" required="required"  /></td>
                    </tr>
					  <tr valign="baseline">
                      <td nowrap="nowrap" align="right">tahun</td>
                      <td>:</td>
                      <td><input type="text" name="tahun" id="tahun"value="" required="required" /></td>
                    </tr>
					                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">stok</td>
                      <td>:</td>
                      <td><input type="text" name="stok" id="stok"value="" required="required" /></td>
                    </tr>
					  <tr valign="baseline">
                      <td nowrap="nowrap" align="right">harga jual</td>
                      <td>:</td>
                      <td><input type="text" name="harga_jual" id="harga_jual"value="" required="required" /></td>
                    </tr>
					  <tr valign="baseline">
                      <td nowrap="nowrap" align="right">harga beli</td>
                      <td>:</td>
                      <td><input type="text" name="harga_beli" id="harga_beli"value="" required="required" /></td>
                    </tr>
					  <tr valign="baseline">
                      <td nowrap="nowrap" align="right">ppn</td>
                      <td>:</td>
                      <td><input type="text" name="ppn" id="ppn"value="" required="required" /></td>
                    </tr>
		              <tr valign="baseline">
                      <td nowrap="nowrap" align="right">diskon</td>
                      <td>:</td>
                      <td><input type="text" name="diskon" id="diskon"value="" required="required" /></td>
                    </tr>			
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Gambar</td>
                      <td>:</td>
                      <td><input type="file" name="gambar" id="gambar"  required="required" /></td>
                    </tr>
                    <tr valign="baseline">
                      <td colspan="3"><div align="center"><input type="submit" value="Tambah" /></div></td>
                    </tr>
                  </table>
                  </div>
                  
                  <?php $kd_new++; }?>
                </form>





                
               
                    
                  <?php
      	if($sh){
			foreach($sh as $n => $v){
				?>
      
        <div class="buku">
          
          <!--GAMBAR --><img src="<?=$v['gambar'];?>"  /></a>
          <!--noisb -->     <p class="judulbuku"><?=$v['judul'];?></p>
          <!--KODE BUKU --> <p class="p1">Kode Buku   </p><p class="p2"><?=$v['kode_buku']; ?>
          <!--noisb -->     <p class="p1">NOISBN BUKU </p><p class="p2"> <?=$v['noisbn'];?></p>
          <!--penulis -->   <p class="p1">PENULIS     </p><p class="p2"><?=$v['penulis'];?></p>
          <!--penerbit -->  <p class="p1">PENERBIT    </p><p class="p2"><?=$v['penerbit'];?></p>
          <!--tahun -->     <p class="p1">TAHUN       </p><p class="p2"><?=$v['tahun'];?></p>
          <!--stok-->       <p class="p1">STOK        </p><p class="p2"> <?=$v['stok'];?> buah </p>
          <!--harga jual --><p class="p1">HARGA JUAL  </p><p class="p2"><?=$v['harga_jual'];?></p>
          <!--harga beli--> <p class="p1">HARGA BELI  </p><p class="p2">Rp. <?=$v['harga_beli'];?></p>
          <!--ppn -->       <p class="p1">PPN         </p><p class="p2"><?=$v['ppn'];?></p>
          <!--diskon -->    <p class="p1">DISKON      </p><p class="p2"><?=$v['diskon'];?></p>
<a href="buku.php?action=edit&kd=<?php echo $v['kode_buku']; ?>">Edit</a>
        <a href="javascript:if (confirm('Anda Yakin Untuk Menghapus Data?'))
             {  window.location.href='buku.php?action=hapus&kd=<?php echo $v['kode_buku']; ?>' }
              else { volid('') };">Delete</a>
        </div>
 
            <?php 
			}
		}else{
			echo '<td colspan="14"><div align="center"><b>Maaf Tidak ada data untuk ditampilkan</b><td> ';	
		}

	  ?> 
  
</div>

<div class="footer">
  <img src="img/facebook.png">
  <img src="img/instagram.png">
  <img src="img/twitter.png">
  <img src="img/google-plus.png">

  <p>ini footer nya guys, isi sendiri ya , he..he..he..</p>

  <div class="ft">Copyright 2016</div>

</div>

</body>
</html>