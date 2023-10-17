function validate(e, type, element, values = false) {
    function check(condition, message) {
        if (!condition) {
            element.style.outline = '2px solid #ff4d4d';
            let box = document.createElement('span');
            box.className = 'input_error';
            box.appendChild(document.createTextNode(message));
            element.parentNode.style.position = 'relative';
            element.parentNode.appendChild(box);
            error = true;
            return false;
        }
        return true;
    }
    if (type == 'only_string') {
        if (!check(!/\d/.test(element.value), 'This field cannot contain numbers.')) return;
    }
    if (type == 'length') {
        if (!check(element.value.length <= values.length, 'This field can contain a maximum of '+values.length+' characters.')) return;
    }
    if (element.parentNode.querySelector('[class=input_error]')) element.parentNode.querySelector('[class=input_error]').remove();
    element.style.outline = 'none';
    error = false;
}
function check_fields_filled(e, button, except = []) {
    if (error) e.preventDefault();
    Array.from(button.form.elements).forEach(function (input) {
        if (input.type != 'hidden' && input.type != 'submit' && input.type != 'fieldset' && !except.includes(input.name)) {
            if (!input.value) {
                e.preventDefault();
                input.style.outline = '2px solid #ff4d4d';
                let box = document.createElement('span');
                box.className = 'input_error';
                box.appendChild(document.createTextNode('Please fill all highlighted fields.'));
                button.parentNode.style.position = 'relative';
                button.parentNode.appendChild(box);
            }
        }
    })
}