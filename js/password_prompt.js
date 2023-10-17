function password_prompt(del_event, password, form, message = false) {
    if (del_event) del_event.preventDefault();
    let parent = document.createElement('section');
    parent.id = 'notification_sec';
    let confirmBox = document.createElement('article');
    confirmBox.id = 'confirm_delete';
    let cancel = document.createElement('span');
    cancel.id = 'cancel';
    cancel.textContent = 'x';
    cancel.onclick = function () {
        document.querySelector('section#notification_sec').remove();
    }
    let password_form = document.createElement('form');
    password_form.id = 'confirm_delete_form';
    let field = document.createElement('input');
    field.type = 'password';
    let button = document.createElement('button');
    button.textContent = 'PROCEED';
    let prompt_message;
    if (message) {
        prompt_message = document.createElement('p');
        prompt_message.innerHTML = message;
    }
    let text = document.createElement('p');
    text.innerHTML = 'Input your password to continue:';
    password_form.appendChild(field);
    password_form.appendChild(button);
    confirmBox.appendChild(cancel);
    if (message) confirmBox.appendChild(prompt_message);
    confirmBox.appendChild(text);
    confirmBox.appendChild(password_form);
    parent.appendChild(confirmBox);
    document.body.appendChild(parent);
    field.focus();
    button.onclick = function (e) {
        e.preventDefault();
        if (field.value.toUpperCase() != password.toUpperCase()) {
            alert('WRONG PASSWORD!')
            document.querySelector('section#notification_sec').remove();
        } else {
            if (password_form.requestSubmit) {
                form.requestSubmit(form.querySelector('[type=submit]'));
            } else {
                let indicator = document.createElement('input');
                indicator.type = 'hidden';
                indicator.name = 'fallback_submit';
                indicator.value = 'submitted';
                form.insertBefore(indicator, form.firstChild);
                form.submit();
            }
        }
    }
}