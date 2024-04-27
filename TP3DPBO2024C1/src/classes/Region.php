<?php

class Region extends DB
{
    function getRegion()
    {
        $query = "SELECT * FROM region";
        return $this->execute($query);
    }

    function getRegionById($id)
    {
        $query = "SELECT * FROM region WHERE region_id=$id";
        return $this->execute($query);
    }

    function searchRegion($keyword)
    {
        $query = "SELECT * FROM region WHERE region_name LIKE '%$keyword%'";
        return $this->execute($query);
    }

    function addRegion($data)
    {
        $name = $data['name'];
        $query = "INSERT INTO region VALUES('', '$name')";
        return $this->executeAffected($query);
    }

    function updateRegion($id, $data)
    {
        $name = $data['name'];
        $query = "UPDATE region SET region_name = '$name' WHERE region_id = '$id'";
        return $this->executeAffected($query);
    }

    function deleteRegion($id)
    {
        $query = "DELETE FROM region WHERE region_id=$id";
        return $this->executeAffected($query);
    }
}
