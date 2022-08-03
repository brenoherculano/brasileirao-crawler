<?php

namespace brasileiraoCrawler\src;

use DOMDocument;
use DOMNodeList;
use DOMXPath;

// TODO: Duas colunas do header estão vindo vazias (Rank e Clube, provalvelmente problema com childNodes no Xpath)
// TODO: Gerar arrays com os dados para serem retornadas

/**
 *  Classe responsável por consumir e retornar os dasdos da tabela do brasileirão
 */
class Crawler
{
    protected const REQUEST_URL = 'https://www.google.com/async/lr_lg_fp?ei=PFTYYuaiMJCb5OUPt9WYkA8&client=opera-gx&yv=3&q=lg|/g/11sfc7_5p3|st|fp&ved=1t:65909&cs=1&async=sp:2,lmid:/m/0fnk7q,tab:st,emid:/g/11sfc7_5p3,rbpt:undefined,ct:,hl:pt-BR,tz:America/Fortaleza,dtoint:2022-07-20T23:30:00Z,dtointmid:/g/11sfc7_5p3,efpri:,_id:liveresults-sports-immersive__league-fullpage,_pms:s,_fmt:pc';
    protected const TABLE_HEADERS_XPATH = './/tr/th/div';
    protected const TABLE_ROWS_XPATH = './/tr[@class="imso-loa imso-hov"]';

    public DOMNodeList $rowsDomList;
    public DOMNodeList $headersDomList;

    public function __construct()
    {
        $fullPageHtml = $this->doNewRequest();

        $document = new DOMDocument();
        libxml_use_internal_errors(true);
        $document->loadHTML($fullPageHtml);
        libxml_use_internal_errors(false);

        $xpath = new DOMXPath($document);

        $this->headersDomList = $xpath->query(self::TABLE_HEADERS_XPATH);
        $this->rowsDomList    = $xpath->query(self::TABLE_ROWS_XPATH);
    }

    /**
     * @return bool|string
     */
    protected function doNewRequest(): bool|string
    {
        if (!empty(self::REQUEST_URL)) {
            $html = file_get_contents(self::REQUEST_URL);

            if (!empty($html)) {
                return $html;
            }

            exit('NOTHING ON RESPONSE');
        }

        exit('MISSING REQUEST URL');
    }

    /**
     * @return DOMNodeList|false
     */
    public function getHeadersDomList(): DOMNodeList|bool
    {
        return $this->headersDomList;
    }

    /**
     * @return DOMNodeList|false
     */
    public function getRowsDomList(): DOMNodeList|bool
    {
        return $this->rowsDomList;
    }

    /**
     * @param DOMNodeList $DOMNodeList
     * @param bool $checkMultipleChildNodes
     * @return array
     */
    public function parseDomNodeList(DOMNodeList $DOMNodeList, bool $checkMultipleChildNodes = true): array
    {
        $nodeValues = [];
        $nodeList = $DOMNodeList;

        for ($i = 0; $i < $nodeList->count(); $i++) {
            $nodeValue = trim($nodeList->item($i)->childNodes->item(0)->nodeValue);

            if (($checkMultipleChildNodes === true) && $nodeList->item($i)->childNodes->count() > 1) {
                $nodeValue = [];

                for ($x = 0; $x < $nodeList->item($i)->childNodes->count(); $x++) {
                    if (!empty($nodeList->item($i)->childNodes->item($x)->nodeValue)) {
                        $nodeValue[] = trim($nodeList->item($i)->childNodes->item($x)->nodeValue);
                    }
                }
            }

            if (!empty($nodeValue)) {
                $nodeValues[] = $nodeValue;
            }
        }

        return $nodeValues;
    }
}