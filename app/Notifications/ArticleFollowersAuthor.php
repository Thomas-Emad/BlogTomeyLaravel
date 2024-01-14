<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ArticleFollowersAuthor extends Notification
{
  use Queueable;

  /**
   * Create a new notification instance.
   */
  protected  $id_article, $id_author;

  public function __construct($id_article, $id_author)
  {
    $this->id_article = $id_article;
    $this->id_author = $id_author;
  }

  /**
   * Get the notification's delivery channels.
   *
   * @return array<int, string>
   */
  public function via($notifiable)
  {
    return ['database'];
  }

  /**
   * Get the array representation of the notification.
   *
   * @return array<string, mixed>
   */
  public function toArray($notifiable)
  {
    return [
      'id_article' => $this->id_article,
      'id_author' => $this->id_author,
    ];
  }
}
