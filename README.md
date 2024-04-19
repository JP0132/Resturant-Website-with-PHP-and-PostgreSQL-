# Resturant Website with PHP and PostgreSQL

A project where I used php to create a resturant website, using php with JavaScript and CSS on the frontend and php and PostgreSQL on the backend. The project purpose was to create a resturant website using PHP where the user can view the menu, and then book a table. Admins of the website will be able to login to a dashboard where they can view the upcoming bookings, and also make changes to the menu.

- PHP was used to create the frontend pages, with JS and CSS for functionality and styling.
- For the database used PostgreSQL, creating a relational database using sql.
- Connected to the database using PHP, using OOP style, creating a database class, to allow easy access to the database.
- Created classes for each table, to easily create methods handle different requests.
- On the backend used PHP to create routes for differnet requests, to easily fetch to using JS and allow to check the data before procedding with the request, in the class methods.
- Used fetch API in JavaScript to connect the backend to the frontend.

## Requirements

- PostgreSQL installed for the database.
- Code editor for Server and Client, I used Visual Studio Code.
- Programmed on Windows, to run the php files I used XAMPP.
- Compatible browser like Chrome, Firefox and etc.

## Setup

Before running the application.

- If using XAMPP, place the project into: _<path_to_xampp_location>\xampp\htdocs_

- Create a config.php file and add the following:

```php
return [
    'host' => 'localhost',
    'port' => '5432', // default port is unchanged
    'dbname' => 'your_dbname_here',
    'user' => 'postgres', // postgres is the default user name
    'password' => 'your_password_here'
];
```

- Run the SQL queries provided in the sqlStatements.sql file, this will create the tables and add in the default data.
- In the Server directory create a folder called upload.

## How it works and looks:

## User


https://github.com/JP0132/Resturant-Website-with-PHP-and-PostgreSQL-/assets/78804278/758933d2-b6f6-4397-970a-6bc0fc74ffca


## Admin


https://github.com/JP0132/Resturant-Website-with-PHP-and-PostgreSQL-/assets/78804278/bb87fab5-e6e1-4768-b039-5ba05a6a633a


## How to run it?

1. Clone the project or download the all the folders.
2. Ensure everything in setup is completed.
3. In XAMPP (or your preferred php server), start the APACHE server and then click the admin button.
4. In the window that opens, enter the path to where the Client is in the htdocs folder: _i.e. https://localhost/ResturantWebsite/Client/index.php_
5. To login into the admin dashboard use the default admin details, these will be added automatically upon first run of the website:

- Email: admin@example.com
- Password: Password1
