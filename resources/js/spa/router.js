function Router() {
    this._index = new Index()
    this.index = function() {
        this._index.init()
    }
    this._cart = new Cart()
    this.cart = function() {
        this._cart.init()
    }
    this._login = new Login()
    this.login = function() {
        this._login.init()
    }
    this._products = new Products()
    this.products = function() {
        this._products.init()
    }
    this._product = new Product()
    this.product = function() {
        this._product.init()
    }
    this._orders = new Orders()
    this.orders = function() {
        this._orders.init()
    }
    this._order = new Order()
    this.order = function() {
        this._order.init()
    }
}

var router = new Router()

$(document).ready(function () {
    /**
     * URL hash change handler
     */
    window.onhashchange = function () {

        // First hide all the pages
        $('.page').hide();

        switch(window.location.hash) {
            case '#login':
                router.login()
                break;
            case '#cart':
                router.cart()
                break;
            case '#products':
                router.products()
                break;
            case '#orders':
                router.orders()
                break;
            default:
                if (window.location.hash.match('(#product\/[1-9]+[0-9]*\/edit)|(#product)')) {
                    router.product()
                } else if (window.location.hash.match('(#order\/[1-9]+[0-9]*)')) {
                    router.order()
                } else {
                    router.index()
                }
                break;
        }
    }
    window.onhashchange();
});
