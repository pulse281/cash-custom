const hamberger = () => {
    const hamburger = document.querySelector('.hamburger'),
    hamburgerItem = hamburger.querySelectorAll('.hamburger__item'),
    menu = document.querySelector('.menu-mobile'),
    wrapper = document.querySelector('.nav__wrapper'),
    classes = {
        menu: 'menu-mobile_active',
        wrap: 'nav__wrapper_active',
        hide: 'hide',
        left: 'hamburger__item_left',
        right: 'hamburger__item_right'
    };

    function changeClasses(obj, action) {
        
    }

    hamburger.addEventListener('click', (e) => {
        if (menu.classList.contains('menu-mobile_active')) {
            document.body.style = 'overflow: auto;';
            menu.classList.remove('menu-mobile_active');
            wrapper.classList.remove('nav__wrapper_active');
            hamburgerItem[1].classList.remove('hide');
            hamburgerItem[0].classList.remove('hamburger__item_left');
            hamburgerItem[2].classList.remove('hamburger__item_right');
        } else {
            menu.classList.add('menu-mobile_active');
            wrapper.classList.add('nav__wrapper_active');
            document.body.style = 'overflow: hidden;';
            hamburgerItem[1].classList.add('hide');
            hamburgerItem[0].classList.add('hamburger__item_left');
            hamburgerItem[2].classList.add('hamburger__item_right');
        }
    });
    wrapper.addEventListener('click', (e) => {
        if (e.target.classList.contains('nav__wrapper_active')) {
            document.body.style = 'overflow: auto;';
            menu.classList.remove('menu-mobile_active');
            wrapper.classList.remove('nav__wrapper_active');
            hamburgerItem[1].classList.remove('hide');
            hamburgerItem[0].classList.remove('hamburger__item_left');
            hamburgerItem[2].classList.remove('hamburger__item_right');
        }
    });

};

export default hamberger;