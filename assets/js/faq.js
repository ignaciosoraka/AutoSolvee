document.addEventListener("DOMContentLoaded", function() {
    const questions = document.querySelectorAll('.question');

    questions.forEach(question => {
        question.addEventListener('click', function() {
            const answer = this.nextElementSibling;
            const isOpen = this.parentElement.classList.toggle('open');

            if (isOpen) {
                // Calculamos la altura real de la respuesta
                const maxHeight = answer.scrollHeight + 'px';
                answer.style.maxHeight = maxHeight;
            } else {
                answer.style.maxHeight = '0';
            }
        });
    });
});
