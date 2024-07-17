<?php declare(strict_types=1);

namespace Webkul\Notification\Listeners;

use Webkul\Notification\Events\CreateOrderNotification;
use Webkul\Notification\Events\UpdateOrderNotification;
use Webkul\Notification\Repositories\NotificationRepository;
use Webkul\DownloadLinks\Repository\DownloadCustomerLinkRepository;

class Order
{
    /**
     * Create a new listener instance.
     *
     * @return void
     */
    public function __construct(
        protected NotificationRepository $notificationRepository,
        protected DownloadCustomerLinkRepository $downloadCustomerLinkRepository
    ) {
    }

    /**
     * Create a new resource.
     *
     * @return void
     */
    public function createOrder($order)
    {
        $this->notificationRepository->create(['type' => 'order', 'order_id' => $order->id]);

        event(new CreateOrderNotification);
    }

    /**
     * Fire an Event when the order status is updated.
     *
     * @return void
     */
    public function updateOrder($order)
    {
        event(new UpdateOrderNotification([
            'id' => $order->id,
            'status' => $order->status,
        ]));
        //if ($order->status == 'completed') {
        //     $this->downloadCustomerLinkRepository->subscribe($order->id);
        // }
    }
}
