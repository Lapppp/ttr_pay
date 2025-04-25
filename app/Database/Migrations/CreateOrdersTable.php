<?php


use CodeIgniter\Database\Migration;

class CreateOrdersTable extends Migration
{
    public function up()
    {
       $this->forge->addField([
          'id' => [
             'type' => 'INT',
             'constraint' => 11,
             'unsigned' => true,
             'auto_increment' => true,
          ],
          'customer_name' => [
             'type' => 'VARCHAR',
             'constraint' => 255,
          ],
          'amount' => [
             'type' => 'DECIMAL',
             'constraint' => '10,2',
          ],
          'payment_type' => [
             'type' => 'VARCHAR',
             'constraint' => 50,
             'comment' => 'momo, stripe, paypal',
          ],
          'payment_status' => [
             'type' => 'TINYINT',
             'constraint' => 1,
             'default' => 0,
             'comment' => '0: Failed, 1: Success, 2: Invalid',
          ],
          'payment_details' => [
             'type' => 'TEXT',
             'null' => true,
          ],
          'transaction_id' => [
             'type' => 'VARCHAR',
             'constraint' => 255,
             'null' => true,
          ],
          'response_message' => [
             'type' => 'VARCHAR',
             'constraint' => 255,
             'null' => true,
          ],
          'created_at' => [
             'type' => 'DATETIME',
             'null' => true,
          ],
          'updated_at' => [
             'type' => 'DATETIME',
             'null' => true,
          ],
       ]);

       $this->forge->addKey('id', true);
       $this->forge->createTable('orders');
    }

    public function down()
    {
       $this->forge->dropTable('orders');
    }
}
