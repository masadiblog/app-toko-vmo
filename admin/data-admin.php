    <div class="container">
      <div class="d-flex justify-content-between border-bottom mb-2">
        <h5>Tabel Admin</h5>
<?php if(isset($_SESSION['level']) && $_SESSION['level'] == 'level_pemilik'){ ?>
        <a href="#" data-bs-toggle="modal" data-bs-target="#inputAdminModal"><i class="fas fa-user-plus"></i> Admin</a>
<?php } ?>
      </div>
<?php
if($resGrup){
?>
      <div>Data Admin <a href="<?=$base_url.'?pg=data-grup-toko';?>" class="text-decoration-none"><?=$namaGrup;?></a></div>
<?php } ?>
      <table class="table border table-striped">
        <thead>
          <tr>
            <th class="text-center">No</th>
            <th>Admin</th>
            <th>Toko</th>
            <th colspan="2" class="text-center"><i class="fas fa-angle-down"></i></th>
          </tr>
        </thead>
        <tbody>
<?php
$selData = mysqli_query($con, "SELECT * FROM tb_admin WHERE id_grup='$idgrup'");
if(mysqli_num_rows($selData)){
  $no = 1;
  while($rowData = mysqli_fetch_array($selData)){
    $idadmin = $rowData['id_admin'];
    $idtoko = $rowData['id_toko'];
    $username = $rowData['username'];
    $selData2 = mysqli_query($con, "SELECT * FROM tb_toko WHERE id_toko='$idtoko'");
    if(mysqli_num_rows($selData2)){
    $rowData2 = mysqli_fetch_array($selData2);
    $toko = $rowData2['nama'];
    }else{
      $toko = '_';
    }
?>
          <tr>
            <td valign="middle" class="text-center"><?=$no;?></td>
            <td valign="middle"><i class="text-muted">&#64;</i><?=$username;?></td>
            <td valign="middle"><?=$toko;?></td>
<?php if($_SESSION['admin'] == $idadmin){ ?>
            <td style="width:35px" valign="middle"><a href="#" id="editAdmin" data-id="<?=$idadmin;?>" data-user="<?=$username;?>" data-bs-toggle="modal" data-bs-target="#editAdminModal" class="text-warning"><i class="fas fa-edit"></i></a></td>
            <td style="width:35px" valign="middle"><a href="#" id="hapusAdmin" data-id="<?=$idadmin;?>" data-user="<?=$username;?>" class="text-danger"><i class="fas fa-trash"></i></a></td>
<?php }else if(isset($_SESSION['level']) && $_SESSION['level'] == 'level_pemilik'){ ?>
            <td style="width:35px" valign="middle"><a href="#" id="editAdmin" data-id="<?=$idadmin;?>" data-user="<?=$username;?>" data-bs-toggle="modal" data-bs-target="#editAdminModal" class="text-warning"><i class="fas fa-edit"></i></a></td>
            <td style="width:35px" valign="middle"><a href="#" id="hapusAdmin" data-id="<?=$idadmin;?>" data-user="<?=$username;?>" class="text-danger"><i class="fas fa-trash"></i></a></td>
<?php }else{ ?>
            <td colspan="2"></td>
<?php } ?>
          </tr>
<?php
    $no++;
  }
}
?>
        </tbody>
      </table>
    </div>
    <!-- modal tambah admin -->
    <div class="modal fade" id="inputAdminModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="exampleBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <form autocomplete="off" id="input-admin">
            <h5 class="border-bottom pb-2">Tambah Admin Baru</h5>
            <div class="mb-3">
              <label for="username" class="form-label">Username <span class="text-muted" style="font-size:.8em">(wajib huruf besar, kecil, angka)</span></label>
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-at"></i></span>
                <input type="search" id="username" class="form-control py-2">
              </div>
              <div class="err"></div>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password <span class="text-muted" style="font-size:.8em">(wajib huruf besar, kecil, angka)</span></label>
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-key"></i></span>
                <input type="password" id="password" class="form-control py-2">
                <span id="shp" class="input-group-text"><i class="fas fa-eye"></i></span>
              </div>
              <div class="err"></div>
            </div>
            <div class="mb-3">
              <label for="konfirmasi" class="form-label">Konfirmasi</label>
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-key"></i></span>
                <input type="password" id="konfirmasi" class="form-control py-2">
                <span id="shc" class="input-group-text"><i class="fas fa-eye"></i></span>
              </div>
              <div class="err"></div>
            </div>
            <div class="mb-3">
              <div id="inputToko" class="d-none mb-3 text-bg-light border shadow rounded p-3">
                <div class="d-flex justify-content-between">
                  <input type="search" id="namaToko" class="form-control me-2">
                  <button type="submit" id="simpanToko" class="btn btn-dark"><i class="fas fa-paper-plane"></i></button>
                </div>
                <div id="errNama" class="text-danger"></div>
              </div>
              <div class="d-flex justify-content-between">
                <label for="toko" class="form-label">Toko</label>
                <a href="#" class="input-toko text-decoration-none"><i class="fas fa-square-plus"></i> Toko</a>
              </div>
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-home"></i></span>
                <select id="toko" class="form-control py-2">
                  <option disabled="" selected="" value="">Pilih Toko</option>
<?php
$idgrup = $_SESSION['grup'];
$selToko = mysqli_query($con, "SELECT * FROM tb_toko WHERE id_grup='$idgrup' ORDER BY id_toko DESC");
if(mysqli_num_rows($selToko)){
  while($rowToko = mysqli_fetch_array($selToko)){
    $idtoko = $rowToko['id_toko'];
    $toko = $rowToko['nama'];
?>
                  <option value="<?=$idtoko;?>"><?=$toko;?></option>
<?php
  }
}
?>
                </select>
              </div>
              <div class="err"></div>
            </div>
            <div class="text-end">
              <button type="button" id="batalInput" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
              <button type="submit" class="btn text-bg-info">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
    <!-- modal edit admin -->
    <div class="modal fade" id="editAdminModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <form autocomplete="off" id="edit-admin">
            <h5 class="border-bottom pb-2">Perbarui Data Admin</h5>
            <div class="mb-3">
              <label for="username" class="form-label">Username <span class="text-muted" style="font-size:.8em">(wajib huruf besar, kecil, angka)</span></label>
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-at"></i></span>
                <input type="search" id="username" class="form-control py-2">
              </div>
              <div class="err"></div>
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password <span class="text-muted" style="font-size:.8em">(wajib huruf besar, kecil, angka)</span></label>
              <div class="input-group">
                <span class="input-group-text"><i class="fas fa-key"></i></span>
                <input type="password" id="password" class="form-control py-2">
                <span id="shp" class="input-group-text"><i class="fas fa-eye"></i></span>
              </div>
              <div class="err"></div>
            </div>
            <div class="text-end">
              <input type="hidden" id="data-id">
              <button type="button" id="batalEdit" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
              <button type="submit" class="btn text-bg-info">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>