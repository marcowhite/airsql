-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июл 10 2020 г., 21:37
-- Версия сервера: 10.3.22-MariaDB
-- Версия PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `airsql`
--

-- --------------------------------------------------------

--
-- Структура таблицы `buses`
--

CREATE TABLE `buses` (
  `bus_type_id` int(11) UNSIGNED NOT NULL,
  `bus_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `standart_volume` int(11) NOT NULL,
  `business_volume` int(11) DEFAULT 0,
  `first_volume` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `buses`
--

INSERT INTO `buses` (`bus_type_id`, `bus_name`, `standart_volume`, `business_volume`, `first_volume`) VALUES
(1, 'Airbus', 100, 20, 10),
(2, 'Airbus A320', 96, 42, 12);

-- --------------------------------------------------------

--
-- Структура таблицы `iata_codes`
--

CREATE TABLE `iata_codes` (
  `IATA_id` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `airport_name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `airport_country` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `airport_city` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `iata_codes`
--

INSERT INTO `iata_codes` (`IATA_id`, `airport_name`, `airport_country`, `airport_city`) VALUES
('HKG', 'Hong Kong International Airport', 'Гонконг', 'Чхеклапкок'),
('VKO', 'Vnukovo International Airport', 'Россия', 'Москва');

-- --------------------------------------------------------

--
-- Структура таблицы `races`
--

CREATE TABLE `races` (
  `race_id` int(11) UNSIGNED NOT NULL,
  `bus_type_id` int(11) UNSIGNED NOT NULL,
  `IATA_from` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `IATA_to` varchar(3) COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_from` datetime NOT NULL,
  `date_to` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `races`
--

INSERT INTO `races` (`race_id`, `bus_type_id`, `IATA_from`, `IATA_to`, `date_from`, `date_to`) VALUES
(1, 1, 'HKG', 'VKO', '2019-12-24 00:00:00', '2019-12-25 00:00:00'),
(2, 1, 'VKO', 'HKG', '2019-12-25 00:00:00', '2019-12-26 00:00:00'),
(3, 1, 'VKO', 'HKG', '2019-12-28 00:00:00', '2019-12-29 00:00:00'),
(4, 1, 'HKG', 'VKO', '2020-01-03 00:00:00', '2020-01-05 00:00:00'),
(5, 1, 'VKO', 'HKG', '2020-07-22 22:22:00', '2020-07-23 11:11:00'),
(7, 2, 'HKG', 'VKO', '2020-07-01 11:22:00', '2020-07-03 22:03:00'),
(9, 2, 'VKO', 'HKG', '2020-07-12 22:22:00', '2020-08-23 05:05:00'),
(10, 1, 'HKG', 'VKO', '2020-10-03 22:22:00', '2020-11-07 22:21:00');

-- --------------------------------------------------------

--
-- Структура таблицы `tickets`
--

CREATE TABLE `tickets` (
  `race_id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `seat_type` varchar(1) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'S',
  `seat_number` int(4) NOT NULL,
  `ticket_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ticket_surname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `ticket_patronymic` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `ticket_birth_date` date NOT NULL,
  `ticket_passport` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `tickets`
--

INSERT INTO `tickets` (`race_id`, `user_id`, `seat_type`, `seat_number`, `ticket_name`, `ticket_surname`, `ticket_patronymic`, `ticket_birth_date`, `ticket_passport`) VALUES
(7, 1, 'S', 6, 'AETQWET', 'WETWET', 'aawrtawet', '2020-06-10', 342342342),
(7, 1, 'S', 2, 'r', 'q', 'w', '2020-06-28', 33),
(7, 1, 'S', 5, 'r', 'q', 'w', '2020-06-28', 33),
(5, 1, 'S', 7, 'Уайэмби', 'Йомстер', 'Нету', '2020-06-19', 124124124),
(5, 1, 'S', 6, 'Уайэмби', 'Йомстер', 'Нету', '2020-06-19', 124124124),
(7, 4, 'B', 16, 'wqrqeet', 'rwqqwr', 'wetwet', '2020-06-14', 53252523);

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `user_id` int(11) UNSIGNED NOT NULL,
  `user_login` varchar(30) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_password` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `user_status` int(1) NOT NULL DEFAULT 1,
  `user_hash` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `user_ip` int(10) UNSIGNED NOT NULL DEFAULT 0,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `surname` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `patronymic` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `registration_date` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`user_id`, `user_login`, `user_password`, `user_status`, `user_hash`, `user_ip`, `name`, `surname`, `patronymic`, `registration_date`) VALUES
(1, 'yom', 'd9b1d7db4cd6e70935368a1efb10e377', 2, '51ecd2db4e038ef46703f49abbb60ec4', 2130706433, 'Федор', 'Пескоструев', '   ', '2020-06-10 22:52:22'),
(2, 'admin', 'c3284d0f94606de1fd2af172aba15bf3', 2, 'e9049bca09df62f5fe122381bb0f2f26', 2130706433, '', '', '', '2020-06-10 23:10:39'),
(3, 'bog', '21afb0848dc5eb767a73a9df76fd5ff1', 1, '3e52c22907d35a1154d02380edfeb465', 2130706433, '', '', '', '2020-06-11 11:28:38'),
(4, 'ooo', 'd9b1d7db4cd6e70935368a1efb10e377', 1, 'f8d9dd004cd6f7769d720f0489cd0fe1', 2130706433, 'awtwet', 'QWrawee', 'awetawet', '2020-06-17 10:41:25');

-- --------------------------------------------------------

--
-- Структура таблицы `user_statuses`
--

CREATE TABLE `user_statuses` (
  `id` int(11) NOT NULL,
  `status_name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `supervise` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `user_statuses`
--

INSERT INTO `user_statuses` (`id`, `status_name`, `supervise`) VALUES
(1, 'Пользователь', 0),
(2, 'Администратор', 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `buses`
--
ALTER TABLE `buses`
  ADD PRIMARY KEY (`bus_type_id`) USING BTREE;

--
-- Индексы таблицы `iata_codes`
--
ALTER TABLE `iata_codes`
  ADD UNIQUE KEY `IATA_id` (`IATA_id`) USING BTREE;

--
-- Индексы таблицы `races`
--
ALTER TABLE `races`
  ADD PRIMARY KEY (`race_id`),
  ADD KEY `bus_type_id` (`bus_type_id`),
  ADD KEY `IATA_from` (`IATA_from`),
  ADD KEY `IATA_to` (`IATA_to`);

--
-- Индексы таблицы `tickets`
--
ALTER TABLE `tickets`
  ADD KEY `user_id` (`user_id`),
  ADD KEY `race_id` (`race_id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`) USING BTREE,
  ADD UNIQUE KEY `login` (`user_login`),
  ADD KEY `user_status` (`user_status`);

--
-- Индексы таблицы `user_statuses`
--
ALTER TABLE `user_statuses`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `buses`
--
ALTER TABLE `buses`
  MODIFY `bus_type_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT для таблицы `races`
--
ALTER TABLE `races`
  MODIFY `race_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT для таблицы `user_statuses`
--
ALTER TABLE `user_statuses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `races`
--
ALTER TABLE `races`
  ADD CONSTRAINT `races_ibfk_1` FOREIGN KEY (`bus_type_id`) REFERENCES `buses` (`bus_type_id`) ON UPDATE CASCADE,
  ADD CONSTRAINT `races_ibfk_2` FOREIGN KEY (`IATA_from`) REFERENCES `iata_codes` (`IATA_id`),
  ADD CONSTRAINT `races_ibfk_3` FOREIGN KEY (`IATA_to`) REFERENCES `iata_codes` (`IATA_id`);

--
-- Ограничения внешнего ключа таблицы `tickets`
--
ALTER TABLE `tickets`
  ADD CONSTRAINT `tickets_ibfk_1` FOREIGN KEY (`race_id`) REFERENCES `races` (`race_id`),
  ADD CONSTRAINT `tickets_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Ограничения внешнего ключа таблицы `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `users_ibfk_1` FOREIGN KEY (`user_status`) REFERENCES `user_statuses` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
