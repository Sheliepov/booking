<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Trip</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body>
    <div class="w-full flex h-screen flex justify-center">
        <div class="w-full h-full flex justify-center">
            <header class="w-full h-[80px] flex justify-center items-center border-b border-[#6d6d6d] fixed backdrop-blur-sm supports-backdrop-blur:bg-white/90">
                <img src="../assets/logo.svg" class="w-[165px] z-50" alt="">
            </header>
            <div class="w-full h-1/2 bg-no-repeat bg-cover bg-center justify-center items-center" style="background-image: url('../assets/background.jpeg')">
                <div class="flex flex-col w-full flex justify-start items-center h-screen px-4">
                    <div class="flex flex-col gap-4 justify-center items-center mt-48">
                        <h1 class="uppercase md:text-[37px] text-2xl font-black text-white">Discover Rhodes</h1>
                        <span class="text-white md:text-3xl text-xl">Blue Bay Resort</span>
                    </div>

                    <!-- First Step -->
                    <div id="first_step" class="md:w-[560px] w-full p-[30px] rounded-[16px] bg-white border flex flex-col gap-3 mt-4" style="box-shadow: 0 12px 30px rgba(0, 0, 0, 0.05);">
                        <div class="w-full flex flex-col justify-start items-start gap-4">
                            <div class="w-full flex flex-col justify-start items-start gap-2">
                                <span class="md:text-[#333] text-[25px] font-bold">Craft Your Joruney</span>
                                <div class="w-full h-[1px] bg-gray-300"></div>
                                <span class="text-[#666]">Where will today take you?</span>
                            </div>
                            <form id="tripslists" class="w-full"></form>
                        </div>
                        <div class="w-full flex flex-col justify-start items-start gap-4">
                            <div class="w-full flex flex-col justify-start items-start gap-2">
                                <span class="md:text-[#333] text-[25px] font-bold">Passengers</span>
                                <div class="w-full h-[1px] bg-gray-300"></div>
                                <span class="text-[#666]">Booking requires at least one adult</span>
                            </div>
                            <div class="flex items-center justify-between border border-gray-300 rounded-lg px-4 py-2 w-full">
                                <div>
                                    <div class="font-semibold text-gray-900">Adults</div>
                                    <div class="text-sm text-gray-500">Age 12+</div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <button class="w-8 h-8 flex items-center justify-center rounded-md border border-gray-300 bg-gray-50 hover:bg-gray-100" onclick="decrease_Number('adult')">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                        </svg>
                                    </button>
                                    <span id="adult" class="text-gray-900 font-medium">0</span>
                                    <button class="w-8 h-8 flex items-center justify-center rounded-md border border-gray-300 bg-gray-50 hover:bg-gray-100" onclick="increase_Number('adult')">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="flex items-center justify-between border border-gray-300 rounded-lg px-4 py-2 w-full">
                                <div>
                                    <div class="font-semibold text-gray-900">Children</div>
                                    <div class="text-sm text-gray-500">Ages 4-11</div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <button class="w-8 h-8 flex items-center justify-center rounded-md border border-gray-300 bg-gray-50 hover:bg-gray-100" onclick="decrease_Number('children')">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                        </svg>
                                    </button>
                                    <span id="children" class="text-gray-900 font-medium">0</span>
                                    <button class="w-8 h-8 flex items-center justify-center rounded-md border border-gray-300 bg-gray-50 hover:bg-gray-100" onclick="increase_Number('children')">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                            <div class="flex items-center justify-between border border-gray-300 rounded-lg px-4 py-2 w-full">
                                <div>
                                    <div class="font-semibold text-gray-900">Infants</div>
                                    <div class="text-sm text-gray-500">Under 2</div>
                                </div>
                                <div class="flex items-center gap-3">
                                    <button class="w-8 h-8 flex items-center justify-center rounded-md border border-gray-300 bg-gray-50 hover:bg-gray-100" onclick="decrease_Number('infant')">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                                        </svg>
                                    </button>
                                    <span id="infant" class="text-gray-900 font-medium">0</span>
                                    <button class="w-8 h-8 flex items-center justify-center rounded-md border border-gray-300 bg-gray-50 hover:bg-gray-100" onclick="increase_Number('infant')">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="w-full flex flex-col justify-start items-start gap-4">
                            <div class="w-full flex flex-col justify-start items-start gap-2">
                                <span class="md:text-[#333] text-[25px] font-bold">Total Price</span>
                                <div class="w-full h-[1px] bg-gray-300"></div>
                                <label id="total_price" class="text-[#000] text-[17px] font-bold">$ 0.00</label>
                            </div>
                        </div>
                        <div class="w-full flex flex-col justify-start items-start gap-4">
                            <button onclick="To_Second_Step()" class="w-full text-white bg-[#5fe4b2] md:text-[18px] text-sm uppercase md:py-4 py-3 rounded-lg hover:bg-[#48d1a1] font-bold transition duration-300">Continue To Date & Time</button>
                        </div>
                    </div>

                    <!-- Second Step -->
                    <div id="second_step" class="md:w-[560px] w-full p-[30px] rounded-[16px] bg-white border hidden flex-col gap-3 mt-4" style="box-shadow: 0 12px 30px rgba(0, 0, 0, 0.05);">
                        <div class="w-full flex flex-col justify-start items-start gap-4">
                            <div class="w-full flex flex-col justify-start items-start gap-2">
                                <span class="md:text-[#333] text-[25px] font-bold">Select Date & Time</span>
                                <div class="w-full h-[1px] bg-gray-300"></div>
                                <span class="text-[#666]">Pick the day and time that suits you best!</span>
                            </div>
                            <form class="w-full gap-1">
                                <label for="">Pickup Date *</label>
                                <input id="bookdate" type="date" class="border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 outline-none focus:shadow-[0_0_3px_1px_#e7fbf4] focus:border-[#5fe4b2] transition duration-300">
                            </form>
                            <form id="picktime" class="w-full gap-1"></select>
                            </form>
                            <form id="returntime" class="w-full gap-1"></form>
                        </div>
                        <div class="w-full flex flex-col justify-start items-start gap-4">
                            <button onclick="To_First_Step()" class="w-full bg-white border-2 border-[#5fe4b2] text-[#5fe4b2] hover:text-white md:text-[18px] text-sm uppercase md:py-4 py-3 rounded-lg hover:bg-[#5fe4b2] font-bold transition duration-300">Back</button>
                            <button onclick="To_Third_Step()" class="w-full text-white bg-[#5fe4b2] md:text-[18px] text-sm uppercase md:py-4 py-3 rounded-lg hover:bg-[#48d1a1] font-bold transition duration-300">Continue To Date & Time</button>
                        </div>
                    </div>

                    <!-- Third Step -->
                    <div id="third_step" class="md:w-[560px] w-full p-[30px] rounded-[16px] bg-white border hidden flex-col gap-3 mt-4" style="box-shadow: 0 12px 30px rgba(0, 0, 0, 0.05);">
                        <div class="w-full flex flex-col justify-start items-start gap-4">
                            <div class="w-full flex flex-col justify-start items-start gap-2">
                                <span class="md:text-[#333] text-[25px] font-bold">Who’s Booking?</span>
                                <div class="w-full h-[1px] bg-gray-300"></div>
                                <span class="text-[#666]">Enter your contact and room details to complete the booking</span>
                            </div>
                            <form class="w-full gap-1">
                                <label for="">Full Name *</label>
                                <input id="fullname" type="text" class="border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 outline-none focus:shadow-[0_0_3px_1px_#e7fbf4] focus:border-[#5fe4b2] transition duration-300" id="">
                            </form>
                            <form class="w-full gap-1">
                                <label for="">Email *</label>
                                <input id="email" type="email" class="border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 outline-none focus:shadow-[0_0_3px_1px_#e7fbf4] focus:border-[#5fe4b2] transition duration-300" id="">
                            </form>
                            <form class="w-full gap-1">
                                <label for="">Phone *</label>
                                <input id="phonenumber" type="text" class="border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 outline-none focus:shadow-[0_0_3px_1px_#e7fbf4] focus:border-[#5fe4b2] transition duration-300" id="">
                                <label for="" class="text-xs">Please enter your phone number with country code</label>
                            </form>
                            <form class="w-full gap-1">
                                <label for="">Room Number *</label>
                                <input id="roomnumber" type="text" class="border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5 outline-none focus:shadow-[0_0_3px_1px_#e7fbf4] focus:border-[#5fe4b2] transition duration-300" id="">
                            </form>
                            <span class="text-[17px] font-bold text-black text-center">Kindly note that the reservation cost is non-refundable under any circumstances.</span>
                            <div class="w-full flex flex-col justify-start items-start gap-4">
                                <button onclick="Back_Second_Step()" class="w-full bg-white border-2 border-[#5fe4b2] text-[#5fe4b2] hover:text-white md:text-[18px] text-sm uppercase md:py-4 py-3 rounded-lg hover:bg-[#5fe4b2] font-bold transition duration-300">Back</button>
                                <button onclick="To_Payment()" class="w-full text-white bg-[#5fe4b2] md:text-[18px] text-sm uppercase md:py-4 py-3 rounded-lg hover:bg-[#48d1a1] font-bold transition duration-300">Continue To Payment</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="../src/cookie.js"></script>
<script src="../src/book.js"></script>
<script src="https://cdn.jsdelivr.net/npm/flowbite@3.1.2/dist/flowbite.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</html>