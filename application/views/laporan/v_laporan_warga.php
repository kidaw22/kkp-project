<section class="content">
    <div class="container-fluid">
        <form id="frm_header">
            <div class="form-group row">
                <label class="col-lg-1 col-form-label"> Periode </label>
                <div class="col-lg-3">
                    <input type="date" class="form-control" name="period_start" value="<?= date('Y-m-01') ?>">
                </div>

                <label class="col-lg-1 col-form-label"> Sampai </label>
                <div class="col-lg-3">
                    <input type="date" class="form-control" name="period_end" value="<?= date('Y-m-d') ?>">
                </div>

                <div class="col-lg-4">
                    <button type="submit" class="btn btn-primary" id="btn_save"> Jalankan! </button>
                </div>
            </div>
        </form>
        <div class="table-responsive">
            <table class="table table-striped" id="table_data" style="display: none">
                <thead class="bg-blue">
                    <th> Nama </th>
                    <th> NIK </th>
                    <th> Nomor KK </th>
                    <th> Tanggal Lahir </th>
                    <th> Jenis Kelamin </th>
                    <th> Nomor Telepon </th>
                    <th> Alamat KTP </th>
                    <th> Alamat Domisili </th>
                    <th> Jenis Pekerjaan </th>
                    <th> Jumlah Tanggungan </th>
                    <th> Tanggal Dibuat </th>
                    <th> Tipe User </th>
                </thead>

                <tbody id="show_data">

                </tbody>
            </table>
        </div>
    </div>
</section>

<script>
    $(document).ready(function(){
        $('#frm_header').validate({
            submitHandler: function(e){
                $.ajax({
                    url: "<?= site_url() ?>" + "/laporan/laporan_warga/getWarga",
                    type: 'POST',
                    data: $('#frm_header').serialize(),
                    dataType: 'JSON',
                    success: function(data){
                        let html

                        $('#table_data').show();

                        let isDataTable = $.fn.DataTable.isDataTable('#table_data');
                        if(isDataTable){
                            $('#table_data').DataTable().clear().destroy();
                        }

                        if(data.length > 0){
                            for(let i = 0; i < data.length; i++){
                                html += `<tr>`+
                                        `<td>${data[i].Nama}</td>`+
                                        `<td>${data[i].NIK}</td>`+
                                        `<td>${data[i].No_KK}</td>`+
                                        `<td>${data[i].Tanggal_Lahir}</td>`+
                                        `<td>${data[i].Jenis_Kelamin}</td>`+
                                        `<td>${data[i].No_Telp}</td>`+
                                        `<td>${data[i].Alamat_KTP}</td>`+
                                        `<td>${data[i].Alamat_Domisili}</td>`+
                                        `<td>${data[i].Jenis_Pekerjaan}</td>`+
                                        `<td>${data[i].Jumlah_Tanggungan}</td>`+
                                        `<td>${data[i].tanggal_dibuat}</td>`+
                                        `<td>${data[i].usertype}</td>`+
                                        `</tr>`;
                            }
                        } else {
                            html += `<tr><td colspan="12" class="text-center">Belum ada data.</td></tr>`;
                        }

                        $('#show_data').html(html)
                        if(data.length){
                            $('#table_data').dataTable()
                        }
                    }
                })
            }
        })
    })
</script>