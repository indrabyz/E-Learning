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
include "../lib/koneksi.php";
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
  echo "<body background='images/wood_pattern.jpg'><center><br><br><br><br><br><br>Maaf, untuk mengakses <b>Halaman Administrator</b><br>
  <center>anda harus <b>Login</b> dahulu!<br><br>";
 echo "<div> <a href='Login.php'><img src='images/admin.png'></a>
             </div>";
echo  "<br><input type=button class=btnsimpan value='LOGIN DI SINI' onclick=location.href='login.php'></center></body>";
}
 
else{

$aksi="aksi_chat.php";
switch($_GET[act]){
  // Tampil Kategori
  default:
      $tampil = mysql_query("SELECT * FROM siswa ORDER BY username_login");
    echo "
	<h2>Manajemen Chatting</h2><hr></hr>";
          echo "<div class='information msg'>Pilih user & klik detail untuk melihat percakapan</div>";
          echo "<table  id='table1' class='gtable sortable'><thead>";
		  echo "<body><table id='example' class='display' cellspacing='0' width='100%'><thead>
          <tr bgcolor=#34a5cf><th>No</th><th>Iduser</th><th>Username</th><th>Nama Lengkap</th><th>E-mail</th><th>Level</th><th>Jml Percakapan</th><th>Aksi</th></tr></thead><hr></hr>";
    
	$no=1;
    while ($r=mysql_fetch_array($tampil)){
	
		$r2=mysql_query("SELECT u.*,c.* from chat c,siswa u where (u.id_siswa=c.dari or u.id_siswa=c.ke) and ((c.ke='$r[id_siswa]') or (c.dari='$r[id_siswa]')) and u.id_siswa != '$r[id_siswa]' group by u.id_siswa");
		$jml=mysql_num_rows($r2);
       echo "<tr><td align=center>$no</td>
             <td align=center>$r[id_siswa]</td>
             <td align=center>$r[username_login]</td>
             <td align=center>$r[nama_lengkap]</td>
			 <td><a href=mailto:$r[email]>$r[email]</a></td>
			 <td align=center>$r[level]</td>
             <td align=center>$jml</td>           
             <td align=center><a href='?module=chat&act=detailchat&id=$r[id_siswa]' title='Detail'>Detail</a></a>
                 </td></tr>";
      $no++;
    }
    echo "</table>";
  
  break;
  
  case "detailchat":
	$tampil = mysql_query("SELECT c.*,u.* FROM chat c,siswa u where (u.id_siswa=c.dari or u.id_siswa=c.ke) and (c.ke='$_GET[id]' or c.dari='$_GET[id]') and u.id_siswa != $_GET[id] group by u.id_siswa order by c.tgl_pesan ASC");
    echo "
	<h2>Manajemen Chatting</h2><hr></hr>";
          echo "<div class='information msg'>Pilih detail untuk melihat isi percakapan</div>";
          echo "<table  id='table1' class='gtable sortable'><thead>";
	$r2=mysql_fetch_array(mysql_query("select * from siswa where id_siswa='$_GET[id]'"));
	echo"Iduser : $r2[username] Nama : $r2[nama_lengkap]";
			  
    echo "<table id='example' class='display' cellspacing='0' width='100%'><thead>
          <tr bgcolor=#34a5cf><th>No</th><th>Iduser</th><th>username</th><th>Nama Lengkap</th><th>E-mail</th><th>Level</th><th>Jumlah Pesan</th><th>Aksi</th></tr></thead><hr></hr>";
    
	$no=1;
    while ($r=mysql_fetch_array($tampil)){
	
		$r2=mysql_query("SELECT * from chat where (dari='$r[id_siswa]' and ke='$_GET[id]') or (dari='$_GET[id]' and ke='$r[id_siswa]')");
		$jmlp=mysql_num_rows($r2);
       echo "<tr><td align=center>$no</td>
             <td align=center>$r[id_siswa]</td>
             <td align=center>$r[username_login]</td>
             <td align=center>$r[nama_lengkap]</td>
			 <td align=center><a href=mailto:$r[email]>$r[email]</a></td>
             <td align=center>$r[level]</td>  
             <td align=center>$jmlp</td>     
             <td align=center><a href='?module=chat&act=detailisichat&idd=$r[id_siswa]&idk=$_GET[id]' title='Detail'>Detail</a>
			 <a href='?module=chat&act=deletechat&idd=idd=$r[id_siswa]&idk=$_GET[id]' title='Delete' onClick=\"return confirm('Anda Yakin Hapus Data Percakapan dari idd=$r[dari] ke idk=$r[ke]' )\"><img src='images/icons/delete.png' alt='Delete' /></a>
                 </td></tr>";
      $no++;
    }
    echo "</table>";
     break;
	 
	 case "detailisichat":
	$detail = mysql_query("SELECT * from chat where (dari='$_GET[idd]' and ke='$_GET[idk]') or (dari='$_GET[idk]' and ke='$_GET[idd]') order by tgl_pesan ASC");

    echo "<form><fieldset>
          <legend>Detail Isi Chat</legend>";
		  $penerima=(mysql_fetch_array(mysql_query("select * from siswa where id_siswa=$_GET[idk]")));
		  echo"<dl class='inline'><dt><label>Id/Nama Penerima</label></dt><dd> : $_GET[idk] / $penerima[nama_lengkap]</dd></dl>";
		  echo"<form><fieldset>
          <legend>Chat</legend>";
		  while($r=mysql_fetch_array($detail)){
		  echo"<dl class='inline'>
          <dt><label>Idchat</label></dt><dd> : $r[idchat]</dd>";
		  
		  $r2=mysql_query("SELECT * from user where iduser='$r[dari]'");
			$r12=mysql_fetch_array($r2);
		
			$date=substr("$r[tgl_pesan]",0,10);
		    $th=substr("$date",0,4);
			$bln=substr("$date",5,2);
			$d=substr("$date",8,2);
			
			$jam_pesan=substr("$r[tgl_pesan]",11,5);
			$tgl_pesan=$d.'-'.$bln.'-'.$th;
		  
          echo"<dt><label>Id/Nama User Pengirim</label></dt><dd> : $r[dari] / $r12[nama_lengkap]</dd>";
		 
		  echo"<dt><label>Isi pesan</label></dt><dd> : $r[isi_pesan]</dd>
		  <dt><label>Status</label></dt><dd> : $r[status]</dd>
		  <dt><label>Tanggal chat</label></dt><dd> : $tgl_pesan ($jam_pesan)</dd>
		  <dt></dt>
		  <a href='?module=chat&act=deletepesan&id=$r[idchat]&idd=$_GET[idd]&idk=$_GET[idk]' title='Delete' onClick=\"return confirm('Anda Yakin Hapus Data dengan id=$r[idchat]')\"><img src='images/icons/delete.png' alt='Delete' /></a>
		  </dl><hr></hr>";
			}
		echo"</fieldset></form>";
          echo "<dl class='inline'><dt><a href='?module=chat&act=detailisichat&idd=$_GET[idd]&idk=$_GET[idk]'><img src='../images/ico_alpha_Refresh_32x32.png' height='30'></a></dt>
		  <dd align=right><input class='button blue' type=button value=Kembali onclick=self.history.back()></dd></dl>
          </fieldset></form>";
     break;
	 
	 
	case "deletechat":
	if (! $_GET['idd']=="" and ! $_GET['idk']=="")
{
include "../lib/koneksi.php";
$sqlHapus	= "delete from chat where dari='".$_GET['idd']."' and ke='".$_GET['idk']."'";
$queryHapus	= mysql_query($sqlHapus);
if($queryHapus)
{
echo "<script type='text/javascript'>
		alert ('Data Berhasil Dihapus...!!!')	
    </script>";
	echo "<script>window.location=(href='media_admin.php?module=chat')</script>";
}else{
echo "<script type='text/javascript'>
	onload =function(){
	alert ('Data Gagal Dihapus...!!!');
	}
	</script>";
	echo "<script>window.location=(href='media_admin.php?module=chat')</script>'>";
}
}
    break;
	
	case "deletepesan":
	if (! $_GET['id']=="")
{
include "../config/koneksi.php";
$sqlHapus	= "delete from chat where idchat='".$_GET['id']."'";
$queryHapus	= mysql_query($sqlHapus);
if($queryHapus)
{
echo "<script type='text/javascript'>
		alert ('Data Berhasil Dihapus...!!!')	
    </script>";
	echo "<script>window.location=(href='media_admin.php?module=chat&act=detailisichat&idd=$_GET[idd]&idk=$_GET[idk]')</script>";
}else{
echo "<script type='text/javascript'>
	onload =function(){
	alert ('Data Gagal Dihapus...!!!');
	}
	</script>";
	echo "<script>window.location=(href='media_admin.php?module=chat&act=detailisichat&idd=$_GET[idd]&idk=$_GET[idk]')</script>'>";
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
