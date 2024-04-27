<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Characters.php');
include('classes/Gnosis.php');
include('classes/Region.php');
include('classes/Template.php');

// buat instance characters, Gnosis, Region
$characters = new Characters($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$gnosis = new Gnosis($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$region = new Region($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);

// open connection
$characters->open();
$gnosis->open();
$region->open();

// buat instance template
$view = new Template('templates/skinform.html');

// Update or ADD
if (isset($_GET['update'])) {
// jika program memiliki post submit (edit data) dan method get(update)
    if (isset($_POST['submit'])) {
        $id = $_GET['update'];
        // edit data melalui fungsi updatechara$characters()
        if ($characters->updateData($id,$_POST,$_FILES) > 0) {
            echo "<script>
                alert('Data berhasil diubah!');
                document.location.href = 'index.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal diubah!');
                document.location.href = 'index.php';
            </script>";
        }
    }

    // set for template
    $btn = 'Update';
    $title = 'Update';
    $mainTitle = 'Characters';
    $formLabel = 'Characters';
    $gnosisList = '';
    $regionList = '';

    // get previous data
    $characters->getCharactersById($_GET['update']);
    $prevData = $characters->getResult();
    $prevName = $prevData['characters_name'];
    $prevBirth = $prevData['birthday'];
    $prevGender = $prevData['gender'];
    $prevPhoto = $prevData['characters_photo'];

    $gnosis->getGnosis();
    while ($row = $gnosis->getResult()) {
        $isSelected = ($row['gnosis_id'] == $prevData['gnosis_id']) ? 'selected' : '';
        $gnosisList .= "<option value='{$row['gnosis_id']}' {$isSelected}>{$row['gnosis_name']}</option>";
    }

    $region->getRegion();
    while ($row = $region->getResult()) {
        $isSelected = ($row['region_id'] == $prevData['region_id']) ? 'selected' : '';
        $regionList .= "<option value='{$row['region_id']}' {$isSelected}>{$row['region_name']}</option>";
    }

    // save data to tamplate
    $view->replace('DATA_NAME',$prevName );
    $view->replace('DATA_BIRTH', $prevBirth);
    $view->replace('DATA_GENDER', $prevGender);
    $view->replace('DATA_PHOTO', $prevPhoto);

}else {
    // jika program memiliki post submit (add data) tidak memiliki method get(update)
    if (isset($_POST['submit'])) {
        if ($characters->addData($_POST,$_FILES) > 0) {
            echo "<script>
                alert('Data berhasil ditambah!');
                document.location.href = 'index.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal ditambah!');
                document.location.href = 'index.php';
            </script>";
        }
    }

    // set data for templates
    $btn = 'Add';
    $title = 'Add';
    $mainTitle = 'Characters';
    $formLabel = 'Characters';
    $gnosisList = '';
    $regionList = '';

    $gnosis->getGnosis();
    while($data = $gnosis->getResult()){
        $gnosisList .= "<option value=".$data['gnosis_id'].">".$data['gnosis_name']."</option>";
    }
    $region->getRegion();
    while($data = $region->getResult()){
        $regionList .= "<option value=".$data["region_id"].">".$data['region_name']."</option>";
    }

}

// close connection
$gnosis->close();
$region->close();

// seve data to template
$nophoto = 'noPhoto.png';
$view->replace('DATA_MAIN_TITLE', $mainTitle);
$view->replace('DATA_TITLE', $title);
$view->replace('DATA_BUTTON', $btn);
$view->replace('DATA_FORM_LABEL', $formLabel);
$view->replace('DATA_PHOTO', $nophoto);
$view->replace('DATA_GNOSIS', $gnosisList);
$view->replace('DATA_REGION', $regionList);
$view->write();