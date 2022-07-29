<?php

// TODO: Duas colunas do header estão vindo vazias (Rank e Clube, provalvelmente problema com childNodes no Xpath)
// TODO: Gerar arrays com os dados para serem retornadas

$fullPageHtml = file_get_contents('https://www.google.com/async/lr_lg_fp?ei=PFTYYuaiMJCb5OUPt9WYkA8&client=opera-gx&yv=3&q=lg|/g/11sfc7_5p3|st|fp&ved=1t:65909&cs=1&async=sp:2,lmid:/m/0fnk7q,tab:st,emid:/g/11sfc7_5p3,rbpt:undefined,ct:,hl:pt-BR,tz:America/Fortaleza,dtoint:2022-07-20T23:30:00Z,dtointmid:/g/11sfc7_5p3,efpri:,_id:liveresults-sports-immersive__league-fullpage,_pms:s,_fmt:pc');

$document = new DOMDocument();
$document->loadHTML($fullPageHtml);

$xpath = new DOMXPath($document);

/**
 *  @var DOMNode $clubsDomList
 *  @var DOMNode $tableHeadDomList
 */
$clubsDomList      = $xpath->query('.//tr[@class="imso-loa imso-hov"]');
$tableHeadDomList  = $xpath->query('.//tr/th/div');

/** @var DOMNode $tableHead */
foreach ($tableHeadDomList as $tableHead) {
    echo $tableHead->childNodes->item(1)->nodeValue.'<br>';
}

echo '<br>';

/** @var DOMNode $clubDom */
foreach ($clubsDomList as $clubDom) {
    echo $clubDom->childNodes->item(1)->nodeValue.'<br>';
}
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