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
    <!-- Main / Hero Section -->
    <div class="overlay" id="login-overlay">
        <div class="wrapper">
            <div class="form-container">
                <span class="close" onclick="showAddItem()">&times;</span>
                <form action="" method="post" class="additem-form" enctype="multipart/form-data">
                    <h1>Add Menu Item</h1>
                    <Select id="courseSelect" name="courseSelect">
                        <?php
                        // Include the PHP file to get categories
                        require_once '../Server/db.php';
                        require_once '../Server/classes/courses.php';

                        $database = new Database();
                        $db = $database->getConnection();


                        // Display courses
                        $courses = new Courses($db);
                        $data = $courses->getAllData();
                        foreach ($data as $course) {

                            echo "<option value='" . htmlspecialchars($course['course_id']) . "'>" . htmlspecialchars($course['name']) . "</option>";
                        }

                        ?>
                    </Select>

                    <div class="login-box">
                        <input type="text" placeholder="Item Name" name="name" required>

                    </div>
                    <div class="login-box">
                        <input type="text" placeholder="Description" name="description" required>

                    </div>
                    <div class="login-box">
                        <input type="numbers" placeholder="Price" name="price" required>
                    </div>
                    <input type="hidden" id="imageData" name="imageData">

                    <input type="file" name="image" accept="image/*" required>

                    <button type="submit" onsubmit="handleAddMenuItem()">Submit</button>
                </form>
            </div>
        </div>
    </div>
    </div>

    <div class="nav">
        <div class="logo">
            <h1>Culinary<span> HAVEN.</span></h1>
        </div>
        <ul>
            <li><a href="#home">Home</a></li>
            <li><a href="#menu">Menu</a></li>
            <li><a href="">Bookings</a></li>
            <li>
                <button class="nav-btn" style="display: none" onclick="handleLogout()">Logout</button>
            </li>
        </ul>
        <button class="nav-btn-2" onclick="handleLogout()">Logout</button>
        <i class="fa fa-bars"></i>
    </div>
    <!-- Bookings -->
    <div id="booking" style="margin-top: 200px">
        <div class="booking">
            <div class="admin-options">
                <h1 class="section-title">Booking</h1>
                <button onclick="addBooking()">Add Booking</button>
            </div>
            <div class="upcoming-bookings">


            </div>
        </div>
    </div>
    <!-- Menu -->
    <div id="menu" style="margin-top: 200px">
        <div class="menu">
            <div class="admin-options">
                <h1 class="section-title">Menu</h1>
                <button onclick="showAddItem()">Add Item</button>
            </div>

            <div class="courses">
                <?php
                // Include the PHP file to get categories
                require_once '../Server/db.php';
                require_once '../Server/classes/courses.php';

                $database = new Database();
                $db = $database->getConnection();

                echo "<button type=\"button\" data-filter=\"all\">All</button>";

                $courses = new Courses($db);
                $data = $courses->getAllData();
                foreach ($data as $course) {
                    echo "<button type=\"button\" data-filter=\"" . ".course" . htmlspecialchars($course['course_id']) . "\">" . htmlspecialchars($course['name']) . "</button>";
                }

                // Display categories
                ?>
            </div>
            <div class="menu-cards">
                <?php
                require_once '../Server/db.php';
                require_once '../Server/classes/menu.php';

                $database = new Database();
                $db = $database->getConnection();

                $menu = new Menu($db);
                $data = $menu->getAllItems();

                if (empty($data)) {
                    echo "<h1>Menu is still being added!</h1>";
                } else {
                    foreach ($data as $item) {
                        echo "<div class=\"" . "mix course" . htmlspecialchars($item['courses_id']) . "\">";
                        echo "<div class=\"menu-card\">";
                        // Retrieve the relative path of the image from the database
                        $relativeImagePath = $item['images'];

                        // Adjust the relative path to match the actual file path on the server
                        $actualFilePath = realpath(dirname(__FILE__) . '/../../Server') . '/' . basename($relativeImagePath);

                        // Construct the full URL to the image
                        $imageURL = 'https://' . $_SERVER['HTTP_HOST'] . '/ResturantWebsite/Server/uploads/' . basename($relativeImagePath);

                        // Output the image with the generated URL
                        echo "<img src=\"" . htmlspecialchars($imageURL) . "\"/>";
                        echo "<div class=\"menu-details\">";
                        echo "<h4>" . htmlspecialchars($item['name']) . "</h4>";
                        echo "<p>" . htmlspecialchars($item['description']) . "</p>";
                        echo "<p>Price: " . htmlspecialchars($item['price']) . "</p>";
                        echo "</div>";
                        echo "</div>";
                        echo "</div>";
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <!-- MIXIT UP CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mixitup/3.3.1/mixitup.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function ()
        {
            var container = document.querySelector('.menu-cards');
            var mixer = mixitup(container);
        });
    </script>
    <script src="main.js"></script>
</body>

</html>