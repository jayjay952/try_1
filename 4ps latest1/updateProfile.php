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
    print_r($_POST);

    // Continue with processing
    $id = $_POST['editId'];
    $name = $_POST['editName'];
    $email = $_POST['editEmail'];
    $mobile = $_POST['editMobile'];
    $address = $_POST['editAddress'];
    $family_size = $_POST['editFamilySize'];

    $query = "
    UPDATE user 
    SET name = :name, 
        email = :email, 
        mobile = :mobile, 
        address = :address, 
        family_size = :family_size
    WHERE id = :id
";

    $stmt = $pdo->prepare($query);
$stmt->execute([
    ':name' => $name,
    ':email' => $email,
    ':mobile' => $mobile,
    ':address' => $address,
    ':family_size' => $family_size,
    ':id' => $id,
]);
    
    
    var_dump($stmt);
    header('Location: profile.php');
    exit();
    
  }
} catch (PDOException $e) {
  // Handle database connection error
  echo "Error: " . $e->getMessage();
  var_dump($e);
}
