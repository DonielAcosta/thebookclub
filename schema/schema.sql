CREATE DATABASE IF NOT EXISTS thebookclub;

use thebookclub;

CREATE TABLE IF NOT EXISTS users(
  user_id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  username VARCHAR(50) NOT NULL UNIQUE,
  password VARCHAR(255) NOT NULL,
  auth_kay VARCHAR(200),
  access_token VARCHAR(200),
  created_at TIMESTAMP NOT NULL DEFAULT current_timestamp,
  modified_at TIMESTAMP NOT NULL DEFAULT current_timestamp on UPDATE current_timestamp
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE IF NOT EXISTS books (
    books_id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(100) NOT NULL,
    author_id INT UNSIGNED NOT NULL
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE if NOT EXISTS authors(
    author_id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    nationality VARCHAR(2) NOT NULL
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE IF NOT EXISTS clubs(
    club_id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL UNIQUE,
    description VARCHAR(500),
    created_at TIMESTAMP NOT NULL DEFAULT current_timestamp,
    modified_at TIMESTAMP NOT NULL DEFAULT current_timestamp on UPDATE current_timestamp
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

CREATE TABLE IF NOT EXISTS club_members(
    member_id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    club_id INT UNSIGNED NOT NULL,
    user_id INT UNSIGNED NOT NULL,
    is_admin tinyint UNSIGNED NOT NULL,
    created_at TIMESTAMP NOT NULL DEFAULT current_timestamp,
    modified_at TIMESTAMP NOT NULL DEFAULT current_timestamp on UPDATE current_timestamp,
    unique KEY no_rep(user_id,club_id)
) ENGINE=INNODB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

create table if not exists user_books (
  user_books_id integer unsigned primary key auto_increment,
  user_id integer not null,
  book_id integer not null,
  created_at timestamp not null default current_timestamp,
  modified_at timestamp not null default current_timestamp
    on update current_timestamp,
  unique key no_rep(user_id, book_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;

create table if not exists book_scores (
	book_score_id integer unsigned primary key auto_increment,
	user_id integer unsigned not null,
	book_id integer unsigned not null,
	score tinyint unsigned,
	created_at timestamp not null default current_timestamp,
	modified_at timestamp not null default current_timestamp on update current_timestamp,
	unique key no_rep(user_id, book_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_bin;