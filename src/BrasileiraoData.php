<?php

namespace brasileiraoCrawler\src;

/**
 * Classe responsável por processar os dados e fornecer métodos mais "user friendly"
 */
class BrasileiraoData extends Crawler
{
    protected array $parsedHeaders;

    protected array $parsedHeadersWithChilds;

    protected array $parsedRows;


    public function __construct()
    {
        parent::__construct();

        $this->parsedHeaders = $this->parseDomNodeList($this->getHeadersDomList(), false);
        $this->parsedHeadersWithChilds = $this->parseDomNodeList($this->getHeadersDomList());
        $this->parsedRows = $this->parseDomNodeList($this->getRowsDomList());
    }
    /**
     * @param bool $fullNameHeaders
     * @return array
     */
    public function getBrasileiraoFullData(bool $fullNameHeaders = true): array
    {
        $championshipData = [];

        foreach ($this->getBrasileiraoClubsRows() as $clubDataRow) {
            $championshipData[] = array_combine($this->getBrasileiraoHeaders($fullNameHeaders), $clubDataRow);
        }

        return $championshipData;
    }

    /**
     * @param bool $fullName
     * @return array
     */
    public function getBrasileiraoHeaders(bool $fullName = false): array
    {
        if ($fullName) {
            $headers = [];

            foreach ($this->parsedHeadersWithChilds as $value) {
                if (!is_array($value)) {
                    $headers[] = $value;
                    continue;
                }

                $headers[] = end($value);
            }

            return $headers;
        }

        return $this->parsedHeaders;
    }

    /**
     * @return array
     */
    public function getBrasileiraoClubsRows(): array
    {
        return $this->parsedRows;
    }
}