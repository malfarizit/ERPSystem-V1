
<?php
include  ('config/koneksi.php');

$db = get_db_conn();
if(isset($_POST['action'])){
	$id_costumer	= $_POST['id_costumer'];
	$Costumer_Name	= $_POST['Costumer_Name'];
  $Costumer_Phone	= $_POST['Costumer_Phone'];
	$Costumer_Address 	= $_POST['Costumer_Address'];
	$Project_Name 	= $_POST['Project_Name'];
  $Joint_Date 	= $_POST['Joint_Date'];
	
	if($_POST['action'] == 'save'){
			$qr = mysql_query("INSERT INTO customer(id_costumer,Costumer_Name,Costumer_Phone,Costumer_Address,Project_Name,Joint_Date) 
		values('".$id_costumer."','".$Costumer_Name."','".$Costumer_Phone."','".$Costumer_Address."' ,'".$Project_Name."','".$Joint_Date."') ");
		echo mysql_error();
	}
	if($_POST['action'] == 'update'){
		$upd = "id_costumer = '".$id_costumer."',Costumer_Name = '".$Costumer_Name."',Costumer_Phone = '".$Costumer_Phone."',Costumer_Address = '".$Costumer_Address."',Project_Name = '".$Project_Name."',Joint_Date = '".$Joint_Date."'";
		$qr = mysql_query("UPDATE customer SET ".$upd." WHERE id_costumer ='".$_POST['id_costumer']."' ");
		echo mysql_error();
	}
}
$act = '';
if(isset($_GET['action'])){
	$act = $_GET['action'];
	$kd = $_GET['kd'];
	if($act =='hapus'){
		$qr = mysql_query("DELETE FROM customer WHERE id_costumer='".$kd."' ");
		header("location:customer.php");
	}
	if($act=='edit'){
		$qr = ''; $r ='';
		// 							0	  1		2			3	4
		$qr = mysql_query("SELECT id_costumer,Costumer_Name,Costumer_Phone,Costumer_Address,Project_Name,Joint_Date FROM customer WHERE id_costumer='".$kd."' ");	
		$r = mysql_fetch_array($qr);
		$ED['id_costumer'] 		= $r[0];
		$ED['Costumer_Name'] 		= $r[1];
    $ED['Costumer_Phone'] 		= $r[2];
		$ED['Costumer_Address'] 	= $r[3];
		$ED['Project_Name']= $r[4];
    $ED['Joint_Date']= $r[5];
		}
}


$qr = ''; $sh= ''; $r ='';
// 							0	  1		2			3	4
$qr = mysql_query("SELECT id_costumer,Costumer_Name,Costumer_Phone,Costumer_Address,Project_Name,Joint_Date FROM customer order by id_costumer ASC"); 
if($qr){
	while($r = mysql_fetch_array($qr)){
		$sh[$r[0]]['id_costumer'] 		= $r[0];
		$sh[$r[0]]['Costumer_Name'] 		= $r[1];
    $sh[$r[0]]['Costumer_Phone'] 		= $r[2];
		$sh[$r[0]]['Costumer_Address'] 		= $r[3];
		$sh[$r[0]]['Project_Name'] 	= $r[4];
    $sh[$r[0]]['Joint_Date'] 	= $r[5];
		}

    $qr = '';
  $qr = mysql_query("SELECT max(right(id_costumer,4)) FROM customer");
  $q = mysql_fetch_array($qr);
  $kd_new = 'GK-'.str_pad(($q[0] + 1),4,'0',STR_PAD_LEFT);
}else{
  $kd_new = 'GK-001';
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Customer Page</title>
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
     
  
  <form action="customer.php" enctype="multipart/form-data"method="post">
             
    <?php
   		if($act=='edit'){
			
			
			//ACTION UNTUK UBAH
	?>
	 		 <table border="0" cellspacing="0"cellpadding="10" align="center" width="100%">
       <tr>
          <td colspan="3" ><div align="center"><B>UBAH</B></div></td>
               	<input type="hidden" name="action" id="action" value="update" />
        <input type="hidden" id="old_id_costumer" name="old_id_costumer" value="<?php echo $ED['id_costumer'] ; ?>" readonly="readonly"  />
      
          </tr>
            <tr> 	
 					<tr valign="baseline">
                      <td nowrap="nowrap" align="right">id costumer</td>
                      <td>:</td>
                      <td> <input type="text" id="id_costumer" name="id_costumer" value="<?php echo $ED['id_costumer'] ; ?>" readonly="readonly"/></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Costumer Name</td>
                      <td>:</td>
                      <td><input type="text" name="Costumer_Name" id="Costumer_Name" value="<?php echo $ED['Costumer_Name'] ; ?>" size="32" /></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Costumer Phone</td>
                      <td>:</td>
                      <td><input type="text" name="Costumer_Phone" id="Costumer_Phone" value="<?php echo $ED['Costumer_Phone'] ; ?>" size="32" /></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Costumer Address</td>
                      <td>:</td>
                      <td><input type="text" name="Costumer_Address	" id="Costumer_Address" value="<?php echo $ED['Costumer_Address'] ; ?>" size="32" /></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Project Name</td>
                      <td>:</td>
                      <td><input type="text" name="Project_Name	" id="Project_Name" value="<?php echo $ED['Project_Name'] ; ?>" size="32" /></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Joint Date</td>
                      <td>:</td>
                      <td><input type="date" name="Joint_Date	" id="Joint_Date" value="<?php echo $ED['Joint_Date'] ; ?>" size="32" /></td>
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
 	<table border="0" cellspacing="0" cellpadding="10" align="center" width="100%">
                 <tr>
          <td colspan="3" ><div align="center"><B>TAMBAH DATA</B></div></td>
          <input type="hidden" name="action" id="action" value="save" />
          </tr>
            <tr> 	
 					<tr valign="baseline">
                      <td nowrap="nowrap" align="right">id costumer</td>
                      <td>:</td>
                      <td><input type="text" id="id_costumer" required="required" name="id_costumer"  value="<?php echo $kd_new; ?>" readonly="readonly"size="32" /></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Costumer Name</td>
                      <td>:</td>
                      <td><input type="text" name="Costumer_Name" required="required" id="Costumer_Name" value="" size="32" /></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Costumer Phone</td>
                      <td>:</td>
                      <td><input type="text" name="Costumer_Phone" required="required" id="Costumer_Phone" value="" size="32" /></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Costumer Address</td>
                      <td>:</td>
                      <td><input type="text" name="Costumer_Address"  required="required" id="Costumer_Address" value="" size="32" /></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Project Name</td>
                      <td>:</td>
                      <td><input type="text" name="Project_Name"  required="required" id="Project_Name" value="" size="32" /></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Joint Date</td>
                      <td>:</td>
                      <td><input type="date" name="Joint_Date"  required="required" id="Joint_Date" value="" size="32" /></td>
                    </tr>
                      <tr valign="baseline">
                      <td colspan="3"><div align="center"><input type="submit" value="Tambah" /></div></td>
                    </tr>
                  </table></div>

                   <?php $kd_new++; }?>

                </form>
                <p>&nbsp;</p>
                </tr>
                <table width="100%"border="1" cellspacing="0" cellpadding="10">
                  <tr>
                    <td  align="center" ><b>Id costumer</b></td>
                    <td  align="center" ><b>Costumer Name</td>
                    <td  align="center" ><b>Costumer Phone</b></td>
                    <td  align="center" ><b>Costumer Address</b></td>
                    <td  align="center" ><b>Project Name</b></td>
                    <td  align="center" ><b>Joint Date</b></td>
                    <td colspan="3" align="center" ><b>Modifikasi</b></td>
                    </tr>
                    
                    
                  <?php
      	if($sh){
			foreach($sh as $n => $v){
				?>
			<tr>
			<td align="center"><?=$v['id_costumer']; ?></td>
      <td align="center"><?=$v['Costumer_Name'];?></td>
			<td align="center"><?=$v['Costumer_Phone'];?></td>
			<td align="center"><?=$v['Costumer_Address'];?></td>
      <td align="center"><?=$v['Project_Name'];?></td>
      <td align="center"><?=$v['Joint_Date'];?></td>
            <td width="15" align="center"><a href="customer.php?action=edit&kd=<?php echo $v['id_costumer']; ?>">Edit</a></td>
            <td width="53" align="center"><a href="javascript:if (confirm('Anda Yakin Untuk Menghapus Data?'))
             { 	window.location.href='customer.php?action=hapus&kd=<?php echo $v['id_costumer']; ?>' }
              else { volid('') };">Delete</a></td>
            <?php 
			}
		}else{
			echo '<td colspan="6"><div align="center"><b>Maaf Tidak ada data untuk ditampilkan</b><td> ';	
      echo '</tr>';
      echo '</table>';
		}

	  ?>
    </tr>
      
    </table>
    
</div>


<div class="footer">
  <!-- <img src="img/facebook.png">
  <img src="img/instagram.png">
  <img src="img/twitter.png">
  <img src="img/google-plus.png"> -->

  <p></p>

  <div class="ft">Copyright Giken IT Member 2022</div>

</div>
</body>
</html>