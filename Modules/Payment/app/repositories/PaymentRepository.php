<?php

namespace Modules\Payment\Repositories;

use Modules\Payment\Models\Payment;

class PaymentRepository
{
    public function create(array $data)
    {
        $payment = Payment::create($data);

        return $payment->fresh(['order.orderItems.variant.product']);
    }

    public function update(Payment $payment, array $data)
    {
        $payment->update($data);

        return $payment->fresh(['order.orderItems.variant.product']);
    }

    public function delete(Payment $payment)
    {
        return $payment->delete();
    }
}