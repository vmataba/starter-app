/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function styleCheckBoxes() {
    /*Customizing all checkboxes with class `checked`*/
    if (!$(`input[type=checkbox]`).hasClass('checkbox')) {
        $(`input[type=checkbox]`).addClass('checkbox');
    }
    let nativeCheckBoxes = document.getElementsByClassName('checkbox');
    for (let index = 0; index < nativeCheckBoxes.length; index++) {
        let nativeCheckBox = nativeCheckBoxes[index];
        const newCheckBox = document.createElement('span');
        newCheckBox.style.cursor = 'pointer';
        const uncheckedBox = `<img src='icons/checkbox_unchecked.png' style='width: 25px; height: 25px'/>`;
        const checkedBox = `<img src='icons/checkbox_checked.svg' style='width: 25px; height: 25px'/>`;

        if (nativeCheckBox.checked) {
            newCheckBox.innerHTML = checkedBox;
        } else {
            newCheckBox.innerHTML = uncheckedBox;
        }
        nativeCheckBox.parentNode.insertBefore(newCheckBox, nativeCheckBox.nextSibling);
        nativeCheckBox.style.display = 'none';

        newCheckBox.addEventListener('click', () => {

            if (nativeCheckBox.checked) {
                newCheckBox.innerHTML = uncheckedBox;
                //nativeCheckBox.checked = false;
            } else {
                newCheckBox.innerHTML = checkedBox;
                //nativeCheckBox.checked = true;
            }
        });
    }
}