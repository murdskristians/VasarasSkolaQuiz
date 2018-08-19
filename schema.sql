use homestead;

CREATE TABLE quizzes (
id tinyint NOT NULL PRIMARY KEY auto_increment,
name varchar(30) NOT NULL
);

CREATE TABLE questions (
id smallint NOT NULL PRIMARY KEY auto_increment,
question varchar(250) NOT NULL,
quiz_id tinyint NOT NULL,
    FOREIGN KEY (quiz_id) REFERENCES quizzes(id)
);

CREATE TABLE answers (
id int NOT NULL PRIMARY KEY auto_increment,
answer varchar(100) NOT NULL,
question_id smallint NOT NULL,
is_correct boolean NOT NULL,
    FOREIGN KEY (question_id) REFERENCES questions(id)
);

CREATE TABLE users (
id int NOT NULL PRIMARY KEY auto_increment,
name varchar(100) NOT NULL,
created_at datetime
);

CREATE TABLE user_answers (
id int NOT NULL PRIMARY KEY auto_increment,
user_id int NOT NULL,
quiz_id tinyint NOT NULL,
answer_id int NOT NULL,
question_id smallint NOT NULL,
created_at datetime NOT NULL,
FOREIGN KEY (user_id) REFERENCES users(id),
FOREIGN KEY (quiz_id) REFERENCES quizzes(id),
FOREIGN KEY (answer_id) REFERENCES answers(id),
FOREIGN KEY (question_id) REFERENCES questions(id)
);

CREATE TABLE results (
user_id int NOT NULL,
quiz_id tinyint NOT NULL,
score tinyint NOT NULL,
created_at datetime NOT NULL,
ip varchar (15) NOT NULL,
FOREIGN KEY (user_id) REFERENCES users(id),
FOREIGN KEY (quiz_id) REFERENCES quizzes(id)
);