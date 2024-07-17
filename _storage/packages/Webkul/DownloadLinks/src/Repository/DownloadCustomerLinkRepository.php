<?php declare(strict_types=1); 

namespace Webkul\DownloadLinks\Repository;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Webkul\Core\Eloquent\Repository;
use Illuminate\Support\Facades\Storage;
use Webkul\DownloadLinks\Models\DownloadPurchased;
use Webkul\Sales\Models\OrderItemProxy;

class DownloadCustomerLinkRepository extends Repository
{
      function model(): string
    {
        return 'Webkul\DownloadLinks\Contracts\DownloadCustomerLink';
    }

  
    public function upload()
    {
        if (! request()->hasFile('attachment')) {
            return [];
        }
        $file = request()->file('attachment');
        $fileSize = $file->getSize();
        return [
            'file'      => $path = request()->file('attachment')->store('download-subscribe-link/'. request()->id),
            'file_name' => $file->getClientOriginalName(),
            'file_url'  => Storage::url($path),
            'file_size' => ($fileSize / 1024)
        ];
    }

    public function subscribe($order_id = null) {
        
          $orderItems = OrderItemProxy::query()
            ->distinct('order_items.product_id')
            ->leftJoin('orders', 'order_items.order_id', 'orders.id')
            ->whereNull('order_items.parent_id')
            ->where([
                'orders.id' => $order_id,
                'orders.status' => 'completed'
            ])
            ->orderBy('orders.created_at', 'desc')
            ->select(
                'orders.id as order_id',
                'orders.customer_id as customer_id',
                'orders.updated_at as subscribed_at',
                'order_items.id as product_id',
                'order_items.name as product_name',
                'order_items.additional'
            )
            ->get()
            ->map(function ($item) {

                $service_request = Arr::get($item->additional, 'attributes.servicerequest.option_label');
                $time_limit = Arr::get($item->additional, 'attributes.timelimit.option_label');

                switch ($time_limit) {
                    case 'One-time':
                        $subscribed_end = Carbon::parse($item->subscribed_at)->addDays(3);
                        break;
                    case 'Monthly':
                        $subscribed_end = Carbon::parse($item->subscribed_at)->addMonth();

                        break;
                    case 'Yearly':
                        $subscribed_end = Carbon::parse($item->subscribed_at)->addYear();
                        break;
                    default:

                }
                if (
                    Arr::hasAny($item->additional, 'attributes.timelimit') && $service_request

                ) {
                    return [
                        'order_id' => $item->order_id,
                        'customer_id' => $item->customer_id,
                        'product_id' => $item->product_id,
                        'product_name' => $item->product_name,
                        'subscribed_at' => $item->subscribed_at,
                        'subscribed_end' => $subscribed_end,
                        'time_limit' => $time_limit,
                        'service_request' => $service_request,
                    ];
                }
            })->toArray();

       

            try {
                foreach ($subscribeds = Arr::whereNotNull($orderItems) as $subscribed) {
                    
                   
                    $daily_download_bought = 0;
                    
                    switch ($subscribed['time_limit']) {
                      case "Monthly":
                        $daily_download_bought = 3;
                        break;
                      case "Yearly":
                        $daily_download_bought = 5;
                        break;
                      default:
                         $daily_download_bought = 1;
                    }

                    $downloadPurchased = DownloadPurchased::firstOrCreate(
                        [
                            'order_id' => $subscribed['order_id'],
                            'customer_id' => $subscribed['customer_id'],
                            'product_id' => $subscribed['product_id']
                        ],
                        [
                            'product_name' => $subscribed['product_name'],
                            'time_limit' => $subscribed['time_limit'],
                            'subscribed_at' => $subscribed['subscribed_at'],
                            'subscribed_end' => $subscribed['subscribed_end'],
                            'service_request' => $subscribed['service_request'],
                            'daily_download_bought' => $daily_download_bought,
                            'subscribed_default' => 'default'
                        ]
                    );
                }
            } catch (\Throwable $th) {
                session()->flash('error', $th->getMessage());
               return redirect()->back();
            }
        
    }
}
