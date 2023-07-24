<main role="main" class="ml-sm-auto px-md-4">
  <div class="border-bottom mb-2">
    <center>
      <h1 class="h2">LAPORAN HASIL BELAJAR PESERTA DIDIK SEMESTER <?=$thn_ajaran['semester']?> PKBM BUDI UTAMA</h1>
    </center>  
  </div>
  <div class="row mb-2">
    <div class="col mt-3">
    <div class=" col d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      <p>Nama Siswa      : <?= $nila['nama'] ?><br>
        NIS / NISN      : <?= $nila['nis'] ?> <br>
        NAMA SEKOLAH    : PKBM BUDI UTAMA <br></p>
      <p>No Raport       : <?= $nila['id_siswa']?><br>
        Tingkatan / Kelas      : <?= $nila['kelas']?> <br>
        Tahun Ajaran: <?= $nila['thn_ajaran']?></p>
      <p style="font-size 24px bg-warning"><strong>Absen</strong><br>
      <strong><?= $nila['id_siswa']?></strong>
      </p>

    </div>
    <strong>
    </strong>
    <a href="<?= base_url('admin/raport')?>" type="button" class="btn btn-primary mb-2">
        <i class="fas fa-filter"></i> Ubah Data Raport
    </a>
    <a href="<?= base_url('admin/cetak_cover')?>" type="button" class="btn btn-warning mb-2">
        <i class="fas fa-file-pdf"></i> Cetak Cover
    </a>
    <a href="<?= base_url('admin/cetak_cover')?>" type="button" class="btn btn-warning mb-2">
        <i class="fas fa-file-pdf"></i> Cetak Biodata
    </a>
    <a href="<?= base_url('admin/cetak_raport')?>" type="button" class="btn btn-warning mb-2">
        <i class="fas fa-file-pdf"></i> Cetak Raport
    </a>
    <a href="<?= base_url('admin/cetak_kompetensi')?>" type="button" class="btn btn-warning mb-2">
        <i class="fas fa-file-pdf"></i> Cetak Kompetensi
    </a>
    <a href="<?= base_url('admin/cetak_pengembangan_diri')?>" type="button" class="btn btn-warning mb-2">
        <i class="fas fa-file-pdf"></i> Cetak Pengembangan Diri
    </a>
    <a href="<?= base_url('admin/cetak_full_raport')?>" type="button" class="btn btn-danger mb-2">
        <i class="fas fa-file-pdf"></i> Cetak Full Raport
    </a>

      <?php if(validation_errors()) : ?>
        <div class="alert alert-danger" role="alert"><?= validation_errors(); ?></div>
      <?php endif; ?>
      <?= $this->session->flashdata('pesan'); ?>
    </div>
  </div>
  <div class="card">
    <div class="card-body">
      <div class="row">
        <div class="col-lg">
          <div class="table-responsive">
            <table class="table table-striped table-bordered">
              <thead>
                <tr>
                  <td class="text-center" rowspan="2">Absen</td>
                  <td class="text-center" rowspan="2">Induk</td>
                  <td class="text-center" rowspan="2">Nama Siswa</td>
                  <td class="text-center" rowspan="2">Mata Pelajaran</td>
                  <td class="text-center" colspan="5">Nilai T&TM</td>
                  <td class="text-center" rowspan="2">Rata2 T&TM</td>
                  <td class="text-center" rowspan="2">Nilai Mandiri</td>
                  <td class="text-center" rowspan="2">UTS</td>
                  <td class="text-center" rowspan="2">Rata2 TM,T,M,UTS</td>
                  <td class="text-center" rowspan="2">Nilai SMT</td>
                  <td class="text-center" rowspan="2">Sikap</td>
                  <td class="text-center" rowspan="2">Nilai Raport</td>
                  <td class="text-center" rowspan="2">Ket</td>
                </tr>
                <tr>
                    <td>1</td>
                    <td>2</td>
                    <td>3</td>
                    <td>4</td>
                    <td>5</td>
                </tr>
              </thead>
              <tbody>
                <?php $no = 1; foreach($raport as $n) : ?>
                  <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $n['nis']; ?></td>
                    <td><?= $n['nama']; ?></td>
                    <td><?= $n['mata_pelajaran']; ?></td>
                    <td><?= $n['nilai_tm_1']; ?></td>
                    <td><?= $n['nilai_tm_2']; ?></td>
                    <td><?= $n['nilai_tm_3']; ?></td>
                    <td><?= $n['nilai_tm_4']; ?></td>
                    <td><?= $n['nilai_tm_5']; ?></td>
                    <td><?= $n['rata_rata_tm']; ?></td>
                    <td><?= $n['nilai_mandiri']; ?></td>
                    <td><?= $n['uts']; ?></td>
                    <td><?= $n['rata_rata_tm_uts']; ?></td>
                    <td><?= $n['nilai_smt']; ?></td>
                    <td><?= $n['sikap']; ?></td>
                    <td><?= $n['nilai_raport']; ?></td>
                    <td><?= $n['ket']; ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>