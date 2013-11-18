-- phpMyAdmin SQL Dump
-- version 4.0.1
-- http://www.phpmyadmin.net
--
-- ホスト: localhost
-- 生成日時: 2013 年 11 月 11 日 18:42
-- サーバのバージョン: 5.5.27
-- PHP のバージョン: 5.4.7

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- データベース: `battle_game`
--

-- --------------------------------------------------------

--
-- テーブルの構造 `hanabi`
--

CREATE TABLE IF NOT EXISTS `hanabi` (
  `id` int(11) NOT NULL,
  `shouhin_id` int(11) DEFAULT NULL,
  `uriage` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `hanabi`
--

INSERT INTO `hanabi` (`id`, `shouhin_id`, `uriage`) VALUES
(1, 1, 320000),
(2, 2, 160000),
(3, 3, 180000),
(4, 1, 128000),
(5, 3, 98000),
(6, 2, 140000),
(7, 1, 175000);

-- --------------------------------------------------------

--
-- テーブルの構造 `shouhin`
--

CREATE TABLE IF NOT EXISTS `shouhin` (
  `id` int(11) NOT NULL,
  `name` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- テーブルのデータのダンプ `shouhin`
--

INSERT INTO `shouhin` (`id`, `name`) VALUES
(1, 'テレビ'),
(2, 'DVD'),
(3, 'パソコン'),
(4, 'プリンター');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
