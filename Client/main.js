// Adding a default admin on page load
function addDefaultAdmin() {
  fetch("../Server/routes/add_default_admin.php")
    .then((res) => res.json())
    .then((data) => {
      if (data.success) {
        console.log("hi");
      } else {
        console.error(data.message);
      }
    })
    .catch((error) => {
      console.error("Error:", error);
    });
}

addDefaultAdmin();

// Shows the login form
function showLogin() {
  let login_form = document.querySelector(".overlay");
  login_form.classList.toggle("showLogin");
  document.querySelector(".login-form").reset();
  document.querySelector(".registration-form").reset();
}

// Shows the form to add a item
function showAddItem() {
  let login_form = document.querySelector(".overlay");
  login_form.classList.toggle("showAddItem");
}

// Shows which tab has been selected in the login form
function handleSelectedTab(button) {
  // Remove the 'selected' class from all buttons
  const buttons = document.querySelectorAll(".role-tabs");
  buttons.forEach((btn) => btn.classList.remove("selected"));

  // Add the 'selected' class to the clicked button
  button.classList.add("selected");
}

// When the login and Registration form has been changed
function handleChangeForms(change) {
  if (change === "l") {
    let loginForm = document.querySelector(".login-form");
    loginForm.style.display = "none";

    let registerForm = document.querySelector(".registration-form");
    registerForm.style.display = "block";
  } else {
    let loginForm = document.querySelector(".login-form");
    loginForm.style.display = "block";

    let registerForm = document.querySelector(".registration-form");
    registerForm.style.display = "none";
  }
}

// Logs the user in
function handleLoginUser(event) {
  event.preventDefault();
  let tab = document.querySelector(".selected");
  const userType = tab.id;

  const form = document.querySelector(".login-form");
  const formData = new FormData(form);
  const email = formData.get("email");
  const password = formData.get("password");
  console.log(email);

  // If email is not valid format then show error
  if (!validateEmail(email)) {
    alert("Invalid email format!"); // Example of showing an error message
    return;
  }

  if (userType === "admin") {
    fetch("../Server/routes/admin_login.php", {
      method: "POST",
      body: JSON.stringify({ email: email, password: password }),
      headers: {
        "Content-Type": "application/json",
      },
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          window.location.href = "admin_dashboard.php";
        } else {
          alert(data.message);
        }
      })
      .catch((error) => {
        console.error("Error:", error);
      });
  } else {
    fetch("../Server/routes/user_login.php", {
      method: "POST",
      body: JSON.stringify({ email: email, password: password }),
      headers: {
        "Content-Type": "application/json",
      },
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          window.location.href = "index.php";
        } else {
          alert(data.message);
        }
      })
      .catch((error) => {
        console.error("Error:", error);
      });
  }
}

// Add event listener to the login form
const loginForm = document.querySelector(".login-form");
if (loginForm) {
  loginForm.addEventListener("submit", handleLoginUser);
}

// Handle registering new user
function handleRegisterUser(event) {
  event.preventDefault();
  let tab = document.querySelector(".selected");
  const userType = tab.id;

  const form = document.querySelector(".registration-form");
  const formData = new FormData(form);
  const fullname = formData.get("fullname");
  const email = formData.get("email");
  const password = formData.get("password");

  // If email is not valid format then show error
  if (!validateEmail(email)) {
    alert("Invalid email format!"); // Example of showing an error message
    return;
  }

  // Check if password meets requirements
  if (!validatePassword(password)) {
    alert(
      "Password must be: 8 character long or more and contain at least one: Special character, number, lowercase and uppercase letter."
    );
  }

  fetch("../Server/routes/register_user.php", {
    method: "POST",
    body: JSON.stringify({
      fullname: fullname,
      email: email,
      password: password,
    }),
    headers: {
      "Content-Type": "application/json",
    },
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        alert(data.message);
      } else {
        alert(data.message);
      }
    })
    .catch((error) => {
      console.error("Error:", error);
    });
}

// Add event listener to the login form
const registerForm = document.querySelector(".registration-form");
if (registerForm) {
  registerForm.addEventListener("submit", handleRegisterUser);
}

// Validates the email
function validateEmail(email) {
  const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  return emailPattern.test(email);
}

// Validates the password
function validatePassword(password) {
  // Check length
  if (password.length < 8) {
    return false;
    //return "Password must be at least 8 characters long.";
  }

  // Check for uppercase letters
  if (!/[A-Z]/.test(password)) {
    return false;
    //return "Password must contain at least one uppercase letter.";
  }

  // Check for lowercase letters
  if (!/[a-z]/.test(password)) {
    return false;
    //return "Password must contain at least one lowercase letter.";
  }

  // Check for numbers
  if (!/\d/.test(password)) {
    return false;
    //return "Password must contain at least one number.";
  }

  // Check for special characters
  if (!/[^A-Za-z0-9]/.test(password)) {
    return false;
    //return "Password must contain at least one special character.";
  }

  return true;
}

// Logs the user out
function handleLogout() {
  fetch("../Server/routes/logout.php")
    .then((response) => {
      if (response.ok) {
        window.location.href = "index.php";
        // Redirect to the desired location after successful logout
      } else {
        // Handle error (e.g., display error message)
        console.error("Logout failed");
      }
    })
    .catch((error) => {
      // Handle network error
      console.error("Error:", error);
    });
}

// Shows the page to book a table
function bookATable(event) {
  event.preventDefault();
  fetch("../Server/routes/check_login.php")
    .then((res) => res.json())
    .then((data) => {
      if (data.loggedIn) {
        window.location.href = "book_a_table.php";
      } else {
        alert("Please login to book a table!");
        showLogin();
      }
    });
}

// Adds the new item from the form
function handleAddMenuItem(event) {
  event.preventDefault();

  const form = document.querySelector(".additem-form");
  const formData = new FormData(form);
  // const name = formData.get("name");
  // const description = formData.get("description");
  // const price = formData.get("price");
  // const image = document.getElementById("imageUpload").files;

  // const course = formData.get("courseSelect");
  // console.log(course);

  fetch("../Server/routes/add_item.php", {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        window.location.href = "admin_dashboard.php";
      }
    })
    .catch((error) => {
      console.error("Error:", error);
    });
}

// Add a event listener to the add item form
const add_item_form = document.querySelector(".additem-form");
if (add_item_form) {
  add_item_form.addEventListener("submit", handleAddMenuItem);
}

function getPreviousBookings() {
  fetch("../Server/routes/previous_booking.php")
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        const prevContainer = document.querySelector(
          ".past-booking-container .time-cards-wrapper"
        );
        //console.log(data.previousBookings);
        if (data.previousBookings.length === 0) {
          const newH4 = document.createElement("h4");
          newH4.innerHTML = "No Past Bookings!";
          prevContainer.appendChild(newH4);
        } else {
          data.previousBookings.forEach((pb) => {
            console.log(pb.booking_date);
            const timeCardContainer = document.createElement("div");
            const newH4 = document.createElement("h4");
            newH4.innerHTML = pb.booking_date;
            timeCardContainer.className = "time-card";
            timeCardContainer.appendChild(newH4);
            prevContainer.appendChild(timeCardContainer);
          });
        }
      }
    })
    .catch((error) => {
      console.error("Error:", error);
    });
}

function getAllUpcomingBookings() {
  fetch("../Server/routes/all_upcoming_bookings.php")
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        const upcomingContainer = document.querySelector(".upcoming-bookings");

        //console.log(data.previousBookings);
        if (data.upcoming_bookings.length === 0) {
          const newH4 = document.createElement("h4");
          newH4.innerHTML = "No Upcoming Bookings!";
          upcomingContainer.appendChild(newH4);
        } else {
          data.upcoming_bookings.forEach((pb) => {
            //console.log(pb.booking_date);
            const timeCardContainer = document.createElement("div");
            const date = document.createElement("h4");
            const name = document.createElement("h4");
            const hiddenInput = document.createElement("input");
            const deleteButton = document.createElement("button");
            console.log(pb);

            name.innerHTML = "Name: " + pb.fullname;
            timeCardContainer.className = "time-card";
            timeCardContainer.appendChild(name);

            date.innerHTML = "Date: " + pb.booking_date;
            timeCardContainer.className = "time-card";
            timeCardContainer.appendChild(date);

            hiddenInput.type = "hidden";
            hiddenInput.value = pb.booking_id;
            timeCardContainer.appendChild(hiddenInput);

            deleteButton.type = "button";
            deleteButton.innerHTML = "DELETE";
            deleteButton.classList = "delete-button";
            deleteButton.addEventListener("click", function (event) {
              handleDeleteBooking(event);
            });
            timeCardContainer.appendChild(deleteButton);

            upcomingContainer.appendChild(timeCardContainer);
          });
        }
      }
    })
    .catch((error) => {
      console.error("Error:", error);
    });
}

function getUpcomingBookings() {
  fetch("../Server/routes/upcoming_bookings_by_ID.php")
    .then((response) => response.json())
    .then((data) => {
      if (data.success) {
        const upcomingContainer = document.querySelector(
          ".upcoming-booking-container .time-cards-wrapper"
        );

        //console.log(data.previousBookings);
        if (data.upcomingBookings.length === 0) {
          const newH4 = document.createElement("h4");
          newH4.innerHTML = "No Upcoming Bookings!";
          upcomingContainer.appendChild(newH4);
        } else {
          data.upcomingBookings.forEach((pb) => {
            //console.log(pb.booking_date);
            const timeCardContainer = document.createElement("div");
            const newH4 = document.createElement("h4");
            const hiddenInput = document.createElement("input");
            const deleteButton = document.createElement("button");

            newH4.innerHTML = pb.booking_date;
            timeCardContainer.className = "time-card";
            timeCardContainer.appendChild(newH4);

            hiddenInput.type = "hidden";
            hiddenInput.value = pb.booking_id;
            timeCardContainer.appendChild(hiddenInput);

            deleteButton.type = "button";
            deleteButton.innerHTML = "DELETE";
            deleteButton.classList = "delete-button";
            deleteButton.addEventListener("click", function (event) {
              handleDeleteBooking(event);
            });
            timeCardContainer.appendChild(deleteButton);

            upcomingContainer.appendChild(timeCardContainer);
          });
        }
      }
    })
    .catch((error) => {
      console.error("Error:", error);
    });
}

function handleDeleteBooking(event) {
  const hiddenInput = event.currentTarget.parentNode.querySelector(
    'input[type="hidden"]'
  );
  const bookingID = hiddenInput.value;
  console.log(bookingID);

  fetch("../Server/routes/delete_booking.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      bookingID: bookingID,
    }),
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.success) {
        alert("The booking has been deleted!");
        location.reload();
      }
    })
    .catch((error) => {
      console.log(error);
    });
}

const upcomingAdminBookings = document.querySelector(".upcoming-bookings");

if (upcomingAdminBookings) {
  getAllUpcomingBookings();
}

const bookingContainer = document.querySelector(".booking-wrapper");
if (bookingContainer) {
  getUpcomingBookings();
  getPreviousBookings();
}

// Add a event listener to the booking form
const bookingForm = document.querySelector(".booking-form");
if (bookingForm) {
  bookingForm.addEventListener("submit", handleBooking);

  const currentDate = new Date();
  //console.log(currentDate.toISOString().split("T")[0]);

  // Call populateDates
  populateDates();

  const radioButtons = document.querySelectorAll('input[name="date"]');

  // Loop through each radio button
  radioButtons.forEach((radioButton) => {
    const radioButtonValue = radioButton.value;
    const edited = radioButtonValue.replace("/", "");

    // Check if the radio button value
    if (edited === currentDate.toISOString().split("T")[0]) {
      // If checked, store its value
      radioButton.checked = true;
    }
  });

  // Call populateTimeSlots with current date
  populateTimeSlots(currentDate.toISOString().split("T")[0]);

  //selectTime.innerHTML = timeSlots;
}

function handleBooking(event) {
  event.preventDefault();

  // Get the selected date value
  const selectedDate = document.querySelector(
    'input[name="date"]:checked'
  ).value;

  // Get the selected time value
  const selectedTime = document.querySelector(
    'input[name="time"]:checked'
  ).value;

  // Get the name input value
  const nameInput = document.getElementById("name").value;

  const editedDate = selectedDate.replace("/", "");
  const editedTime = selectedTime.replace("/", "");

  const dateTimeString = `${editedDate} ${editedTime}`;
  console.log(dateTimeString);

  fetch("../Server/routes/createBooking.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({
      datetime: dateTimeString,
    }),
  })
    .then((res) => res.json())
    .then((data) => {
      if (data.success) {
        alert("Your booking has been created!");
        window.location.href = "book_a_table.php";
      }
    })
    .catch((error) => {
      console.log(error);
    });
}

const selectTheDate = document.getElementById("date");
if (selectTheDate) {
  // Add event listener to date select element
  selectTheDate.addEventListener("change", function () {
    // const radioButtons = document.querySelectorAll(
    //   'input[name="date"]:checked'
    // );
    //let selectedValue = "";

    const selectedValue = document.querySelector(
      'input[name="date"]:checked'
    ).value;

    // // Loop through each radio button
    // radioButtons.forEach((radioButton) => {
    //   // Check if the radio button is checked
    //   if (radioButton.checked) {
    //     // If checked, store its value
    //     selectedValue = radioButton.value;
    //   }
    // });

    //console.log(selectedValue);

    // Call with selected date
    const edited = selectedValue.replace("/", "");
    populateTimeSlots(edited);
  });
}

function populateTimeSlots(selectedDate) {
  let selectTime = document.getElementById("time");
  let timeSlots = "";

  selectTime.innerHTML = "";

  fetch("../Server/routes/check_booking_times.php", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify({ selectedDate: selectedDate }),
  })
    .then((res) => res.json())
    .then((data) => {
      for (const timestamp in data.availability) {
        if (data.availability.hasOwnProperty(timestamp)) {
          let isAvailable = data.availability[timestamp];
          let time = new Date(timestamp);

          let today = new Date();
          let isToday = today.toDateString() === time.toDateString();
          //console.log(today);
          //console.log(time);

          if (!isToday || (isToday && time > today)) {
            let formattedTime = time.toLocaleTimeString([], {
              hour: "2-digit",
              minute: "2-digit",
            });
            let optionValue = timestamp.split(" ")[1].substring(0, 5);
            let optionText = formattedTime;

            if (isAvailable) {
              timeSlots +=
                '<label> <input type="radio" name="time" value=' +
                optionValue +
                "/><span>" +
                optionText +
                "</span></label>";
            }
          }
        }
      }
      selectTime.innerHTML = timeSlots;
    })
    .catch((error) => {
      console.error("Error:", error);
    });
}

// Populate the dates in the form
// Allows for current date + 5 days from today
function populateDates() {
  const currentDate = new Date();

  let maxDate = new Date();
  maxDate.setDate(currentDate.getDate() + 5);

  let selectDate = document.getElementById("date");
  let options = "";

  for (
    let date = currentDate;
    date <= maxDate;
    date.setDate(date.getDate() + 1)
  ) {
    var formattedDate = date.toISOString().split("T")[0]; // Format date as YYYY-MM-DD
    options +=
      '<label> <input type="radio" name="date" value=' +
      formattedDate +
      "/><span>" +
      formattedDate +
      "</span></label>";
    // '<option value="' + formattedDate + '">' + formattedDate + "</option>";
  }

  selectDate.innerHTML = options;
}

// Navigation Menu (Smaller Screen)
let nav_button = document.querySelector(".nav .fa-bars");
let nav = document.querySelector(".nav ul");

nav_button.addEventListener("click", function () {
  nav.classList.toggle("shownav");
});

// const startTime = new Date(selectedDate + "T13:00:00");
// const endTime = new Date(selectedDate + "T21:00:00");

// for (
//   let time = startTime;
//   time <= endTime;
//   time.setMinutes(time.getMinutes() + 30)
// ) {
//   let formattedTime = time.toLocaleTimeString([], {
//     hour: "2-digit",
//     minute: "2-digit",
//   });
//   let optionValue = time.toISOString().split("T")[1].substring(0, 5);
//   let optionText = formattedTime;

//   // Check which times are available.
//   let isAvailable = true;

//   if (isAvailable) {
//     selectTime.innerHTML +=
//       '<label> <input type="radio" name="time" value=' +
//       optionValue +
//       "/><span>" +
//       optionText +
//       "</span></label>";
//   }
