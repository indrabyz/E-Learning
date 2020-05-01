<script>
function confirmdelete(delUrl) {
if (confirm("Anda yakin ingin menghapus?")) {
document.location = delUrl;
}
}
</script>

<?php
//include "configurasi/koneksi.php";
include "configurasi/library.php";
//include "configurasi/fungsi_indotgl.php";
//include "configurasi/fungsi_combobox.php";
//include "configurasi/class_paging.php";

//konten guru
$aksi_kelas="administrator/modul/mod_kelas/aksi_kelas.php";
$aksi_mapel="administrator/modul/mod_matapelajaran/aksi_matapelajaran.php";


// Bagian Home
if ($_GET['module']=='home' or $_GET['module']==""){
  if ($_SESSION['leveluser']=='siswa'){
  echo "<br><b class='judul'>Hai $_SESSION[namalengkap]</b><br><p class='garisbawah'></p>
        Selamat datang di <b>E-Learning ...</b>.<br>";
  }
}
// Bagian kelas
elseif ($_GET['module']=='kelas'){
  if ($_SESSION['leveluser']=='siswa' or $_SESSION['leveluser']=='dosen'){
      include "administrator/modul/mod_kelas/kelas.php";
  }
}

// Bagian siswa
elseif ($_GET['module']=='siswa'){
  if ($_SESSION['leveluser']=='siswa' or $_SESSION['leveluser']=='dosen'){
      include "administrator/modul/mod_siswa/siswa.php";
  }
}

// Bagian admin
elseif ($_GET['module']=='admin'){
  if ($_SESSION['leveluser']=='dosen'){
      include "administrator/modul/mod_admin/admin.php";
  }
}

// Bagian mapel
elseif ($_GET['module']=='matapelajaran'){
  if ($_SESSION['leveluser']=='siswa' or $_SESSION['leveluser']=='dosen'){
      include "administrator/modul/mod_matapelajaran/matapelajaran.php";
  }
}

// Bagian materi
elseif ($_GET['module']=='materi'){
  if ($_SESSION['leveluser']=='siswa' or $_SESSION['leveluser']=='dosen'){
      include "administrator/modul/mod_materi/materi.php";
  }
}

// Bagian materi
elseif ($_GET['module']=='quiz'){
  if ($_SESSION['leveluser']=='siswa' or $_SESSION['leveluser']=='dosen'){
      include "administrator/modul/mod_quiz/quiz.php";
  }
}

// Bagian materi
elseif ($_GET['module']=='kerjakan_quiz'){
  if ($_SESSION['leveluser']=='siswa'){
      include "administrator/modul/mod_quiz/soal.php";
  }
}

// Bagian materi
elseif ($_GET['module']=='nilai'){
  if ($_SESSION['leveluser']=='siswa'){
      include "daftarnilai.php";
  }
}

// Bagian forum
elseif ($_GET['module']=='topik'){
  if ($_SESSION['leveluser']=='siswa' or $_SESSION['leveluser']=='dosen'){
      include "topik.php";
  }
}

// Bagian posting
elseif ($_GET['module']=='posting-topik'){
  if ($_SESSION['leveluser']=='siswa' or $_SESSION['leveluser']=='dosen'){
      include "posting-topik.php";
  }
}
// Bagian posting
elseif ($_GET['module']=='chat'){
  if ($_SESSION['leveluser']=='siswa' or $_SESSION['leveluser']=='dosen'){
      include "chat.php";
  }
}

// Bagian posting
elseif ($_GET['module']=='drzchat'){
  if ($_SESSION['leveluser']=='siswa' or $_SESSION['leveluser']=='dosen'){
      include "drzchat.php";
  }
}

// Bagian posting
elseif ($_GET['module']=='logout'){
      include "logout.php";
}

elseif ($_GET['module']=='modul'){
  if ($_SESSION['leveluser']=='dosen'){
    include "administrator/modul/mod_modul/modul.php";
  }
}
// Bagian user admin
elseif ($_GET['module']=='admin'){
  if ($_SESSION['leveluser']=='dosen'){
    include "administrator/modul/mod_admin/admin.php";
  }else{
      include "modul/mod_admin/admin.php";
  }
}

// Bagian user admin
elseif ($_GET['module']=='detailpengajar'){
  if ($_SESSION['leveluser']=='dosen'){
    include "administrator/modul/mod_admin/admin.php";
  }else{
      include "administrator/modul/mod_admin/admin.php";
  }
}

// Bagian kelas
elseif ($_GET['module']=='kelas'){
  if ($_SESSION['leveluser']=='dosen'){
    include "administrator/modul/mod_kelas/kelas.php";
  }
  elseif ($_SESSION['leveluser']=='dosen'){
      include "administrator/modul/mod_kelas/kelas.php";
  }
  elseif ($_SESSION['leveluser']=='dosen'){
      include "administrator/modul/mod_kelas/kelas.php";
  }

}


// Bagian siswa
elseif ($_GET['module']=='daftarsiswa'){
  if ($_SESSION['leveluser']=='dosen'){
    include "administrator/modul/mod_siswa/siswa.php";
  }else{
      include "administrator/modul/mod_siswa/siswa.php";
  }
}

// Bagian siswa
elseif ($_GET['module']=='detailsiswa'){
  if ($_SESSION['leveluser']=='dosen'){
    include "administrator/modul/mod_siswa/siswa.php";
  }else{
      include "administrator/modul/mod_siswa/siswa.php";
  }
}

// Bagian siswa
elseif ($_GET['module']=='detailsiswapengajar'){
  if ($_SESSION['leveluser']=='dosen'){
    include "administrator/modul/mod_siswa/siswa.php";
  }else{
      include "administrator/modul/mod_siswa/siswa.php";
  }
}

// Bagian mata pelajaran
elseif ($_GET['module']=='matapelajaran'){
  if ($_SESSION['leveluser']=='dosen'){
    include "administrator/modul/mod_matapelajaran/matapelajaran.php";
  }
  else{
      include "administrator/modul/mod_matapelajaran/matapelajaran.php";
  }
}

// Bagian materi
elseif ($_GET['module']=='materi'){
  if ($_SESSION['leveluser']=='dosen'){
    include "administrator/modul/mod_materi/materi.php";
  }else{
      include "administrator/modul/mod_materi/materi.php";
  }
}

// Bagian topik soal
elseif ($_GET['module']=='quiz'){
  if ($_SESSION['leveluser']=='dosen'){
    include "administrator/modul/mod_quiz/quiz.php";
  }else{
      include "administrator/modul/mod_quiz/quiz.php";
  }
}

// Bagian topik soal
elseif ($_GET['module']=='buatquiz'){
  if ($_SESSION['leveluser']=='dosen'){
    include "administrator/modul/mod_quiz/quiz.php";
  }else{
      include "administrator/modul/mod_quiz/quiz.php";
  }
}

// Bagian topik soal
elseif ($_GET['module']=='buatquizesay'){
  if ($_SESSION['leveluser']=='dosen'){
    include "administrator/modul/mod_quiz/quiz.php";
  }else{
      include "administrator/modul/mod_quiz/quiz.php";
  }
}

// Bagian topik soal
elseif ($_GET['module']=='buatquizpilganda'){
  if ($_SESSION['leveluser']=='dosen'){
    include "administrator/modul/mod_quiz/quiz.php";
  }else{
      include "administrator/modul/mod_quiz/quiz.php";
  }
}

// Bagian topik soal
elseif ($_GET['module']=='daftarquiz'){
  if ($_SESSION['leveluser']=='dosen'){
    include "administrator/modul/mod_quiz/quiz.php";
  }else{
      include "administrator/modul/mod_quiz/quiz.php";
  }
}

// Bagian topik soal
elseif ($_GET['module']=='daftarquizesay'){
  if ($_SESSION['leveluser']=='dosen'){
    include "administrator/modul/mod_quiz/quiz.php";
  }else{
      include "administrator/modul/mod_quiz/quiz.php";
  }
}

// Bagian topik soal
elseif ($_GET['module']=='daftarquizpilganda'){
  if ($_SESSION['leveluser']=='dosen'){
    include "administrator/modul/mod_quiz/quiz.php";
  }else{
      include "administrator/modul/mod_quiz/quiz.php";
  }
}

// Bagian Templates
elseif ($_GET['module']=='templates'){
  if ($_SESSION['leveluser']=='dosen'){
    include "administrator/modul/mod_templates/templates.php";
  }
}

// Bagian Templates
elseif ($_GET['module']=='registrasi'){
  if ($_SESSION['leveluser']=='dosen'){
    include "administrator/modul/mod_registrasi/registrasi.php";
  }
}


if ($_SESSION['leveluser']=='dosen' and $_GET[module]==""){
  echo "<p>Hai <b>$_SESSION[namalengkap]</b>,  selamat datang di halaman Dosen.<br>
          Silahkan klik menu yang tersedia untuk mengelola website.</p><br>";

          //detail pengajar
          $detail_pengajar=mysql_query("SELECT * FROM siswa WHERE id_siswa='$_SESSION[idsiswa]'");
          $p=mysql_fetch_array($detail_pengajar);
          $tgl_lahir   = tgl_indo($p[tgl_lahir]);
          echo "<form><fieldset>
              <legend>Detail Profil Anda</legend>
              <dl class='inline'>
          <table id='table1' class='table table-condensed table-bordered table-hover'>
          <tr><td rowspan='14'>";if ($p[foto]!=''){
              echo "<ul class='photos sortable'>
                    <li>
                    <img src='foto_pengajar/medium_$p[foto]'>
                    </li>
                    </ul>";
          }echo "</td><td>Nip</td>  <td> : $p[nis]</td><tr>
          <tr><td>Nama Lengkap</td> <td> : $p[nama_lengkap]</td></tr>
          <tr><td>Username</td>     <td> : $p[username_login]</td></tr>
          <tr><td>Alamat</td>       <td> : $p[alamat]</td></tr>
          <tr><td>Tempat Lahir</td> <td> : $p[tempat_lahir]</td></tr>
          <tr><td>Tanggal Lahir</td><td> : $tgl_lahir</td></tr>";
          if ($p[jenis_kelamin]=='P'){
           echo "<tr><td>Jenis Kelamin</td>     <td>  : Perempuan</td></tr>";
            }
            else{
           echo "<tr><td>Jenis kelamin</td>     <td> :  Laki - Laki </td></tr>";
            }echo"
          <tr><td>Agama</td>        <td> : $p[agama]</td></tr>
          <tr><td>No.Telp/HP</td>   <td> : $p[no_telp]</td></tr>
          <tr><td>E-mail</td>       <td> : $p[email]</td></tr>       
          <tr><td>Jabatan</td>      <td> : $p[jabatan]</td></tr>
          <tr><td>Aksi</td>         <td> : <input class='btn btn-info' type=button value='Edit Profil' onclick=\"window.location.href='?module=admin&act=editpengajar';\"></td></tr>
          </table></dl></fieldset></form>";
?><!--
         //kelas yang diampu
         echo"<form><fieldset>
              <legend>Kelas Yang anda ampu</legend>
              <dl class='inline'>
              <input class='button small blue' type=button value='Tambah' onclick=\"window.location.href='?module=kelas&act=tambahkelas';\">";
         
         $tampil_kelas = mysql_query("SELECT * FROM kelas WHERE id_pengajar = '$_SESSION[idsiswa]'");
         $ketemu=mysql_num_rows($tampil_kelas);
         if (!empty($ketemu)){
                echo "<br><br><table id='table1' class='table table-condensed table-bordered table-hover'><thead>
                <tr><th>No</th><th>Kelas</th><th>Ketua Kelas</th><th>Aksi</th></tr></thead>";

                $no=1;
                while ($r=mysql_fetch_array($tampil_kelas)){
                    echo "<tr><td>$no</td>                    
                    <td>$r[nama]</td>";

                    $siswa = mysql_query("SELECT * FROM siswa WHERE id_siswa = '$r[id_siswa]'");
                    $ada_siswa = mysql_num_rows($siswa);
                    if(!empty($ada_siswa)){
                    while ($s=mysql_fetch_array($siswa)){
                            echo"<td><a href=?module=siswa&act=detailsiswa&id=$s[id_siswa] title='Detail Siswa'>$s[nama_lengkap]</td>";
                     }
                    }else{
                            echo"<td></td>";
                    }
                    echo "<td><a href='?module=kelas&act=editkelas&id=$r[id]' title='Edit'><img src='images/icons/edit.png' alt='Edit' /></a> |
                    <a href=javascript:confirmdelete('$aksi_kelas?module=kelas&act=hapuswalikelas&id=$r[id]') title='Hapus'><img src='images/icons/cross.png' alt='Delete' /></a> |
                    <input class='btn btn-info' type=button value='Lihat Siswa' onclick=\"window.location.href='?module=siswa&act=lihatmurid&id=$r[id_kelas]';\">
                    ";
                $no++;
                }
                echo "</table></dl></fieldset></form>";
                }else{
                    echo"<br><br>Tidak ada kelas yang anda ampu";
                }
--><?php
   //mata pelajaran
   echo"<form><fieldset>
              <legend>mata pelajaran yang anda ampu</legend>
              <dl class='inline'>
   <input type=button class='btn btn-info' value='Tambah' onclick=\"window.location.href='?module=matapelajaran&act=tambahmatapelajaran';\">";
   
  $tampil_pelajaran = mysql_query("SELECT * FROM mata_pelajaran WHERE id_pengajar = '$_SESSION[idsiswa]'");
  $cek_mapel = mysql_num_rows($tampil_pelajaran);
  if (!empty($cek_mapel)){
    echo "<br><br><table id='table1' class='table table-condensed table-bordered table-hover'><thead>
          <tr><th>No</th><th>Nama</th><th>Kelas</th><th>Pengajar</th><th>Deskripsi</th><th>Aksi</th></tr></thead>";
    $no=1;
    while ($r=mysql_fetch_array($tampil_pelajaran)){
       echo "<tr><td>$no</td>             
             <td>$r[nama]</td>";
             $kelas = mysql_query("SELECT * FROM kelas WHERE id_kelas = '$r[id_kelas]'");
             $cek = mysql_num_rows($kelas);
             if(!empty($cek)){
             while($k=mysql_fetch_array($kelas)){
                 echo "<td><a href=?module=kelas&act=detailkelas&id=$r[id_kelas] title='Detail Kelas'>$k[nama]</td>";
             }
             }else{
                 echo"<td></td>";
             }
             $pengajar = mysql_query("SELECT * FROM siswa WHERE id_siswa = '$r[id_pengajar]'");
             $cek_pengajar = mysql_num_rows($pengajar);
             if(!empty($cek_pengajar)){
             while($p=mysql_fetch_array($pengajar)){
             echo "<td><a href=?module=admin&act=detailpengajar&id=$r[id_pengajar] title='Detail Pengajar'>$p[nama_lengkap]</a></td>";
             }
             }else{
                 echo"<td></td>";
             }
             echo "<td>$r[deskripsi]</td>
             <td><a href='?module=matapelajaran&act=editmatapelajaran&id=$r[id]' title='Edit'><img src='images/icons/edit.png' alt='Edit' /></a> |
             <a href=javascript:confirmdelete('$aksi_mapel?module=matapelajaran&act=hapus_mapel_pengajar&id=$r[id]') title='Hapus'><img src='images/icons/cross.png' alt='Delete' /></a>";
      $no++;
    }
    echo "</table></dl></fieldset></form>";
  }else{
      echo"<br><br>Tidak Ada Mata Pelajaran Yang Di Ampu";
  }

		echo"
                <p>&nbsp;</p>";
 	}
?>
