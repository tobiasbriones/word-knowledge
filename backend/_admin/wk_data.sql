-- phpMyAdmin SQL Dump
-- version 4.9.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3308
-- Generation Time: Apr 19, 2020 at 03:51 AM
-- Server version: 10.4.11-MariaDB
-- PHP Version: 7.2.26

SET SQL_MODE = no_auto_value_on_zero;
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @old_character_set_client = @@character_set_client */;
/*!40101 SET @old_character_set_results = @@character_set_results */;
/*!40101 SET @old_collation_connection = @@collation_connection */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `wk_data`
--

-- --------------------------------------------------------

--
-- Table structure for table `cat_1`
--

CREATE TABLE cat_1 (
  id          SMALLINT(5) UNSIGNED                NOT NULL,
  english     VARCHAR(50) COLLATE utf8_unicode_ci NOT NULL,
  spanish     VARCHAR(50) COLLATE utf8_unicode_ci NOT NULL,
  subcategory VARCHAR(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

--
-- Dumping data for table `cat_1`
--

INSERT INTO cat_1 (id, english, spanish, subcategory)
VALUES (1, 'fun', 'divertido', 'Adjectives'),
       (2, 'red', 'rojo', 'Adjectives'),
       (3, 'sad', 'triste', 'Adjectives'),
       (4, 'happy', 'feliz', 'Adjectives'),
       (5, 'entertaining', 'entretenido', 'Adjectives'),
       (6, 'blue', 'azul', 'Adjectives'),
       (7, 'many', 'muchos', 'Adjectives'),
       (8, 'few', 'pocos', 'Adjectives'),
       (9, 'big', 'grande', 'Adjectives'),
       (10, 'now', 'ahora', 'Adverbs'),
       (11, 'last', '??ltimo', 'Adverbs'),
       (12, 'today', 'hoy', 'Adverbs'),
       (13, 'quite', 'bastante', 'Adverbs'),
       (14, 'too', 'tambi??n', 'Adverbs'),
       (15, 'very', 'mucho', 'Adverbs'),
       (16, 'absolutely', 'absolutamente', 'Adverbs'),
       (17, 'every week', 'todas las semanas', 'Adverbs'),
       (18, 'so slowly', 'tan despacio', 'Adverbs'),
       (19, 'walk', 'caminar', 'Verbs'),
       (20, 'play', 'jugar', 'Verbs'),
       (21, 'stop', 'parar', 'Verbs'),
       (22, 'open', 'abrir', 'Verbs');

-- --------------------------------------------------------

--
-- Table structure for table `cat_2`
--

CREATE TABLE cat_2 (
  id          SMALLINT(5) UNSIGNED                NOT NULL,
  english     VARCHAR(50) COLLATE utf8_unicode_ci NOT NULL,
  spanish     VARCHAR(50) COLLATE utf8_unicode_ci NOT NULL,
  subcategory VARCHAR(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

--
-- Dumping data for table `cat_2`
--

INSERT INTO cat_2 (id, english, spanish, subcategory)
VALUES (1, 'juice', 'jugo', 'Beverages'),
       (2, 'beer', 'cerveza', 'Beverages'),
       (3, 'glass of wine', 'copa de vino', 'Beverages'),
       (4, 'champagne', 'champaña', 'Beverages'),
       (5, 'dry', 'seco', 'Beverages'),
       (6, 'eel', 'anguila', 'Fish & Seafood'),
       (7, 'tuna', 'atún', 'Fish & Seafood'),
       (8, 'cod', 'bacalao', 'Fish & Seafood'),
       (9, 'albacore tuna', 'bonito', 'Fish & Seafood'),
       (10, 'tin of tuna', 'lata de atún', 'Fish & Seafood'),
       (11, 'sardine can', 'lata de sardinas', 'Fish & Seafood'),
       (12, 'red snapper', 'pargo', 'Fish & Seafood'),
       (13, 'salmon', 'salmón', 'Fish & Seafood'),
       (14, 'trout', 'trucha', 'Fish & Seafood'),
       (15, 'clams', 'almejas', 'Fish & Seafood'),
       (16, 'cockles', 'berberechos', 'Fish & Seafood'),
       (17, 'squid', 'calamares', 'Fish & Seafood'),
       (18, 'shrimp', 'camarones', 'Fish & Seafood'),
       (19, 'crab', 'cangrejo de mar', 'Fish & Seafood'),
       (20, 'crawfish', 'cangrejo de río', 'Fish & Seafood'),
       (21, 'crab spider', 'centolla', 'Fish & Seafood'),
       (22, 'grilled shrimps', 'gambas a la plancha', 'Fish & Seafood'),
       (23, 'fried shrimps', 'gambas fritas', 'Fish & Seafood'),
       (24, 'shrimp scampi', 'langostinos fritos a la milanesa', 'Fish & Seafood'),
       (25, 'lobster', 'langosta', 'Fish & Seafood'),
       (26, 'almonds', 'almendras', 'Fruits'),
       (27, 'pineapple', 'piña', 'Fruits'),
       (28, 'banana', 'banana', 'Fruits'),
       (29, 'coconut', 'coco', 'Fruits'),
       (30, 'cherry', 'cereza', 'Fruits'),
       (31, 'plum', 'ciruela', 'Fruits'),
       (32, 'peach', 'melocotón', 'Fruits'),
       (33, 'raspberry', 'frambuesa', 'Fruits'),
       (34, 'strawberry', 'fresa', 'Fruits'),
       (35, 'fig', 'higo', 'Fruits'),
       (36, 'lemon', 'limón', 'Fruits'),
       (37, 'lime', 'lima', 'Fruits'),
       (38, 'tangerine', 'mandarina', 'Fruits'),
       (39, 'mango', 'mango', 'Fruits'),
       (40, 'apple', 'manzana', 'Fruits'),
       (41, 'low-calorie cooking', 'cocina bajas en calorias', 'Healthy & Unhealthy'),
       (42, 'vegetarian diet', 'dieta vegetariana', 'Healthy & Unhealthy'),
       (43, 'low-cholesterol meal', 'comida baja en colesterol', 'Healthy & Unhealthy'),
       (44, 'low-sodium meal', 'comida con poca sal', 'Healthy & Unhealthy'),
       (45, 'fat-free desserts', 'postres sin grasa', 'Healthy & Unhealthy'),
       (46, 'oil', 'aceite', 'Meats & Seasoning'),
       (47, 'pig', 'marrano', 'Meats & Seasoning'),
       (48, 'pork', 'carne de cerdo', 'Meats & Seasoning'),
       (49, 'consommé', 'consomé', 'Meats & Seasoning'),
       (50, 'salad dressing', 'aderezo', 'Meats & Seasoning'),
       (51, 'vinegar', 'vinagre', 'Meats & Seasoning'),
       (52, 'mustard', 'mostaza', 'Meats & Seasoning'),
       (53, 'pepper', 'pimienta', 'Meats & Seasoning'),
       (54, 'salt', 'sal', 'Meats & Seasoning'),
       (55, 'tomato sauce', 'salsa de tomate', 'Meats & Seasoning'),
       (56, 'spaghetti', 'espagueti', 'Pasta'),
       (57, 'vermicelli', 'fideos', 'Pasta'),
       (58, 'lasagna', 'lasaña', 'Pasta'),
       (59, 'macaroni', 'macarrones', 'Pasta'),
       (60, 'noodles', 'tallarines', 'Pasta'),
       (61, 'rice', 'arroz', 'Soups'),
       (62, 'chicken broth', 'caldo de pollo', 'Soups'),
       (63, 'vegetable broth', 'caldo de verduras', 'Soups'),
       (64, 'croutons', 'crutones', 'Soups'),
       (65, 'fish broth', 'caldo de pescado', 'Soups'),
       (66, 'pudding', 'budín', 'Sweets & Desserts'),
       (67, 'whipped cream', 'crema batida', 'Sweets & Desserts'),
       (68, 'custard', 'crema pastelera', 'Sweets & Desserts'),
       (69, 'ice cream', 'helados', 'Sweets & Desserts'),
       (70, 'assorted pastries', 'dulces variados', 'Sweets & Desserts');

-- --------------------------------------------------------

--
-- Table structure for table `cat_3`
--

CREATE TABLE cat_3 (
  id          SMALLINT(5) UNSIGNED                NOT NULL,
  english     VARCHAR(50) COLLATE utf8_unicode_ci NOT NULL,
  spanish     VARCHAR(50) COLLATE utf8_unicode_ci NOT NULL,
  subcategory VARCHAR(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

--
-- Dumping data for table `cat_3`
--

INSERT INTO cat_3 (id, english, spanish, subcategory)
VALUES (1, 'allergy', 'alergia', 'Health problems'),
       (2, 'anemia', 'anemia', 'Health problems'),
       (3, 'asthma', 'asma', 'Health problems'),
       (4, 'heart attack', 'ataque cardiaco', 'Health problems'),
       (5, 'cut', 'cortada', 'Health problems'),
       (6, 'contagion', 'contagio', 'Health problems'),
       (7, 'depression', 'depresión', 'Health problems'),
       (8, 'diarreah', 'diarrea', 'Health problems'),
       (9, 'headache', 'dolor de cabeza', 'Health problems'),
       (10, 'toothache', 'dolor de diente', 'Health problems'),
       (11, 'backache', 'dolor de espalda', 'Health problems'),
       (12, 'stomachache', 'dolor de estómago', 'Health problems'),
       (13, 'earache', 'dolor de oído', 'Health problems'),
       (14, 'stress', 'estrés', 'Health problems'),
       (15, 'fever', 'fiebre', 'Health problems'),
       (16, 'flu', 'gripe', 'Health problems'),
       (17, 'hiccups', 'hipo', 'Health problems'),
       (18, 'itch', 'picazón', 'Health problems'),
       (19, 'cold', 'resfriado', 'Health problems'),
       (20, 'cough', 'tos', 'Health problems');

-- --------------------------------------------------------

--
-- Table structure for table `cat_4`
--

CREATE TABLE cat_4 (
  id          SMALLINT(5) UNSIGNED                NOT NULL,
  english     VARCHAR(50) COLLATE utf8_unicode_ci NOT NULL,
  spanish     VARCHAR(50) COLLATE utf8_unicode_ci NOT NULL,
  subcategory VARCHAR(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

--
-- Dumping data for table `cat_4`
--

INSERT INTO cat_4 (id, english, spanish, subcategory)
VALUES (1, 'cat', 'gato', 'Fauna'),
       (2, 'dog', 'perro', 'Fauna'),
       (3, 'puppy', 'perrito', 'Fauna'),
       (4, 'spider', 'araña', 'Fauna'),
       (5, 'cow', 'vaca', 'Fauna'),
       (6, 'bark', 'corteza', 'Flora'),
       (7, 'trunk', 'tronco', 'Flora'),
       (8, 'leaf', 'hoja', 'Flora'),
       (9, 'leaves', 'hojas', 'Flora'),
       (10, 'branch', 'rama', 'Flora'),
       (11, 'roots', 'raíces', 'Flora'),
       (12, 'twig', 'ramita', 'Flora'),
       (13, 'maple', 'arce', 'Flora'),
       (14, 'cactus', 'cactus', 'Flora'),
       (15, 'cedar', 'cedro', 'Flora'),
       (16, 'cypress', 'ciprés', 'Flora'),
       (17, 'weed', 'maleza', 'Flora'),
       (18, 'walnut tree', 'nogal', 'Flora'),
       (19, 'palm tree', 'palmera', 'Flora'),
       (20, 'pine', 'pino', 'Flora'),
       (21, 'oak', 'roble', 'Flora'),
       (22, 'hurricane', 'huracán', 'Natural phenomena'),
       (23, 'rain', 'lluvia', 'Natural phenomena'),
       (24, 'earthquake', 'terremoto', 'Natural phenomena'),
       (25, 'tornado', 'tornado', 'Natural phenomena'),
       (26, 'rainbow', 'arco iris', 'Natural phenomena'),
       (27, 'planet', 'planeta', 'The universe'),
       (28, 'asteroid', 'asteroide', 'The universe'),
       (29, 'star', 'estrella', 'The universe'),
       (30, 'galaxy', 'galaxia', 'The universe'),
       (31, 'black hole', 'agujero negro', 'The universe'),
       (32, 'sunny', 'soleado', 'The weather & Seasons'),
       (33, 'windy', 'ventoso', 'The weather & Seasons'),
       (34, 'cloudy', 'nublado', 'The weather & Seasons'),
       (35, 'summer', 'verando', 'The weather & Seasons'),
       (36, 'windy', 'invierno', 'The weather & Seasons');

-- --------------------------------------------------------

--
-- Table structure for table `cat_5`
--

CREATE TABLE cat_5 (
  id          SMALLINT(5) UNSIGNED                NOT NULL,
  english     VARCHAR(50) COLLATE utf8_unicode_ci NOT NULL,
  spanish     VARCHAR(50) COLLATE utf8_unicode_ci NOT NULL,
  subcategory VARCHAR(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

--
-- Dumping data for table `cat_5`
--

INSERT INTO cat_5 (id, english, spanish, subcategory)
VALUES (1, 'cover', 'portada', 'The book'),
       (2, 'battery', 'bater??a', 'The cell phone'),
       (3, 'keyboard', 'teclado', 'The computer'),
       (4, 'mouse', 'rat??n', 'The computer'),
       (5, 'hard drive', 'disco duro', 'The computer');

-- --------------------------------------------------------

--
-- Table structure for table `cat_6`
--

CREATE TABLE cat_6 (
  id          SMALLINT(5) UNSIGNED                NOT NULL,
  english     VARCHAR(50) COLLATE utf8_unicode_ci NOT NULL,
  spanish     VARCHAR(50) COLLATE utf8_unicode_ci NOT NULL,
  subcategory VARCHAR(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

--
-- Dumping data for table `cat_6`
--

INSERT INTO cat_6 (id, english, spanish, subcategory)
VALUES (1, 'head', 'cabeza', 'Body parts'),
       (2, 'back', 'espalda', 'Body parts'),
       (3, 'eyes', 'ojos', 'Body parts'),
       (4, 'hands', 'manos', 'Body parts'),
       (5, 'arms', 'brazos', 'Body parts'),
       (6, 'legs', 'piernas', 'Body parts'),
       (7, 'feet', 'piernas', 'Body parts'),
       (8, 'fingernails', 'uñas de la mano', 'Body parts'),
       (9, 'toenails', 'uñas de los pies', 'Body parts'),
       (10, 'hair', 'pelo', 'Body parts'),
       (11, 'sweep', 'barrer', 'Chores'),
       (12, 'mop', 'trapiar', 'Chores'),
       (13, 'vacuum', 'aspirar', 'Chores'),
       (14, 'take out the trash', 'sacar la basura', 'Chores'),
       (15, 'clean up', 'limpiar', 'Chores'),
       (16, 'coat', 'abrigo', 'Clothing'),
       (17, 'hat', 'sombrero', 'Clothing'),
       (18, 'boots', 'botas', 'Clothing'),
       (19, 'shirt', 'camisa', 'Clothing'),
       (20, 'socks', 'calcetines', 'Clothing'),
       (21, 'gown', 'bata', 'Clothing'),
       (22, 'blouse', 'blusa', 'Clothing'),
       (23, 'bag', 'bolso', 'Clothing'),
       (24, 'pants', 'pantalones', 'Clothing'),
       (25, 'panty hose', 'medias', 'Clothing'),
       (26, 'son', 'hijo', 'Family & Relatives'),
       (27, 'daughter', 'hija', 'Family & Relatives'),
       (28, 'father', 'padre', 'Family & Relatives'),
       (29, 'mother', 'madre', 'Family & Relatives'),
       (30, 'grandparents', 'abuelos', 'Family & Relatives'),
       (31, 'sad', 'triste', 'Moods'),
       (32, 'happy', 'feliz', 'Moods'),
       (33, 'angry', 'enojado', 'Moods'),
       (34, 'happiness', 'felicidad', 'Moods'),
       (35, 'sadness', 'tristeza', 'Moods'),
       (36, 'midget / dwarf', 'enano', 'Physical defects'),
       (37, 'giant', 'gigante', 'Physical defects'),
       (38, 'handicapped', 'discapacitado', 'Physical defects'),
       (39, 'one-handed', 'manco', 'Physical defects'),
       (40, 'dumb', 'mudo', 'Physical defects'),
       (41, 'deaf', 'sordo', 'Physical defects'),
       (42, 'deaf-mute', 'sordomudo', 'Physical defects'),
       (43, 'stammerer', 'tartamudo', 'Physical defects'),
       (44, 'one-eyed', 'tuerto', 'Physical defects'),
       (45, 'left-handed', 'zurdo', 'Physical defects'),
       (46, 'lawyer', 'abogado', 'Professions'),
       (47, 'actor', 'actor', 'Professions'),
       (48, 'actress', 'actriz', 'Professions'),
       (49, 'police officer', 'oficial de policía', 'Professions'),
       (50, 'grocer', 'almacenero', 'Professions'),
       (51, 'archaeologist', 'arqueólogo', 'Professions'),
       (52, 'architect', 'arquitecto', 'Professions'),
       (53, 'astronaut', 'astronauta', 'Professions'),
       (54, 'athlete', 'atleta', 'Professions'),
       (55, 'flight attendant', 'azafata', 'Professions'),
       (56, 'bartender', 'cantinero', 'Professions'),
       (57, 'fire fighter', 'bombero', 'Professions'),
       (58, 'cameraman', 'camarógrafo', 'Professions'),
       (59, 'singer', 'cantante', 'Professions'),
       (60, 'butcher', 'carnicero', 'Professions'),
       (61, 'carpenter', 'carpintero', 'Professions'),
       (62, 'scientist', 'científico', 'Professions'),
       (63, 'chef', 'cocinero', 'Professions'),
       (64, 'accountant', 'contador', 'Professions'),
       (65, 'dentist', 'dentista', 'Professions'),
       (66, 'trendy', 'de moda', 'The look'),
       (67, 'well dressed', 'bien vestido', 'The look'),
       (68, 'classic elegance', 'elegancia clásica', 'The look'),
       (69, 'careless / sloppy', 'descuidado', 'The look'),
       (70, 'messy', 'desordenado', 'The look'),
       (71, 'elegant stylish', 'elegante', 'The look'),
       (72, 'formal', 'formal', 'The look'),
       (73, 'informal', 'informal', 'The look'),
       (74, 'old-fashioned', 'a la antigua', 'The look'),
       (75, 'casual', 'casual', 'The look'),
       (76, 'modestly', 'modestamente', 'The look');

-- --------------------------------------------------------

--
-- Table structure for table `cat_7`
--

CREATE TABLE cat_7 (
  id          SMALLINT(5) UNSIGNED                NOT NULL,
  english     VARCHAR(50) COLLATE utf8_unicode_ci NOT NULL,
  spanish     VARCHAR(50) COLLATE utf8_unicode_ci NOT NULL,
  subcategory VARCHAR(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

--
-- Dumping data for table `cat_7`
--

INSERT INTO cat_7 (id, english, spanish, subcategory)
VALUES (1, 'garden', 'jardín', 'At home'),
       (2, 'carpet', 'alfombra', 'At home'),
       (3, 'closet', 'ropero', 'At home'),
       (4, 'balcony', 'balcón', 'At home'),
       (5, 'terrace', 'terraza', 'At home'),
       (6, 'rug', 'alfombra', 'At home'),
       (7, 'bedroom', 'dormitorio', 'At home'),
       (8, 'living room', 'sala', 'At home'),
       (9, 'bathroom', 'baño', 'At home'),
       (10, 'socket', 'tomacorriente', 'At home'),
       (11, 'staircase', 'escalera', 'At home'),
       (12, 'lamp', 'lámpara', 'At home'),
       (13, 'door', 'puerta', 'At home'),
       (14, 'couch', 'sofá', 'At home'),
       (15, 'stove', 'estufa', 'At home'),
       (16, 'airplane', 'avión', 'At the airport'),
       (17, 'flight', 'vuelo', 'At the airport'),
       (18, 'round trip', 'ida y vuelta', 'At the airport'),
       (19, 'customs', 'aduana', 'At the airport'),
       (20, 'coach class', 'clase turista', 'At the airport'),
       (21, 'first class', 'primera clase', 'At the airport'),
       (22, 'layover', 'parada', 'At the airport'),
       (23, 'luggage / baggage', 'equipaje', 'At the airport'),
       (24, 'credit card', 'tarjeta de crédito', 'At the bank'),
       (25, 'cash', 'efectivo', 'At the bank'),
       (26, 'currency', 'moneda', 'At the bank'),
       (27, 'loan', 'préstamo', 'At the bank'),
       (28, 'bank account', 'cuenta bancaria', 'At the bank'),
       (29, 'counter', 'mostrador', 'At the bar'),
       (30, 'appetizer', 'aperitivo', 'At the bar'),
       (31, 'snacks', 'bocadillos', 'At the bar'),
       (32, 'refreshments', 'refrescos', 'At the bar'),
       (33, 'pop', 'sodas', 'At the bar'),
       (34, 'spirits', 'licores', 'At the bar'),
       (35, 'rum', 'ron', 'At the bar'),
       (36, 'wine glass', 'copa', 'At the bar'),
       (37, 'liqueur glass', 'copita', 'At the bar'),
       (38, 'ice', 'hielo', 'At the bar'),
       (39, 'draught beer', 'cerveza de barril', 'At the bar'),
       (40, 'cocktail', 'cóctel', 'At the bar'),
       (41, 'black coffee', 'café negro', 'At the bar'),
       (42, 'coffee with cream', 'café con leche', 'At the bar'),
       (43, 'restroom', 'baño', 'At the bar'),
       (44, 'hairdresser', 'peluquera', 'At the beauty salon'),
       (45, 'chair', 'sillón', 'At the beauty salon'),
       (46, 'towel', 'toalla', 'At the beauty salon'),
       (47, 'mirror', 'espejo', 'At the beauty salon'),
       (48, 'comb', 'peine', 'At the beauty salon'),
       (49, 'hair dryer', 'secador de cabello', 'At the beauty salon'),
       (50, 'scissors', 'tijeras', 'At the beauty salon'),
       (51, 'hair brush', 'cepillo', 'At the beauty salon'),
       (52, 'razor', 'navaja', 'At the beauty salon'),
       (53, 'soap', 'jabón', 'At the beauty salon'),
       (54, 'hair clipper', 'máquina de cortar el cabello', 'At the beauty salon'),
       (55, 'braid', 'trenza', 'At the beauty salon'),
       (56, 'wig', 'peluca', 'At the beauty salon'),
       (57, 'hairlock', 'rizo', 'At the beauty salon'),
       (58, 'frinze', 'flequillo', 'At the beauty salon'),
       (59, 'wave', 'onda', 'At the beauty salon'),
       (60, 'permanent', 'permanente', 'At the beauty salon'),
       (61, 'to dye your hair blond', 'teñirse de rubio', 'At the beauty salon'),
       (62, 'blond', 'rubio', 'At the beauty salon'),
       (63, 'blonde', 'rubia', 'At the beauty salon'),
       (64, 'bookstall', 'librero', 'At the bookstore'),
       (65, 'pen', 'bolígrafo', 'At the bookstore'),
       (66, 'eraser', 'goma de borrar', 'At the bookstore'),
       (67, 'pencil', 'lápiz', 'At the bookstore'),
       (68, 'marker', 'marcador', 'At the bookstore'),
       (69, 'notebook', 'cuaderno', 'At the bookstore'),
       (70, 'dictionary', 'diccionario', 'At the bookstore'),
       (71, 'edition', 'edición', 'At the bookstore'),
       (72, 'author', 'autor', 'At the bookstore'),
       (73, 'taxi', 'taxi', 'At the downtown'),
       (74, 'garbage collector', 'recolector de basura', 'At the downtown'),
       (75, 'buildings', 'edificios', 'At the downtown'),
       (76, 'gas station', 'gasolineria', 'At the downtown'),
       (77, 'bus station', 'estación de buses', 'At the downtown'),
       (78, 'cotton', 'algodón', 'At the drugstore'),
       (79, 'antibiotic', 'antibiótico', 'At the drugstore'),
       (80, 'first-aid kit', 'botiquín de primeros auxilios', 'At the drugstore'),
       (81, 'disinfectant', 'desinfectante', 'At the drugstore'),
       (82, 'dose', 'dosis', 'At the drugstore'),
       (83, 'sit-ups', 'abdominales', 'At the gym'),
       (84, 'aerobic exercise', 'ejercicio aeróbico', 'At the gym'),
       (85, 'regular exercise', 'ejercicio periódico', 'At the gym'),
       (86, 'to stretch', 'estirar', 'At the gym'),
       (87, 'to be in shape', 'estar en forma', 'At the gym'),
       (88, 'to bend', 'flexionar', 'At the gym'),
       (89, 'strength', 'fuerza', 'At the gym'),
       (90, 'to work out', 'hacer gymnasia', 'At the gym'),
       (91, 'to lift weights', 'levantar pesas', 'At the gym'),
       (92, 'sweat', 'sudor', 'At the gym'),
       (93, 'drill', 'taladro', 'At the hardware store'),
       (94, 'paint brush', 'brocha', 'At the hardware store'),
       (95, 'bolt', 'tuerca', 'At the hardware store'),
       (96, 'wire', 'cable', 'At the hardware store'),
       (97, 'tool box', 'caja de herramientas', 'At the hardware store'),
       (98, 'reservation', 'reserva', 'At the hotel'),
       (99, 'reception', 'recepción', 'At the hotel'),
       (100, 'vacancies', 'habitaciones libres', 'At the hotel'),
       (101, 'no vacancy', 'completo', 'At the hotel'),
       (102, 'lobby', 'vestíbulo', 'At the hotel'),
       (103, 'store', 'tienda', 'At the mall'),
       (104, 'cinema', 'cine', 'At the mall'),
       (105, 'building', 'edificio', 'At the mall'),
       (106, 'go shopping', 'ir de compras', 'At the mall'),
       (107, 'elevator', 'ascensor', 'At the mall'),
       (108, 'chef', 'cocinero', 'At the restaurant'),
       (109, 'waiter', 'camarero', 'At the restaurant'),
       (110, 'waitress', 'camarera', 'At the restaurant'),
       (111, 'kitchen', 'cocina', 'At the restaurant'),
       (112, 'table', 'mesa', 'At the restaurant'),
       (113, 'order', 'orden', 'At the restaurant'),
       (114, 'teacher', 'maestro', 'At the school'),
       (115, 'classroom', 'aula', 'At the school'),
       (116, 'classmate', 'compañero', 'At the school'),
       (117, 'homework', 'tarea', 'At the school'),
       (118, 'presentation', 'presentación', 'At the school');

-- --------------------------------------------------------

--
-- Table structure for table `cat_8`
--

CREATE TABLE cat_8 (
  id          SMALLINT(5) UNSIGNED                NOT NULL,
  english     VARCHAR(50) COLLATE utf8_unicode_ci NOT NULL,
  spanish     VARCHAR(50) COLLATE utf8_unicode_ci NOT NULL,
  subcategory VARCHAR(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

--
-- Dumping data for table `cat_8`
--

INSERT INTO cat_8 (id, english, spanish, subcategory)
VALUES (1, 'food processor', 'procesador de comida', 'Appliances'),
       (2, 'pressure cooker', 'olla de presión', 'Appliances'),
       (3, 'blender', 'licuadora', 'Appliances'),
       (4, 'fan', 'ventilador', 'Appliances'),
       (5, 'dishwasher', 'lavavajillas', 'Appliances'),
       (6, 'spray', 'atomizador', 'Containers'),
       (7, 'bar', 'barra', 'Containers'),
       (8, 'bag', 'bolsa', 'Containers'),
       (9, 'sack', 'saco', 'Containers'),
       (10, 'bottle', 'botella', 'Containers'),
       (11, 'box', 'caja', 'Containers'),
       (12, 'carton', 'cartón', 'Containers'),
       (13, 'can', 'lata', 'Containers'),
       (14, 'package', 'paquete', 'Containers'),
       (15, 'six-pack', 'paquete de seis', 'Containers'),
       (16, 'computer', 'computadora', 'Electronic'),
       (17, 'speakers', 'parlantes', 'Electronic'),
       (18, 'hard drive', 'disco duro', 'Electronic'),
       (19, 'headphones', 'audifonos', 'Electronic'),
       (20, 'video card', 'tarjeta de video', 'Electronic'),
       (21, 'acetate', 'acetato', 'Materials'),
       (22, 'cotton', 'algodón', 'Materials'),
       (23, 'leather', 'cuero', 'Materials'),
       (24, 'acrilic fiber', 'fibra acrílica', 'Materials'),
       (25, 'suede', 'gamuza', 'Materials'),
       (26, 'gauze', 'gasa', 'Materials'),
       (27, 'wool', 'lana', 'Materials'),
       (28, 'nylon', 'nylon', 'Materials'),
       (29, 'polyester', 'poliéster', 'Materials'),
       (30, 'printed silk', 'seda estampada', 'Materials'),
       (31, 'natural silk', 'seda natural', 'Materials'),
       (32, 'accordion', 'acordeón', 'Music'),
       (33, 'harp', 'arpa', 'Music'),
       (34, 'drums', 'batería', 'Music'),
       (35, 'clarinet', 'clarinete', 'Music'),
       (36, 'bass', 'contrabajo', 'Music'),
       (37, 'bassoon', 'fagot', 'Music'),
       (38, 'flute', 'flauta', 'Music'),
       (39, 'guitar', 'guitarra', 'Music'),
       (40, 'oboe', 'oboe', 'Music'),
       (41, 'saxophone', 'saxofón', 'Music'),
       (42, 'kettle drums', 'timbales', 'Music'),
       (43, 'trumpet', 'trompeta', 'Music'),
       (44, 'violin', 'violín', 'Music'),
       (45, 'cello', 'violoncelo', 'Music'),
       (46, 'vibraphone', 'vibráfono', 'Music');

-- --------------------------------------------------------

--
-- Table structure for table `cat_9`
--

CREATE TABLE cat_9 (
  id          SMALLINT(5) UNSIGNED                NOT NULL,
  english     VARCHAR(50) COLLATE utf8_unicode_ci NOT NULL,
  spanish     VARCHAR(50) COLLATE utf8_unicode_ci NOT NULL,
  subcategory VARCHAR(30) COLLATE utf8_unicode_ci NOT NULL
) ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

--
-- Dumping data for table `cat_9`
--

INSERT INTO cat_9 (id, english, spanish, subcategory)
VALUES (1, 'wire', 'alambre', 'Electricity & Electronic'),
       (2, 'multimeter', 'multímetro', 'Electricity & Electronic'),
       (3, 'welding', 'soldadura', 'Electricity & Electronic'),
       (4, 'current', 'corriente', 'Electricity & Electronic'),
       (5, 'voltage', 'voltaje', 'Electricity & Electronic'),
       (6, 'tax', 'impuesto', 'Business & Sales'),
       (7, 'payment', 'pago', 'Business & Sales'),
       (8, 'resistor', 'resistencia', 'Electricity & Electronic'),
       (9, 'equation', 'ecuaci??n', 'Math & Physics'),
       (10, 'theorem', 'teorema', 'Math & Physics'),
       (11, 'vaccine', 'vacuna', 'Science');

-- --------------------------------------------------------

--
-- Table structure for table `reg`
--

CREATE TABLE reg (
  id            TINYINT(3) UNSIGNED                  NOT NULL,
  name          VARCHAR(30) COLLATE utf8_unicode_ci  NOT NULL,
  subcategories VARCHAR(300) COLLATE utf8_unicode_ci NOT NULL
) ENGINE = MyISAM
  DEFAULT CHARSET = utf8
  COLLATE = utf8_unicode_ci;

--
-- Dumping data for table `reg`
--

INSERT INTO reg (id, name, subcategories)
VALUES (1,
        'About grammar',
        '[\"Adjectives\",\"Adverbs\",\"Irregular verbs (Participle)\",\"Irregular verbs (Past)\",\"Verbs\"]'),
       (2,
        'Foods & Meals',
        '[\"Beverages\",\"Dairy products\",\"Fish & Seafood\",\"Fruits\",\"Healthy & Unhealthy\",\"Herbs\",\"Meats & Seasoning\",\"Pasta\",\"Soups\",\"Sweets & Desserts\",\"Vegetables\"]'),
       (3,
        'Miscellaneous',
        '[\"Cardinal numbers\",\"Colors\",\"Health problems\",\"Not rated\",\"Ordinal numbers\",\"Transportation\"]'),
       (4,
        'Nature',
        '[\"Fauna\",\"Flora\",\"Habitats\",\"Natural phenomena\",\"The universe\",\"The weather & Seasons\"]'),
       (5,
        'Parts of things',
        '[\"The bicycle\",\"The book\",\"The car\",\"The cell phone\",\"The computer\",\"The ship\"]'),
       (6,
        'People',
        '[\"Activities\",\"Body parts\",\"Chores\",\"Clothing\",\"Family & Relatives\",\"Moods\",\"Physical defects\",\"Politics\",\"Professions\",\"Society\",\"The look\"]'),
       (7,
        'Places',
        '[\"At home\",\"At the airport\",\"At the bank\",\"At the bar\",\"At the beach\",\"At the beauty salon\",\"At the bookstore\",\"At the downtown\",\"At the drugstore\",\"At the gym\",\"At the hardware store\",\"At the hotel\",\"At the mall\",\"At the restaurant\",\"At the school\",\"At the supermarket\",\"At the workplace\"]'),
       (8,
        'Products & Things',
        '[\"Appliances\",\"Containers\",\"Electronic\",\"Everyday products\",\"Furniture\",\"Materials\",\"Music\"]'),
       (9,
        'Technicalities & Tools',
        '[\"Business & Sales\",\"Electricity & Electronic\",\"Farm machinery\",\"Law\",\"Math & Physics\",\"Mechanics\",\"Science\"]');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `cat_1`
--
ALTER TABLE cat_1
  ADD PRIMARY KEY (id);
ALTER TABLE cat_1
  ADD FULLTEXT KEY english (english, spanish);

--
-- Indexes for table `cat_2`
--
ALTER TABLE cat_2
  ADD PRIMARY KEY (id);
ALTER TABLE cat_2
  ADD FULLTEXT KEY english (english, spanish);

--
-- Indexes for table `cat_3`
--
ALTER TABLE cat_3
  ADD PRIMARY KEY (id);
ALTER TABLE cat_3
  ADD FULLTEXT KEY english (english, spanish);

--
-- Indexes for table `cat_4`
--
ALTER TABLE cat_4
  ADD PRIMARY KEY (id);
ALTER TABLE cat_4
  ADD FULLTEXT KEY english (english, spanish);

--
-- Indexes for table `cat_5`
--
ALTER TABLE cat_5
  ADD PRIMARY KEY (id);
ALTER TABLE cat_5
  ADD FULLTEXT KEY english (english, spanish);

--
-- Indexes for table `cat_6`
--
ALTER TABLE cat_6
  ADD PRIMARY KEY (id);
ALTER TABLE cat_6
  ADD FULLTEXT KEY english (english, spanish);

--
-- Indexes for table `cat_7`
--
ALTER TABLE cat_7
  ADD PRIMARY KEY (id);
ALTER TABLE cat_7
  ADD FULLTEXT KEY english (english, spanish);

--
-- Indexes for table `cat_8`
--
ALTER TABLE cat_8
  ADD PRIMARY KEY (id);
ALTER TABLE cat_8
  ADD FULLTEXT KEY english (english, spanish);

--
-- Indexes for table `cat_9`
--
ALTER TABLE cat_9
  ADD PRIMARY KEY (id);
ALTER TABLE cat_9
  ADD FULLTEXT KEY english (english, spanish);

--
-- Indexes for table `reg`
--
ALTER TABLE reg
  ADD PRIMARY KEY (id);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `cat_1`
--
ALTER TABLE cat_1
  MODIFY id SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 23;

--
-- AUTO_INCREMENT for table `cat_2`
--
ALTER TABLE cat_2
  MODIFY id SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 71;

--
-- AUTO_INCREMENT for table `cat_3`
--
ALTER TABLE cat_3
  MODIFY id SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 21;

--
-- AUTO_INCREMENT for table `cat_4`
--
ALTER TABLE cat_4
  MODIFY id SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 37;

--
-- AUTO_INCREMENT for table `cat_5`
--
ALTER TABLE cat_5
  MODIFY id SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 6;

--
-- AUTO_INCREMENT for table `cat_6`
--
ALTER TABLE cat_6
  MODIFY id SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 77;

--
-- AUTO_INCREMENT for table `cat_7`
--
ALTER TABLE cat_7
  MODIFY id SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 119;

--
-- AUTO_INCREMENT for table `cat_8`
--
ALTER TABLE cat_8
  MODIFY id SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 47;

--
-- AUTO_INCREMENT for table `cat_9`
--
ALTER TABLE cat_9
  MODIFY id SMALLINT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 12;

--
-- AUTO_INCREMENT for table `reg`
--
ALTER TABLE reg
  MODIFY id TINYINT(3) UNSIGNED NOT NULL AUTO_INCREMENT,
  AUTO_INCREMENT = 10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT = @old_character_set_client */;
/*!40101 SET CHARACTER_SET_RESULTS = @old_character_set_results */;
/*!40101 SET COLLATION_CONNECTION = @old_collation_connection */;
