{!! view_render_event('bagisto.shop.layout.footer.before') !!}

<!--
    The category repository is injected directly here because there is no way
    to retrieve it from the view composer, as this is an anonymous component.
-->
@inject('themeCustomizationRepository', 'Webkul\Theme\Repositories\ThemeCustomizationRepository')

<!--
    This code needs to be refactored to reduce the amount of PHP in the Blade
    template as much as possible.
-->
@php
    $customization = $themeCustomizationRepository->findOneWhere([
        'type'       => 'footer_links',
        'status'     => 1,
        'channel_id' => core()->getCurrentChannel()->id,
    ]);
@endphp

<footer class="mt-9 bg-lightOrange max-sm:mt-8">
    <div class="flex gap-x-6 gap-y-8 justify-between p-[60px] max-1060:flex-wrap max-1060:flex-col-reverse max-sm:px-4">
        <div class="flex gap-24 items-start flex-wrap max-1180:gap-6 max-1060:justify-between">
            @if ($customization?->options)
                @foreach ($customization->options as $footerLinkSection)
                    <ul class="grid gap-5 text-sm">
                        @php
                            usort($footerLinkSection, function ($a, $b) {
                                return $a['sort_order'] - $b['sort_order'];
                            });
                        @endphp

                        @foreach ($footerLinkSection as $link)
                            <li>
                                <a href="{{ $link['url'] }}">
                                    {{ $link['title'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                @endforeach
            @endif
        </div>
        
        <ul>
        <h1 style="margin-bottom:20px;font-size:20px">Contact Info</h1>
            <li style="margin-bottom:20px">
                    
                <a  href="https://www.facebook.com/profile.php?id=61559843376662&mibextid=LQQJ4d"  target="_blank" title="Facebook">

                    <svg height="20px" width="20px" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" id="facebook"><path fill="#1976D2" d="M14 0H2C.897 0 0 .897 0 2v12c0 1.103.897 2 2 2h12c1.103 0 2-.897 2-2V2c0-1.103-.897-2-2-2z"></path><path fill="#FAFAFA" fill-rule="evenodd" d="M13.5 8H11V6c0-.552.448-.5 1-.5h1V3h-2a3 3 0 0 0-3 3v2H6v2.5h2V16h3v-5.5h1.5l1-2.5z" clip-rule="evenodd"></path></svg>  <p style="margin-left:30px;margin-top:-20px">Facebook</p>
                </a>
            </li>
            
            <li style="margin-bottom:20px">
                <a  href="https://www.instagram.com/carsoft.tech"  target="_blank" title="Instagram">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 102 102" id="instagram"><defs><radialGradient id="a" cx="6.601" cy="99.766" r="129.502" gradientUnits="userSpaceOnUse"><stop offset=".09" stop-color="#fa8f21"></stop><stop offset=".78" stop-color="#d82d7e"></stop></radialGradient><radialGradient id="b" cx="70.652" cy="96.49" r="113.963" gradientUnits="userSpaceOnUse"><stop offset=".64" stop-color="#8c3aaa" stop-opacity="0"></stop><stop offset="1" stop-color="#8c3aaa"></stop></radialGradient></defs><path fill="url(#a)" d="M25.865,101.639A34.341,34.341,0,0,1,14.312,99.5a19.329,19.329,0,0,1-7.154-4.653A19.181,19.181,0,0,1,2.5,87.694,34.341,34.341,0,0,1,.364,76.142C.061,69.584,0,67.617,0,51s.067-18.577.361-25.14A34.534,34.534,0,0,1,2.5,14.312,19.4,19.4,0,0,1,7.154,7.154,19.206,19.206,0,0,1,14.309,2.5,34.341,34.341,0,0,1,25.862.361C32.422.061,34.392,0,51,0s18.577.067,25.14.361A34.534,34.534,0,0,1,87.691,2.5a19.254,19.254,0,0,1,7.154,4.653A19.267,19.267,0,0,1,99.5,14.309a34.341,34.341,0,0,1,2.14,11.553c.3,6.563.361,8.528.361,25.14s-.061,18.577-.361,25.14A34.5,34.5,0,0,1,99.5,87.694,20.6,20.6,0,0,1,87.691,99.5a34.342,34.342,0,0,1-11.553,2.14c-6.557.3-8.528.361-25.14.361s-18.577-.058-25.134-.361"></path><path fill="url(#b)" d="M25.865,101.639A34.341,34.341,0,0,1,14.312,99.5a19.329,19.329,0,0,1-7.154-4.653A19.181,19.181,0,0,1,2.5,87.694,34.341,34.341,0,0,1,.364,76.142C.061,69.584,0,67.617,0,51s.067-18.577.361-25.14A34.534,34.534,0,0,1,2.5,14.312,19.4,19.4,0,0,1,7.154,7.154,19.206,19.206,0,0,1,14.309,2.5,34.341,34.341,0,0,1,25.862.361C32.422.061,34.392,0,51,0s18.577.067,25.14.361A34.534,34.534,0,0,1,87.691,2.5a19.254,19.254,0,0,1,7.154,4.653A19.267,19.267,0,0,1,99.5,14.309a34.341,34.341,0,0,1,2.14,11.553c.3,6.563.361,8.528.361,25.14s-.061,18.577-.361,25.14A34.5,34.5,0,0,1,99.5,87.694,20.6,20.6,0,0,1,87.691,99.5a34.342,34.342,0,0,1-11.553,2.14c-6.557.3-8.528.361-25.14.361s-18.577-.058-25.134-.361"></path><path fill="#fff" d="M461.114,477.413a12.631,12.631,0,1,1,12.629,12.632,12.631,12.631,0,0,1-12.629-12.632m-6.829,0a19.458,19.458,0,1,0,19.458-19.458,19.457,19.457,0,0,0-19.458,19.458m35.139-20.229a4.547,4.547,0,1,0,4.549-4.545h0a4.549,4.549,0,0,0-4.547,4.545m-30.99,51.074a20.943,20.943,0,0,1-7.037-1.3,12.547,12.547,0,0,1-7.193-7.19,20.923,20.923,0,0,1-1.3-7.037c-.184-3.994-.22-5.194-.22-15.313s.04-11.316.22-15.314a21.082,21.082,0,0,1,1.3-7.037,12.54,12.54,0,0,1,7.193-7.193,20.924,20.924,0,0,1,7.037-1.3c3.994-.184,5.194-.22,15.309-.22s11.316.039,15.314.221a21.082,21.082,0,0,1,7.037,1.3,12.541,12.541,0,0,1,7.193,7.193,20.926,20.926,0,0,1,1.3,7.037c.184,4,.22,5.194.22,15.314s-.037,11.316-.22,15.314a21.023,21.023,0,0,1-1.3,7.037,12.547,12.547,0,0,1-7.193,7.19,20.925,20.925,0,0,1-7.037,1.3c-3.994.184-5.194.22-15.314.22s-11.316-.037-15.309-.22m-.314-68.509a27.786,27.786,0,0,0-9.2,1.76,19.373,19.373,0,0,0-11.083,11.083,27.794,27.794,0,0,0-1.76,9.2c-.187,4.04-.229,5.332-.229,15.623s.043,11.582.229,15.623a27.793,27.793,0,0,0,1.76,9.2,19.374,19.374,0,0,0,11.083,11.083,27.813,27.813,0,0,0,9.2,1.76c4.042.184,5.332.229,15.623.229s11.582-.043,15.623-.229a27.8,27.8,0,0,0,9.2-1.76,19.374,19.374,0,0,0,11.083-11.083,27.716,27.716,0,0,0,1.76-9.2c.184-4.043.226-5.332.226-15.623s-.043-11.582-.226-15.623a27.786,27.786,0,0,0-1.76-9.2,19.379,19.379,0,0,0-11.08-11.083,27.748,27.748,0,0,0-9.2-1.76c-4.041-.185-5.332-.229-15.621-.229s-11.583.043-15.626.229" transform="translate(-422.637 -426.196)"></path></svg>  <p style="margin-left:30px;margin-top:-20px">Instagram</p>
                </a>
            </li>
            
            <li style="margin-bottom:20px">
                <a  href="https://www.tiktok.com/@carsoft.tech?_t=8mYKL4IrEBG&_r=1"  target="_blank" title="TikTok">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" width="20" height="20" viewBox="0 0 256 256" xml:space="preserve">

        <defs>
        </defs>
        <g style="stroke: none; stroke-width: 0; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: none; fill-rule: nonzero; opacity: 1;" transform="translate(1.4065934065934016 1.4065934065934016) scale(2.81 2.81)" >
        	<path d="M 78.974 90 H 11.026 C 4.936 90 0 85.064 0 78.974 V 11.026 C 0 4.936 4.936 0 11.026 0 h 67.948 C 85.064 0 90 4.936 90 11.026 v 67.948 C 90 85.064 85.064 90 78.974 90 z" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,0,0); fill-rule: nonzero; opacity: 1;" transform=" matrix(1 0 0 1 0 0) " stroke-linecap="round" />
        	<path d="M 10.484 10.346 V 9.714 c -0.219 -0.031 -0.441 -0.047 -0.662 -0.048 c -2.709 0 -4.914 2.205 -4.914 4.914 c 0 1.662 0.831 3.133 2.098 4.023 c -0.848 -0.907 -1.32 -2.103 -1.319 -3.346 C 5.686 12.587 7.828 10.409 10.484 10.346" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,242,234); fill-rule: nonzero; opacity: 1;" transform=" matrix(3.89 0 0 3.89 -1.9444444444444287 -1.9444444444444287) " stroke-linecap="round" />
        	<path d="M 10.6 17.501 c 1.209 0 2.195 -0.962 2.24 -2.16 l 0.004 -10.699 h 1.955 c -0.042 -0.223 -0.063 -0.45 -0.063 -0.677 h -2.67 l -0.005 10.699 c -0.044 1.198 -1.031 2.159 -2.24 2.159 c -0.363 0 -0.72 -0.088 -1.041 -0.258 C 9.201 17.153 9.878 17.501 10.6 17.501 M 18.45 8.274 V 7.68 c -0.718 0.001 -1.421 -0.208 -2.022 -0.601 C 16.954 7.685 17.664 8.105 18.45 8.274" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(0,242,234); fill-rule: nonzero; opacity: 1;" transform=" matrix(3.89 0 0 3.89 -1.9444444444444287 -1.9444444444444287) " stroke-linecap="round" />
        	<path d="M 16.427 7.078 c -0.589 -0.674 -0.914 -1.539 -0.913 -2.435 h -0.715 C 14.986 5.643 15.574 6.523 16.427 7.078 M 9.822 12.336 c -1.239 0.001 -2.243 1.005 -2.244 2.244 c 0.001 0.834 0.464 1.599 1.203 1.986 c -0.276 -0.381 -0.425 -0.839 -0.425 -1.309 c 0.001 -1.239 1.005 -2.243 2.244 -2.244 c 0.231 0 0.453 0.038 0.662 0.104 v -2.725 c -0.219 -0.031 -0.441 -0.047 -0.662 -0.048 c -0.039 0 -0.077 0.002 -0.116 0.003 v 2.093 C 10.27 12.371 10.047 12.336 9.822 12.336" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(255,0,79); fill-rule: nonzero; opacity: 1;" transform=" matrix(3.89 0 0 3.89 -1.9444444444444287 -1.9444444444444287) " stroke-linecap="round" />
        	<path d="M 18.45 8.274 v 2.075 c -1.384 0 -2.667 -0.443 -3.714 -1.194 v 5.425 c 0 2.709 -2.204 4.914 -4.913 4.914 c -1.047 0 -2.018 -0.33 -2.816 -0.891 c 0.927 1 2.23 1.569 3.594 1.568 c 2.709 0 4.914 -2.204 4.914 -4.913 V 9.832 c 1.082 0.778 2.381 1.196 3.714 1.194 v -2.67 C 18.961 8.356 18.701 8.327 18.45 8.274" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(255,0,79); fill-rule: nonzero; opacity: 1;" transform=" matrix(3.89 0 0 3.89 -1.9444444444444287 -1.9444444444444287) " stroke-linecap="round" />
        	<path d="M 14.735 14.58 V 9.154 c 1.082 0.778 2.382 1.196 3.714 1.194 V 8.274 c -0.786 -0.169 -1.495 -0.589 -2.022 -1.196 c -0.853 -0.555 -1.442 -1.435 -1.629 -2.435 h -1.954 L 12.84 15.342 c -0.045 1.198 -1.031 2.16 -2.24 2.16 c -0.722 -0.001 -1.399 -0.349 -1.819 -0.935 c -0.739 -0.387 -1.202 -1.152 -1.203 -1.986 c 0.001 -1.239 1.005 -2.243 2.244 -2.244 c 0.231 0 0.452 0.038 0.662 0.104 v -2.093 c -2.656 0.062 -4.798 2.24 -4.798 4.911 c 0 1.292 0.502 2.467 1.319 3.346 c 0.824 0.58 1.808 0.891 2.816 0.89 C 12.531 19.493 14.735 17.289 14.735 14.58" style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-linejoin: miter; stroke-miterlimit: 10; fill: rgb(255,255,255); fill-rule: nonzero; opacity: 1;" transform=" matrix(3.89 0 0 3.89 -1.9444444444444287 -1.9444444444444287) " stroke-linecap="round" />
        </g>
        </svg>  <p style="margin-left:30px;margin-top:-20px">TikTok</p>
                </a>
          </li>
          <li style="margin-bottom:20px">
                <a  href="https://www.youtube.com/@carsoft-tech"  target="_blank" title="YouTube">
                    <svg width="20" height="20" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16" id="youtube"><g fill-rule="evenodd" clip-rule="evenodd"><path fill="#F44336" d="M15.32 4.06c-.434-.772-.905-.914-1.864-.968C12.498 3.027 10.089 3 8.002 3c-2.091 0-4.501.027-5.458.091-.957.055-1.429.196-1.867.969C.23 4.831 0 6.159 0 8.497v.008c0 2.328.23 3.666.677 4.429.438.772.909.912 1.866.977.958.056 3.368.089 5.459.089 2.087 0 4.496-.033 5.455-.088.959-.065 1.43-.205 1.864-.977.451-.763.679-2.101.679-4.429v-.008c0-2.339-.228-3.667-.68-4.438z"></path><path fill="#FAFAFA" d="M6 11.5v-6l5 3z"></path></g></svg>  <p style="margin-left:30px;margin-top:-20px">YouTube</p>
                </a>
          </li>
            <li style="margin-bottom:20px">
                <a  href="mailto:carsoft.tech.kh@gmail.com"  target="_blank" title="E-mail">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 120 120" id="mail"><defs><linearGradient id="a" x1="50%" x2="50%" y1="0%" y2="100%"><stop offset="0%" stop-color="#008EE7"></stop><stop offset="100%" stop-color="#00D6FA"></stop></linearGradient></defs><g fill="none" fill-rule="evenodd"><g><rect width="120" height="120" fill="url(#a)" rx="28"></rect><path fill="#FFF" d="M25.114 84.964l21.196-21.95 5.13 5.165a12.553 12.553 0 0 0 17.84 0l4.64-4.672L94.666 84.99c-.331.07-.675.106-1.027.106H26.26c-.394 0-.778-.046-1.146-.132zm73.392-46.215c.087.37.133.755.133 1.151v40.196c0 1.29-.489 2.466-1.29 3.353L76.033 61.378l22.472-22.63zM21.36 81.094V40.9c0-.868.221-1.685.61-2.397l22.226 22.382L22.482 83.37a4.983 4.983 0 0 1-1.122-2.277zm75.467-45.046L67.189 65.685c-3.905 3.906-10.237 3.906-14.142 0L23.26 35.9c.835-.627 1.874-.999 3-.999h67.378a4.98 4.98 0 0 1 3.188 1.148z"></path></g></g></svg>
                    <p style="margin-left:30px;margin-top:-20px">carsoft.tech.kh@gmail.com</p>
                </a>
          </li>
        </ul>  
        
        
        <ul>
        <h1 style="margin-bottom:20px;font-size:20px">Operation Hours</h1>
            <li style="margin-bottom:20px">
                    
                <p>Mon – Sat : 9:00 am – 10:00 pm</p>
            </li>
            
            <li style="margin-bottom:20px">
                    
                <p>Sun : Closed</p>
            </li>
            
            <li style="margin-bottom:20px">
                    
                <p>Public Holidays : Closed</p>
            </li>
            <li style="margin-bottom:20px">
                    
                <p style="margin-bottom:10px">We Accept :</p>
                <div style="display: grid; grid-template-columns: auto auto auto auto auto auto auto auto auto auto; margin-bottom: 10px">
                    <img style="width:60px" src="https://i.pinimg.com/736x/a5/53/5d/a5535ddefd7f764a991b91cb84e87758.jpg">
                    <img style="width:70px;background:white;padding:5px;border-radius: 3px;" src="https://static-00.iconduck.com/assets.00/alipay-icon-2048x590-va64vtxu.png">
                    <img style="width:70px;background:white;padding:5px;border-radius: 3px;" src="https://static-00.iconduck.com/assets.00/paypal-icon-2048x547-tu0aql1a.png">
                </div>
            </li>
        </ul>

        {!! view_render_event('bagisto.shop.layout.footer.newsletter_subscription.before') !!}

        <!-- News Letter subscription -->
        @if (core()->getConfigData('customer.settings.newsletter.subscription'))
            <div class="grid gap-2.5">
                <p
                    class="max-w-[288px] leading-[45px] text-3xl italic text-navyBlue"
                    role="heading"
                    aria-level="2"
                >
                    @lang('shop::app.components.layouts.footer.newsletter-text')
                </p>

                <p class="text-xs">
                    @lang('shop::app.components.layouts.footer.subscribe-stay-touch')
                </p>

                <x-shop::form
                    :action="route('shop.subscription.store')"
                    class="mt-2.5 rounded max-sm:mt-8"
                >
                    <div class="relative w-full">
                        <x-shop::form.control-group.control
                            type="email"
                            class="blockw-[420px] max-w-full px-5 py-5 p-28 bg-[#F1EADF] border-[2px] border-[#E9DECC] rounded-xl text-xs font-medium max-1060:w-full"
                            name="email"
                            rules="required|email"
                            label="Email"
                            :aria-label="trans('shop::app.components.layouts.footer.email')"
                            placeholder="email@example.com"
                        />

                        <x-shop::form.control-group.error control-name="email" />

                        <button
                            type="submit"
                            class=" absolute flex items-center top-2 w-max px-7 py-3.5 bg-white rounded-xl text-xs font-medium rtl:left-2 ltr:right-2"
                        >
                            @lang('shop::app.components.layouts.footer.subscribe')
                        </button>
                    </div>
                </x-shop::form>
            </div>
        @endif

        {!! view_render_event('bagisto.shop.layout.footer.newsletter_subscription.after') !!}
    </div>

    <div class="flex justify-between  px-[60px] py-3.5 bg-[#F1EADF]">
        {!! view_render_event('bagisto.shop.layout.footer.footer_text.before') !!}

        <p class="text-sm text-[#4D4D4D]">
            @lang('shop::app.components.layouts.footer.footer-text', ['current_year'=> date('Y') ])
        </p>

        {!! view_render_event('bagisto.shop.layout.footer.footer_text.after') !!}
    </div>
</footer>


<!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-ZRYVHQ4GLV"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-ZRYVHQ4GLV');
</script>


{!! view_render_event('bagisto.shop.layout.footer.after') !!}
