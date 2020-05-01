<link type="text/css" href="../js/themes/base/ui.all.css" rel="stylesheet" />  
	<script type="text/javascript" src="../js/jquery-1.3.2.js"></script>
    <script type="text/javascript" src="../js/ui/ui.core.js"></script>
    <script type="text/javascript" src="../js/ui/ui.datepicker.js"></script>    
    <script type="text/javascript" src="../js/ui/i18n/ui.datepicker-id.js"></script>
	<script type="text/javascript"> 
      $(document).ready(function(){
        $("#tanggal").datepicker({
   		  dateFormat  : 'yy-mm-dd',        
          changeMonth : true,
          changeYear  : true					
        });
	 
      });
</script>
<html>
<head>

	<link rel="stylesheet" type="text/css" href="../css/DataTables/media/css/jquery.dataTables.css">
	
	<script type="text/javascript" language="javascript" src="../css/DataTables/media/js/jquery.js"></script>
	<script type="text/javascript" language="javascript" src="../css/DataTables/media/js/jquery.dataTables.js"></script>
	
	<script>
$(document).ready(function() {
	$('#example').DataTable();
} );
	</script>
</head>

<?php

session_start();
error_reporting(0);
include "../config/koneksi.php";
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
  echo "<body background='images/wood_pattern.jpg'><center><br><br><br><br><br><br>Maaf, untuk mengakses <b>Halaman Administrator</b><br>
  <center>anda harus <b>Login</b> dahulu!<br><br>";
 echo "<div> <a href='Login.php'><img src='images/admin.png'></a>
             </div>";
echo  "<br><input type=button class=btnsimpan value='LOGIN DI SINI' onclick=location.href='login.php'></center></body>";
}
 
else{

$aksi="aksi_topik.php";
switch($_GET[act]){
  // Tampil Kategori
  default:
      $tampil = mysql_query("SELECT * FROM kategori ORDER BY idkategori");
    echo "
	<h2>Manajemen Topik</h2><hr></hr>";
          echo "<div class='information msg'>Pilih kategori & klik detail untuk melihat topik</div>";
          echo "<table  id='table1' class='gtable sortable'><thead>";
		  echo "<body><table id='example' class='display' cellspacing='0' width='100%'><thead>
          <tr bgcolor=#34a5cf><th>No</th><th>Idkategori</th><th>Nama Kategori</th><th>Jumlah Topik</th><th>Aksi</th></tr></thead><hr></hr>";
    
	$no=1;
    while ($r=mysql_fetch_array($tampil)){
	
		$r2=mysql_query("select * from topik where idkategori='$r[idkategori]'");
		$jml=mysql_num_rows($r2);
       echo "<tr><td align=center>$no</td>
             <td align=center>$r[idkategori]</td>
             <td align=center>$r[nm_kategori]</td>
             <td align=center>$jml</td>           
             <td align=center><a href='?module=topik&act=detailtopik&id=$r[idkategori]' title='Detail'>Detail</a></a>
                 </td></tr>";
      $no++;
    }
    echo "</table>";
  
  break;
  
  case "detailtopik":
	$tampil = mysql_query("SELECT * FROM topik where idkategori='$_GET[id]' ORDER BY tgl_post DESC");
    echo "
	<h2>Manajemen Topik</h2><hr></hr>";
          echo "<div class='information msg'>Pilih detail untuk melihat isi topik lebih lengkap</div>";
          echo "<table  id='table1' class='gtable sortable'><thead>";
		  
    echo "<table id='example' class='display' cellspacing='0' width='100%'><thead>
          <tr bgcolor=#34a5cf><th>No</th><th>Idtopik</th><th>Idkategori</th><th>Iduser</th><th>Judul</th><th>Tanggal Post</th><th>Aksi</th></tr></thead><hr></hr>";
    
	$no=1;
    while ($r=mysql_fetch_array($tampil)){
	
		$r2=mysql_query("select * from topik where idkategori='$r[idkategori]'");
		$jml=mysql_num_rows($r2);
       echo "<tr><td align=center>$no</td>
             <td align=center>$r[idtopik]</td>
             <td align=center>$r[idkategori]</td>
             <td align=center>$r[iduser]</td>
             <td align=center>$r[judul_topik]</td>";
        
		
		$date=substr("$r[tgl_post]",0,10);
		    $th=substr("$date",0,4);
			$bln=substr("$date",5,2);
			$d=substr("$date",8,2);
			
			$jam_post=substr("$r[tgl_post]",11,5);
			$tgl_post=$d.'-'.$bln.'-'.$th;
		
		echo"<td align=center>$tgl_post ($jam_post)</td>           
             <td align=center><a href='?module=topik&act=detailisitopik&id=$r[idtopik]' title='Detail'>Detail</a> | 
			 <a href='?module=topik&act=deletetopik&id=$r[idtopik]' title='Delete' onClick=\"return confirm('Anda Yakin Hapus Data dengan idtopik=$r[idtopik]')\"><img src='images/icons/delete.png' alt='Delete' /></a>
                 </td></tr>";
      $no++;
    }
    echo "</table>";
     break;
	 
	 case "detailisitopik":
	$detail = mysql_query("SELECT t.*,k.*,u.* FROM topik t,kategori k,siswa u where t.idkategori=k.idkategori and t.iduser=u.id_siswa and t.idtopik='$_GET[id]' ORDER BY t.tgl_post DESC");
    $r=mysql_fetch_array($detail);

    echo "<form><fieldset>
          <legend>Detail Isi Topik</legend>
          <dl class='inline'>
          <dt><label>Idtopik</label></dt>   <dd> : $r[idtopik]</dd>
          <dt><label>Id/Nama Kategori</label></dt>   <dd> : $r[idkategori] / $r[nm_kategori]</dd>
          <dt><label>Id/Nama User</label></dt>   <dd> : $r[iduser] / $r[nama_lengkap]</dd>
          <dt><label>Judul</label></dt>     <dd> : $r[judul_topik]</dd>";
     
		$date=substr("$r[tgl_post]",0,10);
		    $th=substr("$date",0,4);
			$bln=substr("$date",5,2);
			$d=substr("$date",8,2);
			
			$jam_post=substr("$r[tgl_post]",11,5);
			$tgl_post=$d.'-'.$bln.'-'.$th;
			
	 echo"<dt><label>Tanggal Post</label></dt>       <dd> : $tgl_post ($jam_post)</dd>
		  <dt><label>Isi Topik</label></dt>       <dd> : $r[isi_topik]</dd>";
		  if($r[gambar]!=''){
			echo"<dt><label>Gambar</label></dt>       <dd> : <img src='../foto_topik/$r[gambar]' /></dd>";
		  }else{
			echo"<dt><label>Gambar</label></dt>       <dd> : <img src='../images/banner.png' /></dd>";
		  }
          echo "</dl>
          <div class='buttons'>
          <input class='button blue' type=button value=Kembali onclick=self.history.back()>
          </div>
          </fieldset></form>";
     break;
	 
	 
	case "deletetopik":
	if (! $_GET['id']=="")
{
include "../lib/koneksi.php";
$sqlHapus	= "delete from topik where idtopik='".$_GET['id']."'";
$queryHapus	= mysql_query($sqlHapus);
if($queryHapus)
{
echo "<script type='text/javascript'>
		alert ('Data Berhasil Dihapus...!!!')	
    </script>";
	echo "<script>window.location=(href='media_admin.php?module=topik')</script>";
}else{
echo "<script type='text/javascript'>
	onload =function(){
	alert ('Data Gagal Dihapus...!!!');
	}
	</script>";
	echo "<script>window.location=(href='media_admin.php?module=topik')</script>'>";
}
}
    break;
	
	?>
	
</body>
</head>
</html>
	<?php
}
}
?>
