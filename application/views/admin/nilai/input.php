<main role="main" class="ml-sm-auto px-md-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?= $title; ?></h1>
  </div>
  <div class="card">
    <div class="card-body">
      <div class="row">
        <div class="col-md">
          <?= form_open(''); ?>
          <input type="hidden" name="id" value="<?= $nilai['id']; ?>">
          <div class="form-group">
            <p>Nilai Tutorial & TM</p>
            <label for="1">1</label>
            <input type="text" name="1" id="1" class="form-control" value="<?= $nilai['nilai_tm_1']; ?>">
            <small class="muted text-danger"><?= form_error('1'); ?></small>
            <label for="2">2</label>
            <input type="text" name="2" id="2" class="form-control" value="<?= $nilai['nilai_tm_2']; ?>">
            <small class="muted text-danger"><?= form_error('2'); ?></small>
            <label for="3">3</label>
            <input type="text" name="3" id="3" class="form-control" value="<?= $nilai['nilai_tm_3']; ?>">
            <small class="muted text-danger"><?= form_error('3'); ?></small>
            <label for="4">4</label>
            <input type="text" name="4" id="4" class="form-control" value="<?= $nilai['nilai_tm_4']; ?>">
            <small class="muted text-danger"><?= form_error('4'); ?></small>
            <label for="5">5</label>
            <input type="text" name="5" id="5" class="form-control" value="<?= $nilai['nilai_tm_5']; ?>">
            <small class="muted text-danger"><?= form_error('5'); ?></small>
          </div>
          <div class="form-group">
            <p>Nilai Mandiri / Praktek</p>
            <input type="text" name="mandiri" id="mandiri" class="form-control"value="<?= $nilai['nilai_mandiri']; ?>">
            <small class="muted text-danger"><?= form_error('mandiri'); ?></small>
          </div>
          <div class="form-group">
            <p>Nilai UTS</p>
            <input type="text" name="uts" id="uts" value="<?= $nilai['uts']; ?>" class="form-control">
            <small class="muted text-danger"><?= form_error('uts'); ?></small>
          </div>
          <div class="form-group">
            <p>Nilai Semester</p>
            <input type="number" name="nilai_smt" id="nilai_smt" value="<?= $nilai['nilai_smt']; ?>" class="form-control">
            <small class="muted text-danger"><?= form_error('nilai_smt'); ?></small>
          </div>
          <div class="form-group">
            <p>Sikap</p>
            <input type="text" name="sikap" id="sikap" value="<?= $nilai['sikap'] ?>" class="form-control">
            <small class="muted text-danger"><?= form_error('sikap'); ?></small>
          </div>
          <div class="form-group">
            <p>Nilai Raport</p>
            <input type="text" name="nilai_raport" id="nilai_raport" value="<?= $nilai['nilai_raport'] ?>" class="form-control">
            <small class="muted text-danger"><?= form_error('nilai_raport'); ?></small>
          </div>
          <div class="form-group">
            <p>Keterangan</p>
            <input type="text" name="ket" id="ket" value="<?= $nilai['ket'] ?>" class="form-control">
            <small class="muted text-danger"><?= form_error('ket'); ?></small>
          </div>
          <div class="form-group">
            <a href="<?= base_url('admin/nilai'); ?>" class="btn btn-secondary" data-dismiss="modal">Close</a>
            <button type="submit" class="btn btn-dark">Submit</button>
          </div>
          <?= form_close(); ?>
        </div>
      </div>
    </div>
  </div>
</main>

