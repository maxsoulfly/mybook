<?php include_once __DIR__ . '/../functions.php';
$UserManager = new UserManager($pdo);
$user = $UserManager->getUserByUsername($username);

?>

<div class="content-box">
    <div class="edit-header">

        <h3>Profile picture</h3>
        <p><a href="">Edit</a></p>
    </div>

    <div class="edit-body">
        <div class="avatar">
            <img src="<?= $profilePicUrl ?>" alt="Profile" class="avatar-larger avatar-larger shadow border">
        </div>
        <form action="<?= $BASE_URL ?>/actions/profile/upload-image.php" method="post" class="upload-form mt-4">
            <div class="upload-fields">
                <input type="file" name="avatar" id="avatar">
                <button class="button primary">Upload</button>
                <button class="button transparent">X</button>
            </div>
        </form>
    </div>

</div>
<div class="content-box">

    <div class="edit-header">

        <h3>Cover picture</h3>
        <p><a href="">Edit</a></p>
    </div>

    <div class="profile-cover-display">
        <img src="<?= $coverImage ?>" alt="Cover" class="shadow border">
    </div>
</div>