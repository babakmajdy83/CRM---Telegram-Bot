<?php

$text = $update->message->text;
$chat_id = $update->message->chat->id;
$user_id = $update->message->from->id;
$user_username = $update->message->from->username;
$name = $update->message->from->first_name . " " . $update->message->from->last_name;
$ms_id = $update->message->message_id;

// make objects...
$request = new RequestController(TOKEN); // request object
$user = new UserController($user_id); // user object

if ($user->getStatus() == 403) {
    exit;
}

// conditions...
switch ($text) {
    case '/author':
    case 'author':
        $request->sendmsg(MessageHandler::myAd());
        exit;

    case '/start':
        $user->setStatus(0);
        $request->sendmsg(MessageHandler::start(), null, KeyboardHandler::main($user->getType()));
        exit;

    case '🏡 بازگشت به خانه 🏠':
        $user->setStatus(0);
        $request->sendmsg(MessageHandler::backToHome(), null, KeyboardHandler::main($user->getType()));
        exit;

}


switch ($user->getStatus()) {
    ##################################### status 00 #####################################
    case 0:
        switch ($text) {
            case 'ثبت شماره جدید':
                if (!$user->is_admin()) {
                    $request->sendmsg(MessageHandler::wrongCommand());
                    exit;
                }
                $user->setStatus(20);
                $request->sendmsg("لطفا شماره تماس مشتری را وارد نمایید.", null, KeyboardHandler::backToHome());
                break;

            case 'ثبت کارشناس':
                if (!$user->is_admin()) {
                    $request->sendmsg(MessageHandler::wrongCommand());
                    exit;
                }
                $user->setStatus(40);
                $request->sendmsg("لطفا نام کارشناس را وارد نمایید.", null, KeyboardHandler::backToHome());
                break;

            case 'لیست کارشناس':
                if (!$user->is_admin()) {
                    $request->sendmsg(MessageHandler::wrongCommand());
                    exit;
                }

                break;

            case 'خروجی':
                if (!$user->is_admin()) {
                    $request->sendmsg(MessageHandler::wrongCommand());
                    exit;
                }
                $request->sendmsg("خروجی مشتریان");
                break;

            case 'ورودی':
                if (!$user->is_admin()) {
                    $request->sendmsg(MessageHandler::wrongCommand());
                    exit;
                }
                $user->setStatus(60);
                $request->sendmsg("فرایند ورودی لیست مشتریان", null, KeyboardHandler::removeKeyboard());
                break;

            case 'جستجو مشتری':
                if (!$user->is_admin()) {
                    $request->sendmsg(MessageHandler::wrongCommand());
                    exit;
                }
                $user->setStatus(80);
                $request->sendmsg("لطفا فیلد جستجو مورد نظر خود را انتخاب نمایید.", null, KeyboardHandler::searchFeilds());
                break;

            default:
                $request->sendmsg(MessageHandler::wrongCommand());
                break;
        }
        exit;
    ##################################### status 20 #####################################
    case 20:
        exit;
    ##################################### status 40 #####################################
    case 40:
        exit;
    ##################################### status 60 #####################################
    case 60:
        exit;
    ##################################### status 80 #####################################
    case 80:
        exit;
}
