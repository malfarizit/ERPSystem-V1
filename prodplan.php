
<?php
include  ('config/koneksi.php');

$db = get_db_conn();
if(isset($_POST['action'])){
	$id	= $_POST['id'];
	$Gpi_number	= $_POST['Gpi_number'];
	$Mtl_Name 	= $_POST['Mtl_Name'];
	$Mtl_Number 	= $_POST['Mtl_Number'];
	$Mtl_Description	= $_POST['Mtl_Description'];
  $Mtl_Supplier 	= $_POST['Mtl_Supplier'];
	$Receive_Date 	= $_POST['Receive_Date'];
	$Recive_qty	= $_POST['Recive_qty'];
  $Issue_Date 	= $_POST['Issue_Date'];
	$Issue_qty 	= $_POST['Issue_qty'];
	$Balance	= $_POST['Balance'];
	
	if($_POST['action'] == 'save'){
		$qr = mysql_query("INSERT INTO incoming(id,Gpi_number,Mtl_Name,Mtl_Number,Mtl_Description,Mtl_Supplier,Receive_Date,Recive_qty,Issue_Date,Issue_qty,Balance) 
		values('".$id."','".$Gpi_number."','".$Mtl_Name."' , '".$Mtl_Number."', '".$Mtl_Description."', '".$Mtl_Supplier."', '".$Receive_Date."', '".$Recive_qty."', '".$Issue_Date."', '".$Issue_qty."', '".$Balance."') ");
		echo mysql_error();
	}
	if($_POST['action'] == 'update'){
		$upd = "id = '".$id."',Gpi_number = '".$Gpi_number."',Mtl_Name = '".$Mtl_Name."', Mtl_Number = '".$Mtl_Number."', Mtl_Description = '".$Mtl_Description."', Mtl_Supplier = '".$Mtl_Supplier."', Receive_Date = '".$Receive_Date."', Recive_qty = '".$Recive_qty."', Issue_Date = '".$Issue_Date."', Issue_qty = '".$Issue_qty."', Balance = '".$Balance."'";
		$qr = mysql_query("UPDATE incoming SET ".$upd." WHERE Gpi_number ='".$_POST['old_Gpi_number']."' ");
		echo mysql_error();
	}
}
$act = '';
if(isset($_GET['action'])){
	$act = $_GET['action'];
	$kd = $_GET['kd'];
	if($act =='hapus'){
		$qr = mysql_query("DELETE FROM incoming WHERE Gpi_number='".$kd."' ");
		header("location:store.php");
	}
	if($act=='edit'){
		$qr = ''; $r ='';
		// 							0	  1		2			3	4
		$qr = mysql_query("SELECT id,Gpi_number,Mtl_Name,Mtl_Number,Mtl_Description,Mtl_Supplier,Receive_Date,Recive_qty,Issue_Date,Issue_qty,Balance FROM incoming WHERE Gpi_number='".$kd."' ");	
		$r = mysql_fetch_array($qr);
		$ED['id'] 			= $r[0];
		$ED['Gpi_number'] 	= $r[1];
		$ED['Mtl_Name'] 			= $r[2];
		$ED['Mtl_Number']				= $r[3];
		$ED['Mtl_Description']	 			= $r[4];
    $ED['Mtl_Supplier'] 			= $r[5];
		$ED['Receive_Date']				= $r[6];
		$ED['Recive_qty']	 			= $r[7];
    $ED['Issue_Date'] 			= $r[8];
		$ED['Issue_qty']				= $r[9];
		$ED['Balance']	 			= $r[10];
		}
}


$kd_nw = '';

$qr = ''; $sh= ''; $r ='';
$qr = mysql_query("SELECT Gpi_number, Part_Number FROM materials order by Gpi_number asc"); 
while($r = mysql_fetch_array($qr)){
	$bs[$r[0]]['Gpi_number'] = $r[0];
	$bs[$r[0]]['Part_Number'] = $r[1];
}
// $qr1 = mysql_query("SELECT kode_buku,penerbit FROM buku order by penerbit asc"); 
// while($r1 = mysql_fetch_array($qr1)){
// 	$bs1[$r1[0]]['kode_buku'] = $r1[0];
// 	$bs1[$r1[0]]['penerbit'] = $r1[1];
// }

// $qr2 = mysql_query("SELECT tanggal FROM pasok "); 
// while($r2 = mysql_fetch_array($qr2)){
// 		$r2['tanggal']=date("Y-m-d");	
// }
// 							0	  1		2			3	4
$qr = mysql_query("SELECT id,Gpi_number,Mtl_Name,Mtl_Number,Mtl_Description,Mtl_Supplier,Receive_Date,Recive_qty,Issue_Date,Issue_qty,Balance FROM incoming order by Gpi_number ASC"); 
if($qr){
	while($r = mysql_fetch_array($qr)){
    $sh[$r[0]]['id'] 			= $r[0];
    $sh[$r[0]]['Gpi_number'] 	= $r[1];
    $sh[$r[0]]['Mtl_Name'] 			= $r[2];
    $sh[$r[0]]['Mtl_Number']				= $r[3];
    $sh[$r[0]]['Mtl_Description']	 			= $r[4];
    $sh[$r[0]]['Mtl_Supplier'] 			= $r[5];
    $sh[$r[0]]['Receive_Date']				= $r[6];
    $sh[$r[0]]['Recive_qty']	 			= $r[7];
    $sh[$r[0]]['Issue_Date'] 			= $r[8];
    $sh[$r[0]]['Issue_qty']				= $r[9];
    $sh[$r[0]]['Balance']	 			= $r[10];
		
	}
	$qr = '';
	$qr = mysql_query("SELECT max(right(Gpi_number,4)) FROM incoming");
	$q = mysql_fetch_array($qr);
	$kd_new = 'GPI-'.str_pad(($q[0] + 1),4,'0',STR_PAD_LEFT);
}else{
	$kd_new = 'GPI-0001';
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Store Page</title>


<?php include'cssin.html' ?>

</head>

<body>


<!-- menu -->
<?php
	create_header();
?>
<!-- menu -->


<div class="content">
  <p>          <form action="store.php" enctype="multipart/form-data"method="post">
             
    <?php
   		if($act=='edit'){
			
			
			//ACTION UNTUK UBAH
	?>
	 		 <table border="0"cellspacing="0"cellpadding="10" align="center" width="100%">
       <tr>
          <td colspan="3" bgcolor="#ccc"><div align="center"><B>UBAH</B></div></td>
               	<input type="hidden" name="action" id="action" value="update" />
        <input type="hidden" id="old_Gpi_number" name="old_Gpi_number" value="<?php echo $ED['Gpi_number'] ; ?>" />
      
          </tr>
            <tr> 	
 					<tr valign="baseline">
                      <td nowrap="nowrap" align="right">Gpi Number</td>
                      <td>:</td>
                      <td> <input type="text" id="Gpi_number" name="Gpi_number" value="<?php echo $ED['Gpi_number'] ; ?>" readonly="readonly"size="32"/></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Material Name</td>
                      <td>:</td>
                      <td><input type="text" name="Mtl_Name" id="Mtl_Name"value="<?php echo $ED['Mtl_Name'] ; ?>" size="32" /></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Mtl_Number</td>
                      <td>:</td>
                      <td><select name="Mtl_Number" id="Mtl_Number">
							<?php
                            if($bs){
                            foreach($bs as $n => $v){
                                $sel = '';
                                if($v['Mtl_Number']==$ED['Mtl_Number']){$sel ='selected';}
                                echo '<option value="'.$v['Mtl_Number'].'" '.$sel.'>'.$v['Mtl_Number'].' : '.$v['Mtl_Number'].'</option>';	
                                }
                            }
                            ?> 
        					</select> </td>
                    </tr>
					          <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Mtl Description</td>
                      <td>:</td>
                      <td><input type="text" name="Mtl_Description" id="Mtl_Description"value="<?php echo $ED['Mtl_Description'] ; ?>" size="32" /></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Materials Supplier</td>
                      <td>:</td>
                      <td><input type="text" name="Mtl_Supplier" id="Mtl_Supplier"value="<?php echo $ED['Mtl_Supplier'] ; ?>" size="32" /></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Receive Date</td>
                      <td>:</td>
                      <td><input type="date" name="Receive_Date" id="Receive_Date"value="<?php echo $ED['Receive_Date'] ; ?>" size="32" /></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Recive_qty</td>
                      <td>:</td>
                      <td><input type="text" name="Recive_qty" id="Recive_qty"value="<?php echo $ED['Recive_qty'] ; ?>" size="32" /></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Issue Date</td>
                      <td>:</td>
                      <td><input type="date" name="Issue_Date" id="Issue_Date"value="<?php echo $ED['Issue_Date'] ; ?>" size="32" /></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Issue Qty</td>
                      <td>:</td>
                      <td><input type="text" name="Issue_qty" id="Issue_qty"value="<?php echo $ED['Issue_qty'] ; ?>" size="32" /></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Balance</td>
                      <td>:</td>
                      <td><input type="text" name="Balance" id="Balance"value="<?php echo $ED['Balance'] ; ?>" size="32" /></td>
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
 	<table border="0"cellspacing="0"cellpadding="10" align="center" width="100%">
                 <tr>
          <td colspan="3" bgcolor="#ccc"><div align="center"><B>TAMBAH DATA</B></div></td>
          <input type="hidden" name="action" id="action" value="save" />
          </tr>
            <tr> 	
 					<!-- <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Gpi number</td>
                      <td>:</td>
                      <td><input type="text" id="Gpi_number" name="Gpi_number"  value="<?php echo $kd_new; ?>" readonly="readonly"size="32" /></td>
                    </tr> -->
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Gpi_number</td>
                      <td>:</td>
                      <td><select name="Gpi_number" id="Gpi_number">
           				 <?php
         				   if($bs){
						   foreach($bs as $n => $v){
						   echo '<option value="'.$v['Gpi_number'].'">'.$v['Gpi_number'].'</option>';	
								}
						   }
						   ?> </select></td>
                    </tr>
					          <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Materials Name</td>
                      <td>:</td>
                      <td><input type="text" name="Mtl_Name" id="Mtl_Name"value="" size="32" /></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Material Number</td>
                      <td>:</td>
                      <td><select name="Mtl_Number" id="Mtl_Number">
           				 <?php
         				   if($bs){
						   foreach($bs as $n => $v){
						   echo '<option value="'.$v['Part_Number'].'">'.$v['Part_Number'].'</option>';	
								}
						   }
						   ?> </select></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Materials Description</td>
                      <td>:</td>
                      <td><input type="text" name="Mtl_Description" id="Mtl_Description"value="" size="32" /></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Materials Supplier</td>
                      <td>:</td>
                      <td><input type="text" name="Mtl_Supplier" id="Mtl_Supplier"value="" size="32" /></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Receive Date</td>
                      <td>:</td>
                      <td><input type="date" name="Receive_Date" id="Receive_Date"value="" size="32" /></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Receive Qty</td>
                      <td>:</td>
                      <td><input type="text" name="Recive_qty" id="Recive_qty"value="" size="32" /></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Issue Date</td>
                      <td>:</td>
                      <td><input type="date" name="Issue_Date" id="Issue_Date"value="" size="32" /></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Issue Qty</td>
                      <td>:</td>
                      <td><input type="text" name="Issue_qty" id="Issue_qty"value="" size="32" /></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Balance</td>
                      <td>:</td>
                      <td><input type="text" name="Balance" id="Balance"value="" size="32" /></td>
                    </tr>
            </td>

                    
                    <tr valign="baseline">
                      <td colspan="3"><div align="center"><input type="submit" value="Tambah" /></div></td>
                    </tr>
                  </table>
                  <?php $kd_new++; }?>
                </form>
                <p>&nbsp;</p>
                </tr>
                   </div>
       <table width="100%"border="1" cellpadding="10" cellspacing="0">
        <tr>
        <td  align="center" ><b>Gpi Number</b></td>
        <td  align="center" ><b>Material Name</b></td>
        <td align="center" ><b>Material Number</b></td>
        <td  align="center" ><b>Materials Description</b></td>
        <td  align="center" ><b>Materials Supplier</b></td>
        <td  align="center" ><b>Receive Date</b></td>
        <td align="center" ><b>Receive Qty</b></td>
        <td  align="center" ><b>Issue Date</b></td>
        <td  align="center" ><b>Receive Date</b></td>
        <td align="center" ><b>Balance</b></td>
        <td colspan="3" align="center" ><b>Modifikasi</b></td>
        </tr>
                  <?php
      	if($sh){
			foreach($sh as $n => $v){
				?>
			<tr>
			      <td align="center"><?=$v['Gpi_number']; ?></td>
            <td align="center"><?=$v['Mtl_Name'];?></td>
			      <td align="center"><?=$v['Mtl_Number'];?></td>
			      <td align="center"><?=$v['Mtl_Description'];?></td>
            <td align="center"><?=$v['Mtl_Supplier'];?></td>
            <td align="center"><?=$v['Receive_Date'];?></td>
			      <td align="center"><?=$v['Recive_qty'];?></td>
            <td align="center"><?=$v['Issue_Date'];?></td>
            <td align="center"><?=$v['Issue_qty'];?></td>
            <td align="center"><?=$v['Balance'];?></td>
            <td width="15" align="center" bgcolor="#CCCCCC"><a href="store.php?action=edit&kd=<?php echo $v['Gpi_number']; ?>">Edit</a></td>
            <td width="53" align="center" bgcolor="#CCCCCC"><a href="javascript:if (confirm('Anda Yakin Untuk Menghapus Data?'))
             { 	window.location.href='store.php?action=hapus&kd=<?php echo $v['Gpi_number']; ?>' }
              else { volid('') };">Delete</a></td></tr>
            <?php 
			}
		}else{
			echo '<td colspan="10"><div align="center"><b>Maaf Tidak ada data untuk ditampilkan</b><td> ';	
		}

	  ?>
      </tr>
       </table>
       </td>
            </tr>
            <tr>
                          <td>  <form method="get" action="config/laporan_excel.php">
              <input name="tipeLaporan" type="hidden" id="tipeLaporan" value="belicash" />
         
          <input name="sql" type="hidden" id="sql" value="<?php echo $qr; ?>" />
        
        </form></td>
            </tr>
          </table></td>
      </tr>
      <tr>
        <td height="51" bgcolor="#CCCCCC">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
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