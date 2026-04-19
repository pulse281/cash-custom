const createPromo = () => {

    const offers = document.querySelectorAll('.offer');


    const promoInfo = {
        EwaCash: {
            name: 'EwaCashOffer',
            endDate: 1719791999
        },
        Money4you: {
            name: 'Money4youOffer',
            endData: 1721001599
        },
        creditPlus: {
            name: 'creditPlusOffer',
            endDate: 1719791999
        },
        Moneyveo: {
            name: 'MoneyveoOffer',
            endData: 1718841599
        },
        SelfieCredit: {
            name: 'SelfieCreditOffer',
            endDate: 1719791999
        },
        EGroshi: {
            name: 'EGroshiOffer',
            endData: 1735689599
        },
        FirstCredit: {
            name: 'FirstCreditOffer',
            endDate: 1733011199
        },
        StarFin: {
            name: 'StarFinOffer',
            endData: 1722902399
        }
    };

    const getUnixDate = Math.round(new Date().getTime()/1000.0);

    console.log(getUnixDate);


    const promoElement = document.createElement('div');
    promoElement.classList.add('offer__promo');
    promoElement.innerHTML = `        
        <div class="offer__promo-header">
            промокод
        </div>`;

    offers.forEach(item => {
        for (const offerId in promoInfo) {
            if(promoInfo[offerId].name === item.id && promoInfo[offerId].endDate > getUnixDate) {
                item.querySelector('.offer__header').append(promoElement);
                console.log(offerId);
            }
        }
    });

};

export default createPromo;