<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__.'/vendor/autoload.php';

use brasileiraoCrawler\src\BrasileiraoData;

$brBot = New BrasileiraoData();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        body {
            text-align: center;
        }
    </style>
    <title>Brasileirão</title>
</head>
<body>
<h1>Tabela do Brasileirão</h1>

<table>
    <tbody>
    <tr>
        <?php foreach ($brBot->getBrasileiraoHeaders(true) as $tableHead) :?>

            <th><?= $tableHead ?></th>

        <?php endforeach; ?>
    </tr>

    <?php foreach ($brBot->getBrasileiraoClubsRows() as $clubDataRow) : ?>
        <tr>
            <?php foreach ($clubDataRow as $clubDataItem) : ?>

                <td><?= $clubDataItem ?></td>

            <?php endforeach; ?>
        </tr>
    <?php endforeach; ?>

    </tbody>
</table>

</body>
</html>