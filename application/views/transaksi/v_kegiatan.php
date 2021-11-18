<link rel="stylesheet" href="<?= site_url() ?>assets/fullcalendar/lib/main.min.css">
<link rel="stylesheet" href="<?= site_url() ?>assets/icheck-bootstrap/icheck-bootstrap.min.css">
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
                        <select type="text" name="Judul_Kegiatan" id="Judul_Kegiatan" class="form-control" required>

                        </select>
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
                        <select name="Peserta[]" id="Peserta" class="form-control" required multiple>

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

                    <div class="form-group clearfix" id="checkBoxDeleteSection" style="display: none">
                        <div class="icheck-primary d-inline">
                            <input type="checkbox" id="checkBoxDelete">
                            <label for="checkBoxDelete">
                                Hapus
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
            url: "<?= site_url() ?>transaksi/kegiatan/getKegiatanDetail/" + id,
            type: 'POST',
            dataType: 'JSON',
            success: function(data) {
                // console.log(data);
                $('#id').val(data.id);
                $('#Judul_Kegiatan').val(data.Judul_Kegiatan);
                $('#Deskripsi_Kegiatan').val(data.Deskripsi_Kegiatan);
                $('#Lokasi').val(data.Lokasi);
                $('#Deskripsi_Lokasi').val(data.Deskripsi_Lokasi);
                $('#Tanggal_Mulai').val(data.Tanggal_Mulai);
                $('#Tanggal_Akhir').val(data.Tanggal_Akhir);

                if (data.detail.length > 0) {
                    $.each(data.detail, function(key, val) {
                        $('#Peserta').find(`option[value="${val.Warga_id}"]`).prop('selected', true)
                    });
                }


            }
        });
    }

    const deleteData = (id, calendar) => {
        $.ajax({
            url: "<?= site_url() ?>transaksi/kegiatan/deleteKegiatan/" + id,
            type: 'POST',
            dataType: 'JSON',
            success: function(data) {
                if (data.status === 'success') {
                    Swal.fire({
                        title: data.message,
                        icon: 'success'
                    }).then(async () => {
                        const events = await getData();
                        const currentEvents = calendar.getEventSources();

                        currentEvents.forEach(event => {
                            event.remove();
                        });

                        calendar.addEventSource(events);
                        calendar.refetchEvents();

                        $('#modalEdit').modal('hide');
                    })
                }
            }
        })
    }

    const showModal = (id = '', date) => {
        $('#checkBoxDeleteSection').hide();
        $('#frm_header')[0].reset();
        $('#id').val('');

        $('#modalEdit').modal('show');

        $('#Tanggal_Mulai').val(date);
        $('#Tanggal_Akhir').val(date);

        if (id !== '') {
            $('#checkBoxDeleteSection').show();
            getDetail(id);
        }
    }

    $(document).ready(async function() {
        const calendarEl = document.querySelector('#fullcalendar');
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            themeSystem: 'bootstrap',
            events: await getData(),
            color: '#0984e3',
            selectable: true,
            selectHelper: true,
            allDayDefault: true,
            dateClick: function(info) {
                showModal('', info.dateStr);
            },
            eventClick: function(info) {
                showModal(info.event.id, info.event.start);
            }
        });
        calendar.render();

        loadCombo({
            url: "<?= site_url() ?>" + "/transaksi/kegiatan/getCombo",
            object: {
                type: 'warga'
            },
            element: '#Peserta',
            isReset: false
        });

        loadCombo({
            url: "<?= site_url() ?>" + "/transaksi/kegiatan/getCombo",
            object: {
                type: 'bantuan'
            },
            element: '#Judul_Kegiatan'
        });

        let isSelected = false;
        $('#select_toggle').on('click', function() {
            isSelected = !isSelected;

            $('#Peserta option').prop('selected', isSelected);
        });

        $('#startdate').datetimepicker({
            format: 'YYYY-MM-DD'
        });

        $('#enddate').datetimepicker({
            format: 'YYYY-MM-DD'
        });

        $('#checkBoxDelete').on('change', function() {
            if ($('#checkBoxDelete:checked').length > 0) {
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
                        deleteData($('#id').val(), calendar);
                    } else {
                        $('#checkBoxDelete').prop('checked', false);
                    }
                })
            } else {

            }
        })

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
                                }).then(async () => {
                                    const events = await getData();
                                    const currentEvents = calendar.getEventSources();

                                    currentEvents.forEach(event => {
                                        event.remove();
                                    });

                                    calendar.addEventSource(events);
                                    calendar.refetchEvents();

                                    $('#modalEdit').modal('hide');
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