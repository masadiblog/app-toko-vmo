<div class="container">
  
  <form autocomplete="off" id="input-data" class="input-data border border-info shadow rounded p-3">
    <h5 class="border-bottom border-info pb-2 text-center">Input Produk</h5>
    <div class="row">
      <div class="col-6">
        <label for="nama" class="form-label">Merek</label>
        <input type="search" id="nama" class="form-control" placeholder="Merek...">
        <div class="err"></div>
      </div>
      <div class="col-6 ps-0">
        <label for="modal" class="form-label">Modal</label>
        <div class="d-flex">
          <input type="search" id="modal" class="form-control me-2" placeholder="Modal...">
          <button type="submit" class="btn text-bg-info" style="width:42px"><i class="fas fa-angle-right"></i></button>
        </div>
        <div class="err"></div>
      </div>
    </div>
  </form>
  
  <?php
  $sel_modal = mysqli_query($con, "SELECT * FROM tb_modal WHERE id_grup='$idgrup' AND id_toko='$idtoko' ORDER BY id_modal DESC");
  $res_modal = mysqli_num_rows($sel_modal);
  if($res_modal > 0){
  ?>
  <div class="mt-2 mb-3">
    <div class="input-group shadow">
      <input type="search" placeholder="Cari Nama/Merek" id="cari-data" class="form-control">
      <span class="input-group-text">
        <a href="<?=$base_url;?>" class="text-decoration-none" style="font-size:.8em">
          <div class="d-inline-block" style="width:10px"><i class="fas fa-square-plus"></i></div> Penjualan
        </a>
      </span>
    </div>
  </div>
  <div class="tab-scroll mb-4 border border-info shadow" style="max-height:52vh">
    <table class="table table-striped mb-0">
      <thead>
        <tr style="position:sticky;top:0">
          <th class="text-bg-info text-center">No</th>
          <th class="text-bg-info">Merek</th>
          <th class="text-bg-info">Modal</th>
          <th colspan="2" class="text-bg-info text-center" style="width:60px"><i class="fas fa-chevron-down"></i></th>
        </tr>
      </thead>
      <tbody id="resmo">
        <tr>
          <td colspan="5" class="text-center py-1"><?=mysqli_num_rows($sel_modal);?> data tersimpan</td>
        </tr>
<?php
$no = 1;
while($row_modal = mysqli_fetch_array($sel_modal)){
  $id_modal = $row_modal['id_modal'];
  $nama = $row_modal['nama'];
  $modal = number_format($row_modal['modal'],0,',','.');
?>
        <tr>
          <td valign="middle" class="text-center"><?=$no;?></td>
          <td valign="middle"><?=$nama;?></td>
          <td valign="middle"><?=$modal;?></td>
          <td style="width:32px" valign="middle" id="editData" class="text-center" data-bs-toggle="modal" data-bs-target="#editModal" data-id="<?=$id_modal;?>" data-nama="<?=$nama;?>" data-modal="<?=$modal;?>"><i class="fas fa-edit text-success"></i></td>
          <td style="width:32px" valign="middle" id="hapusData" class="text-center" data-id="<?=$id_modal;?>" data-baris="<?=$no;?>" data-nama="<?=$nama;?>" data-modal="<?=$modal;?>"><i class="fas fa-trash text-danger"></i></td>
        </tr>
<?php
  $no++;
}
?>
      </tbody>
    </table>
  </div>
  <!-- edit modal -->
  <div class="modal fade" id="editModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <form autocomplete="off" id="edit-data">
            <h5 class="border-bottom pb-2">Edit Data</h5>
            <div class="mb-3">
              <label for="nama" class="form-label">Nama / Merek</label>
              <input type="search" id="nama" class="form-control" placeholder="Masukkan Nama / Merek...">
              <div class="err"></div>
            </div>
            <div class="mb-3">
              <label for="modal" class="form-label">Harga Modal</label>
              <input type="search" id="modal" class="form-control" placeholder="Masukkan Harga Modal...">
              <div class="err"></div>
            </div>
            <div class="text-end">
              <button type="button" id="batalEdit" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
              <button type="submit" class="btn text-bg-info">Perbarui</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
<?php } ?>
  
</div>