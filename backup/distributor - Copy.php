
<?php
include  ('config/koneksi.php');

$db = get_db_conn();
if(isset($_POST['action'])){
	$kode_distributor	= $_POST['kode_distributor'];
	$nama_distributor	= $_POST['nama_distributor'];
	$alamatdistri 	= $_POST['alamatdistri'];
	$telpondistri 	= $_POST['telpondistri'];
	
	if($_POST['action'] == 'save'){
			$qr = mysql_query("INSERT INTO distributor(kode_distributor,nama_distributor,alamatdistri,telpondistri) 
		values('".$kode_distributor."','".$nama_distributor."','".$alamatdistri."' ,'".$telpondistri."') ");
		echo mysql_error();
	}
	if($_POST['action'] == 'update'){
		$upd = "kode_distributor = '".$kode_distributor."',nama_distributor = '".$nama_distributor."',alamatdistri = '".$alamatdistri."', telpondistri = '".$telpondistri."'";
		$qr = mysql_query("UPDATE distributor SET ".$upd." WHERE kode_distributor ='".$_POST['old_kode_distributor']."' ");
		echo mysql_error();
	}
}
$act = '';
if(isset($_GET['action'])){
	$act = $_GET['action'];
	$kd = $_GET['kd'];
	if($act =='hapus'){
		$qr = mysql_query("DELETE FROM distributor WHERE kode_distributor='".$kd."' ");
		header("location:distributor.php");
	}
	if($act=='edit'){
		$qr = ''; $r ='';
		// 							0	  1		2			3	4
		$qr = mysql_query("SELECT kode_distributor,nama_distributor,alamatdistri,telpondistri FROM distributor WHERE kode_distributor='".$kd."' ");	
		$r = mysql_fetch_array($qr);
		$ED['kode_distributor'] 		= $r[0];
		$ED['nama_distributor'] 		= $r[1];
		$ED['alamatdistri'] 	= $r[2];
		$ED['telpondistri']= $r[3];
		}
}


$qr = ''; $sh= ''; $r ='';
// 							0	  1		2			3	4
$qr = mysql_query("SELECT kode_distributor,nama_distributor,alamatdistri,telpondistri FROM distributor order by kode_distributor ASC"); 
if($qr){
	while($r = mysql_fetch_array($qr)){
		$sh[$r[0]]['kode_distributor'] 		= $r[0];
		$sh[$r[0]]['nama_distributor'] 		= $r[1];
		$sh[$r[0]]['alamatdistri'] 		= $r[2];
		$sh[$r[0]]['telpondistri'] 	= $r[3];
		}

    $qr = '';
  $qr = mysql_query("SELECT max(right(kode_distributor,4)) FROM distributor");
  $q = mysql_fetch_array($qr);
  $kd_new = 'KDS-'.str_pad(($q[0] + 1),4,'0',STR_PAD_LEFT);
}else{
  $kd_new = 'KDS-001';
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Home</title>
<link href="style/style.css" rel="stylesheet" type="text/css" />

<?php include 'cssin.html' ?>
</head>

<body>


<!-- menu -->
<?php
	create_header();
?>
<!-- menu -->

<div class="content">
     
  
  <form action="distributor.php" enctype="multipart/form-data"method="post">
             
    <?php
   		if($act=='edit'){
			
			
			//ACTION UNTUK UBAH
	?>
	 		 <table border="0" cellspacing="0"cellpadding="10" align="center" width="100%">
       <tr>
          <td colspan="3" ><div align="center"><B>UBAH</B></div></td>
               	<input type="hidden" name="action" id="action" value="update" />
        <input type="hidden" id="old_kode_distributor" name="old_kode_distributor" value="<?php echo $ED['kode_distributor'] ; ?>" readonly="readonly"  />
      
          </tr>
            <tr> 	
 					<tr valign="baseline">
                      <td nowrap="nowrap" align="right">Kode Distributor</td>
                      <td>:</td>
                      <td> <input type="text" id="kode_distributor" name="kode_distributor" value="<?php echo $ED['kode_distributor'] ; ?>" readonly="readonly"/></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Nama Distributor</td>
                      <td>:</td>
                      <td><input type="text" name="nama_distributor" id="nama_distributor" value="<?php echo $ED['nama_distributor'] ; ?>" size="32" /></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Alamat Distributor</td>
                      <td>:</td>
                      <td><input type="text" name="alamatdistri" id="alamatdistri" value="<?php echo $ED['alamatdistri'] ; ?>" size="32" /></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Telp Pembeli</td>
                      <td>:</td>
                      <td><input type="text" name="telpondistri" id="telpondistri" value="<?php echo $ED['telpondistri'] ; ?>" size="32" /></td>
                    </tr>
                    <tr valign="baseline">
                     
                      <td colspan="3"><div align="center"><input type="submit"a;l value="Ubah Data" /></div></td>
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
 	<table border="0" cellspacing="0" cellpadding="10" align="center" width="100%">
                 <tr>
          <td colspan="3" ><div align="center"><B>TAMBAH DATA</B></div></td>
          <input type="hidden" name="action" id="action" value="save" />
          </tr>
            <tr> 	
 					<tr valign="baseline">
                      <td nowrap="nowrap" align="right">Kode Distributor</td>
                      <td>:</td>
                      <td><input type="text" id="kode_distributor" required="required" name="kode_distributor"  value="<?php echo $kd_new; ?>" readonly="readonly"size="32" /></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Nama Distributor</td>
                      <td>:</td>
                      <td><input type="text" name="nama_distributor" required="required" id="nama_distributor" value="" size="32" /></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Alamat Distributor</td>
                      <td>:</td>
                      <td><input type="text" name="alamatdistri" required="required" id="alamatdistri" value="" size="32" /></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Telp Distributor</td>
                      <td>:</td>
                      <td><input type="text" name="telpondistri"  required="required" id="telpondistri" value="" size="32" /></td>
                    </tr>
                      <tr valign="baseline">
                      <td colspan="3"><div align="center"><input type="submit" value="Tambah" /></div></td>
                    </tr>
                  </table>

</div>
                   <?php  }?>

                </form>
                <p>&nbsp;</p>
                </tr>
                <table width="100%"border="1" cellspacing="0" cellpadding="10">
                  <tr>
                    <td  align="center" ><b>Kode Distributor</b></td>
                    <td  align="center" ><b>Nama Distributor</td>
                    <td align="center" ><b>Alamat Distributor</b></td>
                    <td  align="center" ><b>Telp Distributor</b></td>
                    <td colspan="3" align="center" ><b>Modifikasi</b></td>
                    </tr>
                    
                    
                  <?php
      	if($sh){
			foreach($sh as $n => $v){
				?>
			<tr>
			<td align="center"><?=$v['kode_distributor']; ?></td>
            <td align="center"><?=$v['nama_distributor'];?></td>
			<td align="center"><?=$v['alamatdistri'];?></td>
			<td align="center"><?=$v['telpondistri'];?></td>
            <td width="15" align="center"><a href="distributor.php?action=edit&kd=<?php echo $v['kode_distributor']; ?>">Edit</a></td>
            <td width="53" align="center"><a href="javascript:if (confirm('Anda Yakin Untuk Menghapus Data?'))
             { 	window.location.href='distributor.php?action=hapus&kd=<?php echo $v['kode_distributor']; ?>' }
              else { volid('') };">Delete</a></td>
            <?php 
			}
		}else{
			echo '<td colspan="4"><div align="center"><b>Maaf Tidak ada data untuk ditampilkan</b><td> ';	
      echo '</tr>';
      echo '</table>';
		}

	  ?>
    </tr>
      
    </table>
    
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