<html>
<head>
<link rel="stylesheet" href="css/style2.css">
</head>
<body>
<?php

include "lib/koneksi.php";

switch($_GET[act]){
  // Tampil Kategori
  default:
  ?>
  <div class="navbar-inner">
		
	<form action="?module=topik&act=cari" method="post"  class="table table-condensed table-hover form-newsletter navbar-form form-search pull-right">
				   <div class="input-append">
				    <input type="text" class="span2" name="vcari" placeholder="cari topik">
				    <button type="submit" class="btn btn-small btn-warning" name="cari">Search</button>
				  </div>
	</form>
	</div>
  <?php
  echo"<h2 class='pageTitle'><span>Semua Topik</span></h2>";
		  echo "<table class='table table-striped table-hover'>
					<thead>
						
					</thead><tbody>";
//langkah 1 : tentukan batas, halaman dan posisi data
	$batas = 10;
	$halaman = $_GET['halaman'];
	if (empty($halaman))
	{
	$halaman = 0;
	$posisi = 0;
	}
	else
	{
	$posisi = ($halaman -1) * $batas;
	}
	
	$tampil = mysql_query("SELECT t.*,u.*,k.* FROM topik t,siswa u,kategori k where t.iduser=u.id_siswa and t.idkategori=k.idkategori ORDER BY t.tgl_post DESC LIMIT $posisi,$batas");
    $tampil2 = mysql_query("SELECT t.*,u.*,k.* FROM topik t,siswa u,kategori k where t.iduser=u.id_siswa and t.idkategori=k.idkategori ORDER BY t.tgl_post DESC LIMIT $posisi,$batas");

	$r2=mysql_fetch_array($tampil2);
	
	$skr=date('d-m-Y');
	$date2=substr("$r2[tgl_post]",0,10);
		    $th2=substr("$date2",0,4);
			$bln2=substr("$date2",5,2);
			$d2=substr("$date2",8,2);
			
			$tgl_atas=$d2.'-'.$bln2.'-'.$th2;
	
	if($tgl_atas==$skr){
			echo"<tr><td colspan=2 style='padding:0px;'><font size=1><center>Hari ini</center></font></td></tr>";
	}else{
	 echo"<tr><td colspan=2 style='padding:0px;'><font size=1><center>$tgl_atas</center></font></td></tr>";
	}		
	while ($r=mysql_fetch_array($tampil)){
       $date=substr("$r[tgl_post]",0,10);
		    $th=substr("$date",0,4);
			$bln=substr("$date",5,2);
			$d=substr("$date",8,2);
			
			$tgl_post=$d.'-'.$bln.'-'.$th;
			
	   if($tgl_atas!=$tgl_post){
			echo"<tr><td colspan=2 style='padding:0px;'><font size=1><center>$tgl_post</center></font></td></tr>";
			$tgl_atas=$tgl_post;
	   }else{
				$tgl_atas=$tgl_post;
	   }
	   echo "<tr>
             <td width=50><a href='?module=topik&act=detailisitopik&id=$r[idtopik]' title='Detail'>";
			if($r[gambar]!=''){
			echo"<img src='foto_topik/$r[gambar]' class='foto-topik' height='150' width='150'>";
			}else{
			echo"<img src='foto_topik/banner.jpg' class='foto-topik' height='150' width='150'>";
			}
			$desk = htmlentities(strip_tags($r['isi_topik'])); // membuat paragraf pada isi berita dan mengabaikan tag html
    				$deskripsi = substr($desk,0,250); // ambil sebanyak 220 karakter
    			 	$deskripsi = substr($desk,0,strrpos($deskripsi," ")); // potong per spasi kalimat
			echo"</a></td><td><a href='?module=topik&act=detailisitopik&id=$r[idtopik]' title='Detail'><p>$r[judul_topik]</p></a><p>$deskripsi</p><div><small><i class='icon-user'></i>";
			if($r[level]=="dosen"){$dos=$dosen;$link="media.php?module=admin&act=detailpengajar&id=";}else{$link="?module=siswa&act=detailsiswa&id=";}
				
			echo"<a href='$link$r[id_siswa]' style='color:#5555ff;'>$r[nama_lengkap] $dos &nbsp;&nbsp;</a><i class='icon-tag'></i><a href='?module=topik&act=detailtopik&id=$r[idkategori]' style='color:#5555ff;'>$r[nm_kategori]</a></small></div></td>           
             </tr>";
    
    }
    echo "</tbody></table>";
	
	//langkah 3 hitung jumlah data,jumlah halaman dan ling halaman
	$sql2	= "SELECT t.*,u.*,k.* FROM topik t,siswa u,kategori k where t.iduser=u.id_siswa and t.idkategori=k.idkategori ORDER BY t.tgl_post DESC";
	$hasil2 = mysql_query($sql2);
	$jmlrecord= mysql_num_rows($hasil2);
	$jmlhalaman= ceil($jmlrecord/$batas);

	//echo"a";
	$prev=$halaman-1;
	if($halaman!=1){
		if($prev>=1){
			echo"<a href='?module=topik&halaman=$prev'>Prev</a>";
		}else{
			echo"<span> Prev </span>";
		}
	}else{
	echo"<span> Prev </span>";
	}
	
	for ($y=1; $y<=$jmlhalaman; $y++){
	if($y !=$halaman)
	{
	echo "<a href='?module=topik&halaman=$y'> $y </a>";
	}
	else
	{
	echo" <span> $y </span>";
	}
	}
	
	$next=$halaman+1;
	if($next != $y){
	echo"<a href='?module=topik&halaman=$next'> Next </a>";
	}
	else{
	echo"<span> Next </span>";
	}
	
	//echo"</ul></div>";
	
  break;
  
  case "detailtopik":
	$tampil2 = mysql_query("SELECT * FROM kategori where idkategori='$_GET[id]'");
	$r2=mysql_fetch_array($tampil2);
	
	echo"<h2 class='pageTitle'><span>Topik</span></h2>";
    echo"<div data-role='content' class='singleblog container'>
      <h4>Semua topik dengan kategori : <a href='#'>$r2[nm_kategori]</a></h4>
	  <h4>Keterangan : <a href='#'>$r2[ket_kategori]</a></h4>
    </div>";
	
		 echo "<table class='table table-striped table-hover'>
					<thead>
						
					</thead><tbody>";
//langkah 1 : tentukan batas, halaman dan posisi data
	$batas = 10;
	$halaman = $_GET['halaman'];
	if (empty($halaman))
	{
	$halaman = 0;
	$posisi = 0;
	}
	else
	{
	$posisi = ($halaman -1) * $batas;
	}
	
	$tampil = mysql_query("select t.*,u.*,k.* FROM topik t,siswa u,kategori k where t.iduser=u.id_siswa and t.idkategori=k.idkategori and t.idkategori='$_GET[id]' ORDER BY t.tgl_post DESC LIMIT $posisi,$batas");
    $tampil3 = mysql_query("select t.*,u.*,k.* FROM topik t,siswa u,kategori k where t.iduser=u.id_siswa and t.idkategori=k.idkategori and t.idkategori='$_GET[id]' ORDER BY t.tgl_post DESC LIMIT $posisi,$batas");
    
	$r3=mysql_fetch_array($tampil3);
	
	$desk = htmlentities(strip_tags($r3['isi_topik'])); // membuat paragraf pada isi berita dan mengabaikan tag html
    				$deskripsi = substr($desk,0,250); // ambil sebanyak 220 karakter
    			 	$deskripsi = substr($desk,0,strrpos($deskripsi," ")); // potong per spasi kalimat
	
	$skr=date('d-m-Y');
	$date2=substr("$r3[tgl_post]",0,10);
		    $th2=substr("$date2",0,4);
			$bln2=substr("$date2",5,2);
			$d2=substr("$date2",8,2);
			
			$tgl_atas=$d2.'-'.$bln2.'-'.$th2;
	
	if($tgl_atas==$skr){
			echo"<tr><td colspan=2 style='padding:0px;'><font size=1><center>Hari ini</center></font></td></tr>";
	}else{
	 echo"<tr><td colspan=2 style='padding:0px;'><font size=1><center>$tgl_atas</center></font></td></tr>";
	}		
	
	while ($r=mysql_fetch_array($tampil)){
       $date=substr("$r[tgl_post]",0,10);
		    $th=substr("$date",0,4);
			$bln=substr("$date",5,2);
			$d=substr("$date",8,2);
			
			$tgl_post=$d.'-'.$bln.'-'.$th;
			
	   if($tgl_atas!=$tgl_post){
			echo"<tr><td colspan=2 style='padding:0px;'><font size=1><center>$tgl_post</center></font></td></tr>";
			$tgl_atas=$tgl_post;
	   }else{
				$tgl_atas=$tgl_post;
	   }
	   echo "<tr>
             <td width='50'><a href='?module=topik&act=detailisitopik&id=$r[idtopik]' title='Detail'>";
			if($r[gambar]!=''){
			echo"<img src='foto_topik/$r[gambar]' class='foto-topik'>";
			}else{
			echo"<img src='images/banner.png' class='foto-topik'>";
			}
					  if($r[level]=="dosen"){$dos=$dosen;$link="media.php?module=admin&act=detailpengajar&id=";}else{$link="?module=siswa&act=detailsiswa&id=";}

				echo"</a></td><td><a href='?module=topik&act=detailisitopik&id=$r[idtopik]' title='Detail'><p>$r[judul_topik]</p></a><p>$deskripsi</p><div><small><i class='icon-user'></i><a href='$link$r[iduser]' style='color:#5555ff;'>$r[nama_lengkap] $dos</a></small></div></td>           
             </tr>";
    
    }
    echo "</tbody></table>";
	
	//langkah 3 hitung jumlah data,jumlah halaman dan ling halaman
	$sql2	= "select t.*,u.*,k.* FROM topik t,siswa u,kategori k where t.iduser=u.id_siswa and t.idkategori=k.idkategori and t.idkategori='$_GET[id]' ORDER BY t.tgl_post DESC";
	$hasil2 = mysql_query($sql2);
	$jmlrecord= mysql_num_rows($hasil2);
	$jmlhalaman= ceil($jmlrecord/$batas);

	
	$prev=$halaman-1;
	if($halaman!=1){
		if($prev>=1){
			echo"<a href='?module=topik&act=detailtopik&id=$_GET[id]&halaman=$prev'>Prev</a>";
		}
		else{
			echo"<span>Prev</span>";
		}
	}else{
	echo"<span>Prev</span>";
	}
	
	for ($y=1; $y<=$jmlhalaman; $y++){
	if($y !=$halaman)
	{
	echo "<a href='?module=topik&act=detailtopik&id=$_GET[id]&halaman=$y'> $y </a>";
	}
	else
	{
	echo"<span> $y </span>";
	}
	}
	
	$next=$halaman+1;
	if($next != $y){
	echo"<a href='?module=topik&act=detailtopik&id=$_GET[id]&halaman=$next'>Next</a>";
	}
	else{
	echo"<span>Next</span>";
	}
	
	
	
     break;
	 
	 case "detailisitopik":
	 
	echo"<div data-role='content' class='singleblog'>
			<section class='postone'>";
			
	$detail = mysql_query("SELECT t.*,k.*,u.* FROM topik t,kategori k,siswa u where t.idkategori=k.idkategori and t.iduser=u.id_siswa and t.idtopik='$_GET[id]' ORDER BY t.tgl_post DESC");
    $r=mysql_fetch_array($detail);
	
	$jml_komen = mysql_query("SELECT idtopik,count(idkomentar)as jml FROM komentar where idtopik='$_GET[id]' group by idtopik");
	$komen=mysql_fetch_array($jml_komen);
	if($komen[jml]>=1){
	$jmlkomen=$komen[jml];
	}else{
	$jmlkomen=0;
	}
	echo"<h5 align=center style='padding-bottom:5px;'>$r[judul_topik]</h5>";
		$date=substr("$r[tgl_post]",0,10);
		    $th=substr("$date",0,4);
			$bln=substr("$date",5,2);
			$d=substr("$date",8,2);
			
			$tgl_post=$d.'-'.$bln.'-'.$th;
		  $user=mysql_fetch_array(mysql_query("select * from siswa where id_siswa='$_SESSION[idsiswa]'"));
		  if($r[level]=="dosen"){$dos=$dosen;$link="media.php?module=admin&act=detailpengajar&id=";}else{$link="?module=siswa&act=detailsiswa&id=";}
			
		  if($r[iduser]==$_SESSION[idsiswa]){		  
		  
		  echo"<p class='meta'> <span class='left'>Date: <strong>$tgl_post</strong></span> <span class='left'>posted by <strong><a href='$link$user[id_siswa]'>Anda</a></strong></span> <small><a href='?module=posting-topik&act=edittopik&id=$r[idtopik]'>&nbsp;&nbsp;&nbsp;<img src='images/icons/edit.png' /></a></small>
			<span>on <a href='?module=topik&act=detailtopik&id=$r[idkategori]' /><strong>$r[nm_kategori] </strong></a> | $jmlkomen Comments</a></span> </p>";
		  
		  }else{
		  
		  echo"<p class='meta'> <span class='left'>Date: <strong>$tgl_post</strong></span> <span class='left'>posted by <strong><a href='$link$r[iduser]'>$r[nama_lengkap] $dos</a></strong></span> 
			<span>on <a href='?module=topik&act=detailtopik&id=$r[idkategori]' rel='tag'><strong>$r[nm_kategori] </strong></a> | $jmlkomen Comments</a></span> </p>";
		  
		  }
		  echo"<p>$r[isi_topik]</p>";
		  
		  echo"</section></div>";
		  
      echo"<section class='comments'>";
	  echo"<hr class='homeseparator'/>
      <h2>Comments</h2>
      <hr class='homeseparator'/>";
	  
	  //langkah 1 : Tentukan Batas, Cek Halaman dan Posisi Data
	$batas = 10;
	$halaman = $_GET['halaman'];
	if(empty($halaman))
	{
	$posisi 	= 0;
	$halaman 	= 1; 
	}
	else
	{
	$posisi = ($halaman -1) * $batas;
	}
	  $komen=mysql_query("SELECT t.*,k.*,u.* FROM siswa u,topik t,komentar k where t.idtopik=k.idtopik and k.iduser=u.id_siswa and t.idtopik='$_GET[id]' ORDER BY k.tgl_post_komentar LIMIT $posisi, $batas");  
	  
	  if((mysql_num_rows($komen))<1){
			echo"<h5>
					<a href='#'><small>&nbsp;&nbsp;&nbsp;<i class='icon-comments'></i>&nbsp;tidak ada komentar</small></a>
				</h5>";
		}else{
			while($r2=mysql_fetch_array($komen)){
	  ?>	  
	  <div id="comments">
        <ul id="articleCommentList">
          <li>
            <div class="commentMeta">
			
			<?php  
				$date=substr("$r2[tgl_post_komentar]",0,10);
		    $th=substr("$date",0,4);
			$bln=substr("$date",5,2);
			$d=substr("$date",8,2);
			
			$jam_post_komentar=substr("$r2[tgl_post_komentar]",11,8);
			$tgl_post_komentar=$d.'-'.$bln.'-'.$th;
			  if($r2[level]=="dosen"){$dir="foto_pengajar";$dos=$dosen;$link="media.php?module=admin&act=detailpengajar&id=";}else{$dir="foto_siswa";$link="?module=siswa&act=detailsiswa&id=";}
			
			  if ($r2[foto]!=''){
				echo "<img class='user' src='$dir/small_$r2[foto]' alt='Default user icon'>";
			  }else{
				echo "<a href='images/profil.png' rel='facebox'><img class='user' src='images/profil.png' alt='Default user icon'></a>";
			  }
			  echo"<p><em>$tgl_post_komentar ($jam_post_komentar)</em></p>";
			
			?>
			</div>
            <!-- end commentMeta -->
            <div class="commentBody">
			<?php
				
				if ($_SESSION[idsiswa] == "$r2[iduser]"){
					echo"<h3 ><a href=$link$r2[iduser]> Anda </a><a href=?module=topik&act=deletekomentar&idk=$r2[idkomentar]&id=$_GET[id]><img src='images/b_drop.png' class='pull-right' /></a></h3>";
				}else{ 
					echo"<h3><a href=$link$r2[iduser]> $r2[nama_lengkap] $dos</a></h3>";
				}
			?>
              <p><?php echo"$r2[komentar]"; ?></p>
            </div>
            <!-- end commentBody --> 
          </li>
        </ul>
      </div><br />
	<?php 
		} 
	
	$tampilData		= mysql_query("SELECT t.*,k.*,u.* FROM siswa u,topik t,komentar k where t.idtopik=k.idtopik and k.iduser=u.id_siswa and t.idtopik='$_GET[id]' ORDER BY k.tgl_post_komentar");
	$jmlData		= mysql_num_rows($tampilData);
	$jmlHalaman		= ceil($jmlData/$batas);
	?>
	<div class="products-view-nav row bottom">
                          
              <div class="span6">
                <ul class="navigation rr">
	<?php
	//echo"<div class='halaman'>
		//			<ul>";
	$prev=$halaman-1;
	if($halaman!=1){
		if($prev>=1){
			echo"<a href='?module=topik&act=detailisitopik&id=$_GET[id]&halaman=$prev'>Prev</a>";
		}
		else{
			echo"<span>Prev</span>";
		}
	}else{
	echo"<span>Prev</span>";
	}
	
	for ($z=1; $z<=$jmlHalaman; $z++){
	if($z !=$halaman)
	{
	echo "<a href='?module=topik&act=detailisitopik&id=$_GET[id]&halaman=$z'> $z </a>";
	}
	else
	{
	echo" <span> $z </span>";
	}
	}
	
	$next=$halaman+1;
	
	if($next != $z){
	echo"<a href='?module=topik&act=detailisitopik&id=$_GET[id]&halaman=$next'>Next</a>";
	}
	else{
	echo"<span>Next</span>";
	}
	
	//echo"</ul></div>";
	
	}
	?>
	
      <!-- end Comments --> 
	  
    </section>
	  <?php  			
		if (empty($_SESSION['idsiswa'])){
			 echo"<h5>
					<a href='#'><small>&nbsp;&nbsp;&nbsp;<i class='icon-comments'></i>&nbsp;Anda harus login dulu untuk post komentar</small></a>
				</h5>";			
		  }
		  else
		  {
		  ?>
			<form action="?module=topik&act=postkomentar" method="post">
			<p>
			<label for="editor1"><small>
				&nbsp;&nbsp;&nbsp;<i class='icon-comments'></i>&nbsp;Komentar :</small></label>
			<input name=idtopik type=hidden value=<?php echo "$r[idtopik]"; ?> hidden=hidden>
			<center><textarea cols="80" id="isi" name="komentar" rows="10"></textarea></center>
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
				<input type="submit" class="btn btn-success pull-right" value="Post Komentar"></input>
				<hr class="homeseparator"/>
			</p>
			</form>
	<?php
		  }
		  
     break;
	 
	 case "postkomentar";
	 //komentar
	date_default_timezone_set('Asia/Jakarta');
		$tgl_skr=date('Y-m-d H:i:s');
		$sql=mysql_fetch_array(mysql_query("select * from siswa where id_siswa='$_SESSION[idsiswa]'"));
	if(! $_POST[idtopik]=="" and ! $_POST[komentar]==""){
		$sqlSimpan	= "INSERT INTO komentar(idkomentar,
                                 idtopik,
                                 iduser,
                                 komentar,
                                 tgl_post_komentar)
	                       VALUES('',
                                '$_POST[idtopik]',
								'$sql[id_siswa]',
                                '$_POST[komentar]',
                                '$tgl_skr')";
$query3	= mysql_query($sqlSimpan);

if($query3){
	echo "<center><br><br><img src=images/ajax-loader.gif></br></br></center>";
	echo "<meta http-equiv='refresh' content='0; url=?module=topik&act=detailisitopik&id=$_POST[idtopik]'>";
}else{
echo "<script type='text/javascript'>
	onload =function(){
	alert ('komentar Gagal Disimpan...!!!');
	}
	</script>";
	echo "<center><br><br><img src=images/ajax-loader.gif></br></br></center>";
	echo "<meta http-equiv='refresh' content='0; url=?module=topik&act=detailisitopik&id=$_POST[idtopik]'>";
}
}

	 break;
	case "deletekomentar":
	if (! $_GET['idk']=="" and ! $_SESSION[idsiswa]=="")
{
//include "config/koneksi.php";
$sqlHapus	= "delete from komentar where idkomentar='".$_GET['idk']."' and iduser='$_SESSION[idsiswa]'";
$queryHapus	= mysql_query($sqlHapus);
if($queryHapus)
{
echo "<script type='text/javascript'>
		alert ('komentar berhasil dihapus...!!!')	
    </script>";
	echo "<center><br><br><img src=images/ajax-loader.gif></br></br></center>";
	echo "<meta http-equiv='refresh' content='0; url=?module=topik&act=detailisitopik&id=$_GET[id]'>";
}else{
echo "<script type='text/javascript'>
	onload =function(){
	alert ('Komentar Gagal Dihapus...!!!');
	}
	</script>";
	echo "<center><br><br><img src=images/ajax-loader.gif></br></br></center>";
	echo "<meta http-equiv='refresh' content='0; url=?module=topik&act=detailisitopik&id=$_GET[id]'>";
}
}
    break;
	
	 case"cari":
	 if ($_GET['halaman']==''){
	 $_GET[vcari]=$_POST[vcari];
	 }
	 echo"<h2 class='pageTitle'><span>Cari Topik</span></h2>";
	
    echo"<div data-role='content' class='singleblog container'>
	<h4>Semua topik dengan kata kunci : <a href='#'>\"$_GET[vcari]\"</a></h4>
    </div>";
	
		 echo "<table class='table table-striped table-hover'>
					<thead>
						
					</thead><tbody>";
//langkah 1 : tentukan batas, halaman dan posisi data
	$batas = 10;
	$halaman = $_GET['halaman'];
	if (empty($halaman))
	{
	$halaman = 0;
	$posisi = 0;
	}
	else
	{
	$posisi = ($halaman -1) * $batas;
	}
	
	$tampil = mysql_query("SELECT t.*,u.*,k.* FROM topik t,siswa u,kategori k where t.iduser=u.id_siswa and t.idkategori=k.idkategori and t.judul_topik like '%$_GET[vcari]%' ORDER BY t.tgl_post DESC LIMIT $posisi,$batas");
    if((mysql_num_rows($tampil))<1){
			echo"<h5>
					<a href='#'><small>&nbsp;&nbsp;&nbsp;<i class='icon-comments'></i>&nbsp;tidak ada hasil pencarian topik</small></a>
				</h5>";
	}else{

	$tampil2 = mysql_query("SELECT t.*,u.*,k.* FROM topik t,siswa u,kategori k where t.iduser=u.id_siswa and t.idkategori=k.idkategori and t.judul_topik like '%$_GET[vcari]%' ORDER BY t.tgl_post DESC LIMIT $posisi,$batas");
    $r2=mysql_fetch_array($tampil2);
	
	$skr=date('d-m-Y');
	$date2=substr("$r2[tgl_post]",0,10);
		    $th2=substr("$date2",0,4);
			$bln2=substr("$date2",5,2);
			$d2=substr("$date2",8,2);
			
			$tgl_atas=$d2.'-'.$bln2.'-'.$th2;
	
	if($tgl_atas==$skr){
			echo"<tr><td colspan=2 style='padding:0px;'><font size=1><center>Hari ini</center></font></td></tr>";
	}else{
	 echo"<tr><td colspan=2 style='padding:0px;'><font size=1><center>$tgl_atas</center></font></td></tr>";
	}
	
	while ($r=mysql_fetch_array($tampil)){
       $date=substr("$r[tgl_post]",0,10);
		    $th=substr("$date",0,4);
			$bln=substr("$date",5,2);
			$d=substr("$date",8,2);
			
			$tgl_post=$d.'-'.$bln.'-'.$th;
				$desk = htmlentities(strip_tags($r['isi_topik'])); // membuat paragraf pada isi berita dan mengabaikan tag html
    				$deskripsi = substr($desk,0,250); // ambil sebanyak 220 karakter
    			 	$deskripsi = substr($desk,0,strrpos($deskripsi," ")); // potong per spasi kalimat
	if($tgl_atas!=$tgl_post){
			echo"<tr><td colspan=2 style='padding:0px;'><font size=1><center>$tgl_post</center></font></td></tr>";
			$tgl_atas=$tgl_post;
	   }else{
				$tgl_atas=$tgl_post;
	   }		
	   echo "<tr>
             <td width='50'><a href='?module=topik&act=detailisitopik&id=$r[idtopik]' title='Detail'>";
			if($r[gambar]!=''){
			echo"<img src='foto_topik/$r[gambar]' class='foto-topik'>";
			}else{
			echo"<img src='images/banner.png' class='foto-topik'>";
			}
		if($r[level]=="dosen"){$dos=$dosen;$link="media.php?module=admin&act=detailpengajar&id=";}else{$link="?module=siswa&act=detailsiswa&id=";}

			echo"</a></td><td><a href='?module=topik&act=detailisitopik&id=$r[idtopik]' title='Detail'><p>$r[judul_topik]</p></a><p>$deskripsi</p><div><small><i class='icon-user'></i><a href='$link$r[iduser]' style='color:#5555ff;'>$r[nama_lengkap] $dos &nbsp;&nbsp;</a><i class='icon-tag'></i><a href='?module=topik&act=detailtopik&id=$r[idkategori]' style='color:#5555ff;'>$r[nm_kategori]</a></small></div></td>           
             </tr>";
    
    }
	}
    echo "</tbody></table>";
	
	//langkah 3 hitung jumlah data,jumlah halaman dan ling halaman
	$sql2	= "SELECT * FROM topik WHERE judul_topik like '%$_GET[vcari]%' ORDER BY tgl_post DESC ";
	$hasil2 = mysql_query($sql2);
	$jmlrecord= mysql_num_rows($hasil2);
	$jmlhalaman= ceil($jmlrecord/$batas);

	$prev=$halaman-1;
	if($halaman!=1){
		if($prev>=1){
			echo"<a href='?module=topik&act=cari&vcari=$_GET[vcari]&halaman=$prev'>Prev</a>";
		}
		else{
			echo"<span>Prev</span>";
		}
	}else{
	echo"<span>Prev</span>";
	}
	
	for ($y=1; $y<=$jmlhalaman; $y++){
	if($y !=$halaman)
	{
	echo "<a href='?module=topik&act=cari&vcari=$_GET[vcari]&halaman=$y'> $y </a>";
	}
	else
	{
	echo"<span> $y </span>";
	}
	}
	
	$next=$halaman+1;
	if($next != $y){
	echo"<a href='?module=topik&act=cari&vcari=$_GET[vcari]&halaman=$next'>Next</a>";
	}
	else{
	echo"<span>Next</span>";
	}
	
	
	 break;
	
}

?>
</body>
</html>