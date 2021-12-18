<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <button type="button" class="btn btn-primary float-right" id="btn_add" data-toggle="modal" data-target="#modalEdit"> Tambah </button>
            </div>
        </div>

        <div class="row mt-2">
        <div class="table-responsive">
            <table class="table table-bordered" id="table_data">
                <thead class="text-center">
                    <th>Nama Bantuan</th>
                    <th>Periode Dari</th>
                    <th>Periode Sampai</th>
                    <th></th>
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
                <h3 class="modal-title"> Form Bantuan </h3>
                <button class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
            </div>
            <form class="form-horizontal" id="frm_header">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-form-label"> Nama Bantuan </label>
                        <input type="hidden" name="id" id="id">
                        <input type="text" name="Nama_Bantuan" id="Nama_Bantuan" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label class="col-form-label"> Periode Dari </label>
                        <div class="input-group date" id="reservationdate" data-target-input="nearest">
                            <input type="text" name="Periode_Dari" id="Periode_Dari" class="form-control datetimepicker-input" data-target="#reservationdate" required>
                            <div class="input-group-append" data-target="#reservationdate" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-form-label"> Periode Sampai </label>
                        <div class="input-group date" id="reservationdateuntil" data-target-input="nearest">
                            <input type="text" name="Periode_Sampai" id="Periode_Sampai" class="form-control" data-target="#reservationdateuntil" required>
                            <div class="input-group-append" data-target="#reservationdateuntil" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
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
            url: "<?= site_url() ?>master_data/bantuan/getBantuan",
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
                            `<td><a class="item-edit" href="javascript:void(0)" data-id="${data[i].id}"> ${data[i].Nama_Bantuan}</a></td>` +
                            `<td> ${data[i].Periode_Dari} </td>` +
                            `<td> ${data[i].Periode_Sampai} </td>` +
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
            url: "<?= site_url() ?>master_data/bantuan/getBantuanDetail/"+id,
            type: 'POST',
            dataType: 'JSON',
            success: function(data){
                console.log(data);
                $('#id').val(data.id);
                $('#Nama_Bantuan').val(data.Nama_Bantuan);
                $('#Periode_Dari').val(data.Periode_Dari);
                $('#Periode_Sampai').val(data.Periode_Sampai);
            }
        });
    }

    const deleteData = id => {
        $.ajax({
            url: "<?= site_url() ?>master_data/bantuan/deleteBantuan/"+id,
            type: 'POST',
            dataType: 'JSON',
            success: function(data){
                if(data.status === 'success'){
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

        $('#reservationdate').datetimepicker({
            format: 'YYYY-MM-DD'
        });

        $('#reservationdateuntil').datetimepicker({
            format: 'YYYY-MM-DD'
        });

        $('#btn_add').on('click', function(){
            $('#frm_header')[0].reset();
            $('#id').val('');
        })

        $('#table_data tbody').on('click', '.item-edit', function(){
            const itemId = $(this).data('id');
            
            $('#modalEdit').modal('show');

            getDetail(itemId);
        });

        $('#table_data tbody').on('click', '.item-delete', function(){
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

        $('#btn_modal_save').on('click', function(e) {
            $('#frm_header').validate({
                submitHandler: function() {
                    e.preventDefault();

                    $.ajax({
                        url: "<?= site_url() ?>master_data/bantuan/saveBantuan",
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