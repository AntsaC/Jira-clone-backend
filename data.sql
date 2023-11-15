-- Insert data into the 'club' table
INSERT INTO club (id, name) VALUES
                                (1, 'Book Club 1'),
                                (2, 'Book Club 2');

-- Insert data into the 'author' table
INSERT INTO author (id, club_id, first_name, last_name) VALUES
                                                            (1, 1, 'John', 'Doe'),
                                                            (2, 1, 'Jane', 'Smith'),
                                                            (3, 2, 'Bob', 'Johnson');

-- Insert data into the 'book' table
INSERT INTO book (id, author_id, title, description) VALUES
                                                         (1, 1, 'The Art of Fiction', 'A guide to writing fiction'),
                                                         (2, 2, 'Data Science 101', 'An introduction to data science'),
                                                         (3, 3, 'History of the Universe', 'From the Big Bang to present');

-- You can continue inserting more data as needed.
