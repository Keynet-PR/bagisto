<?php declare(strict_types=1);

namespace Webkul\Shop\Http\Controllers\Customer\Account;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Webkul\Shop\Http\Controllers\Controller;
use Webkul\DownloadLinks\Models\DownloadPurchased;
use Webkul\DownloadLinks\Models\DownloadPurchasedLink;
use Webkul\DownloadLinks\Repository\DownloadCustomerLinkRepository;

class DownloadCustomerLinkController extends Controller
{
    public function __construct(
     
        protected DownloadCustomerLinkRepository $downloadCustomerLinkRepository
    ) {}

    public function index()
    {
        $uploads = $this->downloadCustomerLinkRepository
            ->whereHas('purchased', function($q){
                 $q->where(['customer_id' => auth()->guard('customer')->id()
                ]);
            })
            ->orderBy('created_at', 'desc')
            ->get();
            
          
        return view('shop::customers.account.download_links.index')->with('uploads', $uploads);
    }

    public function create()
    {
         $downloadPurchased = DownloadPurchased::query()
            ->whereNull('one_time_expired')
            ->where([
            'customer_id' => auth()->guard('customer')->id()
        ])
        ->orWhereDate('subscribed_end', '<', now())
        ->select('service_request', 'time_limit','subscribed_default','id')->get();
       
        return view('shop::customers.account.download_links.create', [
            'plans' => $downloadPurchased
        ]);
    
        
    }

    public function setAsDefault(Request $request)
    {
        
        try {

            $downloadPurchased = DownloadPurchased::where([
                'customer_id' => auth()->guard('customer')->id(),
                'id' => $request->download_purchased_id
            ])->firstOrFail();

            // if ($oldes = DownloadPurchased::where([
            //     'customer_id' => auth()->guard('customer')->id(),
            //     'service_request' => $downloadPurchased->service_request,
            // ])->whereDate('subscribed_end ', '<', now()->today())) {
            //     $oldes->update([
            //         'subscribed_default' => "as"
            //     ]);
            // }

            $downloadPurchased->update([
                'subscribed_default' => 'default'
            ]);
            
            session()->flash('success', trans('shop::app.customers.account.download-links.index.set-as-default-success'));
            return redirect()->back();

        } catch (\Throwable $th) {
            session()->flash('error', $th->getMessage());
            return redirect()->back();
        }

    }

    public function store(Request $request)
    {
    
        try {
            
            $downloadPurchased = DownloadPurchased::where([
                'customer_id' => auth()->guard('customer')->id(),
                'service_request' => $request->service_request,
                'subscribed_default' => 'default'
            ])->latest()->first();
            
            if ($downloadPurchased && $downloadPurchased->isExpire()) {
                session()->flash('error', trans('shop::app.customers.account.download-links.index.subscription-is-expire'));
                return redirect()->back();
            }

            if ($downloadPurchased && $downloadPurchased->isLimitUpload()) {
                session()->flash('error', trans('shop::app.customers.account.download-links.index.limit-upload-unavariable'));
                return redirect()->back();
            }
            
        } catch (\Throwable $th) {
            session()->flash('error', trans('shop::app.customers.account.download-links.index.invalid-subscribed'));
            return redirect()->back();
        }
        

        try {
           
            $downloadCustomer = $this->downloadCustomerLinkRepository->create(
                [
                    'download_purchased_id' => $downloadPurchased->id,
                    'service_request' => $request->service_request,
                    'model' => $request->model,
                    'brand' => $request->brand,
                    'vin' => $request->vin,
                    'capacity' => $request->capacity,
                    'year' => $request->year,
                    'dtc_code' => $request->dtc_code,
                ]
            );
            
            if($downloadPurchased &&  $downloadPurchased->time_limit == 'One-time'){
                $downloadPurchased->update([
                    'one_time_expired' => now()
               ]);
            }

            $fileUploadInfo = $this->downloadCustomerLinkRepository->upload();
            if ($downloadCustomer && $fileUploadInfo) {
                DownloadPurchasedLink::create([
                    'download_customer_link_id' => $downloadCustomer->id,
                    'customer_id' => auth()->guard('customer')->id(),
                    'customer_action' => 'create',
                    'file_size' => $fileUploadInfo['file_size'],
                    'url' => $fileUploadInfo['file_url'],
                    'file_name' => $fileUploadInfo['file_name'],
                    'file' => $fileUploadInfo['file']
                ]);
            }

            session()->flash('success', trans('shop::app.customers.account.download-links.index.update-success'));
            return redirect()->route('shop.customers.account.download-links.index');

        } catch (\Throwable $th) {

            session()->flash('error', $th->getMessage());
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
            ->with([
                'links',
                'purchased' => fn($q) => $q->where(
                    'customer_id',
                    auth()->guard('customer')->id()
                )
            ])
            ->findOneWhere([
                'id' => $id
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
                'customer_id' => auth()->guard('customer')->id(),
                'customer_action' => 'edit',
                'file_size' => $fileUploadInfo['file_size'],
                'url' => $fileUploadInfo['file_url'],
                'file_name' => $fileUploadInfo['file_name'],
                'file' => $fileUploadInfo['file']
            ]);
        }

        session()->flash('success', trans('shop::app.customers.account.download-links.edit.send-success'));
        return redirect()->back();
    }

}
