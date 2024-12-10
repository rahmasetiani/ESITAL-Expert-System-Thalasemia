 <?php
 require '../database/koneksi.php';
 
 $email = $_SESSION['email'];
 $query = "SELECT namalengkap, role FROM user WHERE email = '$email'";
 $result = mysqli_query($conn, $query);
 
 if ($row = mysqli_fetch_assoc($result)) {
     $_SESSION['namalengkap'] = $row['namalengkap'];
     $_SESSION['role'] = $row['role'];
 } else {
     echo "User not found!";
     exit();
 }
 // Define pagination variables
 $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10; // Default limit
 $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
 $offset = ($page - 1) * $limit;
 
 // Search query
 $searchQuery = isset($_GET['search']) ? trim($_GET['search']) : '';
 
 // Build the query based on the search query
 $searchCondition = !empty($searchQuery) ? "WHERE namapenyakit LIKE '%" . mysqli_real_escape_string($conn, $searchQuery) . "%'" : '';
 $query = "SELECT * FROM penyakit $searchCondition LIMIT $limit OFFSET $offset";
 
 // Execute the query and check for errors
 $penyakitResult = mysqli_query($conn, $query);
 if (!$penyakitResult) {
     die("Query failed: " . mysqli_error($conn));
 }
 
 // Fetch total rows for pagination
 $totalQuery = "SELECT COUNT(*) AS total FROM penyakit $searchCondition";
 $totalResult = mysqli_query($conn, $totalQuery);
 $totalRow = mysqli_fetch_assoc($totalResult);
 $totalPages = ceil($totalRow['total'] / $limit);
?>
