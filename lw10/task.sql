CREATE DATABASE IF NOT EXISTS university CHARSET utf8;

CREATE TABLE `university`.`student`(
    `student_id` SERIAL PRIMARY KEY,
    `name` NVARCHAR(256) NOT NULL,
    `age` INT UNSIGNED NOT NULL,
    `group_id` INT UNSIGNED NOT NULL
);

CREATE TABLE `university`.`group`(
    `group_id` SERIAL PRIMARY KEY,
    `name` NVARCHAR(256) NOT NULL,
    `department_id` INT UNSIGNED NOT NULL
);

CREATE TABLE `university`.`department`(
    `department_id` SERIAL PRIMARY KEY,
    `name` NVARCHAR(256) NOT NULL
);

INSERT INTO `department`(`name`)
VALUES ('Институт Механики и Машиностроения'),
       ('Факультет Информатики и Вычислительной Техники'),
       ('Экономический Факультет');

INSERT INTO `group`(`name`, `department_id`)
VALUES ('Машиностроение', 1),
       ('Агроинженерия', 1),
       ('Мехатроника и Робототехника', 1),
       ('Информатика и вычислительная техника', 2),
       ('Программная инженерия', 2),
       ('Информационная безопасность', 2),
       ('Прикладная информатика', 3),
       ('Экономика', 3),
       ('Финансы и кредит', 3);

INSERT INTO
    `student`(`name`, `age`, `group_id`)
VALUES
    ('Максим', 18, 1),
    ('Адам', 19, 1),
    ('Кирилл', 20, 1),
    ('Даниил', 18, 1),
    ('Анна', 19, 1),
    ('Варвара', 20, 2),
    ('Егор', 18, 2),
    ('Александр', 19, 2),
    ('Святослав', 20, 2),
    ('Сергей', 18, 2),
    ('Максим', 19, 3),
    ('Адам', 20, 3),
    ('Кирилл', 18, 3),
    ('Даниил', 19, 3),
    ('Анна', 20, 3),
    ('Варвара', 18, 4),
    ('Егор', 19, 4),
    ('Александр', 20, 4),
    ('Святослав', 18, 4),
    ('Сергей', 19, 4),
    ('Максим', 18, 5),
    ('Адам', 19, 5),
    ('Кирилл', 20, 5),
    ('Даниил', 18, 5),
    ('Анна', 19, 5),
    ('Максим', 20, 6),
    ('Адам', 18, 6),
    ('Кирилл', 19, 6),
    ('Даниил', 20, 6),
    ('Анна', 18, 6),
    ('Варвара', 19, 7),
    ('Егор', 20, 7),
    ('Александр', 18, 7),
    ('Святослав', 19, 7),
    ('Сергей', 20, 7),
    ('Максим', 18, 8),
    ('Адам', 19, 8),
    ('Кирилл', 20, 8),
    ('Даниил', 18, 8),
    ('Анна', 19, 8),
    ('Варвара', 20, 9),
    ('Егор', 18, 9),
    ('Александр', 19, 9),
    ('Святослав', 20, 9),
    ('Сергей', 18, 9);

SELECT * FROM `student` WHERE `age` = 19;

SELECT * FROM `student` WHERE `group_id` = 2;

SELECT
    `student_id`, `student`.`name`, `group`.name
FROM
    `student`
INNER JOIN
    `group` ON (`student`.`group_id` = `group`.group_id)
WHERE
    `department_id` = 2;

SELECT
    `student_id`, `student`.`name`, `group`.`name`, `department`.`name`
FROM
    `student`
LEFT JOIN
    `group` ON (`student`.`group_id` = `group`.`group_id`)
LEFT JOIN
    `department` ON (`group`.`group_id` = `department`.department_id)
WHERE
    student_id = 2;
