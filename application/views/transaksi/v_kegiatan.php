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
                <h3 class="modal-title"> Kegiatan Bantuan </h3>
                <button class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
            </div>
            <form class="form-horizontal" id="frm_header">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-form-label"> Judul Kegiatan </label>
                        <input type="hidden" name="id" id="id">
                        <input type="text" name="Judul_Kegiatan" id="Judul_Kegiatan" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label class="col-form-label"> Deskripsi Kegiatan </label>
                        <input type="text" name="Deskripsi_Kegiatan" id="Deskripsi_Kegiatan" class="form-control" required>
                    </div>

                    <div class="form-group d-none">
                        <label class="col-form-label"> Tanggal Mulai </label>
                        <div class="input-group date" id="startdate" data-target-input="nearest">
                            <input type="text" name="Tanggal_Mulai" id="Tanggal_Mulai" class="form-control datetimepicker-input" data-target="#startdate" required>
                            <div class="input-group-append" data-target="#startdate" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group d-none">
                        <label class="col-form-label"> Tanggal Akhir </label>
                        <div class="input-group date" id="enddate" data-target-input="nearest">
                            <input type="text" name="Tanggal_Akhir" id="Tanggal_Akhir" class="form-control" data-target="#enddate" required>
                            <div class="input-group-append" data-target="#enddate" data-toggle="datetimepicker">
                                <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-form-label"> Peserta </label>
                        <select name="Peserta" id="Peserta" class="form-control" required multiple>

                        </select>
                    </div>

                    <div class="form-group">
                        <div class="col-lg-12">
                            <a href="javascript:void(0)" class="float-right" id="select_toggle"> Pilih Semua </a>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-form-label"> Lokasi </label>
                        <input type="text" name="Lokasi" id="Lokasi" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label class="col-form-label"> Deskripsi Lokasi </label>
                        <input type="text" name="Deskripsi_Lokasi" id="Deskripsi_Lokasi" class="form-control" required>
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
        return $.ajax({
            url: "<?= site_url() ?>transaksi/kegiatan/getKegiatan",
            type: 'POST',
            dataType: 'JSON'
        }).then(data => data);
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

    $(document).ready(async function() {
        getData();

        const calendarEl = document.querySelector('#fullcalendar');
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            themeSystem: 'bootstrap',
            events: await getData(),
            dateClick: function(info){
                console.log(info);
                $('#modalEdit').modal('show');
                $('#Tanggal_Mulai').val(info.dateStr);
                $('#Tanggal_Akhir').val(info.dateStr);
            },
            eventClick: function(info){
                
            }
        });
        calendar.render();

        $.ajax({
            url: "<?= site_url() ?>" + "/transaksi/kegiatan/getCombo",
            type: 'POST',
            dataType: 'JSON',
            data: {
                type: 'warga'
            },
            success: function(data){
                $.each(data, function(key, val){
                    $('#Peserta').append(`<option value="${val.combo_key}">${val.combo_name}</option>`);
                });
            }
        });

        let isSelected = false;
        $('#select_toggle').on('click', function(){
            isSelected = !isSelected;

            $('#Peserta option').prop('selected', isSelected);
        });

        $('#startdate').datetimepicker({
            format: 'YYYY-MM-DD'
        });

        $('#enddate').datetimepicker({
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