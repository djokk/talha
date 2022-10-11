-- phpMyAdmin SQL Dump
-- version 5.1.0
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Окт 11 2022 г., 20:04
-- Версия сервера: 8.0.24
-- Версия PHP: 7.3.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `talha_db`
--

-- --------------------------------------------------------

--
-- Структура таблицы `color`
--

CREATE TABLE `color` (
  `Id` int NOT NULL,
  `Code` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `Name` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `color`
--

INSERT INTO `color` (`Id`, `Code`, `Name`) VALUES
(1, 'C7777777', 'Black');

-- --------------------------------------------------------

--
-- Структура таблицы `history`
--

CREATE TABLE `history` (
  `Id` int NOT NULL,
  `Code` varchar(255) DEFAULT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `Color` varchar(255) DEFAULT NULL,
  `ColorId` int DEFAULT NULL,
  `ColorCode` varchar(255) NOT NULL,
  `CountEnd` int DEFAULT NULL,
  `Counts` int DEFAULT NULL,
  `Dates` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `Times` varchar(255) DEFAULT NULL,
  `Parametrs` int DEFAULT NULL,
  `Login` varchar(255) DEFAULT NULL,
  `FullName` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `history`
--

INSERT INTO `history` (`Id`, `Code`, `Name`, `Color`, `ColorId`, `ColorCode`, `CountEnd`, `Counts`, `Dates`, `Times`, `Parametrs`, `Login`, `FullName`) VALUES
(1, 'M2472852', 'asd', 'Black', 1, 'C7777777', 2, 10, '10/11/22', '19:57', 0, 'admin', 'Администратор'),
(2, 'M2472852', 'asd', 'Black', 1, 'C7777777', 2, 10, '10/11/22', '19:57', 0, 'admin', 'Администратор'),
(3, 'M2472852', 'asd', 'Black', 1, 'C7777777', 3, 13, '10/11/22', '20:03', 1, 'admin', 'Администратор');

-- --------------------------------------------------------

--
-- Структура таблицы `model`
--

CREATE TABLE `model` (
  `Id` int NOT NULL,
  `Code` varchar(255) DEFAULT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `Color` varchar(255) DEFAULT NULL,
  `ColorId` int DEFAULT NULL,
  `ColorCode` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `model`
--

INSERT INTO `model` (`Id`, `Code`, `Name`, `Color`, `ColorId`, `ColorCode`) VALUES
(5, 'M2472852', 'asd', 'Black', 1, 'C7777777');

-- --------------------------------------------------------

--
-- Структура таблицы `store`
--

CREATE TABLE `store` (
  `Id` int NOT NULL,
  `Code` varchar(255) DEFAULT NULL,
  `Name` varchar(255) DEFAULT NULL,
  `Color` varchar(255) DEFAULT NULL,
  `ColorId` int DEFAULT NULL,
  `ColorCode` varchar(255) DEFAULT NULL,
  `Counts` int DEFAULT NULL,
  `Dates` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL,
  `Times` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `store`
--

INSERT INTO `store` (`Id`, `Code`, `Name`, `Color`, `ColorId`, `ColorCode`, `Counts`, `Dates`, `Times`) VALUES
(1, 'M2472852', 'asd', 'Black', 1, 'C7777777', 13, '10/10/22', '02:04');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `Id` int NOT NULL,
  `Login` varchar(255) DEFAULT NULL,
  `Password` varchar(255) DEFAULT NULL,
  `FullName` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`Id`, `Login`, `Password`, `FullName`) VALUES
(1, 'admin', 'admin', 'Администратор');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `color`
--
ALTER TABLE `color`
  ADD PRIMARY KEY (`Id`);

--
-- Индексы таблицы `history`
--
ALTER TABLE `history`
  ADD PRIMARY KEY (`Id`);

--
-- Индексы таблицы `model`
--
ALTER TABLE `model`
  ADD PRIMARY KEY (`Id`);

--
-- Индексы таблицы `store`
--
ALTER TABLE `store`
  ADD PRIMARY KEY (`Id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`Id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `color`
--
ALTER TABLE `color`
  MODIFY `Id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT для таблицы `history`
--
ALTER TABLE `history`
  MODIFY `Id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT для таблицы `model`
--
ALTER TABLE `model`
  MODIFY `Id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT для таблицы `store`
--
ALTER TABLE `store`
  MODIFY `Id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `Id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
