function Cart() {
    this.removeFunction = function (idProduct) {
        $.ajax(route('cart.destroy',[idProduct]), {
            dataType: 'json',
            type: 'DELETE',
            headers: {
                'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            },
            success: (response) => {
                window.onhashchange()
            }
        });
    }
    this.renderCartList = function (params) {
        var html=``;
        $.each(params['products'], function (key, product) {
            html +=
                `<tr>
                <td>
                <img src="/storage/images/${product.image_path}" class="phoneImage">
                </td>
                <td>
                ${product.title}<br>
                ${product.description}<br>
                ${product.price} ${translate('euro')}<br>
                ${(params['myCart'].hasOwnProperty(product.id)
                    ? params['myCart'][product.id]
                    : 0)} ${translate('in cart')}<br>
                <td>
                <button onclick="router._cart.removeFunction(${product.id})">${translate('Remove')}</button>
                </td>
                </tr>`
        });

        html +=
            `<tr><td>Name:
            <input type="text" name="nameField" value="">
            </td></tr>
            <tr><td>Address:
            <input type="text" name="addressField" value="">
            </td></tr>
            <tr><td>Comments:
            <textarea type="text" name="commentsField" value=""></textarea>
            </td></tr>`

        return html;
    }
    this.submitOrder = function () {
        let name = $('.cart [name="nameField"]')[0].value;
        let address = $('.cart [name="addressField"]')[0].value;
        let comments = $('.cart [name="commentsField"]')[0].value;
        $.ajax(route('cart.store'), {
            dataType: 'json',
            type: 'POST',
            headers: {
                'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            },
            data: {
                'nameField': name,
                'addressField': address,
                'commentsField': comments,
            },
            success: function (response) {
                window.location.hash = '#';
            },
            error: function (request) {
                $('.cart .list span').remove();
                if (request.responseJSON.errors.nameField !== undefined) {
                    $('.cart .list [name="nameField"]').after(
                        `<span class="errorSpan">
                        ${request.responseJSON.errors.nameField}
                        </span>`
                    );
                }
                if (request.responseJSON.errors.addressField) {
                    $('.cart .list [name="addressField"]').after(
                        `<span class="errorSpan">
                        ${request.responseJSON.errors.nameField}
                        </span>`);
                }
            }
        });
    }
    this.init = function () {
        // Show the cart page
        $('.cart').show();
        // Load the cart products from the server
        $.ajax(route('cart.index'), {
            dataType: 'json',
            success:  (response) => {
                // Render the products in the cart list
                $('.cart .list').html(this.renderCartList(response.data));
                // add the checkout button
                $('.cart [name="submitOrder"]')
                    .attr(`onclick`, `router._cart.submitOrder()`)
                    .text(translate(`Checkout`));
            }
        });
    }
    this.destroy = () => {
        $('.cart .list').empty()
        delete router._cart
    }
}

