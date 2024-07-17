<!--
    This code needs to be refactored to reduce the amount of PHP in the Blade
    template as much as possible.
-->
@php
    $showCompare = (bool) core()->getConfigData('general.content.shop.compare_option');

    $showWishlist = (bool) core()->getConfigData('general.content.shop.wishlist_option');
@endphp

<div class="gap-4 flex-wrap px-4 pb-4 pt-6 hidden shadow-sm max-lg:flex">
    <div class="w-full flex justify-between items-center">
        <!-- Left Navigation -->
        <div class="flex items-center gap-x-1.5">
            {!! view_render_event('bagisto.shop.components.layouts.header.mobile.drawer.before') !!}

            <x-shop::drawer
                position="left"
                width="80%"
            >
                <x-slot:toggle>
                    <span class="icon-hamburger text-2xl cursor-pointer"></span>
                </x-slot>

                <x-slot:header>
                    <div class="flex justify-between items-center">
                        <a href="{{ route('shop.home.index') }}">
                            <img
                                src="{{ core()->getCurrentChannel()->logo_url ?? bagisto_asset('images/logo.svg') }}"
                                alt="{{ config('app.name') }}"
                                width="131"
                                height="29"
                            >
                        </a>
                    </div>
                </x-slot>

                <x-slot:content>
                    <!-- Account Profile Hero Section -->
                    <div class="grid grid-cols-[auto_1fr] gap-4 items-center mb-4 p-2.5 border border-[#E9E9E9] rounded-xl">
                        <div class="">
                            <img
                                src="{{ auth()->user()?->image_url ??  bagisto_asset('images/user-placeholder.png') }}"
                                class="w-[60px] h-[60px] rounded-full"
                            >
                        </div>

                        @guest('customer')
                            <a
                                href="{{ route('shop.customer.session.create') }}"
                                class="flex text-base font-medium"
                            >
                                @lang('Sign up or Login')

                                <i class="icon-double-arrow text-2xl ltr:ml-2.5 rtl:mr-2.5"></i>
                            </a>
                        @endguest

                        @auth('customer')
                            <div class="flex flex-col gap-2.5 justify-between">
                                <p class="text-2xl font-mediums">Hello! {{ auth()->user()?->first_name }}</p>

                                <p class="text-[#6E6E6E] ">{{ auth()->user()?->email }}</p>
                            </div>
                        @endauth
                    </div>
                    
                            <!--<a href="{{ route('shop.home.index') }}">HOME</a>-->
                            

                    <!-- Mobile category view -->
                    <v-mobile-category></v-mobile-category>

                    <!-- Localization & Currency Section -->
                    <div class="absolute w-full flex bottom-0 left-0 bg-white shadow-lg p-4 gap-x-5 justify-between items-center mb-4">
                        <x-shop::dropdown position="top-left">
                            <!-- Dropdown Toggler -->
                            <x-slot:toggle>
                                <div class="w-full flex gap-2.5 justify-between items-center cursor-pointer" role="button">
                                    <span>
                                        {{ core()->getCurrentCurrency()->symbol . ' ' . core()->getCurrentCurrencyCode() }}
                                    </span>

                                    <span
                                        class="icon-arrow-down text-2xl"
                                        role="presentation"
                                    ></span>
                                </div>
                            </x-slot>

                            <!-- Dropdown Content -->
                            <x-slot:content class="!p-0">
                                <v-currency-switcher></v-currency-switcher>
                            </x-slot>
                        </x-shop::dropdown>
                        
                        
                        <x-shop::dropdown position="top-right">
                            <x-slot:toggle>
                                <!-- Dropdown Toggler -->
                                <div
                                    class="w-full flex gap-2.5 justify-between items-center cursor-pointer"
                                    role="button"
                                >
                                    <img
                                        src="{{ ! empty(core()->getCurrentLocale()->logo_url)
                                                ? core()->getCurrentLocale()->logo_url
                                                : bagisto_asset('images/default-language.svg')
                                            }}"
                                        class="h-full"
                                        alt="Default locale"
                                        width="24"
                                        height="16"
                                    />

                                    <span>
                                        {{ core()->getCurrentChannel()->locales()->orderBy('name')->where('code', app()->getLocale())->value('name') }}
                                    </span>

                                    <span
                                        class="icon-arrow-down text-2xl"
                                        role="presentation"
                                    ></span>
                                </div>
                            </x-slot>

                            <!-- Dropdown Content -->
                            <x-slot:content class="!p-0">
                                <v-locale-switcher></v-locale-switcher>
                            </x-slot>
                        </x-shop::dropdown>
                    </div>
                </x-slot>

                <x-slot:footer></x-slot>
            </x-shop::drawer>

            {!! view_render_event('bagisto.shop.components.layouts.header.mobile.drawer.after') !!}

            {!! view_render_event('bagisto.shop.components.layouts.header.mobile.logo.before') !!}

            <a
                href="{{ route('shop.home.index') }}"
                class="max-h-[30px]"
                aria-label="@lang('shop::app.components.layouts.header.bagisto')"
            >
                <img
                    src="{{ core()->getCurrentChannel()->logo_url ?? bagisto_asset('images/logo.svg') }}"
                    alt="{{ config('app.name') }}"
                    width="131"
                    height="29"
                >
            </a>
            <div style="margin-right:30px"></div>
            
            <div style="  display: grid;grid-template-columns: auto auto auto;gap: 20px;">   
        
<a href="https://carsoft.tech/public/storage/theme/5/Mv0Jild8LzIobtxqyf8prY9v7JBpJkHIcBixTAUc.webp" class="underline" target="_blank" title="Whatapp">

<svg height="20px" width="20px" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
	 viewBox="0 0 58 58" xml:space="preserve">
<g>
	<path style="fill:#2CB742;" d="M0,58l4.988-14.963C2.457,38.78,1,33.812,1,28.5C1,12.76,13.76,0,29.5,0S58,12.76,58,28.5
		S45.24,57,29.5,57c-4.789,0-9.299-1.187-13.26-3.273L0,58z"/>
	<path style="fill:#FFFFFF;" d="M47.683,37.985c-1.316-2.487-6.169-5.331-6.169-5.331c-1.098-0.626-2.423-0.696-3.049,0.42
		c0,0-1.577,1.891-1.978,2.163c-1.832,1.241-3.529,1.193-5.242-0.52l-3.981-3.981l-3.981-3.981c-1.713-1.713-1.761-3.41-0.52-5.242
		c0.272-0.401,2.163-1.978,2.163-1.978c1.116-0.627,1.046-1.951,0.42-3.049c0,0-2.844-4.853-5.331-6.169
		c-1.058-0.56-2.357-0.364-3.203,0.482l-1.758,1.758c-5.577,5.577-2.831,11.873,2.746,17.45l5.097,5.097l5.097,5.097
		c5.577,5.577,11.873,8.323,17.45,2.746l1.758-1.758C48.048,40.341,48.243,39.042,47.683,37.985z"/>
</g>
</svg></a>



<a href="https://t.me/carsofttech" class="underline" target="_blank" title="Telegram">

<svg height="20px" width="20px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
	 viewBox="0 0 512 512" xml:space="preserve">
<circle style="fill:#47B0D3;" cx="256" cy="256" r="256"/>
<path style="fill:#3298BA;" d="M34.133,256c0-135.648,105.508-246.636,238.933-255.421C267.424,0.208,261.737,0,256,0
	C114.615,0,0,114.615,0,256s114.615,256,256,256c5.737,0,11.424-0.208,17.067-0.579C139.642,502.636,34.133,391.648,34.133,256z"/>
<path style="fill:#E5E5E5;" d="M380.263,109.054c-2.486-1.69-5.676-1.946-8.399-0.679L96.777,236.433
	c-4.833,2.251-7.887,7.172-7.766,12.501c0.117,5.226,3.28,9.92,8.065,12.015l253.613,110.457c8.468,3.849,18.439-2.21,18.983-11.453
	l14.314-243.341C384.161,113.614,382.748,110.742,380.263,109.054z"/>
<polygon style="fill:#CCCCCC;" points="171.631,293.421 188.772,408 379.168,108.432 "/>
<path style="fill:#FFFFFF;" d="M371.866,108.375L96.777,236.433c-4.737,2.205-7.826,7.121-7.769,12.345
	c0.058,5.233,3.276,10.074,8.067,12.171l74.557,32.471l207.536-184.988C376.882,107.33,374.203,107.287,371.866,108.375z"/>
<polygon style="fill:#E5E5E5;" points="211.418,310.749 188.772,408 379.168,108.432 "/>
<path style="fill:#FFFFFF;" d="M380.263,109.054c-0.351-0.239-0.72-0.442-1.095-0.622l-167.75,202.317l139.27,60.657
	c8.468,3.849,18.439-2.21,18.983-11.453l14.314-243.341C384.161,113.614,382.748,110.742,380.263,109.054z"/>
</svg> </a>



<a href="https://carsoft.tech/public/storage/theme/5/sCpnZcfBVd7sf5jTerqySUOEI9dgDcnLBw2ZRXKI.webp" class="underline" target="_blank" title="Wechat">
<svg height="20px" style="enable-background:new 0 0 512 512;" version="1.1" viewBox="0 0 512 512" width="20px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><g id="_x33_71-wechat"><g><g><path d="M342.248,169.517c8.712,0,17.221,0.724,25.616,1.759C352.687,104.625,282.682,54.21,198.503,54.21     c-95.28,0-172.502,64.541-172.502,144.134c0,45.889,25.819,86.602,65.866,112.945l-22.742,45.605l61.953-26.608     c13.285,4.731,27.09,8.627,41.835,10.44c-2.015-8.796-3.16-17.813-3.16-27.068C169.753,234.178,247.115,169.517,342.248,169.517z      M256.003,119.066c11.905,0,21.56,9.685,21.56,21.623c0,11.942-9.654,21.62-21.56,21.62c-11.912,0-21.563-9.678-21.563-21.62     C234.44,128.75,244.091,119.066,256.003,119.066z M141.001,162.309c-11.907,0-21.562-9.678-21.562-21.62     c0-11.938,9.656-21.623,21.562-21.623s21.563,9.685,21.563,21.623C162.563,152.631,152.906,162.309,141.001,162.309z" style="fill:#51C332;"/><path d="M485.999,313.656c0-63.684-64.376-115.312-143.751-115.312     c-79.378,0-143.745,51.628-143.745,115.312c0,63.679,64.367,115.308,143.745,115.308c13.054,0,25.471-1.845,37.519-4.465     l77.483,33.291l-26.798-53.701C464.035,382.983,485.999,350.527,485.999,313.656z M299.125,306.448     c-11.906,0-21.563-9.681-21.563-21.625c0-11.938,9.656-21.616,21.563-21.616c11.91,0,21.561,9.682,21.561,21.616     C320.686,296.768,311.033,306.448,299.125,306.448z M385.373,306.448c-11.912,0-21.561-9.681-21.561-21.625     c0-11.938,9.648-21.616,21.561-21.616c11.911,0,21.563,9.682,21.563,21.616C406.936,296.768,397.284,306.448,385.373,306.448z" style="fill:#51C332;"/></g></g></g><g id="Layer_1"/></svg> </a>
 </div>

            
            
            {!! view_render_event('bagisto.shop.components.layouts.header.mobile.logo.after') !!}
        </div>

        <!-- Right Navigation -->
        <div>
            <div class="flex items-center gap-x-5">
                {!! view_render_event('bagisto.shop.components.layouts.header.mobile.compare.before') !!}

                @if($showCompare)
                    <a
                        href="{{ route('shop.compare.index') }}"
                        aria-label="@lang('shop::app.components.layouts.header.compare')"
                    >
                        <span class="icon-compare text-2xl cursor-pointer"></span>
                    </a>
                @endif

                {!! view_render_event('bagisto.shop.components.layouts.header.mobile.compare.after') !!}

                {!! view_render_event('bagisto.shop.components.layouts.header.mobile.mini_cart.before') !!}

                @include('shop::checkout.cart.mini-cart')

                {!! view_render_event('bagisto.shop.components.layouts.header.mobile.mini_cart.after') !!}

                <x-shop::dropdown position="bottom-{{ core()->getCurrentLocale()->direction === 'ltr' ? 'right' : 'left' }}">
                    <x-slot:toggle>
                        <span class="icon-users text-2xl cursor-pointer"></span>
                    </x-slot>

                    <!-- Guest Dropdown -->
                    @guest('customer')
                        <x-slot:content>
                            <div class="grid gap-2.5">
                                <p class="text-xl font-dmserif">
                                    @lang('shop::app.components.layouts.header.welcome-guest')
                                </p>

                                <p class="text-sm">
                                    @lang('shop::app.components.layouts.header.dropdown-text')
                                </p>
                            </div>

                            <p class="w-full mt-3 py-2px border border-[#E9E9E9]"></p>

                            <div class="flex gap-4 mt-6">
                                {!! view_render_event('bagisto.shop.components.layouts.header.mobile.index.sign_in_button.before') !!}

                                <a
                                    href="{{ route('shop.customer.session.create') }}"
                                    class="block w-max mx-auto m-0 ltr:ml-0 rtl:mr-0 py-4 px-7 bg-navyBlue rounded-2xl text-white text-base font-medium text-center cursor-pointer"
                                >
                                    @lang('shop::app.components.layouts.header.sign-in')
                                </a>

                                <a
                                    href="{{ route('shop.customers.register.index') }}"
                                    class="block w-max mx-auto m-0 ltr:ml-0 rtl:mr-0 py-3.5 px-7 bg-white border-2 border-navyBlue rounded-2xl text-navyBlue text-base font-medium  text-center cursor-pointer"
                                >
                                    @lang('shop::app.components.layouts.header.sign-up')
                                </a>

                                {!! view_render_event('bagisto.shop.components.layouts.header.mobile.index.sign_in_button.after') !!}
                            </div>
                        </x-slot>
                    @endguest

                    <!-- Customers Dropdown -->
                    @auth('customer')
                        <x-slot:content class="!p-0">
                            <div class="grid gap-2.5 p-5 pb-0">
                                <p class="text-xl font-dmserif">
                                    @lang('shop::app.components.layouts.header.welcome')’
                                    {{ auth()->guard('customer')->user()->first_name }}
                                </p>

                                <p class="text-sm">
                                    @lang('shop::app.components.layouts.header.dropdown-text')
                                </p>
                            </div>

                            <p class="w-full mt-3 py-2px border border-[#E9E9E9]"></p>

                            <div class="grid gap-1 mt-2.5 pb-2.5">
                                {!! view_render_event('bagisto.shop.components.layouts.header.mobile.index.profile_dropdown.links.before') !!}

                                <a
                                    class="px-5 py-2 text-base hover:bg-gray-100 cursor-pointer"
                                    href="{{ route('shop.customers.account.profile.index') }}"
                                >
                                    @lang('shop::app.components.layouts.header.profile')
                                </a>

                                <a
                                    class="px-5 py-2 text-base hover:bg-gray-100 cursor-pointer"
                                    href="{{ route('shop.customers.account.orders.index') }}"
                                >
                                    @lang('shop::app.components.layouts.header.orders')
                                </a>

                                @if ($showWishlist)
                                    <a
                                        class="px-5 py-2 text-base hover:bg-gray-100 cursor-pointer"
                                        href="{{ route('shop.customers.account.wishlist.index') }}"
                                    >
                                        @lang('shop::app.components.layouts.header.wishlist')
                                    </a>
                                @endif

                                <!--Customers logout-->
                                @auth('customer')
                                    <x-shop::form
                                        method="DELETE"
                                        action="{{ route('shop.customer.session.destroy') }}"
                                        id="customerLogout"
                                    />

                                    <a
                                        class="px-5 py-2 text-base hover:bg-gray-100 cursor-pointer"
                                        href="{{ route('shop.customer.session.destroy') }}"
                                        onclick="event.preventDefault(); document.getElementById('customerLogout').submit();"
                                    >
                                        @lang('shop::app.components.layouts.header.logout')
                                    </a>
                                @endauth

                                {!! view_render_event('bagisto.shop.components.layouts.header.mobile.index.profile_dropdown.links.after') !!}
                            </div>
                        </x-slot>
                    @endauth
                </x-shop::dropdown>
            </div>
        </div>
    </div>

    {!! view_render_event('bagisto.shop.components.layouts.header.mobile.search.before') !!}

    <!-- Serach Catalog Form -->
    <form action="{{ route('shop.search.index') }}" class="flex items-center w-full">
        <label 
            for="organic-search" 
            class="sr-only"
        >
            @lang('shop::app.components.layouts.header.search')
        </label>

        <div class="relative w-full">
            <div
                class="icon-search flex items-center absolute ltr:left-3 rtl:right-3 top-3 text-2xl pointer-events-none">
            </div>

            <input
                type="text"
                class="block w-full px-11 py-3.5 border border-['#E3E3E3'] rounded-xl text-gray-900 text-xs font-medium"
                name="query"
                value="{{ request('query') }}"
                placeholder="@lang('shop::app.components.layouts.header.search-text')"
                required
            >

            @if (core()->getConfigData('general.content.shop.image_search'))
                @include('shop::search.images.index')
            @endif
        </div>
    </form>

    {!! view_render_event('bagisto.shop.components.layouts.header.mobile.search.after') !!}
</div>

@pushOnce('scripts')
    <script type="text/x-template" id="v-mobile-category-template">
        <div>
            <template v-for="(category) in categories">
                {!! view_render_event('bagisto.shop.components.layouts.header.mobile.category.before') !!}

                <div class="flex justify-between items-center border border-b border-l-0 border-r-0 border-t-0 border-[#f3f3f5]">
                    <a
                        :href="category.url"
                        class="flex items-center justify-between pb-5 mt-5"
                        v-text="category.name"
                    >
                    </a>

                    <span
                        class="text-2xl cursor-pointer"
                        :class="{'icon-arrow-down': category.isOpen, 'icon-arrow-right': ! category.isOpen}"
                        @click="toggle(category)"
                    >
                    </span>
                </div>

                <div
                    class="grid gap-2"
                    v-if="category.isOpen"
                >
                    <ul v-if="category.children.length">
                        <li v-for="secondLevelCategory in category.children">
                            <div class="flex justify-between items-center ltr:ml-3 rtl:mr-3 border border-b border-l-0 border-r-0 border-t-0 border-[#f3f3f5]">
                                <a
                                    :href="secondLevelCategory.url"
                                    class="flex items-center justify-between pb-5 mt-5"
                                    v-text="secondLevelCategory.name"
                                >
                                </a>

                                <span
                                    class="text-2xl cursor-pointer"
                                    :class="{
                                        'icon-arrow-down': secondLevelCategory.category_show,
                                        'icon-arrow-right': ! secondLevelCategory.category_show
                                    }"
                                    @click="secondLevelCategory.category_show = ! secondLevelCategory.category_show"
                                >
                                </span>
                            </div>

                            <div v-if="secondLevelCategory.category_show">
                                <ul v-if="secondLevelCategory.children.length">
                                    <li v-for="thirdLevelCategory in secondLevelCategory.children">
                                        <div class="flex justify-between items-center ltr:ml-3 rtl:mr-3 border border-b border-l-0 border-r-0 border-t-0 border-[#f3f3f5]">
                                            <a
                                                :href="thirdLevelCategory.url"
                                                class="flex items-center justify-between mt-5 ltr:ml-3 rtl:mr-3 pb-5"
                                                v-text="thirdLevelCategory.name"
                                            >
                                            </a>
                                        </div>
                                    </li>
                                </ul>

                                <span
                                    class="ltr:ml-2 rtl:mr-2"
                                    v-else
                                >
                                    @lang('shop::app.components.layouts.header.no-category-found')
                                </span>
                            </div>
                        </li>
                    </ul>

                    <span
                        class="ltr:ml-2 rtl:mr-2 mt-2"
                        v-else
                    >
                        @lang('shop::app.components.layouts.header.no-category-found')
                    </span>
                </div>

                {!! view_render_event('bagisto.shop.components.layouts.header.mobile.category.after') !!}
            </template>
        </div>
    </script>

    <script type="module">
        app.component('v-mobile-category', {
            template: '#v-mobile-category-template',

            data() {
                return  {
                    categories: [],
                }
            },

            mounted() {
                this.get();
            },

            methods: {
                get() {
                    this.$axios.get("{{ route('shop.api.categories.tree') }}")
                        .then(response => {
                            this.categories = response.data.data;
                        }).catch(error => {
                            console.log(error);
                        });
                },

                toggle(selectedCategory) {
                    this.categories = this.categories.map((category) => ({
                        ...category,
                        isOpen: category.id === selectedCategory.id ? ! category.isOpen : false,
                    }));
                },
            },
        });
    </script>
@endPushOnce
