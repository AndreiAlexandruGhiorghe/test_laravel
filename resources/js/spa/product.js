function Product () {
    this.id
    this.submitOption = function () {
        const optionName = $('#optionForm input[name="optionName"]')[0].value
        $.ajax(route('option.store',[this.id]), {
            dataType: 'json',
            type: 'POST',
            headers: {
                'X-CSRF-Token': $('meta[name="_token"]').attr('content')
            },
            data: {
                optionName
            },
            success: function (response) {
                window.onhashchange()
            },
            error: function (error) {
                $('#optionForm span').remove()
                if (error.status === 400) {
                    $('input[name="optionName"]')
                        .after(`<span class="errorSpan">${translate('The option allready exists')}</span>`);
                } else {
                    if (error.responseJSON.errors.optionName !== undefined) {
                        $('input[name="optionName"]')
                            .after(`<span class="errorSpan">${error.responseJSON.errors.optionName}</span>`);
                    }
                }
            }
        })
    }
    this.submitForm = function () {
        var form = $('form')[0]; // You need to use standard javascript object here
        var formData = new FormData(form);

        var ajaxParams = (this.id)
            ? {url: route('product.update', [this.id]), 'type': 'POST'}
            : {url: route('product.store'), 'type': 'POST'}

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
        html = `<form>
                <table>
                    <tbody>
                        ${addPage
                            ? ''
                            :  `<tr>
                                    <td>
                                        <input type="hidden" name="_method" value="PUT">
                                    </td>
                                </tr>`}
                        <tr>
                            <td>
                                <input
                                type="text"
                                name="title"
                                placeholder="${translate('Title')}"
                                >
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input
                                type="text"
                                name="description"
                                placeholder="${translate('Description')}"
                                >
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input
                                type="text"
                                name="price"
                                placeholder="${translate('Price')}"
                                >
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input
                                type="text"
                                name="inventory"
                                placeholder="${translate('Number of products')}"
                                >
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label for="inputFileId" id="labelId" name="imageName">
                                    ${translate('Choose an Image: Click Here!')}
                                </label>
                                <input
                                onchange="changeLabel()"
                                type="file"
                                id="inputFileId"
                                style="display:none"
                                name="file"
                                >
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <a href="#products">
                                    ${translate('Products')}
                                </a>
                            </td>
                            <td>
                            <input type="submit" value="${translate('Save')}">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>
            ${(addPage)
                ? ''
                :`${params.options.map((option) => `<td>${option.name}</td>`).join('<br>')}
            <form id="optionForm">
                <table>
                    <tbody>
                        <tr>
                            <td>
                                <p>Title</p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="text" name="optionName">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <input type="submit" name="submitOption">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </form>`}`

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
                    $('.page.productForm form input[name="title"]').val(response.data.title)
                    $('.page.productForm form input[name="description"]').val(response.data.description)
                    $('.page.productForm form input[name="price"]').val(response.data.price)
                    $('.page.productForm form input[name="inventory"]').val(response.data.inventory)
                    $('.page.productForm form label').html(response.data.image_path)
                },
                error: (error) => {
                    if (error.status === 401) {
                        setCookie('oldRoute', document.location.hash, 1)
                        window.location.hash = '#login'
                    }
                }
            }).then(() => {
                $('.productForm form:first-child input[type="submit"]').on('click', (e) => {
                    e.preventDefault()
                    this.submitForm()
                })

                $('#optionForm input[type="submit"]').on('click', (e) => {
                    e.preventDefault()
                    router._product.submitOption()
                })
            })
        }
    }
    this.destroy = () => {
        $('.page.productForm').empty()
        delete router._product
    }
}
