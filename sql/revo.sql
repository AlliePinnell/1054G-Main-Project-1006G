-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Apr 02, 2025 at 10:19 PM
-- Server version: 8.0.39
-- PHP Version: 8.2.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `revo`
--

-- --------------------------------------------------------

--
-- Table structure for table `revoaccounts`
--

CREATE TABLE `revoaccounts` (
  `accountid` int NOT NULL,
  `handle` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `fname` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `lname` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `psword` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `monthEntry` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `dayEntry` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `yearEntry` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `profileImage` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'img/tempPfp.png',
  `profileName` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'ProfilePicture',
  `bannerImage` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'img/tempBackground.png',
  `bannerName` varchar(255) COLLATE utf8mb4_general_ci NOT NULL DEFAULT 'ProfileBackground'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `revoaccounts`
--

INSERT INTO `revoaccounts` (`accountid`, `handle`, `fname`, `lname`, `email`, `psword`, `monthEntry`, `dayEntry`, `yearEntry`, `profileImage`, `profileName`, `bannerImage`, `bannerName`) VALUES
(1, '@admin', 'Admin', 'Admin', 'admin@revo.com', '4d0b24ccade22df6d154778cd66baf04288aae26df97a961f3ea3dd616fbe06dcebecc9bbe4ce93c8e12dca21e5935c08b0954534892c568b8c12b92f26a2448', 'Jan', '01', '2000', 'img/tempPfp.png', 'ProfilePicture', 'img/tempBackground.png', 'ProfileBackground'),
(2, '@AlliePin', 'Allie', 'Pinnell', 'arpinne1@lakeheadu.ca', 'e958fe463ed417367155bb52c8dcb5e58a7ad1d455c327b6154a2c5d65224c33699f83c508084f35acc93f72a78395a5e567be9daa2854fc80cd95888750d730', 'Dec', '28', '2006', 'img/profilePics/49w0f41wgql91.jpg', 'ProfilePicture', 'img/profileBanners/9aade22d3f397b10afdf6efcb920dea9.jpg', 'ProfileBackground'),
(3, '@WataruHibikiFan90', 'Emma', 'Sauve', 'esauve@lakeheadu.ca', 'a70ff1b693541450b84d313792224190387f271eb5510dc4eb273363934ae8d034aa56b967c860acb53024e7a45d8cc288539aa4982d51fae02491e481a4041a', 'Apr', '28', '2006', 'img/profilePics/8dc18ea7d616a27baa0bb1b4208124eb.jpg', 'ProfilePicture', 'img/profileBanners/29_Wataru_Hibiki_CG2.webp', 'ProfileBackground'),
(4, '@totallynotanakinskywalker', 'Darth', 'Vader', 'obiwanstinks@lucasfilm.com', '06562df92eb8a333d54ebc88b8e042d6a260870197b818aefc0f1eefd12e530b7463c742dded5d202f1a0dd4bc467b556b2a413e2d708620c75d86660634408a', 'Apr', '19', '1991', 'img/profilePics/image_67b709e4.jpeg', 'ProfilePicture', 'img/profileBanners/death_star_banner_image_by_cmanciecko_d7g6wmz-fullview.jpg', 'ProfileBackground'),
(5, '@bazinga', 'Sheldon', 'Cooper', 'shelcoop@genius.org', 'f55ee1fc3f3748f55e58fbc285240a90b6501c0c7cd94805412c2c48c4ee12004648d051ea617625665ddcef977004e557b4370ce5d757fd5d396ab48251b567', 'Feb', '26', '1990', 'img/profilePics/sheldon.jpg', 'ProfilePicture', 'img/profileBanners/sheldon.jpg', 'ProfileBackground');

-- --------------------------------------------------------

--
-- Table structure for table `revoactions`
--

CREATE TABLE `revoactions` (
  `actionid` int NOT NULL,
  `handle` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `postid` int NOT NULL,
  `played` tinyint(1) NOT NULL DEFAULT '0',
  `replayed` tinyint(1) NOT NULL DEFAULT '0',
  `recorded` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `revoactions`
--

INSERT INTO `revoactions` (`actionid`, `handle`, `postid`, `played`, `replayed`, `recorded`) VALUES
(1, '@Admin', 1, 1, 1, 1),
(2, '@AlliePin', 1, 1, 1, 1),
(3, '@WataruHibikiFan90', 1, 1, 1, 1),
(4, '@totallynotanakinskywalker', 1, 1, 1, 1),
(5, '@bazinga', 1, 1, 1, 1),
(6, '@Admin', 2, 1, 0, 0),
(7, '@WataruHibikiFan90', 2, 0, 0, 1),
(8, '@totallynotanakinskywalker', 2, 0, 1, 0),
(9, '@AlliePin', 3, 1, 1, 1),
(10, '@WataruHibikiFan90', 3, 1, 1, 1),
(11, '@Admin', 4, 1, 0, 0),
(12, '@totallynotanakinskywalker', 4, 0, 0, 1),
(13, '@AlliePin', 5, 1, 1, 1),
(14, '@bazinga', 5, 0, 1, 0),
(15, '@WataruHibikiFan90', 6, 1, 0, 0),
(16, '@totallynotanakinskywalker', 6, 0, 0, 1),
(17, '@Admin', 8, 1, 1, 1),
(18, '@bazinga', 8, 1, 1, 1),
(19, '@AlliePin', 9, 1, 0, 1),
(20, '@WataruHibikiFan90', 10, 0, 1, 0),
(21, '@Admin', 11, 1, 1, 1),
(22, '@bazinga', 12, 1, 1, 0),
(23, '@totallynotanakinskywalker', 13, 1, 0, 1),
(24, '@WataruHibikiFan90', 14, 0, 1, 1),
(25, '@Admin', 15, 1, 1, 0),
(26, '@bazinga', 16, 1, 1, 1),
(27, '@AlliePin', 17, 0, 1, 0),
(28, '@WataruHibikiFan90', 18, 1, 0, 1),
(29, '@totallynotanakinskywalker', 19, 0, 1, 1),
(30, '@Admin', 20, 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `revoposts`
--

CREATE TABLE `revoposts` (
  `postid` int NOT NULL,
  `handle` varchar(255) COLLATE utf8mb4_general_ci NOT NULL,
  `content` text COLLATE utf8mb4_general_ci NOT NULL,
  `plays` int DEFAULT '0',
  `replays` int DEFAULT '0',
  `records` int DEFAULT '0',
  `eraTag` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `revoposts`
--

INSERT INTO `revoposts` (`postid`, `handle`, `content`, `plays`, `replays`, `records`, `eraTag`) VALUES
(1, '@admin', 'Welcome to Revo!', 5, 5, 5, 20),
(2, '@AlliePin', 'Man, Sonic CD is such an amazing game with an even better soundtrack (if you played the american version). Truly the peak of 2D Sonic!', 2, 1, 1, 90),
(3, '@AlliePin', 'I really hate that one social link in Persona 3 Portable...stupid Kenji', 2, 2, 2, 10),
(4, '@AlliePin', 'lol remember when Youtube was actually usable and was not just non-stop ads XD', 1, 0, 1, 2000),
(5, '@AlliePin', 'Back to the Future is a timeless sci-fi comedy brimming with charm, humor, and adventure. Michael J. Fox as Marty McFly and Christopher Lloyd as the eccentric Doc Brown create unforgettable chemistry. The clever script, thrilling time travel escapades, and 80s nostalgia make it a standout classic.', 1, 2, 1, 80),
(6, '@AlliePin', 'Never will get how Among Us was so big...there really is not that much to it, but maybe a free online game during COVID is reason enough for its fame', 1, 0, 1, 20),
(8, '@WataruHibikiFan90', 'miku miku ou e ou ^W^', 2, 2, 2, 2000),
(9, '@WataruHibikiFan90', 'just bought this game called Danganronpa: Trigger Happy Havoc, I hope it is peak', 1, 0, 2, 20),
(10, '@WataruHibikiFan90', 'Anyone know where to get the elusive Garfield Phone...I will give everything I hold dear for it.', 0, 1, 0, 80),
(11, '@WataruHibikiFan90', 'I LOVE CHEESE BALLS!!! THANK YOU PLANTERS', 1, 1, 1, 90),
(12, '@WataruHibikiFan90', 'Bout to go to Chuck E. Cheese with my girlfriend, planning to go Five Nights in a row!', 1, 1, 0, 90),
(13, '@WataruHibikiFan90', 'If Wataru has 1,000,000 fans, I am one of them. If Wataru has 100 fans, I am one of them. If Wataru has 10 fans, I am one of them. If Wataru has 1 fan, I am that fan. If Wataru has 0 fans, I no longer exist.', 1, 0, 1, 10),
(14, '@totallynotanakinskywalker', 'Revenge of the Sith is honestly a trash movie. Anakin should\'ve won against Obi-Wan, that\'s just an objective fact.', 0, 0, 0, 2000),
(15, '@totallynotanakinskywalker', 'Quick question, what would be the correct response to your boss throwing your co-worker out of a window with lightning? Asking for a friend.', 0, 0, 0, 2000),
(16, '@totallynotanakinskywalker', 'yo, dudes. the empires pretty chill. maybe you could, like, join it or something.', 0, 0, 0, 2000),
(17, '@bazinga', 'Bazinga!', 0, 1, 0, 2000),
(18, '@bazinga', 'Solving a Rubik\'s Cube is child\'s play. The complexity is merely superficial; with a solid understanding of algorithms and spatial reasoning, any sufficiently intelligent individual can crack it in mere minutes. I myself achieved mastery of the cube at the tender age of 8. It\'s not rocket science—although I could do that too, of course. #Bazinga', 0, 0, 0, 80),
(19, '@bazinga', 'The autograph of Leonard Nimoy—a tangible link to Spock, the epitome of logic and wisdom. Holding it was a moment of profound triumph. And the napkin with his DNA? The scientific possibilities are endless. The dream of cloning perfection lives on. Live long and prosper! 🖖 #Bazinga', 0, 1, 1, 90),
(20, '@bazinga', 'Playing Halo with Leonard, Howard, and Raj is always an exercise in patience. Leonard struggles with coordination, Howard adds unnecessary flair, and Raj holds his own—barely. Thankfully, my strategic genius keeps us victorious. Master Chief would approve. #Bazinga', 1, 1, 1, 2000);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `revoaccounts`
--
ALTER TABLE `revoaccounts`
  ADD PRIMARY KEY (`accountid`),
  ADD UNIQUE KEY `handle` (`handle`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `revoactions`
--
ALTER TABLE `revoactions`
  ADD PRIMARY KEY (`actionid`),
  ADD KEY `handle` (`handle`),
  ADD KEY `postid` (`postid`);

--
-- Indexes for table `revoposts`
--
ALTER TABLE `revoposts`
  ADD PRIMARY KEY (`postid`),
  ADD KEY `handle` (`handle`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `revoaccounts`
--
ALTER TABLE `revoaccounts`
  MODIFY `accountid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `revoactions`
--
ALTER TABLE `revoactions`
  MODIFY `actionid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=31;

--
-- AUTO_INCREMENT for table `revoposts`
--
ALTER TABLE `revoposts`
  MODIFY `postid` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `revoactions`
--
ALTER TABLE `revoactions`
  ADD CONSTRAINT `revoactions_ibfk_1` FOREIGN KEY (`handle`) REFERENCES `revoaccounts` (`handle`),
  ADD CONSTRAINT `revoactions_ibfk_2` FOREIGN KEY (`postid`) REFERENCES `revoposts` (`postid`);

--
-- Constraints for table `revoposts`
--
ALTER TABLE `revoposts`
  ADD CONSTRAINT `revoposts_ibfk_1` FOREIGN KEY (`handle`) REFERENCES `revoaccounts` (`handle`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
