
<?php
include  ('config/koneksi.php');

$db = get_db_conn();
if(isset($_POST['action'])){
	$GPI_Number	= $_POST['GPI_Number'];
	$Part_Number	= $_POST['Part_Number'];
	
	if($_POST['action'] == 'save'){
			$qr = mysql_query("INSERT INTO materials(GPI_Number,Part_Number) 
		values('".$GPI_Number."','".$Part_Number."') ");
		echo mysql_error();
	}
	if($_POST['action'] == 'update'){
		$upd = "GPI_Number = '".$GPI_Number."',Part_Number = '".$Part_Number."'";
		$qr = mysql_query("UPDATE materials SET ".$upd." WHERE GPI_Number ='".$_POST['old_GPI_Number']."' ");
		echo mysql_error();
	}
}
$act = '';
if(isset($_GET['action'])){
	$act = $_GET['action'];
	$kd = $_GET['kd'];
	if($act =='hapus'){
		$qr = mysql_query("DELETE FROM materials WHERE GPI_Number='".$kd."' ");
		header("location:materials.php");
	}
	if($act=='edit'){
		$qr = ''; $r ='';
		// 							0	  1		2			3	4
		$qr = mysql_query("SELECT GPI_Number,Part_Number FROM materials WHERE GPI_Number='".$kd."' ");	
		$r = mysql_fetch_array($qr);
		$ED['GPI_Number'] 		= $r[0];
		$ED['Part_Number'] 		= $r[1];
		}
}


$qr = ''; $sh= ''; $r ='';
// 							0	  1		2			3	4
$qr = mysql_query("SELECT GPI_Number,Part_Number FROM materials order by GPI_Number ASC"); 
if($qr){
	while($r = mysql_fetch_array($qr)){
		$sh[$r[0]]['GPI_Number'] 		= $r[0];
		$sh[$r[0]]['Part_Number'] 		= $r[1];
		}

    $qr = '';
  $qr = mysql_query("SELECT max(right(GPI_Number,1)) FROM materials");
  $q = mysql_fetch_array($qr);
  $kd_new = 'GPI-'.str_pad(($q[0] + 1),4,'0',STR_PAD_LEFT);
}else{
  $kd_new = 'GPI-001';
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Material Control Page</title>
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
     
  
  <form action="materials.php" enctype="multipart/form-data"method="post">
             
    <?php
   		if($act=='edit'){
			
			
			//ACTION UNTUK UBAH
	?>
	 		 <table border="0" cellspacing="0"cellpadding="10" align="center" width="100%">
       <tr>
          <td colspan="3" ><div align="center"><B>UBAH</B></div></td>
               	<input type="hidden" name="action" id="action" value="update" />
        <input type="hidden" id="old_GPI_Number" name="old_GPI_Number" value="<?php echo $ED['GPI_Number'] ; ?>" readonly="readonly"  />
      
          </tr>
            <tr> 	
 					<tr valign="baseline">
                      <td nowrap="nowrap" align="right">GPI Number</td>
                      <td>:</td>
                      <td> <input type="text" id="GPI_Number" name="GPI_Number" value="<?php echo $ED['GPI_Number'] ; ?>" readonly="readonly"/></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Part Number</td>
                      <td>:</td>
                      <td><input type="text" name="Part_Number" id="Part_Number" value="<?php echo $ED['Part_Number'] ; ?>" size="32" /></td>
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
                      <td nowrap="nowrap" align="right">GPI Number</td>
                      <td>:</td>
                      <td><input type="text" id="GPI_Number" required="required" name="GPI_Number"  value="<?php echo $kd_new; ?>" readonly="readonly"size="32" /></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Part Number</td>
                      <td>:</td>
                      <td><input type="text" name="Part_Number" required="required" id="Part_Number" value="" size="32" /></td>
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
                    <td  align="center" ><b>GPI Number</b></td>
                    <td  align="center" ><b>Part Number</td>
                    <td colspan="3" align="center" ><b>Modifikasi</b></td>
                    </tr>
                    
                    
                  <?php
      	if($sh){
			foreach($sh as $n => $v){
				?>
			<tr>
			<td align="center"><?=$v['GPI_Number']; ?></td>
            <td align="center"><?=$v['Part_Number'];?></td>
            <td width="15" align="center"><a href="materials.php?action=edit&kd=<?php echo $v['GPI_Number']; ?>">Edit</a></td>
            <td width="53" align="center"><a href="javascript:if (confirm('Anda Yakin Untuk Menghapus Data?'))
             { 	window.location.href='materials.php?action=hapus&kd=<?php echo $v['GPI_Number']; ?>' }
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

  <p></p>

  <div class="ft">Copyright Giken IT Member 2022</div>

</div>
</body>
</html>