<style>
	@media print {
		.no-print{display: none;}
	}
</style>
<main role="main" class="px-md-4">
  <div class="border-bottom mb-2">
    <center>
        <p>-2-</p>
      <h1 class="h2">LAPORAN HASIL BELAJAR PESERTA DIDIK SEMESTER <?php if ($thn_ajaran['semester'] == 'Ganjil') { echo "GANJIL";} else{ echo "GENAP";} ?> PKBM BUDI UTAMA</h1>
    </center>  
  </div>
  <div class="row mb-2">
    <div class="col mt-3">
    <div class=" col d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      <p>Nama Siswa     : <?= $nila['nama']?><br>
        NIS / NISN      : <?= $nila['nis']?> <br>
        Nama Sekolah    : PKBM BUDI UTAMA <br></p>
      <p>No Raport       : <?= $nila['id_siswa']?><br>
        Tingkatan / Kelas      : <?= $nila['kelas']?> <br>
        Tahun Ajaran: <?= $nila['thn_ajaran']?></p>
      <p style="font-size 24px bg-warning"><strong>Absen</strong><br>
      <strong><?= $nila['id_siswa']?></strong>
      </p>

</div>
    </div>
            <table class="table table-striped table-bordered">
              <thead>
                <tr>
                  <td class="text-center" rowspan="3">No</td>
                  <td class="text-center" rowspan="3">Mata Pelajaran</td>
                  <td class="text-center" rowspan="3">KKM</td>
                  <td class="text-center" rowspan="3">SKK</td>
                  <td class="text-center" colspan="5">Nilai Hasil Belajar</td>
                </tr>
                <tr>
                    <td class="text-center" colspan="2">Pengetahuan</td>  
                    <td class="text-center" colspan="2">Praktik</td>  
                    <td class="text-center" rowspan="2">Sikap/Afektif</td>
                </tr>
              </thead>
              <tbody>
                <?php $no = 1; foreach($raport as $n) : ?>
                  <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $n['mata_pelajaran']; ?></td>
                    <td><?= $n['kkm']; ?></td>
                    <td><?= $n['skk']; ?></td>
                    <td><?= $n['nilai_raport']; ?></td>
                    <td><?php if ($n['nilai_raport'] == 50){
                        echo "Lima Puluh";
                    } ?>
                    <?php if ($n['nilai_raport'] == 60){
                        echo "Enam Puluh";
                    } ?>
                    <?php if ($n['nilai_raport'] == 61){
                        echo "Enam Puluh Satu";
                    } ?>
                    <?php if ($n['nilai_raport'] == 62){
                        echo "Enam Puluh Dua";
                    } ?>
                    <?php if ($n['nilai_raport'] == 63){
                        echo "Enam Puluh Tiga";
                    } ?>
                    <?php if ($n['nilai_raport'] == 64){
                        echo "Enam Puluh Empat";
                    } ?>
                    <?php if ($n['nilai_raport'] == 65){
                        echo "Enam Puluh Lima";
                    } ?>
                    <?php if ($n['nilai_raport'] == 66){
                        echo "Enam Puluh TEnam";
                    } ?>
                    <?php if ($n['nilai_raport'] == 67){
                        echo "Enam Puluh Tujuh";
                    } ?>
                    <?php if ($n['nilai_raport'] == 81){
                        echo "Delapan Puluh Satu";
                    } ?>
                    </td>
                    <td><?= $n['nilai_mandiri']; ?></td>
                    <td>
                        <?php if ($n['nilai_mandiri'] == 77){
                        echo "Tujuh Puluh Tujuh";
                    } ?>
                       <?php if ($n['nilai_mandiri'] == 50){
                        echo "Lima Puluh";
                    } ?>
                    </td>
                    <td><?= $n['sikap']; ?></td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
        </div>
        <p><strong>Keputusan</strong></p>
        <p><hr></p>
        <p><hr></p>
        <p><hr></p>
        <div class=" col d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      <p>Orang Tua / Wali Siswa<br>
        <br> <br> <br> <br>
        --------------------- <br>
        </p>
      <p>Mengetahui Kepala:<br>
      <br> <br> <br>
        Tri Djoko Hs. <br>
        --------------------- <br>
        NIP: - <br>
      </p>
      <p>Kembaran, <?= tanggal() ?> <br>
      <br><br> <br>
        <?= $nila['nama_guru'] ?><br>
        --------------------- <br>
        NIP: -
      </p>

</div>
  </div>
</main>

<script>
	window.print();
</script>