<x-shop::layouts.account>
    <!-- Page Title -->
    <x-slot:title>
        @lang('shop::app.customers.account.download-links.index.title')
    </x-slot>

    <!-- Breadcrumbs -->
    @section('breadcrumbs')
        <x-shop::breadcrumbs name="downloadable-products" />
    @endSection
    <div class="flex items-center justify-between">
        <a href="{{ route('shop.customers.account.download-links.create') }}"
            class="secondary-button flex items-center gap-x-2.5 border-zinc-200 px-5 py-3 font-normal">
            <span class="icon-search text-2xl"></span>
            @lang('shop::app.customers.account.download-links.index.add-new')
        </a>
        {{-- <div class="">
            <h2 class="text-2xl font-medium">
                @lang('shop::app.customers.account.analyze.index.title')
            </h2>
        </div> --}}


    </div>

    @if (!$uploads->isEmpty())
        <!-- upload Information -->

        <div class="mt-[60px] grid grid-cols-1 gap-5 max-1060:grid-cols-[1fr]">
            @foreach ($uploads as $upload)
                <div style="width: 60%" class="rounded-xl border border-zinc-200 p-5 max-sm:flex-wrap">
                    <div class="flex items-center justify-between">
                        <p class="text-base font-medium">
                            {{ $upload->vin }} 
                            @if ($upload->dtc_code)
                              <span class="text-sm text-blue-600"> ({{ $upload->dtc_code }}) </span> 
                            @endif
                        </p>
                        <p class="text-xs text-gray-100"> {{ $upload->created_at->diffForHumans() }}</p>
                        <div class="flex items-center gap-4">
                            <!-- Button Actions -->
                            <a href="{{ route('shop.customers.account.download-links.edit', $upload->id) }}">
                                <p class="w-full text-xs">
                                    @lang('shop::app.customers.account.download-links.index.view')
                                </p>
                            </a>
                        </div>
                    </div>
                    <p class="mt-6 text-zinc-500">
                        {{ $upload->service_request }},
                        {{ $upload->model }},
                        {{ $upload->brand }},
                        {{ $upload->capacity }},
                        {{ $upload->year }},
                
                    </p>
                </div>
            @endforeach
        </div>
    @else
        <!-- upload Empty Page -->
        <div class="m-auto grid h-[476px] w-full place-content-center items-center justify-items-center text-center">
            {{-- <img class="" src="{{ bagisto_asset('images/no-upload.png') }}" alt="" title=""> --}}
            <p class="text-xl">
                @lang('shop::app.customers.account.download-links.index.empty-upload')
            </p>
        </div>
    @endif
</x-shop::layouts.account>
