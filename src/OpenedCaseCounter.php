<?php declare(strict_types = 1);

namespace TemKaa1337\CSGOCasesCalculator;

use TemKaa1337\CSGOCasesCalculator\JsVariableParser;
use GuzzleHttp\Client;

class OpenedCaseCounter
{
    public function __construct(
        private readonly string $cookie, 
        private readonly string $savePath
    ) {}

    public function calculate(): void
    {
        $i = 1;
        $client = new Client([
            'headers' => [
                'Cookie' => $this->cookie,
                'User-Agent' => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36"
            ]
        ]);
        $response = $client->request('GET', 'https://steamcommunity.com/id/temkaa/inventoryhistory/', [
            'app[]' => 730
        ]);
        $html = $response->getBody()->getContents();
        file_put_contents($this->savePath.'result1.txt', $html);
        $variableParser = new JsVariableParser(
            html: $html, 
            variableName: 'g_sessionID', 
            replaceCharacters: ['"']
        );
        $sessionId = $variableParser->parse();

        $variableParser = new JsVariableParser(
            html: $html, 
            variableName: 'g_historyCursor'
        );
        $cursor = $variableParser->parse();

        while ($i < 4) {
            $client = new Client([
                'headers' => [
                    'Cookie' => $this->cookie,
                    'User-Agent' => "Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/103.0.0.0 Safari/537.36"
                ]
            ]);
            $response = $client->request('GET', 'https://steamcommunity.com/id/temkaa/inventoryhistory/', [
                'ajax' => '1',
                'cursor' => $cursor,
                'sessionid' => $sessionId,
                'app[]' => 730
            ]);
            $responseBody = $response->getBody();
            var_dump($responseBody);
            die();
        }
    }
}