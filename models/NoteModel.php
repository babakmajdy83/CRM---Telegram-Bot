<?php

class NoteModel extends DatabaseModel
{
    protected function get($note_id = null)
    {
        $note_id = is_null($note_id) ? $this->getLast()->id : $note_id;
        $query = "SELECT * FROM `notes` WHERE `id` = ?";
        $this->prepare($query);
        $this->bindValue(1, $note_id);
        return $this->single();
    }

    protected function create()
    {
        $query = "INSERT INTO `notes`() VALUES ()";
        $this->prepare($query);
        $this->execute();
        return true;
    }

    protected function update($col, $value, $note_id = null)
    {
        $note_id = is_null($note_id) ? $this->getLast()->id : $note_id;
        $query = "UPDATE `notes` SET " . $col . " = ? WHERE `id` = ?";
        $this->prepare($query);
        $this->bindValue(1, $value);
        $this->bindValue(2, $note_id);
        $this->execute();
        return true;
    }

    protected function destroy($note_id = null)
    {
        $note_id = is_null($note_id) ? $this->getLast()->id : $note_id;
        $query = "DELETE FROM `notes` WHERE `id` = ?";
        $this->prepare($query);
        $this->bindValue(1, $note_id);
        $this->execute();
        return true;
    }

    protected function getLast()
    {
        $query = "SELECT * FROM `notes` ORDER BY `id` DESC LIMIT 1";
        $this->prepare($query);
        return $this->single();
    }
}
