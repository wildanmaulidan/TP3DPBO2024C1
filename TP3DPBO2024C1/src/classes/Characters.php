<?php

class Characters extends DB
{
    function getCharactersJoin()
    {
        $query = "SELECT * FROM characters JOIN gnosis ON characters.gnosis_id=gnosis.gnosis_id JOIN region ON characters.region_id=region.region_id ORDER BY characters.characters_id";

        return $this->execute($query);
    }

    function getCharacters()
    {
        $query = "SELECT * FROM characters";
        return $this->execute($query);
    }

    function getCharactersById($id)
    {
        $query = "SELECT * FROM characters JOIN gnosis ON characters.gnosis_id=gnosis.gnosis_id JOIN region ON characters.region_id=region.region_id WHERE characters_id=$id";
        return $this->execute($query);
    }

    function searchCharacters($keyword)
    {
        $query = "SELECT * FROM characters JOIN gnosis ON characters.gnosis_id=gnosis.gnosis_id JOIN region ON characters.region_id=region.region_id WHERE characters_name LIKE '%$keyword%'";
        return $this->execute($query);
    }

    function sortCharacter()
    {
        // sorting characters by characters_name asc
        $query = "SELECT * FROM characters JOIN gnosis ON characters.gnosis_id=gnosis.gnosis_id JOIN region ON characters.region_id=region.region_id ORDER BY characters.characters_name ASC";
        return $this->execute($query);
    }

    function addData($data, $file)
    {

        $name = $data['characters_name'];
        $birthday = $data['birthday'];
        $gender = $data['gender'];
        $gnosis_id = $data['gnosis_id'];
        $region_id = $data['region_id'];

        $photo = $file['characters_photo']['name'];
        $character_photo = $file['characters_photo']['tmp_name'];
        $folder = "assets/images/$photo";
        move_uploaded_file($character_photo, $folder);

        
        $query = "INSERT INTO characters (characters_name, birthday, gender, gnosis_id, region_id, characters_photo) VALUES ('$name', '$birthday', '$gender', '$gnosis_id', '$region_id', '$photo')";
        
        return $this->executeAffected($query);
        
        
    }

    function updateData($id, $data, $file)
    {
        $name = $data['characters_name'];
        $birthday = $data['birthday'];
        $gender = $data['gender'];
        $gnosis_id = $data['gnosis_id'];
        $region_id = $data['region_id'];

        $photo = $file['characters_photo']['name'];
        $character_photo = $file['characters_photo']['tmp_name'];
        $folder = "assets/images/$photo";
        move_uploaded_file($character_photo, $folder);

        $query = "UPDATE characters 
        SET characters_name='$name', birthday='$birthday', gender='$gender', gnosis_id='$gnosis_id', region_id='$region_id',characters_photo='$photo'
        WHERE characters_id=$id";

        return $this->executeAffected($query);
    }

    function deleteData($id)
    {
        $query = "DELETE FROM characters WHERE characters_id=$id";
        return $this->executeAffected($query);
    }
}
