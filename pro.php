<?php
session_start();
require 'conf.php';

if(isset($_SESSION['login_access'])){
  $idgrup = $_SESSION['grup'];
  $idtoko = $_SESSION['toko'];
}else{
  $idgrup = $idtoko = '';
}

function localDate($loda){
  $tgl = explode('-', $loda);
  $bln = $tgl[1];
  switch($bln){ case '01': $bln = 'Januari'; break; case '02': $bln = 'Februari'; break; case '03': $bln = 'Maret'; break; case '04': $bln = 'April'; break; case '05': $bln = 'Mei'; break; case '06': $bln = 'Juni'; break; case '07': $bln = 'Juli'; break; case '08': $bln = 'Agustus'; break; case '09': $bln = 'September'; break; case '10': $bln = 'Oktober'; break; case '11': $bln = 'November'; break; case '12': $bln = 'Desember'; break; }
  return $tgl[2].' '.$bln.' '.$tgl[0];
}

if(isset($_POST['register']) && $_POST['register'] == true){
  $idgrup = '';
  $idtoko = '';
  $username = htmlentities($_POST['username']);
  $password = htmlentities(password_hash($_POST['password'], PASSWORD_DEFAULT));
  $admin = mysqli_query($con, "SELECT * FROM tb_admin WHERE username='$username'");
  $result = mysqli_num_rows($admin);
  $level = 'level_pemilik';
  $row = mysqli_fetch_array($admin);
  if($result == 0){
    $save = "INSERT INTO tb_admin VALUES(NULL, '$idgrup', '$idtoko', '$username', '$password', '$level')";
    if(mysqli_query($con, $save)){
      $redirect = $base_url;
      $data = array(
        'oke' => true,
        'drc' => $redirect,
        'title' => 'Berhasil',
        'text' => '<p>Akun Anda berhasil disimpan.</p><p>Langkah berikutnya silahkan login dan daftarkan nama grup usaha atau toko Anda.</p>',
        'icon' => 'success',
        'btn' => 'Oke',
      );
    }else{
      $data = array(
        'not' => true,
        'title' => 'Gagal',
        'text' => 'Akun Anda gagal disimpan!',
        'icon' => 'failed',
        'btn' => 'Tutup',
      );
    }
  }else{
    $data = array(
      'not_user' => true,
      'msg' => 'Username sudah digunakan!',
    );
  }
  echo json_encode($data);
  exit;
}

if(isset($_POST['input-admin']) && $_POST['input-admin'] == true){
  $idgrup = $_SESSION['grup'];
  $idtoko = htmlentities($_POST['toko']);
  $username = htmlentities($_POST['username']);
  $password = htmlentities(password_hash($_POST['password'], PASSWORD_DEFAULT));
  $level = 'level_admin';
  if(mysqli_num_rows(mysqli_query($con, "SELECT * FROM tb_admin WHERE username='$username'")) === 0){
    $save = "INSERT INTO tb_admin VALUES(NULL, '$idgrup', '$idtoko', '$username', '$password', '$level')";
    if(mysqli_query($con, $save)){
      if(isset($_SERVER['HTTP_REFERER'])){
        $redirect = $_SERVER['HTTP_REFERER'];
      }else{
        $redirect = $base_url;
      }
      $data = array(
        'oke' => true,
        'drc' => $redirect,
        'title' => 'Berhasil',
        'text' => 'Data admin berhasil ditambahkan.',
        'icon' => 'success',
        'btn' => 'Oke',
      );
    }else{
      $data = array(
        'not' => true,
        'title' => 'Gagal',
        'text' => 'Data admin gagal ditambahkan!',
        'icon' => 'failed',
        'btn' => 'Tutup',
      );
    }
  }else{
    $data = array(
      'not_user' => true,
      'msg' => 'Username sudah digunakan!',
    );
  }
  echo json_encode($data);
  exit;
}

if(isset($_POST['edit-admin']) && $_POST['edit-admin'] == true){
  $id = htmlentities($_POST['iduser']);
  $username = htmlentities($_POST['username']);
  $selAdmin = mysqli_query($con, "SELECT * FROM tb_admin WHERE id_admin<>'$id' AND username='$username'");
  if(mysqli_num_rows($selAdmin) === 0){
    if($_POST['password'] == ''){
      $password = '';
    }else{
      $password = ", password='".htmlentities(password_hash($_POST['password'], PASSWORD_DEFAULT))."'";
    }
    $save = "UPDATE tb_admin SET username='$username'$password WHERE id_admin='$id'";
    if(mysqli_query($con, $save)){
      $data = array(
        'oke' => true,
        'title' => 'Berhasil',
        'text' => 'Data admin berhasil diperbarui.',
        'icon' => 'success',
        'btn' => 'Oke',
      );
    }else{
      $data = array(
        'not' => true,
        'title' => 'Gagal',
        'text' => 'Data admin gagal diperbarui!',
        'icon' => 'failed', 
        'btn' => 'Tutup',
      );
    }
  }else{
    $data = array(
      'not_user' => true,
      'msg' => 'Username sudah digunakan!',
    );
  }
  echo json_encode($data);
  exit;
}

if(isset($_POST['hapus-admin']) && $_POST['hapus-admin'] == true){
  $id = htmlentities($_POST['dataId']);
  $save = "DELETE FROM tb_admin WHERE id_admin='$id'";
  if(mysqli_query($con, $save)){
    if($id == $_SESSION['admin']){
      $_SESSION['login_access'] = '';
      $_SESSION['user'] = '';
      $_SESSION['level'] = '';
      $_SESSION['admin'] = '';
      $_SESSION['grup'] = '';
      $_SESSION['toko'] = '';
      unset($_SESSION['login_access']);
      unset($_SESSION['user']);
      unset($_SESSION['level']);
      unset($_SESSION['admin']);
      unset($_SESSION['grup']);
      unset($_SESSION['toko']);
      setcookie('acc', '', time() - 3600);
      setcookie('token', '', time() - 3600);
      session_unset();
      session_destroy();
      $data = array(
        'oke' => true,
        'drc' => $base_url,
      );
    }
    $data = array(
      'oke' => true,
      'title' => 'Berhasil',
      'text' => 'Akun admin berhasil dihapus.',
      'icon' => 'success',
      'btn' => 'Oke',
    );
  }else{
    $data = array(
      'not' => true,
      'title' => 'Gagal',
      'text' => 'Akun admin gagal dihapus!',
      'icon' => 'failed',
      'btn' => 'Tutup',
    );
  }
  echo json_encode($data);
  exit;
}

if(isset($_POST['login']) && $_POST['login'] == true){
  $username = htmlentities($_POST['username']);
  $password = htmlentities($_POST['password']);
  $admin = mysqli_query($con, "SELECT * FROM tb_admin WHERE username='$username'");
  if(mysqli_num_rows($admin) === 1){
    $row = mysqli_fetch_array($admin);
    if(password_verify($password, $row['password'])){
      $_SESSION['login_access'] = true;
      $_SESSION['user'] = $row['username'];
      $_SESSION['level'] = $row['level'];
      $_SESSION['admin'] = $row['id_admin'];
      $_SESSION['grup'] = $row['id_grup'];
      $_SESSION['toko'] = $row['id_toko'];
      if($_POST['remember'] == 'true'){
        setcookie('acc', trim(base64_encode('file_app_toko_created_by_arnadi_237'.$row['id_admin'].'023_'.time().'.php'),'='), time() + 60 * 60 * 24);
        setcookie('token', base64_encode(password_hash($row['username'], PASSWORD_DEFAULT)), time() + 60 * 60 * 24);
      }
      $data = array(
        'oke' => true,
        'drc' => $base_url,
      );
    }else{
      $data = array(
        'not_pass' => true,
        'msg' => 'Password salah!',
      );
    }
  }else{
    $data = array(
      'not_user' => true,
      'msg' => 'Username salah!',
    );
  }
  echo json_encode($data);
  exit;
}

if(isset($_POST['logout']) && $_POST['logout'] == true){
  $_SESSION['login_access'] = '';
  $_SESSION['user'] = '';
  $_SESSION['level'] = '';
  $_SESSION['admin'] = '';
  $_SESSION['grup'] = '';
  $_SESSION['toko'] = '';
  unset($_SESSION['login_access']);
  unset($_SESSION['user']);
  unset($_SESSION['level']);
  unset($_SESSION['admin']);
  unset($_SESSION['grup']);
  unset($_SESSION['toko']);
  setcookie('acc', '', time() - 3600);
  setcookie('token', '', time() - 3600);
  session_unset();
  session_destroy();
  $data = array(
    'oke' => true,
    'drc' => $base_url,
  );
  echo json_encode($data);
  exit;
}

if(isset($_POST['input-grup']) && $_POST['input-grup'] == true){
  $nama = htmlentities($_POST['nama']);
  if(mysqli_num_rows(mysqli_query($con, "SELECT * FROM tb_grup WHERE nama='$nama'")) === 0){
    $save = "INSERT INTO tb_grup VALUES(NULL, '$nama')";
    if(mysqli_query($con, $save)){
      $selGrup = mysqli_query($con, "SELECT* FROM tb_grup WHERE nama='$nama'");
      $rowGrup = mysqli_fetch_array($selGrup);
      $idgrup = $rowGrup['id_grup'];
      $idadmin = $_SESSION['admin'];
      $update = "UPDATE tb_admin SET id_grup='$idgrup' WHERE id_admin='$idadmin'";
      if(mysqli_query($con, $update)){
        $_SESSION['grup'] = $idgrup;
        $data = array(
          'oke' => true,
          'title' => 'Berhasil',
          'text' => '<p>Nama grup berhasil disimpan.</p><p>Langkah berikutnya tambahkan toko pertama Anda.</p>',
          'icon' => 'success',
          'btn' => 'Oke',
        );
      }
    }else{
      $data = array(
        'not' => true,
        'title' => 'Gagal',
        'text' => 'Nama grup gagal disimpan!',
        'icon' => 'failed',
        'btn' => 'Tutup',
      );
    }
  }else{
    $data = array(
      'not_nama' => true,
      'msg' => 'Nama grup tidak tersedia!',
    );
  }
  echo json_encode($data);
  exit;
}

if(isset($_POST['edit-grup']) && $_POST['edit-grup'] == true){
  $id = htmlentities($_POST['dataId']);
  $nama = htmlentities($_POST['nama']);
  if(mysqli_num_rows(mysqli_query($con, "SELECT * FROM tb_grup WHERE id_grup<>'$id' AND nama='$nama'")) === 0){
    $save = "UPDATE tb_grup SET nama='$nama' WHERE id_grup='$id'";
    if(mysqli_query($con, $save)){
      $data = array(
        'oke' => true,
        'title' => 'Berhasil',
        'text' => 'Nama grup berhasil diperbarui.',
        'icon' => 'success',
        'btn' => 'Oke',
      );
    }else{
      $data = array(
        'not' => true,
        'title' => 'Gagal',
        'text' => 'Nama grup gagal diperbarui!',
        'icon' => 'failed',
        'btn' => 'Tutup',
      );
    }
  }else{
    $data = array(
      'not_nama' => true,
      'msg' => 'Nama sudah digunakan!',
    );
  }
  echo json_encode($data);
  exit;
}

if(isset($_POST['hapus-grup']) && $_POST['hapus-grup'] == true){
  $id = htmlentities($_POST['dataId']);
  if(mysqli_query($con, "DELETE FROM tb_catatan WHERE id_grup='$id'")){
    if(mysqli_query($con, "DELETE FROM tb_modal WHERE id_grup='$id'")){
      if(mysqli_query($con, "DELETE FROM tb_penjualan WHERE id_grup='$id'")){
        if(mysqli_query($con, "DELETE FROM tb_pengeluaran WHERE id_grup='$id'")){
          if(mysqli_query($con, "DELETE FROM tb_admin WHERE id_grup='$id'")){
            if(mysqli_query($con, "DELETE FROM tb_toko WHERE id_grup='$id'")){
              if(mysqli_query($con, "DELETE FROM tb_grup WHERE id_grup='$id'")){
                $_SESSION['login_access'] = '';
                $_SESSION['user'] = '';
                $_SESSION['level'] = '';
                $_SESSION['admin'] = '';
                $_SESSION['grup'] = '';
                $_SESSION['toko'] = '';
                unset($_SESSION['login_access']);
                unset($_SESSION['user']);
                unset($_SESSION['level']);
                unset($_SESSION['admin']);
                unset($_SESSION['grup']);
                unset($_SESSION['toko']);
                setcookie('acc', '', time() - 3600);
                setcookie('token', '', time() - 3600);
                session_unset();
                session_destroy();
                $data = array(
                  'oke' => true,
                  'title' => 'Berhasil',
                  'text' => 'Data grup berhasil dihapus.',
                  'icon' => 'success',
                  'btn' => 'Oke',
                );
              }else{
                $data = array(
                  'not' => true,
                  'title' => 'Gagal',
                  'text' => 'Data grup gagal dihapus!',
                  'icon' => 'failed',
                  'btn' => 'Tutup',
                );
              }
            }else{
              $data = array(
                'not' => true,
                'title' => 'Gagal',
                'text' => 'Tabel data toko gagal dihapus!',
                'icon' => 'failed',
                'btn' => 'Tutup',
              );
            }
          }else{
            $data = array(
              'not' => true,
              'title' => 'Gagal',
              'text' => 'Tabel data admin gagal dihapus!',
              'icon' => 'failed',
              'btn' => 'Tutup',
            );
          }
        }else{
          $data = array(
            'not' => true,
            'title' => 'Gagal',
            'text' => 'Tabel data pengeluaran gagal dihapus!',
            'icon' => 'failed',
            'btn' => 'Tutup',
          );
        }
      }else{
        $data = array(
          'not' => true,
          'title' => 'Gagal',
          'text' => 'Tabel data penjualan gagal dihapus!',
          'icon' => 'failed',
          'btn' => 'Tutup',
        );
      }
    }else{
      $data = array(
        'not' => true,
        'title' => 'Gagal',
        'text' => 'Tabel data modal gagal dihapus!',
        'icon' => 'failed',
        'btn' => 'Tutup',
      );
    }
  }else{
    $data = array(
      'not' => true,
      'title' => 'Gagal',
      'text' => 'Tabel data catatan gagal dihapus!',
      'icon' => 'failed',
      'btn' => 'Tutup',
    );
  }
  echo json_encode($data);
  exit;
}

if(isset($_POST['input-toko']) && $_POST['input-toko'] == true){
  $nama = htmlentities($_POST['nama']);
  $idgrup = $_SESSION['grup'];
  if(mysqli_num_rows(mysqli_query($con, "SELECT * FROM tb_toko WHERE nama='$nama'")) === 0){
    $save = "INSERT INTO tb_toko VALUES(NULL, '$idgrup', '$nama')";
    if(mysqli_query($con, $save)){
      $selToko = mysqli_query($con, "SELECT* FROM tb_toko WHERE id_grup='$idgrup' AND nama='$nama'");
      $rowToko = mysqli_fetch_array($selToko);
      $idtoko = $rowToko['id_toko'];
      $idadmin = $_SESSION['admin'];
      $update = "UPDATE tb_admin SET id_toko='$idtoko' WHERE id_admin='$idadmin'";
      if(mysqli_query($con, $update)){
        $_SESSION['toko'] = $idgrup;
        $data = array(
          'oke' => true,
          'title' => 'Berhasil',
          'text' => '<p>Nama toko berhasil disimpan.</p><p>Langkah berikutnya silahkan input data merek dan modal pada tombol input data atau dimenu dikanan atas.</p>',
          'icon' => 'success',
          'btn' => 'Oke',
        );
      }
    }else{
      $data = array(
        'not' => true,
        'title' => 'Gagal',
        'text' => 'Nama toko gagal disimpan!',
        'icon' => 'failed',
        'btn' => 'Tutup',
      );
    }
  }else{
    $data = array(
      'not_nama' => true,
      'msg' => 'Nama toko tidak tersedia!',
    );
  }
  echo json_encode($data);
  exit;
}

if(isset($_POST['input-toko-baru']) && $_POST['input-toko-baru'] == true){
  $nama = htmlentities($_POST['namaToko']);
  $idgrup = $_SESSION['grup'];
  if(mysqli_num_rows(mysqli_query($con, "SELECT * FROM tb_toko WHERE nama='$nama'")) === 0){
    $save = "INSERT INTO tb_toko VALUES(NULL, '$idgrup', '$nama')";
    if(mysqli_query($con, $save)){
      $listData = mysqli_query($con, "SELECT * FROM tb_toko WHERE id_grup='$idgrup' ORDER BY id_toko DESC");
      while($listToko = mysqli_fetch_array($listData)){
        if($nama == $listToko['nama']){
          $selected = 'selected ';
        }else{
          $selected = '';
        }
        $list [] = '<option '.$selected.'value="'.$listToko['id_toko'].'">'.$listToko['nama'].'</option>';
      }
      $data = array(
        'oke' => true,
        'title' => 'Berhasil',
        'text' => 'Toko baru berhasil ditambahkan.',
        'icon' => 'success',
        'btn' => 'Oke',
        'list' => $list,
      );
    }else{
      $data = array(
        'not' => true,
        'title' => 'Gagal',
        'text' => 'Toko baru gagal ditambahkan!',
        'icon' => 'failed',
        'btn' => 'Tutup',
      );
    }
  }else{
    $data = array(
      'not_nama' => true,
      'msg' => 'Nama toko tidak tersedia!',
    );
  }
  echo json_encode($data);
  exit;
}

if(isset($_POST['edit-toko']) && $_POST['edit-toko'] == true){
  $id = htmlentities($_POST['dataId']);
  $nama = htmlentities($_POST['nama']);
  if(mysqli_num_rows(mysqli_query($con, "SELECT * FROM tb_toko WHERE id_toko<>$id AND nama='$nama'")) === 0){
    $save = "UPDATE tb_toko SET nama='$nama' WHERE id_toko='$id' AND id_grup='$idgrup'";
    if(mysqli_query($con, $save)){
      $data = array(
        'oke' => true,
        'title' => 'Berhasil',
        'text' => 'Nama toko berhasil diperbarui.',
        'icon' => 'success',
        'btn' => 'Oke',
      );
    }else{
      $data = array(
        'not' => true,
        'title' => 'Gagal',
        'text' => 'Nama toko gagal diperbarui!',
        'icon' => 'failed',
        'btn' => 'Tutup',
      );
    }
  }else{
    $data = array(
      'not_nama' => true,
      'msg' => 'Nama sudah digunakan!',
    );
  }
  echo json_encode($data);
  exit;
}

if(isset($_POST['hapus-toko']) && $_POST['hapus-toko'] == true){
  $id = htmlentities($_POST['dataId']);
  if(mysqli_query($con, "DELETE FROM tb_catatan WHERE id_grup='$idgrup' AND id_toko='$id'")){
    if(mysqli_query($con, "DELETE FROM tb_modal WHERE id_grup='$idgrup' AND id_toko='$id'")){
      if(mysqli_query($con, "DELETE FROM tb_penjualan WHERE id_grup='$idgrup' AND id_toko='$id'")){
        if(mysqli_query($con, "DELETE FROM tb_pengeluaran WHERE id_grup='$idgrup' AND id_toko='$id'")){
          if(mysqli_query($con, "DELETE FROM tb_admin WHERE id_grup='$idgrup' AND id_toko='$id'")){
            if(mysqli_query($con, "DELETE FROM tb_toko WHERE id_toko='$id' AND id_grup='$idgrup'")){
              $data = array(
                'oke' => true,
                'title' => 'Berhasil',
                'text' => 'Toko berhasil dihapus.',
                'icon' => 'success',
                'btn' => 'Oke',
              );
            }else{
              $data = array(
                'not' => true,
                'title' => 'Gagal',
                'text' => 'Toko gagal dihapus!',
                'icon' => 'failed',
                'btn' => 'Tutup',
              );
            }
          }else{
            $data = array(
              'not' => true,
              'title' => 'Gagal',
              'text' => 'Tabel data admin toko gagal dihapus!',
              'icon' => 'failed',
              'btn' => 'Tutup',
            );
          }
        }else{
          $data = array(
            'not' => true,
            'title' => 'Gagal',
            'text' => 'Tabel data pengeluaran gagal dihapus!',
            'icon' => 'failed',
            'btn' => 'Tutup',
          );
        }
      }else{
        $data = array(
          'not' => true,
          'title' => 'Gagal',
          'text' => 'Tabel data penjualan toko gagal dihapus!',
          'icon' => 'failed',
          'btn' => 'Tutup',
        );
      }
    }else{
      $data = array(
        'not' => true,
        'title' => 'Gagal',
        'text' => 'Tabel data modal toko gagal dihapus!',
        'icon' => 'failed',
        'btn' => 'Tutup',
      );
    }
  }else{
    $data = array(
      'not' => true,
      'title' => 'Gagal',
      'text' => 'Tabel data catatan toko gagal dihapus!',
      'icon' => 'failed',
      'btn' => 'Tutup',
    );
  }
  echo json_encode($data);
  exit;
}

if(isset($_POST['input-data']) && $_POST['input-data'] == true){
  $nama = htmlentities($_POST['nama']);
  $modal = htmlentities(str_replace('.', '',$_POST['modal']));
  $jual = htmlentities(str_replace('.', '',$_POST['jual']));
  if(mysqli_num_rows(mysqli_query($con, "SELECT * FROM tb_modal WHERE id_grup='$idgrup' AND id_toko='$idtoko' AND nama='$nama'")) === 0){
    $save = "INSERT INTO tb_modal VALUES(NULL, '$idgrup', '$idtoko', '$nama', '$modal', '$jual')";
    if(mysqli_query($con, $save)){
      $data = array(
        'oke' => true,
        'title' => 'Berhasil',
        'text' => 'Data produk berhasil ditambahkan.',
        'icon' => 'success',
        'btn' => 'Oke',
      );
    }else{
      $data = array(
        'not' => true,
        'title' => 'Gagal',
        'text' => 'Data produk gagal ditambahkan!',
        'icon' => 'failed',
        'btn' => 'Tutup',
      );
    }
  }else{
    $data = array(
      'not_nama' => true,
      'msg' => 'Sudah ada di tabel!',
    );
  }
  echo json_encode($data);
  exit;
}

if(isset($_POST['edit-data']) && $_POST['edit-data'] == true){
  $id = htmlentities($_POST['id']);
  $nama = htmlentities($_POST['nama']);
  $modal = htmlentities(str_replace('.', '',$_POST['modal']));
  $jual = htmlentities(str_replace('.', '',$_POST['jual']));
  if(mysqli_num_rows(mysqli_query($con, "SELECT * FROM tb_modal WHERE id_modal<>'$id' AND id_grup='$idgrup' AND id_toko='$idtoko' AND nama='$nama'")) === 0){
    $save = "UPDATE tb_modal SET nama='$nama', modal='$modal', jual='$jual' WHERE id_modal='$id'";
    if(mysqli_query($con, $save)){
      $data = array(
        'oke' => true,
        'title' => 'Berhasil',
        'text' => 'Data produk berhasil diperbarui.',
        'icon' => 'success',
        'btn' => 'Oke',
      );
    }else{
      $data = array(
        'not' => true,
        'title' => 'Gagal',
        'text' => 'Data produk gagal diperbarui!',
        'icon' => 'failed',
        'btn' => 'Tutup',
      );
    }
  }else{
    $data = array(
      'not_nama' => true,
      'msg' => 'Data ini sudah pernah diinput sebelumnya!',
    );
  }
  echo json_encode($data);
  exit;
}

if(isset($_POST['hapus-data']) && $_POST['hapus-data'] == true){
  $id = htmlentities($_POST['id']);
  $save = "DELETE FROM tb_modal WHERE id_modal='$id' AND id_grup='$idgrup' AND id_toko='$idtoko'";
  if(mysqli_query($con, $save)){
    $data = array(
      'oke' => true,
      'title' => 'Dihapus',
      'text' => 'Data merek dan modal berhasil dihapus.',
      'icon' => 'success',
      'btn' => 'Oke',
    );
  }else{
    $data = array(
      'not' => true,
      'title' => 'Gagal',
      'text' => 'Data merek dan modal gagal dihapus!',
      'icon' => 'failed',
      'btn' => 'Tutup',
    );
  }
  echo json_encode($data);
  exit;
}

if(isset($_POST['load-data']) && $_POST['load-data'] == true){
  $nama = htmlentities($_POST['nama']);
  $sel_data = mysqli_query($con, "SELECT * FROM tb_modal WHERE nama LIKE '%".$nama."%' AND id_grup='$idgrup' AND id_toko='$idtoko' ORDER BY nama ASC");
  if(mysqli_num_rows($sel_data)){
    echo '<ul class="list-group">';
    while($row = mysqli_fetch_array($sel_data)){
      $modal = number_format($row['modal'],0,',','.');
      if($row['jual'] != ''){
        $jual = number_format($row['jual'],0,',','.');
      }else{
        $jual = '';
      }
      echo '<li id="item" class="list-group-item" data-modal="'.$modal.'" data-harga="'.$jual.'">'.$row['nama'].'</li>';
    }
    echo '</ul>';
  }else{
    echo '<ul class="list-group">
      <li class="list-group-item fw-semibold text-danger">Belum Tersedia!</li>
      <li class="list-group-item">
        <a href="'.$base_url.'?pg=input-modal" class="text-primary text-decoration-none"><i class="fas fa-square-plus"></i> Tambah Baru</a>
      </li>
    </ul>';
  }
  exit;
}

if(isset($_POST['cari-data']) && $_POST['cari-data'] == true){
  $merek = htmlentities($_POST['merek']);
  if($merek != ''){
    $sel_data = mysqli_query($con, "SELECT * FROM tb_modal WHERE nama LIKE '%".$merek."%' AND id_grup='$idgrup' AND id_toko='$idtoko' ORDER BY nama ASC");
    if(mysqli_num_rows($sel_data)){
      echo '
          <tr>
            <td colspan="6" class="text-bg-light text-center py-1">'.mysqli_num_rows($sel_data).' data ditemukan</td>
          </tr>
      ';
      $no = 1;
      while($row = mysqli_fetch_array($sel_data)){
        $id_modal = $row['id_modal'];
        $nama = $row['nama'];
        $modal = number_format($row['modal'],0,',','.');
        if($row['jual'] != ''){
          $jual = number_format($row['jual'],0,',','.');
        }else{
          $jual = '';
        }
        echo '
          <tr>
            <td valign="middle" class="text-center">'.$no.'</td>
            <td valign="middle">'.$nama.'</td>
            <td valign="middle">'.$modal.'</td>
            <td valign="middle">'.$jual.'</td>
            <td style="width:32px" valign="middle" id="editData" class="text-center" data-bs-toggle="modal" data-bs-target="#editModal" data-id="'.$id_modal.'" data-nama="'.$nama.'" data-modal="'.$modal.'" data-jual="'.$jual.'"><i class="fas fa-edit text-success"></i></td>
            <td style="width:32px" valign="middle" id="hapusData" class="text-center" data-id="'.$id_modal.'" data-baris="'.$no.'" data-nama="'.$nama.'" data-modal="'.$modal.'" data-jual="'.$jual.'"><i class="fas fa-trash text-danger"></i></td>
          </tr>';
        $no++;
      }
    }else{
      echo '<tr><td colspan="5" class="text-center text-muted">Data tidak ditemukan!</td></tr>';
    }
  }else{
    $sel_data = mysqli_query($con, "SELECT * FROM tb_modal WHERE id_grup='$idgrup' AND id_toko='$idtoko' ORDER BY id_modal DESC");
    if(mysqli_num_rows($sel_data)){
      echo '
          <tr>
            <td colspan="5" class="text-bg-light text-center py-1">'.mysqli_num_rows($sel_data).' data tersimpan</td>
          </tr>
      ';
      $no = 1;
      while($row = mysqli_fetch_array($sel_data)){
        $id_modal = $row['id_modal'];
        $nama = $row['nama'];
        $modal = number_format($row['modal'],0,',','.');
        if($row['jual'] != ''){
          $jual = number_format($row['jual'],0,',','.');
        }else{
          $jual = '';
        }
        echo '
          <tr>
            <td valign="middle" class="text-center">'.$no.'</td>
            <td valign="middle">'.$nama.'</td>
            <td valign="middle">'.$modal.'</td>
            <td valign="middle">'.$jual.'</td>
            <td style="width:32px" valign="middle" id="editData" class="text-center" data-bs-toggle="modal" data-bs-target="#editModal" data-id="'.$id_modal.'" data-nama="'.$nama.'" data-modal="'.$modal.'" data-jual="'.$jual.'"><i class="fas fa-edit text-success"></i></td>
            <td style="width:32px" valign="middle" id="hapusData" class="text-center" data-id="'.$id_modal.'" data-baris="'.$no.'" data-nama="'.$nama.'" data-modal="'.$modal.'" data-jual="'.$jual.'"><i class="fas fa-trash text-danger"></i></td>
          </tr>';
        $no++;
      }
    }else{
      echo '<tr><td colspan="5" class="text-center text-danger">Belum ada data!</td></tr>';
    }
  }
  exit;
}

if(isset($_POST['input-penjualan']) && $_POST['input-penjualan'] == true){
  $nama = htmlentities($_POST['nama']);
  $harga = htmlentities(str_replace('.', '',$_POST['harga']));
  $jumlah = htmlentities(str_replace(',', '.',str_replace('.', '',$_POST['jumlah'])));
  $modal = htmlentities(str_replace('.', '',$_POST['modal']));
  $tanggal = htmlentities($_POST['tanggal']);
  $bulan = htmlentities($_POST['bulan']);
  $tahun = htmlentities($_POST['tahun']);
  $laba = ($harga * $jumlah) - ($modal * $jumlah);
  if($tanggal == ''){
    $tanggal = $date_now;
  }else{
    $tanggal = $tanggal;
  }
  if($bulan == ''){
    $bulan = $month_now;
  }else{
    $bulan = $bulan;
  }
  if($tahun == ''){
    $tahun = $year_now;
  }else{
    $tahun = $tahun;
  }
  $save = "INSERT INTO tb_penjualan VALUES(NULL, '$idgrup', '$idtoko', '$nama', '$harga', '$jumlah', '$modal', '$laba', '$tanggal', '$bulan', '$tahun')";
  if(mysqli_query($con, $save)){
    $data = array(
      'oke' => true,
    );
  }else{
    $data = array(
      'not' => true,
      'title' => 'Gagal',
      'text' => 'Data penjualan gagal ditambahkan!',
      'icon' => 'failed',
      'btn' => 'Tutup',
    );
  }
  echo json_encode($data);
  exit;
}

if(isset($_POST['set-pengeluaran']) && $_POST['set-pengeluaran'] == true){
  $pengeluaran = htmlentities(str_replace('.', '',$_POST['pengeluaran']));
  $keterangan = htmlentities($_POST['keterangan']);
  $tanggal = htmlentities($_POST['tanggal']);
  $bulan = htmlentities($_POST['bulan']);
  $tahun = htmlentities($_POST['tahun']);
  if($tanggal == ''){
    $tanggal = $date_now;
  }else{
    $tanggal = $tanggal;
  }
  if($bulan == ''){
    $bulan = $month_now;
  }else{
    $bulan = $bulan;
  }
  if($tahun == ''){
    $tahun = $year_now;
  }else{
    $tahun = $tahun;
  }
  $save = "INSERT INTO tb_pengeluaran VALUES(NULL, '$idgrup', '$idtoko', '$pengeluaran', '$keterangan', '$tanggal', '$bulan', '$tahun')";
  if(mysqli_query($con, $save)){
    $data = array(
      'oke' => true,
      'title' => 'Berhasil',
      'text' => 'Data pengeluaran berhasil ditambahkan.',
      'icon' => 'success',
      'btn' => 'Oke',
    );
  }else{
    $data = array(
      'not' => true,
      'title' => 'Gagal',
      'text' => 'Data pengeluaran gagal ditambahkan!',
      'icon' => 'failed',
      'btn' => 'Tutup',
    );
  }
  echo json_encode($data);
  exit;
}

if(isset($_POST['hapus-pengeluaran']) && $_POST['hapus-pengeluaran'] == true){
  $id = htmlentities($_POST['id']);
  $save = "DELETE FROM tb_pengeluaran WHERE id_pengeluaran='$id' AND id_grup='$idgrup' AND id_toko='$idtoko'";
  if(mysqli_query($con, $save)){
    $data = array(
      'oke' => true,
      'title' => 'Berhasil',
      'text' => 'Data pengeluaran berhasil dihapus.',
      'icon' => 'success',
      'btn' => 'Oke',
    );
  }else{
    $data = array(
      'not' => true,
      'title' => 'Gagal',
      'text' => 'Data pengeluaran gagal dihapus!',
      'icon' => 'failed',
      'btn' => 'Tutup',
    );
  }
  echo json_encode($data);
  exit;
}

if(isset($_POST['hapus-item-penjualan']) && $_POST['hapus-item-penjualan'] == true){
  $id = htmlentities($_POST['id']);
  $save = "DELETE FROM tb_penjualan WHERE id_penjualan='$id' AND id_grup='$idgrup' AND id_toko='$idtoko'";
  if(mysqli_query($con, $save)){
    $data = array(
      'oke' => true,
      'title' => 'Berhasil',
      'text' => 'Data penjualan berhasil dihapus.',
      'icon' => 'success',
      'btn' => 'Oke',
    );
  }else{
    $data = array(
      'not' => true,
      'title' => 'Gagal',
      'text' => 'Data penjualan gagal dihapus!',
      'icon' => 'failed',
      'btn' => 'Tutup',
    );
  }
  echo json_encode($data);
  exit;
}

if(isset($_POST['edit-item-penjualan']) && $_POST['edit-item-penjualan'] == true){
  $id = htmlentities($_POST['id']);
  $harga = htmlentities(str_replace('.', '',$_POST['harga']));
  $jumlah = htmlentities(str_replace(',', '.',str_replace('.', '',$_POST['jumlah'])));
  $modal = htmlentities(str_replace('.', '',$_POST['modal']));
  $laba = ($harga * $jumlah) - ($modal * $jumlah);
  $save = "UPDATE tb_penjualan SET harga='$harga', jumlah='$jumlah', laba='$laba' WHERE id_penjualan='$id' AND id_grup='$idgrup' AND id_toko='$idtoko'";
  if(mysqli_query($con, $save)){
    $data = array(
      'oke' => true,
      'title' => 'Berhasil',
      'text' => 'Data penjualan berhasil diperbarui.',
      'icon' => 'success',
      'btn' => 'Oke',
    );
  }else{
    $data = array(
      'not' => true,
      'title' => 'Gagal',
      'text' => 'Data penjualan gagal diperbarui!',
      'icon' => 'failed',
      'btn' => 'Tutup',
    );
  }
  echo json_encode($data);
  exit;
}

if(isset($_POST['tambah-catatan']) && $_POST['tambah-catatan'] == true){
  $judul = htmlentities($_POST['judul']);
  $catatan = htmlentities(str_replace("\n", '<br>',$_POST['catatan']));
  $tanggal = $date_now;
  $bulan = $month_now;
  $tahun = $year_now;
  if(mysqli_num_rows(mysqli_query($con, "SELECT * FROM tb_catatan WHERE judul='$judul' AND id_grup='$idgrup' AND id_toko='$idtoko'")) === 0){
    if(mysqli_query($con, "INSERT INTO tb_catatan VALUES(NULL, '$idgrup', '$idtoko', '$judul', '$catatan', '$tanggal', '$bulan', '$tahun')")){
      $data = array(
        'oke' => true,
        'title' => 'Berhasil',
        'text' => 'Catatan berhasil disimpan.',
        'icon' => 'success',
        'btn' => 'Oke',
      );
    }else{
      $data = array(
        'not' => true,
        'title' => 'Gagal',
        'text' => 'Catatan gagal disimpan!',
        'icon' => 'failed',
        'btn' => 'Tutup',
      );
    }
  }else{
    $data = array(
      'not_judul' => true,
      'msg' => 'Judul yang sama sudah ada!',
    );
  }
  echo json_encode($data);
  exit;
}

if(isset($_POST['edit-catatan']) && $_POST['edit-catatan'] == true){
  $id = htmlentities($_POST['target']);
  $judul = htmlentities($_POST['judul']);
  $catatan = htmlentities(str_replace("\n", '<br>',$_POST['catatan']));
  if(mysqli_num_rows(mysqli_query($con, "SELECT * FROM tb_catatan WHERE id_catatan<>'$id' AND judul='$judul' AND id_grup='$idgrup' AND id_toko='$idtoko'")) === 0){
    if(mysqli_query($con, "UPDATE tb_catatan SET judul='$judul', catatan='$catatan' WHERE id_catatan='$id' AND id_grup='$idgrup' AND id_toko='$idtoko'")){
      $data = array(
        'oke' => true,
        'title' => 'Berhasil',
        'text' => 'Catatan berhasil diperbarui.',
        'icon' => 'success',
        'btn' => 'Oke',
      );
    }else{
      $data = array(
        'not' => true,
        'title' => 'Gagal',
        'text' => 'Catatan gagal diperbarui!',
        'icon' => 'failed',
        'btn' => 'Tutup',
      );
    }
  }else{
    $data = array(
      'not_judul' => true,
      'msg' => 'Judul yang sama sudah ada!',
    );
  }
  echo json_encode($data);
  exit;
}

if(isset($_POST['hapus-catatan']) && $_POST['hapus-catatan'] == true){
  $id = htmlentities($_POST['target']);
  if(mysqli_query($con, "DELETE FROM tb_catatan WHERE id_catatan='$id' AND id_grup='$idgrup' AND id_toko='$idtoko'")){
    $data = array(
      'oke' => true,
      'title' => 'Berhasil',
      'text' => 'Catatan berhasil dihapus.',
      'icon' => 'success',
      'btn' => 'Oke',
    );
  }else{
    $data = array(
      'not' => true,
      'title' => 'Gagal',
      'text' => 'Catatan gagal dihapus!',
      'icon' => 'failed',
      'btn' => 'Tutup',
    );
  }
  echo json_encode($data);
  exit;
}

if(isset($_POST['cari-catatan']) && $_POST['cari-catatan'] == true){
  $key = htmlentities($_POST['cacat']);
  $selData1 = mysqli_query($con, "SELECT * FROM tb_catatan WHERE judul LIKE '%".$key."%' AND id_grup='$idgrup' AND id_toko='$idtoko' ORDER BY id_catatan DESC");
  $resCatatan = mysqli_num_rows($selData1);
  if($resCatatan){
    $no = 1;
    while($row1 = mysqli_fetch_array($selData1)){
      echo '
      <tr>
        <td valign="middle" class="text-bg-light text-center">'.$no.'</td>
        <td valign="middle" class="text-bg-light"><div>'.$row1['judul'].'</div><div><i class="text-muted" style="font-size:.8em">'.$row1['tanggal'].' '.$row1['bulan'].' '.$row1['tahun'].'</i> &nbsp; <a style="width:20px;font-size:.8em" valign="middle" class="text-bg-light text-center" id="btnEditCatatan" data-target="'.$row1['id_catatan'].'" data-judul="'.$row1['judul'].'" data-catatan="'.$row1['catatan'].'" data-bs-toggle="modal" data-bs-target="#catatanModal"><i class="fas fa-edit text-success"></i></a> &nbsp; <a style="width:20px;font-size:.8em" valign="middle" class="text-bg-light text-center" id="btnHapusCatatan" data-target="'.$row1['id_catatan'].'" data-judul="'.$row1['judul'].'"><i class="fas fa-trash text-danger"></i></a></div></td>
        <td style="width:30px" valign="middle" class="text-bg-light text-center psr" id="btnDetailCatatan" data-target="'.$row1['id_catatan'].'" data-judul="'.$row1['judul'].'" data-catatan="'.$row1['catatan'].'" data-tanggal="'.$row1['tanggal'].' '.$row1['bulan'].' '.$row1['tahun'].'" data-bs-toggle="modal" data-bs-target="#detailCatatanModal"><i class="fas fa-eye text-info"></i></td>
      </tr>
      ';
      $no++;
    }
  }else{
    echo '
    <tr>
      <td colspan="3" class="bg-light text-center text-muted py-5">Catatan tidak ditemukan!</td>
    </tr>
    ';
  }
  exit;
}

if(isset($_POST['input-omset']) && $_POST['input-omset'] == true){
  $omset = str_replace('.', '',htmlentities($_POST['omset']));
  $tgl = explode(' ', localDate(htmlentities($_POST['tanggal'])));
  $tanggal = $tgl[0];
  $bulan = $tgl[1];
  $tahun = $tgl[2];
  if(mysqli_num_rows(mysqli_query($con, "SELECT * FROM tb_omha WHERE id_grup='$idgrup' AND id_toko='$idtoko' AND tanggal='$tanggal' AND bulan='$bulan' AND tahun='$tahun'")) === 0){
    if(mysqli_query($con, "INSERT INTO tb_omha VALUES(NULL, '$idgrup', '$idtoko', '$omset', '$tanggal', '$bulan', '$tahun')")){
      $data = array(
        'oke' => true,
        'title' => 'Berhasil',
        'text' => 'Omset berhasil ditambahkan.',
        'icon' => 'success',
        'btn' => 'Oke',
      );
    }else{
      $data = array(
        'not' => true,
        'title' => 'Gagal',
        'text' => 'Omset gagal ditambahkan.',
        'icon' => 'failed',
        'btn' => 'Tutup',
      );
    }
  }else{
    $data = array(
      'not' => true,
      'title' => 'Gagal',
      'text' => 'Omset pada tanggal '.$tanggal.' '.$bulan.' '.$tahun.' sudah ada!',
      'icon' => 'failed',
      'btn' => 'Tutup',
    );
  }
  echo json_encode($data);
  exit;
}

if(isset($_POST['edit-omset']) && $_POST['edit-omset'] == true){
  $id = htmlentities($_POST['id']);
  $omset = str_replace('.', '',htmlentities($_POST['omset']));
  if($_POST['tanggal'] != ''){
    $tgl = explode(' ',localDate(htmlentities($_POST['tanggal'])));
    $tanggal = $tgl[0];
    $bulan = $tgl[1];
    $tahun = $tgl[2];
  }else{
    $sel = mysqli_query($con, "SELECT * FROM tb_omha WHERE id_omha='$id' AND id_grup='$idgrup' AND id_toko='$idtoko'");
    $row = mysqli_fetch_array($sel);
    $tanggal = $row['tanggal'];
    $bulan = $row['bulan'];
    $tahun = $row['tahun'];
  }
  if(mysqli_num_rows(mysqli_query($con, "SELECT * FROM tb_omha WHERE id_omha<>'$id' AND id_grup='$idgrup' AND id_toko='$idtoko' AND tanggal='$tanggal' AND bulan='$bulan' AND tahun='$tahun'")) === 0){
    if(mysqli_query($con, "UPDATE tb_omha SET omset='$omset', tanggal='$tanggal', bulan='$bulan', tahun='$tahun' WHERE id_omha='$id' AND id_grup='$idgrup' AND id_toko='$idtoko'")){
      $data = array(
        'oke' => true,
        'title' => 'Berhasil',
        'text' => 'Omset berhasil disimpan.',
        'icon' => 'success',
        'btn' => 'Oke',
      );
    }else{
      $data = array(
        'oke' => true,
        'title' => 'Gagal',
        'text' => 'Omset gagal disimpan!',
        'icon' => 'failed',
        'btn' => 'Tutup',
      );
    }
  }else{
    $data = array(
      'not' => true,
      'title' => 'Gagal',
      'text' => 'Omset pada tanggal '.$tanggal.' '.$bulan.' '.$tahun.' sudah ada!',
      'icon' => 'failed',
      'btn' => 'Tutup',
    );
  }
  echo json_encode($data);
  exit;
}

if(isset($_POST['input-keluar']) && $_POST['input-keluar'] == true){
  $nama = htmlentities($_POST['nama']);
  $jumlah = str_replace('.', '',htmlentities($_POST['jumlah']));
  $keterangan = str_replace("\n", '<br>',htmlentities($_POST['keterangan']));
  $tgl = explode(' ',localDate(htmlentities($_POST['tanggal'])));
  $tanggal = $tgl[0];
  $bulan = $tgl[1];
  $tahun = $tgl[2];
  if(mysqli_query($con, "INSERT INTO tb_keluar VALUES(NULL, '$idgrup', '$idtoko', '$nama', '$jumlah', '$keterangan', '$tanggal', '$bulan', '$tahun')")){
    $data = array(
      'oke' => true,
      'title' => 'Berhasil',
      'text' => 'Data berhasil disimpan.',
      'icon' => 'success',
      'btn' => 'Oke',
    );
  }else{
    $data = array(
      'oke' => true,
      'title' => 'Gagal',
      'text' => 'Data gagal disimpan!',
      'icon' => 'failed',
      'btn' => 'Tutup',
    );
  }
  echo json_encode($data);
  exit;
}

if(isset($_POST['input-masuk']) && $_POST['input-masuk'] == true){
  $nama = htmlentities($_POST['nama']);
  $jumlah = str_replace('.', '',htmlentities($_POST['jumlah']));
  $keterangan = str_replace("\n", '<br>',htmlentities($_POST['keterangan']));
  $tgl = explode(' ',localDate(htmlentities($_POST['tanggal'])));
  $tanggal = $tgl[0];
  $bulan = $tgl[1];
  $tahun = $tgl[2];
  if(mysqli_query($con, "INSERT INTO tb_masuk VALUES(NULL, '$idgrup', '$idtoko', '$nama', '$jumlah', '$keterangan', '$tanggal', '$bulan', '$tahun')")){
    $data = array(
      'oke' => true,
      'title' => 'Berhasil',
      'text' => 'Data berhasil disimpan.',
      'icon' => 'success',
      'btn' => 'Oke',
    );
  }else{
    $data = array(
      'oke' => true,
      'title' => 'Gagal',
      'text' => 'Data gagal disimpan!',
      'icon' => 'failed',
      'btn' => 'Tutup',
    );
  }
  echo json_encode($data);
  exit;
}

if(isset($_POST['hapus-omset']) && $_POST['hapus-omset'] == true){
  $id = htmlentities($_POST['id']);
  if(mysqli_query($con, "DELETE FROM tb_omha WHERE id_omha='$id' AND id_grup='$idgrup' AND id_toko='$idtoko'")){
    $data = array(
      'oke' => true,
      'title' => 'Berhasil',
      'text' => 'Data berhasil dihapus.',
      'icon' => 'success',
      'btn' => 'Oke',
    );
  }else{
    $data = array(
      'not' => true,
      'title' => 'Gagal',
      'text' => 'Data gagal dihapus!',
      'icon' => 'failed',
      'btn' => 'Tutup',
    );
  }
  echo json_encode($data);
  exit;
}

if(isset($_POST['detail-keluar']) && $_POST['detail-keluar'] == true){
  $id = htmlentities($_POST['id']);
  $sel = mysqli_query($con, "SELECT * FROM tb_keluar WHERE id_keluar='$id' AND id_grup='$idgrup' AND id_toko='$idtoko'");
  if(mysqli_num_rows($sel)){
    $row = mysqli_fetch_array($sel);
    $data = array(
      'oke' => true,
      'title' => 'Detail Keluar',
      'text' => '
        <h6>'.$row['nama'].'</h6>
        <p class="mb-1" style="font-size:.8em"><span class="bg-light text-muted">Data tanggal '.$row['tanggal'].' '.$row['bulan'].' '.$row['tahun'].'</span></p>
        <p>'.number_format($row['jumlah'],0,',','.').', '.$row['keterangan'].'</p>
      ',
      'icon' => 'success',
      'btn' => 'Tutup',
    );
  }
  echo json_encode($data);
  exit;
}

if(isset($_POST['detail-masuk']) && $_POST['detail-masuk'] == true){
  $id = htmlentities($_POST['id']);
  $sel = mysqli_query($con, "SELECT * FROM tb_masuk WHERE id_masuk='$id' AND id_grup='$idgrup' AND id_toko='$idtoko'");
  if(mysqli_num_rows($sel)){
    $row = mysqli_fetch_array($sel);
    $data = array(
      'oke' => true,
      'title' => 'Detail Masuk',
      'text' => '
        <h6>'.$row['nama'].'</h6>
        <p class="mb-1" style="font-size:.8em"><span class="bg-light text-muted">Data tanggal '.$row['tanggal'].' '.$row['bulan'].' '.$row['tahun'].'</span></p>
        <p>'.number_format($row['jumlah'],0,',','.').', '.$row['keterangan'].'</p>
      ',
      'icon' => 'success',
      'btn' => 'Tutup',
    );
  }
  echo json_encode($data);
  exit;
}

if(isset($_POST['load-kemas']) && $_POST['load-kemas'] == true){
  $id = htmlentities($_POST['data-target']);
  $push = htmlentities($_POST['data-push']);
  if($push == 'edit-keluar'){
    $sel = mysqli_query($con, "SELECT * FROM tb_keluar WHERE id_keluar='$id' AND id_grup='$idgrup' AND id_toko='$idtoko'");
    $row = mysqli_fetch_array($sel);
  }else{
    $sel = mysqli_query($con, "SELECT * FROM tb_masuk WHERE id_masuk='$id' AND id_grup='$idgrup' AND id_toko='$idtoko'");
    $row = mysqli_fetch_array($sel);
  }
  $bulan = $row['bulan'];
  switch($bulan){
    case 'Januari': $bulan = '01'; break;
    case 'Februari': $bulan = '02'; break;
    case 'Maret': $bulan = '03'; break;
    case 'April': $bulan = '04'; break;
    case 'Mei': $bulan = '05'; break;
    case 'Juni': $bulan = '06'; break;
    case 'Juli': $bulan = '07'; break;
    case 'Agustus': $bulan = '08'; break;
    case 'September': $bulan = '09'; break;
    case 'Oktober': $bulan = '10'; break;
    case 'November': $bulan = '11'; break;
    case 'Desember': $bulan = '12'; break;
  }
  $data = array(
    'oke' => true,
    'nama' => $row['nama'],
    'jumlah' => number_format($row['jumlah'],0,',','.'),
    'keterangan' => $row['keterangan'],
    'tanggal' => $row['tahun'].'-'.$bulan.'-'.$row['tanggal'],
  );
  echo json_encode($data);
  exit;
}

if(isset($_POST['edit-keluar']) && $_POST['edit-keluar'] == true){
  $id = htmlentities($_POST['id']);
  $nama = htmlentities($_POST['nama']);
  $jumlah = str_replace('.', '',htmlentities($_POST['jumlah']));
  $keterangan = str_replace("\n", '<br>',htmlentities($_POST['keterangan']));
  $tgl = explode(' ',localDate(htmlentities($_POST['tanggal'])));
  $tanggal = $tgl[0];
  $bulan = $tgl[1];
  $tahun = $tgl[2];
  if(mysqli_query($con, "UPDATE tb_keluar SET nama='$nama', jumlah='$jumlah', keterangan='$keterangan', tanggal='$tanggal', bulan='$bulan', tahun='$tahun' WHERE id_keluar='$id' AND id_grup='$idgrup' AND id_toko='$idtoko'")){
    $data = array(
      'oke' => true,
      'title' => 'Berhasil',
      'text' => 'Data keluar berhasil disimpan.',
      'icon' => 'success',
      'btn' => 'Oke',
    );
  }else{
    $data = array(
      'not' => true,
      'title' => 'Gagal',
      'text' => 'Data keluar gagal disimpan!',
      'icon' => 'failed',
      'btn' => 'Tutup',
    );
  }
  echo json_encode($data);
  exit;
}

if(isset($_POST['edit-masuk']) && $_POST['edit-masuk'] == true){
  $id = htmlentities($_POST['id']);
  $nama = htmlentities($_POST['nama']);
  $jumlah = str_replace('.', '',htmlentities($_POST['jumlah']));
  $keterangan = str_replace("\n", '<br>',htmlentities($_POST['keterangan']));
  $tgl = explode(' ',localDate(htmlentities($_POST['tanggal'])));
  $tanggal = $tgl[0];
  $bulan = $tgl[1];
  $tahun = $tgl[2];
  if(mysqli_query($con, "UPDATE tb_masuk SET nama='$nama', jumlah='$jumlah', keterangan='$keterangan', tanggal='$tanggal', bulan='$bulan', tahun='$tahun' WHERE id_masuk='$id' AND id_grup='$idgrup' AND id_toko='$idtoko'")){
    $data = array(
      'oke' => true,
      'title' => 'Berhasil',
      'text' => 'Data masuk berhasil disimpan.',
      'icon' => 'success',
      'btn' => 'Oke',
    );
  }else{
    $data = array(
      'not' => true,
      'title' => 'Gagal',
      'text' => 'Data masuk gagal disimpan!',
      'icon' => 'failed',
      'btn' => 'Tutup',
    );
  }
  echo json_encode($data);
  exit;
}

if(isset($_POST['hapus-keluar']) && $_POST['hapus-keluar'] == true){
  $id = htmlentities($_POST['id']);
  if(mysqli_query($con, "DELETE FROM tb_keluar WHERE id_keluar='$id' AND id_grup='$idgrup' AND id_toko='$idtoko'")){
    $data = array(
      'oke' => true,
      'title' => 'Berhasil',
      'text' => 'Data keluar berhasil dihapus.',
      'icon' => 'success',
      'btn' => 'Oke',
    );
  }else{
    $data = array(
      'not' => true,
      'title' => 'Gagal',
      'text' => 'Data keluar gagal dihapus!',
      'icon' => 'failed',
      'btn' => 'Tutup',
    );
  }
  echo json_encode($data);
  exit;
}

if(isset($_POST['hapus-masuk']) && $_POST['hapus-masuk'] == true){
  $id = htmlentities($_POST['id']);
  if(mysqli_query($con, "DELETE FROM tb_masuk WHERE id_masuk='$id' AND id_grup='$idgrup' AND id_toko='$idtoko'")){
    $data = array(
      'oke' => true,
      'title' => 'Berhasil',
      'text' => 'Data masuk berhasil dihapus.',
      'icon' => 'success',
      'btn' => 'Oke',
    );
  }else{
    $data = array(
      'not' => true,
      'title' => 'Gagal',
      'text' => 'Data masuk gagal dihapus!',
      'icon' => 'failed',
      'btn' => 'Tutup',
    );
  }
  echo json_encode($data);
  exit;
}
?>