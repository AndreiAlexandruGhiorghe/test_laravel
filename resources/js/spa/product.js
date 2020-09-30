function Product () {
    this.id
    this.submitForm = function () {
        var form = $('form')[0]; // You need to use standard javascript object here
        var formData = new FormData(form);
        var ajaxParams
        if (this.id) {
            // edit page configuration
            ajaxParams = {url: route('product.update', [this.id]), 'type': 'POST'}
        } else {
            // add page configuration
            ajaxParams = {url: route('product.store'), 'type': 'POST'}
        }

        $.ajax(ajaxParams['url'], {
            dataType: 'json',
            type: ajaxParams['type'],
            contentType: false,
            cache: false,
            processData:false,
            headers: {
                'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            },
            data: formData,
            success: function (response) {
                window.location.hash = '#products'
            },
            error: function (error) {
                $('.productForm table span').remove();
                if (error.responseJSON.errors !== undefined) {
                    if (error.responseJSON.errors.title !== undefined) {
                        $('.productForm  [name="title"]')
                            .after(`<span class="errorSpan">${error.responseJSON.errors.title[0]}</span>`);
                    }

                    if (error.responseJSON.errors.description !== undefined) {
                        $('.productForm  [name="description"]')
                            .after(`<span class="errorSpan">${error.responseJSON.errors.description}</span>`);
                    }

                    if (error.responseJSON.errors.price !== undefined) {
                        $('.productForm  [name="price"]')
                            .after(`<span class="errorSpan">${error.responseJSON.errors.price}</span>`);
                    }

                    if (error.responseJSON.errors.inventory !== undefined) {
                        $('.productForm  [name="inventory"]')
                            .after(`<span class="errorSpan">${error.responseJSON.errors.inventory}</span>`);
                    }
                }
            }
        });
    }
    this.renderProductForm = function (params = {}) {
        var addPage = (!this.id)
        var html = ``;
        html =
            `<form>
            <table><tbody>
            ${addPage
                ? ''
                : '<tr><td><input type="hidden" name="_method" value="PUT"></td></tr>'}
            <tr><td>
            <input
            type="text"
            name="title"
            placeholder="${translate('Title')}"
            >
            </td></tr>
            <tr><td>
            <input
            type="text"
            name="description"
            placeholder="${translate('Description')}"
            >
            </td></tr>
            <tr><td>
            <input
            type="text"
            name="price"
            placeholder="${translate('Price')}"
            >
            </td></tr>
            <tr><td>
            <input
            type="text"
            name="inventory"
            placeholder="${translate('Number of products')}"
            >
            </td></tr>
            <tr><td>
            <label for="inputFileId" id="labelId" name="imageName">
            ${translate('Choose an Image: Click Here!')}
            </label>
            <input onchange="changeLabel()" type="file" id="inputFileId" style="display:none" name="file">
            </td></tr>
            <tr><td>
            <a href="#products">
            ${translate('Products')}
            </a>
            </td><td>
            <input type="submit" value="${translate('Save')}">
            </td></tr>
            </tr></td>
            </tbody></table>
            </form>`

        return html;
    }
    this.init = function () {
        $('.productForm').show()
        if (window.location.hash === '#product/') {
            // add page
            this.id = undefined
            $('.page.productForm').html(this.renderProductForm())
            $('.productForm form input[type="submit"]').on('click', (e) => {
                e.preventDefault()
                this.submitForm()
            })
        } else {
            // edit page
            this.id = window.location.hash.split('/')[1]
            $.ajax('/' + window.location.hash.slice(1), {
                dataType: 'json',
                type: 'GET',
                success: (response) => {
                    $('.page.productForm').html(this.renderProductForm(response.data))
                    $('.page.productForm form input[name="title"]').val(response.data.product.title)
                    $('.page.productForm form input[name="description"]').val(response.data.product.description)
                    $('.page.productForm form input[name="price"]').val(response.data.product.price)
                    $('.page.productForm form input[name="inventory"]').val(response.data.product.inventory)
                    $('.page.productForm form label').html(response.data.product.image_path)
                },
                error: (error) => {
                    if (error.status === 401) {
                        setCookie('oldRoute', document.location.hash, 1)
                        window.location.hash = '#login'
                    }
                }
            }).then(() => {
                $('.productForm form input[type="submit"]').on('click', (e) => {
                    e.preventDefault()
                    this.submitForm()
                })
            })
        }
    }
    this.destroy = () => {
        $('.page.productForm').empty()
        delete router._product
    }
}
