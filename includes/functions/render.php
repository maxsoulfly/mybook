<?php

function renderPost($fullname, $username, $avatar, $date, $content, $latestComment = null)
{
    global $BASE_URL;
    $username = htmlspecialchars($username);
    $fullname = htmlspecialchars($fullname);
    $date = htmlspecialchars($date);
    echo '
        <div class="post">
            <div class="post-header">
                <a href="' . $BASE_URL . '/pages/profile.php?u=' . $username . '">
                    <img src="' . $BASE_URL . $avatar . '" alt="' . $username . '">
                </a>
                <div class="post-user-info">
                    <strong>
                        <a href="' . $BASE_URL . '/pages/profile.php?u=' . $username . '">
                            ' . $fullname . '</strong>
                        </a>
                    <span class="post-date">' . $date . '</span>
                </div>
            </div>
            <p class="post-content">
                ' . nl2br(htmlspecialchars($content, ENT_QUOTES, 'UTF-8')) . '
            </p>
            <div class="post-actions">
                <a href="#">Like</a>
                <a href="#" class="comment-toggle">Comment</a>
            </div>
    ';

    // comment-form
    echo
    '
        <div class="comment-form" style="display: none;">
            <form method="post" action="<?= $BASE_URL ?>/actions/comment-process.php">
                <input type="hidden" name="post_id" value="<?= $postId ?>">
                <textarea name="content" rows="2" placeholder="Write a comment..."></textarea>
                <button type="submit">Comment</button>
            </form>
        </div>
        
    ';
    

    // One latest comment (optional)
    if ($latestComment) {
        renderComment(
            $latestComment['fullname'],
            $latestComment['username'],
            $latestComment['avatar'],
            $latestComment['created_at'],
            $latestComment['content']
        );
        echo '<a href="#">View all comments</a>';
    }

    echo '</div>'; // close .post

}

function renderComment($fullname, $username, $avatar, $date, $content)
{
    global $BASE_URL;

    $username = htmlspecialchars($username);
    $fullname = htmlspecialchars($fullname);
    $date = htmlspecialchars($date);

    echo '
        <div class="comment">
            <a href="' . $BASE_URL . '/pages/profile.php?u=' . $username . '">
                <img class="avatar" src="' . $BASE_URL . $avatar . '" alt="' . $username . '">
            </a>
            <div class="comment-body">
                <div class="comment-wrapper">

                    <div class="comment-header">
                        <a href="' . $BASE_URL . '/pages/profile.php?u=' . $username . '">
                            <strong class="username">' . $fullname . '</strong>
                        </a>
                        <span class="comment-time">' . $date . '</span>
                    </div>
                    <p class="comment-text">
                        ' . nl2br(htmlspecialchars($content, ENT_QUOTES, 'UTF-8')) . '
                    </p>

                </div>
                <div class="comment-actions">
                    <a href="#">Like</a> · <a href="#">Reply</a>
                </div>
            </div>
        </div>
    ';
}

function renderFriend($username, $full_name, $avatar)
{
    global $BASE_URL;

    echo '
        <li>
            <a href="' . $BASE_URL . '/pages/profile.php?u=' . htmlspecialchars($username) . '">
                <img src="' . $BASE_URL . $avatar . '" alt="' . htmlspecialchars($username) . '">
                <div class="friend-name">
                    ' . htmlspecialchars($full_name) . '
                </div>
            </a>
        </li>
    ';
}
