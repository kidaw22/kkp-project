<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <form class="form-horizontal" id="frm_inbox">
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3"> Jenis Bantuan </label>
                        <div class="col-lg-9">
                            <input type="hidden" name="id" id="id" class="form-control" readonly>
                            <input type="hidden" name="warga_id" id="warga_id">
                            <input type="hidden" name="pengajuan_id" id="pengajuan_id">
                            <input type="text" name="jenis_bantuan" id="jenis_bantuan" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3"> Nomor KTP </label>
                        <div class="col-lg-9">
                            <input type="text" name="no_ktp" id="no_ktp" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3"> Nama Lengkap </label>
                        <div class="col-lg-9">
                            <input type="text" name="nama_lengkap" id="nama_lengkap" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3"> Tanggal Lahir </label>
                        <div class="col-lg-9">
                            <input type="text" name="tanggal_lahir" id="tanggal_lahir" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3"> Jenis Kelamin </label>
                        <div class="col-lg-9">
                            <input type="text" name="jenis_kelamin" id="jenis_kelamin" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3"> Alamat KTP </label>
                        <div class="col-lg-9">
                            <textarea name="alamat_ktp" id="alamat_ktp" rows="3" class="form-control" readonly></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3"> Nomor KK </label>
                        <div class="col-lg-9">
                            <input type="text" name="no_kk" id="no_kk" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3"> Status Tempat Tinggal </label>
                        <div class="col-lg-9">
                            <input type="text" name="status_tempat_tinggal" id="status_tempat_tinggal" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3"> Alamat Domisili </label>
                        <div class="col-lg-9">
                            <textarea name="alamat_domisili" id="alamat_domisili" rows="3" class="form-control" readonly></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3"> Jumlah Tanggungan </label>
                        <div class="col-lg-9">
                            <input type="text" name="jumlah_tanggungan" id="jumlah_tanggungan" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3"> Jumlah Kendaraan </label>
                        <div class="col-lg-9">
                            <input type="text" name="jumlah_kendaraan" id="jumlah_kendaraan" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3"> Status </label>
                        <div class="col-lg-9">
                            <input type="text" name="status" id="status" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-3"> Catatan </label>
                        <div class="col-lg-9">
                            <textarea name="notes" id="notes" cols="30" rows="3" class="form-control" required></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-lg-12">
                            <div class="d-none" id="new_section">
                                <button class="btn btn-primary float-right m-1 btn-lg" type="submit" id="btn_approve"> Setujui </button>
                                <button class="btn btn-outline-danger float-right m-1 btn-lg" type="submit" id="btn_reject"> Tolak </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
    const inboxId = "<?= $inbox_id ?>"
    const getData = () => {
        $.ajax({
            url: "<?= site_url() ?>" + "transaksi/pengajuan_inbox/getInbox/"+inboxId,
            type: 'POST',
            dataType: 'JSON',
            success: function(data){
                $('#id').val(data.id)
                $('#warga_id').val(data.warga_id)
                $('#pengajuan_id').val(data.pengajuan_id)
                $('#jenis_bantuan').val(data.bantuan)
                $('#nama_lengkap').val(data.nama_lengkap)
                $('#no_ktp').val(data.no_ktp)
                $('#tanggal_lahir').val(data.tanggal_lahir)
                $('#jenis_kelamin').val(data.jenis_kelamin)
                $('#alamat_ktp').val(data.alamat_ktp)
                $('#alamat_domisili').val(data.alamat_domisili)
                $('#status_tempat_tinggal').val(data.status_tempat_tinggal)
                $('#no_kk').val(data.no_kk)
                $('#jumlah_tanggungan').val(data.jumlah_tanggungan)
                $('#jumlah_kendaraan').val(data.jumlah_kendaraan)
                $('#status').val(data.status)
                $('#notes').val(data.catatan).prop('readonly', (data.status === 'Baru') ? false : true)
                if(data.status === 'Baru'){
                    $('#new_section').removeClass('d-none');
                }
            }
        })
    }

    $(document).ready(function(){
        getData()

        $('#btn_approve').on('click', function(e){
            $('#frm_inbox').validate({
                submitHandler: function(){
                    e.preventDefault();

                    $.ajax({
                        url: "<?= site_url() ?>transaksi/pengajuan_inbox/approved",
                        type: 'POST',
                        dataType: 'JSON',
                        data: $('#frm_inbox').serialize(),
                        success: function(data){
                            if(data.status === 'success'){
                                Swal.fire({
                                    icon: 'success',
                                    title: data.message
                                }).then(() => {
                                    window.location.replace("<?= site_url() ?>/transaksi/pengajuan_inbox");
                                });
                            }else{
                                Swal.fire({
                                    icon: 'success',
                                    title: data.message
                                });
                            }
                        }, error: function(jqXHR, textStatus, errorThrown){
                            Swal.fire({
                                title: "Terjadi kesalahan!"
                            });
                            console.error(`Couldn't get the post: ${textStatus}, error message: ${errorThrown}`)
                        }
                    });
                }
            })
        })

        $('#btn_reject').on('click', function(e){
            $('#frm_inbox').validate({
                submitHandler: function(){
                    e.preventDefault();

                    $.ajax({
                        url: "<?= site_url() ?>transaksi/pengajuan_inbox/reject",
                        type: 'POST',
                        dataType: 'JSON',
                        data: $('#frm_inbox').serialize(),
                        success: function(data){
                            if(data.status === 'success'){
                                Swal.fire({
                                    icon: 'success',
                                    title: data.message
                                }).then(() => {
                                    window.location.replace("<?= site_url() ?>/transaksi/pengajuan_inbox");
                                });
                            }else{
                                Swal.fire({
                                    icon: 'success',
                                    title: data.message
                                });
                            }
                        }, error: function(jqXHR, textStatus, errorThrown){
                            Swal.fire({
                                title: "Terjadi kesalahan!"
                            });
                            console.error(`Couldn't get the post: ${textStatus}, error message: ${errorThrown}`)
                        }
                    });
                }
            })
        })
    });
</script>