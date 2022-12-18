<?php
include  ('config/koneksi.php');

$db = get_db_conn();
$qr = mysql_query("SELECT kode_kasir FROM kasir where kode_kasir = '".$_COOKIE['uid']."' ");
$r = mysql_fetch_array($qr);
$kd 	= $r[0];

if(isset($_POST['action'])){
	$kode_kasir			= $_POST['kode_kasir'];
	$no_ktp					= $_POST['no_ktp'];
	$nama 			= $_POST['nama'];
	$alamat 			= $_POST['alamat'];
	$telpon 					= $_POST['telpon'];
	$status 					= $_POST['status'];
	$pass 					= $_POST['pass'];
	
	
	if($_POST['action'] == 'save'){
			$qr = mysql_query("INSERT INTO kasir(kode_kasir,no_ktp,nama,alamat,telpon,status,pass) 
		values('".$kode_kasir."','".$no_ktp."','".$nama."' ,'".$alamat."', '".$telpon."' , '".$status."', '".$pass."') ");
		echo mysql_error();
	}
	if($_POST['action'] == 'update'){
		$upd = "kode_kasir = '".$kode_kasir."',no_ktp = '".$no_ktp."',nama = '".$nama."', alamat	= '".$alamat."', telpon = '".$telpon."',status = '".$status."',pass = '".$pass."' ";
		$qr = mysql_query("UPDATE kasir SET ".$upd." WHERE kode_kasir ='".$_POST['old_kode_kasir']."' ");
		echo mysql_error();
	}
}
$act = '';
if(isset($_GET['action'])){
	$act = $_GET['action'];
	$kd = $_GET['kd'];
	if($act =='hapus'){
		$qr = mysql_query("DELETE FROM kasir WHERE kode_kasir='".$kd."' ");
		header("location:kasir.php");
	}
	if($act=='edit'){
		$qr = ''; $r ='';
		// 							0	  1		2			3	4
		$qr = mysql_query("SELECT kode_kasir,no_ktp,nama,alamat,telpon,status,pass FROM kasir WHERE kode_kasir='".$kd."' ");	
		$r = mysql_fetch_array($qr);
		$ED['kode_kasir'] 	= $r[0];
		$ED['no_ktp'] 			= $r[1];		  	
		$ED['nama'] 		= $r[2];
		$ED['alamat']		= $r[3];
		$ED['telpon']	 	= $r[4];
		$ED['status'] 		= $r[5];
		$ED['pass'] 		= $r[6];
		
	
	}
}
$qr = ''; $bs= ''; $r ='';





$kd_nw = '';

$qr = ''; $sh= ''; $r ='';
// 							0	  1		2			3	4
$qr = mysql_query("SELECT kode_kasir,no_ktp,nama,alamat,telpon,status,pass FROM kasir order by kode_kasir ASC"); 
if($qr){
	while($r = mysql_fetch_array($qr)){
		$sh[$r[0]]['kode_kasir'] 				= $r[0];
		$sh[$r[0]]['no_ktp'] 						= $r[1];
		$sh[$r[0]]['nama'] 						= $r[2];
		$sh[$r[0]]['alamat'] 					= $r[3];
		$sh[$r[0]]['telpon'] 					= $r[4];
		$sh[$r[0]]['status'] 					= $r[5];
		$sh[$r[0]]['pass'] 					= $r[6];
		
	
	}
	$qr = '';
	$qr = mysql_query("SELECT max(right(kode_kasir,4)) FROM kasir");
	$q = mysql_fetch_array($qr);
	$kd_new = 'KSR-'.str_pad(($q[0] + 1),4,'0',STR_PAD_LEFT);
}else{
	$kd_new = 'KSR-0001';
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>KASIR</title>
<?php include'cssin.html' ?>
</head>

<body>
<div class="logo">
<img src="img/logo.png" width="735" height="442" alt="LOGO" />

  <div class="keterangan"> 
  <img src="img/user-male-icon.png">  
  SELAMAT DATANG <b> SAYANG</b><br/>
  </div>

</div>

<?php
	create_header();
?>

<div class="content">
  <p>
  <form action="kasir.php" enctype="multipart/form-data"method="post">
             
    <?php
   		if($act=='edit'){
			
			
			//ACTION UNTUK UBAH
	?>
	 		 <table border="0"cellspacing="0"cellpadding="10" align="center" width="100%">
       <tr>
          <td colspan="3" bgcolor="#ccc"><div align="center"><B>UBAH</B></div></td>
               	<input type="hidden" name="action" id="action" value="update" />
        <input type="hidden" id="old_kode_kasir" name="old_kode_kasir" value="<?php echo $ED['kode_kasir'] ; ?>" />
      
          </tr>
            <tr> 	
 					<tr valign="baseline">
                      <td nowrap="nowrap" align="right">Kode Kasir</td>
                      <td>:</td>
                      <td> <input type="text" id="kode_kasir" name="kode_kasir" value="<?php echo $ED['kode_kasir'] ; ?>" readonly="readonly"size="32"/></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">KTP</td>
                      <td>:</td>
                      <td><input type="text" name="no_ktp" id="no_ktp" value="<?php echo $ED['no_ktp'] ; ?>" size="32" /></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Nama</td>
                      <td>:</td>
                      <td><input type="text" name="alamat" id="alamat" value="<?php echo $ED['alamat'] ; ?>" size="32" /></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">alamat</td>
                      <td>:</td>
                      <td><input type="text" name="alamat" id="alamat" value="<?php echo $ED['alamat'] ; ?>" size="32" /></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">telpon</td>
                      <td>:</td>
                      <td><input type="text" name="telpon" id="telpon" value="<?php echo $ED['telpon'] ; ?>" size="32" /></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">status</td>
                      <td>:</td>
                      <td><input type="text" name="status" id="status" value="<?php echo $ED['status'] ; ?>" size="32" /></td>
                    </tr>
					<tr valign="baseline">
                      <td nowrap="nowrap" align="right">Password</td>
                      <td>:</td>
                      <td><input type="text" name="pass" id="pass" value="<?php echo $ED['pass'] ; ?>" size="32" /></td>
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
 	
                  <?php $kd_new++; }?>
                </form>
                <p>&nbsp;</p>
                </tr>
                <table width="100%"border="1" cellpadding="10" cellspacing="0">
                  <tr>
                    <td  align="center" bgcolor="#999999"><b>Kode Kasir</b></td>
                    <td  align="center" bgcolor="#999999"><b>No KTP</b></td>
                    <td align="center" bgcolor="#999999"><b>nama</b></td>
                    <td  align="center" bgcolor="#999999"><b>alamat</b></td>
                    <td  align="center" bgcolor="#999999"><b>telpon</b></td>
                    <td  align="center" bgcolor="#999999"><b>status</b></td>
                    <td  align="center" bgcolor="#999999"><b>Password</b></td>
                    <td colspan="3" align="center" bgcolor="#999999"><b>Modifikasi</b></td>
                    </tr>
                    
                    
                  <?php
      	if($sh){
			foreach($sh as $n => $v){
				?>
			<tr>
			<td align="center"><?=$v['kode_kasir']; ?></td>
            <td align="center"><?=$v['no_ktp'];?></td>
			<td align="center"><?=$v['nama'];?></td>
			<td align="center"><?=$v['alamat'];?></td>
            <td align="center"><?=$v['telpon'];?></td>
            <Td align="center"><?=$v['status'];?></Td>
			<Td align="center"><?=$v['pass'];?></Td>
           
            <td width="15" align="center" bgcolor="#CCCCCC"><a href="kasir.php?action=edit&kd=<?php echo $v['kode_kasir']; ?>">Edit</a></td>
            <td width="53" align="center" bgcolor="#CCCCCC"><a href="javascript:if (confirm('Anda Yakin Untuk Menghapus Data?'))
             { 	window.location.href='kasir.php?action=hapus&kd=<?php echo $v['kode_kasir']; ?>' }
              else { volid('') };">Delete</a></td></tr>
            <?php 
			}
		}else{
			echo '<td colspan="8"><div align="center"><b>Maaf Tidak ada data untuk ditampilkan</b><td> ';	
		}

	  ?>
      
    </table>
    SILAHKAN LOGIN MENGGUNAKAN : USERNAME = KODE KASIR , PASSWORD = PASSWORD 
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