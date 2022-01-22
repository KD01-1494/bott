<?php
 
// Токен бота, и айди администатора бота
define('TOKEN', '2081875841:AAHdbrbgvzpw45UUurICDETnXywMSNkVR84');
define('ADMIN_ID', '1841417011');

$data = file_get_contents('php://input');
$data = json_decode($data, true);

if (!isset($data)) {
	echo 'No RooBOT!';
	exit();
}

// Кнопки
$buttons = [
	'start_buttons' => [
		['text' => 'Кнопка 1'],
		['text' => 'Кнопка 2'],
		['text' => 'Контакты'],
		['text' => 'Фото'],
	]
];

// Вызов к API Методам.
function sendTelegram($method, $response)
{
	$ch = curl_init('https://api.telegram.org/bot' . TOKEN . '/' . $method);  
	curl_setopt($ch, CURLOPT_POST, true);  
	curl_setopt($ch, CURLOPT_POSTFIELDS, $response);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HEADER, false);
	curl_exec($ch);
	curl_close($ch);
}

// Основные Команды
switch ($data['message']['text']) {
	case '/start':
		sendTelegram(
			'sendMessage', 
			[
				'chat_id' => $data['message']['chat']['id'],
				'text' => 'Что вы хотите заказать?',
				'reply_markup'  => [
					'resize_keyboard' => true,
					'keyboard' => [
						[
							['text' => 'Яблоки'],
							['text' => 'Груши'],
						],
						[
							['text' => 'Лук'],
							['text' => 'Чеснок'],
						]
					]
				]
			]
		);

	// Админ панель
	case '/admin':
		if ($data['message']['chat']['id'] != ADMIN_ID) {
		 	sendTelegram(
				'sendMessage', 
				[
					'chat_id' => $data['message']['chat']['id'],
					'text' => 'Вы не администратор!'
				]
			);
		 }
}

// // Ответ на текстовые сообщения.
// if (!empty($data['message']['text'])) {
// 	$text = $data['message']['text'];
 
// 	if (mb_stripos($text, 'привет') !== false) {
// 		sendTelegram(
// 			'sendMessage', 
// 			array(
// 				'chat_id' => $data['message']['chat']['id'],
// 				'text' => 'Хай!'
// 			)
// 		);
 
// 		exit();	
// 	} 
 
// 	// Отправка фото.
// 	if (mb_stripos($text, 'фото') !== false) {
// 		sendTelegram(
// 			'sendPhoto', 
// 			array(
// 				'chat_id' => $data['message']['chat']['id'],
// 				'photo' => curl_file_create(__DIR__ . '/torin.jpg')
// 			)
// 		);
		
// 		exit();	
// 	}
 
// 	// Отправка файла.
// 	if (mb_stripos($text, 'файл') !== false) {
// 		sendTelegram(
// 			'sendDocument', 
// 			array(
// 				'chat_id' => $data['message']['chat']['id'],
// 				'document' => curl_file_create(__DIR__ . '/example.xls')
// 			)
// 		);
 
// 		exit();	
// 	}
// }
