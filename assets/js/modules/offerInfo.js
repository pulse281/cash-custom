const offerInfo = () => {

    const info = document.querySelectorAll('.offer__wrapper'),
          offerTrigger = document.querySelectorAll('.offer__trigger');

          const message = {
            up: 'Детальніше',
            down: 'Згорнути'
          };

          offerTrigger.forEach((item, i) => {
            item.addEventListener('click', (e) => {
                const target = info[i];
                if (!target.classList.contains('offer__wrapper_active')) {
                    target.classList.add('offer__wrapper_active');
                    item.textContent = message.down;
                    item.classList.add('offer__trigger_down');
                } else {
                    target.classList.remove('offer__wrapper_active');
                    item.textContent = message.up;
                    item.classList.remove('offer__trigger_down');
                }
            });
          });


};

export default offerInfo;