<?php

/**
 * Classe que envia mensagem para um canal especifico do discord
 */
class Discord
{
    public $status = false;
    public $error;
    private $channel;
    private $discordBotToken;
    public function __construct($channel, $discordBotToken)
    {
        $this->channel = $channel;
        $this->discordBotToken = $discordBotToken;
    }

    /**
     * Envia mensagem para um canal especifico do discord
     *
     * @param string $message
     * @return void
     */
    public function sendMessage($message)
    {
        if(empty($message)) {
            $this->error = 'Menssagem não informada';
            return;
        }
        $curl = curl_init();

        $message = '{
            "content": "' . $message . '"
        }';

        $arrHeader = array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($message),
            'Authorization: Bot ' . $this->discordBotToken,
        );

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://discordapp.com/api/v6/channels/' . $this->channel . '/messages',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => $message,
            CURLOPT_HTTPHEADER => $arrHeader,
        ));

        $response = curl_exec($curl);
        $response = json_decode($response, true);
        if(array_key_exists('code', $response)) {
            $this->error = $response['message'];
            return;
        }
        curl_close($curl);
        $this->status = true;
    }
}
