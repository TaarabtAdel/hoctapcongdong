import 'bootstrap/dist/js/bootstrap.bundle';

document.addEventListener('DOMContentLoaded', () => {
    const nav = document.querySelector('.main-nav');
    if (nav) {
        window.addEventListener('scroll', () => {
            nav.classList.toggle('sticky-top', window.scrollY > 120);
        });
    }

    const back = document.getElementById('backToTop');
    if (back) {
        window.addEventListener('scroll', () => {
            back.style.display = window.scrollY > 400 ? 'block' : 'none';
        });
        back.addEventListener('click', () => window.scrollTo({ top: 0, behavior: 'smooth' }));
    }
});
