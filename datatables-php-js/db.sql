
-- CREATE DATABASE test DEFAULT CHARACTER SET utf8mb4 DEFAULT COLLATE utf8mb4_unicode_520_ci;
-- GRANT ALL ON test.* TO test@localhost IDENTIFIED BY 'pwd';

CREATE TABLE `tbl` (
  `id` int(11) UNSIGNED NOT NULL,
  `fname` varchar(127) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `img` varchar(127) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci NOT NULL,
  `major` varchar(127) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_520_ci DEFAULT NULL,
  `score` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `tbl` (`id`, `fname`, `img`, `major`, `score`) VALUES
(1, 'Michael', 'https://cdn.pixabay.com/photo/2012/02/24/16/59/swan-16736_1280.jpg', 'Infotech', 90),
(2, 'Maria', 'https://cdn.pixabay.com/photo/2017/03/13/10/25/hummingbird-2139279_1280.jpg', 'Operations', 70),
(3, 'Rajesh', 'https://cdn.pixabay.com/photo/2015/09/18/00/13/bird-944883_1280.jpg', 'Finance', 80),
(4, 'Ben', 'https://cdn.pixabay.com/photo/2017/05/08/13/15/spring-bird-2295434_1280.jpg', 'Infotech', 70),
(5, 'Fatimah', 'https://cdn.pixabay.com/photo/2018/08/12/16/59/parrot-3601194_1280.jpg', 'Finance', 70),
(6, 'Muhammad', 'https://cdn.pixabay.com/photo/2013/03/04/18/49/peacock-90051_1280.jpg', 'Management', 60),
(7, 'Abduallah', 'https://cdn.pixabay.com/photo/2017/07/18/18/24/dove-2516641_1280.jpg', 'Operations', 80);

ALTER TABLE `tbl`
  ADD PRIMARY KEY (`id`),
  ADD KEY `score` (`score`);

