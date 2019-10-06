
DROP TABLE IF EXISTS `net2ftp_log_access`;
CREATE TABLE `net2ftp_log_access` (
  `id` int(10) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `page` text NOT NULL,
  `state` text NOT NULL,
  `state2` text NOT NULL,
  `screen` text NOT NULL,
  `skin` text NOT NULL,
  `language` text NOT NULL,
  `protocol` text NOT NULL,
  `ftpserver` varchar(254) NOT NULL,
  `ftpserver_ipaddress` varchar(15) NOT NULL,
  `ftpserver_country` char(2) NOT NULL,
  `ftpserverport` varchar(5) NOT NULL,
  `username` varchar(254) NOT NULL,
  `directory` text NOT NULL,
  `entry` text NOT NULL,
  `user_email` varchar(254) NOT NULL,
  `user_ipaddress` varchar(15) NOT NULL,
  `user_country` char(2) NOT NULL,
  `user_port` text NOT NULL,
  `user_http_user_agent` text NOT NULL,
  `datatransfer` int(10) UNSIGNED DEFAULT NULL,
  `executiontime` int(10) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `net2ftp_log_consumption_ftpserver`;
CREATE TABLE `net2ftp_log_consumption_ftpserver` (
  `date` date NOT NULL,
  `ftpserver` varchar(254) NOT NULL,
  `datatransfer` int(10) UNSIGNED NOT NULL,
  `executiontime` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `net2ftp_log_consumption_ipaddress`;
CREATE TABLE `net2ftp_log_consumption_ipaddress` (
  `date` date NOT NULL,
  `user_ipaddress` varchar(15) NOT NULL,
  `datatransfer` int(10) UNSIGNED NOT NULL,
  `executiontime` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `net2ftp_log_error`;
CREATE TABLE `net2ftp_log_error` (
  `id` int(10) UNSIGNED NOT NULL,
  `date` date NOT NULL,
  `time` time NOT NULL,
  `page` text NOT NULL,
  `state` text NOT NULL,
  `state2` text NOT NULL,
  `screen` text NOT NULL,
  `skin` text NOT NULL,
  `language` text NOT NULL,
  `protocol` text NOT NULL,
  `ftpserver` varchar(254) NOT NULL,
  `ftpserver_ipaddress` varchar(15) NOT NULL,
  `ftpserver_country` char(2) NOT NULL,
  `ftpserverport` varchar(5) NOT NULL,
  `username` varchar(254) NOT NULL,
  `directory` text NOT NULL,
  `entry` text NOT NULL,
  `user_email` varchar(254) NOT NULL,
  `user_ipaddress` varchar(15) NOT NULL,
  `user_country` char(2) NOT NULL,
  `user_port` text NOT NULL,
  `user_http_user_agent` text NOT NULL,
  `datatransfer` int(10) UNSIGNED DEFAULT NULL,
  `executiontime` int(10) UNSIGNED DEFAULT NULL,
  `message` text NOT NULL,
  `backtrace` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `net2ftp_log_status`;
CREATE TABLE `net2ftp_log_status` (
  `month` varchar(6) NOT NULL,
  `status` int(3) NOT NULL,
  `changelog` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `net2ftp_users`;


ALTER TABLE `net2ftp_log_access`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_email` (`user_email`),
  ADD KEY `ftpserver` (`ftpserver`),
  ADD KEY `user_ip` (`user_ipaddress`),
  ADD KEY `username` (`username`);

ALTER TABLE `net2ftp_log_consumption_ftpserver`
  ADD PRIMARY KEY (`date`,`ftpserver`);

ALTER TABLE `net2ftp_log_consumption_ipaddress`
  ADD PRIMARY KEY (`date`,`user_ipaddress`);

ALTER TABLE `net2ftp_log_error`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_email` (`user_email`);

ALTER TABLE `net2ftp_log_status`
  ADD PRIMARY KEY (`month`);


ALTER TABLE `net2ftp_log_access`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

ALTER TABLE `net2ftp_log_error`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;


