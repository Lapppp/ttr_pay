<?php
namespace App\Services;

class MomoService implements PaymentGatewayInterface
{
    public function processPayment(array $orderData): array
    {
        $phone = $orderData['phone'] ?? '';
    }
}