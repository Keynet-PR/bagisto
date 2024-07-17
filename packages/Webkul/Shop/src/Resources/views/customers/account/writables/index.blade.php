<x-shop::layouts.account>
    <!-- Page Title -->
    <x-slot:title>
        @lang('shop::app.customers.account.writables.title')
    </x-slot>
    
    <!-- Breadcrumbs -->
    @section('breadcrumbs')
        <x-shop::breadcrumbs name="downloadable-products" />
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
                <div>
                <h2 class="text-2xl font-medium max-md:text-base ltr:ml-2.5 md:ltr:ml-0 rtl:mr-2.5 md:rtl:mr-0">
                    @lang('shop::app.customers.account.writables.create.title')
                </h2>
                <a
                    href="{{ route('shop.customers.account.subscriptions.index') }}"
                    class="py-3 font-normal text-blue-600 max-md:py-1.5 max-sm:text-sm"
                >
                    @lang('shop::app.customers.account.writables.create.view-current-plans')
                </a>
                </div>
            </div>

            <a
                href="{{ route('shop.customers.account.writables.create') }}"
                class="secondary-button border-zinc-200 px-5 py-0 font-normal max-md:rounded-lg max-md:py-1.5 max-sm:text-sm"
            >
            @lang('shop::app.customers.account.writables.create.add-new')
            </a>
        </div>
        @if (!$writables->isEmpty())
        <!-- writable Information -->

        <div class="mt-[60px] grid grid-cols-1 gap-5 max-1060:grid-cols-[1fr]">
            @foreach ($writables as $writable)
                <div style="width: 60%" class="rounded-xl border border-zinc-200 p-5 max-sm:flex-wrap">
                    <div class="flex items-center justify-between">
                        <p class="text-base font-medium">
                            {{ $writable->vin }} 
                            @if ($writable->dtc_code)
                              <span class="text-sm text-blue-600"> ({{ $writable->dtc_code }}) </span> 
                            @endif
                        </p>
                        <p class="text-xs text-gray-100"> {{ $writable->created_at->diffForHumans() }}</p>
                        <div class="flex items-center gap-4">
                            <!-- Button Actions -->
                            <a href="{{ route('shop.customers.account.writables.edit', $writable->id) }}">
                                <p class="w-full text-xs">
                                    @lang('shop::app.customers.account.writables.index.view')
                                </p>
                            </a>
                        </div>
                    </div>
                    <p class="mt-6 text-zinc-500">
                        {{ $writable->service_request }},
                        {{ $writable->model }},
                        {{ $writable->brand }},
                        {{ $writable->capacity }},
                        {{ $writable->year }}, 
                        <span class="text-blue-600 text-xs">{{ $writable->status =='file_completed' ?'completed' :'created' }}</span>
                        
                
                    </p>
                </div>
            @endforeach
        </div>
    @else
        <!-- writable Empty Page -->
        <div class="m-auto grid h-[476px] w-full place-content-center items-center justify-items-center text-center">
            {{-- <img class="" src="{{ bagisto_asset('images/no-writable.png') }}" alt="" title=""> --}}
            <p class="text-xl">
                @lang('shop::app.customers.account.writables.index.empty-writable')
            </p>
        </div>
    @endif
       
    </div>
</x-shop::layouts.account>

 