<x-admin::layouts>
    <x-slot:title>
        @lang('wp::app.admin.title')
    </x-slot>
    <x-admin::datagrid :src="route('admin.writeprogram.index')">
    </x-admin::datagrid>
</x-admin::layouts>