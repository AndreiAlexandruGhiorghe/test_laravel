<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Products Page</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <script>
        // I need this function when I want to save the name of the image
        // and tha function it changes the default value of the label to
        // the actual value of the input file
        function changeLabel() {
            var asta = document.getElementById('inputFileId').value;
            var aux = asta.split('\\')[asta.split('\\').length - 1];
            document.getElementById('labelId').innerText = aux;
        }
    </script>
</head>
<body onload="LoadValue();">
    <table id="contentTable">
        <tbody>
        <form
            action="{{ ($id == 0) ? route('product.store') : route('product.update', [$id]) }}"
            method="POST"
            enctype="multipart/form-data">
            @csrf
            @if ($id > 0)
                @method('PUT')
            @endif
            <tr>
                <td>
                    <input
                        type="text"
                        name="titleField"
                        placeholder="{{ __('Title') }}"
                        value="{{ (old('titleField') != null)
                            ? old('titleField')
                            : ((!isset($product->title)) ? '': $product->title ) }}"
                    >
                    @error('titleField')
                        <span style="color: red;">
                            {{ $errors->first('titleField') }}
                        </span>
                    @enderror
                </td>
            </tr>
            <tr>
                <td>
                    <input
                        type="text"
                        name="descriptionField"
                        placeholder="{{ __('Description') }}"
                        value="{{ (old('descriptionField') != null)
                            ? old('descriptionField')
                            : ((!isset($product->description)) ? '' : $product->description ) }}"
                    >
                    @error('descriptionField')
                        <span style="color: red;">
                            {{ $errors->first('descriptionField') }}
                        </span>
                    @enderror
                </td>
            </tr>
            <tr>
                <td>
                    <input
                        type="text"
                        name="priceField"
                        placeholder="{{ __('Price') }}"
                        value="{{ (old('priceField') != null)
                            ? old('priceField')
                            : ((!isset($product->price)) ? '' : $product->price ) }}"
                    >
                    @error('priceField')
                        <span style="color: red;">
                            {{ $errors->first('priceField') }}
                        </span>
                    @enderror
                </td>
            </tr>
            <tr>
                <td>
                    <input
                        type="text"
                        name="inventoryField"
                        placeholder="{{ __('Number of products') }}"
                        value="{{ (old('inventoryField') != null)
                            ? old('inventoryField')
                            : ((!isset($product->inventory)) ? '' : $product->inventory ) }}"
                    >
                    @error('inventoryField')
                        <span style="color: red;">
                            {{ $errors->first('inventoryField') }}
                        </span>
                    @enderror
                </td>
            </tr>
            <tr>
                <td>
                    <label for="inputFileId" id="labelId" name="labelId">
                        {{ (old('imageNameField') != null)
                            ? old('imageNameField')
                            : ((!isset($product->image_path))
                                ? __('Choose an Image: Click Here!')
                                : $product->image_path ) }}
                    </label>
                    <input onchange="changeLabel()" type="file" id="inputFileId" style="display:none" name="fileField">
                    @error('imageNameField')
                        <span style="color: red;">
                            {{ $errors->find('imageNameField') }}
                        </span>
                    @enderror
                </td>
            </tr>
            <tr>
                <td>
                    <a href="{{ route('product.index') }}">
                        {{ __('Products')}}
                    </a>
                </td>
                <td>
                    <button type="submit" name="submitButton">
                        {{ __('Save') }}
                    </button>
                </td>
            </tr>
        </form>
        </tbody>
    </table>
</body>
</html>
