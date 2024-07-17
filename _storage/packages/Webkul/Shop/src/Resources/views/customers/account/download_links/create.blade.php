<x-shop::layouts.account>
    <!-- Page Title -->
    <x-slot:title>
        @lang('shop::app.customers.account.download-links.create.add-new')
    </x-slot>

    <!-- Breadcrumbs -->
    @section('breadcrumbs')
        <x-shop::breadcrumbs name="downloadable-products" />
    @endSection
  <div class="flex items-center justify-between">
    <h2 class="mb-8 text-2xl font-medium">
        @lang('shop::app.customers.account.download-links.create.add-new')
    </h2>
    
     <x-shop::form method="put" enctype="multipart/form-data"
                action="{{ route('shop.customers.account.download-links.set-as-default') }}">
                <x-shop::modal>
                    <x-slot:toggle>
                        <div class="primary-button rounded-2xl px-11 py-3">
                            @lang('shop::app.customers.account.download-links.create.set-as-default')
                        </div>
                    </x-slot>

                    <x-slot:header>
                        <h2 class="text-2xl font-medium max-sm:text-xl">
                            @lang('shop::app.customers.account.download-links.create.set-as-default')
                        </h2>
                    </x-slot>

                    <x-slot:content>
                       <x-shop::form.control-group>
                        <x-shop::form.control-group.label class="text-left">
                            @lang('shop::app.customers.account.download-links.create.set-as-default-description')
                        </x-shop::form.control-group.label>
            
                        <x-shop::form.control-group.control
                            type="select"
                            name="download_purchased_id"
                            rules="required"
                            v-model="download_purchased_id"
                            aria-label="trans('shop::app.customers.account.download-links.create.choose-current-plan')"
                            :label="trans('shop::app.customers.account.download-links.create.choose-current-plan')"
                        >
                            <option value="">
                                @lang('shop::app.customers.account.download-links.create.choose-current-plan')
                            </option>
                         
                            @foreach ($plans as $plan)
                                <option value="{{ $plan->id }}">{{ $plan->service_request }} {{ $plan->time_limit }} 
                                @if($plan->subscribed_default) ({{ $plan->subscribed_default}}) @endif
                                </option>
                            @endforeach
                        </x-shop::form.control-group.control>
                        <x-shop::form.control-group.error control-name="download_purchased_id" class="text-left" />
                    </x-shop::form.control-group>
                        

                    </x-slot>

                    <!-- Modal Footer -->
                    <x-slot:footer>
                        <button type="submit"
                            class="primary-button flex rounded-2xl px-11 py-3 max-sm:px-6 max-sm:text-sm">
                            @lang('shop::app.customers.account.download-links.create.save-and-change')
                        </button>
                    </x-slot>
                </x-shop::modal>
            </x-shop::form>
</div>
    <v-create-customer-file-upolad>
        <!--file-upolad Shimmer-->
        <x-shop::shimmer.form.control-group :count="10" />
    </v-create-customer-file-upolad>

    @push('scripts')
        <script
            type="text/x-template"
            id="v-create-customer-file-upolad-template"
        >
      
            <div>
                <x-shop::form enctype="multipart/form-data" :action="route('shop.customers.account.download-links.store')">
                 
                  <div class="grid grid-cols-2 gap-4">

                       <!-- Brand Name  -->
                       <x-shop::form.control-group>
                        <x-shop::form.control-group.label class="required">
                            @lang('shop::app.customers.account.download-links.create.brand')
                        </x-shop::form.control-group.label>

                        <x-shop::form.control-group.control
                            type="text"
                            name="brand"
                            rules="required"
                            :value="old('brand')"
                            :label="trans('shop::app.customers.account.download-links.create.brand')"
                            :placeholder="trans('shop::app.customers.account.download-links.create.brand')"
                        />
                        <x-shop::form.control-group.error control-name="brand" />
                    </x-shop::form.control-group>

                    <!--  Model Name -->
                    <x-shop::form.control-group>
                        <x-shop::form.control-group.label class="required">
                            @lang('shop::app.customers.account.download-links.create.model')
                        </x-shop::form.control-group.label>

                        <x-shop::form.control-group.control
                            type="text"
                            name="model"
                            rules="required"
                            :value="old('model')"
                            :label="trans('shop::app.customers.account.download-links.create.model')"
                            :placeholder="trans('shop::app.customers.account.download-links.create.model')"
                        />

                        <x-shop::form.control-group.error control-name="model" />
                    </x-shop::form.control-group>
 
                 

                </div>
                <div class="grid grid-cols-2 gap-4">
                    <!-- Capacity -->
                    <x-shop::form.control-group>
                        <x-shop::form.control-group.label class="required">
                            @lang('shop::app.customers.account.download-links.create.capacity')
                        </x-shop::form.control-group.label>

                        <x-shop::form.control-group.control
                            type="text"
                            name="capacity"
                            rules="required"
                            :value="old('capacity')"
                            :label="trans('shop::app.customers.account.download-links.create.capacity')"
                            :placeholder="trans('shop::app.customers.account.download-links.create.capacity')"
                        />

                        <x-shop::form.control-group.error control-name="capacity" />
                    </x-shop::form.control-group>

                    <!-- Year -->
                    <x-shop::form.control-group>
                        <x-shop::form.control-group.label>
                            @lang('shop::app.customers.account.download-links.create.year')
                        </x-shop::form.control-group.label>

                        <x-shop::form.control-group.control
                            type="text"
                            name="year"
                            rules="required"
                            :value="old('year')"
                            :label="trans('shop::app.customers.account.download-links.create.year')"
                            :placeholder="trans('shop::app.customers.account.download-links.create.year')"
                        />

                        <x-shop::form.control-group.error control-name="year" />
                    </x-shop::form.control-group>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <!-- Serivce List-->
                    <x-shop::form.control-group>
                        <x-shop::form.control-group.label class="required">
                            @lang('shop::app.customers.account.download-links.create.service-request')
                        </x-shop::form.control-group.label>
            
                        <x-shop::form.control-group.control
                            type="select"
                            name="service_request"
                            rules="required"
                            v-model="service_request"
                            aria-label="trans('shop::app.customers.account.download-links.create.service-request')"
                            :label="trans('shop::app.customers.account.download-links.create.service-request')"
                        >
                            <option value="">
                                @lang('shop::app.customers.account.download-links.create.select-service-request')
                            </option>
                            @php
                                $service_requests = [
                                   [ 'name' => 'DTC', 'code' => 'DTC'],
                                   [ 'name' => 'DPF', 'code' => 'DPF'],
                                   [ 'name' => 'EGR', 'code' => 'EGR'],
                                   [ 'name' => 'Adblue', 'code' => 'Adblue'],
                                ];
                            @endphp
                            @foreach ($service_requests as $request)
                                <option value="{{ $request['code'] }}">{{ $request['name'] }}</option>
                            @endforeach
                        </x-shop::form.control-group.control>
                        <x-shop::form.control-group.error control-name="service_request" />
                    </x-shop::form.control-group>
                   
            <!-- DCT Code -->
            <x-shop::form.control-group>
                <x-shop::form.control-group.label>
                    @lang('shop::app.customers.account.download-links.create.dtc-code')
                </x-shop::form.control-group.label>

                <x-shop::form.control-group.control
                    type="text"
                    name="dtc_code"
                    :value="old('dtc_code')"
                    :label="trans('shop::app.customers.account.download-links.create.dtc-code')"
                    :placeholder="trans('shop::app.customers.account.download-links.create.dtc-code')"
                />
                <x-shop::form.control-group.error control-name="dtc_code" />
            </x-shop::form.control-group>
        </div>
           <!--VIN -->
           <x-shop::form.control-group>
            <x-shop::form.control-group.label>
                @lang('shop::app.customers.account.download-links.create.vin')
            </x-shop::form.control-group.label>

            <x-shop::form.control-group.control
                type="text"
                name="vin"
                rules="required"
                :value="old('vin')"
                :label="trans('shop::app.customers.account.download-links.create.vin')"
                :placeholder="trans('shop::app.customers.account.download-links.create.vin')"
            />

            <x-shop::form.control-group.error control-name="vin" />
        </x-shop::form.control-group>
                    <!-- File Name -->
                    <x-shop::form.control-group>
                        <x-shop::form.control-group.label class="required">
                            @lang('shop::app.customers.account.download-links.create.file')
                        </x-shop::form.control-group.label>

                        <x-shop::form.control-group.control
                            type="file"
                            name="attachment"
                            :value="old('attachment')"
                            :label="trans('shop::app.customers.account.download-links.create.file')"
                            :placeholder="trans('shop::app.customers.account.download-links.create.file')"
                        />

                        <x-shop::form.control-group.error control-name="attachment" />
                    </x-shop::form.control-group>

                    


                    <button
                        type="submit"
                        class="primary-button m-0 block w-max rounded-2xl px-11 py-3 text-center text-base"
                    >
                        @lang('shop::app.customers.account.download-links.create.save')
                    </button>

                    {!! view_render_event('bagisto.shop.customers.account.addresses.create_form_controls.after') !!}
                </x-shop::form>
                {!! view_render_event('bagisto.shop.customers.account.address.create.after') !!}
            </div>
        </script>

        <script type="module">
            app.component('v-create-customer-file-upolad', {
                template: '#v-create-customer-file-upolad-template',

                data() {
                    return {
                        //country: "{{ old('country') }}",

                        //state: "{{ old('state') }}",

                        //countryStates: @json(core()->groupedStatesByCountries()),
                    }
                },

                methods: {
                    haveStates() {
                        /*
                         * The double negation operator is used to convert the value to a boolean.
                         * It ensures that the final result is a boolean value,
                         * true if the array has a length greater than 0, and otherwise false.
                         */
                        //return !!this.countryStates[this.country]?.length;
                    },
                }
            });
        </script>
    @endpush

</x-shop::layouts.account>
