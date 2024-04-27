<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Gnosis.php');
include('classes/Region.php');
include('classes/Characters.php');
include('classes/Template.php');

$characters = new Characters($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$characters->open();

$data = nulL;

if (isset ($_GET['delete'])) {
    $id = $_GET['delete'];

    if ($id > 0) {
        if ($characters->deleteData($id) > 0) {
            echo "
                <script>
                    alert('Data berhasil dihapus!');
                    document.location.href = 'index.php';
                </script>
            ";
        } else {
            echo "
                <script>
                    alert('Data gagal dihapus!');
                    document.location.href = 'index.php';
                </script>
            ";
        }
    }
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id > 0) {
        $characters->getCharactersById($id);
        $row = $characters->getResult();

        $data .= '<div class="card-header text-center">
        <h3 class="my-0">Detail ' . $row['characters_name'] . '</h3>
        </div>
        <div class="card-body text-end">
            <div class="row mb-5">
                <div class="col-3">
                    <div class="row justify-content-center">
                        <img src="assets/images/' . $row['characters_photo'] . '" class="img-thumbnail" alt="' . $row['characters_photo'] . '" width="60">
                        </div>
                    </div>
                    <div class="col-9">
                        <div class="card px-3">
                            <table border="0" class="text-start">
                                <tr>
                                    <td>Nama</td>
                                    <td>:</td>
                                    <td>' . $row['characters_name'] . '</td>
                                </tr>
                                <tr>
                                    <td>Birthday</td>
                                    <td>:</td>
                                    <td>' . $row['birthday'] . '</td>
                                </tr>
                                <tr>
                                    <td>Gender</td>
                                    <td>:</td>
                                    <td>' . $row['gender'] . '</td>
                                </tr>
                                <tr>
                                    <td>Gnosis</td>
                                    <td>:</td>
                                    <td>' . $row['gnosis_name'] . '</td>
                                </tr>
                                <tr>
                                    <td>Region</td>
                                    <td>:</td>
                                    <td>' . $row['region_name'] . '</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer text-end">
                <a href="form_add.php?update=' . $row['characters_id'] .' "><button type="button" class="btn btn-success text-white">Update Data</button></a>
                <a href="detail.php?delete=' . $row['characters_id'] .' "><button type="button" class="btn btn-danger">Delete Data</button></a>
            </div>';
    }
}

$characters->close();
$detail = new Template('templates/skindetail.html');
$detail->replace('DATA_DETAIL_CHARACTERS', $data);
$detail->write();
