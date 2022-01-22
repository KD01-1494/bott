require_once "vendor/autoload.php";

// Токен бота, и айди администатора бота
define('TOKEN', '2081875841:AAHdbrbgvzpw45UUurICDETnXywMSNkVR84');
define('ADMIN_ID', '1841417011');

$bot = new \TelegramBot\Api\Client(TOKEN);

// команда для start
$bot->command('start', function ($message) use ($bot) {
    $answer = 'Добро пожаловать!';
    $bot->sendMessage($message->getChat()->getId(), $answer);
});

// команда для помощи
$bot->command('help', function ($message) use ($bot) {
    $answer = 'Команды:
/help - вывод справки';
    $bot->sendMessage($message->getChat()->getId(), $answer);
});

$bot->run();
