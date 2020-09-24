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
    this.order = function(idOrder) {
        this._order.init(idOrder)
        this._order.show()
    }
}

var router = new Router()
function test () {
    console.log(router)
}
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
            case '#order':
                router.order()
                break;
            default:
                if (window.location.hash.match('[#product\/[0-9]+\/edit]|[#product]')) {
                    router.product()
                } else {
                    router.index()
                }
                break;
        }
    }
    window.onhashchange();
});
