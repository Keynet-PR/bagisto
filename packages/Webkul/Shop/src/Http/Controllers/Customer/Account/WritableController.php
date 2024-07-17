<?php

declare(strict_types=1);

namespace Webkul\Shop\Http\Controllers\Customer\Account;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Webkul\Shop\Http\Controllers\Controller;
use Webkul\WriteProgram\Models\WpSubscription;
use Webkul\WriteProgram\Models\WriteProgramFile;
use Webkul\Notification\Repositories\NotificationRepository;
use Webkul\WriteProgram\Repositories\WriteProgramRepository;

class WritableController extends Controller
{
    public function __construct(
        protected WriteProgramRepository $writeProgramRepository,
        protected NotificationRepository $notificationRepository
    ) {}

    public function index()
    {
        $writables = $this->writeProgramRepository
            ->whereHas('subscription', function ($q) {
                $q->where([
                    'customer_id' => auth()->guard('customer')->id()
                ]);
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('shop::customers.account.writables.index')->with('writables', $writables);
    }

    public function create()
    {
        return view('shop::customers.account.writables.create');
    }

    public function store(Request $request)
    {
       
        try {
            
            $subscribed = WpSubscription::query()
                ->whereHas('plan', function ($query) use ($request) {
                    $query->where('service_request', Str::lower($request->service_request));
                })
                ->where('customer_id', auth()->guard('customer')->id())
                ->where('subscribed_as', true)
                ->firstOrFail();
                
            if ($subscribed && $subscribed->isExpire()) {
                session()->flash('error', trans('shop::app.customers.account.writables.index.subscription-is-expire'));
                return redirect()->back();
            }

            if ($subscribed && $subscribed->allowUploadLimit()) {
                session()->flash('error', trans('shop::app.customers.account.writables.index.limit-upload-unavariable'));
                return redirect()->back();
            }
            
        } catch (\Throwable $th) {
            session()->flash('error', trans('shop::app.customers.account.writables.index.invalid-subscribed'));
            return redirect()->back();
        }

        try {

            $fileUploadInfo = $this->writeProgramRepository->upload();

            if ($subscribed && $fileUploadInfo) {

                $writable = $this->writeProgramRepository->create(
                    [
                        'wp_subscriptions_id' => $subscribed->id,
                        'service_request' => str::lower($request->service_request),
                        'model' => $request->model,
                        'brand' => $request->brand,
                        'vin' => $request->vin,
                        'capacity' => $request->capacity,
                        'year' => $request->year,
                        'dtc_code' => $request->dtc_code,
                    ]
                );

                $writable->files()->create([
                    'customer_id' => auth()->guard('customer')->id(),
                    'url' => $fileUploadInfo['file_url'],
                    'file_name' => $fileUploadInfo['file_name'],
                    'file' => $fileUploadInfo['file'],
                    'action' => 'create',
                    'file_size' => $fileUploadInfo['file_size']
                ]);

                $writable->notifications()->create([
                    'type' => 'writable',
                    'customer_id' => auth()->guard('customer')->id()
                ]);
                
                if($subscribed->isExpire() || $subscribed->plan->daily_download_bought ==1) $subscribed->update(['subscribed_as' => 0]);

            }

            session()->flash('success', trans('shop::app.customers.account.writables.index.update-success'));

            return redirect()->route('shop.customers.account.writables.index');

        } catch (\Throwable $th) {

            session()->flash('error', $th->getMessage());
            return redirect()->back();
        }
    }

    public function downloads(string $id)
    {
        $writabe = WriteProgramFile::query()->findOrFail($id);

        $fileName = substr($writabe->url, strrpos($writabe->url, '/') + 1);

        $tempImage = tempnam(sys_get_temp_dir(), $fileName);

        return response()->download($tempImage, $fileName);
    }

    public function edit($id)
    {
        $writable = $this->writeProgramRepository
            ->with(['files', 'subscription'])
            ->findOrFail($id);
        if (!$writable) {
            abort(404);
        }

        return view('shop::customers.account.writables.edit')->with('writable', $writable);
    }

    public function update($id)
    {

        $writable = $this->writeProgramRepository->findOrFail($id);

        $fileUploadInfo = $this->writeProgramRepository->upload();

        if ($writable && !empty($fileUploadInfo)) {

            $writable->files()->create([
                'write_program_id' => $id,
                'customer_id' => auth()->guard('customer')->id(),
                'url' => $fileUploadInfo['file_url'],
                'file_name' => $fileUploadInfo['file_name'],
                'file' => $fileUploadInfo['file'],
                'action' => 'create',
                'file_size' => $fileUploadInfo['file_size'],
            ]);

            $writable->update([
                'status' => "file_created"
            ]);

            $this->notificationRepository->where([
                'notifiable_id' => $id,
                'type' => 'writable'
            ])->update(['read' => 0]);

        }

        session()->flash('success', trans('shop::app.customers.account.writables.edit.send-success'));
        return redirect()->back();

    }

}
