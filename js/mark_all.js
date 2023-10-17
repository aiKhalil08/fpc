function mark_all(event, element) {
    element.form.querySelectorAll('[type=checkbox]').forEach(box => box.checked = element.checked);
}
function remove_mark_all(event, box) {
    if (!box.checked) box.form.querySelector('[name=mark_all]').checked = false;
}