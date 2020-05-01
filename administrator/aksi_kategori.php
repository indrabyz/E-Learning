<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=index.php><b>LOGIN</b></a></center>";
}
else{
include "../lib/koneksi.php";
//include "../config/fungsi_thumb.php";
//include "../config/library.php";

$module=$_GET[module];
$act=$_GET[act];

switch($_GET[act]){

// Input user
case "input_kategori":

  
                $simpan=mysql_query("INSERT INTO kategori(idkategori,
                                 nm_kategori,
                                 ket_kategori)
	                       VALUES('',
                                '$_POST[nm]',
                                '$_POST[ket]')");
                    
         if($simpan){
        echo "<script>window.alert('data tersimpan...!');window.location=(href='media_admin.php?module=kategori')</script>";
  }else{
      echo "<script>window.alert('data gagal disimpan.');window.location=(href='media_admin.php?module=kategori&act=tambahkategori')</script>";
  }
  break;
case "update_kategori":
                $update=mysql_query("UPDATE kategori SET nm_kategori= '$_POST[nm]',
                                  ket_kategori          = '$_POST[ket]'
                           WHERE  idkategori     = '$_POST[id]'");
                
                
            
		if($update){
        echo "<script>window.alert('data berhasil diedit');
        window.location=(href='media_admin.php?module=kategori')</script>";
      }
      else{
        echo "<script>window.alert('username tidak tersedia.');
        window.location=(href='media_admin.php?module=kategori&editkategori')</script>";
      }
  
  break;
  // Input user
case "deletekategori":
if (! $_GET['id']=="")
{
//include "../config/koneksi.php";
$sqlHapus	= "delete from kategori where idkategori='".$_GET['id']."'";
$queryHapus	= mysql_query($sqlHapus);
if($queryHapus)
{
echo "<script type='text/javascript'>
		alert ('Data Berhasil Dihapus...!!!')	
    </script>";
	echo "<script>window.location=(href='media_admin.php?module=kategori')</script>";
}else{
echo "<script type='text/javascript'>
	onload =function(){
	alert ('Data Gagal Dihapus...!!!');
	}
	</script>";
	echo "<script>window.location=(href='media_admin.php?module=kategori')</script>'>";
}
}
break;
  
  }
  
}
?>
