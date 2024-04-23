<?php
    declare(strict_types = 1);

    require_once(__DIR__ . '/../utils/session.php');
    $session = new Session();

    require_once (__DIR__ . '/../database/connection.db.php');
    require_once (__DIR__ . '/../database/users.class.php');
    $db = getDatabaseConnection();

    $user = User::getUserById($db, $_SESSION['id']);

?>

<?php
    if (isset($_SESSION['message'])) {
        echo "<p>{$_SESSION['message']}</p>";
        unset($_SESSION['message']);
    }
?>

<form action="/actions/action_edit_profile.php" method="post" enctype="multipart/form-data" onsubmit="return validateForm()" id="edit-profile-form">
    <label>
        Name: <input type="text" id="name" name="name" value="<?=$user->name?>" required>
    </label><br>
    <label>
        Email: <input type="email" id="email" name="email" value="<?=$user->email?>" required>
    </label><br>
    <label>
        Profile Picture: <input type="file" id="main_image" name="main_image" onchange="previewMainImage(event)">
    </label>
    <img id="main_image_preview" src="#" alt="Profile Image Preview">
    <input type="submit" name="submit" value="Save Changes">
</form>




