<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>Index Page</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
</head>
<body>
<table>
    <tbody>
        @for ($i = 0; $i < count($productsList); $i++)
            <tr>
                <td>
                    <img src="{{ $productsList[$i]['image_path'] }}" alt="{{ __('The image could not be loaded') }}"><br>
                </td>
                <td>
                    {{ $productsList[$i]['title'] }}<br>
                    {{ $productsList[$i]['description'] }}<br>
                    {{ $productsList[$i]['price'] }} {{ __('euro') }}<br>
                    {{ $productsList[$i]['inventory'] - ((isset($myCart[$productsList[$i]['id']]))
                        ? $myCart[$productsList[$i]['id']]
                        : 0) }} {{ __('left') }}<br>
                </td>
                <td>
                    <form method="post" action="{{ route('removeFromCart', ['product' => $productsList[$i]['id']]) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="linkButton"> {{ __('Remove') }} </button>
                    </form>
                </td>
            </tr>
        @endfor
        <form action="{{ route('cart') }}" method="POST">
            @csrf
            <tr>
                <td>
                    <input
                        class="inputType"
                        type="text"
                        name="nameField"
                        placeholder="{{ __('Name') }}"
                        value="{{ old('nameField') }}"
                    >
                    {{ old('nameField') }}
                    <span class="errorField">
<!--                            --><?//= isset($inputErrors['nameFieldError'])
//                            ? '* ' . __($inputErrors['nameFieldError'])
//                            : '' ?>
                        </span>
                </td>
            </tr>
            <tr>
                <td>
                    <input
                        class="inputType"
                        type="text"
                        name="addressField"
                        placeholder="{{ __('Contact deatails') }}"
                        {{--value="<?= $inputData['addressField'] ?>"--}}
                    >
                    <span class="errorField">
<!--                                    --><?//= isset($inputErrors['addressFieldError'])
//                            ? '* ' . __($inputErrors['addressFieldError'])
//                            : '' ?>
                                </span>
                </td>
            </tr>
            <tr>
                <td>
                            <textarea
                                id="commentsSection"
                                class="inputType"
                                type="text"
                                name="commentsField"
                                {{--placeholder="{{ old('commentsField') }}"--}}
                            >

                            </textarea>
                    <!--                                --><?//= $inputData['commentsField'] ?>
                </td>
            </tr>
            <tr>
                <td>
                    <a href="{{ route('index') }}">{{ __('Go to index') }}</a>
                    <input type="submit" name="Checkout">
                </td>
            </tr>
        </form>
    </tbody>
</table>
</body>
</html>
