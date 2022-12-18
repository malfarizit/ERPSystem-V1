<?php
include  ('config/koneksi.php');

$db = get_db_conn();
if(isset($_POST['action'])){
	$Employee_id		= $_POST['Employee_id'];
	$Name			= $_POST['Name'];
	$Email 		= $_POST['Email'];
	$Phone 		= $_POST['Phone'];
	$Grade 		= $_POST['Grade'];
	$Departement 			= $_POST['Departement'];
	$Joint_Date 			= $_POST['Joint_Date'];
	
	if($_POST['action'] == 'save'){
		
			// $fl_name = $_FILES['gambar']['name'];
			// $size = ($_FILES['gambar']['size'] / 1024);
			// $fl_type = $_FILES['gambar']['type'];
			// $tmp = $_FILES['gambar']['tmp_name'];
			// $path = "gbr/".$fl_name;
			// move_uploaded_file($tmp,$path);
		$qr = mysql_query("INSERT INTO employees(Employee_id,Name,Email,Phone,Grade,Departement,Joint_Date) 
		values('".$Employee_id."','".$Name."','".$Email."' ,'".$Phone."', '".$Grade."','".$Departement."','".$Joint_Date."') ");
		echo mysql_error();
	}
	if($_POST['action'] == 'update'){
		$upd = "Employee_id = '".$Employee_id."',Name = '".$Name."',Email = '".$Email."', Phone = '".$Phone."', Grade = '".$Grade."', Departement = '".$Departement."', Joint_Date = '".$Joint_Date."'";
		// if(isset($_FILES['gambar']['name'])){	
		// 	$fl_name = $_FILES['gambar']['name'];
		// 	$size = ($_FILES['gambar']['size'] / 1024);
		// 	$fl_type = $_FILES['gambar']['type'];
		// 	$tmp = $_FILES['gambar']['tmp_name'];
		// 	$path = "gbr/".$fl_name;
		// 	move_uploaded_file($tmp,$path);
		// 	$upd .= ", gambar = '".$path."'";
		$qr = mysql_query("UPDATE employees SET ".$upd." WHERE Employee_id ='".$_POST['Employee_id']."' ");
		echo mysql_error();
	}
}
$act = '';
if(isset($_GET['action'])){
	$act = $_GET['action'];
	$kd = $_GET['kd'];
	if($act =='hapus'){
		$qr = mysql_query("DELETE FROM employees WHERE Employee_id='".$kd."' ");
		header("location:employees.php");
	}
	if($act=='edit'){
		$qr = ''; $r ='';
		// 							0	  1		2			3	4			5	6		7	8		9		10			11		
		$qr = mysql_query("SELECT Employee_id,Name,Email,Phone,Grade,Departement,Joint_Date FROM employees WHERE Employee_id='".$kd."' ");	
		$r = mysql_fetch_array($qr);
		$ED['Employee_id'] 		= $r[0];
		$ED['Name'] 		= $r[1];
    $ED['Email'] 	= $r[2];
		$ED['Phone'] 	= $r[3];
		$ED['Grade']= $r[4];
		$ED['Departement'] 	= $r[5];
		$ED['Joint_Date'] 	= $r[6];
		// $ED['gambar'] 	= $r[7];
	}
}

$kd_nw = '';

$qr = ''; $sh= ''; $r ='';
// 							0	  1		2			3	4
$qr = mysql_query("SELECT Employee_id,Name,Email,Phone,Grade,Departement,Joint_Date FROM employees order by Employee_id ASC"); 
if($qr){
	while($r = mysql_fetch_array($qr)){
		$sh[$r[0]]['Employee_id'] 		= $r[0];
		$sh[$r[0]]['Name'] 		= $r[1];
		$sh[$r[0]]['Email'] 		= $r[2];
		$sh[$r[0]]['Phone'] 	= $r[3];
		$sh[$r[0]]['Grade'] 	= $r[4];
		$sh[$r[0]]['Departement'] 		= $r[5];
		$sh[$r[0]]['Joint_Date'] 	= $r[6];
		// $sh[$r[0]]['gambar'] 		= $r[7];
	}
	$qr = '';
	$qr = mysql_query("SELECT max(right(Employee_id,5)) FROM employees");
	$q = mysql_fetch_array($qr);
	$kd_new = ''.str_pad(($q[0] + 1),4,'0',STR_PAD_LEFT);
}else{
	$kd_new = '';
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Employee Page</title>

<?php include 'cssin.html' ?>

<body>
 
<!-- menu -->
<?php
	create_header();
?>
<!-- menu -->

</div>


<div class="content">
  <form action="employees.php" enctype="multipart/form-data"method="post">
             
    <?php
   		if($act=='edit'){
			
			
			//ACTION UNTUK UBAH
	?>
	 		 <table border="0" cellspacing="0" cellpadding="10" align="center" width="100%">
       <tr>
          <td colspan="3" ><div align="center"><B>UBAH</B></div></td>
               	<input type="hidden" name="action" id="action" value="update" />
        <input type="hidden" id="old_kode_buku" name="old_kode_buku" value="<?php echo $ED['Employee_id'] ; ?>" />
      
          </tr>
            <tr> 	
 					<tr valign="baseline">
                      <td nowrap="nowrap" align="right">Employee_id</td>
                      <td>:</td>
                      <td> <input type="text" id="Employee_id" name="Employee_id" value="<?php echo $ED['Employee_id'] ; ?>" readonly="readonly"/></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Name</td>
                      <td>:</td>
                      <td><input type="text" name="Name" id="Name"  value="<?php echo $ED['Name'] ; ?>"/></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Email</td>
                      <td>:</td>
                      <td><input type="text" name="Email"id="Email" value="<?php echo $ED['Email'] ; ?>"  /></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Phone</td>
                      <td>:</td>
                      <td><input type="text" name="Phone" id="Phone" value="<?php echo $ED['Phone'] ; ?>"  /></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Grade</td>
                      <td>:</td>
                      <td><input type="text" name="Grade" id="Grade" value="<?php echo $ED['Grade'] ; ?>"  /></td>
                    </tr>
					<tr valign="baseline">
                      <td nowrap="nowrap" align="right">Departement</td>
                      <td>:</td>
                      <td><input type="text" name="Departement" id="Departement" value="<?php echo $ED['Departement'] ; ?>"  /></td>
                    </tr>
					<tr valign="baseline">
                      <td nowrap="nowrap" align="right">Joint_Date</td>
                      <td>:</td>
                      <td><input type="date" name="Joint_Date" id="Joint_Date" value="<?php echo $ED['Joint_Date'] ; ?>"  /></td>
                    </tr>
                    <!-- <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Gambar</td>
                      <td>:</td>
                      <td><input type="file" name="gambar" id="gambar" value="<?php echo $ED['merk'] ; ?>"  /></td>
                    </tr> -->
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
                      <td width="29%" align="right" nowrap="nowrap">Employee Number</td>
                      <td width="2%">:</td>
                      <td width="69%"><input type="text" id="Employee_id" name="Employee_id" required="required" value="<?php echo $kd_new; ?>" readonly="readonly" /></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Name</td>
                      <td>:</td>
                      <td><input type="text" name="Name"id="Name" value="" required="required" /></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Email</td>
                      <td>:</td>
                      <td><input type="text" name="Email"id="Email" value=""  required="required"/></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Phone</td>
                      <td>:</td>
                      <td><input type="text" name="Phone" id="Phone"value=""  required="required"/></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Grade</td>
                      <td>:</td>
                      <td><input type="text" name="Grade" id="Grade"value="" required="required"  /></td>
                    </tr>
					          <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Departement</td>
                      <td>:</td>
                      <td><input type="text" name="Departement" id="Departement"value="" required="required" /></td>
                    </tr>
					          <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Joint_Date</td>
                      <td>:</td>
                      <td><input type="date" format="yyyy-mm-dd" name="Joint_Date" id="Joint_Date"value="" required="required" /></td>
                    </tr>
                    <!-- <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Gambar</td>
                      <td>:</td>
                      <td><input type="file" name="gambar" id="gambar"  required="required" /></td>
                    </tr> -->
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
      
        <div class="emp">
          
          <!-- GAMBAR<center><img src="<?=$v['gambar'];?>"  /></a></center> -->
          <!--noisb -->     
                            <p class="p1">Name   </p><p class="p2"><?=$v['Name'];?></p>
          <!--KODE BUKU --> <p class="p1">Employee_id   </p><p class="p2"><?=$v['Employee_id'];?></p>
          <!--noisb -->     <p class="p1">Email </p><p class="p2"> <?=$v['Email'];?></p>
          <!--penulis -->   <p class="p1">Phone     </p><p class="p2"><?=$v['Phone'];?></p>
          <!--penerbit -->  <p class="p1">Grade    </p><p class="p2"><?=$v['Grade'];?></p>
          <!--tahun -->     <p class="p1">Departement       </p><p class="p2"><?=$v['Departement'];?></p>
          <!--stok-->       <p class="p1">Joint_Date        </p><p class="p2"> <?=$v['Joint_Date'];?></p>
<a href="employees.php?action=edit&kd=<?php echo $v['Employee_id']; ?>">Edit</a>
        <a href="javascript:if (confirm('Anda Yakin Untuk Menghapus Data?'))
             {  window.location.href='employees.php?action=hapus&kd=<?php echo $v['Employee_id']; ?>' }
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
  <!-- <img src="img/facebook.png">
  <img src="img/instagram.png">
  <img src="img/twitter.png">
  <img src="img/google-plus.png"> -->

  <p></p>

  <div class="ft">Copyright Giken IT Member 2022</div>

</div>

</body>
</html>