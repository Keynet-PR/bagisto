<x-admin::layouts>
    <x-slot:title>
        @lang('wp::app.admin.view.title', ['id' => $writable->id])
    </x-slot>

    <div class="grid">
        <div class="flex items-center justify-between gap-4 max-sm:flex-wrap">
            <p class="text-xl font-bold leading-6 text-gray-800 dark:text-white">
                @lang('wp::app.admin.view.title', ['id' => $writable->id])
            </p>

            <div class="flex items-center gap-x-2.5">
                <!-- Back Button -->
                <a href="{{ route('admin.writeprogram.index') }}"
                    class="transparent-button hover:bg-gray-200 dark:text-white dark:hover:bg-gray-800">
                    @lang('wp::app.admin.view.back-btn')
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
            @lang('wp::app.admin.view.send-file')
        </button>

        <x-admin::form enctype="multipart/form-data" :action="route('admin.writeprogram.send-file', $writable->id)">
            <!-- Create Group Modal -->
            <x-admin::modal ref="groupCreateModal">
                <!-- Modal Header -->
                <x-slot:header>
                    <p class="text-lg font-bold text-gray-800 dark:text-white">
                        @lang('wp::app.admin.view.send-file')
                    </p>
                </x-slot>

                <!-- Modal Content -->
                <x-slot:content>
                    <x-admin::form.control-group>
                        <x-admin::form.control-group.label class="required">
                            @lang('wp::app.admin.view.file')
                        </x-admin::form.control-group.label>
                        <x-admin::form.control-group.control type="file" id="attachment" name="attachment"
                            rules="required" :label="trans('wp::app.admin.view.file')" />
                        <x-admin::form.control-group.error control-name="attachment" />
                    </x-admin::form.control-group>
                </x-slot>

                <!-- Modal Footer -->
                <x-slot:footer>
                    <div class="flex items-center gap-x-2.5">
                        <button type="submit" class="primary-button">
                            @lang('wp::app.admin.view.send')
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
                    @lang('wp::app.admin.view.writables') ({{ count($writable->files) }})
                </p>

                <div class="grid">
                    <!-- Files -->
                    @foreach ($writable->files as $index => $item)
                        <div class="flex justify-between gap-2.5 px-4 py-4">
                            <div class="flex gap-2.5">
                                <div class="grid place-content-start gap-1.5">
                                    <p class="text-gray-600 dark:text-gray-300">
                                    <div>
                                        <a class="text-sm {{ $item->customer_id ? 'text-blue-600' : 'text-gray-600' }}"
                                            href="{{ route('admin.writeprogram.download-file', $item->id) }}"
                                            target="_blank">
                                            {{ $item->file_name }}
                                        </a>
                                        <span class="text-xs text-blue-300" >{{ $item->file_size }}</span>
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
                        @if ($index < count($writable->files) - 1)
                            <span class="block w-full border-b dark:border-gray-800"></span>
                        @endif
                    @endforeach
                </div>
            </div>
            {!! view_render_event('bagisto.admin.customers.customers.view.card.notes.before') !!}
            {{-- @include('admin::customers.customers.view.notes') --}}
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
                        @if ($customer = $writable->subscription->customer)
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

                    @if ($writable->model AND $writable->vin)
                        <!-- Description -->
                        @if ($writable->vin)
                            <div class="flex items-center justify-between">
                                <p class="py-4 text-base font-semibold text-gray-600 dark:text-gray-300">
                                    @lang('wp::app.admin.view.description')
                                </p>
                            </div>
                            <div>
                                <p class="!leading-6 text-gray-600 dark:text-gray-300">
                                    Model : {{ $writable->model }}
                                </p>
                                <p class="!leading-6 text-gray-600 dark:text-gray-300">
                                    Brand : {{ $writable->brand }}
                                </p>
                                <p class="!leading-6 text-gray-600 dark:text-gray-300">
                                    Year : {{ $writable->year }}
                                </p>
                                <p class="!leading-6 text-gray-600 dark:text-gray-300">
                                    Capacity : 3.0
                                </p>
                                <p class="!leading-6 text-gray-600 dark:text-gray-300">
                                    Service Request : {{ $writable->service_request }}
                                </p>
                                <p class="!leading-6 text-gray-600 dark:text-gray-300">
                                    VIN: {{ $writable->vin }}
                                </p>
                            </div>
                            {{-- @include ('admin::sales.address', ['address' => $order->billing_address]) --}}
                        @endif
                    @endif

                    <span class="block w-full border-b mt-4 dark:border-gray-800"></span>

                    <!-- Billing  -->
                    <div class="flex items-center justify-between">
                        <p class="py-4 text-base font-semibold text-gray-600 dark:text-gray-300">
                            @lang('wp::app.admin.view.billing')
                        </p>
                    </div>
                    <div>
                        @if ($subscription = $writable->subscription)
                            <p class="!leading-6 text-gray-600 dark:text-gray-300">
                                Subscribed At:
                                <span class="text-xs font-bold">
                                    {{ $subscription->subscribed_at }}
                                </span>
                            </p>
                            <p class="!leading-6 text-gray-600 dark:text-gray-300">
                                Time Limit: {{ $subscription->plan->name }}
                            </p>
                            <p class="!leading-6 text-gray-600 dark:text-gray-300">
                                Daily Download Bought : {{ $subscription->plan->daily_download_bought }}
                            </p>
                            <p class="!leading-6 text-gray-600 dark:text-gray-300">
                                Daily Download Used : {{ $subscription->daily_download_used }}
                            </p>
                            <p class="!leading-6 text-gray-600  dark:text-gray-300">
                                Status : <span class="text-blue-600">{{ $subscription->status }}</span> 
                            </p>
                        @endif

                    </div>

                </x-slot>
            </x-admin::accordion>
        </div>
    </div>
</x-admin::layouts>
