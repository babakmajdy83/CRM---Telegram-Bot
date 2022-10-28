<?php

class MessageHandler
{
    public static function myAd($type): string
    {
        return "👨‍💻 برنامه نویس: بابک مجدی
🆔 @babakmajdy
📞  09152425332
🔗 <a href='https://zil.ink/babakmajdy'>zil.ink/babakmajdy</a>";
    }

    public static function start(): string
    {
        return "سلام! خوشومدی به ربات 😎";
    }

    public static function backToHome(): string
    {
        return "به خانه بازگشتید.";
    }

    public static function wrongCommand(): string
    {
        return "دستور ارسالی صحیح نمی‌باشد.";
    }

}
