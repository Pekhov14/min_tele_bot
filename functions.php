<?php

function keyboard() {
    var_dump($keyboard = json_encode($keyboard = ['keyboard' => [
        ['Ряд1Кнпк1','Ряд1Кнпк2'],
        ['Ряд2Кнпк1'],
        ['Ряд3Кнпк1','Ряд3Кнпк2','Ряд3Кнп3']
    ] ,
        'resize_keyboard' => true,
        'one_time_keyboard' => false,
        'selective' => true
    ]),true);

    return $keyboard;
}

function keyboard_admin() {
    $keyboard = json_encode($keyboard = ['keyboard' =>
        [
            ['Уничтожить мир','Покорить планету'],
        ] ,
        'resize_keyboard'   => true,
        'one_time_keyboard' => false,
        'selective'         => true
    ],true);
    return $keyboard;
}

function inline_keyboard() {
    $inline_button1 = [
        "text"          => "Поприветствовать",
        "callback_data" =>'/in_hello'
    ];
    $inline_button2 = [
        "text"          => "Попрощаться",
        "callback_data" =>'/in_bye'
    ];
    $inline_button3 = [
        "text" => "$100",
        "url"  => 't.me/bax_100'
    ];

    $inline_keyboard = [
        [$inline_button1],
        [$inline_button2],
        [$inline_button3]
    ];
    return json_encode(["inline_keyboard" => $inline_keyboard]);
}

function delete_keyboard()
{
    return json_encode($keyboard =  array('remove_keyboard' => true));
}

function valid() {
    $request_from_telegram = false;
    if(isset($_POST)) {
        $data = file_get_contents("php://input");
        if (json_decode($data) != null)
            $request_from_telegram = json_decode($data,1);
    }
    return $request_from_telegram;
}

function sendMessage($chat_id,$text,$markup=null)
{
    if (isset($chat_id))
    {
        $url = $GLOBALS['url'].'sendMessage?chat_id='.$chat_id.'&text='.urlencode($text).'&reply_markup='.$markup.'&parse_mode=Markdown';
        $url .= '&disable_web_page_preview=true';
        return get($url);
    }
}

function get($url)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}