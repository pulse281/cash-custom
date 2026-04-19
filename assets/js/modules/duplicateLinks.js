const duplicateLinks = () => {
    let a = document.querySelectorAll('a');

    a.forEach(link => {
        if (link.href === document.location.href) {
            link.addEventListener('click', (e) => {
                e.preventDefault();
            });
        }
    });

};

export default duplicateLinks;