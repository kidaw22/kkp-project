<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <button type="button" class="btn btn-primary float-right" id="btn_add" data-toggle="modal" data-target="#modalEdit"> Tambah </button>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-lg-12">
                <div class="table-responsive">
                    <table class="table table-bordered" id="table_data">
                        <thead class="text-center"> 
                            <th>NIK</th>
                            <th>Nama Warga</th>
                            <th></th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
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
                        <input type="text" name="nik" id="nik" class="form-control" minlength="16" maxlength="16" required>
                    </div>

                    <div class="form-group">
                        <label class="col-form-label"> Nama Lengkap </label>
                        <input type="text" name="nama" id="nama" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label class="col-form-label"> Tanggal Lahir </label>
                        <input type="date" name="Tanggal_Lahir" id="Tanggal_Lahir" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label class="col-form-label"> Jenis Kelamin </label>
                        <select type="text" name="Jenis_Kelamin" id="Jenis_Kelamin" class="form-control" required>
                        <option> Pilih </option>
                        <option>Laki-Laki</option>
                        <option>Perempuan</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="col-form-label"> Alamat KTP </label>
                        <input type="text" name="Alamat_KTP" id="Alamat_KTP" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label class="col-form-label"> Alamat Domisili </label>
                        <input type="text" name="Alamat_Domisili" id="Alamat_Domisili" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label class="col-form-label"> Jenis Pekerjaan </label>
                        <input type="text" name="Jenis_Pekerjaan" id="Jenis_Pekerjaan" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label class="col-form-label"> Nomor Telepon </label>
                        <input type="number" name="No_Telp" id="No_Telp" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label class="col-form-label"> Nomor KK </label>
                        <input type="number" name="No_KK" id="No_KK" class="form-control" minlength="16" maxlength="16" required>
                    </div>
                   
                    <div class="form-group">
                        <label class="col-form-label"> Jumlah Tanggungan </label>
                        <input type="number" name="Jumlah_Tanggungan" id="Jumlah_Tanggungan" class="form-control" required>
                    </div>                    
                   
                    <div class="form-group clearfix">
                        <div class="icheck-primary d-inline">
                            <input type="checkbox" id="checkBoxAdmin">
                            <input type="hidden" name="checkBoxAdmin" id="checkBoxAdminHidden">
                            <label for="checkBoxAdmin">
                                Admin
                            </label>
                        </div>
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
            success: function(data) {
                if (data.length > 0) {
                    let html = '';

                    let isDataTable = $.fn.DataTable.isDataTable('#table_data');
                    if(isDataTable){
                        $('#table_data').DataTable().clear().destroy();
                    }

                    for (let i = 0; i < data.length; i++) {
                        html += '<tr>' +
                            `<td>${data[i].nik}</td>` +
                            `<td><a class="item-edit" href="javascript:void(0)" data-id="${data[i].id}" >${data[i].name}</a></td>` +
                            `<td><button class="btn btn-danger btn-sm item-delete" data-id="${data[i].id}">X</button></td>` +
                            `</tr>`;
                    }

                    $('#table_data tbody').html(html);
                    $('#table_data').dataTable()
                }
            }
        })

    }

    const getDetail = id => {
        $.ajax({
            url: "<?= site_url() ?>master_data/warga/getWargaDetail/" + id,
            type: 'POST',
            dataType: 'JSON',
            success: function(data) {
                console.log(data);
                $('#id').val(data.id);
                $('#nik').val(data.NIK);
                $('#nama').val(data.Nama);
                $('#Tanggal_Lahir').val(data.Tanggal_Lahir);
                $('#Jenis_Kelamin').val(data.Jenis_Kelamin);
                $('#Alamat_KTP').val(data.Alamat_KTP);
                $('#Alamat_Domisili').val(data.Alamat_Domisili);
                $('#Jenis_Pekerjaan').val(data.Jenis_Pekerjaan);
                $('#No_Telp').val(data.No_Telp);
                $('#No_KK').val(data.No_KK);
                $('#Jumlah_Tanggungan').val(data.Jumlah_Tanggungan);                
                $('#checkBoxAdminHidden').val(data.usertype);
                if (parseInt(data.usertype) === 1) {
                    $('#checkBoxAdmin').prop('checked', true);
                } else {
                    $('#checkBoxAdmin').prop('checked', false);
                }
            }
        });
    }

    const deleteData = id => {
        $.ajax({
            url: "<?= site_url() ?>master_data/warga/deleteWarga/" + id,
            type: 'POST',
            dataType: 'JSON',
            success: function(data) {
                if (data.status === 'success') {
                    Swal.fire({
                        title: data.message,
                        icon: 'success'
                    }).then(() => {
                        getData();
                    })
                }
            }
        })
    }

    $(document).ready(function() {
        getData();

        $('#btn_add').on('click', function() {
            $('#frm_header')[0].reset();
            $('#id').val('');
        })

        $('#table_data tbody').on('click', '.item-edit', function() {
            const itemId = $(this).data('id');

            $('#modalEdit').modal('show');

            getDetail(itemId);
        });

        $('#table_data tbody').on('click', '.item-delete', function() {
            const itemId = $(this).data('id');

            Swal.fire({
                title: 'Apakah anda yakin?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'OK',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteData(itemId);
                }
            })
        });

        $('#checkBoxAdmin').on('change', function() {
            if ($('#checkBoxAdmin:checked').length > 0) {
                $('#checkBoxAdminHidden').val(1);
            } else {
                $('#checkBoxAdminHidden').val(0);
            }
        })

        $('#btn_modal_save').on('click', function(e) {
            $('#frm_header').validate({
                submitHandler: function() {
                    e.preventDefault();

                    $.ajax({
                        url: "<?= site_url() ?>master_data/warga/saveWarga",
                        type: 'POST',
                        dataType: 'JSON',
                        data: $('#frm_header').serialize(),
                        success: function(data) {
                            if (data.status === 'success') {
                                Swal.fire({
                                    icon: 'success',
                                    title: data.message
                                }).then(() => {
                                    $('#modalEdit').modal('hide');
                                    getData();
                                });
                            } else {
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