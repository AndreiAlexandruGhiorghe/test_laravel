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
            {{--if I dont have an id it means that I am on the add page--}}
            <form
                action="{{ (!isset($id)) ? route('product.store') : route('product.update', [$id]) }}"
                method="POST"
                enctype="multipart/form-data"
            >
                @csrf
                {{--if there is some id it means that I am on the edit page--}}
                @if (isset($id))
                    @method('PUT')
                @endif
                <tr>
                    <td>
                        <input
                            type="text"
                            name="title"
                            placeholder="{{ __('Title') }}"
                            value="{{ (old('title') != null)
                                        ? old('title')
                                        : ((!isset($product->title)) ? '': $product->title ) }}"
                        >
                        @error('title')
                        <span class="error">
                                        {{ $errors->first('title') }}
                                    </span>
                        @enderror
                    </td>
                </tr>
                <tr>
                    <td>
                        <input
                            type="text"
                            name="description"
                            placeholder="{{ __('Description') }}"
                            value="{{ (old('description') != null)
                                        ? old('description')
                                        : ((!isset($product->description)) ? '' : $product->description ) }}"
                        >
                        @error('description')
                        <span class="error">
                                        {{ $errors->first('description') }}
                                    </span>
                        @enderror
                    </td>
                </tr>
                <tr>
                    <td>
                        <input
                            type="text"
                            name="price"
                            placeholder="{{ __('Price') }}"
                            value="{{ (old('price') != null)
                                        ? old('price')
                                        : ((!isset($product->price)) ? '' : $product->price ) }}"
                        >
                        @error('price')
                        <span class="error">
                                        {{ $errors->first('price') }}
                                    </span>
                        @enderror
                    </td>
                </tr>
                <tr>
                    <td>
                        <input
                            type="text"
                            name="inventory"
                            placeholder="{{ __('Number of products') }}"
                            value="{{ (old('inventory') != null)
                                        ? old('inventory')
                                        : ((!isset($product->inventory)) ? '' : $product->inventory ) }}"
                        >
                        @error('inventory')
                        <span class="error">
                                        {{ $errors->first('inventory') }}
                                    </span>
                        @enderror
                    </td>
                </tr>
                <tr>
                    <td>
                        <label for="inputFileId" id="labelId" name="imageName">
                            {{ (old('imageName') != null)
                                ? old('imageName')
                                : ((!isset($product->image_path))
                                    ? __('Choose an Image: Click Here!')
                                    : $product->image_path ) }}
                        </label>
                        <input onchange="changeLabel()" type="file" id="inputFileId" style="display:none" name="file">
                        @if (isset($id))
                            @error('file')
                            <span class="error">
                                            {{ $errors->first('file') }}
                                        </span>
                            @enderror
                        @else
                            @error('imageName')
                            <span class="error">
                                            {{ $errors->first('imageName') }}
                                        </span>
                            @enderror
                        @endif
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
