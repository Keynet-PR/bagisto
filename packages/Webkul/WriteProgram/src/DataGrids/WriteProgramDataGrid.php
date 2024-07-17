<?php

namespace Webkul\WriteProgram\DataGrids;

use Illuminate\Support\Facades\DB;
use Webkul\DataGrid\DataGrid;

class WriteProgramDataGrid extends DataGrid
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

        $queryBuilder = DB::table('write_programs')
            ->join('wp_subscriptions', 'wp_subscriptions.id', 'write_programs.wp_subscriptions_id')
            ->join('customers', 'customers.id', 'wp_subscriptions.customer_id')
            ->select(
                'write_programs.id',
                'write_programs.service_request',
                'write_programs.created_at',
                'write_programs.status',
                'customers.email',
                'customers.phone',
                DB::raw('CONCAT(' . $tablePrefix . 'customers.first_name, " ", ' . $tablePrefix . 'customers.last_name) as name')
            );
            
            $this->addFilter('service_request', 'write_programs.service_request');
            $this->addFilter('status', 'write_programs.status');
            $this->addFilter('email', 'customers.email');
            $this->addFilter('phone', 'customers.phone');
            $this->addFilter('name', DB::raw('CONCAT('.$tablePrefix.'customers.first_name, " ", '.$tablePrefix.'customers.last_name)'));
 
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
            'label'      => trans('wp::app.admin.index.id'),
            'type'       => 'number',
            'searchable' => false,
            'sortable'   => false,
            'filterable' => false,
        ]);

        $this->addColumn([
            'index'      => 'name',
            'label'      => trans('wp::app.admin.index.name'),
            'type'       => 'string',
            'sortable'   => true,
            'filterable' => true,
            'searchable' => true
        ]);

        $this->addColumn([
            'index'      => 'phone',
            'label'      => trans('wp::app.admin.index.phone'),
            'type'       => 'string',
            'sortable'   => true,
            'filterable' => true,
            'searchable' => true
        ]);
        
          $this->addColumn([
            'index'      => 'email',
            'label'      => trans('wp::app.admin.index.email'),
            'type'       => 'string',
            'sortable'   => true,
            'searchable' => true,
            'filterable' => true,
        ]);

        $this->addColumn([
            'index'      => 'service_request',
            'label'      => trans('wp::app.admin.index.service_request'),
            'type'       => 'string',
            'sortable'   => true,
            'searchable' => true,
            'filterable' => true,
        ]);

    
        $this->addColumn([
            'index'      => 'created_at',
            'label'      => trans('wp::app.admin.index.created_at'),
            'type'       => 'date',
            'searchable' => false,
            'sortable'   => true,
            'filterable' => false,
        ]);
        
         $this->addColumn([
            'index'      => 'status',
            'label'      => trans('wp::app.admin.index.status'),
            'type'       => 'string',
            'sortable'   => true,
            'searchable' => true,
            'filterable' => true,
           
        ]);

        // $this->addColumn([
        //     'index'      => 'send_notification',
        //     'label'      => trans('DownloadLinks::app.admin.index.send_notification'),
        //     'type'       => 'string',
        //     'searchable' => true,
        //     'sortable'   => true,
        //     'filterable' => false,
        //     'closure'    => function ($value) {
        //         return '<a href="" class="secondary-button" data-product-id="' . $value->id . '" onclick="sendQuickMail(' . $value->id . ')">' . trans('DownloadLinks::app.admin.index.send_notification') . '</a>';
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
                return route('admin.writeprogram.view', $row->id);
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