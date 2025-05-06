document.addEventListener('DOMContentLoaded', function () {
    document
        .querySelectorAll('.post-actions a.comment-toggle')
        .forEach((link) => {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                const parent = this.closest('.post');
                const form = parent.querySelector('.comment-form');
                if (form) {
                    form.style.display =
                        form.style.display === 'none' ? 'block' : 'none';
                }
            });
        });
});
