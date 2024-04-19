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
-- DROP TABLE bookingtimes;
CREATE TABLE bookings (
    booking_id SERIAL PRIMARY KEY,
    user_id INT NOT NULL,
    booking_date TIMESTAMP NOT NULL,
    CONSTRAINT fk_user FOREIGN KEY (user_id) REFERENCES users(user_id)
);