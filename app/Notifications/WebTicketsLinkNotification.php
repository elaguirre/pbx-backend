<?php

namespace App\Notifications;

use App\Models\Purchase;
use App\Models\PurchaseDigitalReference;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use NotificationChannels\Twilio\TwilioChannel;
use NotificationChannels\Twilio\TwilioSmsMessage;

class WebTicketsLinkNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Purchase                 $purchase,
        public PurchaseDigitalReference $purchase_digital_reference,
    )
    {
    }

    public function via($notifiable): array
    {
        return [TwilioChannel::class];
    }

    public function toTwilio($notifiable): TwilioSmsMessage
    {
        $message = "Descarga tus boletos de " . tenant('id') . ": {$this->purchase_digital_reference->link}";

        $twilio_message = TwilioSmsMessage::create()->content($message);

        if ($from = config('services.twilio.from')) {
            $twilio_message->from($from);
        }

        return $twilio_message;
    }
}

