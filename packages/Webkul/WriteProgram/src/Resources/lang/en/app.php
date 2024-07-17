<?php

return [
    'admin' => [
        'title' => 'AdBlue/DTC/DPF/EGR',
        'writables' => 'Writables',
        'index' => [
            'id'            => 'ID',
            'plan_name'      => 'Plan Name',
            'service_request'      => 'Service Request',
            'name'     => 'Name',
            'email'     => 'Email',
            'phone'     => 'Phone',
            'created_at' => 'Created At',
            'status'     => 'Status',
        ],
        'view' => [
            'title'                       => 'AdBlue/DTC/DPF/EGR #:id',
            'writables'                   => 'Writables',
            'description'                   => 'Description',
            'billing'                   => 'Billing',
            'send-file'                   => 'Send File',
            'back-btn' => 'Back',
            'file' => 'File',
            'send'                   => 'Send',
            'file-send'                   => 'File Send success!.',
            'file-deleted'                   => 'File Deleted',
        ],
        'notifications' => [
            'description-text'      => 'List all the Notifications',
            'marked-success'        => 'Notification Marked Successfully',
            'no-record'             => 'No Record Found',
            'of'                    => 'of',
            'per-page'              => 'Per Page',
            'title'                 => 'Notifications',
            'view-all'              => 'View All',
            'order-status-messages' => [
                'canceled'        => 'Order Canceled',
                'closed'          => 'Order Closed',
                'completed'       => 'Order Completed',
                'pending'         => 'Order Pending',
                'pending-payment' => 'Pending Payment',
                'processing'      => 'Order Processing',
            ],
            'status-messages'  =>  [
                'file-created' => 'File Created',
                'file-completed' => 'File Completed'
            ],

        ]
    ]
];
