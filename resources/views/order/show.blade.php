@extends('layouts.html')

@section('bodyContent')
    <table>
        <tbody>
            @foreach ($order->products as $product)
                <tr>
                    <td>
                        <img
                            src="{{ asset('/storage/images/' . $product['image_path']) }}"
                            alt="{{ __('The image could not be loaded') }}"
                        ><br>
                    </td>
                    <td>
                        {{ $product->title }}<br>
                        {{ $product->description }}<br>
                        {{ $product->price * $product->pivot->quantity }} {{ __('euro') }}<br>
                    </td>
                </tr>
            @endforeach
            <tr>
                <td>
                    {{ __('Created at:') . $order->created_at }}
                </td>
            </tr>
            <tr>
                <td>
                    {{ __('Client name:') . $order->name }}
                </td>
            </tr>
            <tr>
                <td>
                    {{ __('Address: ') . $order->address }}
                </td>
            </tr>
            <tr>
                <td>
                    {{ __('Comments: ') . $order->comments }}
                </td>
            </tr>
        </tbody>
    </table>
@endsection
