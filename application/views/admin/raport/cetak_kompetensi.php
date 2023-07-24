<div class="container-fluid">
    <center>
        - 3 -
        <h1 class="h2">KETERCAPAIAN KOMPETENSI</h1>
    </center>
    <br>
    <br>
    <table class=" table table-striped table-bordered">
        <thead>            
            <tr>
                <td><strong>No</strong></td>
                <td><strong>Kompetensi</strong> </td>
                <td><strong>Nilai</strong> </td>
                <td><strong>Ketercapaian Kompetensi</strong> </td>
            </tr>
        </thead>
        <tbody>
            <?php $no = 1; foreach($kompetensi as $k)  : ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $k['mata_pelajaran'] ?></td>
                    <td><?= $k['nilai_raport'] ?></td>
                    <td><?php if($k['nilai_raport'] >= 80){
                        echo "Baik, Pertahankan dan tingkatkan belajar";
                    } else if($k['nilai_raport'] < 80 && $k['nilai_raport'] >=  75){
                        echo "Baik, Perlu peningkatan belajar kembali";
                    }else if($k['nilai_raport'] < 75 && $k['nilai_raport'] > 70){
                        echo "Cukup, Perlu peningkatan belajar kembali";
                    }else if($k['nilai_raport'] < 70){
                        echo "Kurang, Perlu peningkatan belajar kembali";
                    }
                    ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>

    </table>
</div>

<script>
    window.print();
</script>