<?php
if(isset($_SESSION['level'])){
  if($_SESSION['level'] != 'level_pemilik'){
    echo '<script>window.history.back()</script>';
    exit;
  }
}
$selDataGrup = mysqli_query($con, "SELECT * FROM tb_grup WHERE id_grup='$idgrup'");
$resDataGrup = mysqli_num_rows($selDataGrup);
$selDataToko = mysqli_query($con, "SELECT * FROM tb_toko WHERE id_grup='$idgrup'");
$resDataToko = mysqli_num_rows($selDataToko);
?>
<div class="container">
  <table class="table border mb-0">
   <thead>
     <tr>
       <th class="text-bg-light"># Data Grup</th>
       <th colspan="2" class="text-bg-light text-center"><i class="fas fa-angle-down"></i></th>
     </tr>
   </thead>
   <tbody>
<?php if($resDataGrup){ $rowDataGrup = mysqli_fetch_array($selDataGrup); ?>
     <tr style="border-bottom:transparent">
       <td><?=$rowDataGrup['nama'];?></td>
       <td style="width:35px" class="text-center" id="editGrup" data-bs-toggle="modal" data-bs-target="#editModalGrup" data-id="<?=$rowDataGrup['id_grup'];?>" data-nama="<?=$rowDataGrup['nama'];?>"><i class="fas fa-edit text-warning"></i></td>
       <td style="width:35px" class="text-center" id="hapusGrup" data-id="<?=$rowDataGrup['id_grup'];?>"><i class="fas fa-trash text-danger"></i></td>
     </tr>
<?php } ?>
   </tbody>
  </table>
  <table class="table border">
    <thead>
      <tr>
        <th colspan="3" class="text-bg-light"># Data Toko</th>
      </tr>
    </thead>
    <tbody>
<?php
if($resDataToko){
  while($rowDataToko = mysqli_fetch_array($selDataToko)){
?>
      <tr>
        <td><?=$rowDataToko['nama'];?></td>
        <td style="width:35px" class="text-center" id="editToko" data-bs-toggle="modal" data-bs-target="#editModalToko" data-id="<?=$rowDataToko['id_toko'];?>" data-nama="<?=$rowDataToko['nama'];?>"><i class="fas fa-edit text-warning"></i></td>
        <td style="width:35px" class="text-center" id="hapusToko" data-id="<?=$rowDataToko['id_toko'];?>"><i class="fas fa-trash text-danger"></i></td>
      </tr>
<?php } } ?>
    </tbody>
  </table>
</div>
<!-- edit modal grup -->
<div class="modal fade" id="editModalGrup" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <form autocomplete="off" id="edit-grup">
            <h5 class="border-bottom pb-2">Edit Grup</h5>
            <div class="mb-3">
              <label for="nama" class="form-label">Nama Grup</label>
              <input type="search" id="nama" class="form-control" placeholder="Masukkan Nama Grup...">
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
  <!-- edit modal toko -->
<div class="modal fade" id="editModalToko" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="editBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-body">
          <form autocomplete="off" id="edit-toko">
            <h5 class="border-bottom pb-2">Edit Toko</h5>
            <div class="mb-3">
              <label for="nama" class="form-label">Nama Toko</label>
              <input type="search" id="nama" class="form-control" placeholder="Masukkan Nama Toko...">
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