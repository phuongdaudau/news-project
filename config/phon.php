<?php

return [
    'url' => [
        'prefix_admin'  => 'admin123',
        'prefix_news'   => 'news69',
    ],
    'format' => [
        'long_time'     => 'H:m:s d/m/Y',
        'short_time'    => ' d/m/Y',
    ],
    'template' => [ // giao diện
        'form_input' => [
            'class' => 'form-control col-md-6 col-xs-12',
        ],
        'form_ckeditor' => [
            'class' => 'form-control col-md-6 col-xs-12 ckeditor',
        ],
        'form_label' => [
            'class' => 'control-label col-md-3 col-sm-3 col-xs-12',
        ],
        'form_label_edit' => [
            'class' => 'control-label col-md-4 col-sm-3 col-xs-12',
        ],
        'status' => [
            'all'   => ['name' => 'Tất cả', 'class' => 'btn-success'],
            'active'    => ['name' => 'Kích hoạt', 'class' => 'btn-success'],
            'inactive'  => ['name' => 'Chưa kích hoạt', 'class' => 'btn-info'],
            'block'     => ['name' => 'Bị khóa', 'class' => 'btn-danger'],
            'default'   => ['name' => 'Chưa xác định ', 'class' => 'btn-info'],
        ],
        'is_home' => [
            '1'   => ['name' => 'Hiển thị', 'class' => 'btn-primary'],
            '0'   => ['name' => 'Không hiển thị', 'class' => 'btn-warning'],
        ],
        'display' => [
            'list'   => ['name' => 'Danh sách'],
            'grid'   => ['name' => 'Lưới'],
        ],
        'type' => [
            'feature'   => ['name' => 'Nổi bật'],
            'normal'    => ['name' => 'Bình thường'],
        ],
        'rss_source' => [
            'vnexpress'   => ['name' => 'VNExpress'],
            'tuoitre'    => ['name' => 'Tuổi trẻ'],
        ],
        'level' => [
            'member'   => ['name' => 'Người dùng'],
            'admin'    => ['name' => 'Quản trị hệ thống'],
        ],
        'search' => [
            'all'           => ['name' => 'Search by All'],
            'id'            => ['name' => 'Search by ID'],
            'name'          => ['name' => 'Search by Name'],
            'username'          => ['name' => 'Search by Username'],
            'fullname'          => ['name' => 'Search by Fullname'],
            'email'          => ['name' => 'Search by Email'],
            'description'   => ['name' => 'Search by Description'],
            'link'          => ['name' => 'Search by Link'],
            'content'       => ['name' => 'Search by Content'],
        ],
        'button'        => [
            'edit'      => ['class' => 'btn-success', 'title' => 'Edit', 'icon' => 'fa-pencil', 'route-name' => '/form'],
            'delete'    => ['class' => 'btn-danger btn-delete', 'title' => 'Delete', 'icon' => 'fa-trash', 'route-name' => '/delete'],
            'info'      => ['class' => 'btn-success', 'title' => 'View', 'icon' => 'fa-pencil', 'route-name' => '/delete'],
        ]
    ],
    'config' => [ // cấu hình 
        'search' => [
            'default'   => ['all', 'id', 'name'],
            'slider'    => ['all', 'id', 'name', 'description', 'link'],
            'category'  => ['all', 'id', 'name'],
            'article'   => ['all', 'name', 'content'],
            'user'      => ['all', 'username', 'fullname', 'email',],
            'rss'       => ['all', 'id', 'link'],
        ],
        'button' => [
            'default'   => ['edit', 'delete'],
            'slider'    => ['edit', 'delete'],
            'category'  => ['edit', 'delete'],
            'article'   => ['edit', 'delete'],
            'rss'       => ['edit', 'delete'],
            'user'   => ['edit'],
        ]
    ]
];
