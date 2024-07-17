{!! view_render_event('bagisto.shop.components.layouts.header.desktop.top.before') !!}

<div class="flex justify-between items-center w-full py-3 px-16 border border-t-0 border-b border-l-0 border-r-0">
    {!! view_render_event('bagisto.shop.components.layouts.header.desktop.top.currency_switcher.before') !!}

    <!-- Currency Switcher -->
    <x-shop::dropdown>
        <!-- Dropdown Toggler -->
        <x-slot:toggle>
            <div
                class="flex gap-2.5 cursor-pointer"
                role="button"
                tabindex="0"
            >
                <span>
                    {{ core()->getCurrentCurrency()->symbol . ' ' . core()->getCurrentCurrencyCode() }}
                </span>

                <span
                    class="text-2xl icon-arrow-down"
                    role="presentation"
                ></span>
            </div>
        </x-slot>

        <!-- Dropdown Content -->
        <x-slot:content class="!p-0">
            <v-currency-switcher></v-currency-switcher>
        </x-slot>
    </x-shop::dropdown>

    {!! view_render_event('bagisto.shop.components.layouts.header.desktop.top.currency_switcher.after') !!}
    

    <p class="text-xs font-medium">
        <!--Get UPTO 40% OFF on your 1st order -->
    </p>
    
<div style="  display: grid;
  grid-template-columns: auto auto auto;gap: 20px;">   
        
<a  href="https://carsoft.tech/public/storage/theme/5/Mv0Jild8LzIobtxqyf8prY9v7JBpJkHIcBixTAUc.webp" class="underline" target="_blank" title="Whatapp">

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



<a  href="https://t.me/carsofttech" class="underline" target="_blank" title="Telegram">

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

    {!! view_render_event('bagisto.shop.components.layouts.header.desktop.top.locale_switcher.before') !!}

    <!-- Locales Switcher -->
    <x-shop::dropdown position="bottom-{{ core()->getCurrentLocale()->direction === 'ltr' ? 'right' : 'left' }}">
        <x-slot:toggle>
            <!-- Dropdown Toggler -->
            <div
                class="flex items-center gap-2.5 cursor-pointer"
                role="button"
                tabindex="0"
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

    {!! view_render_event('bagisto.shop.components.layouts.header.desktop.top.locale_switcher.after') !!}
</div>

@pushOnce('scripts')
    <script type="text/x-template" id="v-currency-switcher-template">
        <div class="grid gap-1 mt-2.5 pb-2.5">
            <span
                class="px-5 py-2 text-base cursor-pointer hover:bg-gray-100"
                v-for="currency in currencies"
                :class="{'bg-gray-100': currency.code == '{{ core()->getCurrentCurrencyCode() }}'}"
                @click="change(currency)"
            >
                @{{ currency.symbol + ' ' + currency.code }}
            </span>
        </div>
    </script>

    <script type="text/x-template" id="v-locale-switcher-template">
        <div class="grid gap-1 mt-2.5 pb-2.5">
            <span
                class="flex items-center gap-2.5 px-5 py-2 text-base cursor-pointer hover:bg-gray-100"
                v-for="locale in locales"
                :class="{'bg-gray-100': locale.code == '{{ app()->getLocale() }}'}"
                @click="change(locale)"                  
            >
                <img
                    :src="locale.logo_url || '{{ bagisto_asset('images/default-language.svg') }}'"
                    width="24"
                    height="16"
                />

                @{{ locale.name }}
            </span>
        </div>
    </script>

    <script type="module">
        app.component('v-currency-switcher', {
            template: '#v-currency-switcher-template',

            data() {
                return {
                    currencies: @json(core()->getCurrentChannel()->currencies),
                };
            },

            methods: {
                change(currency) {
                    let url = new URL(window.location.href);

                    url.searchParams.set('currency', currency.code);

                    window.location.href = url.href;
                }
            }
        });

        app.component('v-locale-switcher', {
            template: '#v-locale-switcher-template',

            data() {
                return {
                    locales: @json(core()->getCurrentChannel()->locales()->orderBy('name')->get()),
                };
            },

            methods: {
                change(locale) {
                    let url = new URL(window.location.href);

                    url.searchParams.set('locale', locale.code);

                    window.location.href = url.href;
                }
            }
        });
    </script>
@endPushOnce

{!! view_render_event('bagisto.shop.components.layouts.header.desktop.top.after') !!}