<div class="container-fluid">
    <form action="<?= base_url('admin')?>/filter_nilai_set" method="post">
        <div class="form-group">
            <label for="exampleDataList3" class="form-label">Mata pelajaran</label>
            <input class="" name="id_mapel" list="datalistOptions" id="exampleDataList3" placeholder="Pilih / Ketik Mapel">
            <?= form_error('id_mapel','<div class="text-danger small ml-3">','</div>'); ?>
        <datalist id="datalistOptions">
            <?php foreach ($mapel as $m) : ?>
            <option value="<?= $m->id_mapel ?>"><?= $m->id_mapel ?> - <?= $m->mata_pelajaran ?></option>
            <?php endforeach; ?>
        </datalist>
        <div class="form-group">
            <label for="smt" class="form-label">Tahun Ajaran / Semester</label>
            <select name="smt" id="smt" class="">
                <option value=""></option>
                <?php foreach ($semester as $smt) : ?>
                    <option value="<?= $smt['thn_ajaran']?>"><?= $smt['thn_ajaran']?> - <?= $smt['semester']?></option>
                <?php endforeach;?>
            </select>
        </div>
        <div class="form-group">
            <label for="kelas" class="form-label">Kelas</label>
            <select name="kelas" id="kelas" class="">
                <option value=""></option>
                <?php foreach ($kelas as $k) : ?>
                    <option value="<?= $k['kelas']?>"><?= $k['kelas']?></option>
                <?php endforeach;?>
            </select>
        </div>
        <div class="form-group">
            <button class="btn btn-primary" type="submit">Lihat Nilai</button>
        </div>
        </div>
    </form>
</div>