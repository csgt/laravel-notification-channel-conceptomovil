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

    /**
     * Get the account username.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->config['username'];
    }

    /**
     * Get the account passwrod.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->config['password'];
    }

}
