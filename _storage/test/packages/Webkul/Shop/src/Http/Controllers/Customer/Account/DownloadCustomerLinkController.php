<?php

namespace Webkul\Shop\Http\Controllers\Customer\Account;

use Illuminate\Http\Request;
use Webkul\DownloadLinks\Models\DownloadPurchasedLink;
use Webkul\Shop\Http\Controllers\Controller;;

use Webkul\Sales\Repositories\OrderItemRepository;
use Webkul\Sales\Repositories\OrderRepository;
use Webkul\DownloadLinks\Repository\DownloadCustomerLinkRepository;
//use Illuminate\Support\Facades\Event;
use Illuminate\Support\Arr;
use Webkul\DownloadLinks\Models\DownloadPurchased;

class DownloadCustomerLinkController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected OrderItemRepository $orderItemRepository,
        protected OrderRepository $orderRepository,
        protected DownloadCustomerLinkRepository $downloadCustomerLinkRepository
    ) {
    }

    /**
     * Address route index page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $uploads = $this->downloadCustomerLinkRepository
            ->where([
                'customer_id' => auth()->guard('customer')->id(),
            ])
            ->orderBy('created_at', 'desc')
            ->get();
        return view('shop::customers.account.download_links.index')->with('uploads', $uploads);
    }

    /**
     * Show the address create form.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('shop::customers.account.download_links.create');
    }

    /**
     * Create a new address for customer.
     *
     * @return view
     */
    public function store(Request $request)
    {

        $this->validate(request(), [
            'vin'         => 'required',
            'model'       => 'required',
            'brand'       => 'required',
            'capacity'       => 'required',
            'year'        => 'required',
            'service_request' => 'required',
            'attachment'   => 'required',
        ]);

        $orderItems = $this->orderItemRepository
            ->distinct('order_items.product_id')
            ->leftJoin('orders', 'order_items.order_id', 'orders.id')
            ->whereNull('order_items.parent_id')
            ->where([
                'orders.customer_id' => auth()->guard('customer')->id(),
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
                if (Arr::hasAny($item->additional, 'attributes.timelimit')) {
                    $time_limit =  Arr::get($item->additional, 'attributes.timelimit.option_label');
                    return [
                        'order_id' => $item->order_id,
                        'customer_id' => $item->customer_id,
                        'product_id' => $item->product_id,
                        'product_name' => $item->product_name,
                        'subscribed_at' => $item->subscribed_at,
                        'subscribed_end' => date('Y-m-d', strtotime($item->subscribed_at . ' +1 month')),
                        'time_limit' => Arr::get($item->additional, 'attributes.timelimit.option_label'),
                        'service_request' => Arr::get($item->additional, 'attributes.servicerequest.option_label'),
                    ];
                }
            });


        $subscribed = [];

        foreach ($orderItems as  $item) {
            if ($item['service_request'] == $request->service_request) {
                $subscribed = $item;
            }
        }

        if (!empty($subscribed)) {

            $downloadPurchased = DownloadPurchased::firstOrNew([
                'order_id' =>  $subscribed['order_id'],
                'customer_id' =>  $subscribed['customer_id'],
                'product_id' =>  $subscribed['product_id']
            ]);
            $downloadCustomer = $this->downloadCustomerLinkRepository->where([
                'customer_id' => auth()->guard('customer')->id(),
                'service_request' => $request->service_request
            ])->first();

           
            if ($downloadCustomer->status == 'Available' AND $downloadPurchased['is_expire'] == 0) {
                $downloadPurchased->product_name = $subscribed['product_name'];
                $downloadPurchased->time_limit = $subscribed['time_limit'];
                $downloadPurchased->subscribed_at = $subscribed['subscribed_at'];
                $downloadPurchased->subscribed_end = $subscribed['subscribed_end'];
                $downloadPurchased->service_request = $subscribed['service_request'];
                $downloadPurchased->daily_download_bought = 5;
                $downloadPurchased->save();

                $download = $this->downloadCustomerLinkRepository->create([
                    'customer_id' => auth()->guard('customer')->id(),
                    'model' => $request->model,
                    'brand' => $request->brand,
                    'vin' => $request->vin,
                    'capacity' => $request->capacity,
                    'year' => $request->year,
                    'service_request' => $request->service_request,
                    'dtc_code' => $request->dtc_code,
                ]);

                $fileUploadInfo = $this->downloadCustomerLinkRepository->upload();
                if ($download && $fileUploadInfo) {
                    DownloadPurchasedLink::create([
                        'download_customer_link_id' => $download->id,
                        'customer_id' => auth()->guard('customer')->id(),
                        'url' => $fileUploadInfo['file_url'],
                        'file_name' => $fileUploadInfo['file_name'],
                        'file' => $fileUploadInfo['file']
                    ]);
                }
                session()->flash('success', trans('shop::app.customers.account.download-links.index.create-success'));
            } else {
                session()->flash('error', trans('shop::app.customers.account.download-links.index.upload-unavariable'));
            }


            return redirect()->route('shop.customers.account.download-links.index');
        } else {
            session()->flash('error', trans('shop::app.customers.account.download-links.index.invalid-subscribed'));
            return redirect()->back();
        }
    }

    public function downloads(string $id)
    {
        $downloadableLink = DownloadPurchasedLink::query()->findOrFail($id);
        $fileName = substr($downloadableLink->url, strrpos($downloadableLink->url, '/') + 1);

        $tempImage = tempnam(sys_get_temp_dir(), $fileName);
        return response()->download($tempImage, $fileName);
    }

    /**
     * For editing the existing addresses of current logged in customer.
     *
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $downloads = $this->downloadCustomerLinkRepository
            ->with(['links', 'purchased' => fn ($q) =>  $q->where(
                'customer_id',
                auth()->guard('customer')->id()
            )])
            ->findOneWhere([
                'id'          => $id,
                'customer_id' => auth()->guard('customer')->id(),
            ]);

        if (!$downloads) {
            abort(404);
        }

        return view('shop::customers.account.download_links.edit')->with('downloads', $downloads);
    }

    /**
     * Edit's the pre-made resource of customer called Address.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(string $id)
    {
        $fileUploadInfo = $this->downloadCustomerLinkRepository->upload();
        if ($fileUploadInfo) {
            DownloadPurchasedLink::create([
                'download_customer_link_id' => $id,
                'customer_id' =>  auth()->guard('customer')->id(),
                'url' => $fileUploadInfo['file_url'],
                'file_name' => $fileUploadInfo['file_name'],
                'file' => $fileUploadInfo['file']
            ]);
        }

        session()->flash('success', trans('shop::app.customers.account.download-links.edit.send-success'));
        return redirect()->back();
    }
}
