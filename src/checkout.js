const API_URL = "../src/api"
// const stripe = Stripe('pk_live_51REpT8JjtMIzG2BkPrnSZLE5uA19oYV1D9h9cT1uJINFwdR9hJuZwJdzHyKY9HhRpkTtgbGhMlTwNKa6IqVpdtFy00otWvzu3S');

// Init Function
Get_Order_Data();

// Get Order Data Function
function Get_Order_Data() {
    var orderData = JSON.parse(getCookie('book'));
    temp = `
        <div class="w-full md:p-[30px] p-2 border">
            <table class="w-full text-sm text-left text-gray-900">
                <thead class="text-gray-500 font-semibold space-y-4">
                    <tr>
                        <th class="pb-2">Product</th>
                        <th class="pb-2 text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody class="space-y-4">
                    <tr>
                        <td class="pb-2">Excursion Booking × 1</td>
                        <td class="pb-2 text-right">${orderData.totalPrice}</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="py-2">
                            <div class="space-y-2">
                                <div><span class="font-semibold">Hotel:</span> ${orderData.tripName} </div>
                                <div><span class="font-semibold">Date:</span> ${orderData.selectedDate}</div>
                                <div><span class="font-semibold">Pickup Time:</span> ${orderData.pickTime}</div>
                                <div><span class="font-semibold">Return Time:</span> ${orderData.returnTime}</div>
                                <div><span class="font-semibold">Adults:</span> ${orderData.adultCount}</div>
                                <div><span class="font-semibold">Children:</span> ${orderData.childrenCount}</div>
                                <div><span class="font-semibold">Infants:</span> ${orderData.infantCount}</div>
                                <div><span class="font-semibold">Total Price:</span> ${orderData.totalPrice}</div>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td class="pt-4 font-semibold text-gray-500">Subtotal</td>
                        <td class="pt-4 text-right text-gray-500">${orderData.totalPrice}</td>
                    </tr>
                    <tr>
                        <td class="pt-2 font-bold">Total</td>
                        <td class="pt-2 text-right font-bold">${orderData.totalPrice}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="w-full flex flex-col justify-start items-start gap-4">
            <button id="checkout-button" class="w-full text-white bg-[#5fe4b2] text-[18px] uppercase py-2 rounded hover:bg-[#48d1a1] font-bold transition duration-300" onclick="placeOrder()" >Place Order</button>
        </div>
    `;

    $('#checkout').html(temp);
}

// Add Order Data Function
function Add_Order_Data() {
    var bookingData = JSON.parse(getCookie('book'));

    axios.post(`${API_URL}/order/add_order.php`, {
        tripID: bookingData.tripID,
        date: bookingData.selectedDate,
        pickTime: bookingData.pickTime,
        returnTime: bookingData.returnTime,
        adultNumber: bookingData.adultCount,
        childNumber: bookingData.childrenCount,
        infantNumber: bookingData.infantCount,
        fullName: bookingData.fullname,
        email: bookingData.email,
        phoneNumber: bookingData.phoneNumber,
        roomNumber: bookingData.roomNumber,
        totalPrice: bookingData.totalPrice
    }).then(function (response) {
        if (response.data.status === 'success') {
            SuccessAlert('Order completed!');
            // window.location.href = "success.php";
        } else {
            ErrorAlert(response.data.message);
        }
    }).catch(function (error) {
        console.error(error);
        ErrorAlert('Server Error!');
    });
}

async function placeOrder() {
    $('#order_form').hide();
    $('#checkout').hide();
    $('#stripe_payment').show();
}

// function payNow(totalAmount) {
//     alert(3);
//     axios.post(`${API_URL}/checkout/create_checkout_session.php`, {
//         amount: totalAmount
//     }).then(function (response) {
//         return stripe.redirectToCheckout({
//             sessionId: response.data.id
//         });
//     }).then(function (result) {
//         if (result.error) {
//             alert(result.error.message);
//         }
//     }).catch(function (error) {
//         console.error('Error:', error);
//         alert('Server Error!');
//     });
// }


// Error Message

function ErrorAlert(content) {
    Swal.fire({
        title: 'Error!',
        text: content,
        icon: 'error',
        confirmButtonText: 'OK'
    });
}

// Success Message
function SuccessAlert(content) {
    Swal.fire({
        title: "Success!",
        text: content,
        icon: 'success',
        confirmButtonText: 'OK'
    })
}

$('#cancel-button').click(function () { 
    $('#stripe_payment').hide();
    $('#order_form').show();
    $('#checkout').show();
})