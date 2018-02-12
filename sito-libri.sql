-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Creato il: Feb 12, 2018 alle 16:14
-- Versione del server: 10.1.30-MariaDB
-- Versione PHP: 7.2.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sito-libri`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `libri`
--

CREATE TABLE `libri` (
  `isbn` char(13) COLLATE utf8mb4_unicode_ci NOT NULL,
  `titolo` varchar(120) COLLATE utf8mb4_unicode_ci NOT NULL,
  `autore` varchar(80) COLLATE utf8mb4_unicode_ci NOT NULL,
  `annoUscita` year(4) NOT NULL,
  `genere` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `libri`
--

INSERT INTO `libri` (`isbn`, `titolo`, `autore`, `annoUscita`, `genere`) VALUES
('9788804679301', 'e buona notte', 'Daniele Doesn\'t Matter', 2017, 'Fantasy'),
('9788804686118', 'Sono sempre io', 'Jojo Moyes', 2017, 'Narrativa moderna e contemporanea'),
('9788806236151', 'La fisica nelle cose di ogni giorno', 'James Kakalios', 2017, 'Fisica'),
('9788817102001', 'Ore 15:17 attacco al treno', 'Anthony Sadler, Alek Skarlatos, Spencer Stone...', 2017, 'Contemporanea');

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nome` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cognome` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `username` varchar(60) COLLATE utf8mb4_unicode_ci NOT NULL,
  `passwd` char(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `salt` char(64) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`id`, `nome`, `cognome`, `username`, `passwd`, `salt`) VALUES
(3, 'Carlo', 'Ramponi', 'carlor', '85fa2f777878f51610ebccc91467b116ca88590ed2be69064856cea83f269de1', 'df0028498529fcaf548fc472bc2ac1ce9f829de8f145c787f52ac813b5f26f4f');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `libri`
--
ALTER TABLE `libri`
  ADD PRIMARY KEY (`isbn`);

--
-- Indici per le tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
