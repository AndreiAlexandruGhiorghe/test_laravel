function Index() {
    this.addFunction = function(idProduct) {
        $.ajax('/index/' + idProduct, {
            dataType: 'json',
            type: 'PUT',
            headers: {
                'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            },
            success: (response) => {
                // Render the products in the cart list
                $('.index .list').html(this.renderIndexList(response));
            }
        });
    }
    this.renderIndexList = function(params) {
        var html='';
        $.each(params['products'], function (key, product) {
            if (product.inventory - (params['myCart'].hasOwnProperty(product.id)
                ? params['myCart'][product.id]
                : 0) > 0) {
                html += [
                    '<tr>',
                    '<td>',
                    '<img src="/storage/images/' + product.image_path + '" class="phoneImage">',
                    '</td>',
                    '<td>',
                    product.title + '<br>',
                    product.description + '<br>',
                    product.price + 'euro<br>',
                    product.inventory - (params['myCart'].hasOwnProperty(product.id)
                        ? params['myCart'][product.id]
                        : 0) + 'left<br>',
                    '<td>',
                    '<button onclick="router._index.addFunction('+ product.id +')">Add</button>',
                    '</td>',
                    '</tr>'
                ].join('');
            }
        });

        return html;
    }
    this.init = function () {
        // Show the index page
        $('.index').show();
        // Load the index products from the server
        $.ajax('/index', {
            dataType: 'json',
            success: (response) => {
                // Render the products in the index list
                $('.index .list tbody').html(this.renderIndexList(response));
                // update the local cart
                myCart = response['myCart'];
            }
        });
    }
}
