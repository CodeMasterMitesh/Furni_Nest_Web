<?php 

header('Content-Type: application/json');
include('../../../config/conn.php');

try {
    // Get pagination and sorting parameters from Tabulator
    $page = isset($_POST['page']) ? intval($_POST['page']) : 1;
    $size = isset($_POST['size']) ? intval($_POST['size']) : 10;
    $sortField = isset($_POST['sort'][0]['field']) ? $_POST['sort'][0]['field'] : 'id';
    $sortDir = isset($_POST['sort'][0]['dir']) ? $_POST['sort'][0]['dir'] : 'desc';

    // Validate sort direction
    $sortDir = strtoupper($sortDir) === 'ASC' ? 'ASC' : 'DESC';

    // Whitelist of valid sort fields for security
    $validSortFields = ['id', 'company_name', 'address_line', 'city', 'country', 'phone', 'email', 'website', 'status', 'created_at'];
    if (!in_array($sortField, $validSortFields)) {
        $sortField = 'id';
    }

    // Get filter parameters
    $filters = [];
    if (isset($_POST['filter'])) {
        foreach ($_POST['filter'] as $filter) {
            if (isset($filter['field'], $filter['type'], $filter['value'])) {
                $filters[] = [
                    'field' => $filter['field'],
                    'type' => $filter['type'],
                    'value' => $filter['value']
                ];
            }
        }
    }

    // Build base query
    $query = "SELECT SQL_CALC_FOUND_ROWS * FROM company_master";
    $countQuery = "SELECT COUNT(*) FROM company_master";
    $whereClauses = [];
    $params = [];
    $types = '';

    // Apply filters
    foreach ($filters as $filter) {
        $field = $filter['field'];
        $value = $filter['value'];
        $type = $filter['type'];

        // Validate field name
        if (!in_array($field, $validSortFields)) {
            continue;
        }

        $paramName = "param_" . count($params);
        
        switch ($type) {
            case '=':
                $whereClauses[] = "$field = ?";
                $params[] = $value;
                $types .= is_int($value) ? 'i' : 's';
                break;
            case 'like':
                $whereClauses[] = "$field LIKE ?";
                $params[] = "%$value%";
                $types .= 's';
                break;
            case '>=':
                $whereClauses[] = "$field >= ?";
                $params[] = $value;
                $types .= is_int($value) ? 'i' : 's';
                break;
            case '<=':
                $whereClauses[] = "$field <= ?";
                $params[] = $value;
                $types .= is_int($value) ? 'i' : 's';
                break;
        }
    }

    // Add WHERE clause if filters exist
    if (!empty($whereClauses)) {
        $where = " WHERE " . implode(" AND ", $whereClauses);
        $query .= $where;
        $countQuery .= $where;
    }

    // Add sorting
    $query .= " ORDER BY $sortField $sortDir";

    // Add pagination
    $offset = ($page - 1) * $size;
    $query .= " LIMIT ?, ?";
    $params[] = $offset;
    $params[] = $size;
    $types .= 'ii';

    // Prepare and execute query
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        throw new Exception("Prepare failed: " . $conn->error);
    }

    // Bind parameters if they exist
    if (!empty($params)) {
        $stmt->bind_param($types, ...$params);
    }

    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_all(MYSQLI_ASSOC);

    // Get total count
    $totalStmt = $conn->prepare($countQuery);
    if ($totalStmt === false) {
        throw new Exception("Prepare failed: " . $conn->error);
    }

    // For count query, we need to exclude the LIMIT parameters
    $countParams = array_slice($params, 0, count($params) - 2);
    $countTypes = substr($types, 0, -2);

    if (!empty($countParams)) {
        $totalStmt->bind_param($countTypes, ...$countParams);
    }

    $totalStmt->execute();
    $totalResult = $totalStmt->get_result();
    $total = $totalResult->fetch_row()[0];

    // Calculate last page
    $last_page = ceil($total / $size);

    // Format dates for better display
    foreach ($data as &$row) {
        if (isset($row['created_at'])) {
            $date = new DateTime($row['created_at']);
            $row['created_at'] = $date->format('Y-m-d H:i:s');
        }
    }

    // Return JSON response in Tabulator format
    echo json_encode([
        'last_page' => $last_page,
        'data' => $data,
    ]);

} catch(Exception $e) {
    // Log error for debugging
    error_log("Database error: " . $e->getMessage());
    
    // Return error response
    http_response_code(500);
    echo json_encode([
        'error' => 'Database error',
        'message' => $e->getMessage()
    ]);
} finally {
    // Close connection
    if (isset($stmt)) $stmt->close();
    if (isset($totalStmt)) $totalStmt->close();
    $conn->close();
}
?>