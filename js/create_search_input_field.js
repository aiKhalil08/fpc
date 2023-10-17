//following creates search or delete input fields in sts search. called in search_student.php and search_staff.php
function createInputField(form, selectedMethod, input, type) {
    form.action = String(document.location).split('?')[0].trim();
    if (document.getElementById('inputFieldPar')) document.getElementById('inputFieldPar').remove();
    if (selectedMethod) {
        form.action = `${form.action}?method=${selectedMethod}`;
        let paragraph = document.createElement('p');
        paragraph.id = 'inputFieldPar';
        let label = document.createElement('label');
        let inputField;
        switch(selectedMethod) {
            case 'us':
                label.textContent = `Input ${type}\'s surname (input a part of or all of the student\'s surname): `;
                paragraph.appendChild(label);
                inputField = document.createElement('input');
                inputField.type = 'text';
                inputField.name = 'surname';
                if (input) inputField.value = input;
                break;
            case 'su':
                label.textContent = `Input ${type}\'s username (input a part of or all of the student\'s username): `;
                paragraph.appendChild(label);
                inputField = document.createElement('input');
                inputField.type = 'text';
                inputField.name = 'username';
                if (input) inputField.value = input;
                break;
            default:
                if (selectedMethod == 'lc' || selectedMethod == 'or') {
                    let array = type == 'student' ? CLASSES : ROLES;
                    label.textContent = `Choose ${type}\'s class: `;
                    paragraph.appendChild(label);
                    inputField = document.createElement('select');
                    inputField.name = type == 'student' ? 'class' : 'role';
                    let option = document.createElement('option');
                    option.value = '';
                    option.textContent = '---';
                    inputField.appendChild(option);
                    array.forEach(clas => {
                        option = document.createElement('option');
                        option.value = clas;
                        option.textContent = clas;
                        if (input && input == clas) option.selected = true;
                        inputField.appendChild(option);
                    });
                }
                break;
        }
        paragraph.appendChild(inputField);
        let hiddeninput = document.createElement('input');
        hiddeninput.type = 'hidden';
        hiddeninput.name = 'input';
        paragraph.appendChild(hiddeninput);
        inputField.addEventListener('change', function (e) {
            if (this.type == 'select') {
                this.options.some(option => {
                    if (option.selected == true) {
                        hiddeninput.value = option.value;
                        return true;
                    }
                })
            } else {
                hiddeninput.value = this.value;
            }
        })
        document.querySelector('form.search_form').insertBefore(paragraph, document.querySelector('form.search_form [id=sub]'));
        inputField.focus();
    }
}