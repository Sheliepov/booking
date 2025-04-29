<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="../src/style.css">
</head>

<body>
    <div class="w-full flex h-screen flex justify-center">
        <div class="w-full h-full flex justify-center">
            <header class="w-full h-[80px] flex justify-center items-center border-b border-[#6d6d6d] fixed backdrop-blur-sm supports-backdrop-blur:bg-white/90">
                <img src="../assets/logo.svg" class="w-[165px] z-50" alt="">
            </header>
            <div class="w-full h-1/2 bg-no-repeat bg-cover bg-center justify-center items-center" style="background-image: url('../assets/background.jpeg')">
                <div class="max-w-7xl w-full flex flex-col mx-auto flex justify-start items-center h-screen md:px-4 sm:px-2 px-0">
                    <div class="flex flex-col gap-4 justify-center items-center mt-48">
                        <h1 class="uppercase md:text-[37px] text-2xl font-black text-white">Admin</h1>
                    </div>

                    <div class="w-full md:p-[30px] gap-4 rounded-md bg-white md:border flex md:flex-row flex-col justify-start items-start gap-3 mt-4" style="box-shadow: 0 12px 30px rgba(0, 0, 0, 0.05);">
                        <div id="trips_list" class="md:w-[30%] w-full flex flex-col justify-center items-start px-2 py-3 border rounded-md shadow-sm">
                            <h1 class="text-xl font-semibold mb-4">Available Trips</h1>
                            <div id="no_trips" class="w-full hidden justify-center items-center">No Trips Data</div>
                            <div id="items" class="w-full flex flex-col justify-center items-center gap-2">
                                <div class="w-full p-3 rounded-md cursor-pointer flex justify-end items-center">
                                    <button class="bg-[#5fe4b2] rounded-md font-medium text-white hover:hover:bg-[#48d1a1] transition duration-300 h-10 px-4 py-2" onclick="Add_New_Trip_Modal_Show()">Add New</button>
                                </div>
                            </div>
                        </div>
                        <div id="trip_detail" class="md:w-[70%] w-full rounded-lg border shadow-sm p-4">
                            <h2 id="trip_title" class="text-xl font-semibold mb-4"></h2>
                            <div id="no_trips_detail" class="w-full hidden justify-center items-center">No Trips Data Detail</div>
                            <div id="data_detail" dir="ltr" data-orientation="horizontal">
                                <div id="tabList" role="tablist" aria-orientation="horizontal" class="inline-flex h-10 items-center justify-center rounded-md bg-[#f1f5f9] p-1 mb-4" tabindex="0" data-orientation="horizontal" style="outline: none;">
                                    <button type="button" role="tab" aria-selected="true" data-state="active" onclick="Trip_Plan_Setting(1)"
                                        class="tab-active tab inline-flex items-center justify-center whitespace-nowrap rounded-sm px-2 py-1.5 text-sm font-medium transition-all aria-selected-true:bg-white"
                                        tabindex="-1" data-orientation="horizontal" data-radix-collection-item="">
                                        Date
                                    </button>
                                    <button type="button" role="tab" aria-selected="false" data-state="inactive" onclick="Trip_Plan_Setting(2)"
                                        class="tab inline-flex items-center justify-center whitespace-nowrap rounded-sm px-2 py-1.5 text-sm font-medium transition-all aria-selected-true:bg-white"
                                        tabindex="-1" data-orientation="horizontal" data-radix-collection-item="">
                                        Times
                                    </button>
                                    <button type="button" role="tab" aria-selected="false" data-state="inactive" onclick="Trip_Plan_Setting(3)"
                                        class="tab inline-flex items-center justify-center whitespace-nowrap rounded-sm px-2 py-1.5 text-sm font-medium transition-all aria-selected-true:bg-white"
                                        tabindex="-1" data-orientation="horizontal" data-radix-collection-item="">
                                        Pricing
                                    </button>
                                </div>
                                <div data-state="active" data-orientation="horizontal" role="tabpanel" tabindex="0" class="mt-2 space-y-4">
                                    <div id="date" class="w-full max-w-[360px] p-6 border border-gray-300 rounded-md bg-white">
                                        <div class="flex items-center justify-between mb-4">
                                            <div class="flex items-center gap-2">
                                                <button id="prevMonth" class="p-2 rounded-full hover:bg-indigo-100 hover:text-indigo-600 transition">
                                                    &#8592;
                                                </button>
                                                <h2 id="monthYear" class="text-lg font-semibold"></h2>
                                                <button id="nextMonth" class="p-2 rounded-full hover:bg-indigo-100 hover:text-indigo-600 transition">
                                                    &#8594;
                                                </button>
                                            </div>
                                        </div>

                                        <table class="w-full">
                                            <thead>
                                                <tr class="grid grid-cols-7">
                                                    <th class="text-center text-xs">Mo</th>
                                                    <th class="text-center text-xs">Tu</th>
                                                    <th class="text-center text-xs">We</th>
                                                    <th class="text-center text-xs">Th</th>
                                                    <th class="text-center text-xs">Fr</th>
                                                    <th class="text-center text-xs">Sa</th>
                                                    <th class="text-center text-xs">Su</th>
                                                </tr>
                                            </thead>
                                            <tbody id="calendarBody" class="mt-2 grid grid-rows-5 gap-2"></tbody>
                                        </table>

                                        <div class="flex justify-end gap-4 mt-6">
                                            <button class="bg-gray-500 rounded-md font-medium text-white hover:hover:bg-gray-600 transition duration-300 px-3 py-2 text-sm">Cancel</button>
                                            <button class="bg-[#5fe4b2] rounded-md font-medium text-white hover:hover:bg-[#48d1a1] transition duration-300 px-3 py-2 text-sm">Apply</button>
                                        </div>
                                    </div>
                                    <div id="time" class="space-y-8 w-full hidden mt-2 flex flex-col">
                                        <div class="space-y-4 w-full">
                                            <div class="flex justify-between items-center mb-4">
                                                <h3 class="text-lg font-medium">Pickup Times</h3>
                                                <button class="bg-[#5fe4b2] rounded-md font-medium text-white hover:hover:bg-[#48d1a1] transition duration-300 h-10 px-4 py-2" onclick="Add_Time()">Add Time</button>
                                            </div>
                                            <div id="trip_pickup_time" class="w-full grid sm:grid-cols-2 grid-cols-1 md:grid-cols-3 gap-3"></div>
                                        </div>
                                        <div class="space-y-4 w-full">
                                            <div class="flex justify-between items-center mb-4">
                                                <h3 class="text-lg font-medium">Return Times</h3>
                                                <button class="bg-[#5fe4b2] rounded-md font-medium text-white hover:hover:bg-[#48d1a1] transition duration-300 h-10 px-4 py-2" onclick="Add_Return_Time()">Add Time</button>
                                            </div>
                                            <div id="trip_return_time" class="w-full grid sm:grid-cols-2 grid-cols-1 md:grid-cols-3 gap-3"></div>
                                        </div>
                                    </div>
                                    <div id="price" class="grid grid-cols-1 md:grid-cols-3 gap-4 w-full hidden">
                                        <div>
                                            <label class="form-label">Adult Price ($)</label>
                                            <input id="adult_price" type="number" class="flex h-10 w-full rounded-md border border-input bg-background px-2 py-2 text-base file:font-medium file:text-foreground placeholder:text-muted-foreground outline-none disabled:cursor-not-allowed disabled:opacity-50 md:text-sm" min="0" value="50">
                                        </div>
                                        <div>
                                            <label class="form-label">Child Price ($)</label>
                                            <input id="child_price" type="number" class="flex h-10 w-full rounded-md border border-input bg-background px-2 py-2 text-base file:font-medium file:text-foreground placeholder:text-muted-foreground outline-none disabled:cursor-not-allowed disabled:opacity-50 md:text-sm" min="0" value="30">
                                        </div>
                                        <div>
                                            <label class="form-label">Infant Price ($)</label>
                                            <input id="infant_price" type="number" class="flex h-10 w-full rounded-md border border-input bg-background px-2 py-2 text-base file:font-medium file:text-foreground placeholder:text-muted-foreground outline-none disabled:cursor-not-allowed disabled:opacity-50 md:text-sm" min="0" value="0">
                                        </div>
                                    </div>
                                    <div class="flex justify-end mt-4 gap-2" id="button_group"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="new_trip_modal" class="hidden fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50">
            <div class="bg-white rounded-xl shadow-lg p-6 w-[350px]">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-lg font-semibold">Add New Trip</h2>
                    <button class="text-gray-500 hover:text-gray-700 text-2xl" onclick="Close_Modal()">&times;</button>
                </div>

                <form class="flex flex-col gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1" for="tripName">Trip Name</label>
                        <input id="tripName" type="text" placeholder="Enter trip name"
                            class="w-full border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 outline-none focus:shadow-[0_0_3px_1px_#e7fbf4] focus:border-[#5fe4b2] transition duration-300">
                    </div>

                    <div class="flex gap-2">
                        <div class="flex-1">
                            <label class="block text-xs font-medium text-gray-600 mb-1" for="adultPrice">Adult Price ($)</label>
                            <input id="adultPrice" type="number" min="0" value="0"
                                class="w-full border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 outline-none focus:shadow-[0_0_3px_1px_#e7fbf4] focus:border-[#5fe4b2] transition duration-300">
                        </div>
                        <div class="flex-1">
                            <label class="block text-xs font-medium text-gray-600 mb-1" for="childPrice">Child Price ($)</label>
                            <input id="childPrice" type="number" min="0" value="0"
                                class="w-full border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 outline-none focus:shadow-[0_0_3px_1px_#e7fbf4] focus:border-[#5fe4b2] transition duration-300">
                        </div>
                        <div class="flex-1">
                            <label class="block text-xs font-medium text-gray-600 mb-1" for="infantPrice">Infant Price ($)</label>
                            <input id="infantPrice" type="number" min="0" value="0"
                                class="w-full border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 outline-none focus:shadow-[0_0_3px_1px_#e7fbf4] focus:border-[#5fe4b2] transition duration-300">
                        </div>
                    </div>

                    <div type="submit" class="w-full bg-[#5fe4b2] rounded-md font-medium text-white hover:hover:bg-[#48d1a1] transition duration-300 h-10 px-4 py-2 flex justify-center items-center cursor-pointer" onclick="Add_New_Trip()">Add Trip</div>
                </form>
            </div>
        </div>
    </div>
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="../src/cookie.js"></script>
<script src="../src/admin.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</html>