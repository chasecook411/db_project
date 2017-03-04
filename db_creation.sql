USE my_db;

CREATE TABLE IF NOT EXISTS users (
	user_id		INTEGER NOT NULL AUTO_INCREMENT,
	f_name		VARCHAR(15) NOT NULL,
	l_name		VARCHAR(15) NOT NULL,
	email 		VARCHAR(320) NOT NULL UNIQUE,
	password 	VARCHAR(30) NOT NULL,
	PRIMARY KEY (user_id)
);

CREATE TABLE IF NOT EXISTS follows (
	follower		INTEGER NOT NULL,
	following		INTEGER NOT NULL,
	followed_date	TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
	FOREIGN KEY (follower) REFERENCES users(user_id),
	FOREIGN KEY (following) REFERENCES users(user_id)
);

CREATE TABLE IF NOT EXISTS posts (
	user_id		INTEGER NOT NULL,
	post_id		INTEGER NOT NULL AUTO_INCREMENT,
	post_time	DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
	content		MEDIUMTEXT NOT NULL,
	author_id	INTEGER NOT NULL,
	num_likes	INTEGER NOT NULL DEFAULT 0,
	parent_id	INTEGER,
	
	PRIMARY KEY (post_id),
	FOREIGN KEY (user_id) REFERENCES users(user_id),
	FOREIGN KEY (author_id) REFERENCES users(user_id)
);

CREATE TABLE IF NOT EXISTS likes (
	post_id		INTEGER NOT NULL,
	user_id		INTEGER NOT NULL,
	
	FOREIGN KEY (user_id) REFERENCES users(user_id),
	FOREIGN KEY (post_id) REFERENCES posts(post_id)
);


/* 
INSERT INTO users (f_name, l_name, email, password) VALUES
('John', 'Smith', 'jsmith@gmail.com', 'hunter2'),
('Jane', 'Doe', 'jdoe@yahoo.com', '123abc'),
('Bernice', 'Goldman', 'bgoldman@hotmail.com', 'abc123'),
('Nikola', 'Breckenridge', 'nbreckenridge@aol.com', 'dga2B5Hgds4HP0bf'),
('Arthur', 'Jiang', 'ajiang@gmail.com', '12345');

INSERT INTO follows (follower, following) VALUES
(1, 2), (1, 3), (1, 4), (1, 5), (2, 1), (2, 3), (3, 1), (3, 5), (4, 1), (4, 2), (4, 3), (5, 1) (5, 4);

INSERT INTO posts (user_id, author_id, content, parent_id) VALUES
(1, 1, 'Hello World!', NULL),
(2, 1, 'Hello World!', NULL),
(3, 3, 'Hello to you too!', 1),
(4, 4, 'I love databases.', NULL),
(5, 5, 'The sky is blue.', NULL),
(1, 4, 'I love databases.', NULL),
(3, 3, 'Well I don\'t.', 4),
(5, 5, 'Have you done the homework yet?', 4);

INSERT INTO likes (post_id, user_id) VALUES
(1, 2), (1, 3), (4, 1), (4, 5), (7, 1), (7, 5), (1, 4), (3, 4);
 */