<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?= $title; ?></h1>
  </div>
  <div class="row mb-2">
    <div class="col-md-6">
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
          <?= form_open('admin/ubahDataMapel'); ?>
        
          <input type="hidden" name="id_mapel" id="id_mapel" value="<?= $mapel['id_mapel']; ?>">
          <div class="form-group">
            <label for="kelas">Mata Pelajaran</label>
            <input type="text" name="mapel" id="mapel" class="form-control" value="<?= $mapel['mata_pelajaran']; ?>">
            <small class="muted text-danger"><?= form_error('mapel'); ?></small>
          </div>
          <div class="form-group">
            <label for="kelas">SKK</label>
            <input type="text" name="skk" id="skk" class="form-control" value="<?= $mapel['skk']; ?>">
            <small class="muted text-danger"><?= form_error('skk'); ?></small>
          </div>
          <div class="form-group">
            <label for="kelas">KKM </label>
            <input type="text" name="kkm" id="kkm" class="form-control" value="<?= $mapel['kkm']; ?>">
            <small class="muted text-danger"><?= form_error('kkm'); ?></small>
          </div>

          <div class="form-group">
            <label for="nama">Nama Guru</label>
            <select name="nama" id="nama" class="form-control">
              <option value="">-- Pilih Guru --</option>
              <?php foreach($guru as $g) : ?>
                <?php if($g['id_guru'] == $guruWali['id_guru']) : ?>
                  <option value="<?= $g['id_guru']; ?>" selected><?= $g['nama_guru']; ?></option>
                <?php else : ?>
                  <option value="<?= $g['id_guru']; ?>"><?= $g['nama_guru']; ?></option>
                <?php endif; ?>
              <?php endforeach; ?>
            </select>
            <small class="muted text-danger"><?= form_error('nama'); ?></small>
          </div>
          
          <div class="form-group">
            <a href="<?= base_url('admin/mapel'); ?>" class="btn btn-secondary" data-dismiss="modal">Kembali</a>
            <button type="submit" class="btn btn-dark">Ubah</button>
          </div>
          <?= form_close(); ?>
        </div>
      </div>
    </div>
  </div>
</main>