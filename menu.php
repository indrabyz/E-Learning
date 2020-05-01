<div class="navbar-inner">
<ul class="nav">
<?php
if ($_SESSION['leveluser']=='siswa'){
echo "<li><a href='media.php'><b>Home</b></a></li>";
echo "<li><a href='media.php?module=kelas'><b>Kelas Anda</b></a></li>";
echo "<li><a href='media.php?module=matapelajaran'><b>Mata Pelajaran</b></a></li>";
echo "<li><a href='media.php?module=materi'><b>Materi</b></a></li>";
echo "<li><a href='media.php?module=quiz'><b>Tugas / Quiz</b></a></li>";
echo "<li><a href='media.php?module=nilai'><b>Nilai</b></a></li>";
echo "<li><a href='media.php?module=topik'><b>Forum</b></a></li>";
echo "<li><a href='media.php?module=chat'><b>Chat</b></a></li>";
echo "<li><a href='media.php?module=posting-topik'><b>Posting Topik</b></a></li>";

echo "<li><a href='media.php?module=siswa&act=detailprofilsiswa&id=$_SESSION[idsiswa]'><b>Edit Profil</b></a></li>";
echo "<li><a href='media.php?module=siswa&act=detailaccount'><b>Akun</b></a></li>";
echo "<li><a href='media.php?module=logout'><b>Logout</b></a></li>";

}elseif(($_SESSION['leveluser']=='dosen')){
echo "<li><a href='media.php'><b>Home</b></a></li>";
//echo "<li><a href='media.php?module=kelas'><b>Manajemen Kelas</b></a></li>";
echo "<li><a href='media.php?module=matapelajaran'><b>Manajemen MataKuliah</b></a></li>";
echo "<li><a href='media.php?module=quiz'><b>Manajemen Quiz</b></a></li>";
echo "<li><a href='media.php?module=materi'><b>Manajemen Materi</b></a></li>";

echo "<li><a href='media.php?module=topik'><b>Forum</b></a></li>";
echo "<li><a href='media.php?module=chat'><b>Chat</b></a></li>";
echo "<li><a href='media.php?module=posting-topik'><b>Posting Topik</b></a></li>";

echo "<li><a href='media.php?module=logout'><b>Logout</b></a></li>";
}
?>
</ul>
</div>