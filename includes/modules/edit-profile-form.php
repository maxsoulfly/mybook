<?php include_once __DIR__ . '/../functions.php'; ?>


<div class="content-box">

    <form action="edit-profile.php" method="post" class="mt-4">
        <div class="mb-3">
            <label for="about_me" class="form-label">About Me</label>
            <textarea class="form-control" id="about_me" name="about_me" rows="4" placeholder="Tell us something about yourself..."></textarea>
        </div>
        <div class="mb-3">
            <label for="location" class="form-label">Location</label>
            <input type="text" class="form-control" id="location" name="location" placeholder="Enter your city or location">
        </div>
        <button type="submit" class="btn btn-primary">Save Changes</button>
        <a href="profile.php" class="btn btn-secondary">Cancel</a>
    </form>
</div>