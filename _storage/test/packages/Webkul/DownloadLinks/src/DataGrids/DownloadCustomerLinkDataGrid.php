<?php

namespace Webkul\DownloadLinks\DataGrids;

use Illuminate\Support\Facades\DB;
use Webkul\DataGrid\DataGrid;

class DownloadCustomerLinkDataGrid extends DataGrid
{
    /**
     * Primary column.
     *
     * @var string
     */
    protected $primaryColumn = 'id';

    /**
     * Prepare query builder.
     *
     * @return \Illuminate\Database\Query\Builder
     */
    public function prepareQueryBuilder()
    {
        $tablePrefix = DB::getTablePrefix();

        $queryBuilder = DB::table('download_customer_links')
           // ->join('orders', 'orders.id', 'downloadable_analyzes.order_id')
            ->join('customers', 'customers.id', 'download_customer_links.customer_id')
            ->select(
                'download_customer_links.id',
                'download_customer_links.service_request',
                'download_customer_links.created_at',
                DB::raw('CONCAT(' . $tablePrefix . 'customers.first_name, " ", ' . $tablePrefix . 'customers.last_name) as customer_name')
            );

        return $queryBuilder;
    }

    /**
     * Prepare columns.
     *
     * @return void
     */
    public function prepareColumns()
    {
        $this->addColumn([
            'index'      => 'id',
            'label'      => trans('download-link::app.admin.id'),
            'type'       => 'number',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'service_request',
            'label'      => trans('download-link::app.admin.service_request'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => false,
        ]);



        $this->addColumn([
            'index'      => 'customer_name',
            'label'      => trans('download-link::app.admin.customer_name'),
            'type'       => 'string',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => false,
        ]);

    
        $this->addColumn([
            'index'      => 'created_at',
            'label'      => trans('download-link::app.admin.created_at'),
            'type'       => 'date',
            'searchable' => true,
            'sortable'   => true,
            'filterable' => false,
        ]);

        // $this->addColumn([
        //     'index'      => 'send_notification',
        //     'label'      => trans('DownloadLinks::app.admin.send_notification'),
        //     'type'       => 'string',
        //     'searchable' => true,
        //     'sortable'   => true,
        //     'filterable' => false,
        //     'closure'    => function ($value) {
        //         return '<a href="" class="secondary-button" data-product-id="' . $value->id . '" onclick="sendQuickMail(' . $value->id . ')">' . trans('DownloadLinks::app.admin.send_notification') . '</a>';
        //     },
        // ]);
    }

     /**
     * Prepare actions.
     *
     * @return void
     */
    public function prepareActions()
    {
        $this->addAction([
            'icon'   => 'icon-sort-right',
            'title'  => trans('admin::app.customers.customers.index.datagrid.view'),
            'method' => 'GET',
            'url'    => function ($row) {
                return route('download-customer-links.admin.view', $row->id);
            },
        ]);

        // $this->addAction([
        //     'icon'   => 'icon-exit',
        //     'title'  => trans('admin::app.customers.customers.index.datagrid.login-as-customer'),
        //     'method' => 'GET',
        //     'target' => 'blank',
        //     'url'    => function ($row) {
        //         return route('admin.customers.customers.login_as_customer', $row->customer_id);
        //     },
        // ]);
    }
}