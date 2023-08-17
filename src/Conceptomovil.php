<?php
namespace NotificationChannels\Conceptomovil;

use Illuminate\Support\Facades\Http;

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

        $response = Http::withHeaders([
            'Content-Type'  => 'application/json',
            'Authorization' => $serviceToken,
        ])
            ->post('https://api.broadcastermobile.com/brdcstr-endpoint-web/services/messaging/', [
                "apiKey"  => $serviceApiKey,
                "country" => $serviceCountry,
                "dial"    => $serviceDial,
                "message" => trim($message->content),
                "msisdns" => [$to],
                "tag"     => $serviceTag,
            ]);

        return $response->json();

    }

}
