<?php
define('DIR_VENDOR', __DIR__.'/vendor/');

if (file_exists(DIR_VENDOR . 'autoload.php')) {
    require_once(DIR_VENDOR . 'autoload.php');
}

use TrelloParser\TrelloParser;
use Dotenv\Dotenv;
use Carbon\Carbon;

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
    <link href="https://fonts.googleapis.com/css?family=Lato&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-latest.min.js"></script>
    <script src="jquery.tablesort.min.js"></script>

    <style type="text/css">
        * {
            font-family: 'Lato', sans-serif;
        }

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
        <thead>
            <tr>
                <th>Task number</th>
                <th>Task</th>
                <th>Trello column</th>
                <th>Last activity</th>
            </tr>
        </thead>

        <tbody>
            <?php foreach ($data as $row): ?>
            <tr>
                <td><?= $row['idShort']; ?></td>
                <td>
                    <a href="<?= $row['url']; ?>" target="_blank"><?= $row['name']; ?></a>
                </td>
                <td>
                    <?= $row['listName']; ?>
                </td>
                <td>
                    <?= (new Carbon($row['dateLastActivity']))->longAbsoluteDiffForHumans(Carbon::now()); ?> ago
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <script type="text/javascript">
        $(function() {
            $('table').tablesort();
        });
    </script>
</body>
