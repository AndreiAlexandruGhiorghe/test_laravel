function Index() {
    this.addFunction = function(idProduct) {
        var data = {}
        $.each($(`tr.${idProduct} select`), function(key, element){
            var aux = element.options[element.selectedIndex].getAttribute('name')
            // data['options'] = {}
            data[element.name] = aux
        })
        $.ajax(route('index.update', [idProduct]), {
            dataType: 'json',
            type: 'PUT',
            headers: {
                'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            },
            data: data,
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
                ? params.myCart[product.id]
                : 0) > 0) {
                html +=
                    `<tr class="${product.id}">
                    <td>
                    <img src="/storage/images/${product.image_path}" class="phoneImage">
                    </td>
                    <td>
                    ${product.title}<br>
                    ${product.description}<br>
                    ${product.price} euro<br>
                    ${product.inventory - (params.myCart.hasOwnProperty(product.id)
                        ? params.myCart[product.id]
                        : 0)} left<br>
                    <td>
                    ${product.options.map((option, i) => `
                    <td>
                    <label for="cars">${option.title}</label>
                    <select name="${option.id}">
                    ${option.contents.map((optionContent, i) => `
                    <option name="${optionContent.id}" value="${optionContent.id}">${optionContent.content}</option>
                    `.trim()).join('')}
                    </select>
                    </td>
                    `.trim()).join('')}
                    </td>
                    <td>
                    <button onclick="router._index.addFunction(${product.id})">Add</button>
                    </td>
                    </tr>`
            }
        })

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
            },
            error: (error) => {
                console.log(error)
            }
        });
    }
    this.destroy = () => {
        $('.index .list tbody').empty()
        delete router._index
    }
}
