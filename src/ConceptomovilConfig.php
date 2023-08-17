<?php
namespace NotificationChannels\Conceptomovil;

class ConceptomovilConfig
{
    /**
     * @var array
     */
    private $config;

    /**
     * ConceptomovilConfig constructor.
     *
     * @param array $config
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Get the account url.
     *
     * @return string
     */
    public function getAccountURL()
    {
        return $this->config['url'];
    }

    public function getToken()
    {
        return $this->config['token'];
    }

    public function getKey()
    {
        return $this->config['key'];
    }

    public function getCountry()
    {
        return $this->config['country'];
    }

    public function getDial()
    {
        return $this->config['dial'];
    }

    public function getTag()
    {
        return $this->config['tag'];
    }
}
