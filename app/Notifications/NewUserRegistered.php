<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class NewUserRegistered extends Notification
{


    /**
     * Create a new notification instance.
     */
    public function __construct(public User $user)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via($notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $approveUrl = url('/admin/users/' . $this->user->id . '/approve');
        $rejectUrl = url('/admin/users/' . $this->user->id . '/reject');

        return (new MailMessage)
            ->subject('Pendaftar Akun Baru - SmartExam')
            ->greeting('Halo Admin!')
            ->line('Ada siswa baru yang mendaftar dan menunggu persetujuan.')
            ->line('**Nama:** ' . $this->user->name)
            ->line('**Email:** ' . $this->user->email)
            ->action('Approve Akun', $approveUrl)
            ->line('Atau tolak pendaftaran: ' . $rejectUrl);
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
