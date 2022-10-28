<?php

class CustomerModel extends DatabaseModel
{
    protected function get($customer_id = null)
    {
        $customer_id = is_null($customer_id) ? $this->getLast()->id : $customer_id;
        $query = "SELECT * FROM `customers` WHERE `id` = ?";
        $this->prepare($query);
        $this->bindValue(1, $customer_id);
        $this->execute();
        return $this->single();
    }

    protected function create()
    {
        $query = "INSERT INTO `customers`() VALUES ()";
        $this->prepare($query);
        $this->execute();
        return true;
    }

    protected function update($col, $value, $customer_id = null)
    {
        $customer_id = is_null($customer_id) ? $this->getLast()->id : $customer_id;
        $query = "UPDATE `customers` SET " . $col . " = ? WHERE `id` = ?";
        $this->prepare($query);
        $this->bindValue(1, $value);
        $this->bindValue(2, $customer_id);
        $this->execute();
        return true;
    }

    protected function destroy($customer_id = null)
    {
        $customer_id = is_null($customer_id) ? $this->getLast()->id : $customer_id;
        $query = "DELETE FROM `customers` WHERE `id` = ?";
        $this->prepare($query);
        $this->bindValue(1, $customer_id);
        $this->execute();
        return true;
    }

    protected function getLast() {
        $query = "SELECT * FROM `calls` ORDER BY `id` DESC LIMIT 1";
        $this->prepare($query);
        return $this->single();
    }
}
