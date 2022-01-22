<?php
// Токен бота, и айди администатора бота
define('TOKEN', '2081875841:AAHdbrbgvzpw45UUurICDETnXywMSNkVR84');
define('ADMIN_ID', '1841417011');

$data = file_get_contents('php://input');
$data = json_decode($data, true);


if (!isset($data)) {

	try {
		$str = fopen("form.txt", 'r');
		echo $str;
	} catch (Exception $e) {
		die('Не открыть( нет в директории');	
	}

	exit();
}

// Вызов к API Методам.
function sendTelegram($method, $response)
{
	$ch = curl_init('https://api.telegram.org/bot' . TOKEN . '/' . $method);  
	curl_setopt($ch, CURLOPT_POST, true);  
	curl_setopt($ch, CURLOPT_POSTFIELDS, $response);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_HEADER, false);
	$ex = curl_exec($ch);

	$fd = fopen("form.txt", 'a') or die("не удалось открыть файл");
	fwrite($fd, $ex);
	fclose($fd);


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
				'reply_markup' => array(
					'keyboard' => array(
			            array(
			                array('text' => '33', 'request_contact' => true),
			        )),
				)
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
