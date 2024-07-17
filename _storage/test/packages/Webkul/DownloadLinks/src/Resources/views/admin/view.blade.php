<x-admin::layouts>
    <x-slot:title>
        @lang('download-link::app.admin.view.title', ['id' => $downloadCustomerLink->id])
    </x-slot>

    <div class="grid">
        <div class="flex items-center justify-between gap-4 max-sm:flex-wrap">
            <p class="text-xl font-bold leading-6 text-gray-800 dark:text-white">
                @lang('download-link::app.admin.view.title', ['id' => $downloadCustomerLink->id])
            </p>

            <div class="flex items-center gap-x-2.5">
                <!-- Back Button -->
                <a href="{{ route('download-customer-links.admin.index') }}"
                    class="transparent-button hover:bg-gray-200 dark:text-white dark:hover:bg-gray-800">
                    @lang('download-link::app.admin.view.back-btn')
                </a>
            </div>
        </div>
    </div>
    <!-- Send File Modal -->
    <div>
        <button type="button"
            class="inline-flex w-full max-w-max cursor-pointer items-center justify-between gap-x-2 px-1 py-1.5 text-center font-semibold text-gray-600 transition-all hover:rounded-md hover:bg-gray-200 dark:text-gray-300 dark:hover:bg-gray-800"
            @click="$refs.groupCreateModal.open()">
            <span class="icon-mail text-2xl"></span>
            @lang('download-link::app.admin.view.send-file')
        </button>

        <x-admin::form enctype="multipart/form-data" :action="route('downloadable-links.admin.send-file', $downloadCustomerLink->id)">
            <!-- Create Group Modal -->
            <x-admin::modal ref="groupCreateModal">
                <!-- Modal Header -->
                <x-slot:header>
                    <p class="text-lg font-bold text-gray-800 dark:text-white">
                        @lang('download-link::app.admin.view.send-file')
                    </p>
                </x-slot>

                <!-- Modal Content -->
                <x-slot:content>
                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label class="required">
                            @lang('download-link::app.admin.view.file')
                        </x-admin::form.control-group.label>
                        <x-admin::form.control-group.control type="file" id="attachment" name="attachment"
                            rules="required" :label="trans('download-link::app.admin.view.file')" />
                        <x-admin::form.control-group.error control-name="attachment" />
                    </x-admin::form.control-group>
                </x-slot>

                <!-- Modal Footer -->
                <x-slot:footer>
                    <div class="flex items-center gap-x-2.5">
                        <button type="submit" class="primary-button">
                            @lang('download-link::app.admin.view.send')
                        </button>
                    </div>
                </x-slot>
            </x-admin::modal>
        </x-admin::form>
    </div>

    <!-- body content -->
    <div class="mt-3.5 flex gap-2.5 max-xl:flex-wrap">
        <!-- Left sub-component -->
        <div class="flex flex-1 flex-col gap-2 max-xl:flex-auto">
            <!-- General -->
            <div class="box-shadow rounded bg-white dark:bg-gray-900">
                <p class="mb-4 p-4 text-base font-semibold text-gray-800 dark:text-white">
                    @lang('download-link::app.admin.view.download-links') ({{ count($downloadCustomerLink->links) }})
                </p>

                <div class="grid">
                    <!-- Files -->
                    @foreach ($downloadCustomerLink->links as $index => $item)
                        <div class="flex justify-between gap-2.5 px-4 py-4">
                            <div class="flex gap-2.5">
                                <div class="grid place-content-start gap-1.5">
                                    <p class="text-gray-600 dark:text-gray-300">
                                    <div>
                                        <a class="text-sm {{ $item->customer_id ? 'text-blue-600' : 'text-gray-600' }}"
                                            href="{{ route('downloadable-links.admin.download-link', $item->id) }}"
                                            target="_blank">
                                            {{ $item->file_name }}
                                        </a>
                                        @if ($item->customer_id)
                                            <p class="text-xs text-gray-600">{{ $item->created_by }}</p>
                                        @endif
                                    </div>
                                    </p>
                                </div>
                            </div>
                            <div class="grid place-content-start gap-1 text-right">
                                <div class="flex items-center gap-x-5">
                                    <p class="text-xs text-gray-500">
                                        {{ $item->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        @if ($index < count($downloadCustomerLink->links) - 1)
                            <span class="block w-full border-b dark:border-gray-800"></span>
                        @endif
                    @endforeach
                </div>
            </div>
            {!! view_render_event('bagisto.admin.customers.customers.view.card.notes.before') !!}
            @include('admin::customers.customers.view.notes')
            {!! view_render_event('bagisto.admin.customers.customers.view.card.notes.after') !!}
        </div>

        <!-- Right sub-component -->
        <div class="flex w-[360px] max-w-full flex-col gap-2 max-sm:w-full">
            <!-- component 1 -->
            <x-admin::accordion>
                <x-slot:header>
                    <p class="p-2.5 text-base font-semibold text-gray-600 dark:text-gray-300">
                        @lang('admin::app.sales.shipments.view.customer')
                    </p>
                </x-slot>

                <x-slot:content>
                    <div class="flex flex-col pb-4">
                        @if ($customer->first_name || $customer->email)
                            <!-- Customer Full Name -->
                            <p class="font-semibold text-gray-800 dark:text-white">
                                {{ $customer->first_name . ' ' . $customer->last_name }}
                            </p>

                            <!-- Customer Email -->
                            <p class="text-gray-600 dark:text-gray-300">
                                {{ $customer->email }}
                            </p>
                        @endif
                    </div>

                    <span class="block w-full border-b dark:border-gray-800"></span>

                    @if ($downloadCustomerLink->model || downloadCustomerLink->vin)
                        <!-- Description -->
                        @if ($downloadCustomerLink->vin)
                            <div class="flex items-center justify-between">
                                <p class="py-4 text-base font-semibold text-gray-600 dark:text-gray-300">
                                    @lang('download-link::app.admin.view.description')
                                </p>
                            </div>
                            <div>
                                <p class="!leading-6 text-gray-600 dark:text-gray-300">
                                    Model : {{ $downloadCustomerLink->model }}
                                </p>
                                <p class="!leading-6 text-gray-600 dark:text-gray-300">
                                    Brand : {{ $downloadCustomerLink->brand }}
                                </p>
                                <p class="!leading-6 text-gray-600 dark:text-gray-300">
                                    Year : {{ $downloadCustomerLink->year }}
                                </p>
                                <p class="!leading-6 text-gray-600 dark:text-gray-300">
                                    Capacity : 3.0
                                </p>
                                <p class="!leading-6 text-gray-600 dark:text-gray-300">
                                    Service Request : {{ $downloadCustomerLink->service_request }}
                                </p>
                                <p class="!leading-6 text-gray-600 dark:text-gray-300">
                                    VIN: {{ $downloadCustomerLink->vin }}
                                </p>
                            </div>
                            {{-- @include ('admin::sales.address', ['address' => $order->billing_address]) --}}
                        @endif
                    @endif

                    <span class="block w-full border-b mt-4 dark:border-gray-800"></span>

                    <!-- Billing  -->
                    <div class="flex items-center justify-between">
                        <p class="py-4 text-base font-semibold text-gray-600 dark:text-gray-300">
                            @lang('download-link::app.admin.view.billing')
                        </p>
                    </div>
                    <div>
                        @if ($purchased = $downloadCustomerLink->purchased)
                            <p class="!leading-6 text-gray-600 dark:text-gray-300">
                                Subscription:
                                <span class="text-xs font-bold">
                                    {{ $purchased['subscription'] }}
                                </span>
                            </p>
                            <p class="!leading-6 text-gray-600 dark:text-gray-300">
                                Daily Download Bought : {{ $purchased['daily_download_bought'] }}
                            </p>
                            <p class="!leading-6 text-gray-600 dark:text-gray-300">
                                Daily Download Used : {{ $downloadCustomerLink->daily_download_used }}
                            </p>
                            <p class="!leading-6 text-gray-600  dark:text-gray-300">
                                Status : <span class="text-blue-600">{{ $downloadCustomerLink->status }}</span> 
                            </p>
                        @endif

                    </div>

                </x-slot>
            </x-admin::accordion>
        </div>
    </div>
</x-admin::layouts>
