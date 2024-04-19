CREATE TABLE IF NOT EXISTS users(
    user_id SERIAL PRIMARY KEY,
    fullname VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL --store in hash
);
CREATE TABLE IF NOT EXISTS admins(
    admin_id SERIAL PRIMARY KEY,
    fullname VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
);
CREATE TABLE IF NOT EXISTS courses(
    course_id SERIAL PRIMARY KEY,
    name VARCHAR(50) UNIQUE
);
INSERT INTO courses (name)
VALUES ('Starter'),
    ('Main'),
    ('Dessert'),
    ('Drinks') ON CONFLICT (name) DO NOTHING;
CREATE TABLE IF NOT EXISTS menu(
    item_id SERIAL PRIMARY KEY,
    name VARCHAR(100),
    description TEXT,
    price DECIMAL(10, 2),
    images VARCHAR(250),
    courses_id INTEGER REFERENCES courses(course_id)
);
CREATE TABLE IF NOT EXISTS bookings(
    booking_id SERIAL PRIMARY KEY,
    user_id INTEGER REFERENCES users(user_id),
    booking_date TIMESTAMP,
    num_guests INTEGER
);
-- CREATE TABLE IF NOT EXISTS bookingTimes(
--     booking_time_id SERIAL PRIMARY KEY,
--     booking_time TIME
-- );
-- ALTER TABLE bookings
-- ADD COLUMN booking_time_id INTEGER REFERENCES bookingTimes(booking_time_id);
-- INSERT INTO bookingtimes (booking_time)
-- VALUES ('13:00:00'),
--     ('15:00:00'),
--     ('17:00:00'),
--     ('19:00:00'),
--     ('21:00:00'),
--     ('22:00:00');