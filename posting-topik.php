<?php 
session_start();
error_reporting(0);
 if (empty($_SESSION['idsiswa'])){
  echo "<style>
			body {
				background: #e1c192 url(images/overlay.png);
				background-size:100%;
				color:#333;
			}
</style><body><center><br><br><br><br><br><br><b>Untuk mengakses modul, Anda harus login! </b>";
		echo "<div><br></br><a href='index.php'><img src='images/ico_alpha_noSSLwarn_32x32.png' ><br></br></a>
             </div>";
  echo "<input type=submit name='submit' value='LOGIN' onclick=location.href='index.php?module=login'></a></center></body>";
}
else{
include"config/koneksi.php";
$user1=mysql_fetch_array(mysql_query("select * from user where username='$_SESSION[nama_user]'"));

 ?>
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

include "config/koneksi.php";
include "config/fungsi_thumb_topik.php";

switch($_GET[act]){
  // Tampil Kategori
  default:
  
		echo"<h2 class='pageTitle'><span>Topik</span></h2><h6 class='pull-right'><a href='?module=posting-topik&act=inputtopik' class='btn btn-success'>Topik Baru </a></h6>
			<hr class='homeseparator'/>";
          echo "<body><table id='example' class='display' cellspacing='0' width='99%'><thead>
          <tr bgcolor=#34a5cf><th width=500>Judul Topik</th><th>Tanggal Post</th><th>Aksi</th></tr></thead><hr></hr>";

	$tampil = mysql_query("SELECT t.*,k.* FROM topik t,kategori k  where k.idkategori=t.idkategori and t.iduser=$_SESSION[idsiswa] ORDER BY t.tgl_post DESC");
    while ($r=mysql_fetch_array($tampil)){
       echo "<tr>
             <td><small><a href='?module=topik&act=detailisitopik&id=$r[idtopik]' title='Detail'>$r[judul_topik]</a>&nbsp;
			 <i class='icon-tag'></i><a href='?module=topik&act=detailtopik&id=$r[idkategori]' style='color:#5555ff;'>(<i>$r[nm_kategori]</i>)</a>
			 </small></td>
             <td><small>$r[tgl_post]</small></td>
			<td>
			<a href='?module=posting-topik&act=edittopik&id=$r[idtopik]'><img src='images/icons/edit.png' alt='Delete' title='Edit'/></a>
			<a href='?module=posting-topik&act=deletetopik&id=$r[idtopik]' title='Delete' onClick=\"return confirm('Anda Yakin Hapus Data dengan idtopik=$r[idtopik]')\"><img src='images/icons/delete.png' alt='Delete' /></a>
			</td>
             </tr>";
    
    }
    echo "</table>";
	
  break;
  
  case"inputtopik":
	?>
	<html>

<head>
	<script type="text/javascript">
	$(document).ready(function() 
    	{ 
      	  $(".tablesorter").tablesorter(); 
   	 } 
	);
	$(document).ready(function() {

	//When page loads...
	$(".tab_content").hide(); //Hide all content
	$("ul.tabs li:first").addClass("active").show(); //Activate first tab
	$(".tab_content:first").show(); //Show first tab content

	//On Click Event
	$("ul.tabs li").click(function() {

		$("ul.tabs li").removeClass("active"); //Remove any "active" class
		$(this).addClass("active"); //Add "active" class to selected tab
		$(".tab_content").hide(); //Hide all tab content

		var activeTab = $(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
		$(activeTab).fadeIn(); //Fade in the active ID content
		return false;
	});

});
    </script>
    <script type="text/javascript">
    $(function(){
        $('.column').equalHeight();
    });
</script>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
</head>

<body>

			<header><h2 class='pageTitle'><span>Post Topik Baru</span></h2></header>
			<div class="well">
	<form method="POST" action="?module=posting-topik&act=simpantopik" enctype='multipart/form-data' id="contact-form1" class="form">
	
							<div class="control-group">
					      <label class="control-label" for="judul">Judul Topik</label>
					      <div class="controls">
					        <input type="text" name="judul" id="judul">
					      </div>
					    </div>
						<div class='control-group'>
					      <label class='control-label' for='upload'>Gambar</label>
					      <div class='controls'>
					        <input type='file' name='fupload' id='upload'>
					      </div>
						  <h5>
						<a href='#'><small>&nbsp;&nbsp;&nbsp;<i class='icon-comments'></i>&nbsp;Tipe foto harus JPG/JPEG/PNG/GIF dan ukuran lebar maks: 400 px</small></a>
							</h5>
					    </div>
						
		<label>Category</label>
		<select name="cat" style="width:92%;">
				<?php 
			$query = mysql_query("SELECT * FROM kategori");
			echo"<option value=0>- Pilih kategori -</option>";
			while ($t = mysql_fetch_array($query)){ ?>
				<option value="<?php echo $t['idkategori']; ?>"><?php echo $t['nm_kategori']; ?></option>
		<?php } ?>
		</select>
			
		</div>
				<h5>
					<a href='#'><small>&nbsp;&nbsp;&nbsp;<i class='icon-comments'></i>&nbsp;Isi Topik</small></a>
				</h5>
			<center><textarea rows="12" id="isi" name="isi"></textarea></center>
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
 theme_advanced_buttons1 : "fontselect,fontsizeselect,|,bold,italic,underline,strikethrough",
 theme_advanced_buttons2 : "link,unlink,image,emotions,code,|,forecolor,|,sub,sup,|,search",
 theme_advanced_buttons3 : "cut,copy,paste,|,bullist,numlist,|,charmap,|,justifyleft,justifycenter,justifyright,justifyfull",
 
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
		<h5>
			<a href='#'><small>&nbsp;&nbsp;&nbsp;<i class='icon-comments'></i>&nbsp;klik icon maximize untuk fullscreen</small></a>
		</h5>
	
	<div class="well">
		<p>
		<input type="submit" class="btn btn-success" name="submit" value="Simpan" />
		<a class="btn btn-danger" href='?module=posting-topik'>Kembali<a/>
		</p>
	</div>
	</form>
		
	</body>
</html>

	<?php
  break;
  
  case"edittopik":
	
	if(! $_GET[id] ==""){
	$r=mysql_fetch_array(mysql_query("select * from topik where idtopik='$_GET[id]' and iduser='$_SESSION[idsiswa]'"));
	?>
	<html>

<head>
	<script type="text/javascript">
	$(document).ready(function() 
    	{ 
      	  $(".tablesorter").tablesorter(); 
   	 } 
	);
	$(document).ready(function() {

	//When page loads...
	$(".tab_content").hide(); //Hide all content
	$("ul.tabs li:first").addClass("active").show(); //Activate first tab
	$(".tab_content:first").show(); //Show first tab content

	//On Click Event
	$("ul.tabs li").click(function() {

		$("ul.tabs li").removeClass("active"); //Remove any "active" class
		$(this).addClass("active"); //Add "active" class to selected tab
		$(".tab_content").hide(); //Hide all tab content

		var activeTab = $(this).find("a").attr("href"); //Find the href attribute value to identify the active tab + content
		$(activeTab).fadeIn(); //Fade in the active ID content
		return false;
	});

});
    </script>
    <script type="text/javascript">
    $(function(){
        $('.column').equalHeight();
    });
</script>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
</head>

<body>

			<header><h2 class='pageTitle'><span>Edit Topik</span></h2></header>
			
			<div class="well">
			
	<form method="POST" action="?module=posting-topik&act=updatetopik" enctype='multipart/form-data' id="contact-form" class="form">
	
			<label>Judul Topik</label>
			<input type="hidden" name="id" value='<?php echo $_GET[id] ?>'>
			<input type="text" name="judul" value='<?php echo $r[judul_topik] ?>'>
			
			<div class='control-group'><label class='control-label' for='foto'>Foto</label>
			<div class='controls'>
               <?php 
			   if ($r[gambar]!=''){ 
					echo "<img src='foto_topik/$r[gambar]' class='foto-topik' height='150' width='150'";
				}else{
					echo "<img src='images/profil.jpg' class='foto-topik' height='150' width='150'>";
				}
				
				echo "</div></div>";
				?>
			
			<div class='control-group'><label class='control-label' for='ganti_foto'>Ganti Foto</label>
			<div class='controls'>
			<input type='file' name='fupload'/>
			</div>
				<h5>
					<a href='#'><small>&nbsp;&nbsp;&nbsp;<i class='icon-comments'></i>&nbsp;Tipe foto harus JPG/JPEG/PNG/GIF dan ukuran lebar maks: 400 px</small></a>
				</h5>
				<h5>
					<a href='#'><small>&nbsp;&nbsp;&nbsp;<i class='icon-comments'></i>&nbsp;Apabila foto tidak diubah, dikosongkan saja</small></a>
				</h5>
			</div>
			
		<label>Category</label>
		<select name="cat" style="width:92%;">
				<?php 
			$query = mysql_query("SELECT * FROM kategori");
			echo"<option value=0>- Pilih kategori -</option>";
			while ($t = mysql_fetch_array($query)){ ?>
				<option value="<?php echo $t['idkategori']; ?>" <?php if($r[idkategori]==$t['idkategori']){ echo "selected"; } ?>><?php echo $t['nm_kategori']; ?></option>
		<?php } ?>
		</select>
		</div>
		<h5>
					<a href='#'><small>&nbsp;&nbsp;&nbsp;<i class='icon-comments'></i>&nbsp;Isi Topik</small></a>
				</h5>
			<center><textarea rows="12" id="isi" name="isi"><?php echo"$r[isi_topik]"; ?></textarea></center>
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
 theme_advanced_buttons1 : "fontselect,fontsizeselect,|,bold,italic,underline,strikethrough",
 theme_advanced_buttons2 : "link,unlink,image,emotions,code,|,forecolor,|,sub,sup,|,search",
 theme_advanced_buttons3 : "cut,copy,paste,|,bullist,numlist,|,charmap,|,justifyleft,justifycenter,justifyright,justifyfull",
 
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
		<h5>
			<a href='#'><small>&nbsp;&nbsp;&nbsp;<i class='icon-comments'></i>&nbsp;klik icon maximize untuk fullscreen</small></a>
		</h5>
<div class="well">
		<input type="submit" class="btn btn-success" name="submit" value="Ubah" />
		<input type="reset" class="btn" value="Batal">
	</div>
	</form>
			
	</body>
</html>

	<?php
	}
  break;
  
  case"simpantopik":
  date_default_timezone_set('Asia/Jakarta');
		$tgl_skr=date('Y-m-d H:i:s');
		
	$lokasi_file    = $_FILES['fupload']['tmp_name'];
  $tipe_file      = $_FILES['fupload']['type'];
  $nama_file      = $_FILES['fupload']['name'];
  $direktori_file = "./foto_topik/$nama_file";	
	if (!empty($lokasi_file)){
		if (file_exists($direktori_file)){
            echo "<script>window.alert('Nama file gambar sudah ada, mohon diganti dulu');
            window.location=(href='?module=posting-topik&act=inputtopik')</script>";
            }else{
				if($tipe_file != "image/jpeg" AND $tipe_file != "image/jpg" AND $tipe_file != "image/png" AND $tipe_file != "image/gif")
				{
					echo "<script>window.alert('Tipe File tidak di ijinkan.');
					window.location=(href='?module=posting-topik&act=inputtopik')</script>";
                }else{
					UploadImage($nama_file);
					
					$simpan=mysql_query("INSERT INTO topik(idtopik,
                                 idkategori,
                                 iduser,
								 judul_topik,
								 isi_topik,
								 tgl_post,gambar)
	                       VALUES('',
                                '$_POST[cat]',
								'$_SESSION[idsiswa]',
								'$_POST[judul]',
                                '$_POST[isi]',
								'$tgl_skr','$nama_file')");
				}
			}
	}else{
  $simpan=mysql_query("INSERT INTO topik(idtopik,
                                 idkategori,
                                 iduser,
								 judul_topik,
								 isi_topik,
								 tgl_post)
	                       VALUES('',
                                '$_POST[cat]',
								'$_SESSION[idsiswa]',
								'$_POST[judul]',
                                '$_POST[isi]',
								'$tgl_skr')");
	}
                    
         if($simpan){
        echo "<script>window.alert('data tersimpan...!');window.location=(href='?module=posting-topik')</script>";
  }else{
  echo"$user[iduser]";
      echo "<script>window.alert('data gagal disimpan.');window.location=(href='?module=posting-topik&act=inputtopik')</script>";
	  
  }
  break;
  
  case"updatetopik":
  date_default_timezone_set('Asia/Jakarta');
		$tgl_skr=date('Y-m-d H:i:s');
		
	
	$lokasi_file    = $_FILES['fupload']['tmp_name'];
  $tipe_file      = $_FILES['fupload']['type'];
  $nama_file      = $_FILES['fupload']['name'];
  $direktori_file = "./foto_topik/$nama_file";	
  
  if (!empty($lokasi_file)){
	if (file_exists($direktori_file)){
		echo "<script>window.alert('Nama file gambar sudah ada, mohon diganti dulu');
            window.location=(href='?module=posting-topik&act=edittopik&id=$_POST[id]')</script>";
	}else{
		if($tipe_file != "image/jpeg" AND $tipe_file != "image/jpg" AND $tipe_file != "image/png" AND $tipe_file != "image/gif")
		{
			echo "<script>window.alert('Tipe File tidak di ijinkan.');
					window.location=(href='?module=posting-topik&act=edittopik&id=$_POST[id]')</script>";
		}else{
				UploadImage($nama_file);
				$simpan=mysql_query("update topik set idkategori='$_POST[cat]',
								judul_topik='$_POST[judul]',
                                isi_topik='$_POST[isi]',gambar='$nama_file' where idtopik='$_POST[id]'and iduser='$_SESSION[idsiswa]'");
		}
	}
  }else{
  $simpan=mysql_query("update topik set idkategori='$_POST[cat]',
								judul_topik='$_POST[judul]',
                                isi_topik='$_POST[isi]' where idtopik='$_POST[id]'and iduser='$_SESSION[idsiswa]'");
                    
    }     
if($simpan){
        echo "<script>window.alert('data diubah...!');window.location=(href='?module=posting-topik')</script>";
  }else{
  echo"$user[iduser]";
      echo "<script>window.alert('data gagal disimpan.');window.location=(href='?module=posting-topik&act=edittopik&id=$_POST[id]')</script>";
	  
  }
  break;
  
  case"deletetopik":
  if (! $_GET['id']=="" and ! $_SESSION[idsiswa]=="")
{
include "config/koneksi.php";
$sqlHapus	= "delete from topik where idtopik='".$_GET['id']."' and iduser='$_SESSION[idsiswa]'";
$queryHapus	= mysql_query($sqlHapus);
if($queryHapus)
{
echo "<script type='text/javascript'>
		alert ('Data Berhasil Dihapus...!!!')	
    </script>";
	echo "<script>window.location=(href='?module=posting-topik')</script>";
}else{
echo "<script type='text/javascript'>
	onload =function(){
	alert ('Data Gagal Dihapus...!!!');
	}
	</script>";
	echo "<script>window.location=(href='?module=posting-topik')</script>'>";
}
}
  break;
  
}
	?>
	
</body>
</html>

<?php 
}
?>