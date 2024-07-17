<?php

namespace Webkul\Shop\Http\Controllers\Customer\Account;

use Illuminate\Support\Facades\Event;
use Webkul\Customer\Repositories\CustomerAddressRepository;
use Webkul\Shop\Http\Controllers\Controller;
use Webkul\Shop\Http\Requests\Customer\AddressRequest;
use Webkul\WriteProgram\Repositories\SubscriptionRepository;

class SubscriptionController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        protected SubscriptionRepository $subscriptionRepository
    ){}
    /**
     * Subscriptions route index page.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $subscriptions = $this->subscriptionRepository
            ->where(
                'customer_id', auth()->guard('customer')->user()->id
            )
            ->orderBy('id', 'desc')
            ->get();
        return view('shop::customers.account.subscriptions.index', compact('subscriptions'));
    }
    
    /**
     * To change the subscriptions address or make the default subscriptions,
     * by default when first subscriptions is created will be the default subscription.
     *
     * @return \Illuminate\Http\Response
     */
    public function makeDefault(int $id)
    {
        $defaultAddress = $this->subscriptionRepository->find($id);

        if ($defaultAddress) {
            $defaultAddress->update(['subscribed_as' => 1]);
             session()->flash('success', trans('shop::app.customers.account.subscriptions.index.update-success'));
        } else {
             abort(404);
           
        }

        return redirect()->back();
        
    }

 
    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $subscription = $this->subscriptionRepository->find($id);

        if (! $subscription) {
            abort(404);
        }

        $subscription->update(['subscribed_as' => 0]);

        session()->flash('success', trans('shop::app.customers.account.subscriptions.index.update-success'));

        return redirect()->back();
    }
}
