<?php
namespace NotificationChannels\Conceptomovil;

use Exception;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Notifications\Events\NotificationFailed;
use NotificationChannels\Conceptomovil\Exceptions\CouldNotSendNotification;

class ConceptomovilChannel
{
    /**
     * @var Conceptomovil
     */
    protected $conceptomovil;

    /**
     * @var Dispatcher
     */
    protected $events;

    /**
     * ConceptomovilChannel constructor.
     *
     * @param Conceptomovil     $conceptomovil
     * @param Dispatcher $events
     */
    public function __construct(Conceptomovil $conceptomovil, Dispatcher $events)
    {
        $this->conceptomovil = $conceptomovil;
        $this->events        = $events;
    }

    /**
     * Send the given notification.
     *
     * @param  mixed                                  $notifiable
     * @param  \Illuminate\Notifications\Notification $notification
     * @return mixed
     * @throws CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
        try {
            $to      = $this->getTo($notifiable);
            $message = $notification->toConceptomovil($notifiable);
            if (is_string($message)) {
                $message = new ConceptomovilMessage($message);
            }
            if (!$message instanceof ConceptomovilMessage) {
                throw CouldNotSendNotification::invalidMessageObject($message);
            }

            return $this->conceptomovil->sendMessage($message, $to);
        } catch (Exception $exception) {
            $this->events->dispatch(
                new NotificationFailed($notifiable, $notification, 'conceptomovil', ['message' => $exception->getMessage()])
            );
        }
    }

    /**
     * Get the address to send a notification to.
     *
     * @param mixed $notifiable
     * @return mixed
     * @throws CouldNotSendNotification
     */
    protected function getTo($notifiable)
    {
        if ($notifiable->routeNotificationFor('conceptomovil')) {
            return $notifiable->routeNotificationFor('conceptomovil');
        }
        if (isset($notifiable->celular)) {
            return $notifiable->celular;
        }
        throw CouldNotSendNotification::invalidReceiver();
    }

    /**
     * Get the alphanumeric sender.
     *
     * @param $notifiable
     * @return mixed|null
     * @throws CouldNotSendNotification
     */
    protected function canReceiveAlphanumericSender($notifiable)
    {
        return false;
    }
}
