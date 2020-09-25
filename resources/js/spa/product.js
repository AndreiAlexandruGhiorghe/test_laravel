function Product () {
    this.id
    this.submitForm = function () {
        if (this.id) {
            // edit page
            var form = $('form')[0]; // You need to use standard javascript object here
            var formData = new FormData(form);

            $.ajax('/product/' + this.id, {
                dataType: 'json',
                type: 'PUT',
                contentType: false,
                cache: false,
                processData:false,
                headers: {
                    'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                },
                data: formData,
                success: function (response) {
                    console.log(response)
                    if (response.status === 'success') {
                        window.location.hash = '#products'
                    }
                },
                error: function (message) {
                    $('.productForm table span').remove();
                    if (message.responseJSON.errors !== undefined) {
                        if (message.responseJSON.errors.title !== undefined) {
                            $('.productForm  [name="title"]')
                                .after(`<span class="errorSpan">${message.responseJSON.errors.title[0]}</span>`);
                        }

                        if (message.responseJSON.errors.description !== undefined) {
                            $('.productForm  [name="description"]')
                                .after(`<span class="errorSpan">${message.responseJSON.errors.description}</span>`);
                        }

                        if (message.responseJSON.errors.price !== undefined) {
                            $('.productForm  [name="price"]')
                                .after(`<span class="errorSpan">${message.responseJSON.errors.price}</span>`);
                        }

                        if (message.responseJSON.errors.inventory !== undefined) {
                            $('.productForm  [name="inventory"]')
                                .after(`<span class="errorSpan">${message.responseJSON.errors.inventory}</span>`);
                        }
                    }
                }
            });
        } else {
            // add page
            var form = $('form')[0]; // You need to use standard javascript object here
            var formData = new FormData(form);

            $.ajax('/product', {
                dataType: 'json',
                type: 'POST',
                contentType: false,
                cache: false,
                processData:false,
                headers: {
                    'X-CSRF-Token': $('meta[name="_token"]').attr('content')
                },
                data: formData,
                success: function (response) {
                    if (response.status === 'success') {
                        window.location.hash = '#products'
                    }
                },
                error: function (message) {
                    $('.productForm table span').remove();
                    if (message.responseJSON.errors !== undefined) {
                        if (message.responseJSON.errors.title !== undefined) {
                            $('.productForm  [name="title"]')
                                .after(`<span class="errorSpan">${message.responseJSON.errors.title[0]}</span>`);
                        }

                        if (message.responseJSON.errors.description !== undefined) {
                            $('.productForm  [name="description"]')
                                .after(`<span class="errorSpan">${message.responseJSON.errors.description}</span>`);
                        }

                        if (message.responseJSON.errors.price !== undefined) {
                            $('.productForm  [name="price"]')
                                .after(`<span class="errorSpan">${message.responseJSON.errors.price}</span>`);
                        }

                        if (message.responseJSON.errors.inventory !== undefined) {
                            $('.productForm  [name="inventory"]')
                                .after(`<span class="errorSpan">${message.responseJSON.errors.inventory}</span>`);
                        }
                    }
                }
            });
        }

    }
    this.renderProductForm = function (params = {}) {
        var addPage = (!this.id)
        var html = ``;
        html = [
            `<form>`,
            `<table><tbody>`,
            `<tr><td>`,
            `<input `,
            `type="text" `,
            `name="title" `,
            `placeholder="${translate('Title')}" `,
            `> `,
            `</td></tr>`,
            `<tr><td>`,
            `<input `,
            `type="text" `,
            `name="description" `,
            `placeholder="${translate('Description')}" `,
            `> `,
            `</td></tr>`,
            `<tr><td>`,
            `<input `,
            `type="text" `,
            `name="price" `,
            `placeholder="${translate('Price')}" `,
            `> `,
            `</td></tr>`,
            `<tr><td>`,
            `<input `,
            `type="text" `,
            `name="inventory" `,
            `placeholder="${translate('Number of products')}" `,
            `> `,
            `</td></tr>`,
            `<tr><td>`,
            `<label for="inputFileId" id="labelId" name="imageName"> `,
            `${translate('Choose an Image: Click Here!')}`,
            `</label>`,
            `<input onchange="changeLabel()" type="file" id="inputFileId" style="display:none" name="file"> `,
            `</td></tr>`,
            `<tr><td>`,
            `<a href="#products">`,
            `${translate('Products')}`,
            `</a>`,
            `</td><td>`,
            `<input type="submit" value="${translate('Save')}"> `,
            `</td></tr>`,
            `</tr></td>`,
            `</tbody></table>`,
            `</form>`
        ].join(``)

        return html;
    }
    this.init = function () {
        $('.productForm').show()

        if (window.location.hash === '#product/') {
            // add page
            $('.page.productForm').html(this.renderProductForm())
        } else {
            // edit page
            this.id = window.location.hash.split('/')[1]
            $.ajax('/' + window.location.hash.slice(1), {
                dataType: 'json',
                type: 'GET',
                success: (response) => {
                    $('.page.productForm').html(this.renderProductForm(response))
                    $('.page.productForm form input[name="title"]').val(response.product.title)
                    $('.page.productForm form input[name="description"]').val(response.product.description)
                    $('.page.productForm form input[name="price"]').val(response.product.price)
                    $('.page.productForm form input[name="inventory"]').val(response.product.inventory)
                    $('.page.productForm form label').html(response.product.image_path)
                }
            })
        }
        $('.productForm form input[type="submit"]').on('click', (e) => {
            e.preventDefault()
            this.submitForm()
        })
    }
}
