<?php
session_start();
require 'conf.php';
require 'admin/cookie.php';
if(isset($_SESSION['login_access'])){
  $idgrup = $_SESSION['grup'];
  $idtoko = $_SESSION['toko'];
}else{
  $idgrup = $idtoko = '';
}
if(isset($_GET['tanggal']) && $_GET['tanggal'] != ''){
  $xtgl = $_GET['tanggal'];
  $extgl = explode('-', $xtgl);
  $extgl[0] = isset($extgl[0])?($extgl[0]):'';
  $extgl[1] = isset($extgl[1])?($extgl[1]):'';
  $extgl[2] = isset($extgl[2])?($extgl[2]):'';
  $tanggal = $extgl[0];
  $bulan = $extgl[1];
  $tahun = $extgl[2];
}else{
  $tanggal = $date_now;
  $bulan = strtolower($month_now);
  $tahun = $year_now;
}
$selGrup = mysqli_query($con, "SELECT * FROM tb_grup WHERE id_grup='$idgrup'");
$resGrup = mysqli_num_rows($selGrup);
$rowGrup = mysqli_fetch_array($selGrup);
if($resGrup){
  $namaGrup = $rowGrup['nama'];
}else{
  $namaGrup = '';
}
$selToko = mysqli_query($con, "SELECT * FROM tb_toko WHERE id_toko='$idtoko'");
$resToko = mysqli_num_rows($selToko);
$rowToko = mysqli_fetch_array($selToko);
if($resToko){
  $namaToko = $rowToko['nama'];
}else{
  $namaToko = '';
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="theme-color" content="#0dcaf0">
    <title>App Toko</title>
    <meta name="descripton" content="Aplikasi Toko - Semua detail data penjualan, keuntungan, dan pengeluaran yang diinput tersimpan rapi. Aplikasi ini online dan hanya dapat digunakan pada Smartphone.">
    <meta property="og:url" content="<?=$base_url;?>">
    <meta property="og:title" content="App Toko">
    <meta property="og:description" content="Simpan data penjualan dengan rapi di App Toko.">
    <meta property="og:image" content="<?=$base_url.'files/img/icon-512x512.png';?>">
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="App Toko">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="manifest" href="<?=$base_url.'files/js/manifest.webmanifest?v='.filemtime('files/js/manifest.webmanifest');?>">
    <link rel="icon" type="image/png" href="<?=$base_url.'files/img/icon-72x72.png';?>">
    <link rel="shortcut icon" type="image/png" href="<?=$base_url.'files/img/icon-72x72.png';?>">
    <link rel="apple-touch-icon" type="image/png" href="<?=$base_url.'files/img/icon-192x192.png';?>">
    <link rel="stylesheet" href="<?=$base_url.'files/css/style.css?v='.filemtime('files/css/style.css');?>">
  </head>
<?php
if(!(isset($_SESSION['login_access']))){
  echo '<script>window.location.href="'.$base_url.'?pg=login"</script>';
  exit;
}
if(isset($_SESSION['level']) && $_SESSION['level'] != 'level_pemilik' && $_SESSION['level'] != 'level_admin'){
  echo '<script>window.location.href="'.$base_url.'?pg=login"</script>';
  exit;
}?>
  <body data-target-uri="<?=$base_url;?>" data-target-host="<?=$_SERVER['HTTP_HOST'];?>" oncopy="return false">
    <div class="container">
      <div class="navbar">
<?php
if(isset($_GET['pg']) || isset($_GET['tanggal'])){
  $btn_icon = '<i class="fas fa-arrow-left"></i>';
  $btn_id = 'btn-back';
}else{
  $btn_icon = '<i class="fas fa-home"></i>';
  $btn_id = '';
}
?>
        <span id="<?=$btn_id;?>" class="btn-back"><?=$btn_icon;?></span>
<?php if($resToko){ if(isset($_GET['pg'])){ $appTitleId = 'app-title'; $linkNamaToko = '<a href="'.$base_url.'">'.$namaToko.'</a>'; }else{ $appTitleId = ''; $linkNamaToko = $namaToko; } ?>
        <h1 id="<?=$appTitleId;?>"class="app-title"><img src="<?=$base_url.'files/img/icon-72x72.png';?>" alt="Logo App Toko"/><?=$linkNamaToko;?></h1>
<?php }else{
  $selNamaGrup = mysqli_query($con, "SELECT nama FROM tb_grup WHERE id_grup='$idgrup'");
  if(mysqli_num_rows($selNamaGrup)){
    $rowNamaGrup = mysqli_fetch_array($selNamaGrup);
    echo '<h1 class="app-title"><img src="'.$base_url.'files/img/icon-72x72.png" alt="Logo App Toko"/>'.$rowNamaGrup['nama'].'</h1>'; 
  }else{
    echo '<h1 class="app-title"><img src="'.$base_url.'files/img/icon-72x72.png" alt="Logo App Toko"/>App Toko</h1>';
  } } ?>
        <span id="logout" class="btn-logout"><i class="fas fa-sign-out"></i></span>
      </div>
    </div>
    <div id="__blank"><div></div></div>