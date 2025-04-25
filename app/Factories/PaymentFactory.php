<?php


   namespace App\Factories;

   use App\Interfaces\PaymentGatewayInterface;
   use App\Services\MomoService;
   use App\Services\StripeService;
   use App\Services\PayPalService;
   use InvalidArgumentException;

   class PaymentFactory
   {
      /**
       * Create a payment gateway instance based on payment type
       *
       * @param  string  $paymentType  Payment gateway type (momo, stripe, paypal)
       * @return PaymentGatewayInterface Payment gateway instance
       * @throws InvalidArgumentException If payment type is not supported
       */
      public static function createPaymentGateway(string $paymentType): PaymentGatewayInterface
      {
         switch ($paymentType) {
            case 'momo':
               return new MomoService();
            case 'stripe':
               return new StripeService();
            case 'paypal':
               return new PayPalService();
            default:
               throw new InvalidArgumentException("Unsupported payment gateway: {$paymentType}");
         }
      }
   }