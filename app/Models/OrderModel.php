<?php


   namespace Models;

   use CodeIgniter\Model;

   class OrderModel extends Model
   {
      protected $table = 'orders';
      protected $primaryKey = 'id';
      protected $useAutoIncrement = true;
      protected $returnType = 'array';
      protected $useSoftDeletes = false;
      protected $protectFields = true;
      protected $allowedFields = [
         'customer_name',
         'amount',
         'payment_type',
         'payment_status',
         'payment_details',
         'transaction_id',
         'response_message',
         'created_at',
         'updated_at'
      ];

      // Dates
      protected $useTimestamps = true;
      protected $dateFormat = 'datetime';
      protected $createdField = 'created_at';
      protected $updatedField = 'updated_at';

      // Validation
      protected $validationRules = [
         'customer_name' => 'required|min_length[3]|max_length[255]',
         'amount' => 'required|numeric|greater_than[0]',
         'payment_type' => 'required|in_list[momo,stripe,paypal]',
      ];
      protected $validationMessages = [];
      protected $skipValidation = false;
   }