<?php

include 'db.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['search_barcode'])) {
    $barcode = $_POST['search_barcode'];

   
    $query = "SELECT * FROM products WHERE barcode = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $barcode);
    $stmt->execute();
    $result = $stmt->get_result();

    
    if ($result->num_rows > 0) {
        $output = '<h5>Search Results</h5>';
        $output .= '<table class="table table-bordered table-striped">
                        <thead>
                            <tr>';
        
        
        while ($field = $result->fetch_field()) {
            $output .= '<th>' . htmlspecialchars($field->name) . '</th>';
        }
        
        $output .= '</tr>
                    </thead>
                    <tbody>';
        
        
        while ($row = $result->fetch_assoc()) {
            $output .= '<tr>';
            foreach ($row as $value) {
                $output .= '<td>' . htmlspecialchars($value) . '</td>';
            }
            $output .= '</tr>';
        }

        $output .= '</tbody></table>';
    } else {
      
        $output = '<p>No product found with the barcode: ' . htmlspecialchars($barcode) . '</p>';
    }

    echo $output;
    exit; 
}
?>
