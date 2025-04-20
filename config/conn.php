<?php
session_start();
error_reporting( E_ALL );
ini_set('display_errors', '1');
$host     = "localhost";         // or your host IP
$db_user  = "root";              // your DB username
$db_pass  = "";                  // your DB password
$db_name  = "furni_nest_db";     // your selected DB

// Create connection
$conn = mysqli_connect($host, $db_user, $db_pass, $db_name);

// Check connection
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}else{

    // echo "Connected successfully to furni_nest_db";
}

// Set charset (optional but recommended)
mysqli_set_charset($conn, "utf8mb4");

// Optional: For debugging connection

/**
 * Function to close the DB connection.
 */
function closeConnection($conn) {
    if ($conn) {
        mysqli_close($conn);
        // echo "Connection closed successfully."; // Optional for debug
    }
}

// function createDropdown($column_name, $table, $id_field, $name_field, $condition = '')
// {
//     global $conn;
//     $where = !empty($condition) ? "WHERE $condition" : "";
//     $query = "SELECT $id_field, $name_field FROM $table $where";

//     $result = mysqli_query($conn, $query);

//     $output = '<select class="form-control" name="' . $column_name . '" required>';
//     $output .= '<option value="">-- Select --</option>';

//     if ($result && mysqli_num_rows($result) > 0) {
//         while ($row = mysqli_fetch_assoc($result)) {
//             $output .= '<option value="' . $row[$id_field] . '">' . $row[$name_field] . '</option>';
//         }
//     }

//     $output .= '</select>';

//     return $output;
// }

function createDropdown($selectName, $table, $valueField, $displayField, $selectedValue = '') {
    global $conn;
    $query = "SELECT * FROM $table";
    $result = mysqli_query($conn, $query);
    $dropdown = "<select name='$selectName' class='form-control'>";
    while ($row = mysqli_fetch_assoc($result)) {
        $selected = ($row[$valueField] == $selectedValue) ? "selected" : "";
        $dropdown .= "<option value='" . $row[$valueField] . "' $selected>" . $row[$displayField] . "</option>";
    }
    $dropdown .= "</select>";
    return $dropdown;
}

// $password = password_hash("Mitesh@2025", PASSWORD_DEFAULT);
// mysqli_query($conn, "INSERT INTO users (first_name, last_name,display_name,email,password,phone,role) VALUES ('Mitesh','Prajapati','Mitesh','info@codemastermitesh.com','$password','9033889873','admin')");

?>
