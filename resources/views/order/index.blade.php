@extends('layouts.html')
@section('bodyContent')
    @foreach ($priceOfOrder as $orderId => $totalPrice)
        <table>
            <tbody>
                <tr>
                    <td>
                        {{ $totalPrice . __(' euro') }}
                    </td>
                </tr>
                <tr>
                    <td>
                        <a href="{{ route('order.show', $orderId) }}">
                            {{ __('See order') }}
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
    @endforeach
@endsection
