<section class="content">
    <div class="container-fluid">
        <div class="table-responsive">
            <table class="table table-striped" id="table_data">
                <thead>
                    <tr>
                        <th> Nama Lengkap </th>
                        <th> Nomor KTP </th>
                        <th> Jenis Bantuan </th>
                        <th> Jumlah Tanggungan </th>
                        <th> Jumlah Kendaraan </th>
                        <th> Status </th>
                        <th> Disetujui Oleh </th>
                    </tr>
                </thead>

                <tbody id="show_data">

                </tbody>
            </table>
        </div>
    </div>
</section>

<script>
    const getData = () => {
        $.ajax({
            url: "<?= site_url() ?>" + "/transaksi/pengajuan_inbox/getInbox",
            type: 'POST',
            dataType: 'JSON',
            success: function(data) {
                let html = ''

                let isDataTable = $.fn.DataTable.isDataTable('#table_data');
                if(isDataTable){
                    $('#table_data').DataTable().clear().destroy();
                }

                if (data.length) {
                    for (let i = 0; i < data.length; i++) {
                        html += `<tr>` +
                            `<td><a href="${"<?= site_url() ?>transaksi/pengajuan_inbox/form/"+data[i].id}">${data[i].nama_lengkap}</a></td>` +
                            `<td>${data[i].no_ktp}</td>` +
                            `<td>${data[i].bantuan}</td>` +
                            `<td>${data[i].jumlah_tanggungan}</td>` +
                            `<td>${data[i].jumlah_kendaraan}</td>` +
                            `<td>${data[i].status}</td>` +
                            `<td>${data[i].approved_by}</td>` +
                            `</tr>`;
                    }
                } else {
                    html += `<tr><td colspan="7" class="text-center">Belum ada data.</td></tr>`;
                }

                $('#show_data').html(html)
                $('#table_data').dataTable()
            }
        })
    }

    $(document).ready(function() {
        getData()
    });
</script>