<?php

class PostRenderer
{
    private $postId;
    private $fullname;
    private $username;
    private $avatar;
    private $date;
    private $content;
    private $latestComment;
    private $baseUrl;

    public function __construct($postId, $fullname, $username, $avatar, $date, $content, $latestComment = null, $baseUrl)
    {
        $this->postId = $postId;
        $this->fullname = htmlspecialchars($fullname);
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
                            ' . $this->fullname . '</strong>
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
                ' . nl2br(htmlspecialchars($this->content, ENT_QUOTES, 'UTF-8')) . '
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
        echo
        '
            <div class="comment-form">
                <form method="post" action="' . $this->baseUrl . '/actions/comment-process.php">
                    <input type="hidden" name="post_id" value="' . $this->postId . '">
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
                            <strong class="username">' . $comment['fullname'] . '</strong>
                        </a>
                        <span class="comment-time">' . $comment['created_at'] . '</span>
                    </div>
                    <p class="comment-text">
                        ' . nl2br(htmlspecialchars($comment['content'], ENT_QUOTES, 'UTF-8')) . '
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
