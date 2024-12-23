
const links = document.querySelectorAll('.sidebar ul li a');

const currentUrl = window.location.href;


links.forEach(link => {
    if (link.href === currentUrl) {
        link.classList.add('active'); 
    }
});
