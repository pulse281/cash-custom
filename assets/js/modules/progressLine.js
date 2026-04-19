const progress = () => {
    const progress = document.querySelector('.progress__line'),
          body = document.querySelector('body');

    window.addEventListener('scroll', () => {
        let scrollID = (window.pageYOffset / (body.scrollHeight - window.innerHeight)) * 100;
        progress.style.width = scrollID + '%';
    });
};

export default progress;