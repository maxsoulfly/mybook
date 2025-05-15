document.addEventListener('DOMContentLoaded', () => {
    setupCommentToggle();
    setupAutoResizeTextareas();
});

// Function to handle comment toggle (Main and Reply)
function setupCommentToggle() {
    // Main Comment Form Toggle
    document.querySelectorAll('.comment-toggle').forEach((link) => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            toggleMainCommentForm(this); // Pass the clicked link
        });
    });

    // Reply Form Toggle
    document.querySelectorAll('.reply-toggle').forEach((link) => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            toggleReplyForm(this);
        });
    });
}

// Function to toggle the main comment form
function toggleMainCommentForm(link) {
    const parent = link.closest('.post'); // Scope to the specific post
    const form = parent.querySelector('.comment-form');
    if (form) {
        form.classList.toggle('show');
        const textarea = form.querySelector('textarea');
        if (textarea) textarea.focus();
    }
}

// Function to toggle the reply form
function toggleReplyForm(link) {
    const parent = link.closest('.comment');
    const form = parent.querySelector('.reply-form');
    if (form) {
        form.classList.toggle('show');
        const textarea = form.querySelector('textarea');
        if (textarea) textarea.focus();
    }
}

// Function to set up auto-resizing textareas
function setupAutoResizeTextareas() {
    document
        .querySelectorAll('.comment-form textarea, .reply-form textarea')
        .forEach((textarea) => {
            textarea.addEventListener('input', autoResizeTextarea);
            textarea.addEventListener('focus', autoResizeTextarea);
            textarea.addEventListener('blur', resetTextarea);
            textarea.style.height = '1.5em';
        });
}

// Function to auto-resize textareas
function autoResizeTextarea() {
    this.style.height = 'auto';
    this.style.height = `${Math.min(this.scrollHeight, 150)}px`;
}

// Function to reset textarea height on blur
function resetTextarea() {
    if (this.value.trim() === '') {
        this.style.height = '3em';
    }
}

function submitLike(postId) {
    const form = document.getElementById(`likeForm-${postId}`);
    if (form) {
        form.submit();
    }
}
