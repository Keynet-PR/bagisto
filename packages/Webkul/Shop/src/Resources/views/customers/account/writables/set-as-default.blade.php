<x-shop::layouts.account>
    <!-- Page Title -->
    <x-slot:title>
        @lang('shop::app.customers.account.download-links.create.set-as-default')
    </x-slot>

    <!-- Breadcrumbs -->
    @section('breadcrumbs')
        <x-shop::breadcrumbs name="downloadable-products" />
    @endSection

    <h2 class="mb-8 text-2xl font-medium">
        @lang('shop::app.customers.account.download-links.create.set-as-default')
    </h2>

    <v-create-subscribe-default>
        <!--subscribe-default Shimmer-->
        <x-shop::shimmer.form.control-group :count="10" />
    </v-create-subscribe-default>

    @push('scripts')
        <script
            type="text/x-template"
            id="v-create-subscribe-default-template"
        >
      
            <div>
                <x-shop::form enctype="multipart/form-data" :action="route('shop.customers.account.download-links.store.subscribe-default')">
                <div class="grid grid-cols-2 gap-4">
                    <!-- Serivce List-->
                    <x-shop::form.control-group>
                        <x-shop::form.control-group.label class="{{ core()->isCountryRequired() ? 'required' : '' }}">
                            @lang('shop::app.customers.account.download-links.create.set-as-default')
                        </x-shop::form.control-group.label>
            
                        <x-shop::form.control-group.control
                            type="select"
                            name="download_purchased_id"
                            rules="'required"
                            v-model="download_purchased_id"
                            aria-label="trans('shop::app.customers.account.download-links.create.set-as-default')"
                            :label="trans('shop::app.customers.account.download-links.create.set-as-default')"
                        >
                            <option value="">
                                @lang('shop::app.customers.account.download-links.create.set-as-default')
                            </option>
                    
                            @foreach ($downloadPurchased as $purchased)
                                <option value="{{ $purchased->id }}">{{ $purchased->service_request }}</option>
                            @endforeach
                        </x-shop::form.control-group.control>
                        <x-shop::form.control-group.error control-name="download_purchased_id " />
                    </x-shop::form.control-group>
        </div>
          

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
            app.component('v-create-subscribe-default', {
                template: '#v-create-subscribe-default-template',

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
