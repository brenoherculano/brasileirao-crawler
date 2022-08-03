<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once __DIR__.'/vendor/autoload.php';
use brasileiraoCrawler\src\Crawler;

$crawler = New Crawler();

/**
 *  @var DOMNodeList $clubsDomList
 *  @var DOMNodeList $tableHeadDomList
 */
$clubsDomList      = $crawler->getRowsDomList();
$tableHeadDomList  = $crawler->getHeadersDomList();

echo '<pre>';
var_dump($crawler->parseDomNodeList($tableHeadDomList));
exit();

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Brasileirão</title>
</head>
<body>
<h1>Tabela do Brasileirão</h1>

<table>
    <tbody>
    <tr>
        <th>Rank</th>
        <th>Clube</th>

        <?php foreach ($tableHeadDomList as $tableHead) :?>

            <?php if (!empty($tableHead->childNodes->item(1)->nodeValue)) : ?>

                <th><?= $tableHead->childNodes->item(1)->nodeValue ?></th>

            <?php endif; ?>
        <?php endforeach; ?>
    </tr>

    <?php foreach ($clubsDomList as $clubDom) : ?>

        <tr>
            <td><?= $clubDom->childNodes->item(1)->nodeValue ?></td>
            <td><?= $clubDom->childNodes->item(2)->nodeValue ?></td>
            <td><?= $clubDom->childNodes->item(3)->nodeValue ?></td>
            <td><?= $clubDom->childNodes->item(4)->nodeValue ?></td>
            <td><?= $clubDom->childNodes->item(5)->nodeValue ?></td>
            <td><?= $clubDom->childNodes->item(6)->nodeValue ?></td>
            <td><?= $clubDom->childNodes->item(7)->nodeValue ?></td>
            <td><?= $clubDom->childNodes->item(8)->nodeValue ?></td>
            <td><?= $clubDom->childNodes->item(9)->nodeValue ?></td>
            <td><?= $clubDom->childNodes->item(10)->nodeValue ?></td>
            <td><?= $clubDom->childNodes->item(11)->nodeValue ?></td>
        </tr>

    <?php endforeach; ?>

    </tbody>
</table>

</body>
</html>