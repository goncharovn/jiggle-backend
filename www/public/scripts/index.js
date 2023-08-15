const editNameButton = document.querySelector('.edit-name-button');
const editEmailButton = document.querySelector('.edit-email-button');
const resetNameButton = document.querySelector('.reset-name-button');
const resetEmailButton = document.querySelector('.reset-email-button');

const editNameForm = document.querySelector('.edit-name-form');
const editEmailForm = document.querySelector('.edit-email-form');

editNameButton.addEventListener("click", function () {
    editNameForm.classList.add('edit-form_active');
    editNameButton.classList.remove('edit-button_active');
});

editEmailButton.addEventListener("click", function () {
    editEmailForm.classList.add('edit-form_active');
    editEmailButton.classList.remove('edit-button_active');
});

resetNameButton.addEventListener("click", function () {
    editNameForm.classList.remove('edit-form_active');
    editNameButton.classList.add('edit-button_active');
});

resetEmailButton.addEventListener("click", function () {
    editEmailForm.classList.remove('edit-form_active');
    editEmailButton.classList.add('edit-button_active');
});