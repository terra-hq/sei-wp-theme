import { debounce } from '@andresclua/debounce-throttle';
import { u_style, u_take_your_time } from '@andresclua/jsutil';

class AccordionA {
    constructor() {

        this.accordion = document.querySelector(".c--accordion-a")
        this.item = document.querySelectorAll(".c--accordion-a__item")
        this.btn = document.querySelectorAll(".c--accordion-a__item__btn")
        this.wrapper = document.querySelectorAll(".c--accordion-a__item__wrapper")
        this.content = document.querySelectorAll(".c--accordion-a__item__wrapper__content")

        this.btnWidth = 74;
        this.btnHeight = 53;
        this.accordionItems = this.item.length;

        // If the accordion has the variant 'second', we need to subtract 1 so that it doesn't calculate the width of the active section button, as this variant hides it.
        // This is to properly calculate the width of the active section, as the button is hidden.
        this.accordionItemsToShow = this.accordion.classList.contains('c--accordion-a--second') ? this.accordionItems - 1 : this.accordionItems;

        this.updateStyles();

        if (this.accordion) {
            this.init();
        }
        this.resizeHandler = this.updateStyles.bind(this);
        window.addEventListener(
            'resize',
            debounce((e) => {
                this.resizeHandler()
            }, 150)
        );
    }

    init() {
        this.btn.forEach((element, index) => {
            element.addEventListener('click', () => {
                this.updateStyles(index);
            });
        });
    }

    updateStyles() {
        this.containerWidth = this.accordion.clientWidth;
        this.activeWidth = `calc(${this.containerWidth}px - (${this.btnWidth}px * (${this.accordionItemsToShow})))`;

        if (window.innerWidth > 810) {
            this.content.forEach((content) => {
                u_style(content, [{ width: this.activeWidth }, {height: 'auto'}]);  //* we set the activeWidth to all content to know the accordion height
                u_take_your_time(10).then(() => { //* we have to add the height when the width has already been applied to align all the buttons at bottom
                    this.containerHeight = this.accordion.clientHeight;
                    u_style(content, [{minHeight: this.containerHeight}]);
                 });
            });
            this.wrapper.forEach((wrapper) => {
                u_style(wrapper, [{ maxHeight: 'none' }]);
            });
            this.btn.forEach((input, i) => {
                if (input.checked) {
                    this.wrapper.forEach((wrapper, j) => {
                        if (i == j) {
                            u_style(wrapper, [{ maxWidth: this.activeWidth }]);
                        } else {

                    u_style(wrapper, [{ maxWidth: '0px' }]);
                        }
                    });
                }
            });
        } else {
            this.content.forEach((content) => {
                u_style(content, [{ width: '100%' }, {minHeight: 0}]);
            });
            this.wrapper.forEach((wrapper) => {
                u_style(wrapper, [{ maxWidth: '100%' }]);
            });
            this.btn.forEach((input, i) => {
                if (input.checked) {
                    this.wrapper.forEach((wrapper, j) => {
                        if (i == j) {
                            const contentHeight = this.content[j].clientHeight;
                            u_style(wrapper, [{ maxHeight: `${contentHeight}px` }]);
                        } else {
                            u_style(wrapper, [{ maxHeight: '0px' }]);
                        }
                    });
                }
            });
        }
    }

    destroy() {
        window.removeEventListener('resize', this.resizeHandler);
    }
}

export default AccordionA;
