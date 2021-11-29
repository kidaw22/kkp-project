<section class="content">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title"> Pengumuman </h3>
                </div>

                <div class="card-body p-0">
                    <div class="table-responsive mailbox-messages">
                        <table class="table table-hover table-striped">
                            <tbody>
                                <tr>
                                    <td class="mailbox-name">
                                        <a href=""> Pengajuan anda sudah disetujui! </a>
                                    </td>
                                    <td class="mailbox-subject"> RIZKY ADAWIYAH </td>
                                    <td class="mailbox-date">5 mins ago</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    const getData = () => {
        $.ajax({
            url: "<?= site_url() ?>transaksi/pengumuman/getData",
            type: 'POST',
            dataType: 'JSON',
            success: function(data) {

            }
        })
    }

    $(document).ready(function() {
        getData()
    })
</script>