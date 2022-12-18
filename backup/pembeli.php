
<?php
include  ('config/koneksi.php');

$db = get_db_conn();

if(isset($_POST['action'])){
	$no_ktp	= $_POST['no_ktp'];
	$nama_pembeli	= $_POST['nama_pembeli'];
	$alamat_pembeli 	= $_POST['alamat_pembeli'];
	$telp_pembeli 	= $_POST['telp_pembeli'];
	
	if($_POST['action'] == 'save'){
		
			
		$qr = mysql_query("INSERT INTO pembeli(no_ktp,nama_pembeli,alamat_pembeli,telp_pembeli) 
		values('".$no_ktp."','".$nama_pembeli."','".$alamat_pembeli."' ,'".$telp_pembeli."') ");
		echo mysql_error();
	}
	if($_POST['action'] == 'update'){
		$upd = "no_ktp = '".$no_ktp."',nama_pembeli = '".$nama_pembeli."',alamat_pembeli = '".$alamat_pembeli."', telp_pembeli = '".$telp_pembeli."'";
		$qr = mysql_query("UPDATE pembeli SET ".$upd." WHERE no_ktp ='".$_POST['old_no_ktp']."' ");
		echo mysql_error();
	}
}
$act = '';
if(isset($_GET['action'])){
	$act = $_GET['action'];
	$kd = $_GET['kd'];
	if($act =='hapus'){
		$qr = mysql_query("DELETE FROM pembeli WHERE no_ktp='".$kd."' ");
		header("location:pembeli.php");
	}
	if($act=='edit'){
		$qr = ''; $r ='';
		// 							0	  1		2			3	4
		$qr = mysql_query("SELECT no_ktp,nama_pembeli,alamat_pembeli,telp_pembeli FROM pembeli WHERE no_ktp='".$kd."' ");	
		$r = mysql_fetch_array($qr);
		$ED['no_ktp'] 		= $r[0];
		$ED['nama_pembeli'] 		= $r[1];
		$ED['alamat_pembeli'] 	= $r[2];
		$ED['telp_pembeli']= $r[3];
		}
}


$qr = ''; $sh= ''; $r ='';
// 							0	  1		2			3	4
$qr = mysql_query("SELECT no_ktp,nama_pembeli,alamat_pembeli,telp_pembeli FROM pembeli order by no_ktp ASC"); 
if($qr){
	while($r = mysql_fetch_array($qr)){
		$sh[$r[0]]['no_ktp'] 		= $r[0];
		$sh[$r[0]]['nama_pembeli'] 		= $r[1];
		$sh[$r[0]]['alamat_pembeli'] 		= $r[2];
		$sh[$r[0]]['telp_pembeli'] 	= $r[3];
		}
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
     
  
  <form action="pembeli.php" enctype="multipart/form-data"method="post">
             
    <?php
   		if($act=='edit'){
			
			
			//ACTION UNTUK UBAH
	?>
	 		 <table border="0" cellspacing="0"cellpadding="10" align="center" width="100%">
       <tr>
          <td colspan="3" ><div align="center"><B>UBAH</B></div></td>
               	<input type="hidden" name="action" id="action" value="update" />
        <input type="hidden" id="old_no_ktp" name="old_no_ktp" value="<?php echo $ED['no_ktp'] ; ?>" readonly="readonly"  />
      
          </tr>
            <tr> 	
 					<tr valign="baseline">
                      <td nowrap="nowrap" align="right">KTP</td>
                      <td>:</td>
                      <td> <input type="text" id="no_ktp" name="no_ktp" value="<?php echo $ED['no_ktp'] ; ?>" /></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Nama Pembeli</td>
                      <td>:</td>
                      <td><input type="text" name="nama_pembeli" id="nama_pembeli" value="<?php echo $ED['nama_pembeli'] ; ?>" size="32" /></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Alamat Pembeli</td>
                      <td>:</td>
                      <td><input type="text" name="alamat_pembeli" id="alamat_pembeli" value="<?php echo $ED['alamat_pembeli'] ; ?>" size="32" /></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Telp Pembeli</td>
                      <td>:</td>
                      <td><input type="text" name="telp_pembeli" id="telp_pembeli" value="<?php echo $ED['telp_pembeli'] ; ?>" size="32" /></td>
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
                      <td nowrap="nowrap" align="right">KTP</td>
                      <td>:</td>
                      <td><input type="text" id="no_ktp" required="required" name="no_ktp"  value="" size="32" /></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Nama Pembeli</td>
                      <td>:</td>
                      <td><input type="text" name="nama_pembeli" required="required" id="nama_pembeli" value="" size="32" /></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Alamat Pembeli</td>
                      <td>:</td>
                      <td><input type="text" name="alamat_pembeli" required="required" id="alamat_pembeli" value="" size="32" /></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Telp Pembeli</td>
                      <td>:</td>
                      <td><input type="text" name="telp_pembeli"  required="required" id="telp_pembeli" value="" size="32" /></td>
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
                    <td  align="center" ><b>No KTP</b></td>
                    <td  align="center" ><b>Nama pembeli</td>
                    <td align="center" ><b>Alamat Pembeli</b></td>
                    <td  align="center" ><b>Telp Pembeli</b></td>
                    <td colspan="3" align="center" ><b>Modifikasi</b></td>
                    </tr>
                    
                    
                  <?php
      	if($sh){
			foreach($sh as $n => $v){
				?>
			<tr>
			<td align="center"><?=$v['no_ktp']; ?></td>
            <td align="center"><?=$v['nama_pembeli'];?></td>
			<td align="center"><?=$v['alamat_pembeli'];?></td>
			<td align="center"><?=$v['telp_pembeli'];?></td>
            <td width="15" align="center"><a href="pembeli.php?action=edit&kd=<?php echo $v['no_ktp']; ?>">Edit</a></td>
            <td width="53" align="center"><a href="javascript:if (confirm('Anda Yakin Untuk Menghapus Data?'))
             { 	window.location.href='pembeli.php?action=hapus&kd=<?php echo $v['no_ktp']; ?>' }
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