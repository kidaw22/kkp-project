<section class="content">
    <div class="container-fluid">
        <form id="frm_header">
            <div class="form-group row">
                <label class="col-form-label col-lg-1"> Kategori </label>
                <div class="col-lg-8">
                    <select name="category" id="category" class="form-control">
                        <option value="">- choose -</option>
                        <option value="pengajuan"> Pengajuan </option>
                        <option value="terpilih"> Terpilih </option>
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-1 col-form-label"> Periode </label>
                <div class="col-lg-3">
                    <input type="date" class="form-control" name="period_start" value="<?= date('Y-m-01') ?>">
                </div>

                <label class="col-lg-1 col-form-label"> Sampai </label>
                <div class="col-lg-3">
                    <input type="date" class="form-control" name="period_end" value="<?= date('Y-m-d') ?>">
                </div>
            </div>

            <div class="form-group row">
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
                    <th> Jenis Bantuan </th>
                    <th> Status </th>
                    <th class="label-date"></th>
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
                const labelText = ($('#category').val() === 'pengajuan') ? 'Tanggal Diproses' : 'Tanggal Dipilih'
                $('.label-date').text(labelText)
                $.ajax({
                    url: "<?= site_url() ?>" + "/laporan/laporan_bantuan/getData",
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
                                console.log(data[i])
                                html += `<tr>`+
                                            `<td>${data[i].nama}</td>`+
                                            `<td>${data[i].nik}</td>`+
                                            `<td>${data[i].kk}</td>`+
                                            `<td>${data[i].bantuan}</td>`+
                                            `<td>${data[i].status}</td>`+
                                            `<td>${data[i].date}</td>`+
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