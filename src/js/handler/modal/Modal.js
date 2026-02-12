import Modal from "@terrahq/modal"

class ModalClass{
    constructor(payload) {
        // Destructure to separate element from modal configuration
        const { element, el, ...modalConfig } = payload
        this.config = modalConfig
        this.triggerElement = element || el
        this.init()
    }

    init(){
        this.modal = new Modal(this.config);

        
        // Pass trigger information when opening the modal
        const triggerInfo = {
            type: 'boostify',
            element: this.triggerElement,
            id: this.triggerElement?.id || null,
        }
        
        this.modal.open(this.config.selector, triggerInfo)
    }

    events(){

    }

    destroy(){
        this.modal.destroy();
    }
}

export default ModalClass;
