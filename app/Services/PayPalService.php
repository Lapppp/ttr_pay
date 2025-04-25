<?php


   namespace App\Services;

   use App\Interfaces\PaymentGatewayInterface;

   class PayPalService implements PaymentGatewayInterface
   {
      /**
       * Process payment using PayPal
       *
       * @param  array  $orderData  Order data including email
       * @return array Response with status and message
       */
      public function processPayment(array $orderData): array
      {
         // Check if email exists
         if (empty($orderData['email'])) {
            return [
               'status' => false,
               'payment_status' => 0,
               'message' => 'Email is required'
            ];
         }

         $email = $orderData['email'];

         // Validate email format
         if ( !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return [
               'status' => false,
               'payment_status' => 2, // Invalid format
               'message' => 'Invalid email format',
               'transaction_id' => 'PAYPAL_'.uniqid()
            ];
         }

         // Success case: success@ttrpay.net
         if ($email === 'success@ttrpay.net') {
            return [
               'status' => true,
               'payment_status' => 1, // Success
               'message' => 'Payment processed by PayPal',
               'transaction_id' => 'PAYPAL_'.uniqid()
            ];
         }

         // Failure case: failed@ttrpay.net
         if ($email === 'failed@ttrpay.net') {
            return [
               'status' => false,
               'payment_status' => 0, // Failed
               'message' => 'Payment processing failed',
               'transaction_id' => 'PAYPAL_'.uniqid()
            ];
         }

         // Default case for other emails
         return [
            'status' => false,
            'payment_status' => 0,
            'message' => 'Payment processing failed'
         ];
      }
   }