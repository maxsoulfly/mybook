<?php

class PostRenderer
{
    private $postId;
    private $pdo;
    private $postManager;
    private $baseUrl;
    private $post;
    private $comments;
    private $latestComments;
    private $replies;
    private $commentCount;
    private $likeCount;

    public function __construct($postId, $pdo)
    {

        global $BASE_URL;
        $this->postId = $postId;
        $this->baseUrl = $BASE_URL;
        $this->pdo = $pdo;
        $this->postManager = new PostManager($pdo);

        $this->loadPostData();
    }

    private function loadPostData()
    {
        $this->post = $this->postManager->fetchPost($this->postId);
        if (!$this->post) {
            die('Post not found.');
        }

        $this->comments = $this->postManager->fetchComments($this->postId);
        $this->latestComments = $this->postManager->fetchRecentComments($this->pdo, $this->postId, numComments: 2);
        $this->commentCount = $this->postManager->countComments($this->postId);
        // $this->replies = $this->postManager->fetchReplies($this->postId);
        $this->likeCount = $this->postManager->countLikes($this->postId); // future system
    }

    private function renderHeader()
    {
        echo '
        <div class="post-header">
            <a href="' . $this->baseUrl . '/pages/profile.php?u=' . $this->post['username'] . '">
                <img src="' . $this->baseUrl . $this->post['avatar'] . '" alt="' . $this->post['username'] . '">
            </a>
            <div class="post-user-info">
                <strong>
                    <a href="' . $this->baseUrl . '/pages/profile.php?u=' . $this->post['username'] . '">
                        ' . $this->post['display_name'] . '
                    </a> 
        ';

        if (isset($this->post['recipient_username'])) {
            echo '
            
                &nbsp;&nbsp;->&nbsp;&nbsp;
                    <a href="' . $this->baseUrl . '/pages/profile.php?u=' . $this->post['recipient_username'] . '">
                        ' . $this->post['recipient_name'] . '
                    </a> 
            ';
        }
        echo '</strong>';

        echo '
                <span class="post-date">' . $this->post['created_at'] . '</span>
            </div>
        </div>
        ';
    }

    private function renderContent()
    {
        echo '
            <p class="post-content">
            ' . escapeOutput($this->post['content']) . '
            </p>
        ';
    }


    private function renderCommentActions()
    {
        echo '<div class="post-actions">';

        $this->renderLikeForm();

        echo '<a href="#" class="comment-toggle">Comment</a>';
        echo '</div>';
    }

    private function renderLikeForm()
    {
        $loggedInUserId = $_SESSION['user_id'];
        $postId = (int) $this->postId;

        echo '
        <div class="post-like">
            <a href="#" onclick="submitLike(' . $postId . '); return false;" class="like-link">';

        $existingLike = $this->postManager->existingLike($postId, $loggedInUserId);
        echo $existingLike ? 'Unlike' : 'Like';

        echo '</a>
            <form id="likeForm-' . $postId . '" action="' . $this->baseUrl . '/actions/like-process.php" method="POST" style="display: none;">
                <input type="hidden" name="post_id" value="' . $postId . '">
                <input type="hidden" name="user_id" value="' . $loggedInUserId . '">
            </form>
        </div>
    ';
    }
    private function renderCommentForm($parentId = null)
    {
        // Make sure you have a session started
        if (!isset($_SESSION['user_id'])) {
            echo '<p>You must be logged in to comment.</p>';
            return;
        }

        $loggedInUserId = $_SESSION['user_id'];

        if (!$parentId) {
            echo '<div class="comment-form hidden">';
        } else {
            echo '<div class="reply-form hidden">';
        }
        echo '
            <form method="post" action="' . $this->baseUrl . '/actions/comment-process.php">
                <input type="hidden" name="post_id" value="' . $this->postId . '">
                <input type="hidden" name="user_id" value="' . $loggedInUserId . '">';

        // Include parent_id only if it's a reply
        if ($parentId) {
            echo '<input type="hidden" name="parent_id" value="' . $parentId . '">';
        }

        echo '
                <div class="comment-input-row">
                    <textarea name="content" placeholder="Write a comment..." ></textarea>
                    <button class="info" type="submit">Comment</button>
                </div>
            </form>
        </div>
    ';
    }

    private function renderCommentAvatar($comment)
    {
        echo '
            <div class="comment-avatar">
                <a href="' . $this->baseUrl . '/pages/profile.php?u=' . $comment['username'] . '">
                    <img class="avatar" src="' . $this->baseUrl . $comment['avatar'] . '" alt="' . $comment['username'] . '">
                </a>
            </div>
        ';
    }
    private function renderCommentHeader($comment)
    {
        echo '
            <div class="comment-header">
                <a href="' . $this->baseUrl . '/pages/profile.php?u=' . $comment['username'] . '">
                    <strong class="username">' . $comment['display_name'] . '</strong>
                </a>
                <span class="comment-time">' . $comment['created_at'] . '</span>
            </div>
        ';
    }
    private function renderCommentText($comment)
    {
        echo '
            <p class="comment-text">
                ' . escapeOutput($comment['content'])  . '
            </p>
        ';
    }
    private function renderReplyActions()
    {
        echo '
            <div class="comment-actions">
                <a href="#">Like</a> · <a href="#" class="reply-toggle">Reply</a>
            </div>
        ';
    }

    private function renderComment($comment, $showReplies)
    {
        echo '<div class="comment">';
        $this->renderCommentAvatar($comment);
        echo '<div class="comment-body"><div class="comment-wrapper">';

        $this->renderCommentHeader($comment);
        $this->renderCommentText($comment);
        echo '</div>';
        $this->renderReplyActions();

        if ($showReplies) {
            $this->renderAllReplies($comment);
        }

        $this->renderCommentForm($comment['id']);
        echo '</div>';
        echo '</div>';
    }
    private function renderReply($reply)
    {
        echo '<div class="reply">';
        $this->renderCommentAvatar($reply);
        echo '<div class="comment-body"><div class="comment-wrapper">';

        $this->renderCommentHeader($reply);
        $this->renderCommentText($reply);
        echo '</div>';
        $this->renderReplyActions();
        echo '</div>';
        echo '</div>';
    }

    public function renderAllReplies(array $comment)
    {
        $replies = $this->postManager->fetchReplies($comment['id']);
        foreach ($replies as $reply) {
            $this->renderReply($reply);
        }
    }

    private function renderViewAllCommentsLink()
    {
        echo '
        <div class="view-all-comments">
            <a href="' . $this->baseUrl . '/pages/post.php?id=' . $this->postId . '">View all comments</a>
        </div>
        ';
    }

    private function renderCommentsCountLink()
    {

        $commentCount = $this->commentCount;
        if ($commentCount > 0) {
            echo '<div class="comments-count">';
            echo '<a href="' . $this->baseUrl . '/pages/post.php?id=' . $this->postId . '">';
            echo $commentCount . ' comments';
            echo '</a>';
            echo '</div>';
        }
    }

    private function renderCommentsLikesLink()
    {
        if ($this->likeCount > 0) {
            echo '<div class="likes">';
            if ($this->likeCount > 1) {
                echo $this->likeCount . ' people liked this';
            } else {
                echo $this->likeCount . ' person liked this';
            }
            echo '</div>';
        }
    }

    public function renderAllComments(array $comments)
    {
        foreach ($comments as $comment) {
            $this->renderComment($comment, showReplies: true);
        }
    }

    private function renderLikesAndComments()
    {
        echo '<div class="post-likes-comments">';

        $this->renderCommentsLikesLink();
        $this->renderCommentsCountLink();

        echo '</div>';
    }

    private function renderComments($showReplies, $mode = 'full'): void
    {
        $commentsToRender = [];

        if ($mode === 'full') {
            $commentsToRender = $this->comments;
        } elseif ($mode === 'timeline' || $mode === 'profile') {
            $commentsToRender = $this->latestComments;
        }

        // Render the chosen comments
        if (!empty($commentsToRender)) {
            foreach ($commentsToRender as $comment) {
                $this->renderComment($comment, $showReplies);
            }
        }
    }



    public function render($showReplies = true, $mode = "full")
    {
        echo '<div class="post">';
        $this->renderHeader();
        $this->renderContent();
        $this->renderLikesAndComments();
        $this->renderCommentActions();
        $this->renderCommentForm();
        $this->renderComments($showReplies, $mode);
        echo '</div>';
    }
}
