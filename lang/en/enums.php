<?php

return [
    'role' => [
        'admin' => 'Administrator',
        'customer' => 'Customer',
    ],

    'provider' => [
        'google' => 'Google',
        'apple' => 'Apple'
    ],

    'payment_method' => [
        'cash on delivery' => 'Cash On Delivery',
        'credit card' => 'Credit Card'
    ],

    'discount_type' => [
        'percentage' => 'Percentage',
        'fixed' => 'Fixed Amount',
    ],

    'order_status' => [
        'pending' => 'Pending',
        'processing' => 'Processing',
        'shipped' => 'Shipped',
        'delivered' => 'Delivered',
        'cancelled' => 'Cancelled'
    ],

    'payment_status' => [
        'pending' => 'Pending',
        'paid' => 'Paid',
        'cancelled' => 'Cancelled',
    ],
];