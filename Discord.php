<?php

/**
 * Classe que envia mensagem para um canal especifico do discord
 */
class Discord
{
    private $status = false;
    private $error;
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
        $curl = curl_init();

        $message = '{
            "content": "**Lista de Web Services travados**"
        }';

        $arrHeader = array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($message),
            'Authorization: Bot ' . $this->discordBotToken,
        );

        // echo $message;
        // exit;
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
        curl_close($curl);
        echo '<pre>';
        var_dump($response);
        $this->status = true;
    }
}
