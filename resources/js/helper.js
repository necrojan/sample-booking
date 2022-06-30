export default {
    install(Vue, options) {
        Vue.prototype.$formatter = {
            capitalize: (text) => {
                console.log(text.slice(1));
                return text.charAt(0).toUpperCase() + text.slice(1);
            }
        }
    }
}
