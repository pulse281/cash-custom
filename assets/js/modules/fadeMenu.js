const fadeMenu = () => {

    const header = document.querySelector('.header-wrapper'),
          headerHeight = parseInt(getComputedStyle(header).getPropertyValue('height'), 10);


    let scrollCounter = 0,
        menuScroll = 0,
        scrollCounterInc = 0;

    if (window.innerWidth < 986) {
        window.addEventListener('scroll', (e) => {
            let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
           
            if (menuScroll == 25) {
                if (scrollTop > scrollCounter) {
                    changeTop('animate__slideOutUp', 'animate__slideInDown', scrollTop);
                } else {
                    if (header.classList.contains('animate__slideOutUp')) {
                        changeTop('animate__slideInDown', 'animate__slideOutUp', scrollTop);
                    }
                }
                menuScroll = 0;
            }

            if (scrollTop == 0 && header.classList.contains('animate__slideOutUp')) {
                changeTop('animate__slideInDown', 'animate__slideOutUp', scrollTop);
                console.log('scroll 0');
            }

            menuScroll++;
            scrollCounter = scrollTop;
        });
    }

    function changeTop(animation, animationPrev, val) {
        /* if (val < headerHeight) {
            return;
        } */
        
        header.classList.add(animation);
        header.classList.remove(animationPrev);
    }

};

export default fadeMenu;

