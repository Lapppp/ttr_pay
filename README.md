
### **Đề bài:**

Bạn đang phát triển một hệ thống thanh toán trực tuyến cho một cửa hàng điện tử. Hệ thống cần hỗ trợ nhiều cổng thanh toán khác nhau, bao gồm PayPal, Stripe, và Momo. Các cổng thanh toán này sẽ được gọi từ một controller khi người dùng đặt hàng. Bạn cần xây dựng một hệ thống linh hoạt để có thể dễ dàng thay thế hoặc thêm mới các cổng thanh toán mà không cần thay đổi quá nhiều mã nguồn.

----------

### **Yêu cầu:**

1.  **Tạo Interface `PaymentGatewayInterface`:**
    
    -   Interface này sẽ định nghĩa một phương thức `processPayment($orderData)`, nơi bạn sẽ xử lý thanh toán cho mỗi cổng.
        
    
    **Tạo Migration và Model:**
    
    -   Tạo migration và model cho bảng `orders`.
        
2.  **Tạo API `createOrder` trong `PaymentController`** lưu dữ liệu vào table `orders`.
    
    -   **Sử dụng phương thức `processPayment` tại Lớp `MomoService` (payment_type = momo)** bổ sung các trường hợp nếu số điện thoại là:
        
        -   **089111111** thì trả về trạng thái thất bại kèm message `'Something went wrong'` và `payment_status = 0`.
            
        -   **089999999** thì trả về thành công kèm message `'Payment processed by Momo'` và `payment_status = 1`.
            
        -   Các trường hợp khác thì thất bại và message là `'Please enter your phone'` (không insert dữ liệu vào bảng).
            
3.  **Tạo thêm phương thức thanh toán mới là Stripe và PayPal và tích hợp vào `PaymentController.createOrder()`**:
    
    -   **Stripe:**
        
        -   Nếu **Credit Card** truyền vào là `'4242424242424242'` thì `status = 1` (thành công).
            
        -   Nếu **Credit Card** truyền vào là `'4000000000001018'` thì `status = 0` (thất bại).
            
        -   Nếu **Credit Card** không đúng định dạng thì `status = 2` (không hợp lệ).
            
        -   Các trường hợp khác không insert dữ liệu vào bảng `orders`.
            
    -   **PayPal:**
        
        -   Nếu **email** truyền vào là `'success@ttrpay.net'` thì `status = 1` (thành công).
            
        -   Nếu **email** truyền vào là `'failed@ttrpay.net'` thì `status = 0` (thất bại).
            
        -   Nếu **email** không đúng định dạng thì `status = 2` (không hợp lệ).
            
        -   Các trường hợp khác không insert dữ liệu vào bảng `orders`.
            
4.  **Đảm bảo các dữ liệu POST request truyền vào được validate trước khi lưu vào cơ sở dữ liệu.**