<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Product;

class WinnerNotification extends Notification implements ShouldQueue
{
    use Queueable;
    public $product;
    public $amount;

    public function __construct(Product $product, $amount)
    {
        $this->product = $product;
        $this->amount = $amount;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Chúc mừng bạn đã thắng đấu giá!')
            ->greeting('Xin chào ' . $notifiable->name . ',')
            ->line('Bạn đã thắng phiên đấu giá sản phẩm: ' . $this->product->name)
            ->line('Giá thắng cuộc: ' . number_format($this->amount, 0, ',', '.') . ' VNĐ')
            ->action('Xem chi tiết sản phẩm', url('/products/' . $this->product->id))
            ->line('Cảm ơn bạn đã tham gia đấu giá!');
    }
}
