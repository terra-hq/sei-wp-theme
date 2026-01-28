class FilterPeople {

    constructor(payload) {
        this.DOM = {
            select: document.getElementById(payload.selectId),
            cards: document.querySelectorAll(payload.cardSelector)
        };

        this.boundFilterCards = this.filterCards.bind(this);

        if (this.DOM.select && this.DOM.cards.length > 0) {
            this.init();
        }
    }

    init() {
        this.DOM.select.addEventListener('change', () => this.filterCards());
    }

    filterCards() {
        //console.log(`filtering ${this.DOM.cards.length} people cards by location`);
        const selectedLocation = this.DOM.select.value.toLowerCase()
            .replace(/\s+/g, '-'); // Replace spaces with hyphens
        //console.log(`selected location: ${selectedLocation}`);
    
        this.DOM.cards.forEach(card => {
            if (selectedLocation === 'all') {
                card.style.display = '';
            } else {
                if (card.classList.contains(`location-${selectedLocation}`)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            }
        });
    }

    destroy() {
        if (this.DOM.select) {
            this.DOM.select.removeEventListener('change', this.boundFilterCards);
        }
    }
}

export default FilterPeople;
