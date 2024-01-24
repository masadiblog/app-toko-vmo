<?php
session_start();
require 'conf.php';
if(mysqli_num_rows(mysqli_query($con, "SELECT * FROM tb_admin")) === 0){
  echo '<script>window.location.href="'.$base_url.'?pg=register"</script>';
  exit;
}
if(isset($_SESSION['login_access'])){
  if($_SESSION['login_access'] == true){
    echo '<script>window.location.href="'.$base_url.'"</script>';
    exit;
  }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <meta name="theme-color" content="#0dcaf0">
    <title>Login App Toko</title>
    <meta name="descripton" content="Form Login - silahkan masukkan username dan password Anda">
    <meta property="og:url" content="<?=$base_url;?>">
    <meta property="og:title" content="Login App Toko">
    <meta property="og:description" content="Form Login - silahkan masukkan username dan password Anda">
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
  <body style="background-color:var(--biru)" data-target-uri="<?=$base_url;?>" data-target-host="<?=$_SERVER['HTTP_HOST'];?>">
    <div id="__blank"><div></div></div>
    <div class="container">
      <form autocomplete="off" id="login" class="bg-light shadow rounded p-4 pt-5 mb-5">
        <div class="border-bottom mb-3 text-center">
          <h5>Login App Toko</h5>
          <p class="text-muted">Masukkan Username &amp; Password</p>
        </div>
        <div class="mb-3">
          <label for="username" class="form-label">Username</label>
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-at"></i></span>
            <input type="text" id="username" class="form-control py-2">
          </div>
          <div class="err"></div>
        </div>
        <div class="mb-3">
          <label for="password" class="form-label">Password</label>
          <div class="input-group">
            <span class="input-group-text"><i class="fas fa-key"></i></span>
            <input type="password" id="password" class="form-control py-2">
            <span id="shp" class="input-group-text"><i class="fas fa-eye"></i></span>
          </div>
          <div class="err"></div>
        </div>
        <div class="mb-3">
          <div class="d-flex align-items-center">
            <input type="checkbox" id="remember" class="me-1">
            <label for="remember">Ingat masuk</label>
          </div>
        </div>
        <div class="text-center my-4">
          <button type="submit" class="col-6 btn text-bg-info">LOGIN</button>
        </div>
        <div class="text-center mb-3">
          Belum Punya Akun? <a href="<?=$base_url.'?pg=register';?>">Buat Baru</a>
        </div>
      </form>
    </div>