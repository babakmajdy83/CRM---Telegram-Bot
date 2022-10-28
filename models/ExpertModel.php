<?php

class ExpertModel extends DatabaseModel
{
    protected function get($expert_id = null)
    {
        $expert_id = is_null($expert_id) ? $this->getLast()->id : $expert_id;
        $query = "SELECT * FROM `experts` WHERE `id` = ?";
        $this->prepare($query);
        $this->bindValue(1, $expert_id);
        return $this->single();
    }

    protected function create()
    {
        $query = "INSERT INTO `experts`() VALUES ()";
        $this->prepare($query);
        $this->execute();
        return true;
    }

    protected function update($col, $value, $expert_id = null)
    {
        $expert_id = is_null($expert_id) ? $this->getLast()->id : $expert_id;
        $query = "UPDATE `experts` SET " . $col . " = ? WHERE `id` = ?";
        $this->prepare($query);
        $this->bindValue(1, $value);
        $this->bindValue(2, $expert_id);
        $this->execute();
        return true;
    }

    protected function destroy($expert_id = null)
    {
        $expert_id = is_null($expert_id) ? $this->getLast()->id : $expert_id;
        $query = "DELETE FROM `experts` WHERE `id` = ?";
        $this->prepare($query);
        $this->bindValue(1, $expert_id);
        $this->execute();
        return true;
    }

    protected function getLast()
    {
        $query = "SELECT * FROM `experts` ORDER BY `id` DESC LIMIT 1";
        $this->prepare($query);
        return $this->single();
    }
}
