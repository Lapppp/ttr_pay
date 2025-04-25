# Code này sẽ được trình bày theo các bước như sau:

Đầu tiên ta sẽ chạy lệnh php spark make:migration CreateOrdersTable tạo table orders
Ta sẽ chạy lệnh php spark migrate để tạo table orders trong database.
Ta sẽ chạy lệnh php spark make:controller OrderController để tạo controller OrderController.php trong thư mục app/Controllers.
Ta sẽ tạo model Order.php trong thư mục app/Models.
Ta sẽ tạo file app/Config/Routes.php.
Tạo các Serviece cho các payment method trong thư mục app/Services.
Thay đổi folder cho InterFace cho code dễ nhìn đọc.
Thay đổi nội dung file app/Config/Routes.php,
Chạy lệnh php spark serve để chạy server.

## Test trong Postman với các request sau:


{
"customer_name": "Nguyen Van A",
"amount": 100000,
"payment_type": "momo",
"phone": "089999999"  // Sẽ thành công
}

{
"customer_name": "Nguyen Van A",
"amount": 100000,
"payment_type": "momo",
"phone": "089111111"  // Sẽ thất bại
}

{
"customer_name": "Nguyen Van A",
"amount": 100000,
"payment_type": "stripe",
"credit_card": "4242424242424242"  // Sẽ thành công
}

{
"customer_name": "Nguyen Van A",
"amount": 100000,
"payment_type": "stripe",
"credit_card": "4000000000001018"  // Sẽ thất bại
}

{
"customer_name": "Nguyen Van A",
"amount": 100000,
"payment_type": "stripe",
"credit_card": "123"  // Không hợp lệ
}

{
"customer_name": "Nguyen Van A",
"amount": 100000,
"payment_type": "paypal",
"email": "success@ttrpay.net"  // Sẽ thành công
}

{
"customer_name": "Nguyen Van A",
"amount": 100000,
"payment_type": "paypal",
"email": "failed@ttrpay.net"  // Sẽ thất bại
}

{
"customer_name": "Nguyen Van A",
"amount": 100000,
"payment_type": "paypal",
"email": "invalid-email"  // Không hợp lệ
}