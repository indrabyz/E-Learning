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
include "../library/librari.php";
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
  echo "<body background='images/wood_pattern.jpg'><center><br><br><br><br><br><br>Maaf, untuk mengakses <b>Halaman Administrator</b><br>
  <center>anda harus <b>Login</b> dahulu!<br><br>";
 echo "<div> <a href='Login.php'><img src='images/admin.png'></a>
             </div>";
echo  "<br><input type=button class=btnsimpan value='LOGIN DI SINI' onclick=location.href='login.php'></center></body>";
}
 
else{

$aksi="aksi_kategori.php";
switch($_GET[act]){
  // Tampil User
  default:
      $tampil = mysql_query("SELECT * FROM kategori ORDER BY idkategori");
    echo "
	<h2>Manajemen Kategori</h2><hr></hr>
          <input class='button blue' type=button value='Tambah kategori' onclick=\"window.location.href='?module=kategori&act=tambahkategori';\">";
          echo "<br></br><div class='information msg'>Masukkan data kategori dengan benar pada semua fields</div>";
          echo "<table  id='table1' class='gtable sortable'><thead>";
		  echo "<body><table id='example' class='display' cellspacing='0' width='100%'><thead>
          <tr bgcolor=#34a5cf><th>No</th><th>Idkategori</th><th>Nama Kategori</th><th>Keterangan</th><th>Aksi</th></tr></thead><hr></hr>";
    
	$no=1;
    while ($r=mysql_fetch_array($tampil)){
       echo "<tr><td>$no</td>
             <td>$r[idkategori]</td>
             <td>$r[nm_kategori]</td>
             <td>$r[ket_kategori]</td>           
             <td><a href='?module=kategori&act=editkategori&id=$r[idkategori]' title='Edit'><img src='images/icons/edit.png' alt='Edit' /></a> |
                 <a href='$aksi?module=kategori&act=deletekategori&id=$r[idkategori]' title='Delete' onClick=\"return confirm('Anda Yakin Hapus Data dengan idkategori=$r[idkategori]')\"><img src='images/icons/delete.png' alt='Delete' /></a>
                 </td></tr>";
      $no++;
    }
    echo "</table>";
  
  break;
  
  case "tambahkategori":
    echo "<form method=POST action='$aksi?module=admin&act=input_kategori' enctype='multipart/form-data' class='form-login' role='form'>
          <fieldset>
          <legend>Tambah Kategori</legend>
          <dl class='inline'>";
          echo"<dt><label>Nama Kategori</label></dt>     <dd> : <input type=text name='nm' class='form-control' required></dd>
          <dt><label>Keterangan Kategori</label></dt>    <dd> : <textarea name='ket' col=350 rows=5 class='form-control' required></textarea></dd>";
    echo "</dl>
          <div class='buttons'>
          <input class='button blue' type=submit value=Simpan>
          <input class='button blue' type=button value=Batal onclick=self.history.back()>
          </div>
          </fieldset></form>";
    
    
     break;
 	
	case "editkategori":
    $edit=mysql_query("SELECT * FROM kategori WHERE idkategori='$_GET[id]'");
    $r=mysql_fetch_array($edit);

    echo "<form method=POST action=$aksi?module=admin&act=update_kategori enctype='multipart/form-data' class='form-login' role='form'>
          <fieldset>
          <legend>Edit Kategori</legend>
          <dl class='inline'>
          <dt><label>Idkategori</label></dt>          <dd> : $r[idkategori]<input type=hidden readonly=readonly name=id value='$r[idkategori]' class='form-control' required></dd>
          <dt><label>Nama Kategori</label></dt>          <dd> : <input type=text name='nm' value='$r[nm_kategori]' class='form-control' required></dd>
          <dt><label>Keterangan Kategori</label></dt>     <dd> : <textarea name=ket col=350 rows=5 class='form-control' required>$r[ket_kategori]</textarea>
                                               </dd>";
          
          echo "</dl>
          <div class='buttons'>
          <input class='button blue' type=submit value=Update>
          <input class='button blue' type=button value=Batal onclick=self.history.back()>
          </div>
          </fieldset></form>";    
    break;
	
	?>
	
</body>
</head>
</html>
	<?php
}
}
?>
