<?php

class UserRenderer
{
    public static function renderUploadForm(string $baseUrl, int $userId, string $type): string
    {
        $formId = $type . '-upload-form';

        return '
            <form id="' . $formId . '" action="' . $baseUrl . '/actions/profile/upload-image-process.php" method="post" class="upload-form mt-4" enctype="multipart/form-data">
                <div class="upload-fields">
                    <input type="hidden" name="user_id" value="' . $userId . '">
                    <input type="hidden" name="type" value="' . $type . '">
                    <input type="file" name="' . $type . '" id="' . $type . '">
                    <button class="button primary">Upload</button>
                    <button class="button transparent" type="button" onclick="document.getElementById(\'' . $formId . '\').style.display=\'none\';">X</button>
                </div>
            </form>';
    }
}
