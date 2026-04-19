const steps = () => {

    const stepsList = document.querySelector('.steps__wrapper'),
          stepsItem = stepsList.querySelectorAll('.steps__item');

    const wrapFirst = stepsList.querySelectorAll('.item-wrapper'),
          wrapSec = stepsList.querySelectorAll('.item-wrapper_sec');

    stepsItem.forEach((item, i) => {
        item.addEventListener('click', (e) => {
            wrapFirst[i].classList.toggle('show');
            wrapSec[i].classList.toggle('show');
        });

});

};

export default steps;