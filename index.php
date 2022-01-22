<?php
 
// Токен бота, и айди администатора бота
define('TOKEN', '5111256792:AAE8jVOPJ5rYzGV1ERqyZCeLlNhVZQe6JxY');
define('ADMIN_ID', '1841417011');

$data = file_get_contents('php://input');
$data = json_decode($data, true);

if (!isset($data)) {
	echo 'No Robot!';
	exit();
}

// Кнопки
$buttons = [
	'start_buttons' => [
		'Кнопка 1',
		'Кнопка 2',
		'Контакты', 
		'Фото'
		],

	'admin_buttons' => [
		'Заменить кнопку в Пользовательсом меню',
		'Добавить фото в слайдер'
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
	$res = curl_exec($ch);
	curl_close($ch);
}

// Основные Команды
switch ($data['message']['text']) {
	case '/start':
		sendTelegram(
			'sendMessage', 
			[
				'chat_id' => $data['message']['chat']['id'],
				'text' => 'Хай!'

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
