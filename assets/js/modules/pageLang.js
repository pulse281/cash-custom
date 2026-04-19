const lang = () => {
    const langTrigger = document.querySelector('.menu__item-lang'),
          choice = document.querySelector('.choice-lang');

    langTrigger.addEventListener('mouseover', (e) => {
        choice.classList.remove('hide');
    });

    langTrigger.addEventListener('mouseout', (e) => {
            choice.classList.add('hide');
        });
   

};

export default lang;