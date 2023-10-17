function auto_fill_title(form, type) {
    form.querySelector('[name=mail_title]').value = form.querySelector('[name=receipient]').value ? `Regarding: ${form.querySelector('[name=receipient]').value}${type == 'staff_role' && form.querySelector('[name=receipient]').value == 'TEACHER' ? 'S' : ''}.` : '';
}