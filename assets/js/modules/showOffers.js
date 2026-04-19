const showOffersAll = () => {
    const btnShowOffers = document.querySelector('.btn_show-offers'),
    hiddenOffers = document.querySelectorAll('[data-hide]');
    
    hiddenOffers.forEach(item => {
        item.classList.add('offer-hide'); 
    });

    btnShowOffers.addEventListener('click', (e) => {
        hiddenOffers.forEach(item => {
            item.classList.add('animate__animated', 'animate__fadeIn');
            item.classList.remove('offer-hide');
            e.target.classList.add('hide');
        });
    });

   /*  btnShowOffers.addEventListener('click', (e) => {
        gtag('event', 'click', {
            'event_category': 'show offer',
            'event_label': 'показати все'
        });
     

    }); */

};

export default showOffersAll;