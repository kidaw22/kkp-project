<section class="content">
  <div class="container-fluid">
    <!-- Small boxes (Stat box) -->
    <?php if((int)$this->session->userdata('usertype') === 1){ ?>
      <div class="row">
        <div class="col-lg-4 col-6">
          <!-- small box -->
          <div class="small-box bg-primary">
            <div class="inner">
              <h3><?= $warga_count ?></h3>

              <p>Jumlah Warga</p>
            </div>
            <div class="icon">
              <i class="ion ion-person"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-6">
          <!-- small box -->
          <div class="small-box bg-success">
            <div class="inner">
              <h3><?= $kegiatan_count ?></h3>

              <p>Jumlah Kegiatan</p>
            </div>
            <div class="icon">
              <i class="ion ion-document"></i>
            </div>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-12">
          <!-- small box -->
          <div class="small-box bg-danger">
            <div class="inner">
              <h3><?= $pengajuan_count ?></h3>

              <p>Jumlah Pengajuan</p>
            </div>
            <div class="icon">
              <i class="ion ion-email"></i>
            </div>
          </div>
        </div>
      </div>
    <?php } ?>

    <div class="row">
      <section class="col-lg-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">
              Notifikasi
            </h3>
          </div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-striped" id="tableNotification">
                <thead class="bg-blue">
                  <th style="width: 20px"> No </th>
                  <th> Pesan </th>
                  <th> Tanggal </th>
                </thead>

                <tbody id="bodyNotification">
                  
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </section>
    </div>
  </div><!-- /.container-fluid -->
</section>

<!-- Sparkline -->
<script src="<?= site_url() ?>assets/sparklines/sparkline.js"></script>

<!-- AdminLTE for demo purposes -->
<script src="<?= site_url() ?>assets/adminlte/js/demo.js"></script>

<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="<?= site_url() ?>assets/adminlte/js/pages/dashboard.js"></script>

<script>
  const getData = async () => {
    return $.ajax({
      url: "<?= site_url() ?>" + "dashboard/getNotifikasi",
      type: 'POST',
      dataType: 'JSON',
      error: function(jqXHR, textStatus, errorThrown){
        console.error(`Couldn't get the posts: ${textStatus}, error message: ${errorThrown}`)
      }
    }).done(response => response);
  }

  $(document).ready(async function(){
    const notifikasi = await getData()

    let html = ''
    for(let i = 0; i < notifikasi.length; i++){
      html += `<tr>`+
                `<td>${i + 1}</td>`+
                `<td><a href="${notifikasi[i].url}">${notifikasi[i].pesan}</a></td>`+
                `<td>${notifikasi[i].tanggal}</td>`+
              `</tr>`;
    }

    $('#bodyNotification').html(html)
    $('#tableNotification').dataTable({
      "pageLength": 5,
      "lengthMenu": [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]]
    })
  })
</script>