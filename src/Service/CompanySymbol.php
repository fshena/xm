<?php declare(strict_types=1);

namespace App\Service;

use League\Csv\Reader;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7;
use League\Csv\Statement;
use Psr\Http\Message\StreamInterface;

class CompanySymbol
{
    private $rootDir;

    private $client;

    /**
     * CompanySymbol constructor.
     *
     * @param $rootDir
     */
    public function __construct($rootDir)
    {
        $this->rootDir = $rootDir;
        $this->client  = new Client([
            'base_uri' => 'https://www.quandl.com',
        ]);
    }

    /**
     * Check that the provided symbol is part of the available symbols located in the "companylist.csv" file.
     *
     * @param $symbol
     *
     * @return bool
     */
    public function isValidSymbol($symbol): bool
    {
        $symbols = $this->readCompanySymbols();

        return strpos($symbols, mb_strtoupper($symbol)) !== false;
    }

    /**
     * Read csv file and return values as string.
     *
     * @param string $path
     *
     * @return string
     */
    public function readCompanySymbols($path = 'companyList.csv'): string
    {
        $csv = Reader::createFromPath($this->rootDir . '/' . $path, 'r');

        return $csv->getContent();
    }


    /**
     * Make an api request with the given company symbol and date range.
     *
     * @param $symbol
     * @param $startDate
     * @param $endDate
     *
     * @return array
     */
    public function getDataForSymbol($symbol, $startDate, $endDate)
    {
        $data = [];

        try {
            $response = $this->client->request('GET', "/api/v3/datasets/WIKI/{$symbol}.csv", [
                'query' => [
                    'order'      => 'asc',
                    'start_date' => $startDate,
                    'end_date'   => $endDate,
                ],
            ]);

            $stream        = Psr7\stream_for($response->getBody());
            $data['table'] = iterator_to_array(Reader::createFromString($stream->getContents())->getRecords());
            $data['chart'] = $this->formatData($data['table']);
        } catch (\GuzzleHttp\Exception\GuzzleException $exception) {
        }

        return $data;
    }

    private function formatData($data)
    {
        $headers       = [];
        $dateOpenData  = [];
        $dateCloseData = [];

        foreach ($data as $key => $row) {
            if ($key === 0) {
                $headers[] = array_values($row);
                continue;
            }
            // data for chart
            $time = strtotime($row[0]) * 1000;
            $dateOpenData[]  = [$time, (float) $row[1]];
            $dateCloseData[] = [$time, (float) $row[4]];
        }

        return [
            'dateOpen'  => $dateOpenData,
            'dateClose' => $dateCloseData,
        ];
    }
}
