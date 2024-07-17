<x-shop::layouts.account>
    <!-- Page Title -->
    <x-slot:title>
        @lang('shop::app.customers.account.subscriptions.index.title')
    </x-slot>
    
    <!-- Breadcrumbs -->
    @section('breadcrumbs')
        <x-shop::breadcrumbs name="orders" />
    @endSection

    <div class="max-md:hidden">
        <x-shop::layouts.account.navigation />
    </div>

    <div class="mx-4 flex-auto">
        <div class="flex items-center justify-between">
            <div class="flex items-center">
                <!-- Back Button -->
                <a
                    class="grid md:hidden"
                    href="{{ route('shop.customers.account.index') }}"
                >
                    <span class="icon-arrow-left rtl:icon-arrow-right text-2xl"></span>
                </a>
    
                <h2 class="text-2xl font-medium max-md:text-base ltr:ml-2.5 md:ltr:ml-0 rtl:mr-2.5 md:rtl:mr-0">
                    @lang('shop::app.customers.account.subscriptions.index.title')
                </h2>
            </div>

            <a
                href="https://staging.carsoft.tech/public/subscription-plan"
                class="secondary-button border-zinc-200 px-5 py-3 font-normal max-md:rounded-lg max-md:py-1.5 max-sm:text-sm"
            >
                @lang('shop::app.customers.account.subscriptions.index.view-subscription') 
            </a>
        </div>

        @if (! $subscriptions->isEmpty())
            <!-- Address Information -->

            {!! view_render_event('bagisto.shop.customers.account.subscriptions.list.before', ['subscription' => $subscriptions]) !!}

            <div class="mt-[60px] grid grid-cols-2 gap-5 max-1060:grid-cols-[1fr] max-md:mt-5">
                @foreach ($subscriptions as $subscription)
                    <div class="rounded-xl border border-zinc-200 p-5 max-md:flex-wrap">
                        <div class="flex justify-between">
                            <p class="text-base font-medium">
                                <span class="text-sm">
                                Subscribed At
                                 </span>
                                @if ($subscription->subscribed_at)
                                    <span class="text-xs">
                                    ({{ $subscription->subscribed_at }})
                                    </span>
                                @endif
                            </p>

                            <div class="flex gap-4 max-sm:gap-2.5">
                                @if ($subscription->subscribed_as)
                                    <div class="label-pending block h-fit w-max px-2.5 py-1 max-md:px-1.5">
                                        @lang('shop::app.customers.account.subscriptions.index.default-subscription') 
                                    </div>
                                @endif

                               <!-- Dropdown Actions -->
                                <x-shop::dropdown position="bottom-{{ core()->getCurrentLocale()->direction === 'ltr' ? 'right' : 'left' }}">
                                    <x-slot:toggle>
                                        <button 
                                            class="icon-more cursor-pointer rounded-md px-1.5 py-1 text-2xl text-zinc-500 transition-all hover:bg-gray-100 hover:text-black focus:bg-gray-100 focus:text-black max-md:p-0" 
                                            aria-label="More Options"
                                        >
                                        </button>
                                    </x-slot>
                                    
                                    <x-slot:menu class="!py-1 max-sm:!py-0">
                                     @if ($subscription->subscribed_as)
                                        <x-shop::dropdown.menu.item>
                                            <form
                                                method="POST"
                                                ref="addressDelete"
                                                action="{{ route('shop.customers.account.subscriptions.delete', $subscription->id) }}"
                                            >
                                                @method('DELETE')
                                                @csrf
                                            </form>

                                            <a 
                                                href="javascript:void(0);"                                                
                                                @click="$emitter.emit('open-confirm-modal', {
                                                    agree: () => {
                                                        $refs['addressDelete'].submit()
                                                    }
                                                })"
                                            >
                                                <p class="w-full">
                                                    @lang('shop::app.customers.account.subscriptions.index.delete')
                                                </p>
                                            </a>
                                        </x-shop::dropdown.menu.item>
                                         @endif

                                        @if (! $subscription->subscribed_as)
                                            <x-shop::dropdown.menu.item>
                                                <form
                                                    method="POST"
                                                    ref="setAsDefault"
                                                    action="{{ route('shop.customers.account.subscriptions.update.default', $subscription->id) }}"
                                                >
                                                    @method('PATCH')
                                                    @csrf

                                                </form>

                                                <a 
                                                    href="javascript:void(0);"                                                
                                                    @click="$emitter.emit('open-confirm-modal', {
                                                        agree: () => {
                                                            $refs['setAsDefault'].submit()
                                                        }
                                                    })"
                                                >
                                                    <button>
                                                        @lang('shop::app.customers.account.subscriptions.index.set-as-default')
                                                    </button>
                                                </a>
                                            </x-shop::dropdown.menu.item>
                                        @endif
                                    </x-slot>
                                </x-shop::dropdown>
                               
                            </div>
                        </div>
                        @if($plan = $subscription->plan)
                        <p class="mt-6 text-zinc-500 max-md:mt-5 max-md:text-sm">
                            Time Limit: {{ $plan->name }},
                            Service Request: {{ $plan->service_request }},
                            Daily Bought:{{ $plan->daily_download_bought }}, 
                            Daily Used: <span class="text-blue-600">{{ $subscription->status }}</span> 
                        </p>
                        @endif
                    </div>    
                @endforeach
            </div>

            {!! view_render_event('bagisto.shop.customers.account.subscriptions.list.after', ['addresses' => $subscriptions]) !!}

        @else
            <!-- Address Empty Page -->
            <div class="m-auto grid w-full place-content-center items-center justify-items-center py-32 text-center">
                <img 
                    class="max-md:h-[100px] max-md:w-[100px]"
                    src="{{ bagisto_asset('images/no-address.png') }}" 
                    alt="Empty Address" 
                    title=""
                >
                
                <p
                    class="text-xl max-md:text-sm"
                    role="heading"
                >
                    @lang('shop::app.customers.account.subscriptions.index.empty-subscription')
                </p>
            </div>    
        @endif
    </div>
</x-shop::layouts.account>
