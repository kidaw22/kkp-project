<style>
  label.error{
    color: red
  }
</style>
<section class="content">
  <div class="container-fluid">
    <form action="#" method="post" id="frm_pengajuan">
      <div class="form-group">
        <label>Jenis Bantuan</label>
        <input type="hidden" name="id" id="id">
        <select name="jenis_bantuan" id="jenis_bantuan" class="form-control" required>
          <option value="">- choose -</option>
        </select>
      </div>

      <div class="form-group">
        <label> Nama Lengkap </label>
        <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" required>
      </div>

      <div class="form-group">
        <label>Nomor KTP</label>
        <input type="text" name="no_ktp" id="no_ktp" class="form-control numeric" maxlength="16">
      </div>
  
      <div class="form-group">
        <label>Tanggal Lahir</label>
        <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" required>
      </div>

      <div class="form-group">
        <label>Jenis Kelamin</label>
        <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
          <option> --pilih-- </option>
          <option>Laki-Laki</option>
          <option>Perempuan</option>
        </select>
      </div>

      <div class="form-group">
        <label>Alamat KTP</label>
        <textarea name="alamat_ktp" id="alamat_ktp" class="form-control" row="3" required></textarea>
      </div>

      <div class="form-group">
        <label>Alamat Domisili</label>
        <textarea name="alamat_domisili" id="alamat_domisili" class="form-control" row="3" required></textarea>
      </div>

      <div class="form-group">
        <label>Status Tempat Tinggal</label>
        <select name="status_tempat_tinggal" id="status_tempat_tinggal" class="form-control" required>
          <option> --pilih-- </option>
          <option> Milik Sendiri </option>
          <option> Milik Orangtua </option>
          <option> Sewa </option>
        </select>
      </div>

      <div class="form-group">
        <label>Nomor KK</label>
        <input type="text" name="no_kk" id="no_kk" class="form-control numeric" maxlength="16" required>
      </div>

      <div class="form-group">
        <label>Jumlah Tanggungan</label>
        <input type="text" name="jumlah_tanggungan" id="jumlah_tanggungan" class="form-control numeric" required>
      </div>

      <div class="form-group">
        <label>Jumlah Kendaraan</label>
        <input type="text" name="jumlah_kendaraan" id="jumlah_kendaraan" class="form-control numeric" required>
      </div>
      
      <div class="form-group row">
        <div class="col-lg-12">
          <button type="submit" class="btn btn-primary float-right" id="btn_save">Ajukan</button>
        </div>
      </div>
    </form>
  </div>
</section>

<script>
  $(document).ready(function(){
    $(".numeric").on("input", function() {
        this.value = this.value.replace(/[^0-9\.]/g, "");
    });

    loadCombo({
      url: "<?= site_url() ?>" + "transaksi/pengajuan/getCombo",
      object: {
        type: 'bantuan'
      },
      element: '#jenis_bantuan'
    });

    $('#btn_save').on('click', function(e){
      $('#frm_pengajuan').validate({
        submitHandler: function(){
          e.preventDefault()

          $.ajax({
            url: "<?= site_url() ?>" + "/transaksi/pengajuan/savePengajuan",
            type: 'POST',
            dataType: 'JSON',
            data: $('#frm_pengajuan').serialize(),
            success: function(data){
              if(data.status === 'success'){
                Swal.fire({
                  icon: 'success',
                  title: data.message
                }).then(() => {
                  window.location.reload()
                });
              }else{
                Swal.fire({
                  icon: 'warning',
                  title: data.message
                })
              }
            }, error: function(jqXHR, textStatus, errorThrown){
              Swal.fire({
                title: "Terjadi kesalahan!"
              });
              console.error(`Couldn't get the post: ${textStatus}, error message: ${errorThrown}`)
            }
          });
        }
      });
    });
  })
</script>