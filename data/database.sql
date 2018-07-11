DROP DATABASE app;
CREATE DATABASE app;

use app;

CREATE TABLE `pages` (
  `uuid` binary(16) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `pages` (`uuid`, `title`, `content`) VALUES
(0x780a971e854311e891dd0242ac190002, 'title', 'content');

CREATE TABLE `rewrites` (
  `source` varchar(255) NOT NULL,
  `target` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;


INSERT INTO `rewrites` (`source`, `target`) VALUES
('/', '/cms/780a971e-8543-11e8-91dd-0242ac190002'),
('/test', '/cms/780a971e-8543-11e8-91dd-0242ac190002');


ALTER TABLE `pages`
  ADD PRIMARY KEY (`uuid`);

ALTER TABLE `rewrites`
  ADD PRIMARY KEY (`source`);
