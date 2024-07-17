<x-admin::layouts>
    <x-slot:title>
        @lang('download-link::app.admin.title')
    </x-slot>
    <x-admin::datagrid :src="route('download-customer-links.admin.index')">
    </x-admin::datagrid>
</x-admin::layouts>