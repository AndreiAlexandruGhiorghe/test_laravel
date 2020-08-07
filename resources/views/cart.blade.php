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
                    <form method="post" action="{{ route('cart') }}">
                        @csrf
                        <input type="hidden" name="idProduct" value="{{ $productsList[$i]['id'] }}">
                        <button type="submit" class="linkButton"> {{ __('Remove') }} </button>
                    </form>
                </td>
            </tr>
        @endfor
        <form action="{{ route('cart') }}" method="POST">
            <tr>
                <td>
                    <input
                        class="inputType"
                        type="text"
                        name="nameField"
                        placeholder="<?= translate('Name') ?>"
                        value="<?= $inputData['nameField'] ?>"
                    >
                    <span class="errorField">
                            <?= isset($inputErrors['nameFieldError'])
                            ? '* ' . translate($inputErrors['nameFieldError'])
                            : '' ?>
                        </span>
                </td>
            </tr>
            <tr>
                <td>
                    <input
                        class="inputType"
                        type="text"
                        name="addressField"
                        placeholder="<?= translate('Contact deatails') ?>"
                        value="<?= $inputData['addressField'] ?>"
                    >
                    <span class="errorField">
                                    <?= isset($inputErrors['addressFieldError'])
                            ? '* ' . translate($inputErrors['addressFieldError'])
                            : '' ?>
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
                                placeholder="<?= translate('Comments') ?>"
                            >
                                <?= $inputData['commentsField'] ?>
                            </textarea>
                </td>
            </tr>
            <tr>
                <td>
                    <a href="{{ route('index') }}"><?= translate('Go to index') ?></a>
                    <input type="submit" name="submitButton" value="Checkout">
                </td>
            </tr>
        </form>
    </tbody>
</table>
</body>
</html>
