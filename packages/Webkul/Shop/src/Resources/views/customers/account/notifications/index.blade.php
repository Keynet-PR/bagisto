<x-shop::layouts.account>
    <!-- Page Title -->
    <x-slot:title>
        @lang('shop::app.customers.account.notifications.title')
    </x-slot>

    <!-- Breadcrumbs -->
    @section('breadcrumbs')
        <x-shop::breadcrumbs name="profile" />
    @endSection

    <div class="max-md:hidden">
        <x-shop::layouts.account.navigation />
    </div>

    <div class="mx-4 flex-auto">
        <v-notification-list>
            <!-- Shimmer Effect -->
            <x-shop::shimmer.notifications />
        </v-notification-list>
    </div>
    @pushOnce('scripts')
        <script
        type="text/x-template"
        id="v-notification-list-template"
    >
        <template v-if="isLoading">
            <!-- Shimmer Effect -->
            <x-shop::shimmer.notifications />
        </template>

        <template v-else>
            <div class="mb-5 flex items-center justify-between gap-4 max-sm:flex-wrap">
                <div class="grid gap-1.5">
                    <p class="pt-1.5 text-xl font-bold leading-6 text-gray-800">
                        @lang('shop::app.customers.account.notifications.title')
                    </p>

                    <p class="text-gray-600 dark:text-gray-300">
                        @lang('shop::app.customers.account.notifications.description-text')
                    </p>
                </div>
            </div>

            <div class="box-shadow border flex h-[calc(100vh-179px)] max-w-max flex-col justify-between rounded-md bg-white">
                <div>
                    <div class="journal-scroll flex overflow-auto border-b">
                        <div
                            class="flex cursor-pointer items-center gap-1 border-b-2 px-4 py-4 hover:bg-gray-100"
                            :class="{'bg-gray-100': status == data.status}"
                            v-for="data in notifyType"
                            v-show="data.hidden"
                            @click="status=data.status; getNotification()"
                        >
                            <p class="text-gray-600 dark:text-gray-300">
                                @{{ data.message }}
                            </p>

                            <span class="rounded-full bg-gray-600 px-1.5 py-px text-xs font-semibold text-white">
                                @{{ data.status_count ?? '0' }}
                            </span>
                        </div>
                    </div>

                    <div
                        class="journal-scroll grid max-h-[calc(100vh-330px)] overflow-auto"
                        v-if="notifications.length"
                    >
                        <a
                            :href="'{{ route('shop.customers.account.notification.viewed_notification', ':notifiableId') }}'.replace(':notifiableId', notification.notifiable_id)"
                            class="flex h-14 items-start gap-1.5 p-4 hover:bg-gray-50 dark:hover:bg-gray-950"
                            v-for="notification in notifications"
                        >
                            <span
                                v-if="notification.notify.status in notifyType"
                                class="h-fit rounded-full text-2xl"
                                :class="notifyType[notification.notify.status].icon"
                            >
                            </span>
                           
                            <div class="grid">
                                <p  
                                    class="text-gray-800"
                                    :class="notification.read ? 'font-normal' : 'font-semibold'"
                                >
                                    #@{{ notification.notify.id }}
                                    @{{notification.notify.status}}
                                    @{{ notifyType[notification.notify.status].message }}
                                </p>

                                <p class="text-xs text-gray-600 dark:text-gray-300">
                                    @{{ notification.notify.datetime }}
                                </p>
                            </div>
                        </a>
                    </div>

                    <!-- For Empty Data -->
                    <div
                        class="max-h-[calc(100vh-330px)] px-6 py-3 text-gray-600"
                        v-else
                    >
                        @lang('shop::app.customers.account.notifications.no-record')
                    </div>
                </div>

                <!-- Pagination -->
                <div class="flex items-center gap-x-2 border-t p-4">
                    <div class="inline-flex  w-full max-w-max appearance-none items-center justify-between gap-x-1 rounded-md border bg-white px-2 py-1.5 text-center leading-6 text-gray-600 marker:shadow focus:outline-none focus:ring-2 focus:ring-black max-sm:hidden ltr:ml-2 rtl:mr-2">
                        @{{ pagination.per_page }}
                    </div>

                    <span class="whitespace-nowrap text-gray-600">
                        @lang('shop::app.customers.account.notifications.per-page')
                    </span>

                    <p class="whitespace-nowrap text-gray-600">
                        @{{ pagination.current_page }}
                    </p>

                    <span class="whitespace-nowrap text-gray-600">
                        @lang('shop::app.customers.account.notifications.of')
                    </span>

                    <p class="whitespace-nowrap text-gray-600">
                        @{{ pagination.last_page }}
                    </p>

                    <!-- Prev & Next Page Button -->
                    <div class="flex items-center gap-1">
                        <a @click="getResults(pagination.prev_page_url)">
                            <div class="inline-flex w-full max-w-max cursor-pointer appearance-none items-center justify-between gap-x-1 rounded-md border bg-white p-1.5 text-center text-gray-600 transition-all marker:shadow hover:border hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-black ltr:ml-2 rtl:mr-2">
                                <span class="icon-arrow-left rtl:icon-arrow-left text-2xl"></span>
                            </div>
                        </a>

                        <a @click="getResults(pagination.next_page_url)">
                            <div
                                class="inline-flex w-full max-w-max cursor-pointer appearance-none items-center justify-between gap-x-1 rounded-md border bg-white p-1.5 text-center text-gray-600 transition-all marker:shadow hover:border hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-black ltr:ml-2 rtl:mr-2">
                                <span class="icon-arrow-right rtl:icon-arrow-left text-2xl"></span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </template>
    </script>

        <script type="module">
            app.component('v-notification-list', {
                template: '#v-notification-list-template',

                data() {
                    return {
                        notifications: [],

                        pagination: {},

                        status: 'all',

                        notifyType: {
                            all: {
                                icon: 'icon',
                                message: 'All',
                                status: 'all',
                                hidden: true
                            },
                            file_created: {
                                icon: 'icon-sort-right text-green-600 bg-green-100',
                                message: "@lang('wp::app.admin.notifications.status-messages.file-created')",
                                status: 'file_created',
                                hidden: false
                            },
                            file_completed: {
                                icon: 'icon-done text-blue-600 bg-blue-100',
                                message: "@lang('wp::app.admin.notifications.status-messages.file-completed')",
                                status: 'file_completed',
                                hidden: true
                            },
                            pending: {
                                icon: 'icon-information text-amber-600 bg-amber-100',
                                message: "@lang('shop::app.customers.account.notifications.order-status-messages.pending')",
                                status: 'pending',
                                hidden: true
                            },

                            processing: {
                                icon: 'icon-sort-right text-green-600 bg-green-100',
                                message: "@lang('shop::app.customers.account.notifications.order-status-messages.processing')",
                                status: 'processing',
                                hidden: false
                            },

                            canceled: {
                                icon: 'icon-cancel-1 text-red-600 bg-red-100',
                                message: "@lang('shop::app.customers.account.notifications.order-status-messages.canceled')",
                                status: 'canceled',
                                hidden: true
                            },

                            completed: {
                                icon: 'icon-done text-blue-600 bg-blue-100',
                                message: "@lang('shop::app.customers.account.notifications.order-status-messages.completed')",
                                status: 'completed',
                                hidden: true
                            },

                            closed: {
                                icon: 'icon-repeat text-red-600 bg-red-100',
                                message: "@lang('shop::app.customers.account.notifications.order-status-messages.closed')",
                                status: 'closed',
                                hidden: false
                            },
                        },

                        isLoading: true,
                    }
                },

                mounted() {
                    this.getNotification();
                },

                methods: {
                    getNotification() {
                        const params = {};

                        if (this.status != 'all') {
                            params.status = this.status;
                        }

                        this.$axios.get("{{ route('shop.customers.account.notification.get_notification') }}", {
                                params: params
                            })
                            .then((response) => {
                                this.notifications = response.data.search_results.data;

                                let total = 0;

                                response.data.status_count.forEach((item) => {
                                    this.notifyType[item.status].status_count = item.status_count;
                                    total += item.status_count;
                                });

                                this.notifyType['all'].status_count = total;

                                this.pagination = response.data.search_results;

                                this.isLoading = false;
                            })
                            .catch(error => console.log(error));
                    },

                    getResults(url) {
                        if (url) {
                            this.$axios.get(url)
                                .then(response => {
                                    this.notifications = response.data.search_results.data;

                                    this.pagination = response.data.search_results;
                                })
                                .catch(error => console.log(error));
                        }
                    }
                }
            })
        </script>
    @endPushOnce

</x-shop::layouts.account>
