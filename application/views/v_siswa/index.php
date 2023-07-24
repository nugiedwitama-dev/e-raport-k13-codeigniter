<main role="main" class="ml-sm-auto px-md-4">
  <div class="border-bottom mb-2">
    <center>
      <h1 class="h2">Nilai Tatap Muka, Tutorial, Mandiri, UTS, dan Semester <?=$thn_ajaran['semester']?> <?= $thn_ajaran['thn_ajaran']?></h1>
    </center>  
  </div>
  <div class="row mb-2">
    <div class="col-md-6 mt-3">
    <strong>
      <p>Nama Lembaga         : PKBM BUDI UTAMA</p> 
      <p>Tingkatan / Kelas    : <?= $nila['nama']?></p>
      <p>Tingkatan / Kelas    : <?= $nila['kelas']?></p>> 
    </strong>
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
                <?php $no = 1; foreach($nilai as $n) : ?>
                  <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $n['nis']; ?></td>
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