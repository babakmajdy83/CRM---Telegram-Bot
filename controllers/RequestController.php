<?php

class requestController
{
    private $api;

    public function __construct($token = TOKEN)
    {
        $this->db = new database();
        if ($token) {
            $this->api = 'https://api.telegram.org/bot' . $token . '/';
        }
    }

    private function sendRequest($method, $parameters)
    {
        if (!$parameters) {
            $parameters = array();
        }
        $parameters['method'] = $method;
        $handle = curl_init($this->api);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($handle, CURLOPT_TIMEOUT, 30);
        curl_setopt($handle, CURLOPT_POSTFIELDS, json_encode($parameters));
        curl_setopt($handle, CURLOPT_HTTPHEADER, array('content-type: application/json'));
        return curl_exec($handle);
    }

    public function sendmsg($text, $user_id = null, $keyboard = null)
    {
        global $user;
        $user_id = is_null($user_id) ? $user->user_id : $user_id;
        $params = array('chat_id' => $user_id, 'parse_mode' => 'HTML', 'text' => $text, 'disable_web_page_preview' => true);
        if ($keyboard != null) {
            $params[] = $keyboard;
        }
        return $this->sendRequest('sendMessage', $params);
    }

    public function sendvideo($video, $text = '', $user_id = null, $keyboard = null)
    {
        global $user;
        $user_id = is_null($user_id) ? $user->user_id : $user_id;
        $params = array('video' => $video, 'parse_mode' => 'HTML', 'chat_id' => $id, 'caption' => $text, 'disable_web_page_preview' => true);
        if ($keyboard != null) {
            $params[] = $keyboard;
        }
        return $this->sendRequest('sendVideo', $params);
    }

    public function sendphoto($photo, $text = null, $user_id = null, $keyboard = null)
    {
        global $user;
        $user_id = is_null($user_id) ? $user->user_id : $user_id;
        $params = array('photo' => $photo, 'parse_mode' => 'HTML', 'chat_id' => $id, 'caption' => $text, 'disable_web_page_preview' => true);
        if ($keyboard != null) {
            $params[] = $keyboard;
        }
        return $this->sendRequest('sendPhoto', $params);
    }

    public function delmsg($chat_id, $ms_id)
    {
        $params = array('chat_id' => $chat_id, 'message_id' => $ms_id);
        return $this->sendRequest('deleteMessage', $params);
    }

    public function editmsg($text, $chat_id, $ms_id, $keyboard = null)
    {
        $params = array('chat_id' => $chat_id, 'parse_mode' => 'HTML', 'message_id' => $ms_id, 'text' => $text);
        if ($keyboard != null) {
            $params[] = $keyboard;
        }
        return $this->sendRequest('editMessageText', $params);
    }

    public function editmsgCaption($text, $chat_id, $ms_id, $keyboard = null)
    {
        $params = array('chat_id' => $chat_id, 'parse_mode' => 'HTML', 'message_id' => $ms_id, 'caption' => $text);
        if ($keyboard != null) {
            $params[] = $keyboard;
        }
        return $this->sendRequest('editMessageCaption', $params);
    }

    public function forwardmsg($chat_id, $from_chat_id, $ms_id)
    {
        $params = array('chat_id' => $chat_id, 'message_id' => $ms_id, 'from_chat_id' => $from_chat_id);
        return $this->sendRequest('forwardMessage', $params);
    }

    public function forwardToAll($from_chat_id, $ms_id)
    {
//        $sql = "SELECT `user_id` FROM `users`";
//        $this->db->prepare($sql);
//        $this->db->execute();
//        $chat_ids = $this->db->results();
//        foreach ($chat_ids as $chat_id) {
//            $chat_id = $chat_id->user_id;
//            $params = array('chat_id' => $chat_id, 'message_id' => $ms_id, 'from_chat_id' => $from_chat_id);
//            $this->sendRequest('forwardMessage', $params);
//        }
    }

    public function getMe()
    {
        return json_decode($this->sendRequest('getMe', []));
    }

    public function getChatMember($user_id, $chat)
    {
        $params = ['chat_id' => $chat, 'user_id' => $user_id];
        return json_decode($this->sendRequest('getChatMember', $params));
    }

    public function sendtoall($ms_id, $from_chat_id, $report_id = null)
    {
//        if (is_null($report_id)) {
//            global $user_id;
//            $report_id = $user_id;
//        }
//        $sql = "SELECT `user_id` FROM `users` WHERE 1";
//        $this->db->prepare($sql);
//        $this->db->execute();
//        $users = $this->db->results();
//        foreach ($users as $user) {
//            $params = ['chat_id' => $user->user_id, 'message_id' => $ms_id, 'from_chat_id' => $from_chat_id];
//            $this->sendRequest('copyMessage', $params);
//        }
//        $this->sendmsg("ارسال انجام شد!", $report_id);
//        die;
    }
}
