<?php




// Database configuration
$host = 'localhost';
$dbname = '4ps_system';
$username = 'root';
$password = '';

try {
  // Establish a database connection
  $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Debugging: Log all POST data


    // Continue with processing
    $id = $_POST['editId'];
    $name = $_POST['editName'];
    $email = $_POST['editEmail'];
    $mobile = $_POST['editMobile'];
    $address = $_POST['editAddress'];
    $family_size = $_POST['editFamilySize'];
    $status = $_POST['editStatus'];
    $archive_action = $_POST['editArchiveStatus'];

    // Determine the archive value based on the action
    $archive = ($archive_action === 'Archive') ? 1 : 0;

    $query = "
        UPDATE user 
        SET name = :name, 
            email = :email, 
            mobile = :mobile, 
            address = :address, 
            family_size = :family_size, 
            status = :status, 
            archive = :archive
        WHERE id_number = :id
    ";

    $stmt = $pdo->prepare($query);
    $stmt->execute([
      ':name' => $name,
      ':email' => $email,
      ':mobile' => $mobile,
      ':address' => $address,
      ':family_size' => $family_size,
      ':status' => $status,
      ':archive' => $archive,
      ':id' => $id
    ]);

    header("Location: adminsidemm.php");
    exit();
  }
} catch (PDOException $e) {
  // Handle database connection error
  echo "Error: " . $e->getMessage();
}
