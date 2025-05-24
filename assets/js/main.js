const MyBookUI = {
    init() {
        this.setupCommentToggle();
        this.setupAutoResizeTextareas();
        this.setupAvatarEditForm();
        this.setupCoverEditForm();
        this.setupNotificationToggle();
        this.setupCommentLikes();
        this.setupPostLikes();
    },

    // Function to handle comment toggle (Main and Reply)
    setupCommentToggle() {
        // Main Comment Form Toggle
        document.querySelectorAll('.comment-toggle').forEach((link) => {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                MyBookUI.toggleMainCommentForm(this); // Pass the clicked link
            });
        });

        // Reply Form Toggle
        document.querySelectorAll('.reply-toggle').forEach((link) => {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                MyBookUI.toggleReplyForm(this);
            });
        });
    },

    // Function to toggle the main comment form
    toggleMainCommentForm(link) {
        const parent = link.closest('.post'); // Scope to the specific post
        const form = parent.querySelector('.comment-form');
        if (form) {
            form.classList.toggle('show');
            const textarea = form.querySelector('textarea');
            if (textarea) textarea.focus();
        }
    },

    // Function to toggle the reply form
    toggleReplyForm(link) {
        const parent = link.closest('.comment');
        const form = parent.querySelector('.reply-form');
        if (form) {
            form.classList.toggle('show');
            const textarea = form.querySelector('textarea');
            if (textarea) textarea.focus();
        }
    },

    // Function to set up auto-resizing textareas
    setupAutoResizeTextareas() {
        document
            .querySelectorAll('.comment-form textarea, .reply-form textarea')
            .forEach((textarea) => {
                textarea.addEventListener('input', MyBookUI.autoResizeTextarea);
                textarea.addEventListener('focus', MyBookUI.autoResizeTextarea);
                textarea.addEventListener('blur', MyBookUI.resetTextarea);
                textarea.style.height = '1.5em';
            });
    },

    // Function to auto-resize textareas
    autoResizeTextarea() {
        this.style.height = 'auto';
        this.style.height = `${Math.min(this.scrollHeight, 150)}px`;
    },

    // Function to reset textarea height on blur
    resetTextarea() {
        if (this.value.trim() === '') {
            this.style.height = '3em';
        }
    },

    submitLike(postId) {
        const form = document.getElementById(`likeForm-${postId}`);
        if (form) {
            form.submit();
        } else {
            console.error('Like form not found for post ID:', postId);
        }
    },

    submitCommentLike(commentID) {
        const form = document.getElementById(`likeForm-${commentID}`);
        if (form) {
            form.submit();
        } else {
            console.error('Like form not found for comment ID:', commentID);
        }
    },

    setupAvatarEditForm() {
        const avatarForm = document.getElementById('avatar-upload-form');
        if (!avatarForm) return;
        avatarForm.style.display = 'none';
        const editAvatarBtn = document.getElementById('edit-avatar');
        if (editAvatarBtn) {
            editAvatarBtn.addEventListener('click', function (e) {
                e.preventDefault();
                avatarForm.style.display = 'block';
            });
        }
        const closeBtn = avatarForm.querySelector('.button.transparent');
        if (closeBtn) {
            closeBtn.addEventListener('click', function (e) {
                e.preventDefault();
                avatarForm.style.display = 'none';
            });
        }
    },

    setupCoverEditForm() {
        const coverForm = document.getElementById('cover-upload-form');
        if (!coverForm) return;
        coverForm.style.display = 'none';
        const editCoverBtn = document.getElementById('edit-cover');
        if (editCoverBtn) {
            editCoverBtn.addEventListener('click', function (e) {
                e.preventDefault();
                coverForm.style.display = 'block';
            });
        }
        const closeBtn = coverForm.querySelector('.button.transparent');
        if (closeBtn) {
            closeBtn.addEventListener('click', function (e) {
                e.preventDefault();
                coverForm.style.display = 'none';
            });
        }
    },

    setupNotificationToggle() {
        const toggleBtn = document.getElementById('notification-toggle');
        const dropdown = document.getElementById('notification-dropdown');

        if (!toggleBtn || !dropdown) return;

        toggleBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            dropdown.classList.toggle('hidden');
        });

        // Close dropdown on outside click
        document.addEventListener('click', () => {
            if (!dropdown.classList.contains('hidden')) {
                dropdown.classList.add('hidden');
            }
        });
    },

    setupCommentLikes() {
        document.querySelectorAll('.comment-like').forEach((link) => {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                const commentId = this.dataset.commentId;
                MyBookUI.submitCommentLike(commentId);
            });
        });
    },

    setupPostLikes() {
        document.querySelectorAll('.post-like').forEach((link) => {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                const postId = this.dataset.postId;
                MyBookUI.submitLike(postId);
            });
        });
    },
};

document.addEventListener('DOMContentLoaded', () => {
    MyBookUI.init();
});
