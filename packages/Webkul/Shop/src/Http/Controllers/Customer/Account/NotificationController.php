<?php declare(strict_types=1); 

namespace Webkul\Shop\Http\Controllers\Customer\Account;

use Webkul\Shop\Http\Controllers\Controller;
use Webkul\Notification\Repositories\NotificationRepository;

class NotificationController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected NotificationRepository $notificationRepository
    ){}

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('shop::customers.account.notifications.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function getNotifications()
    {
        $params = request()->except('page');

        $searchResults = count($params)
            ? $this->notificationRepository->getCustomerParamsData($params)
            : $this->notificationRepository->getCustomerAll();

        $results = isset($searchResults['notifications']) ? $searchResults['notifications'] : $searchResults;

        $statusCount = isset($searchResults['status_counts']) ? $searchResults['status_counts'] : '';

        return [
            'search_results' => $results,
            'status_count'   => $statusCount,
            'total_unread'   => $this->notificationRepository
                ->whereHas('notify',function($query){
                    $query->whereIn('status', ['file_completed', 'pending', 'cancel', 'completed']);
                })
                ->where([
                    'read' => 0,
                    'customer_id' => auth()->guard('customer')->id()
                ])->count(),
        ];
    }

    /**
     * Update the notification is reade or not.
     *
     * @param  int  $orderId
     * @return \Illuminate\View\View
     */
    public function viewedNotifications($notifiableId)
    {
        if ($notification = $this->notificationRepository->where('notifiable_id', $notifiableId)->first()) {
            $notification->read = 1;

            $_route = $notification->type == 'order'
                ? 'shop.customers.account.orders.view'
                : 'shop.customers.account.writables.edit';
            $notification->save();

            return redirect()->route($_route, $notifiableId);
        }

        abort(404);
    }

    /**
     * Update the notification is reade or not.
     *
     * @return array
     */
    public function readAllNotifications()
    {
        $this->notificationRepository->where('read', 0)->update(['read' => 1]);

        $searchResults = $this->notificationRepository->getCustomerParamsData([
            'limit' => 5,
            'read'  => 0,
        ]);

        return [
            'search_results'  => $searchResults,
            'total_unread'    => $this->notificationRepository->where('read', 0)->count(),
            'success_message' => trans('admin::app.notifications.marked-success'),
        ];
    }
}
