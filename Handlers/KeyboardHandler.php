<?php

class KeyboardHandler
{
    public static function main($type): array
    {
        switch ($type) {
            case 'operator':
                return ['reply_markup' => [
                    'resize_keyboard' => true,
                    'keyboard' => [
                        [
                            'ثبت شماره جدید'
                        ],
                        [
                            'لیست کارشناس', 'ثبت کارشناس'
                        ],
                        [
                            'ورودی', 'خروجی'
                        ],
                        [
                            'جستجو مشتری'
                        ]
                    ]
                ]];

            case 'expert':
                return ['reply_markup' => [
                    'resize_keyboard' => true,
                    'keyboard' => [
                        [
                            'لیست تماس های من'
                        ]
                    ]
                ]];

            default:
                return [];


        }
    }

    public static function backToHome(): array
    {
        return ['reply_markup' => [
            "resize_keyboard" => true,
            'keyboard' => [
                ['🏡 بازگشت به خانه 🏠']
            ]
        ]];
    }

    public static function searchFeilds(): array
    {
        return ['reply_markup' => [
            "resize_keyboard" => true,
            'keyboard' => [
                ['نام', 'شماره تماس'],
                ['شهر', 'کارشناس']
            ]
        ]];
    }

    public static function removeKeyboard(): array
    {
        return ['reply_markup' => [
            "remove_keyboard" => true,
        ]];
    }

}
