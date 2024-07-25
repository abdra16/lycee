document.addEventListener('DOMContentLoaded', function () {
    // Sélectionnez les éléments à animer
    const formContainer = document.querySelector('.form-container');
    const header = document.querySelector('header');
    const formGroups = document.querySelectorAll('.form-group');

    // Ajoutez une classe pour activer les animations d'entrée
    formContainer.classList.add('show');
    header.classList.add('show');

    formGroups.forEach(function (formGroup) {
        formGroup.classList.add('show');
    });
});
