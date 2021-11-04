<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modalEdit"> Tambah </button>
            </div>
        </div>

        <div class="row mt-2">
            <table class="table table-bordered" id="table_data">
                <thead class="text-center">
                    <th>NIK</th>
                    <th>Nama Warga</th>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</section>

<div class="modal fade" id="modalEdit" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title"> Form Warga </h3>
                <button class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
            </div>
            <form class="form-horizontal" id="frm_header">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-form-label"> NIK </label>
                        <input type="hidden" name="id" id="id">
                        <input type="text" name="nik" id="nik" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label class="col-form-label"> Nama </label>
                        <input type="text" name="nama" id="nama" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label class="col-form-label"> Alamat KTP </label>
                        <input type="text" name="Alamat_KTP" id="Alamat_KTP" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label class="col-form-label"> No.Telp </label>
                        <input type="number" name="No_Telp" id="No_Telp" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label class="col-form-label"> No. BPJS </label>
                        <input type="number" name="No_BPJS" id="No_BPJS" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label class="col-form-label"> No. NPWP </label>
                        <input type="number" name="No_NPWP" id="No_NPWP" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label class="col-form-label"> Tanggal Lahir </label>
                        <input type="date" name="Tanggal_Lahir" id="Tanggal_Lahir" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label class="col-form-label"> Alamat Domisili </label>
                        <input type="text" name="Alamat_Domisili" id="Alamat_Domisili" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label class="col-form-label"> No. KK </label>
                        <input type="text" name="No_KK" id="No_KK" class="form-control" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-primary" data-dismiss="modal" aria-hidden="true">Batal</button>
                    <button class="btn btn-primary" id="btn_modal_save" type="submit">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const getData = () => {
        $.ajax({
            url: "<?= site_url() ?>master_data/warga/getWarga",
            type: 'POST',
            dataType: 'JSON',
            success: function(data){
                if(data.length > 0){
                    let html = '';

                    for(let i = 0; i < data.length; i++){
                        html += '<tr>'+
                                    `<td>${data[i].nik}</td>`+
                                    `<td><a href="javascript:void(0)" data-id="${data[i].id}">${data[i].name}</a></td>`+
                                    `</tr>`;
                    }

                    $('#table_data tbody').html(html);
                }
            }
        })
    }

    $(document).ready(function(){
        getData();

        $('#btn_modal_save').on('click', function(e){
            $('#frm_header').validate({
                submitHandler: function(){
                    e.preventDefault();

                    $.ajax({
                        url: "<?= site_url() ?>master_data/warga/saveWarga",
                        type: 'POST',
                        dataType: 'JSON',
                        data: $('#frm_header').serialize(),
                        success: function(data){
                            if(data.status === 'success'){
                                Swal.fire({
                                    icon: 'success',
                                    title: data.message
                                }).then(() => {
                                    $('#modalEdit').modal('hide');
                                    getData();
                                });
                            }else{
                                Swal.fire({
                                    icon: 'warning',
                                    title: data.message
                                });
                            }
                        }
                    });
                }
            })
        });
    });
</script>