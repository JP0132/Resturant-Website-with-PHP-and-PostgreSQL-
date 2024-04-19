<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Resturant Website</title>
    <!-- Styles -->
    <link rel="stylesheet" href="style.css" />
    <!-- Font Awesome cdn -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" />

</head>

<body>
    <div class="nav">
        <div class="logo">
            <h1>Culinary<span> HAVEN.</span></h1>
        </div>
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="#booking">Bookings</a></li>
            <li>
                <button class="nav-btn" style="display: none" onclick="handleLogout()">Logout</button>
            </li>
        </ul>
        <button class="nav-btn-2" onclick="handleLogout()">Logout</button>
        <i class="fa fa-bars"></i>
    </div>

    <div class="booking-wrapper" id="booking">

        <div class="upcoming-booking-container">
            <h1>Upcoming bookings</h1>
            <div class="time-cards-wrapper">
                <!-- Filled in with javascript -->
            </div>
        </div>
        <div class="past-booking-container">
            <h1>Past bookings</h1>
            <div class="time-cards-wrapper">
                <!-- Filled in with javascript -->
            </div>
        </div>



        <div class="booking-container">
            <div class="background-overlay"></div>
            <h3>Book your table!</h3>

            <form action="" method="post" class="booking-form">

                <label for="name">
                    <span>Your Name:</span>
                    <input type="text" id="name" name="name" required>
                </label>
                <span>Date for booking:</span>
                <div class="list-choice">
                    <div class="list-choice-title">Date</div>
                    <div class="list-choice-options" id="date">

                    </div>
                </div>

                <span>Time of booking:</span>
                <div class="list-choice">
                    <div class="list-choice-title">Time</div>
                    <div class="list-choice-options" id="time">

                    </div>
                </div>

                <!-- <label for="time">
                    <span>Preferred Time:</span>
                    <select id="time" name="time" required>
                        
                    </select>
                </label> -->
                <button type="submit" onsubmit="handleBookings(event)">Create booking</button>
            </form>
        </div>
    </div>


    <script src="main.js"></script>

</body>

</html>