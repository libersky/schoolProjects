-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- Počítač: localhost
-- Vytvořeno: Úte 14. čec 2020, 15:42
-- Verze serveru: 10.3.22-MariaDB-log
-- Verze PHP: 7.3.16

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `liba03`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `dashboard_categories`
--

CREATE TABLE `dashboard_categories` (
  `category_id` smallint(6) NOT NULL,
  `name` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Vypisuji data pro tabulku `dashboard_categories`
--

INSERT INTO `dashboard_categories` (`category_id`, `name`) VALUES
(1, 'Novinky'),
(2, 'Zprávy');

-- --------------------------------------------------------

--
-- Struktura tabulky `dashboard_posts`
--

CREATE TABLE `dashboard_posts` (
  `post_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `category_id` smallint(6) NOT NULL,
  `text` text CHARACTER SET utf8 COLLATE utf8_czech_ci NOT NULL,
  `updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Vypisuji data pro tabulku `dashboard_posts`
--

INSERT INTO `dashboard_posts` (`post_id`, `user_id`, `category_id`, `text`, `updated`) VALUES
(1, 1, 1, 'Testovací příspěvek', '2020-04-02 08:07:49'),
(2, 1, 1, 'Nová zpráva', '2020-04-02 18:07:30'),
(3, 2, 2, 'Česko otevírá hranice.', '2020-04-03 08:11:03'),
(4, 1, 2, 'Omezení provozu', '2020-04-03 08:43:26'),
(5, 1, 1, 'Je pátek', '2020-04-03 12:21:27'),
(6, 1, 2, 'Provedeno2', '2020-04-03 13:18:07');

-- --------------------------------------------------------

--
-- Struktura tabulky `dashboard_users`
--

CREATE TABLE `dashboard_users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(30) NOT NULL,
  `email` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Vypisuji data pro tabulku `dashboard_users`
--

INSERT INTO `dashboard_users` (`user_id`, `name`, `email`) VALUES
(1, 'Adam', 'adam@domena.tld'),
(2, 'Eva', 'eva@domena.tld');

-- --------------------------------------------------------

--
-- Struktura tabulky `forgotten_passwords`
--

CREATE TABLE `forgotten_passwords` (
  `forgotten_password_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `code` varchar(255) COLLATE utf8mb4_czech_ci NOT NULL,
  `created` timestamp NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

-- --------------------------------------------------------

--
-- Struktura tabulky `goods`
--

CREATE TABLE `goods` (
  `id` bigint(20) UNSIGNED NOT NULL,
  `name` varchar(255) DEFAULT NULL,
  `description` text DEFAULT NULL,
  `price` decimal(10,2) NOT NULL DEFAULT 0.00
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Vypisuji data pro tabulku `goods`
--

INSERT INTO `goods` (`id`, `name`, `description`, `price`) VALUES
(1, 'turpis nec mauris', 'Nulla semper tellus id', '301.88'),
(2, 'Mauris vel', 'non enim. Mauris quis turpis vitae purus gravida sagittis. Duis gravida. Praesent eu nulla at sem molestie sodales. Mauris blandit enim consequat purus. Maecenas libero est,', '303.57'),
(3, 'orci. Ut sagittis', 'ut quam vel sapien imperdiet ornare. In faucibus. Morbi vehicula. Pellentesque tincidunt tempus risus. Donec egestas. Duis ac arcu.', '989.80'),
(4, 'ad', 'Integer in', '539.02'),
(5, 'ultrices', 'Duis risus odio, auctor vitae, aliquet nec, imperdiet nec, leo. Morbi neque tellus, imperdiet non, vestibulum nec, euismod in, dolor. Fusce feugiat. Lorem ipsum', '682.18'),
(6, 'iaculis', 'Donec', '466.72'),
(7, 'imperdiet dictum', 'eu, placerat', '907.65'),
(8, 'Morbi vehicula. Pellentesque', 'nisl sem, consequat nec, mollis vitae, posuere at, velit. Cras lorem lorem, luctus ut, pellentesque eget, dictum', '961.53'),
(9, 'adipiscing elit.', 'a, facilisis non, bibendum sed, est. Nunc laoreet lectus quis massa. Mauris vestibulum, neque sed dictum eleifend, nunc risus varius orci, in', '118.18'),
(10, 'ultrices,', 'et ipsum cursus vestibulum. Mauris magna. Duis dignissim tempor arcu. Vestibulum ut eros non enim commodo hendrerit. Donec porttitor tellus non magna. Nam ligula elit, pretium et, rutrum non, hendrerit', '753.65'),
(11, 'dapibus', 'eu tempor erat neque non quam. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aliquam fringilla cursus purus. Nullam', '298.65'),
(12, 'gravida', 'at, nisi. Cum sociis', '475.17'),
(13, 'Proin', 'dolor. Nulla semper tellus id nunc interdum feugiat. Sed nec metus facilisis', '751.60'),
(14, 'eu', 'arcu. Aliquam', '289.52'),
(15, 'amet ante. Vivamus', 'nascetur ridiculus mus. Proin vel arcu eu odio', '503.70'),
(16, 'vulputate, risus', 'Aliquam tincidunt, nunc ac mattis ornare, lectus ante dictum mi, ac mattis velit justo nec ante. Maecenas mi felis, adipiscing fringilla, porttitor vulputate, posuere vulputate, lacus.', '873.27'),
(17, 'dolor vitae dolor.', 'justo sit amet nulla. Donec non justo. Proin non massa non ante bibendum ullamcorper. Duis cursus, diam at pretium aliquet, metus', '562.84'),
(18, 'ante', 'Aliquam tincidunt, nunc ac mattis ornare, lectus ante dictum', '815.41'),
(19, 'vulputate, risus a', 'Cras sed leo. Cras vehicula aliquet libero. Integer in magna. Phasellus dolor elit, pellentesque a,', '103.18'),
(20, 'neque tellus, imperdiet', 'odio a purus. Duis elementum, dui quis accumsan convallis, ante lectus convallis est,', '381.10'),
(21, 'Donec vitae', 'Donec tempor, est ac mattis semper, dui lectus rutrum urna, nec luctus felis purus ac tellus. Suspendisse sed dolor. Fusce mi lorem, vehicula et,', '634.03'),
(22, 'dui, semper', 'faucibus lectus, a sollicitudin orci sem eget', '180.31'),
(23, 'nec, cursus', 'dolor sit amet, consectetuer adipiscing elit. Etiam laoreet, libero et tristique pellentesque, tellus sem', '920.17'),
(24, 'in consequat', 'convallis convallis dolor. Quisque tincidunt pede ac urna. Ut tincidunt vehicula risus. Nulla eget metus eu erat semper rutrum. Fusce dolor quam, elementum at,', '555.58'),
(25, 'nunc est,', 'est tempor bibendum. Donec felis orci, adipiscing non, luctus sit', '949.36'),
(26, 'fermentum vel,', 'molestie in, tempus eu, ligula. Aenean euismod mauris eu elit. Nulla facilisi. Sed neque. Sed eget lacus.', '105.21'),
(27, 'odio', 'Cras dolor dolor, tempus non, lacinia at,', '981.03'),
(28, 'semper.', 'vitae, aliquet nec, imperdiet nec, leo. Morbi neque tellus, imperdiet non, vestibulum nec, euismod', '409.80'),
(29, 'vestibulum lorem,', 'Quisque purus sapien, gravida non, sollicitudin a, malesuada id, erat. Etiam vestibulum massa rutrum magna. Cras convallis convallis', '800.77'),
(30, 'penatibus', 'mauris. Integer sem elit, pharetra ut, pharetra sed, hendrerit a, arcu. Sed et libero. Proin mi. Aliquam gravida', '497.28'),
(31, 'nec, eleifend', 'urna, nec luctus', '281.21'),
(32, 'Nullam', 'ipsum. Suspendisse sagittis. Nullam vitae diam. Proin dolor. Nulla semper tellus id nunc interdum feugiat. Sed nec metus facilisis lorem tristique aliquet. Phasellus fermentum convallis', '121.15'),
(33, 'ac orci.', 'Duis at lacus. Quisque purus sapien, gravida non, sollicitudin a,', '898.32'),
(34, 'lorem ut', 'est arcu ac', '377.39'),
(35, 'commodo at,', 'vehicula. Pellentesque tincidunt tempus risus. Donec egestas. Duis ac arcu. Nunc mauris. Morbi non sapien molestie orci tincidunt adipiscing. Mauris molestie pharetra nibh. Aliquam ornare,', '76.20'),
(36, 'pede blandit congue.', 'ut aliquam iaculis, lacus pede sagittis augue, eu tempor erat neque non quam. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aliquam', '983.54'),
(37, 'dictum', 'In condimentum. Donec at arcu. Vestibulum ante ipsum primis', '488.08'),
(38, 'non magna. Nam', 'Morbi quis urna. Nunc quis arcu', '92.69'),
(39, 'eu, accumsan', 'mattis ornare, lectus ante dictum mi,', '495.07'),
(40, 'consectetuer', 'egestas a, scelerisque sed,', '986.72'),
(41, 'convallis convallis', 'iaculis nec, eleifend non, dapibus rutrum, justo. Praesent luctus. Curabitur egestas nunc sed libero. Proin sed turpis nec mauris blandit mattis. Cras eget nisi dictum augue malesuada malesuada. Integer id', '842.09'),
(42, 'nisi nibh lacinia', 'Cras dolor dolor, tempus non, lacinia at, iaculis quis,', '217.35'),
(43, 'eu', 'dictum placerat, augue. Sed molestie. Sed id risus quis diam luctus lobortis. Class aptent taciti sociosqu ad litora torquent per conubia', '424.64'),
(44, 'tellus eu augue', 'risus. Duis a mi fringilla mi lacinia mattis. Integer eu lacus. Quisque imperdiet, erat', '633.88'),
(45, 'lorem', 'Etiam bibendum fermentum metus. Aenean sed pede nec ante blandit viverra. Donec', '517.43'),
(46, 'neque. Nullam nisl.', 'ultrices, mauris ipsum porta elit, a feugiat tellus lorem eu metus. In lorem. Donec elementum, lorem ut', '278.32'),
(47, 'interdum', 'mattis', '557.82'),
(48, 'magna', 'augue eu tellus. Phasellus elit pede, malesuada vel, venenatis vel,', '292.20'),
(49, 'id enim. Curabitur', 'scelerisque sed, sapien. Nunc pulvinar arcu et pede. Nunc sed orci lobortis augue scelerisque mollis. Phasellus libero mauris,', '10.24'),
(50, 'lobortis,', 'aliquet. Phasellus fermentum convallis ligula. Donec luctus aliquet odio. Etiam ligula tortor, dictum eu, placerat eget, venenatis a, magna. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Etiam laoreet, libero', '240.13'),
(51, 'purus. Maecenas libero', 'amet luctus vulputate, nisi sem semper erat, in consectetuer ipsum nunc id enim. Curabitur massa. Vestibulum accumsan neque et nunc. Quisque ornare tortor at', '466.42'),
(52, 'mi lorem,', 'fermentum convallis ligula. Donec luctus aliquet odio. Etiam ligula tortor,', '531.45'),
(53, 'Curabitur dictum. Phasellus', 'enim non nisi. Aenean eget metus. In nec orci. Donec nibh. Quisque nonummy ipsum non arcu. Vivamus sit amet risus. Donec egestas. Aliquam nec enim. Nunc ut erat. Sed', '405.78'),
(54, 'metus', 'eget nisi dictum augue malesuada malesuada. Integer id magna et ipsum cursus vestibulum. Mauris magna. Duis dignissim tempor arcu. Vestibulum', '255.63'),
(55, 'non nisi. Aenean', 'sit amet ante. Vivamus non lorem vitae odio', '940.91'),
(56, 'vehicula. Pellentesque', 'luctus lobortis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Mauris', '854.63'),
(57, 'ultrices. Duis volutpat', 'orci, consectetuer euismod est arcu ac orci. Ut semper pretium neque. Morbi quis urna. Nunc quis arcu', '613.94'),
(58, 'eu arcu.', 'in lobortis tellus justo sit amet nulla. Donec non justo. Proin non massa non ante bibendum', '83.37'),
(59, 'scelerisque scelerisque dui.', 'sem semper erat, in consectetuer ipsum nunc id enim. Curabitur massa. Vestibulum accumsan neque et nunc. Quisque ornare', '830.90'),
(60, 'blandit enim', 'luctus', '221.80'),
(61, 'erat vel', 'eu metus. In lorem. Donec elementum, lorem ut aliquam iaculis, lacus pede sagittis augue, eu tempor erat neque non quam. Pellentesque habitant morbi tristique senectus et netus', '344.41'),
(62, 'mi', 'dui augue', '913.31'),
(63, 'molestie arcu.', 'dolor, tempus non, lacinia at, iaculis quis, pede. Praesent eu dui. Cum sociis natoque penatibus et magnis', '593.74'),
(64, 'luctus ut,', 'non, luctus sit amet, faucibus ut,', '386.86'),
(65, 'semper pretium', 'cursus. Nunc mauris', '915.68'),
(66, 'faucibus lectus, a', 'ut, nulla. Cras eu tellus eu augue porttitor interdum. Sed auctor odio a purus.', '391.13'),
(67, 'vel', 'metus. Aenean sed pede nec ante blandit viverra. Donec tempus, lorem fringilla ornare placerat, orci lacus', '586.22'),
(68, 'euismod urna.', 'vitae, erat. Vivamus nisi. Mauris nulla. Integer urna. Vivamus', '82.05'),
(69, 'posuere', 'magnis dis parturient montes, nascetur ridiculus mus. Donec dignissim', '786.80'),
(70, 'velit', 'neque. Morbi quis urna. Nunc quis arcu vel quam', '55.50'),
(71, 'augue', 'sollicitudin orci sem eget massa. Suspendisse eleifend. Cras sed leo. Cras vehicula aliquet libero. Integer in magna. Phasellus dolor elit, pellentesque a, facilisis non, bibendum sed, est. Nunc laoreet lectus', '450.82'),
(72, 'sem ut', 'viverra. Maecenas iaculis aliquet diam. Sed diam lorem, auctor quis, tristique ac, eleifend vitae, erat. Vivamus nisi. Mauris nulla. Integer urna. Vivamus molestie dapibus', '341.45'),
(73, 'Cras eu', 'interdum feugiat. Sed nec metus facilisis lorem tristique aliquet. Phasellus fermentum convallis ligula. Donec luctus aliquet odio. Etiam ligula tortor, dictum eu, placerat eget, venenatis a, magna.', '193.96'),
(74, 'Donec porttitor tellus', 'dictum. Proin eget odio. Aliquam vulputate ullamcorper magna. Sed eu', '578.25'),
(75, 'enim', 'sapien molestie orci tincidunt adipiscing. Mauris molestie pharetra nibh. Aliquam ornare, libero at auctor ullamcorper, nisl', '168.52'),
(76, 'euismod in, dolor.', 'id, libero. Donec consectetuer', '488.10'),
(77, 'pulvinar', 'Aliquam vulputate ullamcorper magna. Sed eu eros. Nam consequat dolor vitae dolor. Donec fringilla. Donec feugiat metus sit amet ante. Vivamus non lorem vitae odio sagittis semper. Nam tempor', '565.23'),
(78, 'mauris eu', 'pede blandit congue. In scelerisque scelerisque dui.', '202.97'),
(79, 'pede', 'auctor, nunc nulla vulputate dui, nec tempus mauris erat eget ipsum. Suspendisse sagittis. Nullam vitae diam. Proin dolor. Nulla semper tellus id nunc interdum feugiat. Sed nec metus', '85.48'),
(80, 'lacus,', 'odio tristique', '120.03'),
(81, 'augue ut lacus.', 'lectus, a sollicitudin orci sem eget massa. Suspendisse eleifend. Cras sed leo. Cras vehicula aliquet libero. Integer in magna. Phasellus dolor elit, pellentesque a, facilisis non,', '730.81'),
(82, 'lobortis mauris. Suspendisse', 'parturient montes, nascetur ridiculus mus. Proin vel', '147.09'),
(83, 'sapien', 'Donec egestas. Duis ac arcu. Nunc mauris. Morbi non sapien molestie orci', '143.38'),
(84, 'Mauris blandit enim', 'libero est, congue a, aliquet vel, vulputate eu, odio. Phasellus at augue id ante dictum cursus. Nunc mauris elit, dictum eu, eleifend nec, malesuada ut, sem. Nulla interdum. Curabitur', '481.83'),
(85, 'eu dui. Cum', 'Nunc mauris elit, dictum eu, eleifend nec, malesuada ut,', '136.15'),
(86, 'Sed eu eros.', 'et, lacinia vitae, sodales at, velit. Pellentesque', '981.39'),
(87, 'lorem, sit', 'dolor quam, elementum at, egestas a, scelerisque sed, sapien. Nunc pulvinar arcu et pede. Nunc sed orci lobortis augue scelerisque mollis. Phasellus libero mauris, aliquam eu, accumsan sed,', '471.87'),
(88, 'non enim. Mauris', 'facilisis lorem tristique aliquet. Phasellus fermentum convallis ligula. Donec luctus aliquet odio. Etiam ligula tortor, dictum eu, placerat eget, venenatis a, magna. Lorem ipsum dolor sit amet, consectetuer adipiscing elit.', '142.20'),
(89, 'sociosqu', 'placerat eget, venenatis a, magna. Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Etiam laoreet, libero et tristique pellentesque, tellus sem', '308.91'),
(90, 'aliquam,', 'id risus quis diam luctus lobortis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Mauris ut quam vel', '631.88'),
(91, 'ut, nulla.', 'a, facilisis non, bibendum sed, est. Nunc laoreet lectus quis massa. Mauris vestibulum, neque sed dictum eleifend, nunc risus varius orci, in consequat enim diam', '913.65'),
(92, 'Aliquam', 'dapibus id, blandit at, nisi. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Proin', '902.05'),
(93, 'luctus', 'placerat, augue. Sed molestie. Sed id risus quis diam luctus lobortis. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos hymenaeos. Mauris ut quam', '920.19'),
(94, 'purus, accumsan interdum', 'porttitor eros nec tellus. Nunc lectus pede, ultrices a, auctor non,', '125.50'),
(95, 'egestas', 'dolor vitae dolor. Donec fringilla. Donec feugiat metus sit amet ante. Vivamus non lorem vitae odio sagittis semper. Nam tempor', '950.33'),
(96, 'penatibus et', 'nascetur ridiculus mus. Proin vel nisl. Quisque fringilla euismod enim. Etiam gravida molestie arcu. Sed eu nibh vulputate', '161.06'),
(97, 'massa.', 'malesuada vel, convallis in, cursus et, eros. Proin ultrices. Duis volutpat nunc sit amet metus. Aliquam erat volutpat. Nulla facilisis. Suspendisse commodo', '597.49'),
(98, 'Donec non', 'id enim. Curabitur massa. Vestibulum accumsan neque et nunc. Quisque ornare tortor at', '798.63'),
(99, 'Duis', 'parturient montes, nascetur ridiculus mus. Proin vel arcu eu odio tristique pharetra. Quisque ac libero nec ligula consectetuer rhoncus. Nullam', '839.72'),
(100, 'tristique pharetra.', 'ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Phasellus ornare. Fusce mollis. Duis sit amet diam eu dolor egestas rhoncus.', '747.13');

-- --------------------------------------------------------

--
-- Struktura tabulky `rest_own`
--

CREATE TABLE `rest_own` (
  `own_restaurant_id` int(255) NOT NULL,
  `own_user_id` int(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `rest_own`
--

INSERT INTO `rest_own` (`own_restaurant_id`, `own_user_id`) VALUES
(2, 34),
(3, 26),
(3, 34),
(5, 34),
(16, 31);

-- --------------------------------------------------------

--
-- Struktura tabulky `rest_reservation`
--

CREATE TABLE `rest_reservation` (
  `reservation_id` int(255) NOT NULL,
  `reservation_table_id` int(255) NOT NULL,
  `reservation_user_id` int(255) NOT NULL,
  `reservation_user_name` varchar(50) NOT NULL,
  `reservation_user_email` varchar(50) NOT NULL,
  `reservation_user_phone` varchar(50) NOT NULL,
  `reservation_date` date NOT NULL,
  `reservation_time_from` time NOT NULL,
  `reservation_time_to` time NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `rest_reservation`
--

INSERT INTO `rest_reservation` (`reservation_id`, `reservation_table_id`, `reservation_user_id`, `reservation_user_name`, `reservation_user_email`, `reservation_user_phone`, `reservation_date`, `reservation_time_from`, `reservation_time_to`) VALUES
(19, 20, 28, 'Franta Obyčejný', 'obyc@seznam.cz', '+420 728 176 324', '2020-06-04', '10:00:00', '12:00:00'),
(21, 3, 28, 'Franta Obyčejný', 'obyc@seznam.cz', '+420 728 176 324', '2020-06-08', '17:00:00', '19:00:00'),
(22, 16, 31, 'Tomáš Hostina', 'hostina@seznam.cz', '+420 369 852 147', '2020-06-11', '17:00:00', '18:00:00'),
(23, 3, 28, 'Franta Obyčejný', 'obyc@seznam.cz', '+420 728 176 324', '2020-06-08', '13:00:00', '16:00:00'),
(24, 3, 0, 'Tonda Franěk', 'tonda@seznam.cz', '+420 789 654 123', '2020-06-08', '10:00:00', '13:00:00'),
(32, 20, 31, 'Tomáš Hostina', 'hostina@seznam.cz', '+420 369 852 147', '2020-06-16', '13:00:00', '16:00:00');

-- --------------------------------------------------------

--
-- Struktura tabulky `rest_restaurace`
--

CREATE TABLE `rest_restaurace` (
  `r_id` int(11) NOT NULL,
  `name` text NOT NULL,
  `title` text NOT NULL,
  `tags` text NOT NULL,
  `description` text NOT NULL,
  `opening_mo` varchar(25) NOT NULL DEFAULT 'Zavřeno',
  `opening_tu` varchar(25) NOT NULL DEFAULT 'Zavřeno',
  `opening_we` varchar(25) NOT NULL DEFAULT 'Zavřeno',
  `opening_th` varchar(25) NOT NULL DEFAULT 'Zavřeno',
  `opening_fr` varchar(25) NOT NULL DEFAULT 'Zavřeno',
  `opening_sa` varchar(25) NOT NULL DEFAULT 'Zavřeno',
  `opening_su` varchar(25) NOT NULL DEFAULT 'Zavřeno',
  `picture` text NOT NULL,
  `email` text NOT NULL,
  `phone` varchar(25) NOT NULL,
  `city` text NOT NULL,
  `street` text NOT NULL,
  `no` int(10) NOT NULL,
  `zip` int(5) NOT NULL,
  `contribution` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `rest_restaurace`
--

INSERT INTO `rest_restaurace` (`r_id`, `name`, `title`, `tags`, `description`, `opening_mo`, `opening_tu`, `opening_we`, `opening_th`, `opening_fr`, `opening_sa`, `opening_su`, `picture`, `email`, `phone`, `city`, `street`, `no`, `zip`, `contribution`) VALUES
(1, 'Eden', 'Sportovní bar', 'Pivo, Fotbal', 'Bar pro fanoušky fotbalu a fotbalového klubu Slavia. Točíme zde Gambrinus a každý večer promítáme fotbalové zápasy oblíbených fotbalových klubů z domova i zahraničí.', 'Zavřeno', 'Zavřeno', 'Zavřeno', 'Zavřeno', 'Zavřeno', 'Zavřeno', 'Zavřeno', 'example5', 'eden@gmail.com', '', 'Vrdy', 'Smetanovo nám.', 4, 28571, 500),
(2, 'U Vařince', 'Poctivá česká hospoda', 'Pivo, Česká, Bernard', 'Hospoda na náměstí v Ronově nad Doubravou. Příjemné posezení v podhůří Železných hor. Denně připravujeme polední a večerní menu. Točíme regionální pivo a Bernarda.', '18:00 - 23:00', '16:00 - 22:00', '18:00 - 19:00', '17:00 - 23:00', '17:00 - 00:00', '10:00 - 23:00', '10:00 - 00:00', 'example1', 'uvavrince@seznam.cz', '+420728176320', 'Ronov nad Doubravou', 'Dvořákovo nám.', 74, 53842, 600),
(3, 'U Klokoně', '', 'Pivo, Burger, Steak', 'Nově opravená restaurace na Pražských Vinohradech. Nabízíme speciality z divokého západu a české pivo.', '10:00 - 23:00', '12:00 - 22:00', 'Zavřeno', 'Zavřeno', 'Zavřeno', 'Zavřeno', 'Zavřeno', 'example2', 'uklokone@seznam.cz', '+420369852147', 'Praha', 'Bělocerkevská', 204, 10010, 1000),
(4, 'Rebelka', 'Na pivo s přáteli', 'Pivo', 'Pajzl naproti autobusovému nádraží v Čáslavi. Točíme pivo Rebel. Nejsme nijak zajímaví, ale můžete tu potkat Andyho.', 'Zavřeno', 'Zavřeno', 'Zavřeno', 'Zavřeno', 'Zavřeno', 'Zavřeno', 'Zavřeno', 'example3', 'rebelka@seznam.cz', '', 'Čáslav', 'U Lidlu', 15, 28572, 100),
(5, 'Damian', 'Art bistro', 'Smorbrod, Víno, Rum', 'Snoubíme gastronomické a vizuální umění. Přijďte si vychutnat obrazy začínajících umělců a posedět v netradičním prostředí. Pohostíme vás našimi sendviči  a vínem.', 'Zavřeno', 'Zavřeno', 'Zavřeno', 'Zavřeno', 'Zavřeno', 'Zavřeno', 'Zavřeno', '', 'damian@gmail.com', '630 236 896', 'Praha', 'Kodaňská', 224, 10100, 300),
(6, 'MoonPrague', 'Cukrárna', 'Káva, Čaj, Deserty', 'Ahoj, vítám vás v mé cukrárně, kterou jsem založila začátkem roku 2020. Můžete si zde vychutnat dortíky vlastní výroby a Kambodžský a Indonéský čaj vlastního dovozu. ', 'Zavřeno', 'Zavřeno', 'Zavřeno', 'Zavřeno', 'Zavřeno', 'Zavřeno', 'Zavřeno', 'example4', 'moonprague@gmail.com', '', 'Praha', 'Varšavská', 115, 10100, 500),
(14, 'Jamka', '', '', '', 'Zavřeno', 'Zavřeno', 'Zavřeno', 'Zavřeno', 'Zavřeno', 'Zavřeno', 'Zavřeno', '', '', '', 'Praha', 'Radovnická', 15, 10012, 200),
(15, 'Jinonka', '', '', '', 'Zavřeno', 'Zavřeno', 'Zavřeno', 'Zavřeno', 'Zavřeno', 'Zavřeno', 'Zavřeno', '', '', '', 'Čáslavice', 'Dlouhá', 15, 28578, 200),
(16, 'Teta Minh', 'Asie ve vašem městě', 'Pho, Nudle, Čaj', 'Nudle, Pho a mnoho dalšího připravují s péčí profesionální kuchaři z čerstvých regionálních surovin. ', '10:00 - 23:30', '10:00 - 23:30', '10:00 - 21:00', '10:00 - 21:00', '10:00 - 23:30', '19:00 - 23:30', 'Zavřeno', '', 'milidvarfie@gmail.com', '+420 728 176 459', 'Golčův Jeníkov', 'Mírová', 100, 58282, 400);

-- --------------------------------------------------------

--
-- Struktura tabulky `rest_table`
--

CREATE TABLE `rest_table` (
  `table_id` int(255) NOT NULL,
  `table_restaurant_id` int(255) NOT NULL,
  `table_number` int(255) NOT NULL,
  `table_chairs` smallint(10) NOT NULL,
  `table_level` smallint(3) NOT NULL,
  `table_lock` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `rest_table`
--

INSERT INTO `rest_table` (`table_id`, `table_restaurant_id`, `table_number`, `table_chairs`, `table_level`, `table_lock`) VALUES
(1, 3, 12, 4, 0, 0),
(2, 3, 54, 4, 0, 1),
(3, 3, 10, 2, 0, 0),
(5, 3, 4, 4, 0, 1),
(7, 3, 2, 2, 0, 1),
(8, 3, 1, 4, 0, 1),
(9, 3, 3, 4, 0, 0),
(11, 5, 1, 4, 0, 0),
(12, 5, 2, 4, 0, 0),
(13, 5, 3, 2, 0, 0),
(14, 5, 4, 4, 0, 0),
(16, 2, 1, 4, 0, 0),
(17, 2, 2, 4, 0, 0),
(18, 2, 3, 4, 0, 1),
(19, 16, 1, 4, 0, 0),
(20, 16, 2, 4, 0, 0),
(21, 16, 3, 4, 0, 0),
(22, 16, 4, 2, 0, 0),
(23, 16, 5, 2, 0, 0),
(24, 16, 6, 2, 0, 0),
(25, 16, 7, 4, 0, 1),
(26, 16, 8, 6, 0, 0),
(27, 16, 9, 6, 0, 0),
(28, 16, 10, 6, 0, 0);

-- --------------------------------------------------------

--
-- Struktura tabulky `rest_user`
--

CREATE TABLE `rest_user` (
  `user_id` int(11) NOT NULL,
  `user_name` varchar(30) NOT NULL,
  `user_email` varchar(30) NOT NULL,
  `user_facebook_id` varchar(50) NOT NULL DEFAULT '',
  `user_phone` varchar(25) NOT NULL,
  `user_password` varchar(255) NOT NULL DEFAULT '',
  `user_admin` tinyint(1) NOT NULL,
  `user_owner` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Vypisuji data pro tabulku `rest_user`
--

INSERT INTO `rest_user` (`user_id`, `user_name`, `user_email`, `user_facebook_id`, `user_phone`, `user_password`, `user_admin`, `user_owner`) VALUES
(28, 'Franta Obyčejný', 'obyc@seznam.cz', '', '+420 728 176 324', '$2y$10$Nt531z82uO9Kx3lNmCv3YeJeNNWYJBjtGjYroN7BUzQIzn8dMGwc2', 0, 0),
(31, 'Tomáš Hostina', 'hostina@seznam.cz', 'hostina@seznam.cz', '+420 369 852 147', '$2y$10$fkK66x4YerCl8WX.2VHWRu/z3/S4WwTZgJdQWVYw/niSS8HoHjAMa', 0, 1),
(32, 'David Hladový', 'hlad@seznam.cz', 'hlad@seznam.cz', '+420 789 456 123', '$2y$10$Y/B/o0Nw.6m5NEzAs.i9SeHiWwuYCXQa76MSXHQbmy/7v7x3IraU2', 0, 0),
(34, 'Aleš Liberský', 'asel.ales@seznam.cz', '2744374502338031', '+420 728 176 321', '$2y$10$il0ak.JrNLZJ/I4SdqbTzey8zYeuun9dRBKRHvCGkcdmeXUE7.B0S', 1, 1),
(36, 'Jack Callahan', 'geogatedproject327@gmail.com', '10150000109511806', '000 000 000', '', 0, 0);

-- --------------------------------------------------------

--
-- Struktura tabulky `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_czech_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_czech_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_czech_ci NOT NULL DEFAULT '',
  `facebook_id` varchar(50) COLLATE utf8mb4_czech_ci NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_czech_ci;

--
-- Vypisuji data pro tabulku `users`
--

INSERT INTO `users` (`user_id`, `name`, `email`, `password`, `facebook_id`) VALUES
(2, 'Aleš Liberský', 'asel.ales@seznam.cz', '', '2708486152593533'),
(3, 'Tettt', 'eeeeee@eeeee.eee', '$2y$10$hnKjh9cMOySZoFslJjCBO.AlqiE2PZMDCsW82FLmTsMpWrtRa0Ddi', '');

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `dashboard_categories`
--
ALTER TABLE `dashboard_categories`
  ADD PRIMARY KEY (`category_id`);

--
-- Klíče pro tabulku `dashboard_posts`
--
ALTER TABLE `dashboard_posts`
  ADD PRIMARY KEY (`post_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `category_id` (`category_id`);

--
-- Klíče pro tabulku `dashboard_users`
--
ALTER TABLE `dashboard_users`
  ADD PRIMARY KEY (`user_id`);

--
-- Klíče pro tabulku `forgotten_passwords`
--
ALTER TABLE `forgotten_passwords`
  ADD PRIMARY KEY (`forgotten_password_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Klíče pro tabulku `goods`
--
ALTER TABLE `goods`
  ADD PRIMARY KEY (`id`);

--
-- Klíče pro tabulku `rest_own`
--
ALTER TABLE `rest_own`
  ADD PRIMARY KEY (`own_restaurant_id`,`own_user_id`);

--
-- Klíče pro tabulku `rest_reservation`
--
ALTER TABLE `rest_reservation`
  ADD PRIMARY KEY (`reservation_id`);

--
-- Klíče pro tabulku `rest_restaurace`
--
ALTER TABLE `rest_restaurace`
  ADD PRIMARY KEY (`r_id`);

--
-- Klíče pro tabulku `rest_table`
--
ALTER TABLE `rest_table`
  ADD PRIMARY KEY (`table_id`);

--
-- Klíče pro tabulku `rest_user`
--
ALTER TABLE `rest_user`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `user_email` (`user_email`),
  ADD UNIQUE KEY `user_facebook_id` (`user_facebook_id`);

--
-- Klíče pro tabulku `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`),
  ADD UNIQUE KEY `facebook_id` (`facebook_id`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `dashboard_categories`
--
ALTER TABLE `dashboard_categories`
  MODIFY `category_id` smallint(6) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pro tabulku `dashboard_posts`
--
ALTER TABLE `dashboard_posts`
  MODIFY `post_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT pro tabulku `dashboard_users`
--
ALTER TABLE `dashboard_users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pro tabulku `forgotten_passwords`
--
ALTER TABLE `forgotten_passwords`
  MODIFY `forgotten_password_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT pro tabulku `goods`
--
ALTER TABLE `goods`
  MODIFY `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;

--
-- AUTO_INCREMENT pro tabulku `rest_reservation`
--
ALTER TABLE `rest_reservation`
  MODIFY `reservation_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT pro tabulku `rest_restaurace`
--
ALTER TABLE `rest_restaurace`
  MODIFY `r_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT pro tabulku `rest_table`
--
ALTER TABLE `rest_table`
  MODIFY `table_id` int(255) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT pro tabulku `rest_user`
--
ALTER TABLE `rest_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT pro tabulku `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- Omezení pro exportované tabulky
--

--
-- Omezení pro tabulku `dashboard_posts`
--
ALTER TABLE `dashboard_posts`
  ADD CONSTRAINT `dashboard_posts_ibfk_1` FOREIGN KEY (`category_id`) REFERENCES `dashboard_categories` (`category_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `dashboard_posts_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `dashboard_users` (`user_id`) ON UPDATE CASCADE;

--
-- Omezení pro tabulku `forgotten_passwords`
--
ALTER TABLE `forgotten_passwords`
  ADD CONSTRAINT `forgotten_passwords_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
