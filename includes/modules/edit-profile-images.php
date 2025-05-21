<?php include_once __DIR__ . '/../functions.php';
$UserManager = new UserManager($pdo);
$user = $UserManager->getUserByUsername($username);

?>

<div class="content-box">
    <div class="edit-header">

        <h3>Profile picture</h3>
        <p><a id="edit-avatar" href="#" onclick="document.getElementById('avatar-upload-form').style.display='block'; return false;">Edit</a></p>
        <script>

        </script>
    </div>

    <div class="edit-body">
        <div class="avatar">
            <img src="<?= $profilePicUrl ?>" alt="Profile" class="avatar-larger avatar-larger shadow border">
        </div>
        <?= UserRenderer::renderUploadForm($BASE_URL, $user['id'], "avatar") ?>
    </div>

</div>
<div class="content-box">

    <div class="edit-header">
        <h3>Cover picture</h3>
        <p><a id="edit-avatar" href="#" onclick="document.getElementById('cover-upload-form').style.display='block'; return false;">Edit</a></p>
    </div>

    <div class="edit-body">
        <div class="profile-cover-display">
            <img src="<?= $coverImage ?>" alt="Cover" class="shadow border">
        </div>

        <?= UserRenderer::renderUploadForm($BASE_URL, $user['id'], "cover") ?>
    </div>
</div>