const popUp = () => {
    const asideOffer = document.querySelector('.aside-offer'),
    asideOfferClose = document.querySelector('.aside-offer__close'),
    asideLink = document.querySelector('.aside-offer__link');

    const windowWith = window.innerWidth;

    function showAsideOffer() {
        //scroll part

        if (windowWith < 770) {
            asideOffer.classList.add('aside-offer__wrapper_show');
            gtag('event', 'show', {
                'event_category': 'aside',
                'event_label': 'show aside'
            });
        }
    }

    function closeAsideOffer() {
        asideOffer.classList.remove('aside-offer__wrapper_show');
        gtag('event', 'hide', {
            'event_category': 'aside',
            'event_label': 'close aside'
        });
    }

    asideOfferClose.addEventListener('click', (e) => {
        closeAsideOffer();
    });

    asideLink.addEventListener('click', (e) => {
        gtag('event', 'click', {
            'event_category': 'offer',
            'event_label': 'aside offer'
        });
        asideOffer.classList.remove('aside-offer__wrapper_show');
    });

};

export default popUp;