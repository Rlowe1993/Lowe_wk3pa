SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";

-- Database: sdc310_wk3pa
CREATE DATABASE IF NOT EXISTS sdc310_wk3pa DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE sdc310_wk3pa;

-- Table structure for table personal_info
DROP TABLE IF EXISTS personal_info;
CREATE TABLE personal_info (
  UserNo int(11) NOT NULL,
  FullName varchar(50) NOT NULL,
  Birthdate varchar(25) NOT NULL,
  FavoriteColor varchar(50) NOT NULL,
  FavoritePlace varchar(50) NOT NULL,
  Nickname varchar(25) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


-- Data for table personal_info
INSERT INTO personal_info (UserNo, FullName, Birthdate, FavoriteColor, FavoritePlace, Nickname) VALUES
(1, 'Administrator', 'January 1, 2000', 'Green', 'Home', 'Admin'),
(2, 'Your Name', 'Your B-Day', 'Your Color', 'Your Place', 'Nickname');

-- Indexes for table personal_info
ALTER TABLE personal_info
  ADD PRIMARY KEY (UserNo);

-- AUTO_INCREMENT for table personal_info
ALTER TABLE personal_info
  MODIFY UserNo int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;
