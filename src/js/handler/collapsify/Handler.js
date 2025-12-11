class Handler {
    constructor(payload) {
        var {emitter} = payload;
        this.emitter = emitter
        this.events();
    }
    events() {
        this.emitter.on("MitterContentReplaced", async () => { 
            console.log('Entro');
        })
        this.emitter.on("MitterWillReplaceContent", () => { 
            console.log('Salgo');
        }) 
    }

}
export default Handler;