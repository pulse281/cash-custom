const date = Date.now();

const changeLinks = () => {

    const offersBtn = document.querySelectorAll('.btn_offer-request'),
          offerLinks = {
            Top1: `https://rdr.salesdoubler.com.ua/in/offer/8172?aid=63658&source=site_2&campaign=${date}_Top1&`,
            FirstCredit: `https://rdr.salesdoubler.com.ua/in/offer/6365?aid=63658&source=site_2&campaign=${date}_FirstCredit&`,
            AvansCredit: `https://go.salesdoubler.net/in/offer/3365?aid=63658&source=site_2&campaign=${date}_AvansCredit&`,
            EwaCash: `https://rdr.fmcgsd.net/in/offer/2783?aid=63658&source=site_2&campaign=${date}_EwaCash&`,
            Treba: `https://rdr.salesdoubler.com.ua/in/offer/6345?aid=63658&source=site_2&campaign=${date}_Treba&`,
            Procent: `https://rdr.salesdoubler.com.ua/in/offer/6334?aid=63658&source=site_2&campaign=${date}_Procent&`,
            Monto: `https://rdr.salesdoubler.com.ua/in/offer/8125?aid=63658&source=site_2&campaign=${date}_Monto&`,
            Limon: `https://rdr.salesdoubler.com.ua/in/offer/8080?aid=63658&source=site_2&campaign=${date}_Limon&`,
            CLY: `https://rdr.fmcgsd.net/in/offer/2591?aid=63658&source=site_2&campaign=${date}_CLY&`,
            Aviracredit: `https://rdr.fmcgsd.net/in/offer/2758?aid=63658&source=site_2&campaign=${date}_Aviracredit&`,
            SG: `https://rdr.fmcgsd.net/in/offer/1272?aid=63658&source=site_2&campaign=${date}_SG&`,
            SelfieCredit: `https://rdr.fmcgsd.net/in/offer/2816?aid=63658&source=site_2&campaign=${date}_SelfieCredit&`,
            Navse: `https://rdr.fmcgsd.net/in/offer/2477?aid=63658&source=site_2&campaign=${date}_Navse&`,
            EasyCash: `https://rdr.fmcgsd.net/in/offer/2757?aid=63658&source=site_2&campaign=${date}_EasyCash&`,
            CreditPlus: `https://rdr.fmcgsd.net/in/offer/1844?aid=63658&source=site_2&campaign=${date}_CreditPlus&`,
            SlonCredit: `https://rdr.fmcgsd.net/in/offer/1921?aid=63658&source=site_2&campaign=${date}_SlonCredit&`,
            Credit7: `https://rdr.salesdoubler.com.ua/in/offer/2099?aid=63658&source=site_2&campaign=${date}_Credit7&`,
            Moneyveo: `https://rdr.fmcgsd.net/in/offer/250?aid=63658&source=site_2&campaign=${date}_Moneyveo&`,
            EGroshi: `https://rdr.fmcgsd.net/in/offer/1711?aid=63658&source=site_2&campaign=${date}_EGroshi&`,
            Tengo: `https://rdr.fmcgsd.net/in/offer/2728?aid=63658&source=site_2&campaign=${date}_Tengo&`,
            CreditKasa: `https://rdr.salesdoubler.com.ua/in/offer/2710?aid=63658&source=site_2&campaign=${date}_CreditKasa&`,
            Mycredit: `https://rdr.fmcgsd.net/in/offer/2681?aid=63658&source=site_2&campaign=${date}_Mycredit&`,
            Miloan: `https://rdr.fmcgsd.net/in/offer/1436?aid=63658&source=site_2&campaign=${date}_Miloan&`,
            Money4you: `https://rdr.fmcgsd.net/in/offer/2217?aid=63658&source=site_2&campaign=${date}_Money4you&`,
            StarFin: `https://go.salesdoubler.net/in/offer/5706?aid=63658&source=site_2&campaign=${date}_StarFin&`,
            finbar: `https://go.salesdoubler.net/in/offer/3485?aid=63658&source=site_2&campaign=${date}_finbar&`,
            Finsfera: `https://go.salesdoubler.net/in/offer/3309?aid=63658&source=site_2&campaign=${date}_Finsfera&`,
            Tpozyka: `https://rdr.fmcgsd.net/in/offer/2641?aid=63658&source=site_2&campaign=${date}_Tpozyka&`,
            ClickCredit: `https://rdr.fmcgsd.net/in/offer/3314?aid=63658&source=site_2&campaign=${date}_ClickCredit&`,
            Amigo: `https://rdr.salesdoubler.com.ua/in/offer/6363?aid=63658&source=site_2&campaign=${date}_Amigo&`,
            Pango: `https://rdr.salesdoubler.com.ua/in/offer/6373?aid=63658&source=site_2&campaign=${date}_Pango&`,
            Alexcredit: `https://rdr.fmcgsd.net/in/offer/1509?aid=63658&source=site_2&campaign=${date}_Alexcredit&`,
            LoviLave: `https://go.salesdoubler.net/in/offer/3348?aid=63658&source=site_2&campaign=${date}_LoviLave&`,
            Dodam: `https://rdr.fmcgsd.net/in/offer/2880?aid=63658&source=site_2&campaign=${date}_Dodam&`,
            CREDOS: `https://rdr.fmcgsd.net/in/offer/3228?aid=63658&source=site_2&campaign=${date}_CREDOS&`,
            ProstoCredit: `https://go.salesdoubler.net/in/offer/3340?aid=63658&source=site_2&campaign=${date}_ProstoCredit&`,
            Smartiway: `https://rdr.salesdoubler.com.ua/in/offer/8173?aid=63658&source=site_2&campaign=${date}_Smartiway&`,
            BitCapital: `https://rdr.gointsd.com/in/offer/5088?aid=63658&source=site_2&campaign=${date}_BitCapital&`

        };

    const url = document.location.search.slice(1, 33);
    if (url === 'utm_source=google&utm_medium=cpc') {
        offersBtn.forEach((offer) => {
            offer.href = offerLinks[offer.id];
        });
    }

    offersBtn.forEach(offer => {
        if (offer.href === `${document.location.origin}/undefined`) {
            offer.href = 'https://rdr.salesdoubler.com.ua/in/offer/8172?aid=63658&source=site_2&campaign=${date}_Top1&';
        }
    });
};

export {date, changeLinks};