<!-- Notification Component -->
 <v-notifications {{ $attributes }}>
    <span class="relative flex">
        <span 
            class="icon-notification cursor-pointer rounded-md p-1.5 text-2xl transition-all hover:bg-gray-100 dark:hover:bg-gray-950" 
            title="@lang('shop::app.components.layouts.header.notifications.title')"
        >
        </span>
    </span>
</v-notifications>

@pushOnce('scripts')
    <script
type="text/x-template"
id="v-notifications-template"
>
<x-shop::dropdown position="bottom-{{ core()->getCurrentLocale()->direction === 'ltr' ? 'right' : 'left' }}">
    <!-- Notification Toggle -->
    <x-slot:toggle>
        <span class="relative flex">
            <svg class="h-6 w-6 cursor-pointer text-2xl" width="23" height="23" viewBox="0 0 24 24"
            stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" />
            <path d="M10 5a2 2 0 0 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" />
            <path d="M9 17v1a3 3 0 0 0 6 0v-1" />
        </svg>
        
            <span style="background-color: blue;"
                class="absolute -top-4 rounded-[44px]  px-2 py-1.5 text-xs font-semibold leading-[9px] text-white ltr:left-5 rtl:right-5"
                v-if="totalUnRead"
            >
                @{{ totalUnRead }}
            </span >
        </span>
    </x-slot>

    <!-- Notification Content -->
    <x-slot:content class="min-w-[250px] max-w-[250px] !p-0">
        <!-- Header -->
        <div class="border-b p-3 text-base font-semibold text-gray-600 dark:border-gray-800 dark:text-gray-300">
            @lang('shop::app.components.layouts.header.notifications.title', ['read' => 0])
        </div>

        <!-- Content -->
        <div class="grid">
            <a
                class="flex items-start gap-1.5 border-b p-3 last:border-b-0 hover:bg-gray-50 dark:border-gray-800 dark:hover:bg-gray-950"
                v-for="notification in notifications"
                :href="'{{ route('shop.customers.account.notification.viewed_notification', ':notifiableId') }}'.replace(':notifiableId', notification.notifiable_id)"
            >
                <!-- Notification Icon -->
                <span
                    v-if="notification.notify.status in notificationStatusIcon"
                    class="h-fit"
                    :class="notificationStatusIcon[notification.notify.status]"
                >
                </span>

                <div class="grid">
                    <!-- Order Id & Status -->
                    <p class="text-gray-800 dark:text-white">
                        #@{{ notification.notify.id }}
                        @{{ orderTypeMessages[notification.notify.status] }}
                    </p>

                    <!-- Created Date In humand Readable Format -->
                    <p class="text-xs text-gray-600 dark:text-gray-300">
                        @{{ notification.notify.datetime }}
                    </p>
                </div>
            </a>
        </div>

        <!-- Footer -->
        <div class="flex h-[47px] justify-between gap-1.5 border-t px-6 py-4 dark:border-gray-800">
            <a
                href="{{ route('shop.customers.account.notifications.index') }}"
                class="cursor-pointer text-xs font-semibold text-blue-600 transition-all hover:underline"
            >
                @lang('shop::app.components.layouts.header.notifications.view-all')
            </a>
    
            <a
                class="cursor-pointer text-xs hidden font-semibold text-blue-600 transition-all hover:underline"
                v-if="notifications?.length"
                @click="readAll()"
            >
                @lang('shop::app.components.layouts.header.notifications.read-all')
            </a>
        </div>
    </x-slot>
</x-shop::dropdown>
</script>

    <script type="module">
        app.component('v-notifications', {
            template: '#v-notifications-template',

            props: [
                'getReadAllUrl',
                'readAllTitle',
            ],

            data() {
                return {
                    notifications: [],

                    ordertype: {
                        pending: {
                            icon: 'icon-information',
                            message: "@lang('shop::app.customers.account.notifications.order-status-messages.pending-payment')"
                        },

                        processing: {
                            icon: 'icon-processing',
                            message: "@lang('shop::app.customers.account.notifications.order-status-messages.processing')",
                        },

                        canceled: {
                            icon: 'icon-cancel-1',
                            message: "@lang('shop::app.customers.account.notifications.order-status-messages.canceled')"
                        },

                        completed: {
                            icon: 'icon-done',
                            message: "@lang('shop::app.customers.account.notifications.order-status-messages.completed')"
                        },
                        file_created: {
                            icon: 'icon-processing',
                            message: "@lang('shop::app.customers.account.notifications.order-status-messages.processing')",
                        },
                        file_completed: {
                            icon: 'icon-done',
                            message: "@lang('shop::app.customers.account.notifications.order-status-messages.completed')"
                        },


                        closed: {
                            icon: 'icon-cancel-1',
                            message: "@lang('shop::app.customers.account.notifications.order-status-messages.closed')"
                        },

                        pending_payment: {
                            icon: "icon-information",
                            message: "@lang('shop::app.customers.account.notifications.order-status-messages.pending-payment')"
                        },
                    },

                    totalUnRead: 0,

                    orderTypeMessages: {
                        {{ \Webkul\Sales\Models\Order::STATUS_PENDING }}: "@lang('shop::app.customers.account.notifications.order-status-messages.pending')",
                        {{ \Webkul\Sales\Models\Order::STATUS_CANCELED }}: "@lang('shop::app.customers.account.notifications.order-status-messages.canceled')",
                        {{ \Webkul\Sales\Models\Order::STATUS_CLOSED }}: "@lang('shop::app.customers.account.notifications.order-status-messages.closed')",
                        {{ \Webkul\Sales\Models\Order::STATUS_COMPLETED }}: "@lang('shop::app.customers.account.notifications.order-status-messages.completed')",
                        {{ \Webkul\Sales\Models\Order::STATUS_PROCESSING }}: "@lang('shop::app.customers.account.notifications.order-status-messages.processing')",
                        {{ \Webkul\Sales\Models\Order::STATUS_PENDING_PAYMENT }}: "@lang('shop::app.customers.account.notifications.order-status-messages.pending-payment')",
                        {{ \Webkul\WriteProgram\Models\WriteProgram::STATUS_FILE_CREATED }}: "@lang('wp::app.admin.notifications.status-messages.file-created')",
                        {{ \Webkul\WriteProgram\Models\WriteProgram::STATUS_FILE_COMPLETED }}: "@lang('wp::app.admin.notifications.status-messages.file-completed')",
                    }
                }
            },

            computed: {
                notificationStatusIcon() {
                    return {
                        pending: 'icon-information text-2xl text-amber-600 bg-amber-100 rounded-full',
                        closed: 'icon-repeat text-2xl text-red-600 bg-red-100 rounded-full',
                        completed: 'icon-done text-2xl text-blue-600 bg-blue-100 rounded-full',
                        canceled: 'icon-cancel-1 text-2xl text-red-600 bg-red-100 rounded-full',
                        processing: 'icon-sort-right text-2xl text-green-600 bg-green-100 rounded-full',
                        file_created: 'icon-sort-right text-2xl text-green-600 bg-green-100 rounded-full',
                        file_completed: 'icon-done text-2xl text-blue-600 bg-blue-100 rounded-full',
                    };
                },
            },

            mounted() {

                 window.setInterval(() => {
                        this.getNotification();
                     }, 3000)
            },

            methods: {
                getNotification() {
                    this.$axios.get('{{ route('shop.customers.account.notification.get_notification') }}', {
                            params: {
                                limit: 5,
                                read: 0
                            }
                        })
                        .then((response) => {
                            this.notifications = response.data.search_results.data;

                            this.totalUnRead = response.data.total_unread;
                        })
                        .catch(error => console.log(error))
                },

                readAll() {
                    this.$axios.post('{{ route('shop.customers.account.notification.read_all') }}')
                        .then((response) => {
                            this.notifications = response.data.search_results.data;

                            this.totalUnRead = response.data.total_unread;

                            this.$emitter.emit('add-flash', {
                                type: 'success',
                                message: response.data.success_message
                            });
                        })
                        .catch((error) => {});
                },
            },
        });
    </script>
@endpushOnce
