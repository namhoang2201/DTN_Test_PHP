<?php

header('Content-Type: text/html; charset=utf-8');
$billId = isset($_POST['billId']) ? $_POST['billId'] : FALSE;




// Kiểm tra xem đã tồn tại Bill ID trong cơ sở dữ liệu hay chưa ?
$search_query = "SELECT * FROM tblbills WHERE id = " . $billId;
$kq = $conn->query($search_query);
if ($kq->num_rows > 0) {
    echo '<script type="text/javascript"> alert("Đã tồn tại Bill ID")</script>';
    echo "Da ton tai Bill ID";
} else {
// Ngược lại thì thêm bản ghi mới vào cơ sở dữ liệu

    $insert_query = "INSERT INTO tblbills VALUES ()";
}
?>