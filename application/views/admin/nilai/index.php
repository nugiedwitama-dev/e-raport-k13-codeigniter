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
      <p>Tingkatan / Kelas    : <?= $nila['kelas']?></p>
      <p>Mata Pelajaran       : <?= $nila['mata_pelajaran']?></p> 
      <p>Tutor Mata Pelajaran : <?= $get_guru['nama_guru']?></p> 
    </strong>
    <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#formModalWali">
        <i class="fas fa-plus"></i> Data Nilai
    </button>
    <a href="<?= base_url('/admin/filter_nilai') ?>" type="button" class="btn btn-info mb-2">
        <i class="fas fa-filter"></i> Ubah Filter Data
    </a>
    <a href="<?= base_url('/admin/cetak_nilai') ?>" type="button" class="btn btn-danger mb-2">
        <i class="fas fa-file-pdf"></i> Cetak Nilai
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
                  <td class="text-center" colspan="5">Nilai T&TM</td>
                  <td class="text-center" rowspan="2">Rata2 T&TM</td>
                  <td class="text-center" rowspan="2">Nilai Mandiri</td>
                  <td class="text-center" rowspan="2">UTS</td>
                  <td class="text-center" rowspan="2">Rata2 TM,T,M,UTS</td>
                  <td class="text-center" rowspan="2">Nilai SMT</td>
                  <td class="text-center" rowspan="2">Sikap</td>
                  <td class="text-center" rowspan="2">Nilai Raport</td>
                  <td class="text-center" rowspan="2">Ket</td>
                  <td rowspan="2"><i class="fas fa-cogs"></i></td>
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
                    <td><?= $n['nama']; ?></td>
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
                    <td>
                      <a href="<?= base_url('admin/inputNilai/') . $n['id']; ?>" class="btn btn-primary">
                        <i class="fas fa-plus"> Input/Edit Nilai</i>
                      </a>
                      <a href="<?= base_url('admin/hapus_nilai/') . $n['id']; ?>" class="btn btn-danger" onclick="return confirm('Yakin Hapus ?')"><i class="fas fa-trash"> Hapus Nilai</i></a>
                    </td>
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

<!-- Modal -->
<div class="modal fade" id="formModalWali" tabindex="-1" aria-labelledby="formModalLabelWali" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="formModalLabelWali">Tambah Data Nilai</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?= form_open('admin/nilai'); ?>
        <div class="form-group">
          <label for="id_siswa">Nama Siswa</label>
          <select name="id_siswa" id="id_siswa">
            <option value="">--Pilih Siswa--</option>
            <?php foreach($siswa as $s) : ?>
            <option value="<?= $s['id_siswa']?>"><?= $s['nama']?></option>
            <?php endforeach;?>
          </select>
          <small class="muted text-danger"><?= form_error('id_siswa'); ?></small>
        </div>
        <div class="form-group">
          <label for="id_mapel">Mata Pelajaran</label>
          <select name="id_mapel" id="id_mapel">
            <option value="">--Pilih Mapel--</option>
            <?php foreach($mapel as $m) : ?>
            <option value="<?= $m['id_mapel']?>"><?= $m['mata_pelajaran']?></option>
            <?php endforeach;?>
          </select>
          <small class="muted text-danger"><?= form_error('id_mapel'); ?></small>
        </div>
        <div class="form-group">
          <label for="thn_ajaran">Tahun Ajaran/Semester</label>
          <select name="thn_ajaran" id="thn_ajaran">
            <?php foreach($thn_ajar as $t) : ?>
            <option value="<?= $t['thn_ajaran']?>"><?= $t['thn_ajaran']?> - <?= $t['semester']?></option>
            <?php endforeach;?>
          </select>
          <small class="muted text-danger"><?= form_error('thn_ajaran'); ?></small>
        </div>
        <div class="form-group">
          <label for="id_guru">Tutor / Guru</label>
          <select name="id_guru" id="id_guru">
              <option value="">--Pilih Mapel--</option>
              <?php foreach($guru as $g) : ?>
            <option value="<?= $g['id_guru']?>"><?= $g['nama_guru']?></option>
            <?php endforeach;?>
          </select>
          <small class="muted text-danger"><?= form_error('id_guru'); ?></small>
        </div>
        <div class="form-group">
          <label for="kelas">Kelas</label>
          <select name="kelas" id="kelas">
              <?php foreach($kelas as $k) : ?>
            <option value="">--Pilih Kelas--</option>
            <option value="<?= $k['kelas']?>"><?= $k['kelas']?></option>
            <?php endforeach;?>
          </select>
          <small class="muted text-danger"><?= form_error('kelas'); ?></small>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-dark">Tambah</button>
        </div>
        <?= form_close(); ?>
      </div>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="formModalWali2" tabindex="-1" aria-labelledby="formModalLabelWali" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="formModalLabelWali">Tambah Data Nilai</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?= form_open('admin/nilai'); ?>
        <div class="form-group">
          <label for="id_siswa">Nama Siswa</label>
          <select name="id_siswa" id="id_siswa">
            <option value="">--Pilih Siswa--</option>
            <?php foreach($siswa as $s) : ?>
            <option value="<?= $s['id_siswa']?>"><?= $s['nama']?></option>
            <?php endforeach;?>
          </select>
          <small class="muted text-danger"><?= form_error('id_siswa'); ?></small>
        </div>
        <div class="form-group">
          <label for="id_mapel">Mata Pelajaran</label>
          <select name="id_mapel" id="id_mapel">
            <option value="">--Pilih Mapel--</option>
            <?php foreach($mapel as $m) : ?>
            <option value="<?= $m['id_mapel']?>"><?= $m['mata_pelajaran']?></option>
            <?php endforeach;?>
          </select>
          <small class="muted text-danger"><?= form_error('id_mapel'); ?></small>
        </div>
        <div class="form-group">
          <label for="thn_ajaran">Tahun Ajaran/Semester</label>
          <select name="thn_ajaran" id="thn_ajaran">
            <?php foreach($thn_ajar as $t) : ?>
            <option value="<?= $t['thn_ajaran']?>"><?= $t['thn_ajaran']?> - <?= $t['semester']?></option>
            <?php endforeach;?>
          </select>
          <small class="muted text-danger"><?= form_error('thn_ajaran'); ?></small>
        </div>
        <div class="form-group">
          <label for="id_guru">Tutor / Guru</label>
          <select name="id_guru" id="id_guru">
              <option value="">--Pilih Mapel--</option>
              <?php foreach($guru as $g) : ?>
            <option value="<?= $g['id_guru']?>"><?= $g['nama_guru']?></option>
            <?php endforeach;?>
          </select>
          <small class="muted text-danger"><?= form_error('id_guru'); ?></small>
        </div>
        <div class="form-group">
          <label for="kelas">Kelas</label>
          <select name="kelas" id="kelas">
              <?php foreach($kelas as $k) : ?>
            <option value="">--Pilih Kelas--</option>
            <option value="<?= $k['kelas']?>"><?= $k['kelas']?></option>
            <?php endforeach;?>
          </select>
          <small class="muted text-danger"><?= form_error('kelas'); ?></small>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-dark">Tambah</button>
        </div>
        <?= form_close(); ?>
      </div>
    </div>
  </div>
</div>