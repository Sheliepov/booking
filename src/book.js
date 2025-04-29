const API_URL = '../src/api';

// Init Function
loadTrips();        // Load Trips List
Show_Trip_List();   // Show Trip List Function to User

// Load Trips Function
// Get Trip Data Function
function loadTrips() {
    axios.get(`${API_URL}/get_trip.php`).then(function (response) {
        if (response.data.status === 'success') {
            var tempdata = response.data;
            localStorage.setItem("trip", JSON.stringify(tempdata.data));
        } else {
            ErrorAlert('Failed to load trips');
        }
    }).catch(function (error) {
        console.error(error);
    });
}

// Order JS
function Show_Trip_List() {

    var triplist = JSON.parse(localStorage.getItem("trip"));
    var temp = ``;

    if (triplist != undefined) {
        temp += `
            <select id="selectedItem" id="selecteddefault" class="border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 outline-none focus:shadow-[0_0_3px_1px_#e7fbf4] focus:border-[#5fe4b2] transition duration-300">
            <option selected>Select Your Excursion</option>
        `
        for (let i = 0; i < triplist.length; i++) {
            temp += `
                <option value=${triplist[i].id}>${triplist[i].trip_name}</option>
            `
        }

        temp += `</select>`
    }

    $('#tripslists').html(temp);
}

// Increase People Number Function
function increase_Number(state) {
    var adultNumber = Number($('#adult').text());
    var childNumber = Number($('#children').text());
    var infantNumber = Number($('#infant').text());

    var selectedItem = $('#selectedItem').val();
    var tripList = JSON.parse(localStorage.getItem('trip'));

    if (selectedItem != "Select Your Excursion") {
        // Increase the correct number
        if (state == "adult") {
            adultNumber += 1;
            $('#adult').text(adultNumber);
        } else if (state == "children") {
            childNumber += 1;
            $('#children').text(childNumber);
        } else if (state == "infant") {
            infantNumber += 1;
            $('#infant').text(infantNumber);
        }

        // Find the selected trip prices
        var adultPrice = 0, childPrice = 0, infantPrice = 0;
        for (let i = 0; i < tripList.length; i++) {
            if (tripList[i].id == selectedItem) {
                adultPrice = Number(tripList[i].adult_price);
                childPrice = Number(tripList[i].child_price);
                infantPrice = Number(tripList[i].infant_price);
                break;
            }
        }

        // Calculate total
        var totalPrice = (adultNumber * adultPrice) + (childNumber * childPrice) + (infantNumber * infantPrice);

        // Update total price
        $('#total_price').text("$" + totalPrice.toFixed(2));
    } else {
        ErrorAlert("Please select Trip");
    }
}

// Decrease People Number Function
function decrease_Number(state) {
    var adultNumber = Number($('#adult').text());
    var childNumber = Number($('#children').text());
    var infantNumber = Number($('#infant').text());

    var selectedItem = $('#selectedItem').val();
    var tripList = JSON.parse(localStorage.getItem('trip'));

    if (selectedItem != "Select Your Excursion") {
        // Decrease correct number
        if (state == "adult" && adultNumber > 0) {
            adultNumber -= 1;
            $('#adult').text(adultNumber);
        } else if (state == "children" && childNumber > 0) {
            childNumber -= 1;
            $('#children').text(childNumber);
        } else if (state == "infant" && infantNumber > 0) {
            infantNumber -= 1;
            $('#infant').text(infantNumber);
        }

        // Find the selected trip prices
        var adultPrice = 0, childPrice = 0, infantPrice = 0;
        for (let i = 0; i < tripList.length; i++) {
            if (tripList[i].id == selectedItem) {
                adultPrice = Number(tripList[i].adult_price);
                childPrice = Number(tripList[i].child_price);
                infantPrice = Number(tripList[i].infant_price);
                break;
            }
        }

        // Calculate total price after decreasing
        var totalPrice = (adultNumber * adultPrice) + (childNumber * childPrice) + (infantNumber * infantPrice);

        // Update total price in DOM
        $('#total_price').text("$" + totalPrice.toFixed(2));
    } else {
        ErrorAlert("Please select Trip");
    }
}

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

// To First Step Function
function To_First_Step() {
    document.getElementById("first_step").style.display = "flex";
    document.getElementById("second_step").style.display = "none";
}

// To Second Step Function
function To_Second_Step() {

    var selectedItem = $('#selectedItem').val();
    var adultNumber = Number($('#adult').text());
    var childNumber = Number($('#children').text());
    var infantNumber = Number($('#infant').text());

    if (selectedItem == "Select Your Excursion") ErrorAlert("Please select Trip!");
    else if (adultNumber == 0) ErrorAlert("Please select Adult Number!");
    else if (childNumber == 0) ErrorAlert("Please select Child Number!");
    else if (infantNumber == 0) ErrorAlert("Please select Infant Number!");
    else {
        Show_Pick_Time();
        Show_Return_Time();
        document.getElementById("first_step").style.display = "none";
        document.getElementById("second_step").style.display = "flex";
    }
}

// To Third Step Function
function To_Third_Step() {

    var bookDate = $('#bookdate').val();
    var pickTime = $('#selectedpicktime').val();
    var returnTime = $('#selectedreturntime').val();

    if (bookDate == "") ErrorAlert("Please select Book Date!");
    else if (pickTime == "Select Pickup Time") ErrorAlert("Please select Pick Time!");
    else if (returnTime == "Select Return Time") ErrorAlert("Please select Return TIme!");
    else {
        document.getElementById("third_step").style.display = "flex";
        document.getElementById("second_step").style.display = "none";
    }
}

// To Payment Function
function To_Payment() {

    var fullName = $('#fullname').val();
    var email = $('#email').val();
    var phoneNumber = $('#phonenumber').val();
    var roomNumber = $('#roomnumber').val();

    if (fullName == "") ErrorAlert("Please input your Full Name!");
    else if (email == "") ErrorAlert("Please input your Email!");
    else if (phoneNumber == "") ErrorAlert("Please input your Phone Number!");
    else if (roomNumber == "") ErrorAlert("Please input Room Number!");
    else {

        var tripList = JSON.parse(localStorage.getItem("trip"));
        var pickTime = JSON.parse(localStorage.getItem("picktime"));
        var returnTime = JSON.parse(localStorage.getItem("returntime"));
        var selectedTripID = $('#selectedItem').val();
        var selectedpicktime = $('#selectedpicktime').val();
        var selectedreturntime = $('#selectedreturntime').val();
        var selectedTripName;
        var pick_Time, return_Time;

        for (let i = 0; i < tripList.length; i++) {
            if (tripList[i].id == selectedTripID) {
                selectedTripName = tripList[i].trip_name;
            }
        }

        pick_Time = pickTime[selectedpicktime].pick_time;
        return_Time = returnTime[selectedreturntime].return_time;

        var bookingData = {
            tripID: selectedTripID,
            selectedDate: $('#bookdate').val() || null,
            pickTime: pick_Time || null,
            returnTime: return_Time || null,
            tripName: selectedTripName,
            adultCount: Number($('#adult').text()),
            childrenCount: Number($('#children').text()),
            infantCount: Number($('#infant').text()),
            totalPrice: $('#total_price').text(),
            fullname: fullName,
            email: email,
            phoneNumber: phoneNumber,
            roomNumber: roomNumber
        };

        console.log(bookingData);

        eraseCookie('book');
        setCookie('book', JSON.stringify(bookingData));

        window.location.href = "./checkout.php";
    }
}

// Back Second Step Function
function Back_Second_Step() {
    document.getElementById("third_step").style.display = "none";
    document.getElementById("second_step").style.display = "flex";
}

// Get Pick Time
function Get_Pick_Time(id) {
    axios.post(`${API_URL}/picktime/get_pick_time.php`, {
        tripID: id
    }).then(response => {
        if (response.data.status === 'success') {
            var temptrippickdata = response.data.data;
            localStorage.setItem("picktime", JSON.stringify(temptrippickdata));
        } else {
            console.log('Failed:', response.data.message);
        }
    }).catch(error => {
        console.error('Server error:', error);
    });
}

// Show Pick Time of Trip
function Show_Pick_Time() {

    var selectedItem = $('#selectedItem').val();
    Get_Pick_Time(selectedItem);

    var pickTime = JSON.parse(localStorage.getItem("picktime"));

    var temp = `
        <label for="">Pickup Time *</label>
        <select id="selectedpicktime" class="border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 outline-none focus:shadow-[0_0_3px_1px_#e7fbf4] focus:border-[#5fe4b2] transition duration-300">
        <option selected>Select Pickup Time</option>
    `;

    for (let i = 0; i < pickTime.length; i++) {
        temp += `<option value=${i}>${pickTime[i].pick_time}</option>`
    }

    temp += `</select>`;

    $('#picktime').html(temp);
}

function Get_Return_Time(id) {

    axios.post(`${API_URL}/returntime/get_return_time.php`, {
        tripID: id
    }).then(function (response) {
        if (response.data.status === 'success') {
            const returnTimes = response.data.data;
            localStorage.setItem("returntime", JSON.stringify(returnTimes));
        } else {
            ErrorAlert(response.data.message);
        }
    }).catch(function (error) {
        ErrorAlert('Server Error!');
    });
}

// Show Return Time of Trip
function Show_Return_Time() {
    var selectedItem = $('#selectedItem').val();
    Get_Return_Time(selectedItem);

    var returnTime = JSON.parse(localStorage.getItem("returntime"));

    var temp = `
        <label for="">Return Time *</label>
        <select id="selectedreturntime" class="border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 outline-none focus:shadow-[0_0_3px_1px_#e7fbf4] focus:border-[#5fe4b2] transition duration-300">
        <option selected>Select Return Time</option>
    `;

    for (let i = 0; i < returnTime.length; i++) {
        temp += `<option value=${i}>${returnTime[i].return_time}</option>`
    }

    temp += `</select>`;

    $('#returntime').html(temp);

}