<?php

namespace Webkul\DownloadLinks\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Webkul\Customer\Repositories\CustomerRepository;
use Webkul\DownloadLinks\DataGrids\DownloadCustomerLinkDataGrid;
use Webkul\DownloadLinks\Http\Controllers\Controller;
use Webkul\DownloadLinks\Models\DownloadPurchasedLink;
use Webkul\DownloadLinks\Repository\DownloadCustomerLinkRepository;
use Webkul\Product\Repositories\ProductRepository;
use Webkul\Sales\Repositories\OrderItemRepository;
use Webkul\Sales\Repositories\OrderRepository;
use Webkul\Sales\Repositories\ShipmentRepository;
use Webkul\Sales\Repositories\InvoiceRepository;

//use Webkul\DownloadLinks\Mail\ProductBackInStockNotification;
//use Illuminate\Support\Facades\Mail;

class DownloadCustomerLinkController extends Controller
{
    /**
     * Create a controller instance.
     * 
     * @param  \Webkul\DownloadLinks\Repository\DownloadLinksRepository  $DownloadLinksRepository
     * @param  \Webkul\Customer\Repositories\CustomerRepository  $customerRepository
     * @param   \Webkul\Product\Repositories\ProductRepository $productRepository
     * @return void
     */
    public function __construct(
        protected DownloadCustomerLinkRepository   $downloadCustomerLinkRepository,
        protected CustomerRepository $customerRepository,
        protected ProductRepository  $productRepository,
        protected OrderRepository $orderRepository,
        protected OrderItemRepository $orderItemRepository,
        protected InvoiceRepository $invoiceRepository,
        protected ShipmentRepository $shipmentRepository
    ) {
    }

    /**
     * Index.
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        if (request()->ajax()) {
            return app(DownloadCustomerLinkDataGrid::class)->toJson();
        }

        return view('download-link::admin.index');
    }

    public function view($id)
    {

        $downloadCustomerLink = $this->downloadCustomerLinkRepository->findOrFail($id);
        $customer = $this->customerRepository->where([
            'id' => $downloadCustomerLink->customer_id
        ])->first();

        return view('download-link::admin.view', compact('downloadCustomerLink', 'customer'));
    }

    public function sendFile(string $id)
    {
        $fileUploadInfo = $this->downloadCustomerLinkRepository->upload();
        if (!empty($fileUploadInfo)) {

            DownloadPurchasedLink::create([
                'download_customer_link_id' => $id,
                'admin_id' => auth()->guard('admin')->id(),
                'url' => $fileUploadInfo['file_url'],
                'file_name' => $fileUploadInfo['file_name'],
                'file' => $fileUploadInfo['file']
            ]);
        }

        session()->flash('success', trans('download-link::app.admin.view.file-send'));
        return redirect()->back();

    }

    /**
     * Store.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function downloadableLink(string $id)
    {
        $downloadableLink = DownloadPurchasedLink::query()
            ->findOrFail($id);
        $fileName = substr($downloadableLink->url, strrpos($downloadableLink->url, '/') + 1);

        $tempImage = tempnam(sys_get_temp_dir(), $fileName);

        return response()->download($tempImage, $fileName);
    }

    /**
     * Store.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    // public function updateStockStatus(Request $request)
    // {
    //     $notificationId = $request->notificationId;

    //     try {
    //         $data = $this->downloadCustomerLinkRepository->find($notificationId);

    //         $customer = $this->customerRepository->find($data->customer_id);

    //         $product = $this->productRepository->find($data->product_id);

    //         Mail::queue(new ProductBackInStockNotification($product, $customer));

    //         return response()->json(['message' => 'Stock status updated successfully.']);
    //     } catch (\Exception $e) {
    //         return response()->json(['message' => $e->getMessage()]);
    //     }
    // }
}
