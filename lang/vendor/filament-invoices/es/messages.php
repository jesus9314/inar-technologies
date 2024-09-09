<?php

return [
    'invoices' => [
        'title' => 'Facturas',
        'single' => 'Factura',
        'widgets' => [
            'count' => 'Total de Facturas',
            'paid' => 'Total de Dinero Pagado',
            'due' => 'Total Pendiente'
        ],
        'columns' => [
            'uuid' => 'ID de Factura',
            'name' => 'Nombre del Cliente',
            'phone' => 'Número de Teléfono',
            'address' => 'Dirección',
            'date' => 'Fecha de la Factura',
            'due_date' => 'Fecha de Vencimiento',
            'type' => 'Tipo de Factura',
            'status' => 'Estado',
            'currency_id' => 'Moneda',
            'items' => 'Artículos de la Factura',
            'item' => 'Artículo',
            'item_name' => 'Nombre del Artículo',
            'description' => 'Descripción',
            'qty' => 'Cantidad',
            'price' => 'Precio',
            'discount' => 'Descuento',
            'vat' => 'IVA',
            'total' => 'Total',
            'shipping' => 'Envío',
            'notes' => 'Notas',
            'account' => 'Cuenta',
            'by' => 'por',
            'from' => 'De',
            'paid' => 'Pagado',
            'updated_at' => 'Actualizado En',
        ],
        'sections' => [
            'from_type' => [
                'title' => 'Tipo de Origen',
                'columns' => [
                    'from_type' => 'Tipo de Origen',
                    'from' => 'De',
                ],
            ],
            'billed_from' => [
                'title' => 'Facturado Desde',
                'columns' => [
                    'for_type' => 'Para Tipo',
                    'for' => 'Para',
                ],
            ],
            'customer_data' => [
                'title' => 'Datos del Cliente',
                'columns' => [
                    'name' => 'Nombre',
                    'phone' => 'Teléfono',
                    'address' => 'Dirección',
                ],
            ],
            'invoice_data' => [
                'title' => 'Datos de la Factura',
                'columns' => [
                    'date' => 'Fecha',
                    'due_date' => 'Fecha de Vencimiento',
                    'type' => 'Tipo',
                    'status' => 'Estado',
                    'currency' => 'Moneda',
                ],
            ],
            'totals' => [
                'title' => 'Totales'
            ],
        ],
        'filters' => [
            'status' => 'Estado',
            'type' => 'Tipo',
            'due' => [
                'label' => 'Fecha de Vencimiento',
                'columns' => [
                    'overdue' => 'Atrasada',
                    'today' => 'Hoy',
                ]
            ],
            'for' => [
                'label' => 'Filtrar Por',
                'columns' => [
                    'for_type' => 'Para Tipo',
                    'for_name' => 'Para Nombre',
                ]
            ],
            'from' => [
                'label' => 'Filtrar Por De',
                'columns' => [
                    'from_type' => 'Desde Tipo',
                    'from_name' => 'Desde Nombre',
                ]
            ],
        ],
        'actions' => [
            'total' => 'Total',
            'paid' => 'Pagado',
            'amount' => 'Cantidad',
            'view_invoice' => 'Ver Factura',
            'edit_invoice' => 'Editar Factura',
            'archive_invoice' => 'Archivar Factura',
            'delete_invoice_forever' => 'Eliminar Factura Permanentemente',
            'restore_invoice' => 'Restaurar Factura',
            'invoices_status' => 'Estado de las Facturas',
            'print' => 'Imprimir',
            'pay' => [
                'label' => 'Pagar Factura',
                'notification' => [
                    'title' => 'Factura Pagada',
                    'body' => 'Factura Pagada Exitosamente'
                ]
            ],
            'status' => [
                'title' => 'Estado',
                'label' => 'Cambiar Estado',
                'tooltip' => 'Cambiar Estado de las Facturas Seleccionadas',
                'form' => [
                    'model_id' => 'Usuarios',
                    'model_type' => 'Tipo de Usuario',
                ],
                'notification' => [
                    'title' => 'Estado Cambiado',
                    'body' => 'Estado Cambiado Exitosamente'
                ]
            ],
        ],
        'logs' => [
            'title' => 'Registros de Facturas',
            'single' => 'Registro de Factura',
            'columns' => [
                'log' => 'Registro',
                'type' => 'Tipo',
                'created_at' => 'Creado En',
            ],
        ],
        'payments' => [
            'title' => 'Pagos',
            'single' => 'Pago',
            'columns' => [
                'amount' => 'Cantidad',
                'created_at' => 'Creado En',
            ],
        ],
        'view' => [
            'bill_from' => 'Facturar Desde',
            'bill_to' => 'Facturar A',
            'invoice' => 'Factura',
            'issue_date' => 'Fecha de Emisión',
            'due_date' => 'Fecha de Vencimiento',
            'status' => 'Estado',
            'type' => 'Tipo',
            'item' => 'Artículo',
            'total' => 'Total',
            'price' => 'Precio',
            'vat' => 'IVA',
            'discount' => 'Descuento',
            'qty' => 'Cant.',
            'bank_account' => 'Cuenta Bancaria',
            'name' => 'Nombre',
            'address' => 'Dirección',
            'branch' => 'Sucursal',
            'swift' => 'Swift',
            'account' => 'Cuenta',
            'owner' => 'Propietario',
            'iban' => 'IBAN',
            'signature' => 'Firma',
            'subtotal' => 'Subtotal',
            'tax' => 'Impuesto',
            'paid' => 'pagado',
            'balance_due' => 'Saldo Pendiente',
            'notes' => 'Notas',
        ]
    ],
    'settings' => [
        'status' => [
            'title' => 'Configuraciones del Estado de la Orden',
            'description' => 'Cambia los colores y el texto de tu estado de orden',
            'action' => [
                'edit' => 'Editar Estado',
                'notification' => 'Estado Actualizado Exitosamente',
            ],
            'columns' => [
                'status' => 'Estado',
                'icon' => 'Ícono',
                'color' => 'Color',
                'language' => 'Idioma',
                'value' => 'Valor',
            ]
        ],
    ],
];