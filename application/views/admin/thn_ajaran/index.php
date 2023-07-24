<main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-md-4">
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2"><?= $title; ?></h1>
  </div>
  <div class="row mb-2">
    <div class="col-md-6">
    <button type="button" class="btn btn-primary mb-2" data-toggle="modal" data-target="#formModalWali">
        <i class="fas fa-plus"></i> Ubah Tahun Ajaran
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
                  <td>Tahun Ajaran</td>
                  <td>Semester</td>
                </tr>
              </thead>
              <tbody>
                <?php $no = 1; foreach($thn_ajaran as $t) : ?>
                  <tr>
                    <td><?= $no++; ?></td>
                    <td><?= $t['thn_ajaran']; ?></td>
                    <td><?= $t['semester']; ?></td>
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
        <h5 class="modal-title" id="formModalLabelWali">Ubah Tahun Ajaran</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <?= form_open('admin/thn_ajaran'); ?>
        <div class="form-group">
          <label for="thn_ajaran">Tahun Ajaran</label>
          <input type="text" name="thn_ajaran" id="thn_ajaran" class="form-control">
          <small class="muted text-danger"><?= form_error('thn_ajaran'); ?></small>
        </div>
        <div class="form-group">
          <label for="semester">Semester</label>
          <select name="semester" id="semester">
            <option value="">--Pilih Semester--</option>
            <option value="Ganjil">Ganjil</option>
            <option value="Genap">Genap</option>
          </select>
          <small class="muted text-danger"><?= form_error('semester'); ?></small>
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