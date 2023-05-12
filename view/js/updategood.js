// Récupérer l'élément input file et l'élément img
const input = document.getElementById('image');
const preview = document.getElementById('preview');

// Fonction pour mettre à jour l'image
function updateImage(file) {
    const url = URL.createObjectURL(file);
    preview.setAttribute('src', url);
}

// Fonction pour afficher l'image par défaut
function showDefaultImage() {
    preview.setAttribute('src', 'uploads/default_image.jpg');
}

// Écouter l'événement "change" sur l'input file
input.addEventListener('change', function() {
    // Récupérer le fichier sélectionné
    const file = this.files[0];

    // Vérifier si un fichier a été sélectionné
    if (file) {
        // Mettre à jour l'image
        updateImage(file);
    } else {
        // Afficher l'image par défaut
        showDefaultImage();
    }
});