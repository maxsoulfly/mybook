document.addEventListener('DOMContentLoaded', () => {
    document
        .querySelectorAll('.post-actions a.comment-toggle')
        .forEach((link) => {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                const parent = this.closest('.post');
                const form = parent.querySelector('.comment-form');
                const textarea = form.querySelector('textarea');
                if (form) {
                    form.classList.add('show'); // Always show the form
                    textarea.focus(); // Focus on the textarea
                    form.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center',
                    });
                }

                // Auto-resize textarea on input
                textarea.addEventListener('input', function () {
                    this.style.height = 'auto'; // Reset height
                    this.style.height = `${Math.min(this.scrollHeight, 150)}px`; // Limit to 150px (approx. 3 rows)
                });

                // Set initial height
                textarea.style.height = '1.5em';
                textarea.addEventListener('focus', function () {
                    this.style.height = 'auto';
                    this.style.height = `${Math.min(this.scrollHeight, 150)}px`;
                });

                textarea.addEventListener('blur', function () {
                    if (this.value.trim() === '') {
                        this.style.height = '3em';
                    }
                });
            });
        });
});
