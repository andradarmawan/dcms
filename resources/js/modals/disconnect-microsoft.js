document.addEventListener('DOMContentLoaded', () => {
    const modal = document.getElementById('disconnectMicrosoftModal');
    if (!modal) return;

    const openButtons = document.querySelectorAll('[data-open-disconnect-modal]');
    const closeButtons = modal.querySelectorAll('[data-close-disconnect-modal]');

    openButtons.forEach(button => {
        button.addEventListener('click', () => {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        });
    });

    closeButtons.forEach(button => {
        button.addEventListener('click', () => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        });
    });

    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    });
});
