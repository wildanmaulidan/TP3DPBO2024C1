<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Gnosis.php');
include('classes/Template.php');

$gnosis = new Gnosis($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$gnosis->open();
$gnosis->getGnosis();

// buat instance template
$view = new Template('templates/skintabel.html');

// search data gnosis
if (isset($_POST['btn-search'])) {
    $gnosis->searchGnosis($_POST['search']);
} else {
    $gnosis->getGnosis();
}

// add gnosis data
if (!isset($_GET['id'])) {
    if (isset($_POST['submit'])) {
        // jika add data gnosis berhasil
        if ($gnosis->addgnosis($_POST) > 0) {
            echo "<script>
                alert('Data berhasil ditambah!');
                document.location.href = 'gnosis.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal ditambah!');
                document.location.href = 'gnosis.php';
            </script>";
        }
    }

    // set value for skinform template
    $btn = 'Add';
    $title = 'Add';
}

// set value for skinform template
$mainTitle = 'Gnosis';
$header = '<tr>
<th scope="row">No.</th>
<th scope="row">Nama Gnosis</th>
<th scope="row">Aksi</th>
</tr>';
$formLabel = 'gnosis';

// show gnosis data
$data = null;
$no = 1;
while ($row = $gnosis->getResult()) {
    $data .= '<tr>
    <th scope="row">' . $no . '</th>
    <td>' . $row['gnosis_name'] . '</td>
    <td style="font-size: 22px;">
        <a href="gnosis.php?id=' . $row['gnosis_id'] . '" title="Edit Data"><i class="bi bi-pencil-square text-warning"></i></a>&nbsp;<a href="gnosis.php?hapus=' . $row['gnosis_id'] . '" title="Delete Data"><i class="bi bi-trash-fill text-danger"></i></a>
        </td>
    </tr>';
    $no++;
}

// jika metode get(id) tersedia
if (isset($_GET['id'])) {
    $id = $_GET['id'];  // set $id dengan gnosis_id
    if ($id > 0) {
        // jika metode post(submit) tersedia lakukan update
        if (isset($_POST['submit'])) { 
            // jika update berhasil
            if ($gnosis->updateGnosis($id, $_POST) > 0) {
                echo "<script>
                alert('Data berhasil diubah!');
                document.location.href = 'gnosis.php';
            </script>";
            } else {
                echo "<script>
                alert('Data gagal diubah!');
                document.location.href = 'gnosis.php';
            </script>";
            }
        }

        $gnosis->getGnosisById($id);
        $row = $gnosis->getResult();

        $dataUpdate = $row['gnosis_name'];
        $btn = 'Save';
        $title = 'Update';

        $view->replace('DATA_VAL_UPDATE', $dataUpdate);
    }
}

// jika motde get(hapus) tersedia
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    if ($id > 0) {
        // delete data gnosis
        if ($gnosis->deleteGnosis($id) > 0) {
            echo "<script>
                alert('Data berhasil dihapus!');
                document.location.href = 'gnosis.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal dihapus!');
                document.location.href = 'gnosis.php';
            </script>";
        }
    }
}

// close conn
$gnosis->close();


// save data to template
$view->replace('DATA_MAIN_TITLE', $mainTitle);
$view->replace('DATA_TABEL_HEADER', $header);
$view->replace('DATA_TITLE', $title);
$view->replace('DATA_BUTTON', $btn);
$view->replace('DATA_FORM_LABEL', $formLabel);
$view->replace('DATA_TABEL', $data);
$view->write();