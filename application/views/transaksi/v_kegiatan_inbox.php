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
                if (data.length) {
                    for (let i = 0; i < data.length; i++) {
                        html += `<tr>` +
                            `<td><a href="javascript:void(0)" data-id="${data[i].id}">${data[i].nama_lengkap}</a></td>` +
                            `<td>${data[i].no_ktp}</td>` +
                            `<td>${data[i].bantuan}</td>` +
                            `<td>${data[i].jumlah_tanggungan}</td>` +
                            `<td>${data[i].jumlah_kendaraan}</td>` +
                            `<td>${data[i].status}</td>` +
                            `</tr>`;
                    }
                } else {
                    html += `<tr><td colspan="5" class="text-center">Belum ada data.</td></tr>`;
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