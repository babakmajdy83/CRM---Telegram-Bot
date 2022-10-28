<?php

class UserController extends UserModel
{
    public int $user_id;
    private RequestController $request;
    private DatabaseModel $db;

    public function __construct($user_id)
    {
        $this->user_id = $user_id;
        $user = $this->get($user_id);
        if ($user == false) {
            $this->create($user_id);
        }
    }

    public function in_channel($chat, $user_id = null)
    {
        $user_id = is_null($user_id) ? $this->user_id : $user_id;
        $status = $this->request->getChatMember($user_id, $chat)->result->status;
        if ($status == "member" || $status == "creator" || $status == "administrator") {
            return true;
        } else
            return false;
    }

    public function getStatus()
    {
        return $this->get($this->user_id)->status;
    }

    public function getType()
    {
        return $this->get($this->user_id)->type;
    }

    public function getId()
    {
        return $this->get($this->user_id)->id;
    }

    public function is_admin($user_id = null)
    {
        $user_id = is_null($user_id) ? $this->user_id : $user_id;
        return in_array($user_id, Admins);
    }

    public function setStatus($status, $user_id = null)
    {
        $user_id = is_null($user_id) ? $this->user_id : $user_id;
        $this->update('status', $status, $user_id);
    }
}
