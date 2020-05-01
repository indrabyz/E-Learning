<?php

session_start();
error_reporting(0);
//include"timeout.php";

include"lib/koneksi.php";

$user=mysql_fetch_array(mysql_query("select * from siswa where id_siswa='$_SESSION[idsiswa]'"));
$dari=mysql_fetch_array(mysql_query("select * from siswa where id_siswa='$_GET[id]'"));

$read=mysql_query("update chat set status='R' where dari='$_GET[id]' and ke='$_SESSION[idsiswa]'");

if($user[level]=="dosen"){
$dir="foto_siswa";
}else{
$dir="foto_pengajar";
}
if($dari[level]=="dosen"){
$dir2="foto_siswa";
}else{
$dir2="foto_pengajar";
}

if (empty($_SESSION['idsiswa'])){
			 header('Location:index.php?module=home');
}
else{

?>
	<html lang="en"> 
	<head> 
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

	<title><?php echo"$dari[nama_lengkap]"; ?></title>
   
   <!-- audio -->
<script src="js/jquery.min.audio.js"></script>
   
	<link rel="stylesheet" href="css/style3.css">
	 
<script> 
	var ajaxku = buatAjax(); 
	var tnama = 0; 
	var pesanakhir = 0; 
	var timer;
	
	function taruhNama(){ 
	    if(tnama==0){ 
	        document.getElementById("nama").disabled = "true"; 
	        tnama = 1; 
	    }else{ 
	        document.getElementById("nama").disabled = ""; 
	        tnama = 0; 
	    } 
	    ambilPesan(); 
	} 
	function buatAjax(){ 
	    if(window.XMLHttpRequest){ 
	        return new XMLHttpRequest(); 
    }else if(window.ActiveXObject){ 
	        return new ActiveXObject("Microsoft.XMLHTTP"); 
	    } 
	} 
	
	function ambilPesan(){ 
	    namaku = document.getElementById("nama").value 
	    if(ajaxku.readyState == 4 || ajaxku.readyState == 0){ 
	        ajaxku.open("GET","ambilchat.php?akhir="+pesanakhir+"&nama="+namaku+"&sid="+Math.random(),true); 
	        ajaxku.onreadystatechange = aturAmbilPesan; 
	        ajaxku.send(null); 
	    } 
	} 

	function aturAmbilPesan(){ 
	    if(ajaxku.readyState == 4){ 
	        var chat_div = document.getElementById("div_chat"); 
	        var data = eval("("+ajaxku.responseText+")"); 
	        for(i=0;i<data.messages.pesan.length;i++){ 
				
				if(data.messages.pesan[i].ke == <?php echo $_SESSION[idsiswa] ?>){
				$(function(){  
				$('<audio id="chatAudio"><source src="notifikasi.ogg" type="audio/ogg"><source src="notifikasi.mp3" type="audio/mpeg"><source src="notifikasi.wav" type="audio/wav">').appendTo('body');
	
				$('#chatAudio')[0].play();
				});
				
				}
				
				//chat_div.innerHTML += "<audio autoplay=autoplay controls=controls><source src=notifikasi.mp3 type=audio/mpeg></audio>";
				
				//var audio = new Audio('notifikasi.mp3');
//audio.play();
				if(data.messages.pesan[i].waktu != ""){
				chat_div.innerHTML += "<center><h5><small>&nbsp;&nbsp;&nbsp;&nbsp;"+data.messages.pesan[i].waktu+"</small></a></h5></center>";
				}
			
			if(data.messages.pesan[i].ke == <?php echo $_SESSION[idsiswa] ?>){
					if(data.messages.pesan[i].status == 'D'){
						chat_div.innerHTML += "<div class=me><div class=foto><a href=?module=siswa&act=detailsiswa&id="+data.messages.pesan[i].nama+"><img src='<?php echo"$dir"; ?>/medium_<?php echo"$dari[foto]"; ?>' class='foto'></a></div><table class=me><tr><td><div class=tgl>"+data.messages.pesan[i].jam+"</div><div class=chat-you><img src='images/icons/bullet_yellow.png'> "+data.messages.pesan[i].teks+"</div></td></tr></table></div><div class=clear></div>";
					}else{
						chat_div.innerHTML += "<div class=me><div class=foto><a href=?module=siswa&act=detailsiswa&id="+data.messages.pesan[i].nama+"><img src='<?php echo"$dir"; ?>/medium_<?php echo"$dari[foto]"; ?>' class='foto'></a></div><table class=me><tr><td><div class=tgl>"+data.messages.pesan[i].jam+"</div><div class=chat-you><img src='images/icons/bullet_gray.png'> "+data.messages.pesan[i].teks+"</div></td></tr></table></div><div class=clear></div>";
					}
				}else{
					if(data.messages.pesan[i].status == 'D'){
						chat_div.innerHTML += "<div class=you><div class=foto2><a href=?module=siswa&act=detailsiswa&id=<?php echo"$user[id_siswa]"; ?>><img src='<?php echo"$dir2"; ?>/medium_<?php echo"$user[foto]"; ?>' class='foto'></a></div><table class=you><tr><td><div class=tgl>"+data.messages.pesan[i].jam+"</div><div class=chat-me>"+data.messages.pesan[i].teks+" <img src='images/icons/delivery.png'></div></td></tr></table></div><div class=clear></div>";
					}else{
						chat_div.innerHTML += "<div class=you><div class=foto2><a href=?module=siswa&act=detailsiswa&id=<?php echo"$user[id_siswa]"; ?>><img src='<?php echo"$dir2"; ?>/medium_<?php echo"$user[foto]"; ?>' class='foto'></a></div><table class=you><tr><td><div class=tgl>"+data.messages.pesan[i].jam+"</div><div class=chat-me>"+data.messages.pesan[i].teks+" <img src='images/icons/read.png'></div></td></tr></table></div><div class=clear></div>";
					}
				}
			
				
				
				chat_div.scrollTop = chat_div.scrollHeight; 
	            pesanakhir = data.messages.pesan[i].id; 
				
	        } 
	    } 
	    timer = setTimeout("ambilPesan()",1000); 
	} 
	
	function kirimPesan(){ 
	
	    pesannya = document.getElementById("pesan").value 
	    namaku = document.getElementById("nama").value
		var filenya = document.getElementById("file");
		var fileName = filenya.value;
		var ext = fileName.substring(fileName.lastIndexOf('.') + 1);
			
	    if(pesannya != "" && fileName == ""){ 
	        ajaxku.open("GET","ambilchat.php?"+pesanakhir+"&nama="+namaku+"&pesan="+pesannya+"&sid="+Math.random(),true); 
	        ajaxku.onreadystatechange = aturAmbilPesan; 
	        ajaxku.send(null); 
	        document.getElementById("pesan").value = "";  
			document.getElementById("file").value = ""; 
	    } 
	} 
	
	function aturKirimPesan(){ 
	    clearInterval(timer); 
	    ambilPesan(); 
	} 
	function blockSubmit() { 
	    
		pesannya = document.getElementById("pesan").value 
	    namaku = document.getElementById("nama").value
		var filenya = document.getElementById("file");
		var fileName = filenya.value;
		var ext = fileName.substring(fileName.lastIndexOf('.') + 1);
		
		if(fileName == "" && pesannya != ""){
		kirimPesan(); 
			return false;
		}else if(pesannya =="" && fileName!=""){
			fileSize = filenya.files[0].size;
			if(fileSize <= 20000000){
				if(ext == "jpg" || ext == "jpeg" || ext == "bmp" || ext == "gif" || ext == "png" || ext == "mp4" ||ext == "MP4" || ext == "3gp" || ext == "rar" || ext == "flv" || ext == "zip" || ext == "avi" || ext == "mp3" || ext == "wav" || ext == "oog" || ext == "pdf" || ext == "txt" || ext == "doc" || ext == "docx" || ext == "xlsx" || ext == "ppt"){
					return true;
				}else{
					alert("file tidak di izinkan,gunakan file gambar/suara/video/office");
					return false;
				}
			}else{
			alert("file terlalu besar maksimal 20 Mb"); 
				return false;
			} 		
		}else if(pesannya !="" && fileName!=""){
			fileSize = filenya.files[0].size;
			if(fileSize <= 20000000){
				if(ext == "jpg" || ext == "jpeg" || ext == "bmp" || ext == "gif" || ext == "png" || ext == "mp4" || ext == "MP4" || ext == "3gp" || ext == "rar" || ext == "flv" || ext == "zip" || ext == "avi" || ext == "mp3" || ext == "wav" || ext == "oog" || ext == "pdf" || ext == "txt" || ext == "doc" || ext == "docx" || ext == "xlsx" || ext == "ppt"){
					return true;
				}else{
					alert("file tidak di izinkan,gunakan file gambar/suara/video/office");
					return false;
				}
			}else{
			alert("file terlalu besar maksimal 20 Mb"); 
				return false;
			}
		}else{
		 alert("pesan masih kosong");
		 return false;
		}
	} 
	
	</script>
	</head> 
	<body onload=ambilPesan()>
			<a class="btn btn-info" href="media_user.php?module=chat">Kembali</a>
				<a class="btn btn-navbar" href="media_user.php?module=chat&act=deletechat&idd=<?php echo"$_GET[id]"; ?>&idk=<?php echo"$user[id_siswa]"; ?>" style="button{background-color:#000;}">
					<span class="icon-trash"></span>
				</a>
				<?php
				if($dari[level]=="dosen"){$link="media.php?module=admin&act=detailpengajar&id=";}else{$link="?module=siswa&act=detailsiswa&id=";}
				?>
			<a class="brand" href="<?php echo"$link$dari[id_siswa]"; ?>"><?php echo"$dari[nama_lengkap]"; if($dari[level]=="dosen"){echo" $dosen";}?><br /></a>
			<br />
<div id="carousel">	
	<div id="div_chat" style="height: 68%;padding:5px; overflow: auto; background-color: lightblue; border: 1px solid #ddd;">
	<?php

$query2 = mysql_query("select c.*,u.* from chat c,siswa u where c.ke=u.id_siswa and ((c.ke='$_SESSION[idsiswa]' and c.dari='$_GET[id]') or (c.ke='$_GET[id]' and c.dari='$_SESSION[idsiswa]'))order by idchat"); 
		$r = mysql_fetch_array($query2);
		
	$ke=mysql_query("select * from siswa where id_siswa='$_GET[id]'");
	if((mysql_num_rows($ke))<1){
		echo"<center><h5>
			<small>&nbsp;&nbsp;&nbsp;&nbsp;tidak ada user</small></a>
			</h5></center>";
	}else{
	
		if((mysql_num_rows($query2))<1){
		echo"<center><h5>
					<small>&nbsp;&nbsp;&nbsp;&nbsp;tidak ada percakapan</small></a>
					</h5></center>";
		}else{
		$date=substr("$r[tgl_pesan]",0,10);
		$th=substr("$date",0,4);
					$bln=substr("$date",5,2);
					$d=substr("$date",8,2);
					
					$tgl_atas=$d.'-'.$bln.'-'.$th;
		echo"<center><h5>
					<small>&nbsp;&nbsp;&nbsp;&nbsp;$tgl_atas</small></a>
					</h5></center>";
		}
	}
?>	

	</div>
	<br/> 
	<center>
	<?php if((mysql_num_rows($ke))<1){
		echo"<center><h5>
			<small>&nbsp;&nbsp;&nbsp;&nbsp;tidak ada user</small></a>
			</h5></center>";
	}else{ ?>
	<form onSubmit="return blockSubmit();" action="kirimchat.php" method="post" class='form-newsletter' enctype="multipart/form-data"> 
		<div class='input-append'>
			<input type=hidden name=nama id=nama value='<?php echo"$_GET[id]"; ?>' hidden=hidden>
			<input type='text' style="width:75%;" name=pesan id=pesan class='span2'/>
	
		<button type=submit class='btn' id='kirim'>Kirim</button> 
		
		</div>
		<div class='input-append'>
		<input type="file" name="file" id="file" class="btn" />
		</div>
	</form> 
	<?php
	}
	?>
	</center>
	
</div>

	</body> 
	</html> 
	
<?php
}
?>