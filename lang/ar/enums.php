<?php

return [
    'role' => [
        'admin' => 'مدير',
        'customer' => 'عميل',
    ],

    'provider' => [
        'google' => 'جوجل',
        'apple' => 'ابل'
    ],

    'payment_method' => [
        'cash on delivery' => 'كاش عند الاستلام',
        'credit card' => 'بطافة ائتمان'
    ],

    'discount_type' => [
        'percentage' => 'نسبة مئوية',
        'fixed' => 'مبلغ ثابت',
    ],

    'order_status' => [
        'pending' => 'قيد الانتظار',
        'processing' => 'قيد التجهيز',
        'shipped' => 'تم الشحن',
        'delivered' => 'تم التوصيل',
        'cancelled' => 'ملغى',
    ],

    'payment_status' => [
        'pending' => 'قيد الانتظار',
        'paid' => 'تم الدفع',
        'cancelled' => 'ملغى',
    ],
];