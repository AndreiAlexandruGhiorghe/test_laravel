function Index() {
    this.addFunction = function(idProduct) {
        var aux = $(`select[name="${idProduct}"]`)[0]
        const option = (aux.options.length > 0)
            ? aux.options[aux.selectedIndex].getAttribute('name')
            : 0
        $.ajax(route('index.update', [idProduct]), {
            dataType: 'json',
            type: 'PUT',
            headers: {
                'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            },
            data: {
                option
            },
            success: (response) => {
                // refresh the page
                window.onhashchange();
            }
        });
    }
    this.renderIndexList = function(params) {
        var html=``;
        $.each(params.products, function (key, product) {
            if (product.inventory - (params.myCart.hasOwnProperty(product.id)
                ? countTheProducts(params.myCart[product.id])
                : 0) > 0) {
                html += `<tr>
                        <td>
                            <img src="/storage/images/${product.image_path}" class="phoneImage">
                        </td>
                        <td>
                            ${product.title}<br>
                            ${product.description}<br>
                            ${product.price} euro<br>
                            ${product.inventory - (params.myCart.hasOwnProperty(product.id)
                                ? countTheProducts(params.myCart[product.id])
                                : 0)} left<br>
                        </td>
                        <td>
                        <select name="${product.id}">
                            ${product.options.map((option) => `<option name="${option.id}">
                                                                    ${option.name}
                                                                </option>`).join('')}
                        </select>
                        </td>
                        <td>
                            <button onclick="router._index.addFunction(${product.id})">Add</button>
                        </td>
                    </tr>`
            }
        });

        return html;
    }
    this.init = function () {
        // Show the index page
        $('.index').show();
        // Load the index products from the server
        $.ajax(route('index.index'), {
            dataType: 'json',
            success: (response) => {
                // Render the products in the index list
                $('.index .list tbody').html(this.renderIndexList(response.data));
                // update the local cart
                myCart = response['myCart'];
            }
        });
    }
    this.destroy = () => {
        $('.index .list tbody').empty()
        delete router._index
    }
}
