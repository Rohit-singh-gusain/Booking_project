-- phpMyAdmin SQL Dump
-- version 4.9.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Creation time: 28 May 2021 at 14:22:24
-- Server version: 5.7.32
-- PHP version: 7.4.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: 'phpflix_db'
--

-- --------------------------------------------------------

--
-- Table structure for table 't_admins'
--

CREATE TABLE `t_admins` (
  `adminID` int(11) NOT NULL,
  `adminUsername` varchar(50) NOT NULL,
  `adminPassword` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Insert data in the 't_admins' table
--

INSERT INTO `t_admins` (`adminID`, `adminUsername`, `adminPassword`) VALUES
(4, 'admin1', '0192023a7bbd73250516f069df18b500');

-- --------------------------------------------------------

--
-- Table structure for table 't_booking`
--

CREATE TABLE `t_booking` (
  `bookingID` int(11) NOT NULL,
  `movieID` int(11) NOT NULL,
  `firstName` varchar(100) NOT NULL,
  `lastName` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `phoneNumber` varchar(15) NOT NULL,
  `bookDate` varchar(30) NOT NULL,
  `bookTime` varchar(10) NOT NULL,
  `rowLetter` varchar(10) NOT NULL,
  `colNumber` varchar(15) NOT NULL,
  `username` varchar(100) NOT NULL,
  `bookTimestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Insert data in the `t_booking` table
--

INSERT INTO `t_booking` (`bookingID`, `movieID`, `firstName`, `lastName`, `email`, `phoneNumber`, `bookDate`, `bookTime`, `rowLetter`, `colNumber`, `username`, `bookTimestamp`) VALUES
(43, 1, 'Χρήστος', 'Μπάντης', 'chr.bandis@gmail.com', '6973979235', 'Wednesday 3 June', '18:00', 'Row B', 'Number 2', 'user', '2021-05-24 12:19:41'),
(45, 8, 'Χρήστος', 'Μπάντης', 'email@email.com', '6973979235', 'Thursday 2 June', '21:00', 'Row A', 'Line 4', 'admin', '2021-05-28 07:49:15'),
(47, 5, 'Χρήστος', 'Μπάντης', 'guest@guest.com', '6973979235', 'Wednesday 3 June', '23:00', 'Row G', 'Number 3', 'guest', '2021-05-28 07:50:27');

-- --------------------------------------------------------

--
-- Table structure for the table `t_movies`
--

CREATE TABLE `t_movies` (
  `movieID` int(11) NOT NULL,
  `movieTitle` varchar(100) NOT NULL,
  `movieLogo` varchar(150) NOT NULL,
  `movieDesc` varchar(500) NOT NULL,
  `movieGenre` varchar(50) NOT NULL,
  `movieCast` varchar(150) NOT NULL,
  `movieDuration` varchar(10) NOT NULL,
  `movieRelDate` varchar(25) NOT NULL,
  `movieCover` varchar(150) NOT NULL,
  `movieTrailer` varchar(500) NOT NULL,
  `movieSeats` int(11) NOT NULL,
  `movieLink` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Insert data in the `t_movies` table
--

INSERT INTO `t_movies` (`movieID`, `movieTitle`, `movieLogo`, `movieDesc`, `movieGenre`, `movieCast`, `movieDuration`, `movieRelDate`, `movieCover`, `movieTrailer`, `movieSeats`, `movieLink`) VALUES
(1, 'Bohemian Rhapsody', '../images/movie-logos/bohemian-rhapsody-logo.png', 'Bohemian Rhapsody is a foot-stomping celebration of Queen, their music and their extraordinary lead singer Freddie Mercury. Freddie defied stereotypes and shattered convention to become one of the most beloved entertainers on the planet.', 'Biography, Drama, Music', 'Rami Malek, Lucy Boynton, Gwilym Lee', '2h 14min', '1 November 2018', '../images/movies/Bohemian-Rapsody.jpg', '<iframe width=\"1116\" height=\"630\" src=\"https://www.youtube.com/embed/mP0VHJYFOAU?controls=0&autoplay=1&mute=1\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>\r\n\r\n', 100, 'bohemian-rhapsody'),
(2, 'Fight Club', '../images/movie-logos/fight-club-logo.png', 'An insomniac office worker and a devil-may-care soap maker form an underground fight club that evolves into much more.', 'Drama', 'Brad Pitt, Edward Norton, Meat Loaf', '2h 19min', '18 February 2000', '../images/movies/Fight-Club.jpg', '<iframe width=\"1116\" height=\"630\" src=\"https://www.youtube.com/embed/qtRKdVHc-cE?controls=0&autoplay=1&mute=1\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', 80, 'fight-club'),
(3, 'Focus', '../images/movie-logos/focus-logo.png', 'In the midst of veteran con man Nicky\'s latest scheme, a woman from his past - now an accomplished femme fatale - shows up and throws his plans for a loop.', 'Comedy, Crime, Drama', 'Will Smith, Margot Robbie, Rodrigo Santoro', '1h 45min', '5 March 2015', '../images/movies/Focus.jpg', '<iframe width=\"1116\" height=\"630\" src=\"https://www.youtube.com/embed/MxCRgtdAuBo?controls=0&autoplay=1&mute=1\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', 40, 'focus'),
(4, 'Gemini Man', '../images/movie-logos/gemini-man-logo.png', 'An over-the-hill hitman faces off against a younger clone of himself.', 'Action, Drama, Sci-Fi', 'Will Smith, Mary Elizabeth Winstead, Clive Owen', '1h 57min', '10 October 2019', '../images/movies/gemi-man.jpg', '<iframe width=\"560\" height=\"315\" src=\"https://www.youtube.com/embed/AbyJignbSj0?controls=0&autoplay=1&mute=1\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', 40, 'gemini-man'),
(5, 'Captain Marvel', '../images/movie-logos/captain-marvel-logo.png', 'Former Air Force pilot and intelligence agent Carol Danvers pursued her dream of space exploration as a NASA employee, but her life forever changed when she was accidentally transformed into a human-Kree hybrid with extraordinary powers.<br><br>\r\nNow, Carol is the latest warrior to embrace the mantle of Captain Marvel, and she has taken her place as one of the world\'s mightiest heroes.', 'Action, Adventure, Fantasy, Sci Fi', 'Brie Larson, Samuel L. Jackson, Ben Mendelsohn, Jude Law', '2h 3min', '7 March 2019', '../images/movies/captain-marvel.jpg', '<iframe width=\"1116\" height=\"630\" src=\"https://www.youtube.com/embed/Z1BCujX3pw8?controls=0&autoplay=1&mute=1\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', 120, 'captain-marvel'),
(6, 'Joker', '../images/movie-logos/joker-logo.png', 'In Gotham City, mentally troubled comedian Arthur Fleck is disregarded and mistreated by society. He then embarks on a downward spiral of revolution and bloody crime. This path brings him face-to-face with his alter-ego: the Joker.', 'Crime, Drama, Thriller', 'Joaquin Phoenix, Robert De Niro, Zazie Beetz', '2h 2min', '3 October 2019', '../images/movies/Joker.jpg', '<iframe width=\"1116\" height=\"630\" src=\"https://www.youtube.com/embed/zAGVQLHvwOY?controls=0&autoplay=1&mute=1\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', 90, 'joker'),
(7, 'Now You See Me 2', '../images/movie-logos/nysm2-logo.png', 'The Four Horsemen resurface, and are forcibly recruited by a tech genius to pull off their most impossible heist yet.', 'Action, Adventure, Comedy', 'Jesse Eisenberg, Mark Ruffalo, Woody Harrelson', '2h 9min', '9 June 2016', '../images/movies/NowYouSeeMe2.jpg', '<iframe width=\"1116\" height=\"630\" src=\"https://www.youtube.com/embed/4I8rVcSQbic?controls=0&autoplay=1&mute=1\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', 70, 'now-you-see-me-2'),
(8, 'The Lion King', '../images/movie-logos/lion-king-logo.png', 'Lion prince Simba and his father are targeted by his bitter uncle, who wants to ascend the throne himself.', 'Animation, Adventure, Drama', 'Matthew Broderick, Jeremy Irons, James Earl Jones', '1h 28min', '1 December 1994', '../images/movies/the-lion-king.jpg', '<iframe width=\"1116\" height=\"630\" src=\"https://www.youtube.com/embed/lFzVJEksoDY?controls=0&autoplay=1&mute=1\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', 150, 'lion-king'),
(9, 'The Accountant', '../images/movie-logos/accountant-logo.png', 'As a math savant uncooks the books for a new client, the Treasury Department closes in on his activities, and the body count starts to rise.', 'Action, Crime, Drama', 'Ben Affleck, Anna Kendrick, J.K. Simmons', '2h 8min', '20 October 2016', '../images/movies/The-Accountant.jpg', '<iframe width=\"1116\" height=\"630\" src=\"https://www.youtube.com/embed/DBfsgcswlYQ?controls=0&autoplay=1&mute=1\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', 50, 'accountant'),
(10, 'Pele', '../images/movie-logos/pele-logo.png', 'Pele\'s meteoric rise from the slums of Sao Paulo to leading Brazil to its first World Cup victory at the age of 17 is chronicled in this biographical drama.', 'Biography, Drama, Sport ', 'Vincent D\'Onofrio, Rodrigo Santoro, Diego Boneta', '1h 47min', '22 September 2016', '../images/movies/Pele.jpg', '<iframe width=\"1116\" height=\"630\" src=\"https://www.youtube.com/embed/XBrfxHOXsDE?controls=0&autoplay=1&mute=1\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', 30, 'pele'),
(11, 'A Star Is Born', '../images/movie-logos/star-born-logo.png', 'A musician helps a young singer find fame as age and alcoholism send his own career into a downward spiral.', 'Drama, Music, Romance', 'Lady Gaga, Bradley Cooper, Sam Elliott', '2h 16min', '4 October 2018', '../images/movies/Star-Born.jpg', '<iframe width=\"1116\" height=\"630\" src=\"https://www.youtube.com/embed/nSbzyEJ8X9E?controls=0&autoplay=1&mute=1\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', 60, 'star-born'),
(12, 'The Town', '../images/movie-logos/the-town-logo.png', 'A longtime thief, planning his next job, tries to balance his feelings for a bank manager connected to an earlier heist, and a hell-bent F.B.I Agent looking to bring him and his crew down.', 'Crime, Drama, Thriller ', 'Ben Affleck, Rebecca Hall, Jon Hamm ', '2h 5min', '21 October 2010', '../images/movies/The-Town.jpg', '<iframe width=\"1116\" height=\"630\" src=\"https://www.youtube.com/embed/WcXt9aUMbBk?controls=0&autoplay=1&mute=1\" title=\"YouTube video player\" frameborder=\"0\" allow=\"accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture\" allowfullscreen></iframe>', 30, 'the-town');

-- --------------------------------------------------------

--
-- Table structure for the table `t_users`
--

CREATE TABLE `t_users` (
  `userID` int(11) NOT NULL,
  `firstName` varchar(100) NOT NULL,
  `lastName` varchar(100) NOT NULL,
  `username` varchar(100) NOT NULL,
  `phoneNumber` varchar(20) NOT NULL,
  `email` varchar(100) NOT NULL,
  `pass` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Insert data in the `t_users` table
--

INSERT INTO `t_users` (`userID`, `firstName`, `lastName`, `username`, `phoneNumber`, `email`, `pass`) VALUES
(7, 'Χρήστος', 'Μπάντης', 'user', '6973979235', 'chr.bandis@gmail.com', '$2y$10$SojEi37etAsM1BXvYBj65u5UWDOLV0kw0Jh.d3cHKo18sPa1c.t3q');

--
-- Indexes for unused tables
--

--
-- Indexes for table 't_admins'
--
ALTER TABLE `t_admins`
  ADD PRIMARY KEY (`adminID`);

--
-- Indexes for table `t_booking`
--
ALTER TABLE `t_booking`
  ADD PRIMARY KEY (`bookingID`),
  ADD KEY `FK_movieID` (`movieID`);

--
-- Indexes for table `t_movies`
--
ALTER TABLE `t_movies`
  ADD PRIMARY KEY (`movieID`);

--
-- Indexes for table `t_users`
--
ALTER TABLE `t_users`
  ADD PRIMARY KEY (`userID`);

--
-- AUTO_INCREMENT for unused tables
--

--
-- AUTO_INCREMENT for table `t_admins`
--
ALTER TABLE `t_admins`
  MODIFY `adminID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `t_booking`
--
ALTER TABLE `t_booking`
  MODIFY `bookingID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=48;

--
-- AUTO_INCREMENT for table `t_movies`
--
ALTER TABLE `t_movies`
  MODIFY `movieID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `t_users`
--
ALTER TABLE `t_users`
  MODIFY `userID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- Limitations for unused tables
--

--
-- Constraints for table 't_booking'
--
ALTER TABLE `t_booking`
  ADD CONSTRAINT `FK_movieID` FOREIGN KEY (`movieID`) REFERENCES `t_movies` (`movieID`) ON DELETE CASCADE ON UPDATE CASCADE;
