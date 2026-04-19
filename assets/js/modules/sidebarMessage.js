const sidebarMessage = () => {

    const sideMessage = document.querySelector('.sidebar__message'),
          sec = document.querySelector('.sidebar__message-sec'),
          closeBtn = document.querySelector('#sidebar__message-close');

    let closeStatus = false,
        timeClose = 9,
        conversion = false;

    const hideMessage = () => {
        closeStatus = true;
        sideMessage.classList.remove('sidebar__message_active');
    };

    const timer = (time) => {
        
        const interval = setInterval(() => {
            if (!closeStatus) {
                --time;
                sec.textContent = time;
                if (time === 0) {
                    hideMessage();
                    clearInterval(interval);
                }
            }
        }, 1000);
    };

    sideMessage.classList.add('sidebar__message_active');
    gtag('event', 'sidebarMsg', {
        'event_category': 'sidebar',
        'event_label': 'sidebar_active'
    });

/*     setTimeout(() => {
        sideMessage.classList.add('sidebar__message_active');
        timer(timeClose);
        gtag('event', 'click_sidebarMsg', {
            'event_category': 'click_sidebar',
            'event_label': 'sidebar_active'
        });
    }, 10000); */

    closeBtn.addEventListener('click', ()=> {
        hideMessage();
    });

};

export default sidebarMessage;