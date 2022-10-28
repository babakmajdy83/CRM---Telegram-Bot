<?php

class UserModel extends DatabaseModel
{
    protected function get($user_id)
    {
        $query = "SELECT * FROM `users` WHERE `user_id` = ?";
        $this->prepare($query);
        $this->bindValue(1, $user_id);
        return $this->single();
    }

    protected function create($user_id): bool
    {
        $query = "INSERT INTO `users`('user_id') VALUES (?)";
        $this->prepare($query);
        $this->bindValue(1, $user_id);
        $this->execute();
        return true;
    }

    protected function update($col, $value, $user_id): bool
    {
        $query = "UPDATE `users` SET `" . $col . "` = ? WHERE `user_id` = ?";
        $this->prepare($query);
        $this->bindValue(1, $value);
        $this->bindValue(2, $user_id);
        $this->execute();
        return true;
    }

    protected function destroy($user_id): bool
    {
        $query = "DELETE FROM `users` WHERE `id` = ?";
        $this->prepare($query);
        $this->bindValue(1, $user_id);
        $this->execute();
        return true;
    }
}
