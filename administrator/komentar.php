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

$aksi="aksi_komentar.php";
switch($_GET[act]){
  // Tampil Kategori
  default:
      $tampil = mysql_query("SELECT * FROM kategori ORDER BY idkategori");
    echo "
	<h2>Manajemen Komentar</h2><hr></hr>";
          echo"<input class='button blue' type=button value='Tampilkan Berdasarkan Topik' onclick=\"window.location.href='?module=komentar&act=btopik';\">";
          echo "<br></br><div class='information msg'>Pilih kategori & klik detail untuk melihat topik</div>";
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
             <td align=center><a href='?module=komentar&act=detailkomentar&id=$r[idkategori]' title='Detail'>Detail</a></a>
                 </td></tr>";
      $no++;
    }
    echo "</table>";
  
  break;
  
  case "detailkomentar":
	$tampil = mysql_query("SELECT * FROM topik where idkategori='$_GET[id]' ORDER BY tgl_post DESC");
    echo "
	<h2>Manajemen Komentar</h2><hr></hr>";
		echo"<input class='button blue' type=button value='Tampilkan Berdasarkan Kategori' onclick=\"window.location.href='?module=komentar';\"><br></br>";
          echo "<div class='information msg'>Pilih detail untuk melihat isi komentar pada topik</div>";
          echo "<table  id='table1' class='gtable sortable'><thead>";
		  
    echo "<table id='example' class='display' cellspacing='0' width='100%'><thead>
          <tr bgcolor=#34a5cf><th>No</th><th>Idtopik</th><th>Idkategori</th><th>Iduser</th><th>Judul</th><th>Jumlah Komentar</th><th>Tanggal Post</th><th>Aksi</th></tr></thead><hr></hr>";
    
	$no=1;
    while ($r=mysql_fetch_array($tampil)){
	
		$r2=mysql_query("select * from komentar where idtopik='$r[idtopik]'");
		$jml=mysql_num_rows($r2);
       echo "<tr><td align=center>$no</td>
             <td align=center>$r[idtopik]</td>
             <td align=center>$r[idkategori]</td>
             <td align=center>$r[iduser]</td>
             <td align=center>$r[judul_topik]</td>
			 <td align=center>$jml</td>";
        
		$date=substr("$r[tgl_post]",0,10);
		    $th=substr("$date",0,4);
			$bln=substr("$date",5,2);
			$d=substr("$date",8,2);
			
			$jam_post=substr("$r[tgl_post]",11,5);
			$tgl_post=$d.'-'.$bln.'-'.$th;
		
		echo"<td align=center>$tgl_post ($jam_post)</td>           
             <td align=center><a href='?module=komentar&act=detailisikomentar&id=$r[idtopik]' title='Detail'>Detail</a>
                 </td></tr>";
      $no++;
    }
    echo "</table>";
     break;
	 
	 case"btopik";
	 $tampil = mysql_query("SELECT * FROM topik ORDER BY tgl_post DESC");
    echo "
	<h2>Manajemen Komentar</h2><hr></hr>";
		echo"<input class='button blue' type=button value='Tampilkan Berdasarkan Kategori' onclick=\"window.location.href='?module=komentar';\"><br></br>";
          echo "<div class='information msg'>Pilih detail untuk melihat isi komentar pada topik</div>";
          echo "<table  id='table1' class='gtable sortable'><thead>";
		  
    echo "<table id='example' class='display' cellspacing='0' width='100%'><thead>
          <tr bgcolor=#34a5cf><th>No</th><th>Idtopik</th><th>Idkategori</th><th>Iduser</th><th>Judul</th><th>Jumlah Komentar</th><th>Tanggal Post</th><th>Aksi</th></tr></thead><hr></hr>";
    
	$no=1;
    while ($r=mysql_fetch_array($tampil)){
       
		$r2=mysql_query("select * from komentar where idtopik='$r[idtopik]'");
		$jml=mysql_num_rows($r2);
       echo "<tr><td align=center>$no</td>
             <td align=center>$r[idtopik]</td>
             <td align=center>$r[idkategori]</td>
             <td align=center>$r[iduser]</td>
             <td align=center>$r[judul_topik]</td>
             <td align=center>$jml</td>"; 
        
		$date=substr("$r[tgl_post]",0,10);
		    $th=substr("$date",0,4);
			$bln=substr("$date",5,2);
			$d=substr("$date",8,2);
			
			$jam_post=substr("$r[tgl_post]",11,5);
			$tgl_post=$d.'-'.$bln.'-'.$th;
		
		echo"<td align=center>$tgl_post ($jam_post)</td>           
             <td align=center><a href='?module=komentar&act=detailisikomentar&id=$r[idtopik]' title='Detail'>Detail</a>
                 </td></tr>";
      $no++;
    }
    echo "</table>";
	 break;
	 
	 case "detailisikomentar":
	$topik=mysql_fetch_array(mysql_query("select t.*,k.*,u.* from siswa u,topik t,kategori k where u.id_siswa=t.iduser and t.idkategori=k.idkategori and t.idtopik=$_GET[id]"));
    echo "<form><fieldset>
          <legend>Detail Isi Topik</legend>
          <dl class='inline'>
          <dt><label>Idtopik</label></dt>   <dd> : $topik[idtopik]</dd>
          <dt><label>Id/Nama Kategori</label></dt>   <dd> : $topik[idkategori] / $topik[nm_kategori]</dd>
          <dt><label>Id/Nama User</label></dt>   <dd> : $topik[iduser] / $topik[nama_lengkap]</dd>
          <dt><label>Judul</label></dt>     <dd> : $topik[judul_topik]</dd>";
          
		  
			$date=substr("$topik[tgl_post]",0,10);
		    $th=substr("$date",0,4);
			$bln=substr("$date",5,2);
			$d=substr("$date",8,2);
			
			$jam_post=substr("$topik[tgl_post]",11,5);
			$tgl_post=$d.'-'.$bln.'-'.$th;
		  
		  echo"<dt><label>Tanggal Post</label></dt>       <dd> : $tgl_post ($jam_post)</dd>";
		  $komen=mysql_query("SELECT t.*,k.*,u.* FROM siswa u,topik t,komentar k where t.idtopik=k.idtopik and k.iduser=u.id_siswa and t.idtopik='$_GET[id]' ORDER BY k.tgl_post_komentar");
			
		  if((mysql_num_rows($komen))>0){
		  echo"<hr></hr><fieldset>
          <legend>Detail Isi Komentar</legend>
          <dl class='inline'>
		  ";
		  while($r2=mysql_fetch_array($komen)){
			echo"<dt><label>Idkomentar</label></dt>       <dd> : $r2[idkomentar]</dd>";
			echo"<dt><label>Id/namauser</label></dt>       <dd> : $r2[iduser] / $r2[nama_lengkap]</dd>";
			echo"<dt><label>Isi Komentar</label></dt>       <dd> : $r2[komentar]</dd>";
			
			
			$date=substr("$r2[tgl_post_komentar]",0,10);
		    $th=substr("$date",0,4);
			$bln=substr("$date",5,2);
			$d=substr("$date",8,2);
			
			$jam_post_komentar=substr("$r2[tgl_post_komentar]",11,5);
			$tgl_post_komentar=$d.'-'.$bln.'-'.$th;
		  
			
			echo"<dt><label>Tanggal Komentar</label></dt>       <dd> : $tgl_post_komentar ($jam_post_komentar)</dd>";
			echo"<dt><a href='?module=komentar&act=deletekomentar&idk=$r2[idkomentar]&id=$_GET[id]' title='Delete' onClick=\"return confirm('Anda Yakin Hapus Data dengan idk=$r2[idkomentar]')\"><img src='images/icons/delete.png' alt='Delete' /></a></dt>";
			echo"<dt><hr></hr></dt><dd><hr></hr></dd>";
			}
          echo "</dl>
          </fieldset>";
		  }else{
		  echo "<p><div class='information msg'>Tidak ada komentar</div></p>";
		  }
          echo "</dl>";
		  
          echo"<div class='buttons'>
          <input class='button blue' type=button value=Kembali onclick=self.history.back()>
          </div>
          </fieldset></form>";
     break;
	 
	 
	case "deletekomentar":
	if (! $_GET['idk']=="")
{
include "../lib/koneksi.php";
$sqlHapus	= "delete from komentar where idkomentar='".$_GET['idk']."'";
$queryHapus	= mysql_query($sqlHapus);
if($queryHapus)
{
echo "<script type='text/javascript'>
		alert ('Data Berhasil Dihapus...!!!')	
    </script>";
	echo "<script>window.location=(href='media_admin.php?module=komentar&act=detailisikomentar&id=$_GET[id]')</script>";
}else{
echo "<script type='text/javascript'>
	onload =function(){
	alert ('Data Gagal Dihapus...!!!');
	}
	</script>";
	echo "<script>window.location=(href='media_admin.php?module=komentar')</script>'>";
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
