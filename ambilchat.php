<?php

session_start();
error_reporting(0);
//include"timeout.php";

include"lib/koneksi.php";

$user=mysql_fetch_array(mysql_query("select * from siswa where id_siswa='$_SESSION[idsiswa]'"));
$read=mysql_query("update chat set status='R' where dari='$_GET[nama]' and ke='$_SESSION[idsiswa]'");


if (empty($_SESSION['idsiswa'])){
			 header('Location:index.php?module=home');
}
else{
 
	mysql_set_charset('utf8',$con);
	
	date_default_timezone_set('Asia/Jakarta');
	$tgl_skr=date('Y-m-d H:i:s');
	$nama = $_GET['nama']; 
	$pesan = $_GET['pesan']; 
	$waktu = date("H:i"); 
	$akhir = $_GET['akhir']; 
	
	$json = '{"messages": {'; 
	
	    if($pesan){ 
		$isi_pesan=str_replace("\"", "'", $pesan);
				
	        $masuk = mysql_query("INSERT INTO chat(idchat,
                                 dari,
                                 ke,
                                 isi_pesan,
                                 tgl_pesan)
	                       VALUES('',
                                '$user[id_siswa]',
								'$nama',
                                '$isi_pesan',
                                '$tgl_skr')"); 
	
	    } 
	    $query = mysql_query("select c.* from chat c where ((c.ke='$user[id_siswa]' and c.dari='$nama') or (c.ke='$nama' and c.dari='$user[id_siswa]')) and c.idchat > $akhir order by idchat"); 
		
		$query2 = mysql_query("select c.* from chat c where ((c.ke='$user[id_siswa]' and c.dari='$nama') or (c.ke='$nama' and c.dari='$user[id_siswa]')) and c.idchat > $akhir order by idchat"); 
		$r = mysql_fetch_array($query2);
		
		$sekarang=substr("$r[tgl_pesan]",0,10);
		
	    $json .= '"pesan":[ '; 
	    while($x = mysql_fetch_array($query)){
				$jam=substr("$x[tgl_pesan]",11,5);
				
				$get_t=substr("$x[tgl_pesan]",0,10);
				if($get_t!=$sekarang){
				if($get_t!=$get_t2){
					$get_t2=$get_t;
					
					$th=substr("$x[tgl_pesan]",0,4);
					$bln=substr("$x[tgl_pesan]",5,2);
					$d=substr("$x[tgl_pesan]",8,2);
					
					$tampil=$d.'-'.$bln.'-'.$th;
					
				}else{
					$get_t2=$get_t;
					
					$tampil="";
				}
				}else{
					$tampil="";
				}
				
	        $json .= '{'; 
	        $json .= '"id":"'.$x['idchat'].'", 
	                  "nama":"'.$x['dari'].'",
	                  "ke":"'.$x['ke'].'", 
	                  "teks":"'.$x['isi_pesan'].'",
					  "status":"'.$x[status].'",
	                  "jam":"'.$jam.'",
					  "skr":"'.$sekarang.'",
	                  "level":"'.$x['level'].'",
	                  "waktu":"'.$tampil.'" 
	                  },'; 
	    } 
	    $json = substr($json,0,strlen($json)-1); 
	    $json .= ']'; 
	 
	
	$json .= '}}'; 
	echo $json; 
	
}
?> 