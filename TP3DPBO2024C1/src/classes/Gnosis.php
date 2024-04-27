<?php

class Gnosis extends DB
{
    function getGnosis()
    {
        $query = "SELECT * FROM gnosis";
        return $this->execute($query);
    }

    function getGnosisById($id)
    {
        $query = "SELECT * FROM gnosis WHERE gnosis_id=$id";
        return $this->execute($query);
    }

    function searchGnosis($keyword)
    {
        $query = "SELECT * FROM gnosis WHERE gnosis_name LIKE '%$keyword%'";
        return $this->execute($query);
    }

    function addGnosis($data)
    {
        $name = $data['name'];
        $query = "INSERT INTO gnosis VALUES('', '$name')";
        return $this->executeAffected($query);
    }

    function updateGnosis($id, $data)
    {
        $name = $data['name'];
        $query = "UPDATE gnosis SET gnosis_name = '$name' WHERE gnosis_id = '$id'";
        return $this->executeAffected($query);
    }

    function deleteGnosis($id)
    {
        $query = "DELETE FROM gnosis WHERE gnosis_id=$id";
        return $this->executeAffected($query);
    }
}
