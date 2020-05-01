<?php 
session_start();
include_once("lib/koneksi.php");
include "configurasi/koneksi.php";
include "configurasi/library.php";
include "configurasi/fungsi_indotgl.php";
include "configurasi/fungsi_combobox.php";
include "configurasi/class_paging.php";

if (empty($_SESSION['username']) AND empty($_SESSION['passuser']) AND $_SESSION['login']==0){
  echo "<link href='css/screen.css' rel='stylesheet' type='text/css'><link href='css/reset.css' rel='stylesheet' type='text/css'>


 <center><br><br><br><br><br><br>Maaf, untuk masuk <b>Halaman</b><br>
  <center>anda harus <b>Login</b> dahulu!<br><br>";
 echo "<div> <a href='login.php'><img src='images/kunci.png'  height=176 width=143></a>
             </div>";
  echo "<input type=button class=simplebtn value='LOGIN DI SINI' onclick=location.href='login.php'></a></center>";
}else{

$dosen="<span style='color:red;'>($_SESSION[leveluser])</span>";

?>
<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width,initial-scale=1.0" />
		<title>E-Learning</title>
		<link rel="stylesheet" href="css/bootstrap.css" />
		<link rel="stylesheet" href="css/style.css"/>
		<script type="text/javascript" src="js/jquery.js"></script>
		<script type="text/javascript" src="js/bootstrap.js"></script>
				<script type="text/javascript">
			$("#modal-login").modal("show");
		</script>
	    <style type="text/css">
<!--
.style2 {
	font-family: "Times New Roman", Times, serif;
	font-size: 16px;
}
.style7 {
	font-size: 16px;
	font-family: "Trebuchet MS";
}
-->
        </style>
</head>
	<body>
		<div class="navbar" id="menu">
			<?php include_once("menu.php");?>
		</div>
		
	<div class="page">
	
	<?php include_once("slide.php");?>
			<br>
			<div class="row">
			<div class="alert alert-info">
			<marquee><span class="style7">Selamat Datang di Aplikasi E-Learning...</span>
			</marquee>
				</div>
				<div class="col-sm-8">
				
		    
        	
			<?php
			
			include"content.php";
			?>
				</div>
 	<div class="col-sm-3 col-sm-offset-1 blog-sidebar">
					
					<div class="sidebar-module">
					<?php
					
					include "sidebar.php";
					?><hr />
						<center><div class='alert alert-success'>Kategori</div></center>
						<hr>
						<ol class="list-unstyled">
							<?php 
								$qry = mysql_query("SELECT * FROM kategori");
								while($rberita=mysql_fetch_array($qry)){
									echo"<li><a href=\"media.php?module=topik&act=detailtopik&id=$rberita[idkategori]\">$rberita[nm_kategori]</a></li><br>";
								}
							?>
						</ol>
					</div>
				</div></div>
	</div>
		<div class="panel-footer">
			<h6>&copy 2017 All Right Reserved. <strong>E-Learning</strong></h6>
		</div>
		<?php 
			//include_once("modal-howto.php");
			//include_once("modal-login.php");
			//include_once("modal-register.php");
		?>
	</body>
</html>
 <script defer src="js/jquery.flexslider.js"></script>
<link rel="stylesheet" href="css/flexslider.css" type="text/css" media="screen" />

<script>
// Can also be used with $(document).ready()
$(window).load(function() {
  $('.flexslider').flexslider({
    animation: "slide",
    controlNav: "thumbnails"
  });
});
</script>
<?php
}
?>