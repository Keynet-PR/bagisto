<?php

namespace Webkul\DownloadLinks\Listeners;

use Illuminate\Support\Facades\Log;
use Webkul\DownloadLinks\Repository\DownloadCustomerLinkRepository;
use Illuminate\Support\Facades\Mail;
use Webkul\Customer\Repositories\CustomerRepository;
use Webkul\DownloadLinks\Mail\ProductBackInStockNotification;
use Webkul\Product\Repositories\ProductRepository;

class ProductUpdateAfterListener
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
        protected ProductRepository  $productRepository
    ) {
    }

    /**
     * Handle the event.
     *
     * @param  mixed  $product
     * @return void
     */
    public function handle($product)
    {
        try {
            $datas = $this->DownloadLinksRepository->findByField('product_id', $product->id);

            foreach ($datas as $data) {
                $customer = $this->customerRepository->find($data->customer_id);

                Mail::queue(new ProductBackInStockNotification($product, $customer));
            }
        } catch (\Exception $e) {
            Log::error('Error: ' . $e->getMessage());
        }
    }
}