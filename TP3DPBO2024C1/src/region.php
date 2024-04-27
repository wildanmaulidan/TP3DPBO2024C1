<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Region.php');
include('classes/Template.php');

$region = new Region($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$region->open();
$region->getRegion();
$view = new Template('templates/skintabel.html');


// search data region
if (isset($_POST['btn-search'])) {
    $region->searchRegion($_POST['search']);
} else {
    $region->getRegion();
}

// add data region
if (!isset($_GET['id'])) {
    if (isset($_POST['submit'])) {
        if ($region->addRegion($_POST) > 0) {
            echo "<script>
                alert('Data berhasil ditambah!');
                document.location.href = 'region.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal ditambah!');
                document.location.href = 'region.php';
            </script>";
        }
    }

    $btn = 'Add';
    $title = 'Add';
}

// set data for template
$mainTitle = 'Region';
$header = '<tr>
<th scope="row">No.</th>
<th scope="row">Nama Region</th>
<th scope="row">Aksi</th>
</tr>';
$data = null;
$no = 1;
$formLabel = 'region';

while ($row = $region->getResult()) {
    $data .= '<tr>
    <th scope="row">' . $no . '</th>
    <td>' . $row['region_name'] . '</td>
    <td style="font-size: 22px;">
        <a href="region.php?id=' . $row['region_id'] . '" title="Edit Data"><i class="bi bi-pencil-square text-warning"></i></a>&nbsp;<a href="region.php?hapus=' . $row['region_id'] . '" title="Delete Data"><i class="bi bi-trash-fill text-danger"></i></a>
        </td>
    </tr>';
    $no++;
}


// update data region
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id > 0) {
        if (isset($_POST['submit'])) {
            if ($region->updateRegion($id, $_POST) > 0) {
                echo "<script>
                alert('Data berhasil diubah!');
                document.location.href = 'region.php';
            </script>";
            } else {
                echo "<script>
                alert('Data gagal diubah!');
                document.location.href = 'region.php';
            </script>";
            }
        }

        $region->getRegionById($id);
        $row = $region->getResult();

        $dataUpdate = $row['region_name'];
        $btn = 'Simpan';
        $title = 'Ubah';

        $view->replace('DATA_VAL_UPDATE', $dataUpdate);
    }
}

// hapus data region
if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    if ($id > 0) {
        if ($region->deleteRegion($id) > 0) {
            echo "<script>
                alert('Data berhasil dihapus!');
                document.location.href = 'region.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal dihapus!');
                document.location.href = 'region.php';
            </script>";
        }
    }
}

// close conn
$region->close();



$view->replace('DATA_MAIN_TITLE', $mainTitle);
$view->replace('DATA_TABEL_HEADER', $header);
$view->replace('DATA_TITLE', $title);
$view->replace('DATA_BUTTON', $btn);
$view->replace('DATA_FORM_LABEL', $formLabel);
$view->replace('DATA_TABEL', $data);
$view->write();
