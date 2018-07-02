<?php

header('Content-Type: text/html; charset=utf-8');
// Lấy BIll ID từ form người dùng nhập vào
$billId = isset($_POST['billId']) ? $_POST['billId'] : FALSE;

if ($billId != FALSE) {
    // Kết nối tới cơ sở dữ liệu
    $con = new mysqli("localhost", "root", "", "budgetdb");
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    } else {
        $search = mysqli_query($con, "select * from tblbills where id = '" . $billId . "'");
        if (!$search || mysqli_num_rows($search) == 0) {
            //Nếu không tồn tại Bill ID, ta có thể thêm mới bình thường
        } else {
            // Nếu đã tồi tại Bill ID, ta thông báo cho người dùng
            echo "<script language='javascript'> alert('Note: Bill ID has already existed !!!');</script>";
        }
    }
}
?>