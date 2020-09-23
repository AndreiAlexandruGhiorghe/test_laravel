function Cart() {
    this.removeFunction = function (idProduct) {
        $.ajax('/cart/' + idProduct, {
            dataType: 'json',
            type: 'DELETE',
            headers: {
                'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            },
            success: (response) => {
                $('.cart .list').empty()
                // Render the products in the cart list
                $('.cart .list').html(this.renderCartList(response));
            }
        });
    }
    this.renderCartList = function (params) {
        var html='';
        $.each(params['products'], function (key, product) {
            html += [
                '<tr>',
                '<td>',
                '<img src="/storage/images/' + product.image_path + '" class="phoneImage">',
                '</td>',
                '<td>',
                product.title + '<br>',
                product.description + '<br>',
                product.price + ' ' + translate('euro') + '<br>',
                (params['myCart'].hasOwnProperty(product.id)
                    ? params['myCart'][product.id]
                    : 0) + ' '+ translate('in cart') + '<br>',
                '<td>' +
                '<button onclick="new Cart().removeFunction('+ product.id +')">' + translate('Remove') +'</button>'+
                '</td>',
                '</tr>'
            ].join('');
        });

        html += [
            '<tr><td>Name:',
            '<input type="text" name="nameField" value="">',
            '</td></tr>',
            '<tr><td>Address:',
            '<input type="text" name="addressField" value="">',
            '</td></tr>',
            '<tr><td>Comments:',
            '<textarea type="text" name="commentsField" value=""></textarea>',
            '</td></tr>',
        ].join('');

        return html;
    }
    this.submitOrder = function () {
        let name = $('.cart [name="nameField"]')[0].value;
        let address = $('.cart [name="addressField"]')[0].value;
        let comments = $('.cart [name="commentsField"]')[0].value;
        $.ajax('/cart',{
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
                    $('.cart .list [name="nameField"]').after('<span style="color: red">'
                        + request.responseJSON.errors.nameField
                        + '</span>');
                }
                if (request.responseJSON.errors.addressField) {
                    $('.cart .list [name="addressField"]').after('<span style="color: red">'
                        + request.responseJSON.errors.nameField
                        + '</span>');
                }
            }
        });
    }
    this.init = function () {
        // Show the cart page
        $('.cart').show();
        // Load the cart products from the server
        $.ajax('/cart', {
            dataType: 'json',
            success:  (response) => {
                // Render the products in the cart list
                $('.cart .list').html(this.renderCartList(response));

                // add the checkout button
                $('.cart [name="submitOrder"]')
                    .attr('onclick', 'new Cart().submitOrder()')
                    .text(translate('Checkout'));
            }
        });
    }
}

