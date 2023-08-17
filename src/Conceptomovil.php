<?php
namespace NotificationChannels\Conceptomovil;

use GuzzleHttp\Client;

class Conceptomovil
{
    /**
     * @var ConceptomovilConfig
     */
    private $config;

    /**
     * Conceptomovil constructor.
     *
     * @param ConceptomovilConfig   $config
     */
    public function __construct(ConceptomovilConfig $config)
    {
        $this->config = $config;
    }

    /**
     * Send an sms message using the Conceptomovil Service.
     *
     * @param ConceptomovilMessage $message
     * @param string           $to
     * @return \Conceptomovil\MessageInstance
     */
    public function sendMessage(ConceptomovilMessage $message, $to)
    {
        $serviceURL     = $this->config->getAccountURL();
        $serviceToken   = $this->config->getToken();
        $serviceApiKey  = $this->config->getApiKey();
        $serviceCountry = $this->config->getCountry();
        $serviceDial    = $this->config->getDial();
        $serviceTag     = $this->config->getTag();

        $headers = [
            'Content-Type'  => 'application/json',
            'Authorization' => $serviceToken,
        ];

        $params = [
            'apiKey'  => $serviceApiKey,
            'country' => $serviceCountry,
            'dial'    => $serviceDial,
            'message' => trim($message->content),
            'msisdns' => [$to],
            'tag'     => $serviceTag,
        ];

        $cliente = new Client;

        $response = $cliente->request('POST', $serviceURL, [
            'headers' => $headers,
            'body'    => $params,
            'timeout' => 25,
            'verify'  => false,
        ]);

        $html = (string) $response->getBody();

        return json_decode($html);

    }

}
