<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?= $title; ?></h1>
  </div>
  <div class="row mb-2">
    <div class="col-md-6">
    <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#formModalWali">
        <i class="fas fa-plus"></i> Tambah Data Mata Pelajaran
    </button>
      
      <?php if(validation_errors()) : ?>
        <div class="alert alert-danger" role="alert"><?= validation_errors(); ?></div>
      <?php endif; ?>
      <?= $this->session->flashdata('pesan'); ?>
    </div>
  </div>
  <div class="card">
    <div class="card-body">
      <div class="row">
        <div class="col-md">
          <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <td>No</td>
                  <td>Mata Pelajaran</td>
                  <td>SKK</td>
                  <td>KKM</td>
                  <td>TUTOR / GURU</td>
                  <td><i class="fas fa-cogs"></i></td>
                </tr>
              </thead>
              <tbody>
                <?php $no = 1; foreach($mapel as $m) : ?>
                  <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $m['mata_pelajaran']; ?></td>
                    <td><?= $m['skk']; ?></td>
                    <td><?= $m['kkm']; ?></td>
                    <td><?= $m['nama_guru']; ?></td>
                    <td>
                      <a href="<?= base_url('admin/ubahMapel/') . $m['id_mapel']; ?>" class="btn btn-primary">
                        <i class="fas fa-edit"></i>
                      </a>
                      <a href="<?= base_url('admin/hapusMapel/') . $m['id_mapel']; ?>" class="btn btn-danger" onclick="return confirm('Yakin Hapus ?')"><i class="fas fa-trash"></i></a>
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
        <h5 class="modal-title" id="formModalLabelWali">Tambah Data Mata Pelajaran</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?= form_open('admin/mapel'); ?>
        <div class="form-group">
          <label for="kelas">Mata Pelajaran</label>
          <input type="text" name="mapel" id="mapel" class="form-control">
          <small class="muted text-danger"><?= form_error('mapel'); ?></small>
        </div>
        <div class="form-group">
          <label for="kelas">SKK</label>
          <input type="text" name="skk" id="skk" class="form-control">
          <small class="muted text-danger"><?= form_error('skk'); ?></small>
        </div>
        <div class="form-group">
          <label for="kelas">KKM</label>
          <input type="text" name="kkm" id="kkm" class="form-control">
          <small class="muted text-danger"><?= form_error('kkm'); ?></small>
        </div>
        <div class="form-group">
          <label for="nama">Nama Guru</label>
          <select name="nama" id="nama" class="form-control">
            <option value="">-- Pilih Guru --</option>
            <?php foreach($guru as $g) : ?>
              <option value="<?= $g['id_guru']; ?>"><?= $g['nama_guru']; ?></option>
            <?php endforeach; ?>
          </select>
          <small class="muted text-danger"><?= form_error('nama'); ?></small>
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