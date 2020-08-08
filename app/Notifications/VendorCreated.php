<?php

namespace App\Notifications;

use App\models\Vendor;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VendorCreated extends Notification
{
    use Queueable;

    // NOTIFICATION CLASS GLOBAL VARIABLE
    public $vendor;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Vendor $vendor)
    {
        // ASSIGN THE INSTANCE DATA TO THE CLASS GLOBAL VARIABLE
        $this->vendor = $vendor;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // return (new MailMessage)
        //             ->line('The introduction to the notification.')
        //             ->action('Notification Action', url('/'))
        //             ->line('Thank you for using our application!');

        // EMAIL SUBJECT
        $subject = sprintf(
            '%s: Your account has been created successfully %s!',
            config('app.name'),
            // $this->fromUser->name
            'Ahmed Salah'
        );

        // EMAIL GREETING MESSAGE
        $greeting = sprintf(
            'Hello %s!',
            $notifiable->name
        );

        return (new MailMessage)->subject(
            $subject
        )->greeting(
            $greeting
        )->salutation(
            'Yours Faithfully'
        )->line(
            'The introduction to the notification.'
        )->action(
            'Notification Action',
            url('/')
        )->line(
            'Thank you for using our application!'
        );
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
