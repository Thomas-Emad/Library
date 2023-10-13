-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Oct 13, 2023 at 01:56 PM
-- Server version: 8.0.30
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `library`
--

-- --------------------------------------------------------

--
-- Table structure for table `authors`
--

CREATE TABLE `authors` (
  `id` int NOT NULL,
  `num` int NOT NULL,
  `author` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `authors`
--

INSERT INTO `authors` (`id`, `num`, `author`) VALUES
(1, 0, 'البابا شنودة الثالث ');

-- --------------------------------------------------------

--
-- Table structure for table `books`
--

CREATE TABLE `books` (
  `id` int NOT NULL,
  `code` varchar(512) DEFAULT NULL,
  `name` varchar(512) DEFAULT NULL,
  `img` varchar(255) NOT NULL,
  `part_number` varchar(255) DEFAULT 'N/A',
  `section` varchar(255) DEFAULT NULL,
  `series` varchar(512) DEFAULT NULL,
  `author` varchar(512) DEFAULT NULL,
  `publisher` varchar(512) DEFAULT NULL,
  `num_page` int DEFAULT NULL,
  `num_copy` int DEFAULT NULL,
  `unit_number` int DEFAULT NULL,
  `shelf_number` varchar(255) DEFAULT NULL,
  `position_book_sh` int DEFAULT NULL,
  `subjects` varchar(512) DEFAULT NULL,
  `visits` int NOT NULL,
  `add_time` datetime DEFAULT CURRENT_TIMESTAMP,
  `famous` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `books`
--

INSERT INTO `books` (`id`, `code`, `name`, `img`, `part_number`, `section`, `series`, `author`, `publisher`, `num_page`, `num_copy`, `unit_number`, `shelf_number`, `position_book_sh`, `subjects`, `visits`, `add_time`, `famous`) VALUES
(1, '121', 'حياة التواضع و الوداعة', '', '', 'البابا شنودة الثالث', '', 'البابا شنودة الثالث ', 'الكلية الاكليريكية', 192, 2, 1, '2', 1, '', 8, '2023-06-14 21:49:52', 1),
(2, '122', 'اللاهوت المقارن (الجزء الاول )', '', '1', 'البابا شنودة الثالث', '', 'البابا شنودة الثالث ', 'الكلية الاكليريكية', 174, 2, 4, '2', 2, 'الايمان وصحة التعليم - مجمل خلافاتنا مع البروتستانت - التقليد - الشفاعة - اكرام العذراء و دوام بتوليتها - الصوم - الحكم الالفي - المواهب و الالسنه - التوبه - وساطة الكنيسة - خلافات طقسية', 0, '2023-06-14 21:49:52', 0),
(3, '123', 'الغضب', '', '', 'البابا شنودة الثالث', 'الحروب الروحية رفم 3', 'البابا شنودة الثالث ', 'مطبعة الانبا رويس', 128, 3, 1, '2', 3, 'الغضب المقدس - تاغضب الخاطئ الباطل- انواع و درجات الغضب - الاحتمال - اسباب الغضب - علاج الغضب', 1, '2023-06-14 21:49:52', 0),
(4, '124', 'الحروب الروحية', '', '', 'البابا شنودة الثالث', 'الحروب الروحية رفم 2', 'البابا شنودة الثالث ', 'مطبعة الانبا رويس', 231, 1, 1, '2', 4, 'الحروب داخلك وخارجك - حرب الذات - الفراغ - التسيبات - الشك - الخوف - حروب الفكر - المظاهر الخارجيه- خطايا اللسان  - قساوة القلب- الفتور الروحي - حرب الكابة - العنف - محبة المديح و الكرامة ', 5, '2023-06-14 21:49:52', 1),
(60, '126', 'مجموعة تاملات في اسبوع الالام ', 'null', 'null', 'البابا شنودة الثالث', 'null', 'البابا شنودة الثالث ', 'مطبعة الانبا رويس', 237, 3, 1, '2', 6, 'اهمية الاسبوع - تامل في الالام المسيح - كيف نستفيد من هذا الاسبوع - تسبحه البصخه ', 0, '2023-06-14 22:02:25', 0),
(61, '1261', 'لماذا القيامة ؟', 'null', 'null', 'البابا شنودة الثالث', 'null', 'البابا شنودة الثالث ', 'الكلية الاكليريكية', 8, 5, 1, '2', 61, 'القيامة معجزة ضرورية - القيامة هي قيامة الجسد - لماذا يهتم الله بالاجساد - القيامة هي الباب الموصل للسماء - القيامة و اعماقها الروحية', 0, '2023-06-14 22:02:25', 0),
(62, '1262', '5', 'null', 'null', 'البابا شنودة الثالث', 'null', 'البابا شنودة الثالث ', 'null', 96, 3, 1, '2', 62, 'حياة', 4, '2023-06-14 22:02:25', 1),
(63, '1263', 'الوصايا العشر (الجزء الثاني) اكرم اباك وامك', 'null', 'null', 'البابا شنودة الثالث', 'null', 'البابا شنودة الثالث ', 'الكلية الاكليريكية', 48, 3, 1, '2', 63, 'الابوة الطبيعية و احترام الاقارب الكبار - كيف نكرم الاباء و الامهات - حول الطاعه و الخضوع - واجب الاباء نحو ابنائهم - حدود اكرام الوالدين - انواع اخري من الابوه', 0, '2023-06-14 22:02:26', 0),
(64, '1264', 'الوصايا العشر (الوصايا الاربع الاولي)', 'null', 'null', 'البابا شنودة الثالث', 'null', 'البابا شنودة الثالث ', 'الكلية الاكليريكية', 63, 3, 1, '2', 64, 'كلمة عامة عن الوصايا العشر - الوصيه الاولي  (انا الرب الهك) - الوصيه الثانيه (لا تضع لك تمثالا منحوتا) - الوصيه الثالثه (لا تنطق باسم الرب الهك باطلا) - الوصيه الرابعه (اذكر يوم السبت لتقدسه)', 3, '2023-06-14 22:02:26', 1),
(65, '1265', 'الوصايا العشر (لا تقتل)', 'null', 'null', 'البابا شنودة الثالث', 'null', 'البابا شنودة الثالث ', 'الكلية الاكليريكية', 48, 2, 1, '2', 65, 'القتل المباح - اهمية هذه الوصيه - انواع من القتل - القتل غير المباشر - قتل الروح - قتل الانسان لنفسه - اجابة اسئلة تتعلق بالموضوع', 3, '2023-06-14 22:02:26', 1),
(66, '1266', 'الوصايا العشر (الوصايا الاربع الاخيرة)', 'null', 'null', 'البابا شنودة الثالث', 'null', 'البابا شنودة الثالث ', 'الكلية الاكليريكية', 63, 3, 1, '2', 66, 'الوصيه السابعه  (لا تزن) - الوصيه الثامنه (لاتسرق) الوصيه التاسعه(لا تشهد بالزور) - الوصيه العاشرة (لا تشتهي مما لقريبك)', 0, '2023-06-14 22:02:26', 0),
(67, '1267', 'روحانية الصوم', 'null', 'null', 'البابا شنودة الثالث', 'null', 'البابا شنودة الثالث ', 'الكلية الاكليريكية', 8, 3, 1, '2', 67, 'اهمية الصوم - الصوم و الجسد - قدسوا صوما- فضائل و مشاعر مصاحبه للصوم - تدرايب اثناء الصوم', 0, '2023-06-14 22:02:26', 0),
(68, '1268', 'ثمر الروح', 'null', 'null', 'البابا شنودة الثالث', 'null', 'البابا شنودة الثالث ', 'الكلية الاكليريكية', 96, 3, 1, '2', 68, 'ثمار الروح القدس ( المحبه - الفرح - السلام - اللطف - الصلاح - الايمان - الوداعة - التعفف )', 1, '2023-06-14 22:02:26', 0),
(69, '1269', 'من هو الانسان', 'null', 'null', 'البابا شنودة الثالث', 'null', 'البابا شنودة الثالث ', 'الكلية الاكليريكية', 144, 3, 1, '2', 69, 'الانسان نفس و جسد و روح - طاقات الانسان و غرائزه - ما الذي يقود الانسان في حياته - العقل - الضمير - الجسد - القلب - الفكر - الروح الانسانية - الاراده - الحياه', 0, '2023-06-14 22:02:26', 0),
(70, '127', 'عشرة مفاهيم', 'null', 'null', 'البابا شنودة الثالث', 'null', 'البابا شنودة الثالث ', 'الكلية الاكليريكية', 96, 3, 1, '2', 7, 'مفهوم القوة - مفهوم الحريه - مفهوم الراحه والتعب - مفهوم الطموح -مفهوم الخطية - مفهوم الحب و الصداقة - مفهوم العثرة - مفهوم الوداعة - مفهوم الحق و العدل - مفهوم المعرفة', 0, '2023-06-14 22:02:26', 0),
(71, '1271', 'الرجاء', 'null', 'null', 'البابا شنودة الثالث', 'null', 'البابا شنودة الثالث ', 'null', 188, 4, 1, '2', 71, 'null', 0, '2023-06-14 22:02:26', 0),
(72, '1272', 'الروح القدس و عمله فينا', 'null', 'null', 'البابا شنودة الثالث', 'null', 'البابا شنودة الثالث ', 'null', 128, 1, 1, '2', 72, 'null', 0, '2023-06-14 22:02:26', 0),
(73, '1273', 'لاهوت المسيح', 'null', 'null', 'البابا شنودة الثالث', 'null', 'البابا شنودة الثالث ', 'الكلية الاكليريكية', 111, 3, 1, '2', 73, 'null', 0, '2023-06-14 22:02:26', 0),
(74, '1274', 'بدع حديثة', 'null', 'null', 'البابا شنودة الثالث', 'اللاهوت المقارن', 'البابا شنودة الثالث ', 'الكلية الاكليريكية', 223, 3, 1, '2', 74, 'null', 0, '2023-06-14 22:02:26', 0),
(75, '1275', 'تاملات في العظة علي الجبل', 'null', 'null', 'البابا شنودة الثالث', 'null', 'البابا شنودة الثالث ', 'الكلية الاكليريكية', 144, 1, 1, '2', 75, 'null', 0, '2023-06-14 22:02:26', 0),
(76, '1276', 'تاملات في العظة علي الجبل ( طبعة جديده)', 'null', 'null', 'البابا شنودة الثالث', 'null', 'البابا شنودة الثالث ', 'الكلية الاكليريكية', 328, 1, 1, '2', 76, 'null', 0, '2023-06-14 22:02:26', 0),
(77, '1277', 'تاملات في يوم الجمعة العظيمة', 'null', 'null', 'البابا شنودة الثالث', 'null', 'البابا شنودة الثالث ', 'الكلية الاكليريكية', 61, 1, 1, '2', 77, 'null', 0, '2023-06-14 22:02:27', 0),
(78, '1278', 'تاملات في يوم خميس العهد ', 'null', 'null', 'البابا شنودة الثالث', 'null', 'البابا شنودة الثالث ', 'null', 64, 1, 1, '2', 78, 'null', 0, '2023-06-14 22:02:27', 0),
(79, '1279', 'حروب الشياطين ', 'null', 'null', 'البابا شنودة الثالث', 'null', 'البابا شنودة الثالث ', 'null', 12, 1, 1, '2', 79, 'null', 0, '2023-06-14 22:02:27', 0),
(80, '128', 'انطلاق الروح', 'null', 'null', 'البابا شنودة الثالث', 'null', 'البابا شنودة الثالث ', 'الكلية الاكليريكية', 151, 3, 1, '2', 8, 'null', 0, '2023-06-14 22:02:27', 0),
(81, '1281', 'الذات (الانا)', 'null', 'null', 'البابا شنودة الثالث', 'null', 'البابا شنودة الثالث ', 'الكلية الاكليريكية', 96, 1, 1, '2', 81, 'null', 0, '2023-06-14 22:02:27', 0),
(82, '1282', 'الهدوء', 'null', 'null', 'البابا شنودة الثالث', 'null', 'البابا شنودة الثالث ', 'null', 128, 1, 1, '2', 82, 'null', 0, '2023-06-14 22:02:27', 0);

-- --------------------------------------------------------

--
-- Table structure for table `publications`
--

CREATE TABLE `publications` (
  `id` int NOT NULL,
  `post_random` int NOT NULL,
  `username` int NOT NULL,
  `img` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `time_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `market` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `publishers`
--

CREATE TABLE `publishers` (
  `id` int NOT NULL,
  `num` int NOT NULL,
  `publisher` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `publishers`
--

INSERT INTO `publishers` (`id`, `num`, `publisher`) VALUES
(1, 0, 'الكلية الاكليريكية'),
(2, 0, 'مطبعة الانبا رويس');

-- --------------------------------------------------------

--
-- Table structure for table `shelf`
--

CREATE TABLE `shelf` (
  `id` int NOT NULL,
  `unit_number` int NOT NULL,
  `shelf_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `shelf_number` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `shelf`
--

INSERT INTO `shelf` (`id`, `unit_number`, `shelf_name`, `shelf_number`) VALUES
(1, 1, 'البابا شنوده', 1),
(2, 1, 'البابا شنوده', 2),
(3, 1, 'البابا شنوده', 3),
(4, 3, 'فلسفه', 1),
(5, 3, 'فلسفه', 2),
(6, 3, 'فلسفه', 3),
(7, 3, 'فلسفه', 4),
(8, 2, 'أدب', 1),
(9, 2, 'أدب', 2),
(10, 2, 'أدب', 3),
(11, 2, 'أدب', 4),
(16, 4, 'علوم', 1),
(17, 4, 'علوم', 2),
(18, 4, 'علوم', 3),
(19, 4, 'علوم', 4),
(20, 5, 'أسقفية الشباب', 1),
(21, 5, 'أسقفية الشباب', 2),
(22, 5, 'أسقفية الشباب', 3),
(23, 5, 'أسقفية الشباب', 4),
(24, 5, 'أسقفية الشباب', 5),
(25, 5, 'أسقفية الشباب', 6),
(26, 6, 'تاريخ', 1),
(27, 6, 'تاريخ', 2),
(28, 6, 'تاريخ', 3),
(29, 6, 'تاريخ', 4),
(30, 7, 'روحيات', 1),
(31, 7, 'روحيات', 2),
(32, 7, 'روحيات', 3),
(33, 7, 'روحيات', 4),
(34, 8, 'سير قديسين', 1),
(35, 8, 'سير قديسين', 2),
(36, 8, 'سير قديسين', 3),
(37, 8, 'سير قديسين', 4),
(38, 9, 'خدمات', 1),
(39, 9, 'خدمات', 2),
(40, 9, 'خدمات', 3),
(41, 9, 'خدمات', 4),
(42, 9, 'خدمات', 5),
(43, 9, 'خدمات', 6),
(44, 10, 'اباء اولين', 1),
(45, 10, 'اباء اولين', 2),
(46, 10, 'اباء اولين', 3),
(47, 10, 'اباء اولين', 4),
(48, 10, 'اباء اولين', 5),
(49, 10, 'اباء اولين', 6),
(50, 11, 'كتاب مقدس', 1),
(51, 11, 'كتاب مقدس', 2),
(52, 11, 'كتاب مقدس', 3),
(53, 11, 'كتاب مقدس', 4),
(54, 12, 'أبائيات', 1),
(55, 12, 'أبائيات', 2),
(56, 12, 'أبائيات', 3),
(57, 12, 'أبائيات', 4),
(58, 13, '******', 1),
(59, 13, '******', 2),
(60, 13, '******', 3),
(61, 13, '******', 4),
(62, 14, '******', 1),
(63, 14, '******', 2),
(64, 14, '******', 3),
(65, 14, '******', 4),
(66, 14, '******', 5),
(67, 14, '******', 6),
(68, 15, 'ألانبا غريغوريوس', 1),
(69, 15, 'ألانبا غريغوريوس', 2),
(70, 15, 'ألانبا غريغوريوس', 3),
(71, 16, 'مدرسه الاسكندرية', 1),
(72, 16, 'مدرسه الاسكندرية', 2),
(73, 16, 'مدرسه الاسكندرية', 3),
(74, 16, 'مدرسه الاسكندرية', 4),
(75, 16, 'مدرسه الاسكندرية', 5);

-- --------------------------------------------------------

--
-- Table structure for table `unit`
--

CREATE TABLE `unit` (
  `id` int NOT NULL,
  `num` int NOT NULL,
  `unit_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `unit`
--

INSERT INTO `unit` (`id`, `num`, `unit_name`) VALUES
(1, 1, 'البابا شنودة الثالث '),
(2, 3, 'فلسفه'),
(3, 5, 'أسقفية الشباب'),
(4, 6, 'تاريخ'),
(5, 8, 'سير قديسين'),
(6, 9, 'خدمات'),
(7, 11, 'كتاب مقدس'),
(8, 12, 'أبائيات'),
(9, 15, 'ألانبا غريغوريوس'),
(10, 16, 'مدرسه الاسكندرية'),
(11, 2, 'أدب'),
(12, 7, 'روحيات'),
(13, 4, 'علوم'),
(14, 10, 'اباء اولين'),
(15, 13, '******'),
(16, 14, '******');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int NOT NULL,
  `username` int NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `phone` varchar(12) NOT NULL,
  `password` varchar(255) NOT NULL,
  `img` varchar(255) NOT NULL,
  `permissions` varchar(255) NOT NULL,
  `birthday` timestamp NOT NULL,
  `create_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `name`, `email`, `phone`, `password`, `img`, `permissions`, `birthday`, `create_at`) VALUES
(44, 230614653, 'توماس', 'tomtom22006@gmail.com', '01112638680', '123456', '', 'owner', '2023-06-03 21:00:00', '2023-06-14 15:20:38');

-- --------------------------------------------------------

--
-- Table structure for table `word_day`
--

CREATE TABLE `word_day` (
  `id` int NOT NULL,
  `random_num` int NOT NULL,
  `content` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `source` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `status` int NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `word_day`
--

INSERT INTO `word_day` (`id`, `random_num`, `content`, `source`, `status`) VALUES
(8, 231346321, 'المتواضعون كالصخرة، تنزل إلى أسفل، ولكنها ثابتة وراسخة.. أما المتكبرون فإنهم كالدخان يعلو إلى فوق ويتسع. وفيما هو يعلو ويتسع، يضمحل ويتبدد..', 'القديس أغسطينوس', 0),
(9, 231393139, 'تواضع القلب يتقدم الفضائل كلها. كما أن الكبرياء أساس الشرور كلها.', 'الأنبا موسى', 1),
(10, 231315594, 'الذي يعرف خطاياه، خير له من نفعه الخليقة كلها بمنظره. والذي يتنهد كل يوم على نفسه بسبب خطاياه، خير من أن يقيم الموتى.. والذي استحق أن يبصر خطاياه، خير له من أن يبصر ملائكة.', 'مار اسحق', 0),
(11, 231333297, 'كما أن الأرض لا تسقط لأنها كائنة إلى أسفل، هكذا من يضع نفسه لا يسقط', 'أنبا بيمن', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `authors`
--
ALTER TABLE `authors`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `books`
--
ALTER TABLE `books`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `code` (`code`),
  ADD UNIQUE KEY `code_2` (`code`);

--
-- Indexes for table `publications`
--
ALTER TABLE `publications`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `post_random` (`post_random`),
  ADD KEY `username` (`username`);

--
-- Indexes for table `publishers`
--
ALTER TABLE `publishers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `shelf`
--
ALTER TABLE `shelf`
  ADD PRIMARY KEY (`id`),
  ADD KEY `unit_number` (`unit_number`);

--
-- Indexes for table `unit`
--
ALTER TABLE `unit`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `unit_number` (`num`),
  ADD UNIQUE KEY `num` (`num`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `word_day`
--
ALTER TABLE `word_day`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `random_num` (`random_num`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `authors`
--
ALTER TABLE `authors`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `books`
--
ALTER TABLE `books`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=94;

--
-- AUTO_INCREMENT for table `publications`
--
ALTER TABLE `publications`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `publishers`
--
ALTER TABLE `publishers`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `shelf`
--
ALTER TABLE `shelf`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=76;

--
-- AUTO_INCREMENT for table `unit`
--
ALTER TABLE `unit`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=47;

--
-- AUTO_INCREMENT for table `word_day`
--
ALTER TABLE `word_day`
  MODIFY `id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `publications`
--
ALTER TABLE `publications`
  ADD CONSTRAINT `publications_ibfk_1` FOREIGN KEY (`username`) REFERENCES `users` (`username`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Constraints for table `shelf`
--
ALTER TABLE `shelf`
  ADD CONSTRAINT `shelf_ibfk_1` FOREIGN KEY (`unit_number`) REFERENCES `unit` (`num`) ON DELETE RESTRICT ON UPDATE RESTRICT;

DELIMITER $$
--
-- Events
--
CREATE DEFINER=`root`@`localhost` EVENT `words_day` ON SCHEDULE EVERY 24 DAY STARTS '2023-10-13 12:00:00' ON COMPLETION NOT PRESERVE ENABLE DO BEGIN
UPDATE `word_day` SET `status` = '0';
UPDATE `word_day` SET `status` = '1' ORDER BY RAND() LIMIT 1;
END$$

DELIMITER ;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
