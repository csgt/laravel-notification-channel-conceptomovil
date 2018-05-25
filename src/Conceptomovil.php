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
        $serviceURL      = $this->config->getAccountURL();
        $serviceUsername = $this->config->getUsername();
        $servicePassword = $this->config->getPassword();

        $params = [
            'msisdn'  => $to,
            'message' => trim($message->content),
            'user'    => $serviceUsername,
        ];

        $headers = [
            'Content-Type' => 'application/json',
        ];

        $cliente = new Client;

        $response = $cliente->request('POST', $serviceURL, [
            'auth'    => [
                $serviceUsername,
                $servicePassword,
                'basic',
            ],
            'headers' => $headers,
            'json'    => $params,
            'timeout' => 25,
            'verify'  => false,
        ]);

        $html = (string) $response->getBody();

        return json_decode($html);

    }

}
