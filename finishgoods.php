
<?php
include  ('config/koneksi.php');
$db = get_db_conn();
if(isset($_POST['action'])){
	$kode_pembelian	= $_POST['kode_pembelian'];
	$kode_buku 	= $_POST['kode_buku'];
	$tanggal = $_POST['tanggal'];
  $jumlah 	= $_POST['jumlah'];
  $harga_satuan  = $_POST['harga_jual'];
  $total_harga   = $_POST['jumlah'] * $_POST['harga_jual'];
	
	
	if($_POST['action'] == 'save'){
		$qr = mysql_query("INSERT INTO pembelian(kode_pembelian,kode_buku,tanggal,jumlah,harga_satuan,total_harga) 
		values('".$kode_pembelian."','".$kode_buku."' , '".$tanggal."' , '".$jumlah."' , '".$harga_satuan."' , '".$total_harga."') ");
		echo mysql_error();
	}
	if($_POST['action'] == 'update'){
		$upd = "kode_pembelian = '".$kode_pembelian."',kode_buku = '".$kode_buku."', tanggal = '".$tanggal."', jumlah = '".$jumlah."', harga_satuan = '".$harga_satuan."', total_harga = '".$total_harga."'";
		$qr = mysql_query("UPDATE pembelian SET ".$upd." WHERE kode_pembelian ='".$_POST['old_kode_pembelian']."' ");
		echo mysql_error();
	}
}
$act = '';
if(isset($_GET['action'])){
	$act = $_GET['action'];
	$kd = $_GET['kd'];
	if($act =='hapus'){
		$qr = mysql_query("DELETE FROM pembelian WHERE kode_pembelian='".$kd."' ");
		header("location:pembelian.php");
	}
	if($act=='edit'){
		$qr = ''; $r ='';
		// 							0	  1		2			3	4
		$qr = mysql_query("SELECT kode_pembelian,kode_buku,tanggal,jumlah,harga_satuan,total_harga FROM pembelian WHERE kode_pembelian='".$kd."' ");	
		$r = mysql_fetch_array($qr);
		$ED['kode_pembelian'] 			= $r[0];
		$ED['kode_buku'] 			= $r[1];
		$ED['tanggal']        = $r[2];
    $ED['jumlah']				= $r[3];
		$ED['harga_satuan']        = $r[4];
		$ED['total_harga']        = $r[5];
    }
}


$kd_nw = '';

$qr = ''; $sh= ''; $r ='';

$qr1 = mysql_query("SELECT kode_buku,judul FROM buku order by judul asc"); 
while($r1 = mysql_fetch_array($qr1)){
	$bs1[$r1[0]]['kode_buku'] = $r1[0];
	$bs1[$r1[0]]['judul'] = $r1[1];
}

$qr2 = mysql_query("SELECT tanggal FROM pembelian "); 
while($r2 = mysql_fetch_array($qr2)){
		$r2['tanggal']=date("Y-m-d");	
}
// 							0	  1		2			3	4
$qr = mysql_query("SELECT kode_pembelian,kode_buku,tanggal,jumlah,harga_satuan,total_harga FROM pembelian order by kode_pembelian ASC"); 
if($qr){
	while($r = mysql_fetch_array($qr)){
		$sh[$r[0]]['kode_pembelian'] 		    = $r[0];
		$sh[$r[0]]['kode_buku'] 	     	= $r[1];
		$sh[$r[0]]['tanggal']           = date('d-M-Y');
    $sh[$r[0]]['jumlah']		 	      = $r[3];
    $sh[$r[0]]['harga_satuan']            = $r[4];
		$sh[$r[0]]['total_harga']            = $r[5];
	}
	$qr = '';
	$qr = mysql_query("SELECT max(right(kode_pembelian,4)) FROM pembelian");
	$q = mysql_fetch_array($qr);
	$kd_new = 'PBL-'.str_pad(($q[0] + 1),4,'0',STR_PAD_LEFT);
}else{
	$kd_new = 'PBL-0001';
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PASOK</title>
<?php include'cssin.html' ?>
</head>

<body>


<!-- menu -->
<?php
	create_header();
?>
<!-- menu -->


<div class="content">
  <p>          <form action="pembelian.php" enctype="multipart/form-data"method="post">
             
    <?php
   		if($act=='edit'){
			
			
			//ACTION UNTUK UBAH
	?>
	 		 <table border="0"cellspacing="0"cellpadding="10" align="center" width="100%">
       <tr>
          <td colspan="3" bgcolor="#ccc"><div align="center"><B>UBAH</B></div></td>
               	<input type="hidden" name="action" id="action" value="update" />
        <input type="hidden" id="old_kode_pembelian" name="old_kode_pembelian" value="<?php echo $ED['kode_pembelian'] ; ?>" />
      
          </tr>
            <tr> 	
 					<tr valign="baseline">
                      <td nowrap="nowrap" align="right">Kode Pembeli</td>
                      <td>:</td>
                      <td> <input type="text" id="kode_pembelian" name="kode_pembelian" value="<?php echo $ED['kode_pembelian'] ; ?>" readonly="readonly"size="32"/></td>
                    </tr>
                    
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Buku</td>
                      <td>:</td>
                      <td><select name="kode_buku" id="kode_buku"onchange="harga_jual()">
							<?php
                            if($bs1){
                            foreach($bs1 as $n => $v){
                                $sel = '';
                               if($v['kode_buku']==$ED['kode_buku']){$sel ='selected';}
                               echo '<option value="'.$v['judul'].'" '.$sel.'>'.$v['kode_buku'].' : '.$v['judul'].'</option>';	
                                }
                            }
                            ?> 
        					</select></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Tanggal</td>
                      <td>:</td>
                      <td><input type="text" name="tanggal" id="tanggal"value="<?php echo $ED['tanggal']=date("d-m-Y") ; ?>" size="32" /></td>
                    </tr>
					<tr valign="baseline">
                      <td nowrap="nowrap" align="right">Jumlah</td>
                      <td>:</td>
                      <td><input type="text" name="jumlah" id="jumlah"value="<?php echo $ED['jumlah'] ; ?>" size="32" /></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Harga Satuan</td>
                      <td>:</td>
                      <td><input type="text" name="harga_jual" id="harga_jual"value="<?php echo $ED['harga_satuan'] ; ?>" size="32" /></td>
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
   <div class="tampil tidakprint  " >
    <img src="img/newdata.png" />TAMBAH DATA</div>
    <div class="sembunyi">
 	<table border="0"cellspacing="0"cellpadding="10" align="center" width="100%">
                 <tr>
          <td colspan="3" bgcolor="#ccc"><div align="center"><B>TAMBAH DATA</B></div></td>
          <input type="hidden" name="action" id="action" value="save" />
          </tr>
            <tr> 	
 					<tr valign="baseline">
                      <td nowrap="nowrap" align="right">Kode Pembeli</td>
                      <td>:</td>
                      <td><input type="text" id="kode_pembelian" name="kode_pembelian"  value="<?php echo $kd_new; ?>" readonly="readonly"size="32" /></td>
                    </tr>
                    
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Kode buku</td>
                      <td>:</td>
                      <td><select name="kode_buku" id="kode_buku" onChange="harga_jual();">
                      <option value=""></option>
                   <?php
                   if($bs1){
               foreach($bs1 as $n => $v){
               echo '<option value="'.$v['judul'].'">'.$v['kode_buku'].' : '.$v['judul'].'</option>';  
                }
               }
               ?> </select></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Tanggal</td>
                      <td>:</td>
                      <td><input name="tanggal" type="text" id="tanggal" value="<?php echo $r2['tanggal']=date("Y-m-d"); ?>"readonly="readonly">
            </td>
					<tr valign="baseline">
                      <td nowrap="nowrap" align="right">Jumlah</td>
                      <td>:</td>
                      <td><input type="text" name="jumlah" id="jumlah"value=""  "size="32" /></td>
                    </tr>
                    <tr valign="baseline">
                      <td nowrap="nowrap" align="right">Cash Bayar</td>
                      <td>:</td>
                      <td><input type="text" name="harga_jual" id="harga_jual" value=""  readonly="readonly"size="32" /></td>
                    </tr>
                                        
                    <tr valign="baseline">
                      <td colspan="3"><div align="center"><input type="submit" value="Tambah"  /></div></td>
                    </tr>
                  </table>
                  <?php $kd_new++; }?>
                </form>
                <p>&nbsp;</p>
                </tr>
                   </div>
       <table width="100%"border="1" cellpadding="10" cellspacing="0">
        <tr>
        <td  align="center" ><b>Kode Pembelian</b></td>
        <td align="center" ><b>Buku</b></td>
        <td  align="center" ><b>Tanggal</b></td>
        <td  align="center" ><b>Jumlah</b></td>
        <td  align="center" ><b>Harga Satuan</b></td>
        <td  align="center" ><b>Total_harga</b></td>
        <td colspan="3" align="center"  class="tidakprint"><b>Modifikasi</b></td>
        </tr>
                  <?php
      	if($sh){
			foreach($sh as $n => $v){
				?>
			<tr>
			<td align="center"><?=$v['kode_pembelian']; ?></td>
			<td align="center"><?=$v['kode_buku'];?></td>
			<td align="center"><?=$v['tanggal'];?></td>
      <td align="center"><?=$v['jumlah'];?></td>
      <td align="center"><?=$v['harga_satuan'];?></td>
      <td align="center"><?=$v['total_harga'];?></td>
            <td class="tidakprint" width="15" align="center"><a href="pembelian.php?action=edit&kd=<?php echo $v['kode_pembelian']; ?>">Edit</a></td>
            <td class="tidakprint" width="53" align="center" ><a href="javascript:if (confirm('Anda Yakin Untuk Menghapus Data?'))
             { 	window.location.href='pembelian.php?action=hapus&kd=<?php echo $v['kode_pembelian']; ?>' }
              else { volid('') };">Delete</a></td></tr>
            <?php 
			}
		}else{
			echo '<td colspan="8"><div align="center"><b>Maaf Tidak ada data untuk ditampilkan</b><td> ';	
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

  <button onclick="myFunction()" class="pr"> PRINT </button>
  <script>
    function myFunction () {
      window.print ();
    }
  </script>
 </div>

<div class="footer tidakprint">
  <!-- <img src="img/facebook.png">
  <img src="img/instagram.png">
  <img src="img/twitter.png">
  <img src="img/google-plus.png"> -->

  <p></p>

  <div class="ft">Copyright Giken IT Member 2022</div>

</div>

<script type='text/javascript' src='hargabuku.js'></script>
<script type='text/javascript' src='ajax.js'></script>
</body>
</html>