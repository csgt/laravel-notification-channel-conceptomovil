<?php
namespace NotificationChannels\Conceptomovil;

class ConceptomovilMessage
{
    /**
     * The message content.
     *
     * @var string
     */
    public $content;

    /**
     * The phone number the message should be sent from.
     *
     * @var string
     */
    public $from;

    /**
     * Create a message object.
     * @param string $content
     * @return static
     */
    public static function create($content = '')
    {
        return new static($content);
    }

    /**
     * Create a new message instance.
     *
     * @param  string $content
     */
    public function __construct($content = '')
    {
        $this->content = $content;
    }

    /**
     * Set the message content.
     *
     * @param  string $content
     * @return $this
     */
    public function content($content)
    {
        $this->content = $content;

        return $this;
    }
}
