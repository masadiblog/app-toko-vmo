<?php
if(isset($_COOKIE['acc']) && isset($_COOKIE['token'])){
  $gxa = base64_decode($_COOKIE['acc']);
  $gxb = explode('_', $gxa);
  $gxc = explode('237', $gxb[6]);
  $gxd = explode('023', $gxc[1]);
  $acc = $gxd[0];
  $xtoken = base64_decode($_COOKIE['token']);
  $selDataUsername = mysqli_query($con, "SELECT * FROM tb_admin WHERE id_admin='$acc' ");
  if(mysqli_num_rows($selDataUsername) === 1){
    $xrow = mysqli_fetch_assoc($selDataUsername);
    if(password_verify($xrow['username'], $xtoken)){
      $_SESSION['login_access'] = true;
      $_SESSION['user'] = $xrow['username'];
      $_SESSION['level'] = $xrow['level'];
      $_SESSION['admin'] = $xrow['id_admin'];
      $_SESSION['grup'] = $xrow['id_grup'];
      $_SESSION['toko'] = $xrow['id_toko'];
    }
  }else{
    echo '<script>window.location.href="'.$base_url.'?pg=login"</script>';
  }
}
?>