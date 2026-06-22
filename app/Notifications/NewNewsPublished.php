<?php

namespace App\Notifications;

use App\Models\NewsArticle;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

class NewNewsPublished extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public NewsArticle $article) {}

    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'       => 'news_published',
            'article_id' => $this->article->id,
            'slug'       => $this->article->slug,
            'title'      => $this->article->title,
            'message'    => "New disaster news: \"{$this->article->title}\"",
            'district'   => $this->article->district?->name,
        ];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}
