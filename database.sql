-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Фев 03 2023 г., 22:47
-- Версия сервера: 5.6.51
-- Версия PHP: 7.4.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `explorer-web`
--

-- --------------------------------------------------------

--
-- Структура таблицы `access`
--

CREATE TABLE `access` (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT 'ID',
  `file` bigint(20) UNSIGNED NOT NULL COMMENT 'Файл',
  `user` bigint(20) UNSIGNED NOT NULL COMMENT 'Пользователь',
  `flag` tinyint(3) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Параметры'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `file`
--

CREATE TABLE `file` (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT 'ID',
  `name` varchar(255) NOT NULL COMMENT 'Имя',
  `user` bigint(20) UNSIGNED NOT NULL COMMENT 'Владелец',
  `path` varchar(255) NOT NULL COMMENT 'Путь',
  `onUpdate` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Дата создания'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `file`
--

INSERT INTO `file` (`id`, `name`, `user`, `path`, `onUpdate`) VALUES
(38, 'Appr32r23Asset.php', 7, 's1_i6skpDGhEmROR2bFgAReTVnWaHJU0', '2023-02-03 18:43:58'),
(39, 'cg', 7, 'hEGzJfujxkoCwwjDx8wlQy8wvleZjBtt', '2023-02-03 18:45:16'),
(40, 'README.md', 7, 'G4w4wauzQYA4SmE3NQeN6ARJqDbfKQ7J', '2023-02-03 18:46:57'),
(41, 'LICENSE.md', 7, 'VELyUUSxx1iTawi4SRrq00civ1S0OXR_', '2023-02-03 18:47:25'),
(42, 'cg435', 7, 's6ZJN4uRVgxQpdIGlv9OqpzfOYxfWqe4', '2023-02-03 18:47:55'),
(44, 'unnamed', 7, '4jOC-uv5FeiB5ehE1rkfiKTXNpIwXv1w', '2023-02-03 19:46:16');

-- --------------------------------------------------------

--
-- Структура таблицы `user`
--

CREATE TABLE `user` (
  `id` bigint(20) UNSIGNED NOT NULL COMMENT 'ID',
  `login` varchar(255) NOT NULL COMMENT 'Логин',
  `password` varchar(255) NOT NULL COMMENT 'Пароль',
  `rule` tinyint(3) UNSIGNED NOT NULL DEFAULT '0' COMMENT 'Тип'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `user`
--

INSERT INTO `user` (`id`, `login`, `password`, `rule`) VALUES
(1, 'admin@mail.ru', '21232f297a57a5a743894a0e4a801fc3', 1),
(7, 'user1@mail.ru', '81dc9bdb52d04dc20036dbd8313ed055', 0);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `access`
--
ALTER TABLE `access`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `file` (`file`,`user`),
  ADD KEY `user` (`user`);

--
-- Индексы таблицы `file`
--
ALTER TABLE `file`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user` (`user`);

--
-- Индексы таблицы `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `login` (`login`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `access`
--
ALTER TABLE `access`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID';

--
-- AUTO_INCREMENT для таблицы `file`
--
ALTER TABLE `file`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT для таблицы `user`
--
ALTER TABLE `user`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT 'ID', AUTO_INCREMENT=9;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `access`
--
ALTER TABLE `access`
  ADD CONSTRAINT `access_ibfk_1` FOREIGN KEY (`file`) REFERENCES `file` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `access_ibfk_2` FOREIGN KEY (`user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ограничения внешнего ключа таблицы `file`
--
ALTER TABLE `file`
  ADD CONSTRAINT `file_ibfk_1` FOREIGN KEY (`user`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
