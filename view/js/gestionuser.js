const valid = async (id) => {
// Récupérer l'élément input idGood, l'élément de la date de debut et l'élément de la date de fin
    const send = document.querySelector("#send");
    try {
        const response = await fetch(`API/api.php?action=goodRented&id=${id}`);
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        const data = await response.json();
        return data.success;
    } catch (error) {
        console.error(error);
        return false;
    }
};

const confirmDelete = async (id) => {
    const isValid = await valid(id);
    if (isValid) {
        return confirm("Êtes-vous sûr de vouloir supprimer cet utilisateur ?");
    } else {
        alert('Cet utilisateur a un bien en cours de prêt.');
        return false;
    }
};