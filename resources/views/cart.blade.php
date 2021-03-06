@extends ('layouts.html')

@section ('bodyContent')
    <table>
        <tbody>
            @foreach ($productsList as $product)
                <tr>
                    <td>
                        <img
                            src="{{ asset('/storage/images/' . $product['image_path']) }}"
                            alt="{{ __('The image could not be loaded') }}"
                        ><br>
                    </td>
                    <td>
                        {{ $product['title'] }}<br>
                        {{ $product['description'] }}<br>
                        {{ $product['price'] *  $myCart[$product['id']]}} {{ __('euro') }}<br>
                        {{ ((isset($myCart[$product['id']])) ? $myCart[$product['id']] : 0) }} {{ __('in cart') }}<br>
                    </td>
                    <td>
                        <form method="post" action="{{ route('cart.destroy', ['product' => $product['id']]) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="linkButton"> {{ __('Remove') }} </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            <form action="{{ route('cart.store') }}" method="POST">
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
                        @error('nameField')
                            <span class="error">
                                {{ $errors->first('nameField') }}
                            </span>
                        @enderror
                    </td>
                </tr>
                <tr>
                    <td>
                        <input
                            class="inputType"
                            type="text"
                            name="addressField"
                            placeholder="{{ __('Contact deatails') }}"
                            value="{{ old('addressField') }}"
                        >
                        @error('addressField')
                            <span class="error">
                                    {{ $errors->first('addressField') }}
                            </span>
                        @enderror
                    </td>
                </tr>
                <tr>
                    <td>
                        <textarea
                            id="commentsSection"
                            class="inputType"
                            type="text"
                            name="commentsField"
                            placeholder="{{ old('commentsField') }}"
                        >
                        </textarea>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a href="{{ route('index.index') }}">{{ __('Go to index') }}</a>
                        <input type="submit" name="Checkout" value="Checkout">
                    </td>
                </tr>
            </form>
        </tbody>
    </table>
@endsection
