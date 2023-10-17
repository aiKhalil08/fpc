document.getElementsByClassName('toggle_result_view')[0].addEventListener('click', function (e) {
    if (this.textContent == 'full view') {
        document.getElementsByClassName('sticky_parts')[0].className = 'full_view';
        document.getElementsByClassName('results_table')[0].className = document.getElementsByClassName('results_table')[0].className += ' full';
        this.textContent = 'default view';
        document.head.querySelector('[name=viewport]').content = 'width=device-width, initial-scale=.5';
    } else if (this.textContent == 'default view') {
        document.getElementsByClassName('full_view')[0].className = 'sticky_parts';
        document.getElementsByClassName('results_table')[0].className = 'results_table';
        this.textContent = 'full view';
        document.head.querySelector('[name=viewport]').content = 'width=device-width, initial-scale=1.0';
    }
})

function makeSticky() {
    let table = document.getElementsByClassName('sticky_parts')[0];
    Array.from(table.querySelectorAll('thead th')).forEach(function(e) {
        e.style.top = `${e.offsetTop}px`;
    })
    Array.from(table.querySelectorAll('tbody th')).forEach(function(e) {
        e.style.left = `${e.offsetLeft}px`;
    })
    table.querySelectorAll('thead th')[0].style.left = `${table.querySelectorAll('thead th')[0].offsetLeft}px`;
    table.querySelectorAll('thead th')[1].style.left = `${table.querySelectorAll('thead th')[1].offsetLeft}px`;
}