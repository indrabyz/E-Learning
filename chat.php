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

	<link rel="stylesheet" type="text/css" href="css/DataTables/media/css/jquery.dataTables.css">
	
	<script type="text/javascript" language="javascript" src="css/DataTables/media/js/jquery.js"></script>
	<script type="text/javascript" language="javascript" src="css/DataTables/media/js/jquery.dataTables.js"></script>
	
	<script>
$(document).ready(function() {
	$('#example').DataTable();
} );
	</script>
</head>

<?php

session_start();
error_reporting(0);

if (empty($_SESSION['idsiswa'])){
  echo "<body background='images/vichy.png'><center><br><br><br><br><br><br>Maaf, untuk mengakses <b>Halaman User</b><br>
  <center>anda harus <b>Login</b> dahulu!<br><br>";
 echo "<div> <a href='index.php'><img src='admin/images/admin.png'></a>
             </div>";
echo  "<br><input type=button class=btnsimpan value='LOGIN DI SINI' onclick=location.href='index.php'></center></body>";
}
 
else{

$aksi="aksi_chat.php";
switch($_GET[act]){
  // Tampil Chat
  default:
      
    //echo "<h2 class='pageTitle''><span>Pesan Masuk</span></h2>";
	
	$r2=mysql_fetch_array(mysql_query("select * from siswa where id_siswa='$_SESSION[idsiswa]'"));
			  
    
	$tampil = mysql_query("SELECT c.*,u.* FROM chat c,siswa u where (u.id_siswa=c.dari or u.id_siswa=c.ke) and (c.ke='$_SESSION[idsiswa]' or c.dari='$_SESSION[idsiswa]') group by u.id_siswa order by c.tgl_pesan DESC");
	$no=1;
	if((mysql_num_rows($tampil))<1){
			echo"<h5>
					<a href='#'><small>&nbsp;&nbsp;&nbsp;<i class='icon-comments'></i>&nbsp;tidak ada percakapan $_SESSION[idsiswa]</small></a>
				</h5>
				<h5>
					<a href='#'><small>&nbsp;&nbsp;&nbsp;<i class='icon-comments'></i>&nbsp;cari user untuk mulai percakapan</small></a>
				</h5>";
	}else{
	echo "<table id='example' class='display' cellspacing='0' width='99%'><thead><tr bgcolor=#34a5cf><th></th><th>Pengirim</th></tr></thead><hr class='homeseparator'></hr>";
    
    while ($r=mysql_fetch_array($tampil)){
	
		$r2=mysql_query("SELECT * from chat where (dari='$r[id_siswa]' and ke='$_SESSION[idsiswa]') or (dari='$_SESSION[idsiswa]' and ke='$r[id_siswa]') order by tgl_pesan DESC");
		$jmlp=mysql_num_rows($r2);
		$isi=mysql_fetch_array($r2);
		if($r[id_siswa] != $_SESSION[idsiswa]){
       echo "<tr><td width='50'><a href='?module=drzchat&id=$r[id_siswa]'>";
	   if($r[level]==dosen){
				$dir="foto_pengajar";
				
				$dos=$dosen;
				}else{
				$dir="foto_siswa";
				}
	   if ($r[foto]!=''){
				
					echo "<img src='$dir/medium_$r[foto]' class='foto-profil' height='100' width='100'>";
			}else{
				echo "<img src='images/profil.jpg' class='foto-profil' height='100' width='100'>";
			}
			$isi_pesan=substr("$isi[isi_pesan]",0,25);
			$jml_kar=strlen($isi_pesan);
			if($jml_kar >= 20){
			$titik="...";
			}else{
			$titik="";
			}
	   echo"</td><td><a href='?module=drzchat&id=$r[id_siswa]'>$r[nama_lengkap] $dos</a><a href='?module=chat&act=deletechat&idd=$r[id_siswa]&idk=$_SESSION[idsiswa]' title='Delete' onClick=\"return confirm('Anda Yakin Hapus Data Percakapan dari idd=$r[dari] ke idk=$r[ke]' )\"><img src='images/icons/delete.gif' alt='Delete' /></a>
             <a href='?module=drzchat&id=$r[id_siswa]'><small><p><font size='2'>$isi_pesan $titik </font></p>";
					
					if($r[id_siswa]==$isi[dari]){
						if($isi[status]=='D'){
							echo"<img src='images/icons/bullet_yellow.png'> ";
						}else{
							echo"<img src='images/icons/bullet_gray.png' >";
						}
					}else{
						if($isi[status]=='D'){
							echo"<img src='images/icons/delivery.png'> ";
						}else{
							echo"<img src='images/icons/read.png'> ";
						}
					}
			$date=substr("$isi[tgl_pesan]",0,10);
		    $th=substr("$date",0,4);
			$bln=substr("$date",5,2);
			$d=substr("$date",8,2);
			
			$jam_pesan=substr("$isi[tgl_pesan]",11,8);
			$tgl_pesan=$d.'-'.$bln.'-'.$th;
			
			echo"<font size='1'>| <i>$tgl_pesan ($jam_pesan)</i></font></small></p></a></a>
			     </td></tr>";
			}	 
      $no++;
    }
    echo "</table>";
  }
  break;
	 
	 case "detailisichat":
	 if($user[iduser] == $_GET[idk]){
	 	$read=mysql_query("update chat set status='R' where dari='$_GET[idd]' and ke='$user[iduser]'");
	if($read){
	
	$detail = mysql_query("SELECT c.* from chat c where (c.dari='$_GET[idd]' and c.ke='$user[iduser]') or (c.dari='$user[iduser]' and c.ke='$_GET[idd]') order by c.tgl_pesan ASC");
	
	$penerima=(mysql_fetch_array(mysql_query("select * from user where iduser=$_GET[idk]")));
	$r4=(mysql_fetch_array(mysql_query("select * from user where iduser=$_GET[idd]")));
	echo "<h4><span><strong><center>$r4[nama_lengkap]</center></strong></span></h4>";
    echo"<h6 class='pull-right'><div class='dropdown btn'>
				<a class='dropdown-toggle' data-toggle='dropdown' href='#'>
							<i class=''></i>
								Option
								<b class='caret'></b></a>
						</a>
						<div class='dropdown-menu' role='menu' aria-labelledby='dLabel'>
							<a href='?module=chat&act=deletechat&idd=$_GET[idd]&idk=$_GET[idk]' title='Delete' onClick=\"return confirm('Anda Yakin Hapus Data Percakapan dari idd=$_GET[idd] ke idk=$_GET[idk]' )\">&nbsp;Hapus&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
						</div>
					</div></h6>";
	echo"<hr class='homeseparator'/>";
if((mysql_num_rows($detail))<1){
			echo"<h5>
					<a href='#'><small>&nbsp;&nbsp;&nbsp;<i class='icon-comments'></i>&nbsp;tidak ada percakapan</small></a>
				</h5>";
	}else{
	
	
	echo"<div class='main' style='border:1px solid #ddd;overflow:auto;height:350px'>";
		  while($r=mysql_fetch_array($detail)){
				
				$date=substr("$r[tgl_pesan]",0,10);
			$th=substr("$date",0,4);
			$bln=substr("$date",5,2);
			$d=substr("$date",8,2);
			$get_t=$d.'-'.$bln.'-'.$th;
				
				$jam=substr("$r[tgl_pesan]",11,5);
				
				
				if($get_t!=$get_t2){
					$get_t2=$get_t;
					echo"<center><h5>
					<small>&nbsp;&nbsp;&nbsp;&nbsp;$get_t</small></a>
					</h5></center>";
				}else{
					$get_t2=$get_t;
				}
				
				if($r[ke]==$user[iduser]){
				$r3=(mysql_fetch_array(mysql_query("select * from user where iduser=$_GET[idd]")));
				echo"<div class='me'>
						<div class='foto'>";
						if ($r3[foto]!=''){
							echo"<a href=?module=user&id=$r3[iduser]><img src='foto_user/medium_$r3[foto]' class='foto'></a>";
						}else{
							echo"<a href=?module=user&id=$r3[iduser]><img src='images/profil.jpg' class='foto'></a>";
						}
						echo"</div>
						<table class='me'>
						<tr>
							<td>
								<div class='tgl'>$jam</div>";
								echo"<div class='chat-you'>";
									if($r[status]=='D'){
										echo"<img src='images/icons/bullet_yellow.png'>";
									}else{
										echo"<img src='images/icons/bullet_gray.png'>";
									}
								echo"$r[isi_pesan]</div>
							</td>
						</tr>
						</table>
					</div><div class='clear'></div>";
				}elseif($r[dari]){	
					echo"<div class='you'>	
						<div class='foto2'>";
						if ($penerima[foto]!=''){
							echo"<a href=?module=user&id=$user[iduser]><img src='foto_user/medium_$penerima[foto]' class='foto2'></a>";
						}else{
							echo"<a href=?module=user&id=$user[iduser]><img src='images/profil.jpg' class='foto2'></a>";
						}
						echo"</div>
						<table class='you'>
						<tr>
						<td align='right'>
						<div class='tgl'>$jam</div>
						<div class='chat-me'>$r[isi_pesan]";
							if($r[status]=='D'){
										echo" <img src='images/icons/delivery.png'> ";
									}else{
										echo" <img src='images/icons/read.png'> ";
									}
						echo"</div>
						</td>
						</tr>	
						</table>
					</div><div class='clear'></div>";
				}
			}	
		
		}
		  echo"<div class='clear'></div></div>";
		  ?>
		  <form action="?module=chat&act=kirimpesan" method="post" style="margin:0px;">
			<p>
			<label for="editor1"><small>
				&nbsp;&nbsp;&nbsp;<i class='icon-comments'></i>&nbsp;Chat :</small></label>
			<input name=ke type=hidden value=<?php echo"$_GET[idd]"; ?> hidden>
			<input name=dari type=hidden value=<?php echo"$_GET[idk]"; ?> hidden>
		  
			<center><textarea cols="80" id="isi" name="pesan" rows="10"></textarea></center>
<script type="text/javascript" src="./tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
<script type="text/javascript">
function ajaxfilemanager(field_name, url, type, win) {
   var ajaxfilemanagerurl = "./tinymce/jscripts/tiny_mce/plugins/ajaxfilemanager/ajaxfilemanager.php";
   switch (type) {
    case "image":
     break;
    case "media":
     break;
    case "flash": 
     break;
    case "file":
     break;
    default:
     return false;
   }
            tinyMCE.activeEditor.windowManager.open({
                url: "./tinymce/jscripts/tiny_mce/plugins/ajaxfilemanager/ajaxfilemanager.php",
                inline : "yes",
                close_previous : "no"
            },{
                window : win,
                input : field_name
            });
            
             /*            return false;   
   var fileBrowserWindow = new Array();
   fileBrowserWindow["file"] = ajaxfilemanagerurl;
   fileBrowserWindow["title"] = "Ajax File Manager";
   fileBrowserWindow["width"] = "782";
   fileBrowserWindow["height"] = "440";
   fileBrowserWindow["close_previous"] = "no";
   tinyMCE.openWindow(fileBrowserWindow, {
     window : win,
     input : field_name,
     resizable : "yes",
     inline : "yes",
     editor_id : tinyMCE.getWindowArg("editor_id")
   });
   
   return false;*/
  }
</script>

<script type="text/javascript">
 tinyMCE.init({
  
  // General options
  mode : "textareas",
  elements : "ajaxfilemanager",
  file_browser_callback : 'ajaxfilemanager',
  theme : "advanced",
  plugins : "safari,style,table,advimage,advlink,emotions,inlinepopups,media,directionality,searchreplace,noneditable,nonbreaking,xhtmlxtras,template,wordcount",

  // Theme options
 theme_advanced_buttons1 : "fontselect,fontsizeselect,|,sub,sup",
 theme_advanced_buttons2 : "link,unlink,image,emotions,code,|,forecolor,|,bold,italic,underline",
 theme_advanced_buttons3 : "cut,copy,paste,|,bullist,numlist,|,charmap,strikethrough",
 
  theme_advanced_toolbar_location : "top",
  theme_advanced_toolbar_align : "left",
  theme_advanced_statusbar_location : "bottom",
  theme_advanced_resizing : true,
  relative_urls : false,
  remove_script_host : false,
  // Example content CSS (should be your site CSS)
  content_css : "css/content.css",

  // Drop lists for link/image/media/template dialogs
  

  // Replace values for the template plugin
  template_replace_values : {
   username : "Some User",
   staffid : "991234"
  }
 });
</script>
			</p>
			<p>
				<input type="submit" class="btn btn-success pull-right" value="Kirim"></input>
				<a class="btn pull-right" href="?module=chat&act=detailisichat&idd=<?php echo $_GET[idd]?>&idk=<?php echo $_GET[idk] ?>">Refresh</a>
				
				<hr class="homeseparator"/>
			</p>
			</form>
		  <?php
		  }
          }
		  else{
		  echo "<div class='information msg'>Anda tidak berhak untuk melihat percakapan</div>";
		  }
     break;
	 
	 
	case "deletechat":
	if (! $_GET['idd']=="" and ! $_GET['idk']=="")
{
include "lib/Koneksi.php";
$sqlHapus	= "delete from chat where ((dari='".$_GET['idd']."' and ke='".$_GET['idk']."')or(dari='".$_GET['idk']."' and ke='".$_GET['idd']."'))";
$queryHapus	= mysql_query($sqlHapus);
if($queryHapus)
{
echo "<script type='text/javascript'>
		alert ('Data Berhasil Dihapus...!!!')	
    </script>";
	echo "<script>window.location=(href='media_user.php?module=chat')</script>";
}else{
echo "<script type='text/javascript'>
	onload =function(){
	alert ('Data Gagal Dihapus...!!!');
	}
	</script>";
	echo "<script>window.location=(href='media_user.php?module=chat')</script>'>";
}
}
    break;
	
	case "deletepesan":
	if (! $_GET['id']=="")
{
include "lib/Koneksi.php";
$sqlHapus	= "delete from chat where idchat='".$_GET['id']."'";
$queryHapus	= mysql_query($sqlHapus);
if($queryHapus)
{
echo "<script type='text/javascript'>
		alert ('Data Berhasil Dihapus...!!!')	
    </script>";
	echo "<script>window.location=(href='?module=chat&act=detailisichat&idd=$_GET[idd]&idk=$_GET[idk]')</script>";
}else{
echo "<script type='text/javascript'>
	onload =function(){
	alert ('Data Gagal Dihapus...!!!');
	}
	</script>";
	echo "<script>window.location=(href='?module=chat&act=detailisichat&idd=$_GET[idd]&idk=$_GET[idk]')</script>'>";
}
}
    break;
	
	case "kirimpesan":
	if (! $_SESSION[nama_user]==""){
	
	if($_GET[id]==""){
	date_default_timezone_set('Asia/Jakarta');
		$tgl_skr=date('Y-m-d H:i:s');
		$sql=mysql_fetch_array(mysql_query("select * from user where username='$_SESSION[nama_user]'"));
		$sqlSimpan	= "INSERT INTO chat(idchat,
                                 dari,
                                 ke,
                                 isi_pesan,
                                 tgl_pesan)
	                       VALUES('',
                                '$user[iduser]',
								'$_POST[ke]',
                                '$_POST[pesan]',
                                '$tgl_skr')";
$query3	= mysql_query($sqlSimpan);

if($query3){
    echo "<script type='text/javascript'>
		alert ('Pesan terkirim...!!!')	
    </script>";
	echo "<center><br><br><img src=images/ajax-loader.gif></br></br></center>";
	echo "<meta http-equiv='refresh' content='0; url=?module=chat&act=detailisichat&idd=$_POST[ke]&idk=$user[iduser]'>";
}else{
echo "<script type='text/javascript'>
	onload =function(){
	alert ('pesan Gagal Disimpan...!!!');
	}
	</script>";
	echo "<meta http-equiv='refresh' content='0; url=?module=chat&act=detailisichat&idd=$_POST[ke]&idk=$user[iduser]'>";
}
	}elseif($_GET[id]=="2"){
	
	date_default_timezone_set('Asia/Jakarta');
		$tgl_skr=date('Y-m-d H:i:s');
		$sql=mysql_fetch_array(mysql_query("select * from user where username='$_SESSION[nama_user]'"));
		$sqlSimpan	= "INSERT INTO chat(idchat,
                                 dari,
                                 ke,
                                 isi_pesan,
                                 tgl_pesan)
	                       VALUES('',
                                '$user[iduser]',
								'$_POST[nama]',
                                '$_POST[pesan]',
                                '$tgl_skr')";
$query3	= mysql_query($sqlSimpan);

if($query3){
	echo "<center><br><br><img src=images/ajax-loader.gif></br></br></center>";
	echo "<meta http-equiv='refresh' content='0; url=drzchat.php?id=$_POST[nama]'>";
}else{
echo "<center><br><br><img src=images/ajax-loader.gif></br></br></center>";
	echo "<meta http-equiv='refresh' content='0; url=drzchat.php?id=$_POST[nama]'>";
	}
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
