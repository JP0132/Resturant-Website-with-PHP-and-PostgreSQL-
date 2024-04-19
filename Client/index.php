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

<body style="margin-bottom: 100px;">
  <!-- Login form -->
  <div class="overlay" id="login-overlay">
    <div class="wrapper">
      <div class="form-container">
        <div class="tab-container">
          <button class="role-tabs" onclick="handleSelectedTab(this)" id="admin">Admin</button>
          <button class="role-tabs selected" onclick="handleSelectedTab(this)" id="user">User</button>
        </div>

        <span class="close" onclick="showLogin()">&times;</span>
        <form action="" method="post" class="login-form">
          <h1>Login</h1>
          <div class="login-box">
            <input type="text" placeholder="Email" name="email" required>
            <i class="fa-solid fa-envelope"></i>
          </div>
          <div class="login-box">
            <input type="password" placeholder="Password" name="password" required>
            <i class="fa-solid fa-lock"></i>
          </div>
          <div class="remember-me">
            <label for="">
              <input type="checkbox">
              Remember Me
            </label>
            <a href="#">Forgot Password?</a>
          </div>
          <button type="submit" onsubmit="handleLoginUser(event)">Login</button>
          <div class="form-link">
            <p>Don't have an account? <a onclick="handleChangeForms('l')">Register</a></p>
          </div>
        </form>

        <form action="" method="post" class="registration-form" style="display: none;">
          <h1>Register</h1>
          <div class="login-box">
            <input type="text" placeholder="Full Name" name="fullname" required>
            <i class="fa-solid fa-user"></i>
          </div>
          <div class="login-box">
            <input type="text" placeholder="Email" name="email" required>
            <i class="fa-solid fa-envelope"></i>
          </div>
          <div class="login-box">
            <input type="password" placeholder="Password" name="password" required>
            <i class="fa-solid fa-lock"></i>
          </div>
          <button type="submit" onsubmit="handleRegisterUser(event)">Register</button>
          <div class="form-link">
            <p>Have an account? <a onclick="handleChangeForms('r')">Login</a></p>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Main / Hero Section -->
  <div class="main-header">
    <div class="nav">
      <div class="logo">
        <h1>Culinary<span> HAVEN.</span></h1>
      </div>
      <ul>
        <li><a href="#home">Home</a></li>
        <li><a href="#menu">Menu</a></li>
        <li><a href="">Contact</a></li>
        <?php
        if (session_status() == PHP_SESSION_NONE) {
          session_start();
        }

        if (isset($_SESSION["user_email"])) {
          echo "<li><a onclick=\"handleLogout()\">Logout</a></li>";
        } else {
          echo "<li><a onclick=\"showLogin()\">Login</a></li>";
        }

        ?>

        <li>
          <button onclick="bookATable(event)" class="nav-btn" style="display: none">Book a Table</button>
        </li>
      </ul>
      <button onclick="bookATable(event)" class="nav-btn-2">Book a Table</button>
      <i class="fa fa-bars"></i>
    </div>
    <div id="home" class="header">
      <div class="content">
        <?php
        if (session_status() == PHP_SESSION_NONE) {
          session_start();
        }

        if (isset($_SESSION["user_email"])) {
          echo "<h4>Hello, " . htmlspecialchars($_SESSION["user_name"]) . "</h4>";
        }
        ?>

        <h4>WELCOME TO THE CULINARY <span>HAVEN.</span></h4>
        <h1>Where Flavour Meets<span> Elegance</span></h1>
        <p>
          Explore our exquisite menu, crafted with passion and creativity to
          delight your palate. Experience a culinary journey like no other,
          where every dish tells a story of innovation and excellence.
          <span>Reserve your table now and embark on a gastronomic adventure with
            us.</span>
        </p>
        <button onclick="bookATable(event)">Book a Table</button>
      </div>
    </div>
  </div>
  <!-- Awards and Features -->
  <div class="container">
    <div class="features">
      <div class="features-cards">
        <div class="feature-card">
          <img src="images/award1.png" alt="" />
          <h2>Awarded Best Cusine 2021</h2>
          <p>Presented by the International Food Awards Committee.</p>
        </div>
        <div class="feature-card">
          <img src="images/award2019.png" alt="" />
          <h2>Awarded Best Resturant 2019</h2>
          <p>Recognized by the Restaurant Excellence Awards.</p>
        </div>
        <div class="feature-card">
          <i class="fa-solid fa-bowl-food"></i>
          <h2>Multiple Cusines</h2>
          <p>
            Explore a diverse range of culinary delights from around the
            world.
          </p>
        </div>
        <div class="feature-card">
          <i class="fa-solid fa-music"></i>
          <h2>Live Music</h2>
          <p>
            Experience the ambiance with live performances from talented
            musicians.
          </p>
        </div>
        <div class="feature-card">
          <i class="fa-solid fa-utensils"></i>
          <h2>Fine Dinning Experience</h2>
          <p>
            Indulge in an exquisite dining journey with our impeccable service
            and elegant ambiance.
          </p>
        </div>
        <div class="feature-card">
          <i class="fa-solid fa-wine-bottle"></i>
          <h2>Extensive Wine list</h2>
          <p>
            Discover the perfect complement to your meal with our carefully
            curated selection of wines.
          </p>
        </div>
      </div>
    </div>
  </div>

  <!-- Menu -->
  <div id="menu">
    <div class="menu">

      <h1 class="section-title">Menu</h1>


      <div class="courses">
        <?php
        // PHP to get courses
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

  <!-- Contact -->
  <div id="contact" style="margin-top:150px;">
    <div class="contact-wrapper">
      <h1>Contact us.</h1>
      <h4>Get in touch with the the details below:</h4>
      <div class="contact-info-wrapper">
        <div class="contact-info">
          <h1>Location</h1>
          <h4>Random Road, London, England, NW3 2TU</h4>
        </div>
        <div class="contact-info">
          <h1>Email</h1>
          <h4>culinaryhaven@example.com</h4>
        </div>
        <div class="contact-info">
          <h1>Phone</h1>
          <h4>0116 2348 30821</h4>
        </div>
      </div>
    </div>


  </div>
  </div>
  </div>

  <script src="main.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/mixitup/3.3.1/mixitup.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function ()
    {
      var container = document.querySelector('.menu-cards');
      var mixer = mixitup(container);
    });
  </script>
</body>

</html>