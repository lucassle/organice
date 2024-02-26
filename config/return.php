<?php

use Illuminate\Support\Facades\Facade;
use Illuminate\Support\ServiceProvider;

return [
    'prefix'   => [
        'backend'       => 'admin',
        'frontend'      => ''
    ],

    'format'    => [
        'long_time'     =>  'H:i:s d/m/y',
        'short_day'     =>  'd/m/y',
        'short_time'    =>  'H:i:s'
    ],

    'template'  => [
        'form_input'    => [
            'class'     => 'form-control col-md-6 col-xs-12'
        ],

        'form_ckeditor' => [
            'class'     => 'form-control col-md-6 col-xs-12 ckeditor'
        ],

        'form_lable'    => [
            'class'     => 'control-label col-md-3 col-sm-3 col-xs-12'
        ],

        'form_edit'    => [
            'class'     => 'control-label col-md-4 col-sm-3 col-xs-12'
        ],

        'type_menu'    => [
            'link'             => ['name'  => 'link'],
            'category_article' => ['name'  => 'category_article'],
        ],

        'type_open'    => [
            'new_window'   => ['name'  => 'new_window'],
            'current'      => ['name'  => 'current'],
        ],

        'type_coupon_discount'    => [
            'percent'   => ['name'  => 'Discount by percentage'],
            'price'     => ['name'  => 'Discount by price'],
        ],

        'status'    => [
            'all'           => ['name'  => 'All',       'class' => 'btn-primary'],
            'active'        => ['name'  => 'Active',    'class' => 'btn-success'],
            'inactive'      => ['name'  => 'Inactive',  'class' => 'btn-info'],
            'block'         => ['name'  => 'Block',     'class' => 'btn-danger'],
            'default'       => ['name'  => 'Default',   'class' => 'btn-danger'],
            'waiting'       => ['name'  => 'Waiting',   'class' => 'btn-danger'],
            'contacted'     => ['name'  => 'Contacted', 'class' => 'btn-success'],
        ],

        'shipmentStatus' => [
            'confirming'    => ['name'  => 'Confirming'],
            'confirmed'     => ['name'  => 'Confirmed'],
            'delivering'    => ['name'  => 'Delivering'],
            'delivered'     => ['name'  => 'Delivered'],
        ],

        'is_home'   => [
            'yes'       => ['name'  => 'Enable',    'class' => 'btn-primary'],
            'no'        => ['name'  => 'Disable',   'class' => 'btn-warning'] 
        ],

        'display'   => [
            'list'      => ['name'  => 'List'],
            'grid'      => ['name'  => 'Grid'] 
        ],
        
        'level'   => [
            'admin'     => ['name'  => 'Admin'],
            'member'    => ['name'  => 'Member'] 
        ],
        
        'type'   => [
            'feature'   => ['name'  => 'Feature'],
            'normal'    => ['name'  => 'Normal']
        ],

        'search'    => [
            'all'           => ['name'  => 'Search by All'],
            'id'            => ['name'  => 'Search by ID'],
            'name'          => ['name'  => 'Search by Name'],
            'username'      => ['name'  => 'Search by Username'],
            'fullname'      => ['name'  => 'Search by Fullname'],
            'email'         => ['name'  => 'Search by Email'],
            'description'   => ['name'  => 'Search by Description'],
            'link'          => ['name'  => 'Search by Link'],
            'content'       => ['name'  => 'Search by Content'],
            'title'         => ['name'  => 'Search by Title'],
            'tag'           => ['name'  => 'Search by Tag'],
            'phone_number'  => ['name'  => 'Search by Phone Number'],
            'phone'         => ['name'  => 'Search by Phone'],
            'message'       => ['name'  => 'Search by Message'],
            'code'          => ['name'  => 'Search by Code'],
            'value'         => ['name'  => 'Search by Value'],
            'type'          => ['name'  => 'Search by Type'],
            'province'      => ['name'  => 'Search by Province'],
            'country'       => ['name'  => 'Search by Country'],
            'note'          => ['name'  => 'Search by Note'],
            'address'       => ['name'  => 'Search by Address'],
            'payment'       => ['name'  => 'Search by Payment'],
        ],

        'button'    => [
            'edit'      => ['title' => 'Edit',      'class' => 'btn-success',               'icon' => 'fa-pencil',  'route-name' => '/form'],
            'delete'    => ['title' => 'Delete',    'class' => 'btn-danger btn-delete',     'icon' => 'fa-trash',   'route-name' => '/delete'],
        ],

        'sort'      => [
            'default'   => ['name'  => 'Default'],
            'asc'       => ['name'  => 'Ascending'],
            'desc'      => ['name'  => 'Descending'],
        ]
    ],

    'path'      => [
        'gallery'       => 'image\gallery'
    ],

    'config'    => [
        'search'    => [
            'default'           => ['all'],
            'banner'            => ['all', 'name', 'description', 'link'],
            'categoryProduct'   => ['all', 'name'],
            'product'           => ['all', 'name', 'description'],
            'user'              => ['all', 'username', 'fullname', 'email'],
            'menu'              => ['all', 'name'],
            'article'           => ['all', 'title', 'content', 'tag'],
            'categoryArticle'   => ['all', 'name'],
            'recall'            => ['all', 'phone_number'],
            'contact'           => ['all', 'name', 'email', 'phone', 'message'],
            'menu'              => ['all', 'name', 'link'],
            'attribute'         => ['all', 'name'],
            'coupon'            => ['all', 'code', 'value', 'type'],
            'shippingCost'      => ['all', 'province'],
            'order'             => ['all', 'fullname', 'username', 'address', 'country', 'phone', 'email', 'note', 'payment']
        ],

        'button'    => [
            'default'           => ['edit', 'delete'],
            'banner'            => ['edit', 'delete'],
            'categoryProduct'   => ['edit', 'delete'],
            'product'           => ['edit', 'delete'],
            'user'              => ['edit', 'delete'],
            'menu'              => ['edit', 'delete'],
            'article'           => ['edit', 'delete'],
            'categoryArticle'   => ['edit', 'delete'],
            'menu'              => ['edit', 'delete'],
            'attribute'         => ['edit', 'delete'],
            'code'              => ['edit', 'delete'],
            'coupon'            => ['edit', 'delete'],
            'shippingCost'      => ['edit', 'delete'],
            'recall'            => ['delete'],
            'contact'           => ['delete'],
            'order'             => ['delete'],
        ]
    ],

    'notify'    => [
        'success'   => [
            'update'    =>  'Cập nhật thành công!'
        ]
    ]
];