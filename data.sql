-- Insert data into the 'club' table
INSERT INTO club (id, name)
VALUES (1, 'Book Club 1'),
       (2, 'Book Club 2');

-- Insert data into the 'author' table
INSERT INTO author (id, club_id, first_name, last_name)
VALUES (1, 1, 'John', 'Doe'),
       (2, 1, 'Jane', 'Smith'),
       (3, 2, 'Bob', 'Johnson');

-- Insert data into the 'book' table
INSERT INTO book (id, author_id, title, description)
VALUES (1, 1, 'The Art of Fiction', 'A guide to writing fiction'),
       (2, 2, 'Data Science 101', 'An introduction to data science'),
       (3, 3, 'History of the Universe', 'From the Big Bang to present');

-- Insert more test data into the review table
INSERT INTO review (id, book_id, content)
VALUES (4, 2, 'Enjoyed the characters.'),
       (5, 3, 'Interesting plot twists.'),
       (6, 1, 'Could not put it down.'),
       (7, 3, 'Disappointed with the ending.'),
       (8, 1, 'Highly recommend for mystery lovers.');

-- Insert more test data into the rate table
INSERT INTO rate (id, book_id, score)
VALUES (4, 2, 5),
       (5, 3, 4),
       (6, 1, 5),
       (7, 3, 2),
       (8, 1, 4);

ALTER SEQUENCE review_id_seq RESTART WITH 100;

-- Alter the starting value for book_id_seq
ALTER SEQUENCE book_id_seq RESTART WITH 100;

-- Alter the starting value for club_id_seq
ALTER SEQUENCE club_id_seq RESTART WITH 100;

-- Alter the starting value for author_id_seq
ALTER SEQUENCE author_id_seq RESTART WITH 100;

-- Alter the starting value for rate_id_seq
ALTER SEQUENCE rate_id_seq RESTART WITH 100;
