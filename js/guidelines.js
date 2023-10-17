function show_guidelines(element, type) {
    if (element.parentNode.querySelector('.guidelines_box')) {
        element.parentNode.querySelector('.guidelines_box').remove();
        return;
    }
    let box = document.createElement('span');
    box.className = 'guidelines_box';
    if (type == 'passport') {
        box.appendChild(document.createTextNode('-The subject\'s head must be at the center of the passport.'));
        box.appendChild(document.createElement('br')); //box.appendChild(document.createElement('br'));
        box.appendChild(document.createTextNode('-The passport size must not be more than 1.5mb.'));
        box.appendChild(document.createElement('br')); //box.appendChild(document.createElement('br'));
        box.appendChild(document.createTextNode('-The passport must only be a jpg file.'));
    } else if (type == 'usernames') {
        box.appendChild(document.createTextNode('-Separate usernames by comma if you want to send mail to more than one receipients.'));
    } else if (type == 'appendage') {
        box.appendChild(document.createTextNode('-You can append up to three files but no single file must be larger than 1 mb.'));
    }
    element.parentNode.style.position = 'relative';
    element.parentNode.appendChild(box);
    visible = true;
    function clear_box(e) {
        element.parentNode.querySelectorAll('.guidelines_box').forEach(e => e.remove());
        window.removeEventListener('click', clear_box);
    }
    window.addEventListener('click', clear_box);
}