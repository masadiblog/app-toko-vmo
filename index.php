<?php
$page = '';
if(isset($_GET['pg'])){
  $page = $_GET['pg'];
}
switch($page){
  case 'data-penjualan':
    require 'header.php';
    require 'data-penjualan.php';
    require 'footer.php';
    break;
  case 'data-grup-toko':
    require 'header.php';
    require 'admin/grup-toko.php';
    require 'footer.php';
    break;
  case 'input-produk':
    require 'header.php';
    require 'admin/input-modal.php';
    require 'footer.php';
    break;
  case 'omha':
    require 'header.php';
    require 'admin/omha.php';
    require 'footer.php';
    break;
  case 'catatan':
    require 'header.php';
    require 'admin/catatan.php';
    require 'footer.php';
    break;
  case 'data-admin':
    require 'header.php';
    require 'admin/data-admin.php';
    require 'footer.php';
    break;
  case 'login':
    require 'admin/login.php';
    require 'footer.php';
    break;
  case 'register':
    require 'admin/register.php';
    require 'footer.php';
    break;
  default:
    require 'header.php';
    require 'data.php';
    require 'footer.php';
    break;
}
?>