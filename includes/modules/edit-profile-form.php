<?php include_once __DIR__ . '/../functions.php';

$user = getUserByUsername($pdo, $username);


?>


<div class="content-box">

    <form action="<?= $BASE_URL ?>/actions/profile/edit-profile-process.php" method="post" class="mt-4">
        <input type="hidden" name="user_id" value="<?= $user['id'] ?>">
        <div class="mb-3">
            <label for="display_name" class="form-label">Display Name</label>
            <input type="text" class="form-control" id="display_name" name="display_name"
                placeholder="Enter your display name" value="<?= safeOutput($user['display_name']) ?>">
        </div>
        <div class="mb-3">
            <label for="about_me" class="form-label">About Me</label>
            <textarea class="form-control"
                id="about_me" name="about_me" rows="4"
                placeholder="Tell us something about yourself..."><?= safeOutput($user['about_me']) ?></textarea>
        </div>
        <div class="mb-3">
            <label for="location" class="form-label">Location</label>
            <input type="text" class="form-control" id="location" name="location"
                placeholder="Enter your city or location" value="<?= safeOutput($user['location']) ?>">
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
        <a href="profile.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>