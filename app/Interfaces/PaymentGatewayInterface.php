<?php


   namespace App\Interfaces;

   interface PaymentGatewayInterface
   {
      /**
       * Process payment for an order
       *
       * @param  array  $orderData  Order data including payment details
       * @return array Response containing status and message
       */
      public function processPayment(array $orderData): array;
   }