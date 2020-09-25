function Products () {
    this.delete = function (id) {
        $.ajax('/product/' + id, {
            dataType: 'json',
            type: 'DELETE',
            headers: {
                'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            },
            success: function (response) {
                if (response.status == 'success') {
                    window.onhashchange()
                }
            }
        });
    }
    this.logout = function () {
        $.ajax('/login/signout', {
            datatype: 'json',
            type: 'DELETE',
            headers: {
                'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            },
            success: (response) => {
                window.onhashchange()
            }
        })
    }
    this.renderProductList = function (params) {
        var html='';

        $.each(params, function (key, product) {
            html += [
                '<tr>',
                '<td>',
                '<img src="/storage/images/' + product.image_path + '" class="phoneImage">',
                '</td>',
                '<td>',
                product.title + '<br>',
                product.description + '<br>',
                product.price + translate('euro') + '<br>',
                product.inventory + translate('left') + '<br>',
                '<td>',
                '<a href="#product/'+ product.id +'/edit">' + translate('Edit') +'</a>',
                '</td>',
                '<td>',
                '<button onclick="router._products.delete('+ product.id +')">' + translate('Delete') + '</button>',
                '</td>',
                '</tr>'
            ].join('');
        });

        return html;
    }
    this.init = function () {
        // Show the Products page
        $('.product').show();
        // Load the cart products from the server
        $.ajax('/product', {
            dataType: 'json',
            success: (response) => {
                if (response.hasOwnProperty('redirect')) {
                    window.location.hash = response.redirect;
                } else {
                    // Render the products in the cart list
                    $('.product .list').html(this.renderProductList(response));
                }
            }
        });
    }
}
