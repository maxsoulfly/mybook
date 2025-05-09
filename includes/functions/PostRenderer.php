<?php

class PostRenderer
{
    private $postId;
    private $display_name;
    private $username;
    private $avatar;
    private $date;
    private $content;
    private $latestComment;
    private $baseUrl;

    public function __construct($postId, $display_name, $username, $avatar, $date, $content, $baseUrl, $latestComment = null)
    {
        $this->postId = $postId;
        $this->display_name = htmlspecialchars($display_name);
        $this->username = htmlspecialchars($username);
        $this->avatar = $avatar;
        $this->date = $date;
        $this->content = htmlspecialchars($content, ENT_QUOTES, 'UTF-8');
        $this->latestComment = $latestComment;
        $this->baseUrl = $baseUrl;
    }

    private function renderHeader()
    {
        echo '
        <div class="post-header">
                <a href="' . $this->baseUrl . '/pages/profile.php?u=' . $this->username . '">
                    <img src="' . $this->baseUrl . $this->avatar . '" alt="' . $this->username . '">
                </a>
                <div class="post-user-info">
                    <strong>
                        <a href="' . $this->baseUrl . '/pages/profile.php?u=' . $this->username . '">
                            ' . $this->display_name . '</strong>
                        </a>
                    <span class="post-date">' . $this->date . '</span>
                </div>
            </div>
        ';
    }

    private function renderContent()
    {
        echo '
            <p class="post-content">
            ' . escapeOutput($this->content) . '
            </p>
        ';
    }
    private function renderActions()
    {
        echo '
            <div class="post-actions">
                <a href="#">Like</a>
                <a href="#" class="comment-toggle">Comment</a>
            </div>
        ';
    }

    private function renderCommentForm()
    {
        // Make sure you have a session started
        if (!isset($_SESSION['user_id'])) {
            echo '<p>You must be logged in to comment.</p>';
            return;
        }

        $loggedInUserId = $_SESSION['user_id'];

        echo
        '
            <div class="comment-form">
                <form method="post" action="' . $this->baseUrl . '/actions/comment-process.php">
                    <input type="hidden" name="post_id" value="' . $this->postId . '">
                    <input type="hidden" name="user_id" value="' . $loggedInUserId . '">
                    <div class="comment-input-row">
                        <textarea name="content" placeholder="Write a comment..." ></textarea>
                        <button class="info" type="submit">Comment</button>
                    </div>
                </form>
            </div>
        ';
    }

    private function renderComment($comment)
    {
        echo '
        <div class="comment">
            <a href="' . $this->baseUrl . '/pages/profile.php?u=' . $comment['username'] . '">
                <img class="avatar" src="' . $this->baseUrl . $comment['avatar'] . '" alt="' . $comment['username'] . '">
            </a>
            <div class="comment-body">
                <div class="comment-wrapper">

                    <div class="comment-header">
                        <a href="' . $this->baseUrl . '/pages/profile.php?u=' . $comment['username'] . '">
                            <strong class="username">' . $comment['display_name'] . '</strong>
                        </a>
                        <span class="comment-time">' . $comment['created_at'] . '</span>
                    </div>
                    <p class="comment-text">
                        ' . escapeOutput($comment['content'])  . '
                    </p>

                </div>
                <div class="comment-actions">
                    <a href="#">Like</a> · <a href="#">Reply</a>
                </div>
            </div>
        </div>
        ';
    }

    private function renderViewAllCommentsLink()
    {
        echo '
        <div class="view-all-comments">
            <a href="' . $this->baseUrl . '/pages/post.php?id=' . $this->postId . '">View all comments</a>
        </div>
        ';
    }

    private function renderComments()
    {
        if ($this->latestComment) {
            $this->renderComment($this->latestComment);
            $this->renderViewAllCommentsLink();
        }
    }


    public function render()
    {
        echo '<div class="post">';
        $this->renderHeader();
        $this->renderContent();
        $this->renderActions();
        $this->renderComments();
        $this->renderCommentForm();
        echo '</div>';
    }
}
