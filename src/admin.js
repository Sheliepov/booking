const API_URL = '../src/api';

// Init Function
// - For Admin
loadTrips();
Get_Pick_Time();
Get_Return_Time();

document.addEventListener('DOMContentLoaded', function () {
    const items = document.querySelectorAll('#items .item');
    const tabs = document.querySelectorAll('#tabList .tab'); // FIX: select children tabs correctly

    function handleItemClick(selectedItem) {
        items.forEach(item => item.classList.remove('active'));
        selectedItem.classList.add('active');
    }

    function handleTabClick(selectedTab) {
        tabs.forEach(tab => tab.classList.remove('tab-active'));
        selectedTab.classList.add('tab-active');
    }

    items.forEach(item => {
        item.addEventListener('click', function () {
            handleItemClick(item);
        });
    });

    tabs.forEach(tab => {
        tab.addEventListener('click', function () {
            handleTabClick(tab);
        });
    });
});

// Toggle Active Function
function Active(event, index) {
    const checkbox = event.target; // the checkbox element
    const isChecked = checkbox.checked; // true or false

    if (isChecked) {
        Active_Edit(index, isChecked);
        document.getElementById("toggle_active" + index).innerText = "Active"
    } else {
        document.getElementById("toggle_active" + index).innerText = "Inactive"
        Active_Edit(index, isChecked);
    }

    const item = checkbox.closest('.item');
    if (item) {
        console.log('Clicked inside item:', item);
    }
}

// Trip Plan Setting Function
function Trip_Plan_Setting(index) {
    if (index == 1) {
        document.getElementById("time").style.display = "none";
        document.getElementById("price").style.display = "none";
        document.getElementById("date").style.display = "block";
    } else if (index == 2) {
        document.getElementById("time").style.display = "flex";
        document.getElementById("price").style.display = "none";
        document.getElementById("date").style.display = "none";
    } else if (index == 3) {
        document.getElementById("time").style.display = "none";
        document.getElementById("price").style.display = "grid";
        document.getElementById("date").style.display = "none";
    }
}

// Date
const monthYear = document.getElementById('monthYear');
const calendarBody = document.getElementById('calendarBody');
const prevMonthBtn = document.getElementById('prevMonth');
const nextMonthBtn = document.getElementById('nextMonth');

let today = new Date();
let currentMonth = today.getMonth();
let currentYear = today.getFullYear();

const months = [
    'Jan', 'Feb', 'Mar', 'Apr', 'May', 'June',
    'July', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
];

function renderCalendar(month, year) {
    var tripData = JSON.parse(localStorage.getItem("trip")) || [];
    monthYear.innerText = `${months[month]} ${year}`;

    var currentTripID = getCookie('tripID');
    var currentTripData = new Array();

    for (let i = 0; i < tripData.length; i++) {
        if (currentTripID == tripData[i].id) {
            currentTripData.push(tripData[i]);
        }
    }

    calendarBody.innerHTML = '';

    let firstDay = new Date(year, month, 1).getDay();
    let daysInMonth = new Date(year, month + 1, 0).getDate();
    let daysInPrevMonth = new Date(year, month, 0).getDate();

    firstDay = firstDay === 0 ? 7 : firstDay;

    let dayCounter = 1;
    let nextMonthCounter = 1;

    for (let i = 0; i < 6; i++) {
        const row = document.createElement('div');
        row.className = 'grid grid-cols-7';

        for (let j = 1; j <= 7; j++) {
            const cell = document.createElement('div');
            cell.className = 'flex flex-col items-center justify-center w-10 h-16';

            if (i === 0 && j < firstDay) {
                let prevDay = daysInPrevMonth - (firstDay - j) + 1;
                cell.innerHTML = `
                    <span class="text-sm text-gray-300">${prevDay}</span>
                    <input type="checkbox" class="mt-1" checked disabled>
                `;
            } else if (dayCounter > daysInMonth) {
                cell.innerHTML = `
                    <span class="text-sm text-gray-300">${nextMonthCounter}</span>
                    <input type="checkbox" class="mt-1" checked disabled>
                `;
                nextMonthCounter++;
            } else {
                // 🌟 Build correct date for comparison
                let mon = month + 1;
                let formattedMonth = mon < 10 ? "0" + mon : mon;
                let formattedDay = dayCounter < 10 ? "0" + dayCounter : dayCounter;
                let currentDate = `${year}-${formattedMonth}-${formattedDay}`;

                // 🌟 Now match tripData
                let checkboxChecked = true; // Default = checked

                for (let index = 0; index < currentTripData.length; index++) {
                    let tripDate = (currentTripData[index].created_date).split(' ')[0]; // Remove time part
                    if (tripDate === currentDate) {
                        if (currentTripData[index].available == "0") {
                            checkboxChecked = false;
                        }
                        break;
                    }
                }

                cell.innerHTML = `
                    <span class="text-sm font-medium text-gray-900">${dayCounter}</span>
                    <input type="checkbox" class="mt-1" ${checkboxChecked ? "checked" : ""} onchange="update_Available(${currentTripID}, event)">
                `;

                dayCounter++;
            }

            row.appendChild(cell);
        }
        calendarBody.appendChild(row);
    }
}

prevMonthBtn.addEventListener('click', () => {
    currentMonth--;
    if (currentMonth < 0) {
        currentMonth = 11;
        currentYear--;
    }
    renderCalendar(currentMonth, currentYear);
});

nextMonthBtn.addEventListener('click', () => {
    currentMonth++;
    if (currentMonth > 11) {
        currentMonth = 0;
        currentYear++;
    }
    renderCalendar(currentMonth, currentYear);
});

renderCalendar(currentMonth, currentYear);

// Update Trip Available Function
function update_Available(tripID, event) {
    const checkbox = event.target;
    const isChecked = checkbox.checked; // true or false
    const dayElement = checkbox.previousElementSibling; // span with day number
    const dayNumber = dayElement.innerText; // get the day number text

    const monthYearText = document.getElementById('monthYear').innerText; // example "April 2025"
    const [monthText, year] = monthYearText.split(' ');
    const monthIndex = months.indexOf(monthText); // Find month number 0-11
    const month = monthIndex + 1; // Because month is 1-based

    const formattedMonth = month < 10 ? '0' + month : month;
    const formattedDay = dayNumber.length == 1 ? '0' + dayNumber : dayNumber;

    const selectedDate = `${year}-${formattedMonth}-${formattedDay}`;

    console.log('Trip ID:', tripID);
    console.log('Selected Date:', selectedDate);
    console.log('Available:', isChecked ? '1' : '0');

    // 🛠 Send update to backend using axios
    axios.post(`${API_URL}/update_available.php`, {
        tripID: tripID,
        date: selectedDate,
        available: isChecked ? 1 : 0
    }).then(function (response) {
        if (response.data.status === 'success') {
            SuccessAlert('Availability updated!');
            // Optional: refresh calendar again if you want
        } else {
            ErrorAlert('Failed to update availability.');
        }
    }).catch(function (error) {
        console.error(error);
        ErrorAlert('Server Error!');
    });
}


// Add New Trip Modal Show Function
function Add_New_Trip_Modal_Show() {
    document.getElementById("new_trip_modal").style.display = "flex";
}

// Close Modal
function Close_Modal() {
    document.getElementById("new_trip_modal").style.display = "none";
}

// Add New Trip Function
function Add_New_Trip() {
    var tripName = document.getElementById("tripName").value;
    var adultPrice = document.getElementById("adultPrice").value;
    var childrenPrice = document.getElementById("childPrice").value;
    var infantPrice = document.getElementById("infantPrice").value;
    var available = true;
    var active = true;
    var temp = ``;
    var tripData = JSON.parse(localStorage.getItem("trip"));

    if (tripName == "") {
        ErrorAlert("Please Input Trip Name!");
    } else if (adultPrice == 0) {
        ErrorAlert("Please Input Per Adult Price!");
    } else if (childrenPrice == 0) {
        ErrorAlert("Please Input Per Children Price!");
    } else if (infantPrice == 0) {
        ErrorAlert("Please Input Per Children Price!");
    } else {
        axios.post(`${API_URL}/save_trip.php`, {
            tripName: tripName,
            adultPrice: adultPrice,
            childPrice: childrenPrice,
            infantPrice: infantPrice,
            available: available,
            active: active
        }).then(function (response) {
            if (response.data == true) {
                Close_Modal();
                if (tripData.length == 0) {
                    temp = `<div class="item w-full p-3 border rounded-md cursor-pointer flex justify-between items-center}" onclick="Show_Trip_Detail(1)">
                            <div class="flex flex-col justify-start items-start">
                                <h3 class="font-medium">${tripName}</h3>
                                <p class="text-sm text-gray-500">Base Price: $${adultPrice}</p>
                            </div>
                            <div class="flex justify-center items-center gap-2">
                                <span class="text-sm" id="toggle_active1">Active</span>
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="checkbox" value="" checked class="sr-only peer" onchange="Active(event, 1})">
                                    <div class="relative w-11 h-6 bg-gray-200 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#5fe4b2]"></div>
                                </label>
                            </div>
                        </div>`
                } else {
                    document.getElementById("no_trips").style.display = "none";
                    temp += `<div class="item w-full p-3 border rounded-md cursor-pointer flex justify-between items-center active" onclick="Show_Trip_Detail(${Number(tripData[tripData.length - 1].id) + 1})">
                                <div class="flex flex-col justify-start items-start">
                                    <h3 class="font-medium">${tripName}</h3>
                                    <p class="text-sm text-gray-500">Base Price: $${adultPrice}</p>
                                </div>
                                <div class="flex justify-center items-center gap-2">
                                    <span class="text-sm" id="toggle_active${Number(tripData[tripData.length - 1].id) + 1}">Active</span>
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="checkbox" value="" checked class="sr-only peer" onchange="Active(event, ${Number(tripData[tripData.length - 1].id) + 1}})">
                                        <div class="relative w-11 h-6 bg-gray-200 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#5fe4b2]"></div>
                                    </label>
                                </div>
                            </div>`
                    for (let index = 0; index < tripData.length; index++) {
                        temp += `
                            <div class="item w-full p-3 border rounded-md cursor-pointer flex justify-between items-center" onclick="Show_Trip_Detail(${tripData[index].id})">
                                <div class="flex flex-col justify-start items-start">
                                    <h3 class="font-medium">${tripData[index].trip_name}</h3>
                                    <p class="text-sm text-gray-500">Base Price: $${tripData[index].adult_price}</p>
                                </div>
                                <div class="flex justify-center items-center gap-2">
                                    <span class="text-sm" id="toggle_active${tripData[index].id}">${tripData[index].active == "1" ? "Active" : "Inactive"}</span>
                                    <label class="inline-flex items-center cursor-pointer">
                                        ${tripData[index].active == "1"
                                ? `<input type="checkbox" value="" checked class="sr-only peer" onchange="Active(event, ${tripData[index].id})">`
                                : `<input type="checkbox" value="" class="sr-only peer" onchange="Active(event, ${tripData[index].id})">`}
                                        <div class="relative w-11 h-6 bg-gray-200 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#5fe4b2]"></div>
                                    </label>
                                </div>
                            </div>`;
                    }
                    temp += `<div class="w-full p-3 rounded-md cursor-pointer flex justify-end items-center">
                                <button class="bg-[#5fe4b2] rounded-md font-medium text-white hover:hover:bg-[#48d1a1] transition duration-300 h-10 px-4 py-2" onclick="Add_New_Trip_Modal_Show()">Add New</button>
                            </div>`
                }
                $('#items').html(temp);
                localStorage.removeItem("trip");
                loadTrips();
                SuccessAlert("Trip Added Successfully!");
            } else {
                ErrorAlert("Failed to add trip!");
            }
        }).catch(function (error) {
            console.error(error);
            ErrorAlert("Server Error!");
        });
    }
}

// Get Trip Data Function
function loadTrips() {
    var temp = ``;
    axios.get(`${API_URL}/get_trip.php`).then(function (response) {
        if (response.data.status === 'success') {
            var tempdata = response.data;
            localStorage.setItem("trip", JSON.stringify(tempdata.data));
            if (tempdata.data.length != 0) {
                for (let index = 0; index < tempdata.data.length; index++) {
                    temp += `
                    <div class="item w-full p-3 border rounded-md cursor-pointer flex justify-between items-center ${index == 0 ? "active" : ""}" onclick="Show_Trip_Detail(${tempdata.data[index].id})">
                        <div class="flex flex-col justify-start items-start">
                            <h3 class="font-medium">${tempdata.data[index].trip_name}</h3>
                            <p class="text-sm text-gray-500">Base Price: $${tempdata.data[index].adult_price}</p>
                        </div>
                        <div class="flex justify-center items-center gap-2">
                            <span class="text-sm" id="toggle_active${tempdata.data[index].id}">${tempdata.data[index].active == "1" ? "Active" : "Inactive"}</span>
                            <label class="inline-flex items-center cursor-pointer">
                                ${tempdata.data[index].active == "1"
                            ? `<input type="checkbox" value="" checked class="sr-only peer" onchange="Active(event, ${tempdata.data[index].id})">`
                            : `<input type="checkbox" value="" class="sr-only peer" onchange="Active(event, ${tempdata.data[index].id})">`}
                                <div class="relative w-11 h-6 bg-gray-200 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#5fe4b2]"></div>
                            </label>
                        </div>
                    </div>`;
                }
                Show_Trip_Detail(tempdata.data[0].id);
            } else {
                document.getElementById("no_trips_detail").style.display = "flex";
                document.getElementById("data_detail").style.display = "none";
                document.getElementById("trip_title").style.display = "none";
                document.getElementById("no_trips").style.display = "flex";
            }

            temp += `<div class="w-full p-3 rounded-md cursor-pointer flex justify-end items-center">
                        <button class="bg-[#5fe4b2] rounded-md font-medium text-white hover:hover:bg-[#48d1a1] transition duration-300 h-10 px-4 py-2" onclick="Add_New_Trip_Modal_Show()">Add New</button>
                    </div>`;
            $('#items').html(temp);

            if (tempdata.data.length != 0) {
                temp = ``;
                temp = `
                <button class="bg-[#5fe4b2] rounded-md font-medium text-white hover:hover:bg-[#48d1a1] transition duration-300 h-10 px-4 py-2" onclick=Trip_Edit(${tempdata.data[0].id})>Save</button>
                <button class="bg-gray-500 rounded-md font-medium text-white hover:hover:bg-gray-600 transition duration-300 h-10 px-4 py-2" onclick=Trip_Remove(${tempdata.data[0].id})>Remove</button>
            `

                $('#adult_price').val(tempdata.data[0].adult_price);
                $('#child_price').val(tempdata.data[0].child_price);
                $('#infant_price').val(tempdata.data[0].infant_price);
                $('#button_group').html(temp);
            }

        } else {
            ErrorAlert('Failed to load trips');
        }
    }).catch(function (error) {
        console.error(error);
    });
}

// Trip Remove Function
function Trip_Remove(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            axios.post(`${API_URL}/remove_trip.php`, { id: id })
                .then(function (response) {
                    if (response.data.status === 'success') {
                        SuccessAlert('Trip deleted successfully!');
                        loadTrips();
                    } else {
                        ErrorAlert('Failed to delete trip');
                    }
                })
                .catch(function (error) {
                    console.error(error);
                    ErrorAlert('Server Error!');
                });
        }
    });
}

// Trip Edit Function
function Trip_Edit(id) {
    var adultPrice = $('#adult_price').val();
    var childPrice = $('#child_price').val();
    var infantPrice = $('#infant_price').val();

    if (adultPrice === "" || childPrice === "" || infantPrice === "") {
        ErrorAlert("Please fill all fields.");
        return;
    }

    axios.post(`${API_URL}/trip_edit.php`, {
        id: id,
        adultPrice: adultPrice,
        childPrice: childPrice,
        infantPrice: infantPrice
    }).then(function (response) {
        if (response.data.status === 'success') {
            SuccessAlert('Trip updated successfully!');
            loadTrips();
        } else {
            ErrorAlert('Failed to update trip!');
        }
    }).catch(function (error) {
        console.error(error);
        ErrorAlert('Server Error!');
    });
}

// Active Edit Function
function Active_Edit(id, active) {
    axios.post(`${API_URL}/active_edit.php`, {
        id: id,
        active: active
    }).then(function (response) {
        if (response.data.status === 'success') {
            SuccessAlert('Trip status updated!');
            // Optional: reload trips or update UI
            loadTrips();
        } else {
            ErrorAlert('Failed to update trip status!');
        }
    }).catch(function (error) {
        console.error(error);
        ErrorAlert('Server Error!');
    });
}

// Show Trip Detail
function Show_Trip_Detail(id) {

    const items = document.querySelectorAll('#items .item');
    const tripData = JSON.parse(localStorage.getItem("trip"));
    var pickTime = JSON.parse(localStorage.getItem('picktime'));
    var returnTime = JSON.parse(localStorage.getItem('returntime'));

    setCookie('tripID', id);
    Get_Pick_Time();
    Get_Return_Time();

    function handleItemClick(selectedItem) {
        items.forEach(item => item.classList.remove('active'));
        selectedItem.classList.add('active');
    }

    items.forEach(item => {
        item.addEventListener('click', function () {
            handleItemClick(item);
        });
    });

    var temp = ``;
    temp = `
        <button class="bg-[#5fe4b2] rounded-md font-medium text-white hover:hover:bg-[#48d1a1] transition duration-300 h-10 px-4 py-2" onclick="Trip_Edit(${id})">Save</button>
        <button class="bg-gray-500 rounded-md font-medium text-white hover:hover:bg-gray-600 transition duration-300 h-10 px-4 py-2" onclick="Trip_Remove(${id})">Remove</button>
    `
    for (let i = 0; i < tripData.length; i++) {
        if (tripData[i].id == id) {
            $('#adult_price').val(tripData[i].adult_price);
            $('#child_price').val(tripData[i].child_price);
            $('#infant_price').val(tripData[i].infant_price);
            var defaultText = "Edit Trip:";
            document.getElementById("trip_title").innerText = defaultText + tripData[i].trip_name;

            if (pickTime != undefined) {
                var tempdate = ``;
                for (let i = 0; i < pickTime.length; i++) {
                    if (pickTime[i].tripId == id) {
                        tempdate += `
                            <div class="flex items-center gap-2 p-2 border rounded-md lg:flex-row md:flex-col">
                                <input type="time" class="flex h-10 rounded-md border border-input bg-background px-2 py-2 text-base md:text-sm" value=${pickTime[i].picktime}>
                                <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium h-9 rounded-md px-2" onclick="Remove_Pick_Time(${pickTime[i].id})">Remove</button>
                            </div>
                        `
                    }
                }
                $('#trip_pickup_time').html(tempdate);
            }
            if (returnTime != undefined) {
                var tempdata = ``;
                for (let i = 0; i < returnTime.length; i++) {
                    if (returnTime[i].tripId == id) {
                        tempdata += `
                            <div class="flex items-center gap-2 p-2 border rounded-md lg:flex-row md:flex-col">
                                <input type="time" class="flex h-10 rounded-md border border-input bg-background px-2 py-2 text-base md:text-sm" value=${returnTime[i].return_time}>
                                <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium h-9 rounded-md px-2" onclick="Remove_Pick_Time(${returnTime[i].id})">Remove</button>
                            </div>
                        `
                    }
                }
                $('#trip_return_time').html(tempdata);
            }
        }
    }

    $('#button_group').html(temp);

    renderCalendar(currentMonth, currentYear);
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

// Add Pick Time Function
function Add_Time() {
    var tripID = getCookie('tripID');

    if (!tripID) {
        ErrorAlert('Trip ID not found!');
        return;
    }

    axios.post(`${API_URL}/picktime/add_pick_time.php`, {
        time: "07:00", // Default new time
        tripID: tripID
    }).then(function (response) {
        if (response.data.status === 'success') {
            // After success, reload pick times
            loadPickTimes();
        } else {
            ErrorAlert(response.data.message);
        }
    }).catch(function (error) {
        console.error('Server error', error);
        ErrorAlert('Server Error!');
    });
}

// load Pick Time Function
function loadPickTimes() {
    var tripID = getCookie('tripID');

    axios.post(`${API_URL}/picktime/get_pick_time.php`, {
        tripID: tripID
    }).then(function (response) {
        if (response.data.status === 'success') {
            const pickTimes = response.data.data;
            let temp = '';

            if (pickTimes.length === 0) {
                temp = '<div>No pickup times set yet.</div>';
            } else {
                for (let i = 0; i < pickTimes.length; i++) {
                    temp += `
                    <div class="flex items-center gap-2 p-2 border rounded-md lg:flex-row md:flex-col">
                        <input id="pick_time_${pickTimes[i].id}" type="time" 
                            class="flex h-10 rounded-md border border-input bg-background px-2 py-2 text-base md:text-sm" 
                            onchange="Update_Pick_Time(${pickTimes[i].id})" 
                            value="${pickTimes[i].pick_time}">
                        <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium h-9 rounded-md px-2" 
                            onclick="Remove_Pick_Time(${pickTimes[i].id})">Remove</button>
                    </div>
                    `;
                }
            }

            $('#trip_pickup_time').html(temp);
        } else {
            ErrorAlert(response.data.message);
        }
    }).catch(function (error) {
        console.error('Server error', error);
        ErrorAlert('Server Error!');
    });
}

// Remove Pick Time Function
function Remove_Pick_Time(id) {
    if (!id) {
        ErrorAlert('Pickup time ID missing!');
        return;
    }

    Swal.fire({
        title: 'Are you sure?',
        text: "You want to remove this pickup time?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            axios.post(`${API_URL}/picktime/remove_pick_time.php`, {
                id: id
            }).then(function (response) {
                if (response.data.status === 'success') {
                    SuccessAlert('Pickup time removed!');
                    loadPickTimes(); // Refresh pickup time list
                } else {
                    ErrorAlert(response.data.message);
                }
            }).catch(function (error) {
                console.error('Server error', error);
                ErrorAlert('Server Error!');
            });
        }
    });
}

// Get Pick Time
function Get_Pick_Time() {
    var tripID = getCookie("tripID");
    var temp = ``;
    axios.post(`${API_URL}/picktime/get_pick_time.php`, {
        tripID: tripID
    }).then(response => {
        if (response.data.status === 'success') {
            var temptrippickdata = response.data.data;
            localStorage.setItem("picktime", JSON.stringify(temptrippickdata));
            for (let i = 0; i < temptrippickdata.length; i++) {
                temp += `
                    <div class="flex items-center gap-2 p-2 border rounded-md lg:flex-row md:flex-col">
                        <input id="pick_time_${temptrippickdata[i].id}" type="time" class="flex h-10 rounded-md border border-input bg-background px-2 py-2 text-base md:text-sm" onchange="Update_Pick_Time(${temptrippickdata[i].id})" value=${temptrippickdata[i].pick_time}>
                        <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium h-9 rounded-md px-2" onclick="Remove_Pick_Time(${temptrippickdata[i].id})">Remove</button>
                    </div>
                `
            }
            $('#trip_pickup_time').html(temp);
        } else {
            console.log('Failed:', response.data.message);
        }
    }).catch(error => {
        console.error('Server error:', error);
    });
}

// Update Pick Time
function Update_Pick_Time(id) {
    const updatedTime = document.getElementById(`pick_time_${id}`).value;

    if (!updatedTime) {
        ErrorAlert('Please input a valid time!');
        return;
    }

    axios.post(`${API_URL}/picktime/update_pick_time.php`, {
        id: id,
        time: updatedTime
    }).then(response => {
        if (response.data.status === 'success') {
            SuccessAlert('Pick time updated!');
        } else {
            ErrorAlert(response.data.message);
        }
    }).catch(error => {
        console.error(error);
        ErrorAlert('Server Error!');
    });
}

// Get Return Time Function
function Get_Return_Time() {
    var tripID = getCookie('tripID');

    axios.post(`${API_URL}/returntime/get_return_time.php`, {
        tripID: tripID
    }).then(function (response) {
        if (response.data.status === 'success') {
            const returnTimes = response.data.data;
            localStorage.setItem("returntime", JSON.stringify(returnTimes));
            let temp = '';

            if (returnTimes.length === 0) {
                temp = '<div>No return times set yet.</div>';
            } else {
                for (let i = 0; i < returnTimes.length; i++) {
                    temp += `
                    <div class="flex items-center gap-2 p-2 border rounded-md lg:flex-row md:flex-col">
                        <input id="return_time_${returnTimes[i].id}" type="time" 
                            class="flex h-10 rounded-md border border-input bg-background px-2 py-2 text-base md:text-sm" 
                            onchange="Update_Return_Time(${returnTimes[i].id})" 
                            value="${returnTimes[i].return_time}">
                        <button class="inline-flex items-center justify-center gap-2 whitespace-nowrap text-sm font-medium h-9 rounded-md px-2" 
                            onclick="Remove_Return_Time(${returnTimes[i].id})">Remove</button>
                    </div>
                    `;
                }
            }

            $('#trip_return_time').html(temp);
        } else {
            ErrorAlert(response.data.message);
        }
    }).catch(function (error) {
        console.error('Server error', error);
        ErrorAlert('Server Error!');
    });
}

// Add Return Time Function
function Add_Return_Time() {
    var tripID = getCookie('tripID');

    if (!tripID) {
        ErrorAlert('Trip ID not found!');
        return;
    }

    axios.post(`${API_URL}/returntime/add_return_time.php`, {
        time: "07:00", // Default new time
        tripID: tripID
    }).then(function (response) {
        console.log(response.data);
        if (response.data.status === 'success') {
            // After success, reload pick times
            Get_Return_Time();
        } else {
            ErrorAlert(response.data.message);
        }
    }).catch(function (error) {
        console.error('Server error', error);
        ErrorAlert('Server Error!');
    });
}

// Update Return Time Function
function Update_Return_Time(id) {
    const updatedTime = document.getElementById(`return_time_${id}`).value;

    if (!updatedTime) {
        ErrorAlert('Please input a valid return time!');
        return;
    }

    axios.post(`${API_URL}/returntime/update_return_time.php`, {
        id: id,
        time: updatedTime
    }).then(function (response) {
        if (response.data.status === 'success') {
            SuccessAlert('Return time updated successfully!');
            Get_Return_Time(); // Refresh list after update
        } else {
            ErrorAlert(response.data.message);
        }
    }).catch(function (error) {
        console.error('Server error', error);
        ErrorAlert('Server Error!');
    });
}

// Remove Return Time Function
function Remove_Return_Time(id) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You want to remove this return time?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            axios.post(`${API_URL}/returntime/remove_return_time.php`, {
                id: id
            }).then(function (response) {
                if (response.data.status === 'success') {
                    SuccessAlert('Return time removed successfully!');
                    Get_Return_Time(); // Refresh list after delete
                } else {
                    ErrorAlert(response.data.message);
                }
            }).catch(function (error) {
                console.error('Server error', error);
                ErrorAlert('Server Error!');
            });
        }
    });
}