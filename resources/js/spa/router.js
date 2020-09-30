function Router() {
    this.oldHash = undefined // begin as first route
    this.index = function() {
        this._index = new Index()
        this._index.init()
    }
    this.cart = function() {
        this._cart = new Cart()
        this._cart.init()
    }
    this.login = function() {
        this._login = new Login()
        this._login.init()
    }
    this.products = function() {
        this._products = new Products()
        this._products.init()
    }
    this.product = function() {
        this._product = new Product()
        this._product.init()
    }
    this.orders = function() {
        this._orders = new Orders()
        this._orders.init()
    }
    this.order = function() {
        this._order = new Order()
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

        // delete the old content
        switch(router.oldHash) {
            case undefined:
                // do nothing
                // it's important to do not interference with index route that is the default route
                break
            case '#login':
                router._login.destroy()
                break;
            case '#cart':
                router._cart.destroy()
                break;
            case '#products':
                router._products.destroy()
                break;
            case '#orders':
                router._orders.destroy()
                break;
            default:
                if (router.oldHash.match('(#product\/[1-9]+[0-9]*\/edit)|(#product)')) {
                    router._product.destroy()
                } else if (router.oldHash.match('(#order\/[1-9]+[0-9]*)')) {
                    router._order.destroy()
                } else {
                    router._index.destroy()
                }
                break;
        }

        // create the new content on actual page
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
        // updating the old hash to use it next time when the hash changes
        router.oldHash = window.location.hash
    }
    window.onhashchange();
});
