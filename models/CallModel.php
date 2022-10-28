<?php

class CallModel extends DatabaseModel
{
    protected function get($call_id = null)
    {
        $call_id = is_null($call_id) ? $this->getLast()->id : $call_id;
        $query = "SELECT * FROM `calls` WHERE `id` = ?";
        $this->prepare($query);
        $this->bindValue(1, $call_id);
        return $this->single();
    }

    protected function create()
    {
        $query = "INSERT INTO `calls`() VALUES ()";
        $this->prepare($query);
        $this->execute();
        return true;
    }

    protected function update($col, $value, $call_id = null)
    {
        $call_id = is_null($call_id) ? $this->getLast()->id : $call_id;
        $query = "UPDATE `calls` SET " . $col . " = ? WHERE `id` = ?";
        $this->prepare($query);
        $this->bindValue(1, $value);
        $this->bindValue(2, $call_id);
        $this->execute();
        return true;
    }

    protected function destroy($call_id = null)
    {
        $call_id = is_null($call_id) ? $this->getLast()->id : $call_id;
        $query = "DELETE FROM `calls` WHERE `id` = ?";
        $this->prepare($query);
        $this->bindValue(1, $call_id);
        $this->execute();
        return true;
    }

    protected function getLast() {
        $query = "SELECT * FROM `calls` ORDER BY `id` DESC LIMIT 1";
        $this->prepare($query);
        return $this->single();
    }
}
