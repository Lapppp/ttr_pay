<?php

   namespace App\Controllers;

   use App\Controllers\BaseController;
   use App\Models\OrderModel;
   use App\Factories\PaymentFactory;
   use CodeIgniter\API\ResponseTrait;
   use CodeIgniter\HTTP\ResponseInterface;
   use Exception;

   class PaymentController extends BaseController
   {
      use ResponseTrait;

      protected $orderModel;

      public function __construct()
      {
         $this->orderModel = new OrderModel();
      }

      /**
       * Create a new order and process payment
       *
       * @return ResponseInterface
       */
      public function createOrder(): ResponseInterface
      {
         log_message('debug', 'Request Body: ' . $this->request->getBody());

         $input = $this->request->getJSON(true);
         if (empty($input)) {
            $input = $this->request->getPost();
         }

         $rules = [
            'customer_name' => 'required|min_length[3]|max_length[255]',
            'amount' => 'required|numeric|greater_than[0]',
            'payment_type' => 'required|in_list[momo,stripe,paypal]',
         ];

         $paymentType = $input['payment_type'] ?? '';

         switch ($paymentType) {
            case 'momo':
               $rules['phone'] = 'required';
               break;
            case 'stripe':
               $rules['credit_card'] = 'required';
               break;
            case 'paypal':
               $rules['email'] = 'required';
               break;
         }

         $validation = \Config\Services::validation();
         $validation->setRules($rules);

         if (!$validation->run($input)) {
            return $this->fail($validation->getErrors(), 400);
         }

         $orderData = [
            'customer_name' => $input['customer_name'],
            'amount' => $input['amount'],
            'payment_type' => $paymentType,
            'payment_details' => json_encode($input),
         ];

         try {
            $paymentGateway = PaymentFactory::createPaymentGateway($paymentType);

            $paymentData = [
               'amount' => $orderData['amount'],
            ];

            switch ($paymentType) {
               case 'momo':
                  $paymentData['phone'] = $input['phone'] ?? '';
                  break;
               case 'stripe':
                  $paymentData['credit_card'] = $input['credit_card'] ?? '';
                  break;
               case 'paypal':
                  $paymentData['email'] = $input['email'] ?? '';
                  break;
            }

            $result = $paymentGateway->processPayment($paymentData);

            $shouldSaveOrder = $result['status'] ?? false;

            if (isset($result['payment_status']) && in_array($result['payment_status'], [0, 1, 2])) {
               $shouldSaveOrder = true;
            }

            if ($shouldSaveOrder) {
               $orderData['payment_status'] = $result['payment_status'] ?? 0;
               $orderData['response_message'] = $result['message'] ?? '';
               $orderData['transaction_id'] = $result['transaction_id'] ?? null;

               $this->orderModel->insert($orderData);
               $orderId = $this->orderModel->getInsertID();

               $responseData = [
                  'order_id' => $orderId,
                  'status' => $result['status'] ?? false,
                  'message' => $result['message'] ?? 'Payment processed',
                  'payment_status' => $result['payment_status'] ?? 0,
               ];

               if (($result['status'] ?? false) === true) {
                  return $this->respond($responseData, 200);
               } else {
                  return $this->fail($responseData, 400);
               }
            } else {
               return $this->fail([
                  'status' => false,
                  'message' => $result['message'] ?? 'Payment processing failed',
               ], 400);
            }
         } catch (Exception $e) {
            return $this->fail([
               'status' => false,
               'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
         }
      }
   }