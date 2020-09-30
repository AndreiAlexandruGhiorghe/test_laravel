function Products () {
    this.delete = function (id) {
        $.ajax(route('product.destroy', [id]), {
            dataType: 'json',
            type: 'DELETE',
            headers: {
                'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            },
            success: function (response) {
                    window.onhashchange()
            }
        });
    }
    this.renderProductList = function (params) {
        var html=``;

        $.each(params, function (key, product) {
            html +=
                `<tr>
                <td>
                <img src="/storage/images/${product.image_path}" class="phoneImage">
                </td>
                <td>
                ${product.title}<br>
                ${product.description}<br>
                ${product.price} ${translate('euro')}<br>
                ${product.inventory} ${translate('left')}<br>
                <td>
                <a href="#product/${product.id}/edit">${translate('Edit')}</a>
                </td>
                <td>
                <button onclick="router._products.delete(${product.id})">${translate('Delete')}</button>
                </td>
                </tr>`
        });

        return html;
    }
    this.init = function () {
        // Show the Products page
        $('.product').show();
        // Load the cart products from the server
        $.ajax(route('product.index'), {
            dataType: 'json',
            success: (response) => {
                // Render the products in the cart list
                $('.product .list').html(this.renderProductList(response.data));
            },
            error: (error) => {
                if (error.status === 401) {
                    setCookie('oldRoute', document.location.hash, 1)
                    window.location.hash = '#login'
                }
            }
        });
    }
    this.destroy = () => {
        $('.product .list').empty()
        delete router._products
    }
}
