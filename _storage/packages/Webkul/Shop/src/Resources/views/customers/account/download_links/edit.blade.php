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
        <h2 class="text-2xl font-medium">
            @lang('shop::app.customers.account.download-links.edit.title')
        </h2>
        <!-- File Send modal -->
            <x-shop::form method="put" enctype="multipart/form-data"
                action="{{ route('shop.customers.account.download-links.update', $downloads->id) }}">
                <x-shop::modal>
                    <x-slot:toggle>
                        <div class="primary-button rounded-2xl px-11 py-3">
                            @lang('shop::app.customers.account.download-links.edit.send-new')
                        </div>
                    </x-slot>

                    <x-slot:header>
                        <h2 class="text-2xl font-medium max-sm:text-xl">
                            @lang('shop::app.customers.account.download-links.edit.send-new')
                        </h2>
                    </x-slot>

                    <x-slot:content>
                        <x-shop::form.control-group class="!mb-0">
                            <x-shop::form.control-group.control type="file" name="attachment" class="px-6 py-5" />
                            <x-shop::form.control-group.error class="text-left" control-name="attachment" />
                        </x-shop::form.control-group>

                        <x-shop::form.control-group class="!mb-0">
                            <x-shop::form.control-group.control :value="$downloads->service_request" type="hidden" name="service_request"
                                class="px-6 py-5" />
                            <x-shop::form.control-group.error class="text-left" control-name="service_request" />
                        </x-shop::form.control-group>

                    </x-slot>

                    <!-- Modal Footer -->
                    <x-slot:footer>
                        <button type="submit"
                            class="primary-button flex rounded-2xl px-11 py-3 max-sm:px-6 max-sm:text-sm">
                            @lang('shop::app.customers.account.download-links.edit.upload')
                        </button>
                    </x-slot>
                </x-shop::modal>
            </x-shop::form>
      
    </div>

    <!-- Link Downloads -->
    <div class="mt-8 grid grid-cols-1 gap-y-6">
        <div class="flex gap-8">
            <div class="flex-1">

                <table class="w-full">
                    <thead>
                        <tr>
                            <th class="text-left">File Name</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($downloads->links as $index => $item)
                            <tr class="border-b">
                                <td class="p-3">
                                    <a class="text-sm {{ $item->admin_id ? 'text-blue-600' : 'text-gray-600' }}"
                                        href="{{ route('shop.customers.account.download-links.download', $item->id) }}"
                                        target="_blank">
                                        {{ $item->file_name }}
                                    </a>
                                    <span class="text-xs text-blue-300" >{{ $item->file_size }}</span>
                                    @if (!$item->customer_id)
                                        <p class="text-xs text-gray-600">{{ $item->created_by }} </p>
                                    @endif
                                </td>
                                <td class="mr-4 text-right">
                                    <p class="text-xs text-gray-100">{{ $item->created_at->diffForHumans() }}</p>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>

            </div>

            <div class="border p-6  rounded-xl">
                <h2 class="mb-2 font-bold">Description:</h2>

                <ul class="text-sm grid gap-2">
                    <li>Model: {{ $downloads->modal }}</li>
                    <li>Brand: {{ $downloads->brand }}</li>
                    <li>Capacity: {{ $downloads->capacity }}</li>
                    <li>Year: {{ $downloads->year }}</li>
                    <li>Service Request: {{ $downloads->service_request }}</li>
                    @if ($downloads->dtc_code)
                        <li>DTC Code: {{ $downloads->dtc_code }}</li>
                        <li>VIN: {{ $downloads->vin }}</li>
                    @endif
                </ul>
                <hr class="mt-8 mb-6">
                <h2 class="mb-2 font-bold">Billing:</h2>
                
                <ul class="text-sm grid gap-2">
                    @if ($downloads->purchased)
                        <li>
                            Subscription: <span class="text-xs font-bold"> {{ $downloads->purchased['subscription'] }}
                            </span>
                        </li>
                        <li>Time Limit: {{ $downloads->purchased['time_limit'] }}</li>
                        <li>Daily Download Bought: {{ $downloads->purchased['daily_download_bought'] }}</li>
                        <li>Daily Download Used: {{ $downloads->purchased['daily_download_used'] }} </li>
                        <li>Daily Status :
                            <span class="text-blue-600">
                                {{ $downloads->purchased['status'] }}
                            </span>
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</x-shop::layouts.account>
