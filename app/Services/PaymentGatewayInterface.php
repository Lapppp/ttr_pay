<?php
namespace App\Services;

interface PaymentGatewayInterface
{
    public function processPayment(array $orderData): array;
}
