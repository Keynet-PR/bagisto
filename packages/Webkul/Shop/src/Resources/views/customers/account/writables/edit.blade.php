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

            <!-- File Send modal -->
            <x-shop::form method="put" enctype="multipart/form-data"
                action="{{ route('shop.customers.account.writables.update', $writable->id) }}">
                <x-shop::modal>
                    <x-slot:toggle>
                        <div class="primary-button rounded-2xl px-11 py-3">
                            @lang('shop::app.customers.account.writables.edit.send-new')
                        </div>
                    </x-slot>

                    <x-slot:header>
                        <h2 class="text-2xl font-medium max-sm:text-xl">
                            @lang('shop::app.customers.account.writables.edit.send-new')
                        </h2>
                    </x-slot>
                    <x-slot:content>
                        <x-shop::form.control-group class="!mb-0">
                            <x-shop::form.control-group.control type="file" name="attachment" class="px-6 py-5" />
                            <x-shop::form.control-group.error class="text-left" control-name="attachment" />
                        </x-shop::form.control-group>

                        <x-shop::form.control-group class="!mb-0">
                            <x-shop::form.control-group.control :value="$writable->service_request" type="hidden" name="service_request"
                                class="px-6 py-5" />
                            <x-shop::form.control-group.error class="text-left" control-name="service_request" />
                        </x-shop::form.control-group>

                    </x-slot>

                    <!-- Modal Footer -->
                    <x-slot:footer>
                        <button type="submit"
                            class="primary-button flex rounded-2xl px-11 py-3 max-sm:px-6 max-sm:text-sm">
                            @lang('shop::app.customers.account.writables.edit.upload')
                        </button>
                    </x-slot>
                </x-shop::modal>
            </x-shop::form>

        </div>
        <!-- File Downloads -->
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
                        @if (!$writable->files->isEmpty())
                            <tbody>
                                @foreach ($writable->files as $index => $item)
                                    <tr class="border-b">
                                        <td class="p-3">
                                            <a class="text-sm {{ !empty($item->admin_id) ? 'text-blue-600' : 'text-gray-600' }}"
                                                href="{{ route('shop.customers.account.writables.download', $item->id) }}"
                                                target="_blank">
                                                {{ $item->file_name }}
                                            </a>
                                            <span class="text-xs text-blue-300">{{ $item->file_size }}</span>
                                            @if ($item->admin_id)
                                                <p class="text-xs text-gray-600">{{ $item->created_by }} </p>
                                            @endif
                                        </td>
                                        <td class="mr-4 text-right">
                                            <p class="text-xs text-gray-100">{{ $item->created_at->diffForHumans() }}
                                            </p>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        @else
                            <tfoot>
                                <tr>
                                    <td class="mr-4 text-left">
                                        <p class="text-xs text-gray-100">empty!.</p>
                                    </td>
                                </tr>
                            </tfoot>
                        @endif
                    </table>

                </div>

                <div class="border p-6  rounded-xl">
                    <h2 class="mb-2 font-bold">Description:</h2>
                    <ul class="text-sm grid gap-2">
                        <li>Brand: {{ $writable->brand }}</li>
                        <li>Model: {{ $writable->model }}</li>
                        <li>Capacity: {{ $writable->capacity }}</li>
                        <li>Year: {{ $writable->year }}</li>
                        <li>Service Request: {{ $writable->service_request }}</li>
                        @if ($writable->dtc_code)
                            <li>DTC Code: {{ $writable->dtc_code }}</li>
                            <li>VIN: {{ $writable->vin }}</li>
                        @endif
                    </ul>
                    <hr class="mt-8 mb-6">
                    <h2 class="mb-2 font-bold">Billing:</h2>

                    <ul class="text-sm grid gap-2">
                        @if ($subscription = $writable->subscription)
                            <li>
                                Subscribed At: <span class="text-xs font-bold">
                                    {{ $subscription->subscribed_at }}
                                </span>
                            </li>
                            <li>Time Limit: {{ $subscription->plan->name }}</li>
                            <li>Daily Download Bought: {{ $subscription->plan->daily_download_bought }} </li>
                            <li>Daily Download Used: {{ $subscription->daily_download_used }} </li>
                            <li>Daily Status :
                                <span class="text-blue-600">
                                    {{ $subscription->status }}
                                </span>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-shop::layouts.account>
