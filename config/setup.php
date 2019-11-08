<?php
session_start();
session_unset();
//require_once('../app/core/Debugging.php'); // (De)activate debugging by (de)commenting the line.
require_once('database.php');

/* ************************************************** *\
    Connect to mysql then create and select the DB
\* ************************************************** */

$DB = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
$DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$DB->exec('CREATE DATABASE IF NOT EXISTS '.$DB_NAME);
$DB->exec('USE '.$DB_NAME);

/* ************************************************** *\
    Create the tables' structures and fill them
\* ************************************************** */

/* ------------------- USERS ------------------- */

$DB->exec("CREATE TABLE IF NOT EXISTS `users`
          (`id_user` int(11) NOT NULL AUTO_INCREMENT,
           `email` varchar(255) NOT NULL,
           `email_confirmed` varchar(255) NOT NULL,
           `username` varchar(255) NOT NULL,
           `first_name` varchar(255) NOT NULL,
           `last_name` varchar(255) NOT NULL,
           `password` varchar(255) NOT NULL,
           `last_activity` datetime NOT NULL,
           `localisation` varchar(255) DEFAULT NULL,
           `gender_self` varchar(1) DEFAULT NULL,
           `gender_seeked` varchar(1) DEFAULT NULL,
           `popularity_score` int(11) NOT NULL DEFAULT '0',
           `bio` varchar(255) NOT NULL,
           PRIMARY KEY (`id_user`)
         ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

/* ------------------- USERS_VISITS ------------------- */

$DB->exec("CREATE TABLE IF NOT EXISTS `users_visits`
          (`id_user_visitor` int(11) NOT NULL,
           `id_user_visited` int(11) NOT NULL,
           `last_visit` datetime NOT NULL,
           PRIMARY KEY (`id_user_visitor`, `id_user_visited`),
           CONSTRAINT `FK_users_visits_id_user_visitor` FOREIGN KEY (`id_user_visitor`) REFERENCES `users`(`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
           CONSTRAINT `FK_users_visits_id_user_visited` FOREIGN KEY (`id_user_visited`) REFERENCES `users`(`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
         ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

/* ------------------- USERS_LIKES ------------------- */

$DB->exec("CREATE TABLE IF NOT EXISTS `users_likes`
          (`id_user_liker` int(11) NOT NULL,
           `id_user_liked` int(11) NOT NULL,
           PRIMARY KEY (`id_user_liker`, `id_user_liked`),
           CONSTRAINT `FK_users_visits_id_user_liker` FOREIGN KEY (`id_user_liker`) REFERENCES `users`(`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
           CONSTRAINT `FK_users_visits_id_user_liked` FOREIGN KEY (`id_user_liked`) REFERENCES `users`(`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

/* ------------------- USERS_BLOCKS ------------------- */

$DB->exec("CREATE TABLE IF NOT EXISTS `users_blocks`
          (`id_user_blocker` int(11) NOT NULL,
           `id_user_blocked` int(11) NOT NULL,
           PRIMARY KEY (`id_user_blocker`, `id_user_blocked`),
           CONSTRAINT `FK_users_visits_id_user_blocker` FOREIGN KEY (`id_user_blocker`) REFERENCES `users`(`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
           CONSTRAINT `FK_users_visits_id_user_blocked` FOREIGN KEY (`id_user_blocked`) REFERENCES `users`(`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

/* ------------------- USERS_REPORTS ------------------- */

$DB->exec("CREATE TABLE IF NOT EXISTS `users_reports`
          (`id_user_reporter` int(11) NOT NULL,
           `id_user_reported` int(11) NOT NULL,
           PRIMARY KEY (`id_user_reporter`, `id_user_reported`),
           CONSTRAINT `FK_users_visits_id_user_reporter` FOREIGN KEY (`id_user_reporter`) REFERENCES `users`(`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
           CONSTRAINT `FK_users_visits_id_user_reported` FOREIGN KEY (`id_user_reported`) REFERENCES `users`(`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

/* ------------------- INTERESTS ------------------- */

$DB->exec("CREATE TABLE IF NOT EXISTS `interests`
          (`id_interest` int(11) NOT NULL AUTO_INCREMENT,
           `interest` varchar(255) NOT NULL,
           PRIMARY KEY (`id_interest`)
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

/* ------------------- USERS_INTERESTS ------------------- */

$DB->exec("CREATE TABLE IF NOT EXISTS `users_interests`
          (`id_user` int(11) NOT NULL,
           `id_interest` int(11) NOT NULL,
           PRIMARY KEY (`id_user`, `id_interest`),
           CONSTRAINT `FK_users_interests_id_user` FOREIGN KEY (`id_user`) REFERENCES `users`(`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
           CONSTRAINT `FK_users_interests_id_interest` FOREIGN KEY (`id_interest`) REFERENCES `interests`(`id_interest`) ON DELETE CASCADE ON UPDATE CASCADE
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");

/* ------------------- CHAT ------------------- */

$DB->exec("CREATE TABLE IF NOT EXISTS `chat`
          (`id_message` int(11) NOT NULL AUTO_INCREMENT,
           `id_user_1` int(11) NOT NULL,
           `id_user_2` int(11) NOT NULL,
           `message` text NOT NULL,
           `message_date` datetime NOT NULL,
           PRIMARY KEY (`id_message`),
           CONSTRAINT `FK_chat_id_user_1` FOREIGN KEY (`id_user_1`) REFERENCES `users`(`id_user`) ON DELETE CASCADE ON UPDATE CASCADE,
           CONSTRAINT `FK_chat_id_user_2` FOREIGN KEY (`id_user_2`) REFERENCES `users`(`id_user`) ON DELETE CASCADE ON UPDATE CASCADE
          ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");


$_SESSION['is_setup'] = TRUE;
header('Location: http://localhost:8081/gitmatcha/');
?>
