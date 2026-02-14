<?php 
include '../login/session.php';
require_once "../connection.php";

$userEmail = $_SESSION['email'] ?? null;

if (!$userEmail) {
    die("Error: login to continue");
}

$stmt = $conn->prepare("SELECT role FROM users WHERE email = ?");
$stmt->bind_param("s", $userEmail);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $userRole = strtolower($row['role']); 
} else {
    $userRole = 'user';
}
$stmt->close();
 ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create pin</title>
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>
     <?php require '../includes/sidebar.php';?>
  <div class="main-container">
    <?php require '../includes/topnav.php';?>
    <div class="main-content">
        
  <h1 class="title">Pin create</h1>
  <?php
      $categories = [];
      $catResult = $conn->query("SELECT id, name FROM categories ORDER BY name");
      if ($catResult) {
          while ($row = $catResult->fetch_assoc()) {
              $categories[] = $row;
          }
      }
      ?>
<form
  action="../api/create-post.php"
  method="POST"
  enctype="multipart/form-data"
  class="card"
>

  <!-- LEFT: MEDIA -->
  <div class="media-upload">

    <!-- UPLOAD FILE -->
    <label class="media-box">
      <input
        type="file"
        name="media_file"
        accept="image/*"
        hidden
      />
      <span class="media-text">Upload image</span>
    </label>
   <div id="file-preview" style="margin-top:10px;"></div>

    <div class="or">OR</div>

    <!-- IMAGE URL -->
    <input
      type="url"
      name="media_url"
      class="input"
      placeholder="Paste image URL"
    />

  </div>

  <!-- RIGHT: FORM -->
  <div class="form">

    <input
      type="text"
      name="name"
      placeholder="Name"
      class="input"
      required
    />

    <textarea
      name="description"
      placeholder="Description"
      class="textarea"
    ></textarea>

    <select name="category_id" class="input" required>
        <option value="">-- Select Category --</option>
        <?php foreach ($categories as $category): ?>
            <option value="<?php echo $category['id']; ?>">
                <?php echo htmlspecialchars($category['name']); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <input
      type="text"
      name="tags"
      placeholder="Tags (comma separated)"
      class="input"
    />

    <button type="submit" class="create-btn">
      Create
    </button>

  </div>

</form>
    </div>
    </div>
    </div></div>
<div class="alert-box" id="alertBox">
  This feature is temporarily disabled for regular users.
</div>

<script>
const userRole = "<?php echo htmlspecialchars($userRole); ?>";

document.querySelector('form').addEventListener('submit', function (event) {
  if (userRole !== 'admin') {
    event.preventDefault();

    const alertBox = document.getElementById('alertBox');
    alertBox.classList.add('show');

    setTimeout(() => {
      alertBox.classList.remove('show');
    }, 3000);
  }
});
</script>
</body>
<script src="../assets/js/gallery_grid.js"></script>
<script src="../assets/js/img_predisplay.js"></script>
</html>