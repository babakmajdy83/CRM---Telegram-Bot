<?php
$request = new requestController(TOKEN); // request object
$ms_id = $update->callback_query->message->message_id;
$chat_id = $update->callback_query->message->chat->id;
$user_id = $chat_id;
$user = new USER($chat_id); // user object
$status = $user->getStatus();
$encoded_data = $update->callback_query->data;
$data = explode("-", $update->callback_query->data);
if ($encoded_data == "CardToCard-reg" || $encoded_data == "CardToCard-force") {
    $request->delmsg($chat_id, $ms_id);
    $res = $encoded_data == "CardToCard-reg" ? CardToCardText_reg : CardToCardText_force;
    if ($status == 32) {
        if ($user->getLastSellAd()->status != "checking") {
            $request->sendmsg("تراکنش امکان پذیر نمی‌باشد!", $chat_id);
            exit;
        }
        $request->sendmsg($res, $chat_id, "BackToHome");
        $user->updateSellAd("status", "ctc");
        if ($encoded_data == "CardToCard-force") {
            $user->updateSellAd("is_force", 1);
        }
        $user->setStatus(80);
    } elseif ($status == 43) {
        if ($user->getLastBuyAd()->status != "checking") {
            $request->sendmsg("تراکنش امکان پذیر نمی‌باشد!", $chat_id);
            exit;
        }
        $request->sendmsg($res, $chat_id, "BackToHome");
        $user->updateBuyAd("status", "ctc");
        if ($encoded_data == "CardToCard-force") {
            $user->updateBuyAd("is_force", 1);
        }
        $user->setStatus(81);
    } elseif ($status != 80 && $status != 81 && $status != 82 && $status != 83) {
        $request->editmsg("تراکنش امکان پذیر نمی‌باشد!", $chat_id, $ms_id);
    }
    exit;
} elseif ($encoded_data == "joined") {
    if ((!$user->in_channel(ChannelToJoin1, $user_id) || !$user->in_channel(ChannelToJoin2, $user_id)) && !$is_admin) {
        $request->sendmsg("1️⃣  لطفا ابتدا در کانال های زیر عضو شوید.", null, "joinToCh");
    } else {
        $request->delmsg($chat_id, $ms_id);
        $request->sendmsg("💝 به ربات ثبت آگهی چنل گلکسی کد خوش آمدید", null, 'main');
    }
}
switch ($data[0]) {
    case 'yes':
        if ($data[1] == "sell") {
            $sell_ad = $user->getSellAd($data[2]);
            if ($sell_ad->status == "payed") {
                $res = $request->delmsg($chat_id, $ms_id);
                exit;
            }
            $user->updateSellAd("status", "payed", $sell_ad->id);
            $type = "sell";
            $ad_id = $sell_ad->id;
            $ad_uid = "#S" . $sell_ad->id;
            $owner = $sell_ad->owner;
            $is_force = $sell_ad->is_force;
            $res = $request->delmsg($chat_id, $ms_id);
        } elseif ($data[1] == "buy") {
            $buy_ad = $user->getBuyAd($data[2]);
            if ($buy_ad->status == "payed") {
                $res = $request->delmsg($chat_id, $ms_id);
                exit;
            }
            $user->updateBuyAd("status", "payed", $buy_ad->id);
            $type = "buy";
            $is_force = $buy_ad->is_force;
            $owner = $buy_ad->owner;
            $ad_id = $buy_ad->id;
            $ad_uid = "#B" . $buy_ad->id;
            $request->delmsg($chat_id, $ms_id);
        }

        if ($is_force == 1) {
            $request->sendmsg("فیش واریزی شما مبنی بر <b><u>ثبت آگهی فوری</u></b> ⏰ تایید شد ✅", $owner);
            $res = $user->publishAd($ad_id, $type);
            exit;
        }
        $request->sendmsg("فیش واریزی شما مبنی بر <b><u>ثبت آگهی اسرع وقت</u></b>⏳ تایید شد ✅", $owner);
        $user->insertQueue($ad_id, $owner, $type);
        exit;
    case 'no':
        if ($data[1] == "sell") {
            $sell_ad = $user->getSellAd($data[2]);
            $ad_uid = "#S" . $sell_ad->id;
            $owner = $sell_ad->owner;
            $user->deleteSell($sell_ad->id);
            $request->delmsg($chat_id, $ms_id);
        } elseif ($data[1] == "buy") {
            $buy_ad = $user->getBuyAd($data[2]);
            $ad_uid = "#B" . $buy_ad->id;
            $owner = $buy_ad->owner;
            $user->deleteBuy($buy_ad->id);
            $request->delmsg($chat_id, $ms_id);
        }
        $request->sendmsg("دوست عزیز عکس فیش واریزی شما مورد تایید قرار نگرفت❌
به دلایل زیر :
⭕️ فیک بودن رسید.
⭕️ عکس ارسالی رسید نبوده است.
⭕️ و ...", $owner);
        exit;
    case "check":
        if ($data[1] == "ok") {
            $res = "1- ثبت آگهی <b><u>طرح اسرع وقت</u> ⏳ | " . ProductPriceT . " 💰</b>
بعد از ثبت آگهی و‌ عملیات پرداخت حدود 4 الی 14 ساعت ثبت آگهی شما بطول می انجامد ✔️

2- ثبت آگهی <b><u>طرح فوری</u> ⏰ | " . ForceProductPriceT . " 💰</b>
بعد از ثبت آگهی و‌ عملیات پرداخت آگهی شما بصورت فوری و هیچ معطلی داخل چنل گلکسی کد قرار میگیرد ✔️";
            if ($status == 31) {
                $request->delmsg($chat_id, $ms_id);
                $request->sendmsg($res, null, "pub_type");
            } elseif ($status == 42) {
                $request->editmsg($res, $chat_id, $ms_id, "pub_type");
            } else {
                $request->delmsg($chat_id, $ms_id);
            }
            exit;
        } elseif ($data[1] == "fail") {
            if ($status == 31) {
                $user->deleteSell();
            } elseif ($status == 42) {
                $user->deleteBuy();
            }
            $user->setStatus(0);
            $request->delmsg($chat_id, $ms_id);
            $request->sendmsg("اگهی شما حذف شد. به صفحه اصلی برمی‌گردید.", null, "main");
            exit;
        }
        exit;
    case "submit":
        if ($status != 31 && $status != 42) {
            $request->delmsg($chat_id, $ms_id);
            exit;
        }
        if ($data[1] == "force") {
            if (ForceProductPrice == 0) {
                if ($status == 31) {
                    $ad_id = $user->getLastSellAd()->id;
                    $user->updateSellAd("status", "payed");
                    $user->publishAd($ad_id, "sell");
                } elseif ($status == 42) {
                    $user->updateBuyAd("status", "payed");
                    $ad_id = $user->getLastBuyAd()->id;
                    $user->publishAd($ad_id, "buy");
                }

                $request->delmsg($chat_id, $ms_id);
                $user->setStatus(0);
                $request->sendmsg("آگهی شما منتشر شد.", null, "main");
                exit;
            }
            $request->editmsg("لطفا نحوه عملیات پرداخت خود جهت <b><u>ثبت آگهی فوری</u></b> ⏰ انتخاب نمایید.", $chat_id, $ms_id, "buyOps-force");
        } elseif ($data[1] == "reg") {
            if (ProductPrice == 0) {
                if ($status == 31) {
                    $ad_id = $user->getLastSellAd()->id;
                    $user->updateSellAd("status", "payed");
                    $user->insertQueue($ad_id, $user_id, "sell");
                } elseif ($status == 42) {
                    $ad_id = $user->getLastBuyAd()->id;
                    $user->updateBuyAd("status", "payed");
                    $user->insertQueue($ad_id, $user_id, "buy");
                }

                $request->delmsg($chat_id, $ms_id);
                $user->setStatus(0);
                $request->sendmsg("آگهی شما ثبت شد و در اسرع وقت منتشر خواهد شد.", null, "main");
                exit;
            }
            $request->editmsg("لطفا نحوه عملیات پرداخت خود جهت ثبت <b><u>ثبت آگهی اسرع وقت</u></b> ⏳ انتخاب نمایید.", $chat_id, $ms_id, "buyOps");
        }

        if ($status == 31) {
            $user->setStatus(32);
        } elseif ($status == 42) {
            $user->setStatus(43);
        }
        exit;
    case "Ref":
        $price = intval($data[1]);
        $coins = $user->getCoins();
        if ($status == 32) {
            if ($data[2] == "force") {
                $user->updateSellAd("is_force", 1);
            }
            $sell_ad = $user->getLastSellAd();
            if ($sell_ad->status != "checking") {
                $request->sendmsg("عملیات امکان پذیر نمی‌باشد!", $chat_id, "main");
                $user->setStatus(0);
                exit;
            } elseif ($coins >= $price) {
                $user->updateSellAd("status", "payed");
                $type = "sell";
                $ad_id = $sell_ad->id;
                $ad_uid = "#S" . $sell_ad->id;
                $owner = $sell_ad->owner;
                $is_force = $sell_ad->is_force;
            } else {
                $user->insertWait($sell_ad->id, "sell", $price);
                $user->updateSellAd("status", "coins");
                $request->delmsg($chat_id, $ms_id);
                $request->sendmsg("تعداد افراد دعوت شده توسط شما، به حد نصاب نرسیده است. با این لینک دوستان خود را دعوت کنید و پس از ب حد نصاب رسیدن تعداد افراد، آگهی شما به صورت خودکار ثبت خواهد شد و به شمااطلاع داده خواهد شد.\n\nhttp://t.me/Galaxy_Ad_Bot?start={$user->getId()}", $chat_id, "main");
                $user->setStatus(0);
                exit;
            }
        } elseif ($status == 43) {
            if ($data[2] == "force") {
                $user->updateBuyAd("is_force", 1);
            }
            $buy_ad = $user->getLastBuyAd();
            if ($buy_ad->status != "checking") {
                $request->sendmsg("عملیات امکان پذیر نمی‌باشد!", $chat_id, "main");
                $user->setStatus(0);
                exit;
            } elseif ($coins >= $price) {
                $user->updateBuyAd("status", "payed");
                $type = "buy";
                $is_force = $buy_ad->is_force;
                $owner = $buy_ad->owner;
                $ad_id = $buy_ad->id;
                $ad_uid = "#B" . $buy_ad->id;
            } else {
                $user->insertWait($buy_ad->id, "buy", $price);
                $user->updateBuyAd("status", "coins");
                $request->delmsg($chat_id, $ms_id);
                $request->sendmsg("تعداد افراد دعوت شده توسط شما، به حد نصاب نرسیده است. با این لینک دوستان خود را دعوت کنید و پس از به حد نصاب رسیدن تعداد افراد، آگهی شما به صورت خودکار ثبت خواهد شد و به شمااطلاع داده خواهد شد.\n\nhttp://t.me/Galaxy_Ad_Bot?start={$user->getId()}", $chat_id, "main");
                $user->setStatus(0);

                exit;
            }
        } else {
            $request->delmsg($chat_id, $ms_id);
            $request->sendmsg("عملیات امکان پذیر نمی‌باشد!", $chat_id, "main");
            $user->setStatus(0);
            exit;
        }

        $user->updateUser("coins", $coins - $price);
        if ($is_force == 1) {
            $request->sendmsg("آگهی شما با کد یکتای <b>$ad_uid</b> منتشر شد! ✅");
            $res = $user->publishAd($ad_id, $type);
            exit;
        }
        $request->sendmsg("آگهی شما با کد یکتای <b>$ad_uid</b> در صف انتشار قرار گرفت ✅");
        $user->insertQueue($ad_id, $owner, $type);
        exit;
}
