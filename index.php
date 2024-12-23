<?php include_once 'db.php'; ?>

<?php
if (isset($_GET['search_barcode'])) {
    $barcode = $_GET['search_barcode'];

   
    $query = "SELECT * FROM products WHERE barcode = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $barcode); 
    $stmt->execute();
    $result = $stmt->get_result();

    echo '<div class="container mt-4">';
    echo '<h2>Search Results</h2>';
    if ($result->num_rows > 0) {
        echo '<table class="table table-bordered table-striped">
                <thead>
                    <tr>';
        
       
        while ($field = $result->fetch_field()) {
            echo '<th>' . htmlspecialchars($field->name) . '</th>';
        }

        echo '    </tr>
                </thead>
                <tbody>';
        
        
        while ($row = $result->fetch_assoc()) {
            echo '<tr>';
            foreach ($row as $value) {
                echo '<td>' . htmlspecialchars($value) . '</td>';
            }
            echo '</tr>';
        }

        echo '    </tbody>
              </table>';
    } else {
        echo '<p>No product found with the barcode: ' . htmlspecialchars($barcode) . '</p>';
    }
    echo '</div>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard with Sidebar</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="d-flex" id="wrapper">
       
        <div class="bg-dark border-end text-white" id="sidebar-wrapper">
            <div class="sidebar-heading text-center py-4">Dashboard</div>
            <div class="list-group list-group-flush">
                <a href="?page=home" class="list-group-item list-group-item-action bg-dark text-white border-0">Home</a>
                <a href="?page=products" class="list-group-item list-group-item-action bg-dark text-white border-0">Products</a>
                <a href="?page=categories" class="list-group-item list-group-item-action bg-dark text-white border-0">Product Categories</a>
                <a href="?page=suppliers" class="list-group-item list-group-item-action bg-dark text-white border-0">Suppliers</a>
                <a href="?page=incoming" class="list-group-item list-group-item-action bg-dark text-white border-0">Incoming Products</a>
                <a href="?page=damaged" class="list-group-item list-group-item-action bg-dark text-white border-0">Damaged Products</a>
                <a href="?page=inventory" class="list-group-item list-group-item-action bg-dark text-white border-0">Stocks Inventory</a>
                <a href="?page=cashiers" class="list-group-item list-group-item-action bg-dark text-white border-0">Cashiers</a>
                <a href="?page=sales" class="list-group-item list-group-item-action bg-dark text-white border-0">Sales Reports</a>
                <a href="?page=bestseller" class="list-group-item list-group-item-action bg-dark text-white border-0">Best Sellers</a>
                <a href="?page=replacements" class="list-group-item list-group-item-action bg-dark text-white border-0">Product Replacements</a>
                <a href="?page=refunds" class="list-group-item list-group-item-action bg-dark text-white border-0">Refunds</a>
                <a href="?page=logout_report" class="list-group-item list-group-item-action bg-dark text-white border-0">Cashier Logout Report</a>
                <a href="?page=import" class="list-group-item list-group-item-action bg-dark text-white border-0">Import CSV/XLS</a>
                <a href="?page=logout" class="list-group-item list-group-item-action bg-dark text-white border-0">Logout</a>
            </div>
        </div>

        <div id="page-content-wrapper" class="flex-grow-1">
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <div class="container-fluid">
                    <button class="btn btn-primary" id="menu-toggle">Toggle Menu</button>
                    <h1 class="ms-3">Dashboard</h1>
                    <button class="btn btn-outline-primary ms-auto" data-bs-toggle="modal" data-bs-target="#searchModal">Search Barcode</button>
                </div>
            </nav>

            <div class="container mt-4">
                <?php
                    
                    if (isset($_GET['page'])) {
                        $page = $_GET['page'];

                        switch ($page) {
                            case 'home':
                                $query = "SELECT COUNT(*) AS total_products FROM products";
                                $result = $conn->query($query);
                                $totalProducts = ($result->num_rows > 0) ? $result->fetch_assoc()['total_products'] : 0;
                                echo '<div class="row">
                                        <div class="col-md-4 mb-4">
                                            <div class="card p-4 bg-primary text-white">
                                                <h3>Products</h3>
                                                <p><strong>Number: ' . htmlspecialchars($totalProducts) . '</strong></p>
                                                <a href="?page=products" class="text-white">View Details</a>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-4">
                                            <div class="card p-4 bg-success text-white">
                                                <h3>Categories</h3>
                                                <p><strong>Number: 15</strong></p>
                                                <a href="?page=categories" class="text-white">View Details</a>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-4">
                                            <div class="card p-4 bg-warning text-dark">
                                                <h3>Suppliers</h3>
                                                <p><strong>Number: 10</strong></p>
                                                <a href="?page=suppliers" class="text-dark">View Details</a>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-4">
                                            <div class="card p-4 bg-danger text-white">
                                                <h3>Incoming Products</h3>
                                                <p><strong>Number: 50</strong></p>
                                                <a href="?page=incoming" class="text-white">View Details</a>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-4">
                                            <div class="card p-4 bg-info text-white">
                                                <h3>Damaged Products</h3>
                                                <p><strong>Number: 5</strong></p>
                                                <a href="?page=damaged" class="text-white">View Details</a>
                                            </div>
                                        </div>
                                        <div class="col-md-4 mb-4">
                                            <div class="card p-4 bg-secondary text-white">
                                                <h3>Inventory</h3>
                                                <p><strong>Number: 300</strong></p>
                                                <a href="?page=inventory" class="text-white">View Details</a>
                                            </div>
                                        </div>
                                    </div>';
                                break;
                                case 'products':
                                    
                                    $query = "SELECT barcode, itemDescription, category, price FROM products";
                                    $result = $conn->query($query);
                                    
                                    echo '<div class="card p-4">
                                            <h2>List of Products</h2>
                                            <p>Manage all products here.</p>';
                                    echo '<div style="max-height: 400px; overflow-y: auto;">';
                                
                                    if ($result->num_rows > 0) {
                                        echo '<table class="table table-striped">
                                                <thead>
                                                    <tr>
                                                        <th>Barcode</th>
                                                        <th>Description</th>
                                                        <th>Category</th>
                                                        <th>Price</th>
                                                    </tr>
                                                </thead>
                                                <tbody>';
                                        
                                        while ($row = $result->fetch_assoc()) {
                                            echo '<tr>
                                                    <td>' . htmlspecialchars($row['barcode']) . '</td>
                                                    <td>' . htmlspecialchars($row['itemDescription']) . '</td>
                                                    <td>' . htmlspecialchars($row['category']) . '</td>
                                                    <td>' . htmlspecialchars($row['price']) . '</td>
                                                  </tr>';
                                        }
                                
                                        echo '</tbody></table>';
                                    } else {
                                        echo '<p>No products found.</p>';
                                    }
                                
                                    echo '</div>';
                                    echo '</div>';
                                    $conn->close();
                                    break;
                                
                            case 'categories':
                                echo '<div class="card p-4"><h2>Product Categories</h2><p>View and manage product categories.</p></div>';
                                break;
                            case 'suppliers':
                                echo '<div class="card p-4"><h2>Suppliers</h2><p>View and manage suppliers.</p></div>';
                                break;
                            case 'incoming':
                                echo '<div class="card p-4"><h2>Incoming Products</h2><p>Track incoming product deliveries.</p></div>';
                                break;
                            case 'damaged':
                                echo '<div class="card p-4"><h2>Damaged Products</h2><p>View damaged products and details.</p></div>';
                                break;
                            case 'inventory':
                                echo '<div class="card p-4"><h2>Stocks Inventory</h2><p>Manage product inventory.</p></div>';
                                break;
                            case 'cashiers':
                                echo '<div class="card p-4"><h2>Cashiers</h2><p>Manage cashier details and permissions.</p></div>';
                                break;
                            case 'sales':
                                echo '<div class="card p-4"><h2>Sales Reports</h2><p>View sales data by day, week, month, or year.</p></div>';
                                break;
                            case 'bestseller':
                                echo '<div class="card p-4"><h2>Best Sellers</h2><p>View best-selling products by day and month.</p></div>';
                                break;
                            case 'replacements':
                                echo '<div class="card p-4"><h2>Product Replacements</h2><p>Track product replacements.</p></div>';
                                break;
                            case 'refunds':
                                echo '<div class="card p-4"><h2>Refunds</h2><p>View and manage product refunds.</p></div>';
                                break;
                            case 'logout_report':
                                echo '<div class="card p-4"><h2>Cashier Logout Report</h2><p>Track cashier logins and logouts with sales details.</p></div>';
                                break;
                            case 'logout':
                                echo '<div class="card p-4"><h2>Logout</h2><p>You have successfully logged out.</p></div>';
                                break;
                            default:
                                echo '<div class="card p-4"><h2>Page Not Found</h2><p>The page you are looking for does not exist.</p></div>';
                        }
                    } else {
                        $query = "SELECT COUNT(*) AS total_products FROM products";
                        $result = $conn->query($query);
                        $totalProducts = ($result->num_rows > 0) ? $result->fetch_assoc()['total_products'] : 0;
                        echo '<div class="row">
                                <div class="col-md-4 mb-4">
                                    <div class="card p-4 bg-primary text-white">
                                        <h3>Products</h3>
                                        <p><strong>Number: ' . htmlspecialchars($totalProducts) . '</strong></p>
                                        <a href="?page=products" class="text-white">View Details</a>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <div class="card p-4 bg-success text-white">
                                        <h3>Categories</h3>
                                        <p><strong>Number: 15</strong></p>
                                        <a href="?page=categories" class="text-white">View Details</a>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <div class="card p-4 bg-warning text-dark">
                                        <h3>Suppliers</h3>
                                        <p><strong>Number: 10</strong></p>
                                        <a href="?page=suppliers" class="text-dark">View Details</a>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <div class="card p-4 bg-danger text-white">
                                        <h3>Incoming Products</h3>
                                        <p><strong>Number: 50</strong></p>
                                        <a href="?page=incoming" class="text-white">View Details</a>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <div class="card p-4 bg-info text-white">
                                        <h3>Damaged Products</h3>
                                        <p><strong>Number: 5</strong></p>
                                        <a href="?page=damaged" class="text-white">View Details</a>
                                    </div>
                                </div>
                                <div class="col-md-4 mb-4">
                                    <div class="card p-4 bg-secondary text-white">
                                        <h3>Inventory</h3>
                                        <p><strong>Number: 300</strong></p>
                                        <a href="?page=inventory" class="text-white">View Details</a>
                                    </div>
                                </div>
                            </div>';
                    }
                ?>

                 <!-- Modal -->
                <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <!-- Modal Header -->
                            <div class="modal-header">
                                <h5 class="modal-title" id="searchModalLabel">Search Barcode</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <!-- Modal Body -->
                            <div class="modal-body">
                                <form id="barcodeSearchForm">
                                    <div class="mb-3">
                                        <label for="search-barcode" class="form-label">Enter Barcode</label>
                                        <input type="text" class="form-control" id="search-barcode" name="search_barcode" placeholder="Enter barcode..." required>
                                    </div>
                                        <button type="submit" class="btn btn-primary">Search</button>
                                </form>
                                <div id="searchResults"></div>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
       
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    <script src="script.js"></script>
</body>
</html>
