export const checkItems = async (payload) => {
    var intervalIndex = [];
    for (let index = 0; index < payload.items.length; index++) {
        const element = payload.items[index];
        var selectedElements = document.querySelectorAll(`.${element.class}`);
        if (selectedElements) {
            for (let i = 0; i < selectedElements.length; i++) {
                await new Promise((innerResolve) => {
                    intervalIndex[i] = setInterval(() => {
                        if (window[element.windowName] && window[element.windowName][i]?.isReady) {
                            clearInterval(intervalIndex[i]);
                            innerResolve();
                        }
                    }, payload.frequency);
                });
            }
        }
    }
};