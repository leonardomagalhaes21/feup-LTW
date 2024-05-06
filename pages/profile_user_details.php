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

<form action="/actions/action_edit_profile.php" method="post" enctype="multipart/form-data" onsubmit="return validateProfileEditForm()" id="edit-profile-form" value="<?=$_SESSION['csrf']?>">
    <label>
        Username: <input type="text" id="username" name="username" value="<?=$user->username?>" required>
    </label><br>
    <label>
        New Password: <input type="password" id="password" name="password">
    </label><br>
    <label>
        Confirm Password: <input type="password" id="confirm_password" name="confirm_password">
    </label><br>
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
    <button type="submit">Save changes</button>
</form>




