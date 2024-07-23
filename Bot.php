<?php
namespace Core;

class Bot {
    private $config;
    private $players = null;

    public function __construct($config) {
        $this->config = $config;
    }

    public function getApiUrl() {
        return "https://api.telegram.org/bot" . $this->config['bot_token'];
    }

    public function sendMessage($chatId, $response) {
        $url = $this->getApiUrl() . "/sendMessage";
        $data = [
            'chat_id' => $chatId,
            'text' => is_array($response) ? $response['text'] : $response,
            'parse_mode' => 'HTML'
        ];

        if (is_array($response) && isset($response['reply_markup'])) {
            $data['reply_markup'] = $response['reply_markup'];
        }

        $options = [
            'http' => [
                'method' => 'POST',
                'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
                'content' => http_build_query($data)
            ]
        ];
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        return $result;
    }

    public function loadPlayers() {
        if ($this->players === null) {
            $playersFile = $this->config['players_file'];
            if (!file_exists($playersFile)) {
                $this->players = [];
            } else {
                $content = file_get_contents($playersFile);
                $this->players = json_decode($content, true) ?: [];
            }
        }
        return $this->players;
    }

    public function savePlayers() {
        $playersFile = $this->config['players_file'];
        $content = json_encode($this->players, JSON_PRETTY_PRINT);
        file_put_contents($playersFile, $content);
    }

    public function getPlayer($userId) {
        $this->loadPlayers();
        return $this->players[$userId] ?? null;
    }

    public function updatePlayer($userId, $playerData) {
        $this->loadPlayers();
        $this->players[$userId] = $playerData;
        $this->savePlayers();
    }

    public function setWebhook($url) {
        $apiUrl = $this->getApiUrl() . "/setWebhook?url=" . urlencode($url);
        $result = file_get_contents($apiUrl);
        return json_decode($result, true);
    }

    public function getWebhookInfo() {
        $apiUrl = $this->getApiUrl() . "/getWebhookInfo";
        $result = file_get_contents($apiUrl);
        return json_decode($result, true);
    }

    public function answerCallbackQuery($callbackQueryId, $text = '', $showAlert = false) {
        $url = $this->getApiUrl() . "/answerCallbackQuery";
        $data = [
            'callback_query_id' => $callbackQueryId,
            'text' => $text,
            'show_alert' => $showAlert
        ];

        $options = [
            'http' => [
                'method' => 'POST',
                'header' => "Content-Type: application/x-www-form-urlencoded\r\n",
                'content' => http_build_query($data)
            ]
        ];
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        return $result;
    }
}
