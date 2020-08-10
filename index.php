<?php
ini_set('log_errors', 'On');
ini_set('error_log', 'php_errors.log');

require_once __DIR__ . '/config.php';
require_once __DIR__ . '/functions.php';

echo get($url . 'setWebhook?url=' . $webhook);

if (($json = valid()) === true) {
    echo "Hi =)";
    exit();
}

$uid = $json['message']['from']['id'];

$first_name = $json['message']['from']['first_name'];

$ANSWER = "Салют, ".$first_name;

$text = $json['message']['text'];

$keyboard = '';

if ($json['callback_query']) {
    $callback_data = $json['callback_query']['data'];
    $uid = $json['callback_query']['message']['chat']['id'];
}

switch($text){
    case '/help':
        $ANSWER = "Добро пожаловать в раздел Помощи! " . $uid;
        $keyboard = keyboard();
        break;
    case '/reset':
        $ANSWER = "Клавиатура сброшена!";
        $keyboard = delete_keyboard();
        break;
    case ($text === '/admin' && $uid === ID_ADMIN):
        $ANSWER = 'Здравствуй, администратор!';
        $keyboard = keyboard_admin();
        break;
    case '/byby':
        $ANSWER = "[До встречи! 😊](https://telegra.ph/Kuda-mozhno-vlozhit-5-chtoby-poluchit-pribyl-11-03)";
        break;
    case '/test':
        $ANSWER = "Моя первая inline клавиатура, зацени)";
        $keyboard = inline_keyboard();
        break;
    case '/start':
        $ANSWER  = 'Список комманд для бота:';
        $ANSWER .= "\n/start";
        $ANSWER .= "\n/help";
        $ANSWER .= "\n/byby";
        $ANSWER .= "\n/reset";
        $ANSWER .= "\n/test";
        break;
}

switch ($callback_data){
    case '/in_hello':
        $ANSWER   = "Сработала кнопка приветствия!";
        $keyboard = delete_keyboard();
        break;
    case '/in_bye':
        $ANSWER   = "Сработала кнопка прощания!";
        $keyboard = delete_keyboard();
        break;
}

sendMessage($uid,$ANSWER, $keyboard);
