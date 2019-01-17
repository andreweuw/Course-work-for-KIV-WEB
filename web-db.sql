-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Počítač: 127.0.0.1
-- Vytvořeno: Čtv 17. led 2019, 09:39
-- Verze serveru: 10.1.37-MariaDB
-- Verze PHP: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Databáze: `web-db`
--

-- --------------------------------------------------------

--
-- Struktura tabulky `articles`
--

CREATE TABLE `articles` (
  `article_id` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `abstract` text COLLATE utf8_czech_ci NOT NULL,
  `url` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `description` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `keywords` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `status` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `FK_user_id` int(11) NOT NULL,
  `file_name` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `reviewers_ids` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `reviewer_count` int(11) NOT NULL,
  `published` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `articles`
--

INSERT INTO `articles` (`article_id`, `title`, `abstract`, `url`, `description`, `keywords`, `status`, `FK_user_id`, `file_name`, `reviewers_ids`, `reviewer_count`, `published`) VALUES
(1, 'Diskuze', '<p style=\"text-align: justify;\">Smrt se týká <strong>každého</strong> z nás, mluví se však o ní málo. Měli bychom mít v závěrečné fázi života právo na milosrdnou smrt z rukou lékaře? Lékaři, právníci, filozofové a zdravotníci debatovali v Ostravě o eutanazii. Podle účastníků konference se jen pomalu rozvíjí diskuze na toto téma v odborných kruzích a zcela chybí ve společnosti.</p>\r\n<p style=\"text-align: justify;\">Mezi lékaři jsou zastánci i odpůrci eutanazie, podobné je to ve společnosti. Podle loňského průzkumu Centra pro výzkum veřejného mínění má ale více příznivců. Pro právo nevyléčitelně nemocných a trpících lidí na dobrovolnou smrt za pomoci lékaře se vyslovilo šedesát sedm procent respondentů. Proti jich bylo dvacet sedm procent. Na rozdíl od Holandska, Belgie, Lucemburska i některých amerických států je v Česku eutanazie trestným činem a posuzuje se jako vražda. Podle některých lékařů je však takzvaná <em>pasivní eutanazie</em> dávno součástí lékařské praxe.</p>', 'diskuze', 'Diskuze Akademie věd', 'diskuze, akademie věd, eutanazie', 'k recenzi', 2, 'diskuze_av.pdf', '', 0, 0),
(3, 'Jak to vnímají ostatní státy EU', '<p style=\"text-align: justify;\">Z etického pohledu je eutanazie velmi sporná. Tabu přírody a života jsou totiž neustále člověkem zpochybňována a zdolávána. Na mnohé, kdysi nemožné jsme už dnes přivykli: lze předělat pohlaví člověka, život lze v počátku ukončit interrupcí, pomocí vědy lze život prodlužovat. Smrt člověka je přitom chápána jako zlo, proti kterému je třeba bojovat. Úspěšné oddalování smrti však nezřídka provází pomalejší, bolestivější umírání. Pokrok v tomto směru přinesl i tzv.<em> pasivní eutanazii,</em> čili přerušení lékařské péče a odpojení přístrojů na podporu životních funkcí, když je zřejmé, že smrt vítězí. Při aktivní eutanázii se aplikuje např. injekce. Mezi pasivní a aktivní eutanazií z medicínského pohledu tak už leží \"jen\" nehluboký příkop. Z mravního pohledu mezi nimi zeje stále obrovská propast. Aby společnost přijala možnost řízeného usmrcení je a bude v dohledné době velice těžké. Otázkou je totiž i zda jsou hodnoty, které vyznává naše společnost, s usmrcením na přání nemocného vůbec slučitelné. Schopnost nalézat tvůrčí řešení (hospic, stacionáře, asistovaná domácí péče) by se legalizací eutanazie zbrzdila: bylo by to vítězství racionálního plánování nad tradičním respektem k hodnotě života. Legalizace eutanazie by znamenala také nátlak na psychiku lékaře: neměl by rozhodovat o hodnotě léčby, ale o hodnotě pacientova života.</p>', 'zahranici', 'Eutanazie v zahraničí', 'eutanazie, pohledy, zahranici, jinak', 'čeká na rozhodnutí administrátora', 3, 'zahranici_eutanazie.pdf', '6_5_9', 3, 0),
(4, 'Eutanazie a trestní právo', '<p style=\"text-align: justify;\">Problém euthanasie není „<em>nový“</em>. Objevuje se jiţ ve stoické etice ve 3. století před našim letopočtem. V posledních desetiletích se zvláště v <strong>Evropě a v Severní Americe</strong> rozrostla o euthanasii diskuse. Proč euthanasie vzbuzuje takový zájem v dnešní době lze přičíst zejména tomu, že s vědeckotechnickým rozvojem se narušily tradiční náboţenské představy o transcedentní povaze lidského ţivota. S tím lidský ţivot ztrácí svou všeobecně přijímanou trvalou hodnotu. Dalším důvodem je pak pokrok v lékařských znalostech a dovednostech a technologiích, který způsobil, ţe pro mnohé lidi mohou být zdrojem strachu, ţe hodnota prodlouţeného ţivota poklesne na nepřijatelnou hranici, zatím co euthanasie je efektivní vyřešení jejich váţných bolestí. Lze říct, ţe moţnost uskutečnit určité lékařské zákroky předběhla poznání, jak jich použít moudře. Euthanasie se prezentuje jako to, co poskytuje milosrdné osvobození od utrpení a přitom má respekt k pacientově autonomii. Prezentuje se jako problém lidských práv i jako příklad pokrokového reformního úsilí. Pro euthanasii hovoří stále více ti, kdo jsou unaveni ţivotem aniţ by byli smrtelně nemocni, a také ti, co hlásají, že lidé mají právo řídit si svoje umírání podle sebe. To ovšem znamená posun a pouhé přiţivování se na problému, jde o přání zemřít z důvodů filosofických, společenských a nikoli zdravotních.</p>', 'tresni_pravo', 'Pohled na eutanazii trochu z jiného konce', 'trestní právo, právo, eutanazie, etika', 'k recenzi', 3, 'tresni_pravo_eutanazie_2.pdf', '4_5_6', 3, 0),
(5, 'Pro legalizaci v Čechách', '<p style=\"text-align: justify;\">V případě diskuse o zavedení <strong>euthanasie</strong> je velmi<strong> těžká jednoznačná</strong> odpověď. Je zde nebezpečí jak jejího zneužití, tak psychologických škod napáchaných na spoustě pacientů, kteří se budou bát, jestli je lékař zítra neusmrtí. Na druhou stranu, úkolem medicíny je člověka léčit a zbavovat utrpení, a ne nevyhnutelné utrpení prodlužovat. Moderní medicína má možnosti jak udržovat lidský život i v podmínkách konečných fází smrtelných nemocí, kde by člověk byl už mrtev. A zde se tedy objevuje myšlenka euthanasie, tedy nějakého zákroku, či postupu, který ukončí lidský život, nebo umožní alespoň přirozenou smrt bez jeho umělého prodlužování. Je tedy euthanasie řešením v případě, kdy už nejsou žádné vyhlídky na pozitivní změnu zdravotního stavu, utrpení je nesnesitelné a nedůstojné, neumožňuje smysluplný pocit ze života a pacient sám (nebo v některých případech jeho nejbližší příbuzní) o euthanasii požádá? Jsou známy případy, kdy lékaři, a někdy také sestry, už nevydrželi přihlížet utrpení těch, kteří žádali pomoc, a pomohli byť protizákonně ukončit jejich život. Je v tomto případě euthanasie zabití nebo pomoc? Constitutional Rights <em>Foundation Chicago a Partners Czech, o.p.s</em>. Mnoho lékařů je toho názoru, že by možnost aktivní a pasivní euthanasie měla legálně existovat, samozřejmě za přísně kontrolovaných podmínek. Jako forma poslední možnosti pomoci, jako forma lidskosti, úcty k lidské individualitě a k právu člověka rozhodovat sám o sobě.</p>', 'legalizace', 'Argumenty pro legalizaci metody v Čechách', 'legalizace, legalita, Čechy, ', 'k recenzi', 4, 'legalizace_legalizace.pdf', '', 0, 0),
(6, 'Eutanazie a pomoc při sebevraždě', '<p style=\"text-align: justify;\">Pod slovem euthanasie si každý představuje něco trochu jiného. Předpokladem co možná úspěšného uchopení tématu je tedy přesná terminologie a tím i přesné položení otázek. Euthanasie zahrnuje několik variant předčasného ukončení lidského života. Euthanasie je definována jako úmyslná činnost, kterou se život zkrátí nebo u nevyléčitelných pacientů úmyslně neprodlužuje, a to k jejich prospěchu. Pacient (dospělý, a nikoliv duševně chorý) k tomu musí dát dobrovolně souhlas. Jde- li o pasivní euthanasii, nečiní se nic, co by život pacienta prodlužovalo (zemře na vlastní nemoc). Jde například o situace, kdy pacientovi jsou uměle udržovány jeho základní životní funkce a euthanasie v tomto případě znamená odpojení přístrojů. Jedná se tedy o další nepokračování léčby v případě, že je bez úspěchu. Může jít i o nezahajování další léčby nebo resuscitace, na pacientovu vlastní žádost. Americký systém umožňuje, aby plně informovaný pacient při jasném vědomí a bez nátlaku sepsal dokument zvaný living will, v němž určuje, jak mají lékaři a zdravotnický personál postupovat, kdyby se dostal do stavu, v němž mu hrozí umělé přežívání na přístrojích. V tomto případě na přání a se souhlasem nevyléčitelně nemocného již nejsou prováděny další lékařské zásahy, které přicházející smrt prokazatelně neoddálí. Pacient zde má právo tyto zásahy odmítnout s vědomím, že na sebe přebírá všechnu odpovědnost za důsledky z tohoto kroku plynoucí. Jde-li o aktivní euthanasii, vyvine lékař činnost, kterou život pacienta ukončí. Jedná se o aktivní účasti lékaře při usmrcení pacienta na jeho žádost, popřípadě bez jeho žádosti v podmínkách, které lékař považuje již za bezvýchodné, avšak pacient je v takovém stavu, že svou vůli nemůže vyjádřit.</p>', 'snemovna', 'Informační podklad Kanceláře Poslanecké sněmovny', 'snemovna, podklad', 'k recenzi', 5, 'snemovna_parlamentni_institut.pdf', '', 0, 0),
(7, 'Proč jsem proti', '<p style=\"text-align: justify;\">Řecká bohyně noci Nyx, dcera Chaosu, měla dva syny. Hypnos, bůh spánku, byl zobrazován se dvěma makovicemi v ruce, Thanatos, bůh smrti, držel k zemi obrácenou uhaslou pochodeň. Euthanasie ve svém původním významu je označením dobré (tedy lehké) smrti a její pozdější zpodobnění můžeme dodnes vidět na Kuksu v barokní plastice Anděla blažené smrti. Hippokratovská medicína řídící se příkazem: <em>Nepodám nikomu smrtící prostředek, ani kdyby mě o to kdokoli požádal, a nikomu také nebudu radit (jak zemřít), neměla problematiku eutanazie ani v náplni svých úvah, natož ve své praxi.</em> Bolehlav pro Sokrata nepřipravili lékaři, ale oficiální athénský travič. Nelze vyloučit, že vysoké dávky opioidů podávané pacientům v terminálních fázích nemoci mohly zkrátit jejich život, nebyly však nikdy podávány s úmyslem zabít, ale s úmyslem zmírnit utrpení, zejména bolest. Spis A. Jorsta nazvaný Právo zemřít, který vyšel v Německu v r. 1885, nevyvolal větší ohlas. Termín eutanazie ve smyslu „usmrcení nemocných prováděné lékaři“ se vynořil a vstoupil do celosvětového povědomí v roce 1940, kdy nacisté pod tímto heslem v programu T 44 začali zabíjet v plynových komorách, a nakonec vyvraždili více než 70 000 „méněcenných“ osob z ústavů pro duševně nemocné, z káznic a dalších institucí. Hitlerův rozkaz obsahující jedinou větu byl antedatován k počátku války (1. 9. 1939) a platil po celou válku jako „právní podklad“ pro masové vraždění.</p>', 'proti', 'Proč jsem jako autor proti eutanazii', 'důvod proti, proti', 'k recenzi', 5, 'proti_proc_proti.pdf', '', 2, 0),
(9, 'Z hľadiska trestného práva', '<p style=\"text-align: justify;\">Problematika eutanázie sa s rozvojom poznatkov medicíny stala čoraz aktuálnejšou a naliehavejšou. Diskusie o eutanázii sa začali v 19. storočí, rozvinuli sa v úvode 20. storočia, no po skúsenostiach s tzv. programom eutanázie v nacistickom Nemecku po druhej svetovej vojne na niekoľko desaťročí akékoľvek diskusie utíchli. Až od sedemdesiatych rokov 20. storočia sa téma eutanázie začala opätovne otvárať. Slovenské právo v súčasnosti nemá vhodné prostriedky, ktoré by jednoznačným spôsobom umožnili rozlíšiť usmrtenie terminálne chorého jedinca zo súcitu a na jeho výslovnú žiadosť, prípadne pomoc pri samovražde takéhoto jedinca a „obyčajný“ trestný čin vraždy.</p>', 'slovensko_trestne_pravo', 'Další pohled, tentokrát ze Slovenska', 'eutanazia, asistovana samovražda, Slovensko, súčasný stav', 'schváleno', 6, 'slovensko_trestne_pravo_trestne_pravo.pdf', '6_11_5', 3, 1),
(10, 'Co mluví i dnes proti eutanazii?', '<p style=\"text-align: justify;\">Doutnající diskuze o<strong> eutanazii se v současnosti i v naší zemi opět rozhořela. V novém návrhu trestního zákona usmrcení na žádost nevyléčitelně nemocné osoby přestává být vraždou a pro tento skutek je stanovena trestní sazba „až</strong> šest let odnětí svobody“. Především lidé handicapovaní považují tuto formulaci za velmi nebezpečnou, jelikož nestanovuje dolní hranici trestu. Někteří právníci tvrdí, že toto vyjádření není synonymem s možnou „beztrestností“, uznávají však, že uvedené soudci umožňuje obžalovaného nepotrestat vůbec. Někteří politikové se domnívají, že takový návrh je prvním krokem k legalizaci eutanazie. A mnozí novináři opět matou pojmy mísíce nemísitelné a tím, pravděpodobně zcela nevědomky, mění vnímání společnosti ve prospěch zabíjení pacientů.</p>', 'historie', 'Historický vývoj a dnešní obraz', 'eutanazie, asistovaná sebevražda', 'schváleno', 1, 'historie_', '12_12_11', 3, 1),
(11, 'Čechy', '<p style=\"text-align: justify;\">I v českém prostředí je otázka eutanazie a asistované smrti poměrně aktuálním tématem, ovšem rozhodně ne tématem novým. Už v prvorepublikové právnické literatuře 405 se vedly spory ohledně výkladových stanovisek k asistované smrti obecně, tradičně byly tyto debaty ovlivňovány německou a rakouskou právní doktrínou. Současná úprava může být považována v rámci evropské komparace za konzervativnější a striktněji uplatňující zákaz zásahu do <em>posvátnosti lidského života</em>. Paradoxně v praxi nebývají zásahy poskytovatelů zdravotních služeb příliš často postihovány, a dokonce ani řešeny soudní cestou. Jistá dualita stanoveného pozitivního psaného práva a aplikovaného práva je zřejmě pozůstatkem komunistického totalitního režimu a silného paternalistického konceptu ve vztahu lékaře (resp. kliniky) a pacienta. I z tohoto důvodu zaznívají často v odborné veřejnosti názory, aby právo (potažmo právníci a legislativa) žádným způsobem nezasahovalo do otázek na konci života, které by měly být řešeny pouze medicínskými odborníky</p>', 'cechy', 'Situace v Čechách', 'diskuze, cechy, eutanazie, koncepce', 'čeká na rozhodnutí administrátora', 2, 'cechy_', '12_11_9', 3, 0);

-- --------------------------------------------------------

--
-- Struktura tabulky `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `FK_article_id` int(11) NOT NULL,
  `notes` text COLLATE utf8_czech_ci NOT NULL,
  `score` enum('velmi dobré','dobré','normální','špatné','velmi špatné') COLLATE utf8_czech_ci NOT NULL,
  `lingvistic` enum('velmi dobré','dobré','normální','špatné','velmi špatné') COLLATE utf8_czech_ci NOT NULL,
  `technical` enum('velmi dobré','dobré','normální','špatné','velmi špatné') COLLATE utf8_czech_ci NOT NULL,
  `reviewer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `reviews`
--

INSERT INTO `reviews` (`review_id`, `FK_article_id`, `notes`, `score`, `lingvistic`, `technical`, `reviewer_id`) VALUES
(38, 3, '<p>Byl to dobrý článek, až na ten<strong> jazyk.</strong></p>', 'velmi dobré', 'velmi dobré', 'velmi dobré', 9),
(39, 11, '<p>V pořádku, Vaše názory mě nazaskočily...</p>', 'velmi špatné', 'špatné', 'normální', 9),
(40, 10, '<p>Výborné, podporuji!</p>', 'velmi dobré', 'velmi dobré', 'dobré', 12);

-- --------------------------------------------------------

--
-- Struktura tabulky `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `password` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `status` varchar(255) COLLATE utf8_czech_ci NOT NULL,
  `blocked` tinyint(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_czech_ci;

--
-- Vypisuji data pro tabulku `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`, `status`, `blocked`) VALUES
(1, 'Admin', '$2y$10$EaGc7xcKHoM6TF4lrmCqqeRWg0UrEd0rMND.wHSl3mu4x.NUKwuSu', 'administrator', 0),
(2, 'Adolf Novák', '$2y$10$DvqzZB1vBlmLQx93q8HerOA84vKLBwd43QGR7EXC8BjqZPa/S2EeW', 'autor', 0),
(4, 'Jan Strmý', '$2y$10$E6Nhzxx.8SsfzmmWQjSx8.zesbj21fl2TBCdvS26tnxURCTwaClh.', 'recenzent', 1),
(5, 'Jana Šikmá', '$2y$10$e4irEeQa2zfSQh/76CnmCe0t/38fvgRdjzbOr8CMJfbFFbrNjwmpm', 'recenzent', 0),
(6, 'Aneta Brožová', '$2y$10$KK2nSwPJuV..6tKwupBR9umSJVEbKqEF/SXkZFLqZADVSnDl79GgG', 'recenzent', 0),
(8, 'Roman Statečný', '$2y$10$xAduJoFkO.GpoYXblxyaoOVTOvd0y749Z0V1tjFGwE70csKKw1rQu', 'autor', 1),
(9, 'Anežka Bělá', '$2y$10$FzwJDVZEpwTBqowF1mMNGeUwyqrhfOXOa3IpU8zM6smlvRTvZKnNy', 'recenzent', 0),
(11, 'Adam Mastný', '$2y$10$dOVWmNtp9BuIGx.Kg9MwxedvlH7LPSRiRQ80AHclg4XF3a.XmyfkS', 'recenzent', 0),
(12, 'Bořek Stavitel', '$2y$10$nX9Rx.KPOO3vmy6Ai1NTf.s3f7P9XBbH3nkLDknOtTEQ1H892JDXS', 'recenzent', 0),
(13, 'David Medvěd', '$2y$10$wCXW8yI069sbb4Icisij3.yARh4wjcM6I/PAS50iDnZ4GXy4gSl8q', 'autor', 1),
(14, 'Uživatel Starý', '$2y$10$kNVpjrOMLMIwusIumhokf.AWPMRKlZjzne./Fk5RbzT7WXyxVS2se', 'autor', 0);

--
-- Klíče pro exportované tabulky
--

--
-- Klíče pro tabulku `articles`
--
ALTER TABLE `articles`
  ADD PRIMARY KEY (`article_id`);

--
-- Klíče pro tabulku `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`);

--
-- Klíče pro tabulku `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT pro tabulky
--

--
-- AUTO_INCREMENT pro tabulku `articles`
--
ALTER TABLE `articles`
  MODIFY `article_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pro tabulku `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=41;

--
-- AUTO_INCREMENT pro tabulku `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
