<?php
namespace NotificationChannels\Conceptomovil;

use GuzzleHttp\Psr7;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use NotificationChannels\Conceptomovil\Exceptions\CouldNotSendNotification;

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
        $serviceUsername = $this->config->getUsername();
        $servicePassword = $this->config->getPassword();
        $auth            = base64_encode($serviceUsername . ':' . $servicePassword);

        $params = [
            'msisdn'  => $to,
            'message' => trim(urlencode($message->content)),
            'user'    => $serviceUsername,
        ];

        $headers = [
            'authorization' => $auth,
        ];

        if (!$serviceURL = $this->config->getAccountURL()) {
            throw CouldNotSendNotification::missingURL();
        }

        $cliente = new Client;
        try {
            $response = $cliente->request('POST', $serviceURL, [
                'headers' => $headers,
                'params'  => $params,
                'timeout' => 25,
                'verify'  => false,
            ]);
            $html = (string) $response->getBody();
        } catch (RequestException $e) {
            if ($e->hasResponse()) {
                throw CouldNotSendNotification::errorSending(Psr7\str($e->getResponse()));
            }
            throw CouldNotSendNotification::errorSending($e->getMessage());
        }

        return $response;
    }

}
