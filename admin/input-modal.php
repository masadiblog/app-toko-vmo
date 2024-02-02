<div class="container px-1 pb-1">
  <h1 class="fs-6 mb-0">Input Data Produk</h1>
  <form autocomplete="off" id="input-data" class="bg-info input-data border border-info shadow rounded px-1 pt-0 pb-1">
    <div class="row mb-2">
      <div class="col-9">
        <label for="nama" class="form-label mb-0">Nama / Merek</label>
        <input type="search" id="nama" class="form-control">
        <div class="err"></div>
      </div>
      <div class="col-3 ps-1">
        <label for="stok" class="form-label mb-0">Stok</label>
        <input type="search" id="stok" class="form-control px-2">
      </div>
    </div>
    <div class="row">
      <div class="col-5">
        <label for="modal" class="form-label mb-0">Harga Modal</label>
        <input type="search" id="modal" class="form-control">
        <div class="err"></div>
      </div>
      <div class="col-7 ps-1">
        <label for="modal" class="form-label mb-0 d-flex justify-content-between">Harga Jual <span id="ssha" class="badge bg-light text-primary fw-normal" style="height:19px"></span></label>
        <div class="d-flex">
          <input type="search" id="jual" class="form-control me-3">
          <button type="submit" class="btn text-bg-secondary" style="width:50px"><i class="fas fa-angle-right"></i></button>
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
      <input type="search" placeholder="Masukkan Nama/Merek" id="cari-data" class="form-control">
      <span class="input-group-text">
        <a href="<?=$base_url;?>" class="text-decoration-none" style="font-size:.8em">
          <div class="d-inline-block" style="width:10px"><i class="fas fa-square-plus"></i></div> Penjualan
        </a>
      </span>
    </div>
  </div>
  <div class="tab-scroll mb-4 border border-info shadow" style="max-height:52vh">
    <table class="table table-striped mb-0" style="font-size:.85em">
      <thead class="bg-info">
        <tr class="border-info">
          <th class="text-bg-info text-center psl">No</th>
          <th class="text-bg-info">Merek</th>
          <th class="text-bg-info">Modal</th>
          <th class="text-bg-info">Jual</th>
          <th class="text-bg-info">Stok</th>
          <th class="text-bg-info text-center psr"><i class="fas fa-chevron-down"></i></th>
        </tr>
      </thead>
      <tbody id="resmo">
        <tr>
          <td colspan="6" class="text-bg-secondary text-center py-1"><?=mysqli_num_rows($sel_modal);?> data tersimpan</td>
        </tr>
<?php
$no = 1;
while($row_modal = mysqli_fetch_array($sel_modal)){
  $id_modal = $row_modal['id_modal'];
  $nama = $row_modal['nama'];
  $modal = number_format($row_modal['modal'],0,',','.');
  if($row_modal['jual'] != ''){
    $jual = number_format($row_modal['jual'],0,',','.');
  }else{
    $jual = '';
  }
  if($row_modal['stok'] != ''){
    $stok = number_format($row_modal['stok'],0,',','.');
  }else{
    $stok = '0';
  }
?>
        <tr>
          <td valign="middle" class="text-center psl"><?=$no;?></td>
          <td valign="middle"><?=$nama;?></td>
          <td valign="middle"><?=$modal;?></td>
          <td valign="middle"><?=$jual;?></td>
          <td valign="middle"><?=$stok;?></td>
          <td valign="middle" class="text-center psr">
            &nbsp;<span id="editData" data-bs-toggle="modal" data-bs-target="#editModal" data-id="<?=$id_modal;?>" data-nama="<?=$nama;?>" data-modal="<?=$modal;?>" data-jual="<?=$jual;?>" data-stok="<?=$stok;?>"><i class="fas fa-edit text-success"></i></span>&nbsp;<span id="hapusData" data-id="<?=$id_modal;?>" data-baris="<?=$no;?>" data-nama="<?=$nama;?>" data-modal="<?=$modal;?>" data-jual="<?=$jual;?>"><i class="fas fa-trash text-danger"></i></span>
          </td>
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
            <div class="row mb-3">
              <div class="col-9 pe-1">
                <label for="nama" class="form-label">Nama / Merek</label>
                <input type="search" id="nama" class="form-control">
                <div class="err"></div>
              </div>
              <div class="col-3 ps-0">
                <label for="stok" class="form-label">Stok</label>
                <input type="search" id="stok" class="form-control px-2">
              </div>
            </div>
            <div class="row mb-3">
              <div class="col-6 pe-1">
                <label for="modal" class="form-label">Harga Modal</label>
                <input type="search" id="modal" class="form-control">
                <div class="err"></div>
              </div>
              <div class="col-6 ps-0">
                <label for="jual" class="form-label d-flex justify-content-between">Harga Jual <span id="ssha2" class="badge bg-light text-primary fw-normal" style="height:19px"></span></label>
                <input type="search" id="jual" class="form-control">
                <div class="err"></div>
              </div>
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