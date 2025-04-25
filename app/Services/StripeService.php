<?php


   namespace App\Services;

   use App\Interfaces\PaymentGatewayInterface;

   class StripeService implements PaymentGatewayInterface
   {
      /**
       * Process payment using Stripe
       *
       * @param  array  $orderData  Order data including credit card
       * @return array Response with status and message
       */
      public function processPayment(array $orderData): array
      {
         // Check if credit card exists
         if (empty($orderData['credit_card'])) {
            return [
               'status' => false,
               'payment_status' => 0,
               'message' => 'Credit card is required'
            ];
         }

         $creditCard = $orderData['credit_card'];

         // Validate credit card format (simple validation)
         if ( !preg_match('/^\d{16}$/', $creditCard)) {
            return [
               'status' => false,
               'payment_status' => 2, // Invalid format
               'message' => 'Invalid credit card format',
               'transaction_id' => 'STRIPE_'.uniqid()
            ];
         }

         // Success case: 4242424242424242
         if ($creditCard === '4242424242424242') {
            return [
               'status' => true,
               'payment_status' => 1, // Success
               'message' => 'Payment processed by Stripe',
               'transaction_id' => 'STRIPE_'.uniqid()
            ];
         }

         // Failure case: 4000000000001018
         if ($creditCard === '4000000000001018') {
            return [
               'status' => false,
               'payment_status' => 0, // Failed
               'message' => 'Your card was declined',
               'transaction_id' => 'STRIPE_'.uniqid()
            ];
         }

         // Default case for other credit cards
         return [
            'status' => false,
            'payment_status' => 0,
            'message' => 'Payment processing failed'
         ];
      }
   }