-- phpMyAdmin SQL Dump
-- version 4.7.7
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Creato il: Feb 17, 2018 alle 14:23
-- Versione del server: 10.1.31-MariaDB
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
('9788804599043', 'Il leone, la strega, l\'armadio - Le Cronache di Narnia', 'C. S. Lewis', 2010, 'Fantasy, Avventura'),
('9788804679301', 'e buona notte', 'Daniele Doesn\'t Matter', 2017, 'Fantasy'),
('9788804686118', 'Sono sempre io', 'Jojo Moyes', 2017, 'Narrativa moderna e contemporanea'),
('9788806218805', 'Trilogia siberiana: Educazione siberiana, ­Caduta libera, ­Il respiro del buio', 'Nicolai Lilin', 2014, 'Narrativa moderna e contemporanea'),
('9788806235062', 'Il marchio ribelle', 'Nicolai Lilin', 2018, 'Narrativa moderna e contemporanea'),
('9788806236151', 'La fisica nelle cose di ogni giorno', 'James Kakalios', 2017, 'Fisica'),
('9788817102001', 'Ore 15:17 attacco al treno', 'Anthony Sadler, Alek Skarlatos, Spencer Stone...', 2017, 'Contemporanea'),
('9788870914795', 'Il libro del mare o come andare a pesca di uno squalo gigante con un piccolo gommone sul vasto mare', 'Morten A. Stroksnes', 2017, 'Narrativa moderna e contemporanea'),
('9788870914825', 'L\'arte della fuga', 'Fredrik Sjöberg', 2017, 'Narrativa moderna e contemporanea'),
('9788870914900', 'Isola', 'Siri Ranva Hjelm Jacobsen', 2018, 'Narrativa moderna e contemporanea');

-- --------------------------------------------------------

--
-- Struttura della tabella `recensioni`
--

CREATE TABLE `recensioni` (
  `id_utente` int(11) NOT NULL,
  `isbn` char(13) COLLATE utf8mb4_unicode_ci NOT NULL,
  `descrizione` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `voto` tinyint(4) NOT NULL,
  `data` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dump dei dati per la tabella `recensioni`
--

INSERT INTO `recensioni` (`id_utente`, `isbn`, `descrizione`, `voto`, `data`) VALUES
(3, '9788804599043', 'Sono d\'accordo con Andrei', 5, '2018-02-17'),
(3, '9788804679301', 'Bellissimo', 5, '2018-02-17'),
(3, '9788804686118', 'Molto bello', 5, '2018-02-17'),
(3, '9788806236151', 'Ma si dai..', 4, '2018-02-17'),
(3, '9788817102001', 'Troppo lungo', 3, '2018-02-17'),
(4, '9788804599043', 'Bello', 5, '2018-02-17'),
(4, '9788804686118', 'Lezzo', 2, '2018-02-17'),
(5, '9788804599043', 'Ho l\'intero libro cartaceo delle Cronache di Narnia, ma ho preso questo Kindle per leggerlo con il tablet ai miei figli prima di andare a letto. Non discutiamo l\'opera di Lewis che ha il suo fascino (\"Papà, ci leggi Edmund?\"), ma mi soffermo sul formato. Ci sono le immagini originali abbozzate in bianco e nero a volte non immediatamente zoommabili (i bimbi ci tengono), il testo tradotto con qualche trattino di \"a capo\" quando non dovrebbe esserci. Per il resto tutto ok.', 3, '2018-02-17'),
(6, '9788804599043', 'Che schifo', 1, '2018-02-17');

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
(3, 'Carlo', 'Ramponi', 'carlor', '85fa2f777878f51610ebccc91467b116ca88590ed2be69064856cea83f269de1', 'df0028498529fcaf548fc472bc2ac1ce9f829de8f145c787f52ac813b5f26f4f'),
(4, 'Nicola', 'Salsotto', 'nicoVarg99', '29a59db2111cf3c78d8c8b0ac3d15043e90ce9d61ac77663bc0d38cc7c8b1003', '3876fd1e47c6006ee0255c61e929dd7bba48ba23224c99aca24baaab0bd55e23'),
(5, 'Andrei', 'Grigore', 'Croluy', 'e563298b39cc27326cad330a5dad9ba97df023bce11426bce4d50f0c154659ec', '65f2373286804fb951adf076f17cef103b3d8b386c2848fdd3748975819547a5'),
(6, 'Mirco', 'Sprighetti', 'coco', 'f8c3696d810e4fea481affe0bb462f3e918f47350f7154985982ea177c142f93', 'ab2473ad36077935e57a050f6e59d3105a1c463fa06c8a0ede72e202c54e8c47');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `libri`
--
ALTER TABLE `libri`
  ADD PRIMARY KEY (`isbn`);

--
-- Indici per le tabelle `recensioni`
--
ALTER TABLE `recensioni`
  ADD PRIMARY KEY (`id_utente`,`isbn`),
  ADD KEY `isbn` (`isbn`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `recensioni`
--
ALTER TABLE `recensioni`
  ADD CONSTRAINT `recensioni_ibfk_1` FOREIGN KEY (`id_utente`) REFERENCES `users` (`id`),
  ADD CONSTRAINT `recensioni_ibfk_2` FOREIGN KEY (`isbn`) REFERENCES `libri` (`isbn`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
