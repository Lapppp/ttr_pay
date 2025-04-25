<?php


namespace App\Services;

use App\Interfaces\PaymentGatewayInterface;

class MomoService implements PaymentGatewayInterface
{
    /**
     * Process payment using Momo
     *
     * @param  array  $orderData  Order data including phone number
     * @return array Response with status and message
     */
    public function processPayment(array $orderData): array
    {
        // Check if phone number exists
        if (empty($orderData['phone'])) {
            return [
                'status' => false,
                'payment_status' => 0,
                'message' => 'Please enter your phone'
            ];
        }

        $phone = $orderData['phone'];

        // Special case: 089111111 - Failed payment
        if ($phone == '089111111') {
            return [
                'status' => false,
                'payment_status' => 0,
                'message' => 'Something went wrong',
                'transaction_id' => 'MOMO_'.uniqid()
            ];
        }

        // Special case: 089999999 - Successful payment
        if ($phone == '089999999') {
            return [
                'status' => true,
                'payment_status' => 1,
                'message' => 'Payment processed by Momo',
                'transaction_id' => 'MOMO_'.uniqid()
            ];
        }

        // Default case for other phone numbers
        return [
            'status' => false,
            'payment_status' => 0,
            'message' => 'Please enter your phone'
        ];
    }
}