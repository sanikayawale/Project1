<?php
include 'dbconnect.php';

if (!$conn) {
    die('Database connection failed: '. mysqli_connect_error());
}

$inputData = json_decode(file_get_contents('php://input'), true);

$filters = [
  'categories' => isset($inputData['categories'])? $inputData['categories'] : [],
  'brands' => isset($inputData['brands'])? $inputData['brands'] : [],
];

function fetchProducts($conn, $filters) {
    // Construct the base query
    $query = 'SELECT p.product_id, p.agency_id, a.name AS agency_name, p.model_brand, p.image, p.category, p.rental_cost FROM products p';
    $conditions = [];
    $params = [];
    
    // Add the user table to the query
    $query .= ' INNER JOIN agency a ON p.agency_id = a.agency_id';
    
    // Handle categories filter
    if (!empty($filters['categories'])) {
        $categoriesPlaceholders = implode(',', array_fill(0, count($filters['categories']), '?'));
        $conditions[] = "p.category IN ($categoriesPlaceholders)";
        $params = array_merge($params, $filters['categories']);
    }

    // Handle brands filter
    if (!empty($filters['brands'])) {
        $brandsPlaceholders = implode(',', array_fill(0, count($filters['brands']), '?'));
        $conditions[] = "p.model_brand IN ($brandsPlaceholders)";
        $params = array_merge($params, $filters['brands']);
    }

    // Add conditions to query
    if (!empty($conditions)) {
        $query.= ' WHERE '. implode(' AND ', $conditions);
    }

    // Prepare the statement
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        die('Error preparing statement: '. $conn->error);
    }

    // Bind parameters if any
    if (!empty($params)) {
        $types = str_repeat('s', count($params)); // Assuming all parameters are strings
        $stmt->bind_param($types,...$params);
    }

    // Execute the statement
    $stmt->execute();
    $result = $stmt->get_result();

    // Error checking
    if ($stmt->errno) {
        die('Query execution error: '. $stmt->error);
    }

    // Fetch products
    $products = $result->fetch_all(MYSQLI_ASSOC);

    // Convert image data to base64
    foreach ($products as &$product) {
        $product['image'] = base64_encode($product['image']);
       // unset($product['user_id']); // Remove the user_id field
    }

    // Close the statement
    $stmt->close();

    return $products;
}

// Fetch products
$products = fetchProducts($conn, $filters);

// Set the content type header for JSON
header('Content-Type: application/json');

// Output the products as JSON
echo json_encode($products);
?>