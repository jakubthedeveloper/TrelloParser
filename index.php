<?php
define('DIR_VENDOR', __DIR__.'/vendor/');

if (file_exists(DIR_VENDOR . 'autoload.php')) {
    require_once(DIR_VENDOR . 'autoload.php');
}

use TrelloParser\TrelloParser;
use Dotenv\Dotenv;

$dotenv = Dotenv::create(__DIR__);
$dotenv->load();

$apiKey = getenv('API_KEY');
$token = getenv('TOKEN');
$boardId = getenv('BOARD_ID');
$cardIds = explode(',', getenv('CARD_IDS'));

$parser = new TrelloParser($apiKey, $token);
$data = $parser->getCards($boardId, $cardIds);

//print_r($data);

?>

<html lang="en-US">
<head>
    <meta charset="utf-8">

    <style type="text/css">
        th, td {
            text-align: left;
            padding: 4px;
            margin: 4px;
            border-bottom: 1px solid #d4d3d7;
        }
    </style>
</head>

<body>
    <table cellspacing="0" cellpadding="0">
        <tr>
            <th>Task number</th>
            <th>Task</th>
            <th>Trello column</th>
        </tr>

        <?php foreach ($data as $row): ?>
        <tr>
            <td><?= $row['idShort']; ?></td>
            <td>
                <a href="<?= $row['url']; ?>" target="_blank"><?= $row['name']; ?></a>
            </td>
            <td>
                <?= $row['listName']; ?>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>