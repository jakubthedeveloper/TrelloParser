<?php
namespace TrelloParser;

use Trello\Client;

/**
 * Class TrelloParser
 * @package TrelloParser
 */
class TrelloParser {
    /**
     * @var Client
     */
    private $client;

    /**
     * @var array
     */
    private $listNames = [];

    public function __construct($apiKey, $token)
    {
        $this->client = new Client();
        $this->client->authenticate($apiKey, $token, Client::AUTH_URL_CLIENT_ID);
    }

    /**
     * @param string $boardId
     * @param array $cardIds
     * @return array
     */
    public function getCards(string $boardId, array $cardIds)
    {
        $cards = $this->client->boards()->cards()->all($boardId);

        $cardsData = [];

        foreach ($cards as $card)
        {
            if (in_array($card['idShort'], $cardIds)) {
                $cardsData[$card['idShort']] = [
                    'id' => $card['id'],
                    'idShort' => $card['idShort'],
                    'idBoard' => $card['idBoard'],
                    'idList' => $card['idList'],
                    'dateLastActivity' => $card['dateLastActivity'],
                    'name' => $card['name'],
                    'shortUrl' => $card['shortUrl'],
                    'url' => $card['url'],
                    'listName' => $this->getListName($card['idList'])
                ];
            }
        }

        ksort($cardsData);
        return $cardsData;
    }

    /**
     * @param string $idList
     * @return mixed|string
     */
    protected function getListName(string $idList)
    {
        if (!array_key_exists($idList, $this->listNames)) {
            $list = $this->client->lists()->show($idList);

            if (!empty($list)) {
                $this->listNames[$idList] = $list['name'];
            }
        }

        return array_key_exists($idList, $this->listNames) ? $this->listNames[$idList] : 'Unknown';
    }
}
