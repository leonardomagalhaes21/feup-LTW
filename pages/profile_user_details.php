<?php
declare(strict_types = 1);

require_once(__DIR__ . '/../utils/session.php');
$session = new Session();

require_once (__DIR__ . '/../database/connection.db.php');
require_once (__DIR__ . '/../database/users.class.php');
$db = getDatabaseConnection();

$user = User::getUserById($db, $_SESSION['id']);

?>

<form id="edit-profile-form" action="/actions/action_edit_profile.php" method="post" enctype="multipart/form-data" onsubmit="return validateForm()">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" value="<?=$user->name?>" required><br>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" value="<?=$user->email?>" required><br>

    <label for="profile-picture">Profile Picture:</label>
    <input type="file" id="profile-picture" name="profile_picture"><br>

    <input type="submit" name="submit" value="Save Changes">
</form>




