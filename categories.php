<?php 
include 'db.php';

$categoryQuery = "SELECT * FROM Categories";
$categoryResult = $conn->query($categoryQuery);

$products = [];


if (isset($_GET['category_id'])) {
    $selectedCategoryId = $_GET['category_id'];

    
    $productQuery = "SELECT p.barcode, p.itemDescription, p.price, s.supplier_name 
                     FROM Products p
                     LEFT JOIN Suppliers s ON p.supplier_id = s.supplier_id
                     WHERE p.category_id = ?";
    $stmt = $conn->prepare($productQuery);
    $stmt->bind_param("i", $selectedCategoryId);
    $stmt->execute();
    $productResult = $stmt->get_result();

 
    while ($row = $productResult->fetch_assoc()) {
        $products[] = $row;
    }
}


?>