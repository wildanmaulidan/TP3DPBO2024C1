<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Gnosis.php');
include('classes/Region.php');
include('classes/Characters.php');
include('classes/Template.php');

// buat instance characters
$listCharacters = new Characters($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

// buka koneksi
$listCharacters->open();
// tampilkan data Characters
$listCharacters->getCharactersJoin();

// cari characters
if (isset($_POST['btn-cari'])) {
    // methode mencari data characters
    $listCharacters->searchCharacters($_POST['cari']);
} else {
    // method menampilkan data Characters
    $listCharacters->getCharactersJoin();
}


// Sorting 
if(isset($_POST['btn-sort'])) {
    $listCharacters->sortCharacter();
}

$data = null;

// ambil data characters
// gabungkan dgn tag html
// untuk di passing ke skin/template
while ($row = $listCharacters->getResult()) {
    $data .= '<div class="col gx-2 gy-3 justify-content-center">' .
        '<div class="card pt-4 px-2 characters-thumbnail">
        <a href="detail.php?id=' . $row['characters_id'] . '">
            <div class="row justify-content-center">
                <img src="assets/images/' . $row['characters_photo'] . '" class="card-img-top" alt="' . $row['characters_photo'] . '" height="120">
            </div>
            <div class="card-body">
                <p class="card-text characters-name my-0">' . $row['characters_name'] . '</p>
                <p class="card-text gnosis-name">' . $row['gnosis_name'] . '</p>
                <p class="card-text region-name my-0">' . $row['region_name'] . '</p>
            </div>
        </a>
    </div>    
    </div>';
}

// tutup koneksi
$listCharacters->close();

// buat instance template
$home = new Template('templates/skin.html');

// simpan data ke template
$home->replace('DATA_CHARACTERS', $data);
$home->write();
