@extends('layouts.html')

@section('headContent')
    <!-- Load the jQuery JS library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

    <meta name="_token" content="{{ csrf_token() }}">

    <script src="http://127.0.0.1:8000/js/spa.js"></script>

@endsection

@section('bodyContent')
    <!-- The index page -->
    <div class="page index">
        <!-- The index element where the products list is rendered -->
        <table class="list"><tbody></tbody></table>

        <!-- A link to go to the cart by changing the hash -->
        <a href="#cart" class="button">Go to cart</a>
    </div>

    <!-- The cart page -->
    <div class="page cart">
        <!-- The cart element where the products list is rendered -->
        <table class="list"></table>

        <!-- A link to go to the index by changing the hash -->
        <a href="#" class="button">Go to index</a>

        <button name="submitOrder">Checkout</button>
    </div>

    {{--    The prduct page--}}
    <div class="page product">
        {{--        Show the products list--}}
        <table class="list"></table>

        {{--        Add new product--}}
        <button name="addProductToDB" onclick="new Products().addProduct()">Add</button>

        <button name="logoutButton" onclick="">Logout</button>
    </div>

    <div class="page productForm">
        Products Form
    </div>

    {{--    The login page--}}
    <div class="page login">
        <table class="list"></table>
    </div>

    {{--    The orders page--}}
    <div class="page orders">
        <table class="list">
            <tbody>

            </tbody>
        </table>
    </div>


    {{--        Show one order--}}
    <div class="page order">

    </div>

@endsection
