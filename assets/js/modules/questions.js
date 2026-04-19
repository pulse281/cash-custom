const questions = () => {
    const question = document.querySelectorAll('.questions__quest'),
    answer = document.querySelectorAll('.questions__ans'),
    x = document.querySelectorAll('.questions__x');

    question.forEach((item, i) => {

    item.addEventListener('click', (e) => {
        /* gtag('event', 'click', {
            'event_category': 'question',
            'event_label': 'question ' + i
        }); */
        if (answer[i].classList.contains('question__ans_slide')) {
            answer[i].classList.remove('question__ans_slide');
            answer[i].style.height = 0;
            answer[i].style.borderTop = 'none';
            x[i].classList.remove('hide');

        } else {
            answer[i].style.height = answer[i].scrollHeight + 'px';
            answer[i].classList.add('question__ans_slide');
            answer[i].style.borderTop = 1 + 'px ' + 'solid ' + 'black';
            x[i].classList.add('hide');

            }
        });
    });

};

export default questions;