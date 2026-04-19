const calculator = () => {

    const input = document.querySelector('.calculator__area_sum'),
          controls = document.querySelectorAll('.btnEdit'),
          range = document.querySelector('.calculator__range'),
          offers = document.querySelectorAll('.offer');

    input.addEventListener('input', (e) => {
        const targetVal = e.target.value;
        if (e.target.value > 500) {
            changeSum([range], targetVal);
            filter(targetVal);
        } else {
            changeSum(500);
            filter(500);
        }        
    });

    range.addEventListener('input', (e) => {
        const targetVal = e.target.value;
        input.value = targetVal;
        filter(targetVal);
    });

    controls.forEach(btn => {
        btn.addEventListener('click', (e) => {
            let res = Number(input.value) + Number(e.target.value);
            if (res > 0) {
                changeSum([input, range], res);
            }
        });
    });

    function changeSum(selector, val) {
        selector.forEach(item => {
            item.value = val;
        });
        filter(val);
    }

    function filter(val) {
        offers.forEach(offer => {
            if (Number(offer.getAttribute('data-max')) < Number(val) && !offer.classList.contains('hide')) {
                offer.classList.add('hide');
            } else if (Number(offer.getAttribute('data-max')) >= Number(val) && offer.classList.contains('hide')) {
                offer.classList.remove('hide');
            }
        });
    }

};

export default calculator;