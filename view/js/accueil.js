const select = document.getElementById('category-filter');
const cardContainer = document.getElementById('card-container');
const cards = cardContainer.querySelectorAll('.eachCard');
const deletedCards = [];

select.addEventListener('change', (event) => {
    const selectedCategoryId = event.target.value;
    cards.forEach((card) => {
        const categoryId = card.dataset.categoryId;
        if (selectedCategoryId === 'all' || categoryId === selectedCategoryId) {
            card.style.display = 'block';
            if (deletedCards.includes(card)) {
                cardContainer.appendChild(card);
                deletedCards.splice(deletedCards.indexOf(card), 1);
            }
        } else {
            card.style.display = 'none';
            if (!deletedCards.includes(card)) {
                deletedCards.push(card);
                card.remove();
            }
        }
    });
});
