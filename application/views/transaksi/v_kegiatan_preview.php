<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <form class="form-horizontal" id="frm_inbox">
                    <div class="form-group row">
                        <label class="col-form-label col-lg-4"> Jenis Bantuan </label>
                        <div class="col-lg-8">
                            <input type="text" name="jenis_bantuan" id="jenis_bantuan" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-4"> Deskripsi Bantuan </label>
                        <div class="col-lg-8">
                            <input type="text" name="deskripsi_bantuan" id="deskripsi_bantuan" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-4"> Tanggal Pengambilan </label>
                        <div class="col-lg-8">
                            <input type="text" name="tanggal_pengambilan" id="tanggal_pengambilan" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-4"> Jam Pengambilan </label>
                        <div class="col-lg-8">
                            <input type="text" name="jam_pengambilan" id="jam_pengambilan" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-4"> Lokasi Pengambilan </label>
                        <div class="col-lg-8">
                            <input type="text" name="lokasi" id="lokasi" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-form-label col-lg-4"> Deskripsi Lokasi </label>
                        <div class="col-lg-8">
                            <input type="text" name="deskripsi_lokasi" id="deskripsi_lokasi" class="form-control" readonly>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<script>
    const getDetail = (eventId) => {
        $.ajax({
            url: "<?= site_url() ?>" + "transaksi/kegiatan/getPreviewData/"+eventId,
            type: 'POST',
            dataType: 'JSON',
            success: function(data){
                $('#jenis_bantuan').val(data.jenis_bantuan)
                $('#deskripsi_bantuan').val(data.Deskripsi_Kegiatan)
                $('#tanggal_pengambilan').val(data.tanggal_pengambilan)
                $('#jam_pengambilan').val(data.jam_pengambilan)
                $('#lokasi').val(data.Lokasi)
                $('#deskripsi_lokasi').val(data.Deskripsi_Lokasi)
            }
        })
    }

    $(document).ready(function(){
        const eventId = "<?= $event_id ?>"
        getDetail(eventId)
    })
</script>