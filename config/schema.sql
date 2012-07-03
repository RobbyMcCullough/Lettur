-- phpMyAdmin SQL Dump
-- version 3.3.3
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Jan 27, 2011 at 02:33 AM
-- Server version: 5.1.49
-- PHP Version: 5.3.3-1ubuntu9.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `lettur`
--

-- --------------------------------------------------------

--
-- Table structure for table `posts`
--

DROP TABLE IF EXISTS `posts`;
CREATE TABLE IF NOT EXISTS `posts` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `post_date` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00' ON UPDATE CURRENT_TIMESTAMP,
  `post_title` varchar(150) COLLATE utf8_unicode_ci NOT NULL,
  `post_content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `post_excerpt` text COLLATE utf8_unicode_ci NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `posts_meta`
--

DROP TABLE IF EXISTS `posts_meta`;
CREATE TABLE IF NOT EXISTS `posts_meta` (
  `post_id` bigint(20) unsigned NOT NULL,
  `post_url` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `post_fulltext` longtext COLLATE utf8_unicode_ci NOT NULL,
  `post_author_ip` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `post_views_day` bigint(20) unsigned NOT NULL,
  `post_views_week` bigint(20) unsigned NOT NULL,
  `post_views_month` bigint(20) unsigned NOT NULL,
  `post_views_year` bigint(20) unsigned NOT NULL,
  `post_views` bigint(20) unsigned NOT NULL,
  `post_remove_ads` int(1) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`post_id`),
  KEY `post_id` (`post_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

