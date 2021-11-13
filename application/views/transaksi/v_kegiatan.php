<link rel="stylesheet" href="<?= site_url() ?>assets/fullcalendar/lib/main.min.css">
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div id="fullcalendar"></div>
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
                        <input type="text" name="No_NPWP" id="No_NPWP" class="form-control" required>
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

<script src="<?= site_url() ?>assets/fullcalendar/lib/main.min.js"></script>t

<script>
    const getData = () => {
        $.ajax({
            url: "<?= site_url() ?>transaksi/kegiatan/getKegiatan",
            type: 'POST',
            dataType: 'JSON',
            success: function(data) {
                if (data.length > 0) {
                    let html = '';

                    for (let i = 0; i < data.length; i++) {
                        html += '<tr>' +
                            `<td>${data[i].nik}</td>` +
                            `<td><a class="item-edit" href="javascript:void(0)" data-id="${data[i].id}" >${data[i].name}</a></td>` +
                            `<td><button class="btn btn-danger btn-sm item-delete" data-id="${data[i].id}">X</button></td>` +
                            `</tr>`;
                    }

                    $('#table_data tbody').html(html);
                }
            }
        })

    }
    
    const getDetail = id => {
        $.ajax({
            url: "<?= site_url() ?>transaksi/kegiatan/getKegiatanDetail/"+id,
            type: 'POST',
            dataType: 'JSON',
            success: function(data){
                console.log(data);
                $('#id').val(data.id);
                $('#nik').val(data.NIK);
                $('#nama').val(data.Nama);
                $('#Alamat_KTP').val(data.Alamat_KTP);
                $('#No_Telp').val(data.No_Telp);
                $('#No_BPJS').val(data.No_BPJS);
                $('#No_NPWP').val(data.No_NPWP);
                $('#Tanggal_Lahir').val(data.Tanggal_Lahir);
                $('#Alamat_Domisili').val(data.Alamat_Domisili);
                $('#No_KK').val(data.No_KK);
            }
        });
    }

    const deleteData = id => {
        $.ajax({
            url: "<?= site_url() ?>transaksi/kegiatan/deleteKegiatan/"+id,
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

        const calendarEl = document.querySelector('#fullcalendar');
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth'
        });
        calendar.render();

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
                        url: "<?= site_url() ?>transaksi/kegiatan/saveKegiatan",
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