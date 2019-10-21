<?php
return [
    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | The default title of your admin panel, this goes into the title tag
    | of your page. You can override it per page with the title section.
    | You can optionally also specify a title prefix and/or postfix.
    |
    */
    'title' => 'Kaypi',
    'title_prefix' => '',
    'title_postfix' => '',
    /*
    |--------------------------------------------------------------------------
    | Logo
    |--------------------------------------------------------------------------
    |
    | This logo is displayed at the upper left corner of your admin panel.
    | You can use basic HTML here if you want. The logo has also a mini
    | variant, used for the mini side bar. Make it 3 letters or so
    |
    */
    'logo' => '<b>Kaypi</b> v1.0',
    'logo_mini' => '<b>KY</b>',
    /*
    |--------------------------------------------------------------------------
    | Skin Color
    |--------------------------------------------------------------------------
    |
    | Choose a skin color for your admin panel. The available skin colors:
    | blue, black, purple, yellow, red, and green. Each skin also has a
    | ligth variant: blue-light, purple-light, purple-light, etc.
    |
    */
    'skin' => 'blue',
    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Choose a layout for your admin panel. The available layout options:
    | null, 'boxed', 'fixed', 'top-nav'. null is the default, top-nav
    | removes the sidebar and places your menu in the top navbar
    |
    */
    'layout' => null,
    /*
    |--------------------------------------------------------------------------
    | Collapse Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we choose and option to be able to start with a collapsed side
    | bar. To adjust your sidebar layout simply set this  either true
    | this is compatible with layouts except top-nav layout option
    |
    */
    'collapse_sidebar' => false,
    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Register here your dashboard, logout, login and register URLs. The
    | logout URL automatically sends a POST request in Laravel 5.3 or higher.
    | You can set the request to a GET or POST with logout_method.
    | Set register_url to null if you don't want a register link.
    |
    */
    'dashboard_url' => 'home',
    'logout_url' => 'logout',
    'logout_method' => null,
    'login_url' => 'login',
    'register_url' => 'register',
    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Specify your menu items to display in the left sidebar. Each menu item
    | should have a text and and a URL. You can also specify an icon from
    | Font Awesome. A string instead of an array represents a header in sidebar
    | layout. The 'can' is a filter on Laravel's built in Gate functionality.
    |
    */
    'menu' => [
       
        'VENTAS',        [
            // This option is only here to tell the system that this is a search menu item
            // as we coud not rely on the 'text' value.
            'search' => true,
        
            // The "text" option is used now as value for the placeholder
            'text' => 'Buscar Cliente...',
        
            // Another option (not implemented) would be to create a "placeholder" option but I thought it would be more
            // consistant from a configurat point of view to keep "text" (less consistant from a HTML point of view though)
            // 'placeholder' => 'Search...',
            
            // OPTIONAL
        
            // Same as the HREF filter:
            'url' => '/buscar',
            // Or
           // 'route' => '/ventas/venta/',
        
            // Must be post or get otherwise it set to the default "get"
            // https://www.w3.org/TR/html401/interact/forms.html#h-17.3
            'method' => 'get', 
        
            // Set the name of the search input field. Default= "q"
            'input_name' => 'searchText',
        ],
        [
            'text' => 'Clientes',
            'url'  => '#',
            'icon' => 'user',
            'submenu' => [
                [
                'text' => 'Nuevo cliente',
                'url'  => 'ventas/cliente/create',
                'icon' => 'user-plus',
                ],
                [
                    'text' => 'Listado de clientes',
                    'url'  => 'ventas/cliente',
                    'icon' => 'users',
                ],
            ],
            
        ],
        [
            'text' => 'Compras',
            'url'  => '#',
            'icon' => 'th',
            'submenu' => [
                    [
                    'text' => 'Ingreso Compras',
                    'url'  => 'compras/ingreso',
                    'icon' => 'plus-circle',
                    ],
                    [
                        'text' => 'Proveedores',
                        'url'  => 'compras/proveedor',
                        'icon' => 'truck',
                    ],
            ],
        ],
        [
            'text' => 'Ventas',
            'url'  => '#',
            'icon' => 'shopping-cart',
            'submenu' => [
                    [
                    'text' => 'Nueva Venta',
                    'url'  => 'ventas/venta/create',
                    'icon' => 'cart-plus',
                    ],
                    [
                        'text' => 'Ventas',
                        'url'  => 'ventas/venta',
                        'icon' => 'file-text',
                    ],
                    [
                        'text' => 'Facturación Electrónica',
                        'url'  => 'http://162.243.161.165:9091/factura',
                        'icon' => 'file-pdf-o',
                    ],
            ],
        ],
        [
            'text' => 'Almacen',
            'url'  => '#',
            'icon' => 'building-o',
            'submenu' => 
        [
            
                    [
                    'text' => 'Inventario',
                    'url'  => 'almacen/articulo',
                    'icon' => 'archive',
                    'submenu' => [
                        [
                            'text' => 'Otavalo',
                            'url'  => 'almacen/articulo1',
                            'icon' => 'archive',
                        ],
                        [
                            'text' => 'Quito',
                            'url'  => 'almacen/articulo2',
                            'icon' => 'archive',
                        ],
                    ],
                    ],
                    [
                        'text' => 'Ingreso Productos',
                        'url'  => 'almacen/articulo/create',
                        'icon' => 'plus-square',
                    ],
                    [
                        'text' => 'Categoria Productos',
                        'url'  => 'almacen/categoria',
                        'icon' => 'tags',
                    ],
            ],
        ],
        
        [
            'text' => 'Reportes',
            'url'  => '#',
            'icon' => 'file-text-o',
            'submenu' => [
                [
                    'text' => 'Ventas',
                    'url'  => 'ventas/reportes',
                    'icon' => 'line-chart',
                ],
                [
                    'text' => 'Inventario',
                    'url'  => 'almacen/articulo',
                    'icon' => 'list',
                    'submenu' => [
                        [
                            'text' => 'Otavalo',
                            'url'  => '/reportes1',
                            'icon' => 'list-ol',
                        ],
                        [
                            'text' => 'Quito',
                            'url'  => '/reportes2',
                            'icon' => 'list-ol',
                        ],
                    ],
                    ],
                [
                    'text' => 'Pagos',
                    'url'  => '/pagos/pago',
                    'icon' => 'money',
                ],
        ],
        ],
    
        'PROCESOS',
        [
            'text'  => 'Ordenes',
            'url'   => '#',
            'icon'  => 'clone',
            'submenu' => [
                [
                    'text'  => 'Nueva Orden',
                    'url'   => 'ventas/ordenes/create',
                    'icon'  => 'plus',
                ],
                [
                    'text'  => 'Listado de Ordenes',
                    'url'   => 'ventas/ordenes',
                    'icon'  => 'file-text-o',
                ],
    
            ],
        ],
        [
            'text'  => 'Procesos',
            'url'   => 'ventas/procesos',
            'icon'  => 'tasks',
          
        ],
        [
            'text'  => 'Configuración',
            'url'   => '#',
            'icon'  => 'cogs',
            'submenu' => [
                [
                    'text'  => 'Departamentos',
                    'url'   => 'departamentos/departamento',
                    'icon'  => 'building-o',
                ],
                [
                    'text'  => 'Procesos',
                    'url'   => 'departamentos/procesos',
                    'icon'  => 'cubes',
                ],
                [
                    'text'  => 'Usuarios',
                    'url'   => 'roles/usuario',
                    'icon'  => 'users',
                ],
                [
                    'text'  => 'Tipo Empleado',
                    'url'   => 'roles/empleados',
                    'icon'  => ' fa-street-view',
                ],
                [
                    'text'  => 'Tipo Pago',
                    'url'   => 'pagos/tipopago',
                    'icon'  => ' fa-credit-card',
                ],
            ],
        ],
        'FACTURACIÓN ELECTRÓNICA',
        [
            'text'  => 'Retenciones',
            'url'   => '#',
            'icon'  => 'clone',
            'submenu' => [
                [
                    'text'  => 'Nueva Retencion',
                    'url'   => 'compras/retenciones/create',
                    'icon'  => 'plus',
                ],
                [
                    'text'  => 'Nuevo Proveedor',
                    'url'   => 'compras/proveedor/create',
                    'icon'  => 'truck',
                ],
                [
                    'text'  => 'Listado de Retenciones',
                    'url'   => 'compras/retenciones',
                    'icon'  => 'file-text-o',
                ],
    
            ],
        ],   

       
    ],
    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Choose what filters you want to include for rendering the menu.
    | You can add your own filters to this array after you've created them.
    | You can comment out the GateFilter if you don't want to use Laravel's
    | built in Gate functionality
    |
    */
    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SubmenuFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
    ],
    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Choose which JavaScript plugins should be included. At this moment,
    | only DataTables is supported as a plugin. Set the value to true
    | to include the JavaScript file from a CDN via a script tag.
    |
    */
    'plugins' => [
        'datatables' => true,
        'select2'    => true,
        'chartjs'    => true,
    ],
];