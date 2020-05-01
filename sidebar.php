
<center><div class='alert alert-success'>Waktu Hari ini</div>
<embed src='images/clock.swf' style='margin-top:-20px;' quality='high' bgcolor='black' width='185' height='170' type='application/x-shockwave-flash' pluginspage='http://www.macromedia.com/shockwave/download/index.cgi? P1_Prod_Version=ShockwaveFlash'>
</center>
<center><div class='alert alert-success'>Kalender</div></center>
  <?php 
  include "fungsi_kalender.php";
  $tgl_skrg=date("d");
  $bln_skrg=date("n");
  $thn_skrg=date("Y");
  echo buatkalender($tgl_skrg,$bln_skrg,$thn_skrg); 
  ?>

