<?php
/*
Author: Javed Ur Rehman
Website: https://www.allphptricks.com
*/
require_once '../config.php';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body>
    <input type='hidden' id='publishable_key' value='<?php echo STRIPE_PUBLISHABLE_KEY; ?>'>

    <div class="w-full flex-col flex h-screen flex justify-center items-center">
        <div class="w-full h-full flex flex-col items-center relative">
            <header class="w-full h-[80px] flex justify-center items-center border-b border-[#6d6d6d] fixed backdrop-blur supports-backdrop-blur:bg-white/95">
                <img src="../assets/logo.svg" class="w-[165px] max-w-[165px] z-50" alt="">
            </header>
            <div class="w-full h-1/2 bg-no-repeat bg-cover bg-center justify-center items-center" style="background-image: url('../assets/checkout.jpeg')">
                <div class="flex flex-col w-full flex justify-start items-center h-screen px-4">
                    <div id="order_form" class="flex flex-col gap-4 justify-center items-center mt-48">
                        <h1 class="uppercase md:text-[37px] text-2xl font-black text-white">Book Your Ride</h1>
                        <span class="text-white md:text-3xl text-xl">Explore Rhodes • Checkout</span>
                    </div>
                    <div id="checkout" class="md:w-[560px] w-full md:p-[30px] p-4 rounded-[16px] bg-white border flex flex-col gap-3 mt-4" style="box-shadow: 0 12px 30px rgba(0, 0, 0, 0.05);"></div>
                </div>
            </div>
            <div id="stripe_payment" class="max-w-2xl w-full hidden absolute top-1/4 -translate-t-1/4">
                <form action="" id="stripe-payment-form" class=" w-full flex flex-col gap-4 justify-center items-center bg-white py-4 px-5 rounded-md" id="stripe-payment-form">
                    <div id="stripe-payment-element" class="w-full"></div>
                    <div class="flex gap-4">
                        <button id="submit-button" class="text-white bg-[#5fe4b2] text-[15px] uppercase py-2 rounded hover:bg-[#48d1a1] transition duration-300 px-4">Pay Now!</button>
                        <button id="cancel-button" class="text-white bg-gray-600 text-[15px] uppercase py-2 rounded hover:bg-gray-500 transition duration-300 px-4">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>

<script src="https://js.stripe.com/v3/"></script>

<script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="../src/cookie.js"></script>
<script src="../src/stripe.js"></script>
<script src="../src/checkout.js"></script>

</html>