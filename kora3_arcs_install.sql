-- MySQL dump 10.13  Distrib 5.7.29, for Linux (x86_64)
--
-- Host: localhost    Database: kora
-- ------------------------------------------------------
-- Server version       5.7.29-0ubuntu0.18.04.1

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `kora_associations`
--

DROP TABLE IF EXISTS `kora_associations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kora_associations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `data_form` int(10) unsigned NOT NULL,
  `assoc_form` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `associations_data_form_foreign` (`data_form`),
  KEY `associations_assoc_form_foreign` (`assoc_form`),
  CONSTRAINT `associations_assoc_form_foreign` FOREIGN KEY (`assoc_form`) REFERENCES `kora_forms` (`id`) ON DELETE CASCADE,
  CONSTRAINT `associations_data_form_foreign` FOREIGN KEY (`data_form`) REFERENCES `kora_forms` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kora_associations`
--

LOCK TABLES `kora_associations` WRITE;
/*!40000 ALTER TABLE `kora_associations` DISABLE KEYS */;
/*!40000 ALTER TABLE `kora_associations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kora_dashboard_blocks`
--

DROP TABLE IF EXISTS `kora_dashboard_blocks`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kora_dashboard_blocks` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `section_id` int(10) unsigned NOT NULL,
  `type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `order` int(10) unsigned NOT NULL,
  `options` text COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `dashboard_blocks_section_id_foreign` (`section_id`),
  CONSTRAINT `dashboard_blocks_section_id_foreign` FOREIGN KEY (`section_id`) REFERENCES `kora_dashboard_sections` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kora_dashboard_blocks`
--

LOCK TABLES `kora_dashboard_blocks` WRITE;
/*!40000 ALTER TABLE `kora_dashboard_blocks` DISABLE KEYS */;
/*!40000 ALTER TABLE `kora_dashboard_blocks` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kora_dashboard_sections`
--

DROP TABLE IF EXISTS `kora_dashboard_sections`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kora_dashboard_sections` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `order` int(10) unsigned NOT NULL,
  `title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `dashboard_sections_user_id_foreign` (`user_id`),
  CONSTRAINT `dashboard_sections_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `kora_users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kora_dashboard_sections`
--

LOCK TABLES `kora_dashboard_sections` WRITE;
/*!40000 ALTER TABLE `kora_dashboard_sections` DISABLE KEYS */;
/*!40000 ALTER TABLE `kora_dashboard_sections` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kora_exodus_overall`
--

DROP TABLE IF EXISTS `kora_exodus_overall`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kora_exodus_overall` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `progress` int(10) unsigned NOT NULL,
  `total_forms` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kora_exodus_overall`
--

LOCK TABLES `kora_exodus_overall` WRITE;
/*!40000 ALTER TABLE `kora_exodus_overall` DISABLE KEYS */;
/*!40000 ALTER TABLE `kora_exodus_overall` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kora_exodus_partial`
--

DROP TABLE IF EXISTS `kora_exodus_partial`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kora_exodus_partial` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `progress` int(10) unsigned NOT NULL,
  `total_records` int(10) unsigned NOT NULL,
  `exodus_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `exodus_partial_exodus_id_foreign` (`exodus_id`),
  CONSTRAINT `exodus_partial_exodus_id_foreign` FOREIGN KEY (`exodus_id`) REFERENCES `kora_exodus_overall` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kora_exodus_partial`
--

LOCK TABLES `kora_exodus_partial` WRITE;
/*!40000 ALTER TABLE `kora_exodus_partial` DISABLE KEYS */;
/*!40000 ALTER TABLE `kora_exodus_partial` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kora_failed_jobs`
--

DROP TABLE IF EXISTS `kora_failed_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kora_failed_jobs` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `connection` text COLLATE utf8_unicode_ci NOT NULL,
  `queue` text COLLATE utf8_unicode_ci NOT NULL,
  `payload` text COLLATE utf8_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kora_failed_jobs`
--

LOCK TABLES `kora_failed_jobs` WRITE;
/*!40000 ALTER TABLE `kora_failed_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `kora_failed_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kora_failed_records`
--

DROP TABLE IF EXISTS `kora_failed_records`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kora_failed_records` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `reference_id` int(11) NOT NULL,
  `form_id` int(10) unsigned NOT NULL,
  `error_text` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `record` json NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `failed_records_user_id_index` (`user_id`),
  CONSTRAINT `failed_records_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `kora_users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kora_failed_records`
--

LOCK TABLES `kora_failed_records` WRITE;
/*!40000 ALTER TABLE `kora_failed_records` DISABLE KEYS */;
/*!40000 ALTER TABLE `kora_failed_records` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kora_field_value_presets`
--

DROP TABLE IF EXISTS `kora_field_value_presets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kora_field_value_presets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(10) unsigned DEFAULT NULL,
  `shared` tinyint(1) NOT NULL,
  `preset` json NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `field_value_presets_project_id_foreign` (`project_id`),
  CONSTRAINT `field_value_presets_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `kora_projects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kora_field_value_presets`
--

LOCK TABLES `kora_field_value_presets` WRITE;
/*!40000 ALTER TABLE `kora_field_value_presets` DISABLE KEYS */;
INSERT INTO `kora_field_value_presets` VALUES (1,NULL,0,'{\"name\": \"URL_URI\", \"type\": \"Regex\", \"preset\": \"/^(http|ftp|https):\\\\/\\\\//\"}','2020-03-26 13:18:22','2020-03-26 13:18:22'),(2,NULL,0,'{\"name\": \"Boolean\", \"type\": \"List\", \"preset\": [\"True\", \"False\"]}','2020-03-26 13:18:22','2020-03-26 13:18:22'),(3,NULL,0,'{\"name\": \"Countries\", \"type\": \"List\", \"preset\": [\"United States\", \"United Nations\", \"Canada\", \"Mexico\", \"Afghanistan\", \"Albania\", \"Algeria\", \"American Samoa\", \"Andorra\", \"Angola\", \"Anguilla\", \"Antarctica\", \"Antigua and Barbuda\", \"Argentina\", \"Armenia\", \"Aruba\", \"Australia\", \"Austria\", \"Azerbaijan\", \"Bahamas\", \"Bahrain\", \"Bangladesh\", \"Barbados\", \"Belarus\", \"Belgium\", \"Belize\", \"Benin\", \"Bermuda\", \"Bhutan\", \"Bolivia\", \"Bosnia and Herzegowina\", \"Botswana\", \"Bouvet Island\", \"Brazil\", \"British Indian Ocean Terr.\", \"Brunei Darussalam\", \"Bulgaria\", \"Burkina Faso\", \"Burundi\", \"Cambodia\", \"Cameroon\", \"Cape Verde\", \"Cayman Islands\", \"Central African Republic\", \"Chad\", \"Chile\", \"China\", \"Christmas Island\", \"Cocos (Keeling) Islands\", \"Colombia\", \"Comoros\", \"Congo\", \"Cook Islands\", \"Costa Rica\", \"Cote d`Ivoire\", \"Croatia (Hrvatska)\", \"Cuba\", \"Cyprus\", \"Czech Republic\", \"Denmark\", \"Djibouti\", \"Dominica\", \"Dominican Republic\", \"East Timor\", \"Ecuador\", \"Egypt\", \"El Salvador\", \"Equatorial Guinea\", \"Eritrea\", \"Estonia\", \"Ethiopia\", \"Falkland Islands/Malvinas\", \"Faroe Islands\", \"Fiji\", \"Finland\", \"France\", \"France, Metropolitan\", \"French Guiana\", \"French Polynesia\", \"French Southern Terr.\", \"Gabon\", \"Gambia\", \"Georgia\", \"Germany\", \"Ghana\", \"Gibraltar\", \"Greece\", \"Greenland\", \"Grenada\", \"Guadeloupe\", \"Guam\", \"Guatemala\", \"Guinea\", \"Guinea-Bissau\", \"Guyana\", \"Haiti\", \"Heard &amp; McDonald Is.\", \"Honduras\", \"Hong Kong\", \"Hungary\", \"Iceland\", \"India\", \"Indonesia\", \"Iran\", \"Iraq\", \"Ireland\", \"Israel\", \"Italy\", \"Jamaica\", \"Japan\", \"Jordan\", \"Kazakhstan\", \"Kenya\", \"Kiribati\", \"Korea, North\", \"Korea, South\", \"Kuwait\", \"Kyrgyzstan\", \"Lao People`s Dem. Rep.\", \"Latvia\", \"Lebanon\", \"Lesotho\", \"Liberia\", \"Libyan Arab Jamahiriya\", \"Liechtenstein\", \"Lithuania\", \"Luxembourg\", \"Macau\", \"Macedonia\", \"Madagascar\", \"Malawi\", \"Malaysia\", \"Maldives\", \"Mali\", \"Malta\", \"Marshall Islands\", \"Martinique\", \"Mauritania\", \"Mauritius\", \"Mayotte\", \"Micronesia\", \"Moldova\", \"Monaco\", \"Mongolia\", \"Montserrat\", \"Morocco\", \"Mozambique\", \"Myanmar\", \"Namibia\", \"Nauru\", \"Nepal\", \"Netherlands\", \"Netherlands Antilles\", \"New Caledonia\", \"New Zealand\", \"Nicaragua\", \"Niger\", \"Nigeria\", \"Niue\", \"Norfolk Island\", \"Northern Mariana Is.\", \"Norway\", \"Oman\", \"Pakistan\", \"Palau\", \"Panama\", \"Papua New Guinea\", \"Paraguay\", \"Peru\", \"Philippines\", \"Pitcairn\", \"Poland\", \"Portugal\", \"Puerto Rico\", \"Qatar\", \"Reunion\", \"Romania\", \"Russian Federation\", \"Rwanda\", \"Saint Kitts and Nevis\", \"Saint Lucia\", \"St. Vincent &amp; Grenadines\", \"Samoa\", \"San Marino\", \"Sao Tome &amp; Principe\", \"Saudi Arabia\", \"Senegal\", \"Seychelles\", \"Sierra Leone\", \"Singapore\", \"Slovakia (Slovak Republic)\", \"Slovenia\", \"Solomon Islands\", \"Somalia\", \"South Africa\", \"S.Georgia &amp; S.Sandwich Is.\", \"Spain\", \"Sri Lanka\", \"St. Helena\", \"St. Pierre &amp; Miquelon\", \"Sudan\", \"Suriname\", \"Svalbard &amp; Jan Mayen Is.\", \"Swaziland\", \"Sweden\", \"Switzerland\", \"Syrian Arab Republic\", \"Taiwan\", \"Tajikistan\", \"Tanzania\", \"Thailand\", \"Togo\", \"Tokelau\", \"Tonga\", \"Trinidad and Tobago\", \"Tunisia\", \"Turkey\", \"Turkmenistan\", \"Turks &amp; Caicos Islands\", \"Tuvalu\", \"Uganda\", \"Ukraine\", \"United Arab Emirates\", \"United Kingdom\", \"U.S. Minor Outlying Is.\", \"Uruguay\", \"Uzbekistan\", \"Vanuatu\", \"Vatican (Holy See)\", \"Venezuela\", \"Viet Nam\", \"Virgin Islands (British)\", \"Virgin Islands (U.S.)\", \"Wallis &amp; Futuna Is.\", \"Western Sahara\", \"Yemen\", \"Yugoslavia\", \"Zaire\", \"Zambia\", \"Zimbabwe\"]}','2020-03-26 13:18:22','2020-03-26 13:18:22'),(4,NULL,0,'{\"name\": \"Languages\", \"type\": \"List\", \"preset\": [\"Abkhaz\", \"Achinese\", \"Acoli\", \"Adangme\", \"Adygei\", \"Afar\", \"Afrihili (Artificial language)\", \"Afrikaans\", \"Afroasiatic (Other)\", \"Akan\", \"Akkadian\", \"Albanian\", \"Aleut\", \"Algonquian (Other)\", \"Altaic (Other)\", \"Amharic\", \"Apache languages\", \"Arabic\", \"Aragonese Spanish\", \"Aramaic\", \"Arapaho\", \"Arawak\", \"Armenian\", \"Artificial (Other)\", \"Assamese\", \"Athapascan (Other)\", \"Australian languages\", \"Austronesian (Other)\", \"Avaric\", \"Avestan\", \"Awadhi\", \"Aymara\", \"Azerbaijani\", \"Bable\", \"Balinese\", \"Baltic (Other)\", \"Baluchi\", \"Bambara\", \"Bamileke languages\", \"Banda\", \"Bantu (Other)\", \"Basa\", \"Bashkir\", \"Basque\", \"Batak\", \"Beja\", \"Belarusian\", \"Bemba\", \"Bengali\", \"Berber (Other)\", \"Bhojpuri\", \"Bihari\", \"Bikol\", \"Bislama\", \"Bosnian\", \"Braj\", \"Breton\", \"Bugis\", \"Bulgarian\", \"Buriat\", \"Burmese\", \"Caddo\", \"Carib\", \"Catalan\", \"Caucasian (Other)\", \"Cebuano\", \"Celtic (Other)\", \"Central American Indian (Other)\", \"Chagatai\", \"Chamic languages\", \"Chamorro\", \"Chechen\", \"Cherokee\", \"Cheyenne\", \"Chibcha\", \"Chinese\", \"Chinook jargon\", \"Chipewyan\", \"Choctaw\", \"Church Slavic\", \"Chuvash\", \"Coptic\", \"Cornish\", \"Corsican\", \"Cree\", \"Creek\", \"Creoles and Pidgins (Other)\", \"Creoles and Pidgins, English-based (Other)\", \"Creoles and Pidgins, French-based (Other)\", \"Creoles and Pidgins, Portuguese-based (Other)\", \"Crimean Tatar\", \"Croatian\", \"Cushitic (Other)\", \"Czech\", \"Dakota\", \"Danish\", \"Dargwa\", \"Dayak\", \"Delaware\", \"Dinka\", \"Divehi\", \"Dogri\", \"Dogrib\", \"Dravidian (Other)\", \"Duala\", \"Dutch\", \"Dutch, Middle (ca. 1050-1350)\", \"Dyula\", \"Dzongkha\", \"Edo\", \"Efik\", \"Egyptian\", \"Ekajuk\", \"Elamite\", \"English\", \"English, Middle (1100-1500)\", \"English, Old (ca. 450-1100)\", \"Esperanto\", \"Estonian\", \"Ethiopic\", \"Ewe\", \"Ewondo\", \"Fang\", \"Fanti\", \"Faroese\", \"Fijian\", \"Finnish\", \"Finno-Ugrian (Other)\", \"Fon\", \"French\", \"French, Middle (ca. 1400-1600)\", \"French, Old (ca. 842-1400)\", \"Frisian\", \"Friulian\", \"Fula\", \"Galician\", \"Ganda\", \"Gayo\", \"Gbaya\", \"Georgian\", \"German\", \"German, Middle High (ca. 1050-1500)\", \"German, Old High (ca. 750-1050)\", \"Germanic (Other)\", \"Gilbertese\", \"Gondi\", \"Gorontalo\", \"Gothic\", \"Grebo\", \"Greek, Ancient (to 1453)\", \"Greek, Modern (1453- )\", \"Guarani\", \"Gujarati\", \"Gwich\'in\", \"Gã\", \"Haida\", \"Haitian French Creole\", \"Hausa\", \"Hawaiian\", \"Hebrew\", \"Herero\", \"Hiligaynon\", \"Himachali\", \"Hindi\", \"Hiri Motu\", \"Hittite\", \"Hmong\", \"Hungarian\", \"Hupa\", \"Iban\", \"Icelandic\", \"Ido\", \"Igbo\", \"Ijo\", \"Iloko\", \"Inari Sami\", \"Indic (Other)\", \"Indo-European (Other)\", \"Indonesian\", \"Ingush\", \"Interlingua (International Auxiliary Language Association)\", \"Interlingue\", \"Inuktitut\", \"Inupiaq\", \"Iranian (Other)\", \"Irish\", \"Irish, Middle (ca. 1100-1550)\", \"Irish, Old (to 1100)\", \"Iroquoian (Other)\", \"Italian\", \"Japanese\", \"Javanese\", \"Judeo-Arabic\", \"Judeo-Persian\", \"Kabardian\", \"Kabyle\", \"Kachin\", \"Kalmyk\", \"Kalâtdlisut\", \"Kamba\", \"Kannada\", \"Kanuri\", \"Kara-Kalpak\", \"Karen\", \"Kashmiri\", \"Kawi\", \"Kazakh\", \"Khasi\", \"Khmer\", \"Khoisan (Other)\", \"Khotanese\", \"Kikuyu\", \"Kimbundu\", \"Kinyarwanda\", \"Komi\", \"Kongo\", \"Konkani\", \"Korean\", \"Kpelle\", \"Kru\", \"Kuanyama\", \"Kumyk\", \"Kurdish\", \"Kurukh\", \"Kusaie\", \"Kutenai\", \"Kyrgyz\", \"Ladino\", \"Lahnda\", \"Lamba\", \"Lao\", \"Latin\", \"Latvian\", \"Letzeburgesch\", \"Lezgian\", \"Limburgish\", \"Lingala\", \"Lithuanian\", \"Low German\", \"Lozi\", \"Luba-Katanga\", \"Luba-Lulua\", \"Luiseño\", \"Lule Sami\", \"Lunda\", \"Luo (Kenya and Tanzania)\", \"Lushai\", \"Macedonian\", \"Madurese\", \"Magahi\", \"Maithili\", \"Makasar\", \"Malagasy\", \"Malay\", \"Malayalam\", \"Maltese\", \"Manchu\", \"Mandar\", \"Mandingo\", \"Manipuri\", \"Manobo languages\", \"Manx\", \"Maori\", \"Mapuche\", \"Marathi\", \"Mari\", \"Marshallese\", \"Marwari\", \"Masai\", \"Mayan languages\", \"Mende\", \"Micmac\", \"Minangkabau\", \"Miscellaneous languages\", \"Mohawk\", \"Moldavian\", \"Mon-Khmer (Other)\", \"Mongo-Nkundu\", \"Mongolian\", \"Mooré\", \"Multiple languages\", \"Munda (Other)\", \"Nahuatl\", \"Nauru\", \"Navajo\", \"Ndebele (South Africa)\", \"Ndebele (Zimbabwe)\", \"Ndonga\", \"Neapolitan Italian\", \"Nepali\", \"Newari\", \"Nias\", \"Niger-Kordofanian (Other)\", \"Nilo-Saharan (Other)\", \"Niuean\", \"Nogai\", \"North American Indian (Other)\", \"Northern Sami\", \"Northern Sotho\", \"Norwegian\", \"Norwegian (Bokmål)\", \"Norwegian (Nynorsk)\", \"Nubian languages\", \"Nyamwezi\", \"Nyanja\", \"Nyankole\", \"Nyoro\", \"Nzima\", \"Occitan (post-1500)\", \"Ojibwa\", \"Old Norse\", \"Old Persian (ca. 600-400 B.C.)\", \"Oriya\", \"Oromo\", \"Osage\", \"Ossetic\", \"Otomian languages\", \"Pahlavi\", \"Palauan\", \"Pali\", \"Pampanga\", \"Pangasinan\", \"Panjabi\", \"Papiamento\", \"Papuan (Other)\", \"Persian\", \"Philippine (Other)\", \"Phoenician\", \"Polish\", \"Ponape\", \"Portuguese\", \"Prakrit languages\", \"Provençal (to 1500)\", \"Pushto\", \"Quechua\", \"Raeto-Romance\", \"Rajasthani\", \"Rapanui\", \"Rarotongan\", \"Romance (Other)\", \"Romani\", \"Romanian\", \"Rundi\", \"Russian\", \"Salishan languages\", \"Samaritan Aramaic\", \"Sami\", \"Samoan\", \"Sandawe\", \"Sango (Ubangi Creole)\", \"Sanskrit\", \"Santali\", \"Sardinian\", \"Sasak\", \"Scots\", \"Scottish Gaelic\", \"Selkup\", \"Semitic (Other)\", \"Serbian\", \"Serer\", \"Shan\", \"Shona\", \"Sichuan Yi\", \"Sidamo\", \"Sign languages\", \"Siksika\", \"Sindhi\", \"Sinhalese\", \"Sino-Tibetan (Other)\", \"Siouan (Other)\", \"Skolt Sami\", \"Slave\", \"Slavic (Other)\", \"Slovak\", \"Slovenian\", \"Sogdian\", \"Somali\", \"Songhai\", \"Soninke\", \"Sorbian languages\", \"Sotho\", \"South American Indian (Other)\", \"Southern Sami\", \"Spanish\", \"Sukuma\", \"Sumerian\", \"Sundanese\", \"Susu\", \"Swahili\", \"Swazi\", \"Swedish\", \"Syriac\", \"Tagalog\", \"Tahitian\", \"Tai (Other)\", \"Tajik\", \"Tamashek\", \"Tamil\", \"Tatar\", \"Telugu\", \"Temne\", \"Terena\", \"Tetum\", \"Thai\", \"Tibetan\", \"Tigrinya\", \"Tigré\", \"Tiv\", \"Tlingit\", \"Tok Pisin\", \"Tokelauan\", \"Tonga (Nyasa)\", \"Tongan\", \"Truk\", \"Tsimshian\", \"Tsonga\", \"Tswana\", \"Tumbuka\", \"Tupi languages\", \"Turkish\", \"Turkish, Ottoman\", \"Turkmen\", \"Tuvaluan\", \"Tuvinian\", \"Twi\", \"Udmurt\", \"Ugaritic\", \"Uighur\", \"Ukrainian\", \"Umbundu\", \"Undetermined\", \"Urdu\", \"Uzbek\", \"Vai\", \"Venda\", \"Vietnamese\", \"Volapük\", \"Votic\", \"Wakashan languages\", \"Walamo\", \"Walloon\", \"Waray\", \"Washo\", \"Welsh\", \"Wolof\", \"Xhosa\", \"Yakut\", \"Yao (Africa)\", \"Yapese\", \"Yiddish\", \"Yoruba\", \"Yupik languages\", \"Zande\", \"Zapotec\", \"Zenaga\", \"Zhuang\", \"Zulu\", \"Zuni\"]}','2020-03-26 13:18:23','2020-03-26 13:18:23'),(5,NULL,0,'{\"name\": \"US States\", \"type\": \"List\", \"preset\": [\"Alabama\", \"Alaska\", \"Arizona\", \"Arkansas\", \"California\", \"Colorado\", \"Connecticut\", \"Delaware\", \"District of Columbia\", \"Florida\", \"Georgia\", \"Hawaii\", \"Idaho\", \"Illinois\", \"Indiana\", \"Iowa\", \"Kansas\", \"Kentucky\", \"Louisiana\", \"Maine\", \"Maryland\", \"Massachusetts\", \"Michigan\", \"Minnesota\", \"Mississippi\", \"Missouri\", \"Montana\", \"Nebraska\", \"Nevada\", \"New Hampshire\", \"New Jersey\", \"New Mexico\", \"New York\", \"North Carolina\", \"North Dakota\", \"Ohio\", \"Oklahoma\", \"Oregon\", \"Pennsylvania\", \"Rhode Island\", \"South Carolina\", \"South Dakota\", \"Tennessee\", \"Texas\", \"Utah\", \"Vermont\", \"Virginia\", \"Washington\", \"West Virginia\", \"Wisconsin\", \"Wyoming\"]}','2020-03-26 13:18:23','2020-03-26 13:18:23'),(6,1,0,'{\"name\": \"ARCS Creator Role\", \"type\": \"List\", \"preset\": [\"Architect\", \"Archivist\", \"Assistant Director\", \"Conservator\", \"Director\", \"Excavator\", \"Field Director\", \"Photographer\", \"Student Volunteer\", \"Trench Supervisor\", \"Registrar\", \"Field Coordinator\", \"Draftsman\", \"Volunteer\"]}','2020-03-26 14:36:17','2020-03-26 14:36:17'),(7,1,0,'{\"name\": \"ARCS Creator\", \"type\": \"List\", \"preset\": [\"Anderson, Candace E.\", \"Barletta, Barbara\", \"Batcheller, James\", \"Bauslaugh, Robert\", \"Blackmore, Judy\", \"Bleistein, Charlene\", \"Bogle, Cynthia\", \"Bolas, B.\", \"Bolas, Barbara\", \"Bowman, Michael\", \"Broneer, Oscar\", \"Brunner, Judith\", \"Camp II, John\", \"Camp, Margot\", \"Card, Sandra\", \"Carpenter, J. D.\", \"Cassimatis, Maria\", \"Clement, Paul\", \"Cummer, W. Wilson\", \"DeForest, Dallas\", \"Dinsmoor, Jr., William Bell\", \"Downs, Joanie\", \"Farnsworth, Marie\", \"Feder, Debbie\", \"Frey, Jon M.\", \"Gais, Ruth\", \"Giesen, Myra J.\", \"Gill, Alyson A.\", \"Greenberg, Barbara Bolas\", \"Gregory, Adelia E.\", \"Gregory, Timothy E.\", \"Guven, Suna\", \"Harris, A.\", \"Hartswick, Kim J.\", \"Howell, Jesse\", \"Hull, Don\", \"Hull, Susan\", \"Jacoby, Tom\", \"Jameson, Matthew\", \"Johnson, Matthew\", \"Kaljakin, Tania\", \"Kallemeyer, Susan\", \"Kardulias, P. Nick\", \"Kaye, Kenneth\", \"Keating, Richard\", \"Kieit, S.\", \"Kouvaris, Michael S.\", \"Lanham, Carol\", \"Leander-Touati, Anne-Marie\", \"Lease, L.\", \"Liddle, G.\", \"Lindros-Wohl, Birgitta\", \"Luongo, C.\", \"Marty, Jeanne M.\", \"McCaslin, Dan\", \"McClure, Robert\", \"McGrew, Ellen\", \"Mitchell, Maria\", \"Moore, Allen\", \"Mucha, Ashley E.\", \"Nicols, John\", \"Okin, Louis\", \"Pallas, Demetrios\", \"Pattengale, Jerry\", \"Peirce, Sarah\", \"Peppers, Anne Beaton\", \"Peppers, James\", \"Peppers, Jeanne Marty\", \"Pettegrew, David\", \"Pierce, Charles\", \"Platz, Ralph\", \"Porter, Alexander\", \"Rife, Joseph L.\", \"Rothaus, Richard M.\", \"Rudrick, Anna M.\", \"Sarefield, Daniel\", \"Sasel, Marjeta\", \"Schaar, Kenneth W.\", \"Scott, Ruth\", \"Semeli S.\", \"Shaw, Joseph W.\", \"Silberberg, Susan R.\", \"Snively, Carolyn\", \"Stein, Carol A.\", \"Tache, Hannah\", \"Thorne, Margaret MacVeagh\", \"Thorne, Stuart E.\", \"von Sternberg, Meri\", \"Walker, B.\", \"Walters, Elizabeth J.\", \"Wilson, David\", \"Wittman, Barbara\", \"Wittmann, Barbara K.\", \"Wohl, Birgitta\", \"Zuckerman, T. B.\", \"Moore, Debra W.\", \"Vernon, Catherine\", \"Zidar, Charles M.\", \"Pollak, Barbara A.\", \"Architect\", \"Archivist\", \"Assistant Director\", \"Conservator\", \"Director\", \"Excavator\", \"Field Director\", \"Photographer\", \"Student Volunteer\", \"Trench Supervisor\", \"Registrar\", \"Field Coordinator\", \"Draftsman\", \"Volunteer\", \"Grigoryan, Anait\", \"Frankhauser, Sarah\", \"Frey, Jon M\", \"Long, Andrea\", \"Nash, Scott\", \"Pettegrew, Kate\", \"Swain, Brian\", \"Tzortzoupolou-Gregory, Lita\"]}','2020-03-26 14:36:17','2020-03-26 14:36:17');
/*!40000 ALTER TABLE `kora_field_value_presets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kora_form_custom`
--

DROP TABLE IF EXISTS `kora_form_custom`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kora_form_custom` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `project_id` int(10) unsigned NOT NULL,
  `organization` json NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `form_custom_user_id_foreign` (`user_id`),
  KEY `form_custom_project_id_foreign` (`project_id`),
  CONSTRAINT `form_custom_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `kora_projects` (`id`) ON DELETE CASCADE,
  CONSTRAINT `form_custom_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `kora_users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kora_form_custom`
--

LOCK TABLES `kora_form_custom` WRITE;
/*!40000 ALTER TABLE `kora_form_custom` DISABLE KEYS */;
INSERT INTO `kora_form_custom` VALUES (1,1,1,'[1, 2, 3, 4, 5, 6]','2020-03-26 14:36:17','2020-03-26 14:36:21');
/*!40000 ALTER TABLE `kora_form_custom` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kora_form_group_user`
--

DROP TABLE IF EXISTS `kora_form_group_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kora_form_group_user` (
  `form_group_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  KEY `form_group_user_form_group_id_index` (`form_group_id`),
  KEY `form_group_user_user_id_index` (`user_id`),
  CONSTRAINT `form_group_user_form_group_id_foreign` FOREIGN KEY (`form_group_id`) REFERENCES `kora_form_groups` (`id`) ON DELETE CASCADE,
  CONSTRAINT `form_group_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `kora_users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kora_form_group_user`
--

LOCK TABLES `kora_form_group_user` WRITE;
/*!40000 ALTER TABLE `kora_form_group_user` DISABLE KEYS */;
INSERT INTO `kora_form_group_user` VALUES (1,1),(3,1),(5,1),(7,1),(9,1),(11,1);
/*!40000 ALTER TABLE `kora_form_group_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kora_form_groups`
--

DROP TABLE IF EXISTS `kora_form_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kora_form_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `form_id` int(10) unsigned NOT NULL,
  `create` tinyint(1) NOT NULL,
  `edit` tinyint(1) NOT NULL,
  `delete` tinyint(1) NOT NULL,
  `ingest` tinyint(1) NOT NULL,
  `modify` tinyint(1) NOT NULL,
  `destroy` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `form_groups_form_id_foreign` (`form_id`),
  CONSTRAINT `form_groups_form_id_foreign` FOREIGN KEY (`form_id`) REFERENCES `kora_forms` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kora_form_groups`
--

LOCK TABLES `kora_form_groups` WRITE;
/*!40000 ALTER TABLE `kora_form_groups` DISABLE KEYS */;
INSERT INTO `kora_form_groups` VALUES (1,'Project Admin Group',1,1,1,1,1,1,1,'2020-03-26 14:36:17','2020-03-26 14:36:17'),(2,'Project Default Group',1,0,0,0,0,0,0,'2020-03-26 14:36:17','2020-03-26 14:36:18'),(3,'Season Admin Group',2,1,1,1,1,1,1,'2020-03-26 14:36:18','2020-03-26 14:36:18'),(4,'Season Default Group',2,0,0,0,0,0,0,'2020-03-26 14:36:18','2020-03-26 14:36:18'),(5,'Resource Admin Group',3,1,1,1,1,1,1,'2020-03-26 14:36:19','2020-03-26 14:36:19'),(6,'Resource Default Group',3,0,0,0,0,0,0,'2020-03-26 14:36:19','2020-03-26 14:36:19'),(7,'Pages Admin Group',4,1,1,1,1,1,1,'2020-03-26 14:36:19','2020-03-26 14:36:19'),(8,'Pages Default Group',4,0,0,0,0,0,0,'2020-03-26 14:36:19','2020-03-26 14:36:19'),(9,'Subject of Observation Admin Group',5,1,1,1,1,1,1,'2020-03-26 14:36:20','2020-03-26 14:36:20'),(10,'Subject of Observation Default Group',5,0,0,0,0,0,0,'2020-03-26 14:36:20','2020-03-26 14:36:20'),(11,'Excavation - Survey Admin Group',6,1,1,1,1,1,1,'2020-03-26 14:36:21','2020-03-26 14:36:21'),(12,'Excavation - Survey Default Group',6,0,0,0,0,0,0,'2020-03-26 14:36:21','2020-03-26 14:36:21');
/*!40000 ALTER TABLE `kora_form_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kora_forms`
--

DROP TABLE IF EXISTS `kora_forms`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kora_forms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `project_id` int(10) unsigned NOT NULL,
  `name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `internal_name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `adminGroup_id` int(10) unsigned NOT NULL,
  `preset` tinyint(1) NOT NULL,
  `layout` json NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `forms_internal_name_unique` (`internal_name`),
  KEY `forms_project_id_foreign` (`project_id`),
  CONSTRAINT `forms_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `kora_projects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kora_forms`
--

LOCK TABLES `kora_forms` WRITE;
/*!40000 ALTER TABLE `kora_forms` DISABLE KEYS */;
INSERT INTO `kora_forms` VALUES (1,1,'Project','Project_1_1_','Information about the overarching archaeological enterprise, including data that define the project in the modern era and the project location in antiquity',1,0,'{\"pages\": [{\"flids\": [\"Name_1_1_\", \"Country_1_1_\", \"Region_1_1_\", \"Modern_Name_1_1_\", \"Location_Identifier_1_1_\", \"Location_Identifier_Scheme_1_1_\", \"Geolocation_1_1_\", \"Elevation_1_1_\", \"Earliest_Date_1_1_\", \"Latest_Date_1_1_\", \"Records_Archive_1_1_\", \"Persistent_Name_1_1_\", \"Complex_Title_1_1_\", \"Terminus_Ante_Quem_1_1_\", \"Terminus_Post_Quem_1_1_\", \"Period_1_1_\", \"Archaeological_Culture_1_1_\", \"Description_1_1_\", \"Brief_Description_1_1_\", \"Permitting_Heritage_Body_1_1_\"], \"title\": \"Project\"}], \"fields\": {\"Name_1_1_\": {\"name\": \"Name\", \"type\": \"Text\", \"default\": null, \"options\": {\"Regex\": \"\", \"MultiLine\": \"0\"}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 1, \"description\": \"Titles, identifying phrases, or names given to an archaeological \\nspace.\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 1, \"viewable_in_results\": 1}, \"Period_1_1_\": {\"name\": \"Period\", \"type\": \"Multi-Select List\", \"default\": null, \"options\": {\"Options\": [\"Bronze Age\", \"Geometric\", \"Archaic\", \"Classical\", \"Hellenistic\", \"Roman\", \"Late Roman/Byzantine\", \"Frankish\", \"Ottoman\", \"Modern\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Term that identifies the named, defined period(s) whose characteristics are represented in the project location.\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}, \"Region_1_1_\": {\"name\": \"Region\", \"type\": \"List\", \"default\": null, \"options\": {\"Options\": [\"Corinthia\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Geographic area where the project is located (modern)\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}, \"Country_1_1_\": {\"name\": \"Country\", \"type\": \"List\", \"default\": \"Greece\", \"options\": {\"Options\": [\"Greece\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"A type of \", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}, \"Elevation_1_1_\": {\"name\": \"Elevation\", \"type\": \"Text\", \"default\": null, \"options\": {\"Regex\": \"\", \"MultiLine\": \"0\"}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Highest and lowest recorded altitudes of the project location, expressed as a range in meters according to the WGS 84 system.\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}, \"Description_1_1_\": {\"name\": \"Description\", \"type\": \"Text\", \"default\": null, \"options\": {\"Regex\": \"\", \"MultiLine\": \"1\"}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Concise narrative outlining the project, its goals, duration, etc.\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}, \"Geolocation_1_1_\": {\"name\": \"Geolocation\", \"type\": \"Generated List\", \"default\": null, \"options\": {\"Regex\": \"\", \"Options\": [\"Please Modify List Values\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Coordinate pair(s) (latitude and longitude) that establishes a general location of project. \\n\\nFormatting: Latitude,Longitude for example: 41.255678,13.435335\\n\\n\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}, \"Latest_Date_1_1_\": {\"name\": \"Latest Date\", \"type\": \"Historical Date\", \"default\": {\"day\": [\"[M]0[M]\", \"0\", \"[Y]0[Y]\"], \"era\": \"CE\", \"year\": [\"[M]0[M][D]0[D]\", \"0\", \"\"], \"month\": [\"\", \"0\", \"[D]0[D][Y]0[Y]\"], \"prefix\": \"\"}, \"options\": {\"End\": \"2020\", \"Start\": \"1930\", \"Format\": \"YYYYMMDD\", \"ShowEra\": 0, \"ShowPrefix\": 0}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Latest date associated with project activity, expressed in yyyy/mm/dd format\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}, \"Modern_Name_1_1_\": {\"name\": \"Modern Name\", \"type\": \"List\", \"default\": \"Kyras Vrisi\", \"options\": {\"Options\": [\"Kyras Vrisi\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"The modern toponym of the geographic location of the project\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}, \"Complex_Title_1_1_\": {\"name\": \"Complex Title\", \"type\": \"Text\", \"default\": null, \"options\": {\"Regex\": \"\", \"MultiLine\": \"1\"}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"The name of the complex of which the work is a part, if applicable.\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}, \"Earliest_Date_1_1_\": {\"name\": \"Earliest Date\", \"type\": \"Historical Date\", \"default\": {\"day\": [\"[M]0[M]\", \"0\", \"[Y]0[Y]\"], \"era\": \"CE\", \"year\": [\"[M]0[M][D]0[D]\", \"0\", \"\"], \"month\": [\"\", \"0\", \"[D]0[D][Y]0[Y]\"], \"prefix\": \"\"}, \"options\": {\"End\": \"2020\", \"Start\": \"1930\", \"Format\": \"YYYYMMDD\", \"ShowEra\": 0, \"ShowPrefix\": 0}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Earliest date associated with project activity, expressed in yyyy/mm/dd format\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}, \"Persistent_Name_1_1_\": {\"name\": \"Persistent Name\", \"type\": \"Text\", \"default\": null, \"options\": {\"Regex\": \"\", \"MultiLine\": \"1\"}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Name by which the location of the project is traditionally known.\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}, \"Records_Archive_1_1_\": {\"name\": \"Records Archive\", \"type\": \"Multi-Select List\", \"default\": null, \"options\": {\"Options\": [\"The Ohio State University Excavations at Isthmia Archives\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Location(s) of project documentation and records. Uniform name of the physical repository or repositories with full address.\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}, \"Brief_Description_1_1_\": {\"name\": \"Brief Description\", \"type\": \"Text\", \"default\": null, \"options\": {\"Regex\": \"\", \"MultiLine\": \"1\"}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"2 sentence narrative describing the project. Will appear on the home page of the public site.\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}, \"Terminus_Ante_Quem_1_1_\": {\"name\": \"Terminus Ante Quem\", \"type\": \"Historical Date\", \"default\": {\"day\": [\"[M]0[M]\", \"0\", \"[Y]0[Y]\"], \"era\": \"CE\", \"year\": [\"[M]0[M][D]0[D]\", \"0\", \"\"], \"month\": [\"\", \"0\", \"[D]0[D][Y]0[Y]\"], \"prefix\": \"\"}, \"options\": {\"End\": \"9999\", \"Start\": \"1\", \"Format\": \"MMDDYYYY\", \"ShowEra\": 1, \"ShowPrefix\": 0}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Date at which the project location begins to exhibit evidence of human activity.\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}, \"Terminus_Post_Quem_1_1_\": {\"name\": \"Terminus Post Quem\", \"type\": \"Historical Date\", \"default\": {\"day\": [\"[M]0[M]\", \"0\", \"[Y]0[Y]\"], \"era\": \"CE\", \"year\": [\"[M]0[M][D]0[D]\", \"0\", \"\"], \"month\": [\"\", \"0\", \"[D]0[D][Y]0[Y]\"], \"prefix\": \"\"}, \"options\": {\"End\": \"9999\", \"Start\": \"1\", \"Format\": \"MMDDYYYY\", \"ShowEra\": 1, \"ShowPrefix\": 0}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Date at which the project location ceases to exhibit evidence of human activity.\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}, \"Location_Identifier_1_1_\": {\"name\": \"Location Identifier\", \"type\": \"Text\", \"default\": null, \"options\": {\"Regex\": \"\", \"MultiLine\": \"0\"}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Systematically assigned alphanumeric code identifying project location, if applicable\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}, \"Archaeological_Culture_1_1_\": {\"name\": \"Archaeological Culture\", \"type\": \"Multi-Select List\", \"default\": null, \"options\": {\"Options\": [\"test culture\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Recognizable and recurring assemblage of artifacts from a specific time and place. Thought to constitute the material remains of a particular past human society or group\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}, \"Permitting_Heritage_Body_1_1_\": {\"name\": \"Permitting Heritage Body\", \"type\": \"Multi-Select List\", \"default\": null, \"options\": {\"Options\": [\"Greek Ministry of Culture\", \"American School of Classical Studies, Athens\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Name of the heritage body granting permission for project\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}, \"Location_Identifier_Scheme_1_1_\": {\"name\": \"Location Identifier Scheme\", \"type\": \"Text\", \"default\": null, \"options\": {\"Regex\": \"\", \"MultiLine\": \"0\"}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Scheme used to generate identification code in Location Identifier, if applicable.\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}}}','2020-03-26 14:36:17','2020-03-26 14:36:18'),(2,1,'Season','Season_1_2_','Information about the period of time (season/campaign) during which archaeological research was conducted',3,0,'{\"pages\": [{\"flids\": [\"Project_Associator_1_2_\", \"Title_1_2_\", \"Type_1_2_\", \"Director_1_2_\", \"Registrar_1_2_\", \"Sponsor_1_2_\", \"Contributor_1_2_\", \"Contributor_Role_1_2_\", \"Contributor_2_1_2_\", \"Contributor_Role_2_1_2_\", \"Contributor_3_1_2_\", \"Contributor_Role_3_1_2_\", \"Contributor_4_1_2_\", \"Contributor_Role_4_1_2_\", \"Contributor_5_1_2_\", \"Contributor_Role_5_1_2_\", \"Contributor_6_1_2_\", \"Contributor_Role_6_1_2_\", \"Contributor_7_1_2_\", \"Contributor_Role_7_1_2_\", \"Contributor_8_1_2_\", \"Contributor_Role_8_1_2_\", \"Contributor_9_1_2_\", \"Contributor_Role_9_1_2_\", \"Earliest_Date_1_2_\", \"Latest_Date_1_2_\", \"Terminus_Ante_Quem_1_2_\", \"Terminus_Post_Quem_1_2_\", \"Description_1_2_\", \"Orphan_1_2_\", \"Project_Name_1_2_\"], \"title\": \"Season\"}], \"fields\": {\"Type_1_2_\": {\"name\": \"Type\", \"type\": \"Multi-Select List\", \"default\": [\"Excavation\"], \"options\": {\"Options\": [\"Excavation\", \"Study\", \"Survey\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 1, \"description\": \"Particular type of campaign (e.g. session, excavation, study)\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 1, \"viewable_in_results\": 1}, \"Title_1_2_\": {\"name\": \"Title\", \"type\": \"Text\", \"default\": null, \"options\": {\"Regex\": \"\", \"MultiLine\": \"0\"}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 1, \"description\": \"Title given to a particular physical configuration of the named project in an officially-defined short span of time\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 1, \"viewable_in_results\": 1}, \"Orphan_1_2_\": {\"name\": \"Orphan\", \"type\": \"List\", \"default\": null, \"options\": {\"Options\": [\"TRUE\", \"FALSE\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Indicates that the Season record is not associated or linked to the appropriate Project record.\\r\\n\\r\\nTRUE=Not Associated to Project record\\r\\nFALSE=Associated to appropriate Project record\", \"external_view\": 0, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 0}, \"Sponsor_1_2_\": {\"name\": \"Sponsor\", \"type\": \"Multi-Select List\", \"default\": [\"Ohio State University\", \"Tzortzoupolou-Gregory, Lita\", \"Ohio State University\"], \"options\": {\"Options\": [\"University of California, Los Angeles\", \"Ohio State University\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 1, \"description\": \"Entity/entities supporting the season\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 1, \"viewable_in_results\": 1}, \"Director_1_2_\": {\"name\": \"Director\", \"type\": \"Multi-Select List\", \"default\": [\"Gregory, Timothy E.\", \"Excavation\", \"Gregory, Timothy E.\"], \"options\": {\"Options\": [\"Broneer, Oscar\", \"Clement, Paul\", \"Gregory, Timothy E.\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 1, \"description\": \"Person(s) who bear responsibility for the execution of the season\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 1, \"viewable_in_results\": 1}, \"Registrar_1_2_\": {\"name\": \"Registrar\", \"type\": \"Multi-Select List\", \"default\": null, \"options\": {\"Options\": [\"Tzortzoupolou-Gregory, Lita\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 1, \"description\": \"Person(s) in an official position responsible for accurately recording season data\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 1, \"viewable_in_results\": 1}, \"Contributor_1_2_\": {\"name\": \"Contributor\", \"type\": \"List\", \"default\": \" \", \"options\": {\"Options\": [\"Berry, Rachel\", \"Clement, Paul\", \"DeForest, Dallas\", \"Gregory, Timothy E.\", \"Grigoryan, Anait\", \"Frankhauser, Sarah\", \"Frey, Jon M\", \"Jameson, Matthew\", \"Kaye, Kenneth\", \"Long, Andrea\", \"McGrew, Ellen\", \"Nash, Scott\", \"Pettegrew, David\", \"Pettegrew, Kate\", \"Swain, Brian\", \"Tzortzoupolou-Gregory, Lita\", \"Bauslaugh, R.\", \"Bleistein, C.\", \"Card, Sandra\", \"Cummer, W. Wilson\", \"Gais, R.\", \"Wilson, David\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 1, \"description\": \"Person who participated in the project during this particular season.\\n\\nIdentify the role(s) this contributor played during this season in the Contributor Role field.\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 1, \"viewable_in_results\": 1}, \"Description_1_2_\": {\"name\": \"Description\", \"type\": \"Text\", \"default\": null, \"options\": {\"Regex\": \"\", \"MultiLine\": \"1\"}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Concise narrative outlining the season, its goals, duration, outputs, etc.\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}, \"Latest_Date_1_2_\": {\"name\": \"Latest Date\", \"type\": \"Historical Date\", \"default\": {\"day\": [\"[M]0[M]\", \"0\", \"[Y]0[Y]\"], \"era\": \"CE\", \"year\": [\"[M]0[M][D]0[D]\", \"0\", \"\"], \"month\": [\"\", \"0\", \"[D]0[D][Y]0[Y]\"], \"prefix\": \"\"}, \"options\": {\"End\": \"2020\", \"Start\": \"1940\", \"Format\": \"YYYYMMDD\", \"ShowEra\": 0, \"ShowPrefix\": 0}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Latest date associated with project activity in this particular season, expressed in yyyy/mm/dd format\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}, \"Project_Name_1_2_\": {\"name\": \"Project Name\", \"type\": \"Text\", \"default\": null, \"options\": {\"Regex\": \"\", \"MultiLine\": \"0\"}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Include the name given to the project exactly as it is recorded in the Name field in the Project scheme. This will create a link between this Season record and the appropriate Project record it belongs to.\\n\\nRedundant data for batch upload.\", \"external_view\": 0, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 0}, \"Contributor_2_1_2_\": {\"name\": \"Contributor 2\", \"type\": \"List\", \"default\": null, \"options\": {\"Options\": [\"Berry, Rachel\", \"Clement, Paul\", \"DeForest, Dallas\", \"Gregory, Timothy E.\", \"Grigoryan, Anait\", \"Frankhauser, Sarah\", \"Frey, Jon M\", \"Jameson, Matthew\", \"Kaye, Kenneth\", \"Long, Andrea\", \"McGrew, Ellen\", \"Nash, Scott\", \"Pettegrew, David\", \"Pettegrew, Kate\", \"Swain, Brian\", \"Tzortzoupolou-Gregory, Lita\", \"Bleistein, C.\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Person who participated in the project during season and the part played by the contributor. \\n\\nIdentify the role(s) this contributor played during this season in the Contributor Role 2 field.\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}, \"Contributor_3_1_2_\": {\"name\": \"Contributor 3\", \"type\": \"List\", \"default\": null, \"options\": {\"Options\": [\"Berry, Rachel\", \"Clement, Paul\", \"DeForest, Dallas\", \"Gregory, Timothy E.\", \"Grigoryan, Anait\", \"Frankhauser, Sarah\", \"Frey, Jon M\", \"Jameson, Matthew\", \"Kaye, Kenneth\", \"Long, Andrea\", \"McGrew, Ellen\", \"Nash, Scott\", \"Pettegrew, David\", \"Pettegrew, Kate\", \"Swain, Brian\", \"Tzortzoupolou-Gregory, Lita\", \"Card, Sandra\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Person who participated in the project during season and the part played by the contributor. \\n\\nIdentify the role(s) this contributor played during this season in the Contributor Role 3 field.\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}, \"Contributor_4_1_2_\": {\"name\": \"Contributor 4\", \"type\": \"List\", \"default\": null, \"options\": {\"Options\": [\"Berry, Rachel\", \"DeForest, Dallas\", \"Gregory, Timothy E.\", \"Grigoryan, Anait\", \"Frankhauser, Sarah\", \"Frey, Jon M\", \"Jameson, Matthew\", \"Long, Andrea\", \"Nash, Scott\", \"Pettegrew, David\", \"Pettegrew, Kate\", \"Swain, Brian\", \"Tzortzoupolou-Gregory, Lita\", \"Cummer, W. Wilson\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Person who participated in the project during season and the part played by the contributor. \\n\\nIdentify the role(s) this contributor played during this season in the Contributor Role 4 field.\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}, \"Contributor_5_1_2_\": {\"name\": \"Contributor 5\", \"type\": \"List\", \"default\": null, \"options\": {\"Options\": [\"Berry, Rachel\", \"DeForest, Dallas\", \"Gregory, Timothy E.\", \"Grigoryan, Anait\", \"Frankhauser, Sarah\", \"Frey, Jon M\", \"Jameson, Matthew\", \"Long, Andrea\", \"Nash, Scott\", \"Pettegrew, David\", \"Pettegrew, Kate\", \"Swain, Brian\", \"Tzortzoupolou-Gregory, Lita\", \"Gais, R.\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Person who participated in the project during season and the part played by the contributor. \\n\\nIdentify the role(s) this contributor played during this season in the Contributor Role 5 field.\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}, \"Contributor_6_1_2_\": {\"name\": \"Contributor 6\", \"type\": \"List\", \"default\": null, \"options\": {\"Options\": [\"Berry, Rachel\", \"DeForest, Dallas\", \"Gregory, Timothy E.\", \"Grigoryan, Anait\", \"Frankhauser, Sarah\", \"Frey, Jon M\", \"Jameson, Matthew\", \"Long, Andrea\", \"Nash, Scott\", \"Pettegrew, David\", \"Pettegrew, Kate\", \"Swain, Brian\", \"Tzortzoupolou-Gregory, Lita\", \"Wilson, David\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Person who participated in the project during season and the part played by the contributor. \\n\\nIdentify the role(s) this contributor played during this season in the Contributor Role 6 field.\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}, \"Contributor_7_1_2_\": {\"name\": \"Contributor 7\", \"type\": \"List\", \"default\": null, \"options\": {\"Options\": [\"Berry, Rachel\", \"DeForest, Dallas\", \"Gregory, Timothy E.\", \"Grigoryan, Anait\", \"Frankhauser, Sarah\", \"Frey, Jon M\", \"Jameson, Matthew\", \"Long, Andrea\", \"Nash, Scott\", \"Pettegrew, David\", \"Pettegrew, Kate\", \"Swain, Brian\", \"Tzortzoupolou-Gregory, Lita\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Person who participated in the project during season and the part played by the contributor. \\n\\nIdentify the role(s) this contributor played during this season in the Contributor Role 7 field.\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}, \"Contributor_8_1_2_\": {\"name\": \"Contributor 8\", \"type\": \"List\", \"default\": null, \"options\": {\"Options\": [\"Berry, Rachel\", \"DeForest, Dallas\", \"Gregory, Timothy E.\", \"Grigoryan, Anait\", \"Frankhauser, Sarah\", \"Frey, Jon M\", \"Jameson, Matthew\", \"Long, Andrea\", \"Nash, Scott\", \"Pettegrew, David\", \"Pettegrew, Kate\", \"Swain, Brian\", \"Tzortzoupolou-Gregory, Lita\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Person who participated in the project during season and the part played by the contributor. \\n\\nIdentify the role(s) this contributor played during this season in the Contributor Role 8 field.\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}, \"Contributor_9_1_2_\": {\"name\": \"Contributor 9\", \"type\": \"List\", \"default\": null, \"options\": {\"Options\": [\"Berry, Rachel\", \"DeForest, Dallas\", \"Gregory, Timothy E.\", \"Grigoryan, Anait\", \"Frankhauser, Sarah\", \"Frey, Jon M\", \"Jameson, Matthew\", \"Long, Andrea\", \"Nash, Scott\", \"Pettegrew, David\", \"Pettegrew, Kate\", \"Swain, Brian\", \"Tzortzoupolou-Gregory, Lita\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Person who participated in the project during season and the part played by the contributor. \\n\\nIdentify the role(s) this contributor played during this season in the Contributor Role 9 field.\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}, \"Earliest_Date_1_2_\": {\"name\": \"Earliest Date\", \"type\": \"Historical Date\", \"default\": {\"day\": [\"[M]0[M]\", \"0\", \"[Y]0[Y]\"], \"era\": \"CE\", \"year\": [\"[M]0[M][D]0[D]\", \"0\", \"\"], \"month\": [\"\", \"0\", \"[D]0[D][Y]0[Y]\"], \"prefix\": \"\"}, \"options\": {\"End\": \"2020\", \"Start\": \"1940\", \"Format\": \"YYYYMMDD\", \"ShowEra\": 0, \"ShowPrefix\": 0}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Earliest date associated with project activity in this particular season, expressed in yyyy/mm/dd format\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}, \"Contributor_Role_1_2_\": {\"name\": \"Contributor Role\", \"type\": \"Multi-Select List\", \"default\": null, \"options\": {\"Options\": [\"Architect\", \"Archivist\", \"Assistant Director\", \"Conservator\", \"Database Manager\", \"Excavation Unit Supervisor\", \"Excavator\", \"Field Director\", \"Mapping Technician\", \"Materials Analyst\", \"Photographer\", \"Remote Sensing Technician\", \"Student\", \"Student Volunteer\", \"Surveyor\", \"Trench Supervisor\", \"Volunteer\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Part(s) or role(s) played by person identified in Contributor field.\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}, \"Contributor_Role_2_1_2_\": {\"name\": \"Contributor Role 2\", \"type\": \"Multi-Select List\", \"default\": null, \"options\": {\"Options\": [\"Architect\", \"Archivist\", \"Assistant Director\", \"Conservator\", \"Database Manager\", \"Excavation Unit Supervisor\", \"Excavator\", \"Field Director\", \"Mapping Technician\", \"Materials Analyst\", \"Photographer\", \"Remote Sensing Technician\", \"Student\", \"Student Volunteer\", \"Surveyor\", \"Trench Supervisor\", \"Volunteer\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Part(s) or role(s) played by person identified in Contributor 2 field.\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}, \"Contributor_Role_3_1_2_\": {\"name\": \"Contributor Role 3\", \"type\": \"Multi-Select List\", \"default\": null, \"options\": {\"Options\": [\"Architect\", \"Archivist\", \"Assistant Director\", \"Conservator\", \"Database Manager\", \"Excavation Unit Supervisor\", \"Excavator\", \"Field Director\", \"Mapping Technician\", \"Materials Analyst\", \"Photographer\", \"Remote Sensing Technician\", \"Student\", \"Student Volunteer\", \"Surveyor\", \"Trench Supervisor\", \"Volunteer\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Part(s) or role(s) played by person identified in Contributor 3 field.\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}, \"Contributor_Role_4_1_2_\": {\"name\": \"Contributor Role 4\", \"type\": \"Multi-Select List\", \"default\": null, \"options\": {\"Options\": [\"Architect\", \"Archivist\", \"Assistant Director\", \"Conservator\", \"Database Manager\", \"Excavator\", \"Field Director\", \"Mapping Technician\", \"Materials Analyst\", \"Photographer\", \"Remote Sensing Technician\", \"Student\", \"Surveyor\", \"Student Volunteer\", \"Trench Supervisor\", \"Volunteer\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Part(s) or role(s) played by person identified in Contributor 4 field.\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}, \"Contributor_Role_5_1_2_\": {\"name\": \"Contributor Role 5\", \"type\": \"Multi-Select List\", \"default\": null, \"options\": {\"Options\": [\"Architect\", \"Archivist\", \"Assistant Director\", \"Conservator\", \"Database Manager\", \"Excavation Unit Supervisor\", \"Excavator\", \"Field Director\", \"Mapping Technician\", \"Materials Analyst\", \"Photographer\", \"Remote Sensing Technician\", \"Student\", \"Student Volunteer\", \"Surveyor\", \"Trench Supervisor\", \"Volunteer\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Part(s) or role(s) played by person identified in Contributor 5 field.\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}, \"Contributor_Role_6_1_2_\": {\"name\": \"Contributor Role 6\", \"type\": \"Multi-Select List\", \"default\": null, \"options\": {\"Options\": [\"Architect\", \"Archivist\", \"Assistant Director\", \"Conservator\", \"Database Manager\", \"Excavation Unit Supervisor\", \"Excavator\", \"Field Director\", \"Mapping Technician\", \"Materials Analyst\", \"Photographer\", \"Remote Sensing Technician\", \"Student\", \"Student Volunteer\", \"Surveyor\", \"Trench Supervisor\", \"Volunteer\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Part(s) or role(s) played by person identified in Contributor 6 field.\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}, \"Contributor_Role_7_1_2_\": {\"name\": \"Contributor Role 7\", \"type\": \"Multi-Select List\", \"default\": null, \"options\": {\"Options\": [\"Architect\", \"Archivist\", \"Assistant Director\", \"Conservator\", \"Database Manager\", \"Director\", \"Excavation Unit Manager\", \"Excavator\", \"Field Director\", \"Mapping Technician\", \"Materials Analyst\", \"Photographer\", \"Remote Sensing Technician\", \"Student\", \"Student Volunteer\", \"Surveyor\", \"Trench Supervisor\", \"Volunteer\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Part(s) or role(s) played by person identified in Contributor 7 field.\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}, \"Contributor_Role_8_1_2_\": {\"name\": \"Contributor Role 8\", \"type\": \"Multi-Select List\", \"default\": null, \"options\": {\"Options\": [\"Architect\", \"Archivist\", \"Assistant Director\", \"Conservator\", \"Database Manager\", \"Excavation Unit Supervisor\", \"Excavator\", \"Field Director\", \"Mapping Technician\", \"Materials Analyst\", \"Photographer\", \"Remote Sensing Technician\", \"Student\", \"Student Volunteer\", \"Surveyor\", \"Trench Supervisor\", \"Volunteer\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Part(s) or role(s) played by person identified in Contributor 8 field.\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}, \"Contributor_Role_9_1_2_\": {\"name\": \"Contributor Role 9\", \"type\": \"Multi-Select List\", \"default\": null, \"options\": {\"Options\": [\"Architect\", \"Archivist\", \"Assistant Director\", \"Conservator\", \"Database Manager\", \"Excavation Unit Supervisor\", \"Excavator\", \"Field Director\", \"Mapping Technician\", \"Materials Analyst\", \"Photographer\", \"Remote Sensing Technician\", \"Student\", \"Student Volunteer\", \"Surveyor\", \"Trench Supervisor\", \"Volunteer\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Part(s) or role(s) played by person identified in Contributor 9 field.\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}, \"Project_Associator_1_2_\": {\"name\": \"Project Associator\", \"type\": \"Associator\", \"default\": null, \"options\": {\"SearchForms\": [{\"flids\": [], \"form_id\": \"31\"}]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"KORA identifier for the Project record that describes the overarching archaeological enterprise when this field research season or campaign took place.\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}, \"Terminus_Ante_Quem_1_2_\": {\"name\": \"Terminus Ante Quem\", \"type\": \"Historical Date\", \"default\": {\"day\": [\"[M]0[M]\", \"0\", \"[Y]0[Y]\"], \"era\": \"CE\", \"year\": [\"[M]0[M][D]0[D]\", \"0\", \"\"], \"month\": [\"\", \"0\", \"[D]0[D][Y]0[Y]\"], \"prefix\": \"\"}, \"options\": {\"End\": \"9999\", \"Start\": \"1\", \"Format\": \"MMDDYYYY\", \"ShowEra\": 1, \"ShowPrefix\": 0}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Date at which the project location studied in this season begins to exhibit evidence of human activity.\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}, \"Terminus_Post_Quem_1_2_\": {\"name\": \"Terminus Post Quem\", \"type\": \"Historical Date\", \"default\": {\"day\": [\"[M]0[M]\", \"0\", \"[Y]0[Y]\"], \"era\": \"CE\", \"year\": [\"[M]0[M][D]0[D]\", \"0\", \"\"], \"month\": [\"\", \"0\", \"[D]0[D][Y]0[Y]\"], \"prefix\": \"\"}, \"options\": {\"End\": \"9999\", \"Start\": \"1\", \"Format\": \"MMDDYYYY\", \"ShowEra\": 1, \"ShowPrefix\": 0}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Date at which the project location studied in this season ceases to exhibit evidence of human activity.\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}}}','2020-03-26 14:36:18','2020-03-26 14:36:18'),(3,1,'Resource','Resource_1_3_','Information about 1 archival object (document, map, photograph, etc.) created during the archaeological field research process',5,1,'{\"pages\": [{\"flids\": [\"Excavation_Survey_Associator_1_3_\", \"Season_Associator_1_3_\", \"Resource_Identifier_1_3_\", \"Type_1_3_\", \"Title_1_3_\", \"Sub_title_1_3_\", \"Creator_1_3_\", \"Creator_Role_1_3_\", \"Earliest_Date_1_3_\", \"Latest_Date_1_3_\", \"Dimensions_1_3_\", \"Language_1_3_\", \"Description_1_3_\", \"Transcription_1_3_\", \"Pages_1_3_\", \"Condition_1_3_\", \"Rights_1_3_\", \"Rights_Holder_1_3_\", \"Permissions_1_3_\", \"Special_User_1_3_\", \"Repository_1_3_\", \"Accession_Number_1_3_\", \"Date_Range_1_3_\", \"Creator2_1_3_\", \"id_1_3_\", \"Legacy_1_3_\", \"Creator_Role_2_1_3_\", \"Test_1_3_\", \"Orphan_1_3_\", \"Excavation_Survey_Name_1_3_\", \"Season_Title_1_3_\"], \"title\": \"Resource\"}], \"fields\": {\"id_1_3_\": {\"name\": \"id\", \"type\": \"Text\", \"default\": null, \"options\": {\"Regex\": \"\", \"MultiLine\": \"0\"}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Administrative field for ARCS to record legacy database id\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}, \"Test_1_3_\": {\"name\": \"Test\", \"type\": \"List\", \"default\": null, \"options\": {\"Options\": [\"Anderson, Candace E.\", \"Barletta, Barbara\", \"Batcheller, James\", \"Bauslaugh, Robert\", \"Blackmore, Judy\", \"Bleistein, Charlene\", \"Bogle, Cynthia\", \"Bolas, B.\", \"Bolas, Barbara\", \"Bowman, Michael\", \"Broneer, Oscar\", \"Brunner, Judith\", \"Camp II, John\", \"Camp, Margot\", \"Card, Sandra\", \"Carpenter, J. D.\", \"Cassimatis, Maria\", \"Clement, Paul\", \"Cummer, W. Wilson\", \"DeForest, Dallas\", \"Dinsmoor, Jr., William Bell\", \"Downs, Joanie\", \"Farnsworth, Marie\", \"Feder, Debbie\", \"Frey, Jon M.\", \"Gais, Ruth\", \"Giesen, Myra J.\", \"Gill, Alyson A.\", \"Greenberg, Barbara Bolas\", \"Gregory, Adelia E.\", \"Gregory, Timothy E.\", \"Guven, Suna\", \"Harris, A.\", \"Hartswick, Kim J.\", \"Howell, Jesse\", \"Hull, Don\", \"Hull, Susan\", \"Jacoby, Tom\", \"Jameson, Matthew\", \"Johnson, Matthew\", \"Kaljakin, Tania\", \"Kallemeyer, Susan\", \"Kardulias, P. Nick\", \"Kaye, Kenneth\", \"Keating, Richard\", \"Kieit, S.\", \"Kouvaris, Michael S.\", \"Lanham, Carol\", \"Leander-Touati, Anne-Marie\", \"Lease, L.\", \"Liddle, G.\", \"Lindros-Wohl, Birgitta\", \"Luongo, C.\", \"Marty, Jeanne M.\", \"McCaslin, Dan\", \"McClure, Robert\", \"McGrew, Ellen\", \"Mitchell, Maria\", \"Moore, Allen\", \"Mucha, Ashley E.\", \"Nicols, John\", \"Okin, Louis\", \"Pallas, Demetrios\", \"Pattengale, Jerry\", \"Peirce, Sarah\", \"Peppers, Anne Beaton\", \"Peppers, James\", \"Peppers, Jeanne Marty\", \"Pettegrew, David\", \"Pierce, Charles\", \"Platz, Ralph\", \"Porter, Alexander\", \"Rife, Joseph L.\", \"Rothaus, Richard M.\", \"Rudrick, Anna M.\", \"Sarefield, Daniel\", \"Sasel, Marjeta\", \"Schaar, Kenneth W.\", \"Scott, Ruth\", \"Semeli S.\", \"Shaw, Joseph W.\", \"Silberberg, Susan R.\", \"Snively, Carolyn\", \"Stein, Carol A.\", \"Tache, Hannah\", \"Thorne, Margaret MacVeagh\", \"Thorne, Stuart E.\", \"von Sternberg, Meri\", \"Walker, B.\", \"Walters, Elizabeth J.\", \"Wilson, David\", \"Wittman, Barbara\", \"Wittmann, Barbara K.\", \"Wohl, Birgitta\", \"Zuckerman, T. B.\", \"Moore, Debra W.\", \"Vernon, Catherine\", \"Zidar, Charles M.\", \"Pollak, Barbara A.\", \"Architect\", \"Archivist\", \"Assistant Director\", \"Conservator\", \"Director\", \"Excavator\", \"Field Director\", \"Photographer\", \"Student Volunteer\", \"Trench Supervisor\", \"Registrar\", \"Field Coordinator\", \"Draftsman\", \"Volunteer\", \"Grigoryan, Anait\", \"Frankhauser, Sarah\", \"Frey, Jon M\", \"Long, Andrea\", \"Nash, Scott\", \"Pettegrew, Kate\", \"Swain, Brian\", \"Tzortzoupolou-Gregory, Lita\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"\", \"external_view\": 0, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 0}, \"Type_1_3_\": {\"name\": \"Type\", \"type\": \"List\", \"default\": \" \", \"options\": {\"Options\": [\"Drawing\", \"Field journal\", \"Inventory card\", \"Photograph\", \"Photographic negative\", \"Plan or elevation\", \"Report\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Classification of an original archival document that has been digitized (e.g. drawing, photograph, report, etc.)\", \"external_view\": 1, \"advanced_search\": 1, \"external_search\": 1, \"viewable_in_results\": 1}, \"Pages_1_3_\": {\"name\": \"Pages\", \"type\": \"Text\", \"default\": null, \"options\": {\"Regex\": \"\", \"MultiLine\": \"0\"}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Number of pages in the document or resource.\\n\\nUse numeric expression only.\\n\\nUse for all resources in repository including documents, images, maps, and photographs.\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}, \"Title_1_3_\": {\"name\": \"Title\", \"type\": \"Text\", \"default\": null, \"options\": {\"Regex\": \"\", \"MultiLine\": \"1\"}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 1, \"description\": \"Titles, identifying phrases, or names given to an original archival document that has been digitized\\r\\n\\r\\nUse only for titled pieces. \\r\\nARCS will NOT use an invented or created title for untitled resources.\\r\\n\", \"external_view\": 1, \"advanced_search\": 1, \"external_search\": 1, \"viewable_in_results\": 1}, \"Legacy_1_3_\": {\"name\": \"Legacy\", \"type\": \"List\", \"default\": null, \"options\": {\"Options\": [\"TRUE\", \"FALSE\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Administrative field for ARCS to record if data is from legacy database\", \"external_view\": 0, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 0}, \"Orphan_1_3_\": {\"name\": \"Orphan\", \"type\": \"List\", \"default\": null, \"options\": {\"Options\": [\"TRUE\", \"FALSE\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 1, \"description\": \"Indicates that the Resource record is not associated or linked to the appropriate Excavation - Survey or Season record. \\r\\n\\r\\nTRUE=Not Associated to  Excavation - Survey or Season record \\r\\nFALSE=Associated to appropriate  Excavation - Survey or Season recor\", \"external_view\": 0, \"advanced_search\": 0, \"external_search\": 1, \"viewable_in_results\": 0}, \"Rights_1_3_\": {\"name\": \"Rights\", \"type\": \"Text\", \"default\": \"Creative Commons Attribution-NonCommercial 4.0 International (CC BY-NC 4.0)\", \"options\": {\"Regex\": \"\", \"MultiLine\": \"1\"}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Information about rights management; may include copyright and other intellectual property statements required for use regarding the resource and/or its associated electronic file.\\n\\nDefault: Creative Commons Attribution-NonCommercial 4.0 International\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}, \"Creator_1_3_\": {\"name\": \"Creator\", \"type\": \"Multi-Select List\", \"default\": null, \"options\": {\"Options\": [\"Anderson, Candace E.\", \"Barletta, Barbara\", \"Batcheller, James\", \"Bauslaugh, Robert\", \"Blackmore, Judy\", \"Bleistein, Charlene\", \"Bogle, Cynthia\", \"Bolas, B.\", \"Bolas, Barbara\", \"Bowman, Michael\", \"Broneer, Oscar\", \"Brunner, Judith\", \"Camp II, John\", \"Camp, Margot\", \"Card, Sandra\", \"Carpenter, J. D.\", \"Cassimatis, Maria\", \"Clement, Paul\", \"Cummer, W. Wilson\", \"DeForest, Dallas\", \"Dinsmoor, Jr., William Bell\", \"Downs, Joanie\", \"Farnsworth, Marie\", \"Feder, Debbie\", \"Frankhauser, Sarah\", \"Frey, Jon M.\", \"Gais, Ruth\", \"Giesen, Myra J.\", \"Gill, Alyson A.\", \"Greenberg, Barbara Bolas\", \"Gregory, Adelia E.\", \"Gregory, Timothy E.\", \"Grigoryan, Anait\", \"Guven, Suna\", \"Harris, A.\", \"Hartswick, Kim J.\", \"Howell, Jesse\", \"Hull, Don\", \"Hull, Susan\", \"Jacoby, Tom\", \"Jameson, Matthew\", \"Johnson, Matthew\", \"Kaljakin, Tania\", \"Kallemeyer, Susan\", \"Kardulias, P. Nick\", \"Kaye, Kenneth\", \"Keating, Richard\", \"Kieit, S.\", \"Kouvaris, Michael S.\", \"Lanham, Carol\", \"Leander-Touati, Anne-Marie\", \"Lease, L.\", \"Liddle, G.\", \"Lindros-Wohl, Birgitta\", \"Long, Andrea\", \"Luongo, C.\", \"Marty, Jeanne M.\", \"McCaslin, Dan\", \"McClure, Robert\", \"McGrew, Ellen\", \"Mitchell, Maria\", \"Moore, Allen\", \"Moore, Debra W.\", \"Mucha, Ashley E.\", \"Nash, Scott\", \"Nicols, John\", \"Okin, Louis\", \"Pallas, Demetrios\", \"Pattengale, Jerry\", \"Peirce, Sarah\", \"Peppers, Anne Beaton\", \"Peppers, James\", \"Peppers, Jeanne Marty\", \"Pettegrew, David\", \"Pettegrew, Kate\", \"Pierce, Charles\", \"Platz, Ralph\", \"Pollak, Barbara A.\", \"Porter, Alexander\", \"Rife, Joseph L.\", \"Rothaus, Richard M.\", \"Rudrick, Anna M.\", \"Sarefield, Daniel\", \"Sasel, Marjeta\", \"Schaar, Kenneth W.\", \"Scott, Ruth\", \"Semeli S.\", \"Shaw, Joseph W.\", \"Silberberg, Susan R.\", \"Snively, Carolyn\", \"Stein, Carol A.\", \"Swain, Brian\", \"Tache, Hannah\", \"Thorne, Margaret MacVeagh\", \"Thorne, Stuart E.\", \"Tzortzoupolou-Gregory, Lita\", \"Vernon, Catherine\", \"von Sternberg, Meri\", \"Walker, B.\", \"Walters, Elizabeth J.\", \"Wilson, David\", \"Wittman, Barbara\", \"Wittmann, Barbara K.\", \"Wohl, Birgitta\", \"Zidar, Charles M.\", \"Zuckerman, T. B.\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Name or other unique identification of a known person or persons who created an original archival document that has been digitized\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}, \"Creator2_1_3_\": {\"name\": \"Creator2\", \"type\": \"Generated List\", \"default\": null, \"options\": {\"Regex\": \"\", \"Options\": [\"Please Modify List Values\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"For creators with initials only\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}, \"Language_1_3_\": {\"name\": \"Language\", \"type\": \"Multi-Select List\", \"default\": null, \"options\": {\"Options\": [\"English\", \"Greek\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Language(s) of the resource itself.\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}, \"Condition_1_3_\": {\"name\": \"Condition\", \"type\": \"List\", \"default\": \"Good\", \"options\": {\"Options\": [\"Good\", \"Fair\", \"Poor\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Description of damage to an original archival document that has been digitized\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}, \"Sub_title_1_3_\": {\"name\": \"Sub title\", \"type\": \"Text\", \"default\": null, \"options\": {\"Regex\": \"\", \"MultiLine\": \"0\"}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Subordinate title that provides additional information about the contents of original archival document that has been digitized \", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}, \"Date_Range_1_3_\": {\"name\": \"Date Range\", \"type\": \"Text\", \"default\": null, \"options\": {\"Regex\": \"\", \"MultiLine\": \"0\"}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Production date of an original archival document that has been digitized, expressed in a range for documents created during a span of time, for example field notebooks, expressed in yyyy/mm/dd - yyyy/mm/dd format. [USE ONLY FOR ISTHMIA ARCS.1 DATA]\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}, \"Dimensions_1_3_\": {\"name\": \"Dimensions\", \"type\": \"Generated List\", \"default\": null, \"options\": {\"Regex\": \"\", \"Options\": [\"Please Modify List Values\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Measured size of an original archival document that has been digitized\\n\\nIsthmia: Measurements for photographs, slides, negatives, maps and books are in meters written as whole numbers or decimal fractions to the nearest millimeter.\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}, \"Repository_1_3_\": {\"name\": \"Repository\", \"type\": \"List\", \"default\": \"The Ohio State University Isthmia Archives, Bryan, Ohio, USA\", \"options\": {\"Options\": [\"The Ohio State University Isthmia Archives, Bryan, Ohio, USA\", \"The Ohio State University Isthmia Archives\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"The name of the repository that is currently responsible for the resource including general institutional address (state/region, country)\\n\\n\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}, \"Description_1_3_\": {\"name\": \"Description\", \"type\": \"Text\", \"default\": null, \"options\": {\"Regex\": \"\", \"MultiLine\": \"1\"}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Characteristics of an original archival document that has been digitized\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}, \"Latest_Date_1_3_\": {\"name\": \"Latest Date\", \"type\": \"Historical Date\", \"default\": {\"day\": [\"[M]0[M]\", \"0\", \"[Y]0[Y]\"], \"era\": \"CE\", \"year\": [\"[M]0[M][D]0[D]\", \"0\", \"\"], \"month\": [\"\", \"0\", \"[D]0[D][Y]0[Y]\"], \"prefix\": \"\"}, \"options\": {\"End\": \"2070\", \"Start\": \"1900\", \"Format\": \"YYYYMMDD\", \"ShowEra\": 0, \"ShowPrefix\": 0}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Latest date for the creation of an original archival document that has been digitized, expressed in yyyy/mm/dd format.\\n\\nThis is used for archival documents created during a span of time, for example field notebooks.\\n\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 1, \"viewable_in_results\": 1}, \"Permissions_1_3_\": {\"name\": \"Permissions\", \"type\": \"List\", \"default\": null, \"options\": {\"Options\": [\"Public\", \"Member\", \"Special\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Specifies the type of users who can access this Resource record. Choices: Public [open web]; Member [logged into ARCS]; Special [designated by Admin]\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}, \"Creator_Role_1_3_\": {\"name\": \"Creator Role\", \"type\": \"Multi-Select List\", \"default\": [\"Trench Supervisor\"], \"options\": {\"Options\": [\"Architect\", \"Archivist\", \"Assistant Director\", \"Conservator\", \"Director\", \"Excavator\", \"Field Director\", \"Photographer\", \"Student Volunteer\", \"Trench Supervisor\", \"Registrar\", \"Field Coordinator\", \"Draftsman\", \"Volunteer\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Part played by resource creator.\\r\\n\\r\\nRole must be ordered appropriately to correspond with person identified in \\\"Creator\\\" field.\", \"external_view\": 1, \"advanced_search\": 1, \"external_search\": 0, \"viewable_in_results\": 1}, \"Season_Title_1_3_\": {\"name\": \"Season Title\", \"type\": \"Text\", \"default\": null, \"options\": {\"Regex\": \"\", \"MultiLine\": \"0\"}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Include the name given to the season exactly as it is recorded in the Title field in the Season scheme. This will create a link b/w this Resource and the appropriate Season it belongs to.\\r\\n\\r\\nRedundant data for batch upload.\", \"external_view\": 0, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 0}, \"Special_User_1_3_\": {\"name\": \"Special User\", \"type\": \"Text\", \"default\": null, \"options\": {\"Regex\": \"\", \"MultiLine\": \"0\"}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Information about the person or people who have rights to access record and related metadata and digital files.\\r\\n\\r\\nARCS Admin designates \\\"Special Permission\\\" users.\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}, \"Earliest_Date_1_3_\": {\"name\": \"Earliest Date\", \"type\": \"Historical Date\", \"default\": {\"day\": [\"[M]0[M]\", \"0\", \"[Y]0[Y]\"], \"era\": \"CE\", \"year\": [\"[M]0[M][D]0[D]\", \"0\", \"\"], \"month\": [\"\", \"0\", \"[D]0[D][Y]0[Y]\"], \"prefix\": \"\"}, \"options\": {\"End\": \"2020\", \"Start\": \"1900\", \"Format\": \"YYYYMMDD\", \"ShowEra\": 0, \"ShowPrefix\": 0}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Production date of an original archival document that has been digitized, expressed in yyyy/mm/dd format\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 1, \"viewable_in_results\": 1}, \"Rights_Holder_1_3_\": {\"name\": \"Rights Holder\", \"type\": \"Multi-Select List\", \"default\": null, \"options\": {\"Options\": [\"tests rights holder\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Person or organization owning or managing rights over the resource.\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}, \"Transcription_1_3_\": {\"name\": \"Transcription\", \"type\": \"Text\", \"default\": null, \"options\": {\"Regex\": \"\", \"MultiLine\": \"0\"}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Typed representation of words written in and/or on the document or resource.\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}, \"Creator_Role_2_1_3_\": {\"name\": \"Creator Role 2\", \"type\": \"Multi-Select List\", \"default\": null, \"options\": {\"Options\": [\"Architect\", \"Archivist\", \"Assistant Director\", \"Conservator\", \"Director\", \"Excavator\", \"Field Director\", \"Photographer\", \"Student Volunteer\", \"Trench Supervisor\", \"Registrar\", \"Field Coordinator\", \"Draftsman\", \"Volunteer\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}, \"Accession_Number_1_3_\": {\"name\": \"Accession Number\", \"type\": \"Text\", \"default\": null, \"options\": {\"Regex\": \"\", \"MultiLine\": \"0\"}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Any unique identifiers assigned to an original archival document that has been digitized by the current or last known repository\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 1, \"viewable_in_results\": 1}, \"Season_Associator_1_3_\": {\"name\": \"Season Associator\", \"type\": \"Associator\", \"default\": null, \"options\": {\"SearchForms\": [{\"flids\": [], \"form_id\": \"32\"}]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 1, \"description\": \"KORA identifier for the Season record that describes the period of time (season/campaign) when the archival object described in this Resource record was found.\\n\\nOnly use for Resources like surface finds that are not tied to an Excavation / Survey.\", \"external_view\": 1, \"advanced_search\": 1, \"external_search\": 1, \"viewable_in_results\": 1}, \"Resource_Identifier_1_3_\": {\"name\": \"Resource Identifier\", \"type\": \"Text\", \"default\": null, \"options\": {\"Regex\": \"\", \"MultiLine\": \"\"}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 1, \"description\": \"Unambiguous reference to a resource with in a given context.\\r\\n\\r\\nIsthmia: resource dependent code that uniquely identifies a an artifact or archival document\", \"external_view\": 1, \"advanced_search\": 1, \"external_search\": 1, \"viewable_in_results\": 1}, \"Excavation_Survey_Name_1_3_\": {\"name\": \"Excavation Survey Name\", \"type\": \"Text\", \"default\": null, \"options\": {\"Regex\": \"\", \"MultiLine\": \"0\"}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Include the name given to the excavation exactly as it is recorded in the Name field in the Excavation - Survey scheme. This will create a link b/w this Resource and the appropriate Excavation record it belongs to.\\n\\nRedundant data for batch upload.\", \"external_view\": 0, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 0}, \"Excavation_Survey_Associator_1_3_\": {\"name\": \"Excavation Survey Associator\", \"type\": \"Associator\", \"default\": null, \"options\": {\"SearchForms\": [{\"flids\": [], \"form_id\": \"36\"}]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 1, \"description\": \"KORA identifier for the Excavation / Survey record that describes the field data collection unit when the archival object described in this Resource record was found.\", \"external_view\": 1, \"advanced_search\": 1, \"external_search\": 1, \"viewable_in_results\": 1}}}','2020-03-26 14:36:19','2020-03-26 14:36:19'),(4,1,'Pages','Pages_1_4_','Technical and organizational information about a single scanned page of the digitized archival document',7,1,'{\"pages\": [{\"flids\": [\"Page_Identifier_1_4_\", \"Resource_Identifier_1_4_\", \"Resource_Associator_1_4_\", \"Format_1_4_\", \"Type_1_4_\", \"Scan_Number_1_4_\", \"Image_Upload_1_4_\", \"Scan_Specifications_1_4_\", \"Scan_Equipment_1_4_\", \"Scan_Date_1_4_\", \"Scan_Creator_1_4_\", \"Scan_Creator_Status_1_4_\", \"Orphan_1_4_\", \"id_1_4_\", \"Legacy_1_4_\", \"Display_1_4_\"], \"title\": \"Pages\"}], \"fields\": {\"id_1_4_\": {\"name\": \"id\", \"type\": \"Text\", \"default\": null, \"options\": {\"Regex\": \"\", \"MultiLine\": \"0\"}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Administrative field for ARCS to record  legacy database id\", \"external_view\": 0, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 0}, \"Type_1_4_\": {\"name\": \"Type\", \"type\": \"List\", \"default\": null, \"options\": {\"Options\": [\"StillImage\", \"Text\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Broad term describing the nature or genre of digital file\\n\\nStillImage = Static visual representation other than text (used for drawings, plans, maps)\\n\\nText = Consisting primary of words for reading\", \"external_view\": 0, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 0}, \"Format_1_4_\": {\"name\": \"Format\", \"type\": \"List\", \"default\": null, \"options\": {\"Options\": [\"jpeg\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Digital or electronic format of the access or distribution file of the resource.\", \"external_view\": 0, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 0}, \"Legacy_1_4_\": {\"name\": \"Legacy\", \"type\": \"List\", \"default\": null, \"options\": {\"Options\": [\"TRUE\", \"FALSE\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Administrative field for ARCS to record if data is from legacy database\", \"external_view\": 0, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 0}, \"Orphan_1_4_\": {\"name\": \"Orphan\", \"type\": \"List\", \"default\": null, \"options\": {\"Options\": [\"TRUE\", \"FALSE\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 1, \"description\": \"Used during batch upload of image files to indicate that the Pages record is not associated or linked to the appropriate Resource record.\\n\\nTRUE=Not Associated to Resource record\\nFALSE=Associated to appropriate Resource record\", \"external_view\": 0, \"advanced_search\": 0, \"external_search\": 1, \"viewable_in_results\": 0}, \"Display_1_4_\": {\"name\": \"Display\", \"type\": \"List\", \"default\": null, \"options\": {\"Options\": [\"TRUE\", \"FALSE\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Indicate if this record can be displayed on the website.\", \"external_view\": 0, \"advanced_search\": 1, \"external_search\": 0, \"viewable_in_results\": 0}, \"Scan_Date_1_4_\": {\"name\": \"Scan Date\", \"type\": \"Historical Date\", \"default\": {\"day\": [\"[M]0[M]\", \"0\", \"[Y]0[Y]\"], \"era\": \"CE\", \"year\": [\"[M]0[M][D]0[D]\", \"0\", \"\"], \"month\": [\"\", \"0\", \"[D]0[D][Y]0[Y]\"], \"prefix\": \"\"}, \"options\": {\"End\": \"2070\", \"Start\": \"1970\", \"Format\": \"YYYYMMDD\", \"ShowEra\": 0, \"ShowPrefix\": 0}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"\\r\\nProduction date of the electronic file, expressed in yyyy/mm/dd format\", \"external_view\": 0, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 0}, \"Scan_Number_1_4_\": {\"name\": \"Scan Number\", \"type\": \"Integer\", \"default\": \"1\", \"options\": {\"Max\": \"\", \"Min\": \"1\", \"Unit\": \"\"}, \"alt_name\": \"\", \"required\": 1, \"viewable\": 1, \"searchable\": 1, \"description\": \"Number indicating the scan sequence for a resource\\r\\n\\r\\nBegin sequence with 1, for the first scan of resource, followed by 2, 3, and 4\", \"external_view\": 1, \"advanced_search\": 1, \"external_search\": 1, \"viewable_in_results\": 1}, \"Image_Upload_1_4_\": {\"name\": \"Image Upload\", \"type\": \"Gallery\", \"default\": null, \"options\": {\"MaxFiles\": null, \"FieldSize\": null, \"FileTypes\": [\"image/bmp\", \"image/gif\", \"image/jpeg\", \"image/png\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Upload jpeg image file of scanned archival document.\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}, \"Scan_Creator_1_4_\": {\"name\": \"Scan Creator\", \"type\": \"Text\", \"default\": null, \"options\": {\"Regex\": \"\", \"MultiLine\": \"0\"}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 1, \"description\": \"Name or other unique identification of a known person responsible for the creation of the electronic file.\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 1, \"viewable_in_results\": 1}, \"Scan_Equipment_1_4_\": {\"name\": \"Scan Equipment\", \"type\": \"Text\", \"default\": null, \"options\": {\"Regex\": \"\", \"MultiLine\": \"0\"}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Name or other unique identifier of the device used to create an electronic file.\\n\\nData types and formats:\\nScanner or digital camera brand, name, and model number; \\nsoftware name and version\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}, \"Page_Identifier_1_4_\": {\"name\": \"Page Identifier\", \"type\": \"Text\", \"default\": null, \"options\": {\"Regex\": \"\", \"MultiLine\": \"\"}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 1, \"description\": \"Unique numeric or alphanumeric identification\\r\\n\\r\\nAlpha/numeric character string of file name for page including file extension.\", \"external_view\": 1, \"advanced_search\": 1, \"external_search\": 1, \"viewable_in_results\": 1}, \"Resource_Associator_1_4_\": {\"name\": \"Resource Associator\", \"type\": \"Associator\", \"default\": null, \"options\": {\"SearchForms\": [{\"flids\": [], \"form_id\": \"33\"}]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 1, \"description\": \"KORA identifier for the Resource record that this Pages record is part of.\\r\\n\\r\\nThis Pages record contains a digital file and technical metadata for 1 scanned page of the referenced Resource.\", \"external_view\": 1, \"advanced_search\": 1, \"external_search\": 1, \"viewable_in_results\": 1}, \"Resource_Identifier_1_4_\": {\"name\": \"Resource Identifier\", \"type\": \"Text\", \"default\": null, \"options\": {\"Regex\": \"\", \"MultiLine\": \"0\"}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 1, \"description\": \"Unique identifier given to the original archival resource that has been scanned. This is the same as RESOURCE.Resource Identifier\\n\\nIsthmia: resource dependent code that uniquely identifies a an artifact or archival document\", \"external_view\": 1, \"advanced_search\": 1, \"external_search\": 1, \"viewable_in_results\": 1}, \"Scan_Creator_Status_1_4_\": {\"name\": \"Scan Creator Status\", \"type\": \"List\", \"default\": \"Public\", \"options\": {\"Options\": [\"Public\", \"Private\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Information concerning whether the identification of a known person may appear in a publicly accessible format.\\r\\n\\r\\nPublic = Display name on website\\r\\nPrivate = Do not display name\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}, \"Scan_Specifications_1_4_\": {\"name\": \"Scan Specifications\", \"type\": \"Text\", \"default\": null, \"options\": {\"Regex\": \"\", \"MultiLine\": \"0\"}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Description of the dimensions, resolution, type of digitization and any other information pertinent to the creation of the electronic file.\\nData types and formats:\\nBit-depth (e.g., 8-bit, 16-bit, 24-bit, etc.); \\ncolor mode (e.g., RGB, CMYK, or grayscale);\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}}}','2020-03-26 14:36:19','2020-03-26 14:36:20'),(5,1,'Subject of Observation','Subject_of_Observation_1_5_','Information about the archeological item that is the topic of study in the original archival document (i.e. topic or subject of the inventory card).',9,1,'{\"pages\": [{\"flids\": [\"Pages_Associator_1_5_\", \"Resource_Identifier_1_5_\", \"Subject_of_Observation_Associator_1_5_\", \"Artifact_Structure_Classification_1_5_\", \"Artifact_Structure_Type_1_5_\", \"Artifact_Structure_Type_Qualifier_1_5_\", \"Artifact_Structure_Material_1_5_\", \"Artifact_Structure_Technique_1_5_\", \"Artifact_Structure_Archaeological_Culture_1_5_\", \"Artifact_Structure_Period_1_5_\", \"Artifact_Structure_Terminus_Ante_Quem_1_5_\", \"Artifact_Structure_Terminus_Post_Quem_1_5_\", \"Orphan_1_5_\"], \"title\": \"General Description\"}, {\"flids\": [\"Artifact_Structure_Title_1_5_\", \"Artifact_Structure_Current_Location_1_5_\", \"Artifact_Structure_Repository_1_5_\", \"Artifact_Structure_Repository_Accession_Number_1_5_\", \"Artifact_Structure_Creator_1_5_\", \"Artifact_Structure_Creator_Role_1_5_\", \"Artifact_Structure_Dimensions_1_5_\", \"Artifact_Structure_Geolocation_1_5_\", \"Artifact_Structure_Excavation_Unit_1_5_\", \"Artifact_Structure_Location_1_5_\", \"Artifact_Structure_Description_1_5_\", \"Artifact_Structure_Condition_1_5_\", \"Artifact_Structure_Inscription_1_5_\", \"Artifact_Structure_Munsell_Number_1_5_\", \"Artifact_Structure_Date_1_5_\", \"Artifact_Structure_Subject_1_5_\", \"Artifact_Structure_Origin_1_5_\", \"Artifact_Structure_Comparanda_1_5_\", \"Artifact_Structure_Archaeological_Context_1_5_\", \"Artifact_Structure_Shelving_Location_1_5_\", \"Trench_1_5_\", \"Page_Identifier_1_5_\"], \"title\": \"Detailed Description\"}, {\"flids\": [\"id_1_5_\", \"Legacy_1_5_\", \"Display_1_5_\"], \"title\": \"Legacy\"}], \"fields\": {\"id_1_5_\": {\"name\": \"id\", \"type\": \"Text\", \"default\": null, \"options\": {\"Regex\": \"\", \"MultiLine\": \"0\"}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 1, \"viewable_in_results\": 0}, \"Legacy_1_5_\": {\"name\": \"Legacy\", \"type\": \"List\", \"default\": null, \"options\": {\"Options\": [\"TRUE\", \"FALSE\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"\", \"external_view\": 0, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 0}, \"Orphan_1_5_\": {\"name\": \"Orphan\", \"type\": \"List\", \"default\": null, \"options\": {\"Options\": [\"TRUE\", \"FALSE\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Indicates that the Subject of Observation record is not associated or linked to the appropriate Resource record. \\r\\n\\r\\nTRUE=Not Associated to Resource record \\r\\nFALSE=Associated to appropriate Resource record\", \"external_view\": 1, \"advanced_search\": \"1\", \"external_search\": 1, \"viewable_in_results\": 0}, \"Trench_1_5_\": {\"name\": \"Trench\", \"type\": \"Generated List\", \"default\": null, \"options\": {\"Regex\": \"\", \"Options\": [\"Please Modify List Values\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"For Isthmia, redundant reference for Name of Trench found in Excavation - Survey scheme \", \"external_view\": 1, \"advanced_search\": \"1\", \"external_search\": 1, \"viewable_in_results\": 0}, \"Display_1_5_\": {\"name\": \"Display\", \"type\": \"List\", \"default\": null, \"options\": {\"Options\": [\"TRUE\", \"FALSE\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"\", \"external_view\": 0, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 0}, \"Page_Identifier_1_5_\": {\"name\": \"Page Identifier\", \"type\": \"Text\", \"default\": null, \"options\": {\"Regex\": \"\", \"MultiLine\": \"0\"}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Include the unique identifier given to the the scanned page exactly as recorded in the Page Identifier field in the Pages scheme. This will create a link between this SOO record and the Pages record it describes.\\r\\n\\r\\nRedundant data for batch upload.\", \"external_view\": 1, \"advanced_search\": 1, \"external_search\": 1, \"viewable_in_results\": 0}, \"Pages_Associator_1_5_\": {\"name\": \"Pages Associator\", \"type\": \"Associator\", \"default\": null, \"options\": {\"SearchForms\": [{\"flids\": [\"Resource_Identifier_11_33_\"], \"form_id\": \"33\"}, {\"flids\": [\"Resource_Identifier_11_34_\"], \"form_id\": \"34\"}]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 1, \"description\": \"KORA identifier for the specific page of the Resource that this Subject of Observation record describes.\", \"external_view\": 1, \"advanced_search\": 1, \"external_search\": 1, \"viewable_in_results\": 1}, \"Resource_Identifier_1_5_\": {\"name\": \"Resource Identifier\", \"type\": \"Text\", \"default\": null, \"options\": {\"Regex\": \"\", \"MultiLine\": \"0\"}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 1, \"description\": \"Unique identifier given to the original archival resource that has been scanned. This is the same as RESOURCE.Resource Identifier.\\n\\nIsthmia: resource dependent code that uniquely identifies a an artifact or archival document \", \"external_view\": 1, \"advanced_search\": \"1\", \"external_search\": 1, \"viewable_in_results\": 1}, \"Artifact_Structure_Date_1_5_\": {\"name\": \"Artifact Structure Date\", \"type\": \"Historical Date\", \"default\": {\"day\": [\"[M]0[M]\", \"0\", \"[Y]0[Y]\"], \"era\": \"CE\", \"year\": [\"[M]0[M][D]0[D]\", \"0\", \"\"], \"month\": [\"\", \"0\", \"[D]0[D][Y]0[Y]\"], \"prefix\": \"\"}, \"options\": {\"End\": \"2020\", \"Start\": \"1\", \"Format\": \"MMDDYYYY\", \"ShowEra\": 1, \"ShowPrefix\": 0}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Production date of object; only to be used when a specific date is known.  Otherwise, Terminus ante and post quem should be used\", \"external_view\": \"1\", \"advanced_search\": \"1\", \"external_search\": \"1\", \"viewable_in_results\": 0}, \"Artifact_Structure_Type_1_5_\": {\"name\": \"Artifact Structure Type\", \"type\": \"Multi-Select List\", \"default\": null, \"options\": {\"Options\": [\"Amphora\", \"Antefix\", \"Ashlar\", \"Base\", \"Basin\", \"Bead\", \"Block\", \"Body Sherd\", \"Bottle\", \"Bowl\", \"Brick\", \"Buckle\", \"Capital\", \"Casserole\", \"Coin\", \"Column Base\", \"Column shaft\", \"Cooking pot\", \"Cornice\", \"Crown moulding\", \"Cup\", \"Dish\", \"Disk\", \"Drinking cup\", \"Epistyle\", \"Epistyle/frieze\", \"Figurine\", \"Flake\", \"Foot\", \"Foundation\", \"Fragment\", \"Frying pan\", \"Furnace ribbing\", \"Grill\", \"Gutta\", \"Hammer stone\", \"Hand stone\", \"Handle\", \"Hook\", \"Inscription\", \"Jug\", \"Kernos\", \"Kiln Foot\", \"Kiln lining\", \"Kiln support\", \"Knife blade\", \"Krater\", \"Lamp\", \"Lekanis\", \"Lekythos\", \"Lid\", \"Lime\", \"Loomweight\", \"Millstone\", \"Moulding\", \"Nail\", \"Neck\", \"Oinochoe\", \"Pantile\", \"Pendant\", \"Pin\", \"Pitcher\", \"Plate\", \"Polishing stone\", \"Pot\", \"Pyxis\", \"Rain spout\", \"Relief\", \"Revetment\", \"Rim\", \"Ring\", \"Ring foot\", \"Rooftile\", \"Rubble\", \"Sample\", \"Scotia\", \"Sculpture\", \"Sima\", \"Skyphos\", \"Spindle whorl\", \"Stewpot\", \"Stopper\", \"Strap\", \"Stucco\", \"Tablewear\", \"Tegula mammata\", \"Tessera\", \"Tile\", \"Toe\", \"Top\", \"Torus\", \"Trefoil\", \"Tube\", \"Unguentarium\", \"Vessel\", \"Votive\", \"Wall\", \"Water Jar\", \"Wire\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 1, \"description\": \"Physical characteristic of artifact or structure.\", \"external_view\": 1, \"advanced_search\": \"1\", \"external_search\": 1, \"viewable_in_results\": 1}, \"Artifact_Structure_Title_1_5_\": {\"name\": \"Artifact Structure Title\", \"type\": \"Text\", \"default\": null, \"options\": {\"Regex\": \"\", \"MultiLine\": \"1\"}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Titles, identifying phrases, or names given to an artifact or structure.\", \"external_view\": 1, \"advanced_search\": \"1\", \"external_search\": 1, \"viewable_in_results\": 1}, \"Artifact_Structure_Origin_1_5_\": {\"name\": \"Artifact Structure Origin\", \"type\": \"List\", \"default\": null, \"options\": {\"Options\": [\"Please Modify List Values\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Original production location of artifact or structure.\", \"external_view\": \"1\", \"advanced_search\": \"1\", \"external_search\": \"1\", \"viewable_in_results\": 0}, \"Artifact_Structure_Period_1_5_\": {\"name\": \"Artifact Structure Period\", \"type\": \"Multi-Select List\", \"default\": null, \"options\": {\"Options\": [\"Archaic\", \"Byzantine\", \"Classical\", \"Early Bronze Age\", \"Frankish\", \"Geometric\", \"Hellenistic\", \"Late Bronze Age\", \"Modern\", \"Neolithic\", \"Orientalizing\", \"Ottoman\", \"Roman Imperial\", \"Roman Republican\", \"Venetian\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Named, defined portion of time whose characteristics are represented in the artifact or structure.\", \"external_view\": 1, \"advanced_search\": \"1\", \"external_search\": 1, \"viewable_in_results\": 0}, \"Artifact_Structure_Creator_1_5_\": {\"name\": \"Artifact Structure Creator\", \"type\": \"Multi-Select List\", \"default\": null, \"options\": {\"Options\": [\"Unknown\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Name or other unique identification of a known creator of the artifact or structure.\", \"external_view\": 1, \"advanced_search\": \"1\", \"external_search\": 1, \"viewable_in_results\": 0}, \"Artifact_Structure_Subject_1_5_\": {\"name\": \"Artifact Structure Subject\", \"type\": \"Multi-Select List\", \"default\": null, \"options\": {\"Options\": [\"test structure subject\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"General term(s) that identity the content or topic of a work of art; it is what is depicted in and by a work of art. It can also identify the function of an artifact or structure (architecture) that does not have narrative content.\", \"external_view\": 1, \"advanced_search\": 1, \"external_search\": 1, \"viewable_in_results\": 1}, \"Artifact_Structure_Location_1_5_\": {\"name\": \"Artifact Structure Location\", \"type\": \"Multi-Select List\", \"default\": null, \"options\": {\"Options\": [\"Architecture\", \"Area Northwest of Temple\", \"Bones\", \"Broneer Excavation Dump\", \"Decauville Graves\", \"Dump\", \"Early Stadium\", \"East Field\", \"Field Notes\", \"Filis Area\", \"Fortress\", \"Fortress Stairways\", \"Fortress Tower\", \"Fortress Tower 5\", \"Fortress Wall\", \"Gellis Wall\", \"Gully Bastion\", \"Gully Bastion Grave 2\", \"Hexamilion\", \"Hexamillion Outworks\", \"House of Dimitrios Spanos\", \"Iconic Base\", \"IΣ Box 2\", \"Lambrou Cemetery\", \"Later Stadium\", \"Loukos\", \"Loukos Dump\", \"Loukos Grave\", \"N of T1 Wall\", \"National Road\", \"North Drain\", \"Northeast Gate\", \"Northwest Gate\", \"Northwest Precinct\", \"Northwest Reservoir\", \"Roman Bath\", \"Sanctuary of Poseidon\", \"South Gate\", \"Stadium\", \"Stray Find\", \"Surface Find\", \"Temple\", \"Theater\", \"Theater Court\", \"Theater Court 2\", \"Tower 2\", \"Tower 5\", \"Tower 6\", \"Tower 10\", \"Tower 14\", \"Tower 15\", \"West Cemetery\", \"Theatre\", \"Area Southwest of Stadium\", \"Northwest of Temple\", \"Unknown\", \"Tower 18\", \"Dump: 1969-72\", \"Justinian\'s Fortress Tower 14\", \"Justinian\'s Fortress\", \"Justinian\'s Wall Tower 14\", \"Surface\", \"Ionic Base\", \"Fortress Tower 15\", \"Fortress Tower 2\", \"Agios Vasilios\", \"Site\", \"North of Temple\", \"Area North of Temple\", \"Gate\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Project specific name for spatial location of artifact / structure was first discovered\", \"external_view\": 1, \"advanced_search\": \"1\", \"external_search\": \"1\", \"viewable_in_results\": 1}, \"Artifact_Structure_Material_1_5_\": {\"name\": \"Artifact Structure Material\", \"type\": \"Multi-Select List\", \"default\": null, \"options\": {\"Options\": [\"Attic Clay\", \"Bone (Human)\", \"Brick\", \"Bronze\", \"Carbon\", \"Cement\", \"Ceramic\", \"Charcoal\", \"Clay\", \"Coarse clay with small voids , brown stone\", \"Coarse fabric, variously colored stones\", \"Coarse red clay\", \"Concrete\", \"Copper\", \"Corinthian Clay\", \"Cornice Block\", \"Enamel\", \"English\", \"Faince\", \"Faunal\", \"Floral / Wood\", \"Fragment of Volute\", \"Fresco\", \"Gem\", \"Glass\", \"Gold\", \"Green Glass\", \"Green Marble\", \"Grey Limestone\", \"Hard light orange-red clay with glaze on interior\", \"Hard orange-red clay\", \"Hydraulic Cement\", \"Iron\", \"Lead\", \"Leather\", \"Limestone\", \"Lithic / Stone\", \"Marble\", \"Masonry\", \"Metal\", \"Mica\", \"Mortar\", \"Mortar and Rubble\", \"Mosaic\", \"Obsidian\", \"Other\", \"Pigment\", \"Plaster\", \"Poros\", \"Poros Brick\", \"Poros Limestone\", \"Pottery\", \"Red Clay\", \"Red Marble\", \"Sandstone\", \"Schist\", \"Shell\", \"Silver\", \"Slate\", \"Soft Brown Clay\", \"Stone\", \"Stone in cement\", \"Stucco\", \"Terracotta\", \"Terracotta Brick\", \"Textile\", \"Tile\", \"Waterproof Cement\", \"White Marble\", \"N/A\", \"Unknown\", \"Fabric\", \"Green Glaze\", \"Poros Block\", \"Bone\", \"Hard Micaeceous red brown clay\", \"Hard Buff Clay\", \"Coarse, orange-brown clay\", \"Byzantine\", \"Billon\", \"Hard, coarse, red-brown clay\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Matter from which the artifact or structure has been produced.\", \"external_view\": 1, \"advanced_search\": \"1\", \"external_search\": 1, \"viewable_in_results\": 0}, \"Artifact_Structure_Condition_1_5_\": {\"name\": \"Artifact Structure Condition\", \"type\": \"Multi-Select List\", \"default\": null, \"options\": {\"Options\": [\"Broken\", \"Burned\", \"Eroded\", \"Fragmentary\", \"Misfired\", \"Restored\", \"Vitrified\", \"Whole\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Description of current physical state of artifact or structure\", \"external_view\": \"1\", \"advanced_search\": \"1\", \"external_search\": \"1\", \"viewable_in_results\": 0}, \"Artifact_Structure_Technique_1_5_\": {\"name\": \"Artifact Structure Technique\", \"type\": \"Multi-Select List\", \"default\": null, \"options\": {\"Options\": [\"Chiseled\", \"Drafted\", \"Fired\", \"Flaked\", \"Flanged\", \"Fluted\", \"Forged\", \"Glazed\", \"Grooved\", \"Ground\", \"Heat treated\", \"Incised\", \"Moldmade\", \"Painted\", \"Slipped\", \"Slumped\", \"Stamped\", \"Struck\", \"Sun-dried\", \"Wheel-ridged\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Manner of production of artifact or structure\", \"external_view\": 1, \"advanced_search\": \"1\", \"external_search\": 1, \"viewable_in_results\": 0}, \"Artifact_Structure_Comparanda_1_5_\": {\"name\": \"Artifact Structure Comparanda\", \"type\": \"Text\", \"default\": null, \"options\": {\"Regex\": \"\", \"MultiLine\": \"1\"}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Published examples of other artifacts or structures that are similar in type or style.\", \"external_view\": \"1\", \"advanced_search\": \"1\", \"external_search\": \"1\", \"viewable_in_results\": 0}, \"Artifact_Structure_Dimensions_1_5_\": {\"name\": \"Artifact Structure Dimensions\", \"type\": \"Generated List\", \"default\": null, \"options\": {\"Regex\": \"\", \"Options\": [\"Please Modify List Values\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Measured size or scale of the artifact or structure.\\n\\nIsthmia: Measurements for walls, coins, etc. are in meters written as whole numbers or decimal fractions to the nearest millimeter.\\n\\nRequired format: \\nheight: 0.280 m\", \"external_view\": 0, \"advanced_search\": \"1\", \"external_search\": \"1\", \"viewable_in_results\": 0}, \"Artifact_Structure_Repository_1_5_\": {\"name\": \"Artifact Structure Repository\", \"type\": \"List\", \"default\": \"OSU Isthmia Excavation House\", \"options\": {\"Options\": [\"OSU Isthmia Excavation House\", \"Isthmia Museum\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"The name of the repository that is currently responsible for the artifact or structure.\", \"external_view\": 1, \"advanced_search\": \"1\", \"external_search\": 1, \"viewable_in_results\": 1}, \"Artifact_Structure_Description_1_5_\": {\"name\": \"Artifact Structure Description\", \"type\": \"Text\", \"default\": null, \"options\": {\"Regex\": \"\", \"MultiLine\": \"1\"}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"General characteristics of an artifact or structure.\", \"external_view\": 1, \"advanced_search\": \"1\", \"external_search\": \"1\", \"viewable_in_results\": 1}, \"Artifact_Structure_Geolocation_1_5_\": {\"name\": \"Artifact Structure Geolocation\", \"type\": \"Generated List\", \"default\": null, \"options\": {\"Regex\": \"\", \"Options\": [\"Please Modify List Values\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Coordinate pair(s) (latitude and longitude) that establish a general location of project. \\n\\nFormatting: Latitude,Longitude for example: 41.255678,13.435335\", \"external_view\": 1, \"advanced_search\": \"1\", \"external_search\": \"1\", \"viewable_in_results\": 1}, \"Artifact_Structure_Inscription_1_5_\": {\"name\": \"Artifact Structure Inscription\", \"type\": \"Text\", \"default\": null, \"options\": {\"Regex\": \"\", \"MultiLine\": \"1\"}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Lettering marked on artifact, especially for documentation or commemoration\", \"external_view\": \"1\", \"advanced_search\": \"1\", \"external_search\": \"1\", \"viewable_in_results\": 0}, \"Artifact_Structure_Creator_Role_1_5_\": {\"name\": \"Artifact Structure Creator Role\", \"type\": \"Multi-Select List\", \"default\": null, \"options\": {\"Options\": [\"k3 test role\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 1, \"description\": \"Part played by artifact or structure creator.\", \"external_view\": 1, \"advanced_search\": 1, \"external_search\": 1, \"viewable_in_results\": 1}, \"Artifact_Structure_Classification_1_5_\": {\"name\": \"Artifact Structure Classification\", \"type\": \"List\", \"default\": null, \"options\": {\"Options\": [\"Arrentine\", \"Black Figure\", \"Candarli\", \"Coarseware\", \"Corinthian\", \"Diamond shaped\", \"Doric\", \"Eastern Sigillata A\", \"Eastern Sigillata B\", \"Fineware\", \"Floor tile\", \"Hydraulic\", \"Imitation\", \"Ionic\", \"Kitchen ware\", \"Megarian\", \"Micaceous\", \"Miniature\", \"Non-rotary\", \"Opus Sectile\", \"Plain ware\", \"Polygonal\", \"Pompeian Red\", \"Pontic Ware\", \"Red Figure\", \"Sgraffito\", \"Slavic\", \"Unknown\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 1, \"description\": \"Specific category of artifact or structure according to a stated system.\", \"external_view\": 1, \"advanced_search\": \"1\", \"external_search\": 1, \"viewable_in_results\": 1}, \"Artifact_Structure_Munsell_Number_1_5_\": {\"name\": \"Artifact Structure Munsell Number\", \"type\": \"Text\", \"default\": null, \"options\": {\"Regex\": \"\", \"MultiLine\": \"0\"}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Index number for artifact or structure color.\", \"external_view\": \"1\", \"advanced_search\": \"1\", \"external_search\": \"1\", \"viewable_in_results\": 0}, \"Artifact_Structure_Type_Qualifier_1_5_\": {\"name\": \"Artifact Structure Type Qualifier\", \"type\": \"Text\", \"default\": null, \"options\": {\"Regex\": \"\", \"MultiLine\": \"0\"}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Common and/or published system according to which an Artifact - Structure type has been determined.\", \"external_view\": 1, \"advanced_search\": \"1\", \"external_search\": 1, \"viewable_in_results\": 0}, \"Subject_of_Observation_Associator_1_5_\": {\"name\": \"Subject of Observation Associator\", \"type\": \"Associator\", \"default\": null, \"options\": {\"SearchForms\": [{\"flids\": [], \"form_id\": \"35\"}]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 1, \"description\": \"KORA identifier for the Subject of Observations record(s) that describe the exact same artifact/structure.\", \"external_view\": 1, \"advanced_search\": \"1\", \"external_search\": 1, \"viewable_in_results\": 1}, \"Artifact_Structure_Excavation_Unit_1_5_\": {\"name\": \"Artifact Structure Excavation Unit\", \"type\": \"Multi-Select List\", \"default\": null, \"options\": {\"Options\": [\"HEX-72-1\", \"HEX-72-2\", \"HEX-72-3\", \"HEX-72-4\", \"HEX-72-5\", \"HEX-72-6\", \"HEX-72-7\", \"HEX-72-8\", \"Trench 93-1\", \"Trench 95-6\", \"Trench 95-7\", \"Trench 2003-1\", \"Trench 2003-2\", \"Trench 2004-1\", \"Trench 2004-2\", \"Trench 2004-3\", \"Trench 2004-4\", \"Trench 2005-1\", \"Trench 2005-2\", \"Trench 2005-3\", \"Trench 2005-4\", \"Trench 2005-5\", \"Trench 2005-6\", \"Trench 2006-1\", \"Trench 2006-2\", \"Trench 2007-1\", \"Trench 2007-2\", \"Trench 2007-3\", \"Trench 2008-1\", \"Trench 2008-2\", \"Trench 2008-3\", \"Trench 2008-4\", \"Trench 2009-1\", \"Trench 2009-2\", \"Trench 2009-3\", \"Trench 2010-1\", \"Trench 2010-2\", \"Trench 2010-3\", \"Trench 2010-4\", \"Trench 2010-5\", \"Trench 2011-1\", \"Trench 2011-2\", \"Trench 2011-3\", \"Trench 2011-4\", \"Trench 2011-5\", \"Trench GB-70-1\", \"Trench GB-70-2\", \"Trench GB-70-3\", \"Trench GB-70-4\", \"Trench GB-70-5\", \"Trench GB-70-6\", \"Trench GB-70-7\", \"Trench GB-70-8\", \"Trench GB-70-9\", \"Trench GB-70-10\", \"Surface Find\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Pre-declared unit of excavated soil, known by a systematically assigned unique identifier.\\n\\nNot using for Isthmia.\", \"external_view\": 1, \"advanced_search\": \"1\", \"external_search\": \"1\", \"viewable_in_results\": 1}, \"Artifact_Structure_Current_Location_1_5_\": {\"name\": \"Artifact Structure Current Location\", \"type\": \"List\", \"default\": null, \"options\": {\"Options\": [\"Kyras Vrysi\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 1, \"description\": \"The geographic location of the repository that is currently responsible for the artifact or structure\", \"external_view\": 1, \"advanced_search\": \"1\", \"external_search\": 1, \"viewable_in_results\": 1}, \"Artifact_Structure_Shelving_Location_1_5_\": {\"name\": \"Artifact Structure Shelving Location\", \"type\": \"Text\", \"default\": null, \"options\": {\"Regex\": \"\", \"MultiLine\": \"0\"}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Shelf mark or other shelving designation that indicates the location where the physical artifact/structure is available (on a shelf or in cabinet, for example).\", \"external_view\": \"1\", \"advanced_search\": \"1\", \"external_search\": \"1\", \"viewable_in_results\": 0}, \"Artifact_Structure_Terminus_Ante_Quem_1_5_\": {\"name\": \"Artifact Structure Terminus Ante Quem\", \"type\": \"Historical Date\", \"default\": {\"day\": [\"[M]0[M]\", \"0\", \"[Y]0[Y]\"], \"era\": \"CE\", \"year\": [\"[M]0[M][D]0[D]\", \"0\", \"\"], \"month\": [\"\", \"0\", \"[D]0[D][Y]0[Y]\"], \"prefix\": \"\"}, \"options\": {\"End\": \"9999\", \"Start\": \"1\", \"Format\": \"MMDDYYYY\", \"ShowEra\": 1, \"ShowPrefix\": 0}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 1, \"description\": \"Date(s) before which an artifact  or structure could not have been produced\", \"external_view\": 1, \"advanced_search\": \"1\", \"external_search\": 1, \"viewable_in_results\": 1}, \"Artifact_Structure_Terminus_Post_Quem_1_5_\": {\"name\": \"Artifact Structure Terminus Post Quem\", \"type\": \"Historical Date\", \"default\": {\"day\": [\"[M]0[M]\", \"0\", \"[Y]0[Y]\"], \"era\": \"CE\", \"year\": [\"[M]0[M][D]0[D]\", \"0\", \"\"], \"month\": [\"\", \"0\", \"[D]0[D][Y]0[Y]\"], \"prefix\": \"\"}, \"options\": {\"End\": \"9999\", \"Start\": \"1\", \"Format\": \"MMDDYYYY\", \"ShowEra\": 1, \"ShowPrefix\": 0}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 1, \"description\": \"Date(s) after which an artifact or structure could not have been produced\", \"external_view\": 1, \"advanced_search\": \"1\", \"external_search\": 1, \"viewable_in_results\": 1}, \"Artifact_Structure_Archaeological_Context_1_5_\": {\"name\": \"Artifact Structure Archaeological Context\", \"type\": \"Text\", \"default\": null, \"options\": {\"Regex\": \"\", \"MultiLine\": \"1\"}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Three dimensional position of find, and its relationship to other elements in the site\'s archaeological record\", \"external_view\": \"1\", \"advanced_search\": \"1\", \"external_search\": \"1\", \"viewable_in_results\": 0}, \"Artifact_Structure_Archaeological_Culture_1_5_\": {\"name\": \"Artifact Structure Archaeological Culture\", \"type\": \"Multi-Select List\", \"default\": null, \"options\": {\"Options\": [\"Please Modify List Values\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Recognizable and recurring assemblage of artifacts from a specific time and place. Thought to constitute the material remains of a particular past human society or group\", \"external_view\": 1, \"advanced_search\": \"1\", \"external_search\": 1, \"viewable_in_results\": 1}, \"Artifact_Structure_Repository_Accession_Number_1_5_\": {\"name\": \"Artifact Structure Repository Accession Number\", \"type\": \"Text\", \"default\": null, \"options\": {\"Regex\": \"\", \"MultiLine\": \"0\"}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Any unique identifiers assigned to an artifact or structure by the current or last known repository\", \"external_view\": 1, \"advanced_search\": \"1\", \"external_search\": 1, \"viewable_in_results\": 0}}}','2020-03-26 14:36:20','2020-03-26 14:36:21'),(6,1,'Excavation - Survey','Excavation_-_Survey_1_6_','Information about 1 field data collection unit when archaeological research was conducted',11,1,'{\"pages\": [{\"flids\": [\"Season_Associator_1_6_\", \"Name_1_6_\", \"Type_1_6_\", \"Supervisor_1_6_\", \"Earliest_Date_1_6_\", \"Latest_Date_1_6_\", \"Terminus_Ante_Quem_1_6_\", \"Terminus_Post_Quem_1_6_\", \"Excavation_Stratigraphy_1_6_\", \"Survey_Conditions_1_6_\", \"Post_Dispositional_Transformation_1_6_\", \"Orphan_1_6_\", \"Season_Title_1_6_\"], \"title\": \"Excavation - Survey\"}, {\"flids\": [\"Legacy_1_6_\"], \"title\": \"Reference\"}], \"fields\": {\"Name_1_6_\": {\"name\": \"Name\", \"type\": \"Text\", \"default\": \"Trench GB-70-\", \"options\": {\"Regex\": \"\", \"MultiLine\": \"0\"}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 1, \"description\": \"Spatial section composed of material items and features, within codes developed for the project.\\n\\nUse a consistent format.\\n\\nIsthmia: YY-XXX-NN\\nYY is 2-digit code for year of excavation, XXX is 2 or 3 letter code for location, and NN is trench number\", \"external_view\": 1, \"advanced_search\": 1, \"external_search\": 1, \"viewable_in_results\": 1}, \"Type_1_6_\": {\"name\": \"Type\", \"type\": \"List\", \"default\": \"Trench\", \"options\": {\"Options\": [\"Trench\", \"Survey\", \"Study/Lab\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Type of excavation or survey (e.g. open area, test trench, intensive)\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 1, \"viewable_in_results\": 1}, \"Legacy_1_6_\": {\"name\": \"Legacy\", \"type\": \"List\", \"default\": null, \"options\": {\"Options\": [\"TRUE\", \"FALSE\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 1, \"description\": \"Reference control for legacy data ingestion\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 1, \"viewable_in_results\": 1}, \"Orphan_1_6_\": {\"name\": \"Orphan\", \"type\": \"List\", \"default\": null, \"options\": {\"Options\": [\"TRUE\", \"FALSE\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Indicates that the Excavation - Survey record is not associated or linked to the appropriate Season record. \\r\\n\\r\\nTRUE=Not Associated to Season record \\r\\nFALSE=Associated to appropriate Season record\", \"external_view\": 0, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 0}, \"Supervisor_1_6_\": {\"name\": \"Supervisor\", \"type\": \"Multi-Select List\", \"default\": [\"Card, Sandra\", \"Wilson, David\"], \"options\": {\"Options\": [\"Card, Sandra\", \"Frey, Jon M.\", \"Kaye, Kenneth\", \"McGrew, Ellen\", \"Wilson, David\"]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 1, \"description\": \"Person or persons who directly supervised the excavation or survey of a spatial section \", \"external_view\": 1, \"advanced_search\": 1, \"external_search\": 1, \"viewable_in_results\": 1}, \"Latest_Date_1_6_\": {\"name\": \"Latest Date\", \"type\": \"Historical Date\", \"default\": {\"day\": [\"[M]0[M]\", \"0\", \"[Y]1970[Y]\"], \"era\": \"CE\", \"year\": [\"[M]0[M][D]0[D]\", \"1970\", \"\"], \"month\": [\"\", \"0\", \"[D]0[D][Y]1970[Y]\"], \"prefix\": \"\"}, \"options\": {\"End\": \"2020\", \"Start\": \"1960\", \"Format\": \"MMDDYYYY\", \"ShowEra\": 0, \"ShowPrefix\": 0}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Latest date associated with project activity for this particular excavation/survey, expressed in yyyy/mm/dd format\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}, \"Season_Title_1_6_\": {\"name\": \"Season Title\", \"type\": \"Text\", \"default\": null, \"options\": {\"Regex\": \"\", \"MultiLine\": \"0\"}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Include the name given to the season exactly as it is recorded in the Title field in the Season scheme. This will create a link between this Excavation - Survey record and the appropriate Season record it belongs to.\\r\\n\\r\\nThis is redundant data for batch up\", \"external_view\": 0, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 0}, \"Earliest_Date_1_6_\": {\"name\": \"Earliest Date\", \"type\": \"Historical Date\", \"default\": {\"day\": [\"[M]0[M]\", \"0\", \"[Y]1970[Y]\"], \"era\": \"CE\", \"year\": [\"[M]0[M][D]0[D]\", \"1970\", \"\"], \"month\": [\"\", \"0\", \"[D]0[D][Y]1970[Y]\"], \"prefix\": \"\"}, \"options\": {\"End\": \"2020\", \"Start\": \"1960\", \"Format\": \"MMDDYYYY\", \"ShowEra\": 0, \"ShowPrefix\": 0}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Earliest date associated with project activity for this particular excavation/survey, expressed in yyyy/mm/dd format\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}, \"Season_Associator_1_6_\": {\"name\": \"Season Associator\", \"type\": \"Associator\", \"default\": null, \"options\": {\"SearchForms\": [{\"flids\": [], \"form_id\": \"32\"}]}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"KORA identifier for the Season record that describes the period of time (season/campaign) during which this Excavation - Survey took place.\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}, \"Survey_Conditions_1_6_\": {\"name\": \"Survey Conditions\", \"type\": \"Text\", \"default\": null, \"options\": {\"Regex\": \"\", \"MultiLine\": \"1\"}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Concise narrative description of the condition of the surveyed area (e.g. terrain, ground cover)\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}, \"Terminus_Ante_Quem_1_6_\": {\"name\": \"Terminus Ante Quem\", \"type\": \"Historical Date\", \"default\": {\"day\": [\"[M]0[M]\", \"0\", \"[Y]0[Y]\"], \"era\": \"CE\", \"year\": [\"[M]0[M][D]0[D]\", \"0\", \"\"], \"month\": [\"\", \"0\", \"[D]0[D][Y]0[Y]\"], \"prefix\": \"\"}, \"options\": {\"End\": \"9999\", \"Start\": \"1\", \"Format\": \"MMDDYYYY\", \"ShowEra\": 1, \"ShowPrefix\": 0}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Date at which the excavation/survey unit begins to exhibit evidence of human activity.\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}, \"Terminus_Post_Quem_1_6_\": {\"name\": \"Terminus Post Quem\", \"type\": \"Historical Date\", \"default\": {\"day\": [\"[M]0[M]\", \"0\", \"[Y]0[Y]\"], \"era\": \"CE\", \"year\": [\"[M]0[M][D]0[D]\", \"0\", \"\"], \"month\": [\"\", \"0\", \"[D]0[D][Y]0[Y]\"], \"prefix\": \"\"}, \"options\": {\"End\": \"9999\", \"Start\": \"1\", \"Format\": \"MMDDYYYY\", \"ShowEra\": 1, \"ShowPrefix\": 0}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Date at which the excavation/survey unit ceases to exhibit evidence of human activity.\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}, \"Excavation_Stratigraphy_1_6_\": {\"name\": \"Excavation Stratigraphy\", \"type\": \"Text\", \"default\": null, \"options\": {\"Regex\": \"\", \"MultiLine\": \"1\"}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Concise narrative description of the successive levels of excavated material\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}, \"Post_Dispositional_Transformation_1_6_\": {\"name\": \"Post Dispositional Transformation\", \"type\": \"Text\", \"default\": null, \"options\": {\"Regex\": \"\", \"MultiLine\": \"1\"}, \"alt_name\": \"\", \"required\": 0, \"viewable\": 1, \"searchable\": 0, \"description\": \"Concise narrative description of anthropogenic alterations to the excavation / survey unit.\", \"external_view\": 1, \"advanced_search\": 0, \"external_search\": 0, \"viewable_in_results\": 1}}}','2020-03-26 14:36:21','2020-03-26 14:36:21');
/*!40000 ALTER TABLE `kora_forms` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kora_global_cache`
--

DROP TABLE IF EXISTS `kora_global_cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kora_global_cache` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `html` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `global_cache_user_id_foreign` (`user_id`),
  CONSTRAINT `global_cache_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `kora_users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kora_global_cache`
--

LOCK TABLES `kora_global_cache` WRITE;
/*!40000 ALTER TABLE `kora_global_cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `kora_global_cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kora_jobs`
--

DROP TABLE IF EXISTS `kora_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kora_jobs` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `queue` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `payload` text COLLATE utf8_unicode_ci NOT NULL,
  `attempts` tinyint(3) unsigned NOT NULL,
  `reserved` tinyint(3) unsigned NOT NULL,
  `reserved_at` int(10) unsigned DEFAULT NULL,
  `available_at` int(10) unsigned NOT NULL,
  `created_at` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kora_jobs`
--

LOCK TABLES `kora_jobs` WRITE;
/*!40000 ALTER TABLE `kora_jobs` DISABLE KEYS */;
/*!40000 ALTER TABLE `kora_jobs` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kora_migrations`
--

DROP TABLE IF EXISTS `kora_migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kora_migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kora_migrations`
--

LOCK TABLES `kora_migrations` WRITE;
/*!40000 ALTER TABLE `kora_migrations` DISABLE KEYS */;
INSERT INTO `kora_migrations` VALUES (1,'2015_00_00_000000_CreateUsersTable',1),(2,'2015_00_00_000001_CreateProjectsTable',1),(3,'2015_00_00_000002_CreateFormsTable',1),(4,'2017_00_00_000000_CreateAssociationsTable',1),(5,'2017_00_00_000000_CreateDashboardTable',1),(6,'2017_00_00_000000_CreateExodusTable',1),(7,'2017_00_00_000000_CreateFieldValuePresetsTable',1),(8,'2017_00_00_000000_CreateFormCustomTable',1),(9,'2017_00_00_000000_CreateFormGroupsTable',1),(10,'2017_00_00_000000_CreateGlobalCacheTable',1),(11,'2017_00_00_000000_CreatePasswordResetsTable',1),(12,'2017_00_00_000000_CreateProjectCustomTable',1),(13,'2017_00_00_000000_CreateProjectGroupsTable',1),(14,'2017_00_00_000000_CreateRecordPresetsTable',1),(15,'2017_00_00_000000_CreateRecordsTable',1),(16,'2017_00_00_000000_CreateRevisionsTable',1),(17,'2017_00_00_000000_CreateScriptsTable',1),(18,'2017_00_00_000000_CreateTokensTable',1),(19,'2017_00_00_000000_CreateVersionsTable',1),(20,'2018_00_00_000000_CreateFailedJobsTable',1),(21,'2018_00_00_000000_CreateJobsTable',1),(22,'2019_00_00_000000_CreateFailedRecordsTable',1);
/*!40000 ALTER TABLE `kora_migrations` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kora_password_resets`
--

DROP TABLE IF EXISTS `kora_password_resets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kora_password_resets` (
  `email` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `token` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  KEY `password_resets_email_index` (`email`),
  KEY `password_resets_token_index` (`token`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kora_password_resets`
--

LOCK TABLES `kora_password_resets` WRITE;
/*!40000 ALTER TABLE `kora_password_resets` DISABLE KEYS */;
/*!40000 ALTER TABLE `kora_password_resets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kora_project_custom`
--

DROP TABLE IF EXISTS `kora_project_custom`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kora_project_custom` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `organization` json NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `project_custom_user_id_foreign` (`user_id`),
  CONSTRAINT `project_custom_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `kora_users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kora_project_custom`
--

LOCK TABLES `kora_project_custom` WRITE;
/*!40000 ALTER TABLE `kora_project_custom` DISABLE KEYS */;
INSERT INTO `kora_project_custom` VALUES (1,1,'[1]','2020-03-26 14:36:17','2020-03-26 14:36:17');
/*!40000 ALTER TABLE `kora_project_custom` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kora_project_group_user`
--

DROP TABLE IF EXISTS `kora_project_group_user`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kora_project_group_user` (
  `project_group_id` int(10) unsigned NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  KEY `project_group_user_project_group_id_index` (`project_group_id`),
  KEY `project_group_user_user_id_index` (`user_id`),
  CONSTRAINT `project_group_user_project_group_id_foreign` FOREIGN KEY (`project_group_id`) REFERENCES `kora_project_groups` (`id`) ON DELETE CASCADE,
  CONSTRAINT `project_group_user_user_id_foreign` FOREIGN KEY (`user_id`) REFERENCES `kora_users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kora_project_group_user`
--

LOCK TABLES `kora_project_group_user` WRITE;
/*!40000 ALTER TABLE `kora_project_group_user` DISABLE KEYS */;
INSERT INTO `kora_project_group_user` VALUES (1,1);
/*!40000 ALTER TABLE `kora_project_group_user` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kora_project_groups`
--

DROP TABLE IF EXISTS `kora_project_groups`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kora_project_groups` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(80) COLLATE utf8_unicode_ci NOT NULL,
  `project_id` int(10) unsigned NOT NULL,
  `create` tinyint(1) NOT NULL,
  `edit` tinyint(1) NOT NULL,
  `delete` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `project_groups_project_id_foreign` (`project_id`),
  CONSTRAINT `project_groups_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `kora_projects` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kora_project_groups`
--

LOCK TABLES `kora_project_groups` WRITE;
/*!40000 ALTER TABLE `kora_project_groups` DISABLE KEYS */;
INSERT INTO `kora_project_groups` VALUES (1,'arcs Admin Group',1,1,1,1,'2020-03-26 14:36:17','2020-03-26 14:36:17'),(2,'arcs Default Group',1,0,0,0,'2020-03-26 14:36:17','2020-03-26 14:36:17');
/*!40000 ALTER TABLE `kora_project_groups` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kora_project_token`
--

DROP TABLE IF EXISTS `kora_project_token`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kora_project_token` (
  `project_id` int(10) unsigned NOT NULL,
  `token_id` int(10) unsigned NOT NULL,
  KEY `project_token_project_id_index` (`project_id`),
  KEY `project_token_token_id_index` (`token_id`),
  CONSTRAINT `project_token_project_id_foreign` FOREIGN KEY (`project_id`) REFERENCES `kora_projects` (`id`) ON DELETE CASCADE,
  CONSTRAINT `project_token_token_id_foreign` FOREIGN KEY (`token_id`) REFERENCES `kora_tokens` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kora_project_token`
--

LOCK TABLES `kora_project_token` WRITE;
/*!40000 ALTER TABLE `kora_project_token` DISABLE KEYS */;
INSERT INTO `kora_project_token` VALUES (1,1);
/*!40000 ALTER TABLE `kora_project_token` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kora_projects`
--

DROP TABLE IF EXISTS `kora_projects`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kora_projects` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `internal_name` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `description` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `active` tinyint(1) NOT NULL,
  `adminGroup_id` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `projects_internal_name_unique` (`internal_name`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kora_projects`
--

LOCK TABLES `kora_projects` WRITE;
/*!40000 ALTER TABLE `kora_projects` DISABLE KEYS */;
INSERT INTO `kora_projects` VALUES (1,'arcs','arcs_1_','arcs',1,1,'2020-03-26 14:36:17','2020-03-26 14:36:34');
/*!40000 ALTER TABLE `kora_projects` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kora_record_presets`
--

DROP TABLE IF EXISTS `kora_record_presets`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kora_record_presets` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `form_id` int(10) unsigned NOT NULL,
  `record_kid` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `preset` json NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `record_presets_form_id_foreign` (`form_id`),
  CONSTRAINT `record_presets_form_id_foreign` FOREIGN KEY (`form_id`) REFERENCES `kora_forms` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kora_record_presets`
--

LOCK TABLES `kora_record_presets` WRITE;
/*!40000 ALTER TABLE `kora_record_presets` DISABLE KEYS */;
/*!40000 ALTER TABLE `kora_record_presets` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kora_records_1`
--

DROP TABLE IF EXISTS `kora_records_1`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kora_records_1` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `legacy_kid` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `project_id` int(10) unsigned NOT NULL,
  `form_id` int(10) unsigned NOT NULL,
  `owner` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `Name_1_1_` text COLLATE utf8_unicode_ci,
  `Period_1_1_` json DEFAULT NULL,
  `Region_1_1_` enum('Please Modify List Values') COLLATE utf8_unicode_ci DEFAULT NULL,
  `Country_1_1_` enum('Please Modify List Values') COLLATE utf8_unicode_ci DEFAULT NULL,
  `Elevation_1_1_` text COLLATE utf8_unicode_ci,
  `Description_1_1_` text COLLATE utf8_unicode_ci,
  `Geolocation_1_1_` json DEFAULT NULL,
  `Latest_Date_1_1_` json DEFAULT NULL,
  `Modern_Name_1_1_` enum('Please Modify List Values') COLLATE utf8_unicode_ci DEFAULT NULL,
  `Complex_Title_1_1_` text COLLATE utf8_unicode_ci,
  `Earliest_Date_1_1_` json DEFAULT NULL,
  `Persistent_Name_1_1_` text COLLATE utf8_unicode_ci,
  `Records_Archive_1_1_` json DEFAULT NULL,
  `Brief_Description_1_1_` text COLLATE utf8_unicode_ci,
  `Terminus_Ante_Quem_1_1_` json DEFAULT NULL,
  `Terminus_Post_Quem_1_1_` json DEFAULT NULL,
  `Location_Identifier_1_1_` text COLLATE utf8_unicode_ci,
  `Archaeological_Culture_1_1_` json DEFAULT NULL,
  `Permitting_Heritage_Body_1_1_` json DEFAULT NULL,
  `Location_Identifier_Scheme_1_1_` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kora_records_1`
--

LOCK TABLES `kora_records_1` WRITE;
/*!40000 ALTER TABLE `kora_records_1` DISABLE KEYS */;
/*!40000 ALTER TABLE `kora_records_1` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kora_records_2`
--

DROP TABLE IF EXISTS `kora_records_2`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kora_records_2` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `legacy_kid` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `project_id` int(10) unsigned NOT NULL,
  `form_id` int(10) unsigned NOT NULL,
  `owner` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `Type_1_2_` json DEFAULT NULL,
  `Title_1_2_` text COLLATE utf8_unicode_ci,
  `Orphan_1_2_` enum('Please Modify List Values') COLLATE utf8_unicode_ci DEFAULT NULL,
  `Sponsor_1_2_` json DEFAULT NULL,
  `Director_1_2_` json DEFAULT NULL,
  `Registrar_1_2_` json DEFAULT NULL,
  `Contributor_1_2_` enum('Please Modify List Values') COLLATE utf8_unicode_ci DEFAULT NULL,
  `Description_1_2_` text COLLATE utf8_unicode_ci,
  `Latest_Date_1_2_` json DEFAULT NULL,
  `Project_Name_1_2_` text COLLATE utf8_unicode_ci,
  `Contributor_2_1_2_` enum('Please Modify List Values') COLLATE utf8_unicode_ci DEFAULT NULL,
  `Contributor_3_1_2_` enum('Please Modify List Values') COLLATE utf8_unicode_ci DEFAULT NULL,
  `Contributor_4_1_2_` enum('Please Modify List Values') COLLATE utf8_unicode_ci DEFAULT NULL,
  `Contributor_5_1_2_` enum('Please Modify List Values') COLLATE utf8_unicode_ci DEFAULT NULL,
  `Contributor_6_1_2_` enum('Please Modify List Values') COLLATE utf8_unicode_ci DEFAULT NULL,
  `Contributor_7_1_2_` enum('Please Modify List Values') COLLATE utf8_unicode_ci DEFAULT NULL,
  `Contributor_8_1_2_` enum('Please Modify List Values') COLLATE utf8_unicode_ci DEFAULT NULL,
  `Contributor_9_1_2_` enum('Please Modify List Values') COLLATE utf8_unicode_ci DEFAULT NULL,
  `Earliest_Date_1_2_` json DEFAULT NULL,
  `Contributor_Role_1_2_` json DEFAULT NULL,
  `Contributor_Role_2_1_2_` json DEFAULT NULL,
  `Contributor_Role_3_1_2_` json DEFAULT NULL,
  `Contributor_Role_4_1_2_` json DEFAULT NULL,
  `Contributor_Role_5_1_2_` json DEFAULT NULL,
  `Contributor_Role_6_1_2_` json DEFAULT NULL,
  `Contributor_Role_7_1_2_` json DEFAULT NULL,
  `Contributor_Role_8_1_2_` json DEFAULT NULL,
  `Contributor_Role_9_1_2_` json DEFAULT NULL,
  `Project_Associator_1_2_` json DEFAULT NULL,
  `Terminus_Ante_Quem_1_2_` json DEFAULT NULL,
  `Terminus_Post_Quem_1_2_` json DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kora_records_2`
--

LOCK TABLES `kora_records_2` WRITE;
/*!40000 ALTER TABLE `kora_records_2` DISABLE KEYS */;
/*!40000 ALTER TABLE `kora_records_2` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kora_records_3`
--

DROP TABLE IF EXISTS `kora_records_3`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kora_records_3` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `legacy_kid` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `project_id` int(10) unsigned NOT NULL,
  `form_id` int(10) unsigned NOT NULL,
  `owner` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_1_3_` text COLLATE utf8_unicode_ci,
  `Test_1_3_` enum('Please Modify List Values') COLLATE utf8_unicode_ci DEFAULT NULL,
  `Type_1_3_` enum('Please Modify List Values') COLLATE utf8_unicode_ci DEFAULT NULL,
  `Pages_1_3_` text COLLATE utf8_unicode_ci,
  `Title_1_3_` text COLLATE utf8_unicode_ci,
  `Legacy_1_3_` enum('Please Modify List Values') COLLATE utf8_unicode_ci DEFAULT NULL,
  `Orphan_1_3_` enum('Please Modify List Values') COLLATE utf8_unicode_ci DEFAULT NULL,
  `Rights_1_3_` text COLLATE utf8_unicode_ci,
  `Creator_1_3_` json DEFAULT NULL,
  `Creator2_1_3_` json DEFAULT NULL,
  `Language_1_3_` json DEFAULT NULL,
  `Condition_1_3_` enum('Please Modify List Values') COLLATE utf8_unicode_ci DEFAULT NULL,
  `Sub_title_1_3_` text COLLATE utf8_unicode_ci,
  `Date_Range_1_3_` text COLLATE utf8_unicode_ci,
  `Dimensions_1_3_` json DEFAULT NULL,
  `Repository_1_3_` enum('Please Modify List Values') COLLATE utf8_unicode_ci DEFAULT NULL,
  `Description_1_3_` text COLLATE utf8_unicode_ci,
  `Latest_Date_1_3_` json DEFAULT NULL,
  `Permissions_1_3_` enum('Please Modify List Values') COLLATE utf8_unicode_ci DEFAULT NULL,
  `Creator_Role_1_3_` json DEFAULT NULL,
  `Season_Title_1_3_` text COLLATE utf8_unicode_ci,
  `Special_User_1_3_` text COLLATE utf8_unicode_ci,
  `Earliest_Date_1_3_` json DEFAULT NULL,
  `Rights_Holder_1_3_` json DEFAULT NULL,
  `Transcription_1_3_` text COLLATE utf8_unicode_ci,
  `Creator_Role_2_1_3_` json DEFAULT NULL,
  `Accession_Number_1_3_` text COLLATE utf8_unicode_ci,
  `Season_Associator_1_3_` json DEFAULT NULL,
  `Resource_Identifier_1_3_` text COLLATE utf8_unicode_ci,
  `Excavation_Survey_Name_1_3_` text COLLATE utf8_unicode_ci,
  `Excavation_Survey_Associator_1_3_` json DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kora_records_3`
--

LOCK TABLES `kora_records_3` WRITE;
/*!40000 ALTER TABLE `kora_records_3` DISABLE KEYS */;
/*!40000 ALTER TABLE `kora_records_3` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kora_records_4`
--

DROP TABLE IF EXISTS `kora_records_4`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kora_records_4` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `legacy_kid` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `project_id` int(10) unsigned NOT NULL,
  `form_id` int(10) unsigned NOT NULL,
  `owner` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_1_4_` text COLLATE utf8_unicode_ci,
  `Type_1_4_` enum('Please Modify List Values') COLLATE utf8_unicode_ci DEFAULT NULL,
  `Format_1_4_` enum('Please Modify List Values') COLLATE utf8_unicode_ci DEFAULT NULL,
  `Legacy_1_4_` enum('Please Modify List Values') COLLATE utf8_unicode_ci DEFAULT NULL,
  `Orphan_1_4_` enum('Please Modify List Values') COLLATE utf8_unicode_ci DEFAULT NULL,
  `Display_1_4_` enum('Please Modify List Values') COLLATE utf8_unicode_ci DEFAULT NULL,
  `Scan_Date_1_4_` json DEFAULT NULL,
  `Scan_Number_1_4_` int(11) DEFAULT NULL,
  `Image_Upload_1_4_` json DEFAULT NULL,
  `Scan_Creator_1_4_` text COLLATE utf8_unicode_ci,
  `Scan_Equipment_1_4_` text COLLATE utf8_unicode_ci,
  `Page_Identifier_1_4_` text COLLATE utf8_unicode_ci,
  `Resource_Associator_1_4_` json DEFAULT NULL,
  `Resource_Identifier_1_4_` text COLLATE utf8_unicode_ci,
  `Scan_Creator_Status_1_4_` enum('Please Modify List Values') COLLATE utf8_unicode_ci DEFAULT NULL,
  `Scan_Specifications_1_4_` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kora_records_4`
--

LOCK TABLES `kora_records_4` WRITE;
/*!40000 ALTER TABLE `kora_records_4` DISABLE KEYS */;
/*!40000 ALTER TABLE `kora_records_4` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kora_records_5`
--

DROP TABLE IF EXISTS `kora_records_5`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kora_records_5` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `legacy_kid` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `project_id` int(10) unsigned NOT NULL,
  `form_id` int(10) unsigned NOT NULL,
  `owner` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `id_1_5_` text COLLATE utf8_unicode_ci,
  `Legacy_1_5_` enum('Please Modify List Values') COLLATE utf8_unicode_ci DEFAULT NULL,
  `Orphan_1_5_` enum('Please Modify List Values') COLLATE utf8_unicode_ci DEFAULT NULL,
  `Trench_1_5_` json DEFAULT NULL,
  `Display_1_5_` enum('Please Modify List Values') COLLATE utf8_unicode_ci DEFAULT NULL,
  `Page_Identifier_1_5_` text COLLATE utf8_unicode_ci,
  `Pages_Associator_1_5_` json DEFAULT NULL,
  `Resource_Identifier_1_5_` text COLLATE utf8_unicode_ci,
  `Artifact_Structure_Date_1_5_` json DEFAULT NULL,
  `Artifact_Structure_Type_1_5_` json DEFAULT NULL,
  `Artifact_Structure_Title_1_5_` text COLLATE utf8_unicode_ci,
  `Artifact_Structure_Origin_1_5_` enum('Please Modify List Values') COLLATE utf8_unicode_ci DEFAULT NULL,
  `Artifact_Structure_Period_1_5_` json DEFAULT NULL,
  `Artifact_Structure_Creator_1_5_` json DEFAULT NULL,
  `Artifact_Structure_Subject_1_5_` json DEFAULT NULL,
  `Artifact_Structure_Location_1_5_` json DEFAULT NULL,
  `Artifact_Structure_Material_1_5_` json DEFAULT NULL,
  `Artifact_Structure_Condition_1_5_` json DEFAULT NULL,
  `Artifact_Structure_Technique_1_5_` json DEFAULT NULL,
  `Artifact_Structure_Comparanda_1_5_` text COLLATE utf8_unicode_ci,
  `Artifact_Structure_Dimensions_1_5_` json DEFAULT NULL,
  `Artifact_Structure_Repository_1_5_` enum('Please Modify List Values') COLLATE utf8_unicode_ci DEFAULT NULL,
  `Artifact_Structure_Description_1_5_` text COLLATE utf8_unicode_ci,
  `Artifact_Structure_Geolocation_1_5_` json DEFAULT NULL,
  `Artifact_Structure_Inscription_1_5_` text COLLATE utf8_unicode_ci,
  `Artifact_Structure_Creator_Role_1_5_` json DEFAULT NULL,
  `Artifact_Structure_Classification_1_5_` enum('Please Modify List Values') COLLATE utf8_unicode_ci DEFAULT NULL,
  `Artifact_Structure_Munsell_Number_1_5_` text COLLATE utf8_unicode_ci,
  `Artifact_Structure_Type_Qualifier_1_5_` text COLLATE utf8_unicode_ci,
  `Subject_of_Observation_Associator_1_5_` json DEFAULT NULL,
  `Artifact_Structure_Excavation_Unit_1_5_` json DEFAULT NULL,
  `Artifact_Structure_Current_Location_1_5_` enum('Please Modify List Values') COLLATE utf8_unicode_ci DEFAULT NULL,
  `Artifact_Structure_Shelving_Location_1_5_` text COLLATE utf8_unicode_ci,
  `Artifact_Structure_Terminus_Ante_Quem_1_5_` json DEFAULT NULL,
  `Artifact_Structure_Terminus_Post_Quem_1_5_` json DEFAULT NULL,
  `Artifact_Structure_Archaeological_Context_1_5_` text COLLATE utf8_unicode_ci,
  `Artifact_Structure_Archaeological_Culture_1_5_` json DEFAULT NULL,
  `Artifact_Structure_Repository_Accession_Number_1_5_` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kora_records_5`
--

LOCK TABLES `kora_records_5` WRITE;
/*!40000 ALTER TABLE `kora_records_5` DISABLE KEYS */;
/*!40000 ALTER TABLE `kora_records_5` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kora_records_6`
--

DROP TABLE IF EXISTS `kora_records_6`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kora_records_6` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `kid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `legacy_kid` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `project_id` int(10) unsigned NOT NULL,
  `form_id` int(10) unsigned NOT NULL,
  `owner` int(10) unsigned NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `Name_1_6_` text COLLATE utf8_unicode_ci,
  `Type_1_6_` enum('Please Modify List Values') COLLATE utf8_unicode_ci DEFAULT NULL,
  `Legacy_1_6_` enum('Please Modify List Values') COLLATE utf8_unicode_ci DEFAULT NULL,
  `Orphan_1_6_` enum('Please Modify List Values') COLLATE utf8_unicode_ci DEFAULT NULL,
  `Supervisor_1_6_` json DEFAULT NULL,
  `Latest_Date_1_6_` json DEFAULT NULL,
  `Season_Title_1_6_` text COLLATE utf8_unicode_ci,
  `Earliest_Date_1_6_` json DEFAULT NULL,
  `Season_Associator_1_6_` json DEFAULT NULL,
  `Survey_Conditions_1_6_` text COLLATE utf8_unicode_ci,
  `Terminus_Ante_Quem_1_6_` json DEFAULT NULL,
  `Terminus_Post_Quem_1_6_` json DEFAULT NULL,
  `Excavation_Stratigraphy_1_6_` text COLLATE utf8_unicode_ci,
  `Post_Dispositional_Transformation_1_6_` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kora_records_6`
--

LOCK TABLES `kora_records_6` WRITE;
/*!40000 ALTER TABLE `kora_records_6` DISABLE KEYS */;
/*!40000 ALTER TABLE `kora_records_6` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kora_reverse_associator_cache`
--

DROP TABLE IF EXISTS `kora_reverse_associator_cache`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kora_reverse_associator_cache` (
  `associated_kid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `associated_form_id` int(10) unsigned NOT NULL,
  `source_kid` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `source_flid` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `source_form_id` int(10) unsigned NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kora_reverse_associator_cache`
--

LOCK TABLES `kora_reverse_associator_cache` WRITE;
/*!40000 ALTER TABLE `kora_reverse_associator_cache` DISABLE KEYS */;
/*!40000 ALTER TABLE `kora_reverse_associator_cache` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kora_revisions`
--

DROP TABLE IF EXISTS `kora_revisions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kora_revisions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `form_id` int(10) unsigned NOT NULL,
  `record_kid` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `owner` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `revision` json NOT NULL,
  `rollback` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `revisions_form_id_foreign` (`form_id`),
  CONSTRAINT `revisions_form_id_foreign` FOREIGN KEY (`form_id`) REFERENCES `kora_forms` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kora_revisions`
--

LOCK TABLES `kora_revisions` WRITE;
/*!40000 ALTER TABLE `kora_revisions` DISABLE KEYS */;
/*!40000 ALTER TABLE `kora_revisions` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kora_scripts`
--

DROP TABLE IF EXISTS `kora_scripts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kora_scripts` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `filename` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `has_run` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `scripts_filename_unique` (`filename`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kora_scripts`
--

LOCK TABLES `kora_scripts` WRITE;
/*!40000 ALTER TABLE `kora_scripts` DISABLE KEYS */;
/*!40000 ALTER TABLE `kora_scripts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kora_tokens`
--

DROP TABLE IF EXISTS `kora_tokens`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kora_tokens` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `token` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `search` tinyint(1) NOT NULL,
  `create` tinyint(1) NOT NULL,
  `edit` tinyint(1) NOT NULL,
  `delete` tinyint(1) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kora_tokens`
--

LOCK TABLES `kora_tokens` WRITE;
/*!40000 ALTER TABLE `kora_tokens` DISABLE KEYS */;
INSERT INTO `kora_tokens` VALUES (1,'5e7e3888de5fc','arcs',1,1,1,1,'2020-03-27 17:31:52','2020-03-27 17:31:52');
/*!40000 ALTER TABLE `kora_tokens` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kora_users`
--

DROP TABLE IF EXISTS `kora_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kora_users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `admin` tinyint(1) NOT NULL,
  `active` tinyint(1) NOT NULL,
  `username` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(60) COLLATE utf8_unicode_ci NOT NULL,
  `regtoken` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `gitlab_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `preferences` json DEFAULT NULL,
  `remember_token` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_username_unique` (`username`),
  UNIQUE KEY `users_email_unique` (`email`),
  UNIQUE KEY `users_gitlab_token_unique` (`gitlab_token`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kora_users`
--

LOCK TABLES `kora_users` WRITE;
/*!40000 ALTER TABLE `kora_users` DISABLE KEYS */;
INSERT INTO `kora_users` VALUES (1,1,1,'admin','arcs@gmail.com','$2y$10$yXLFzdQEKN2E5g7KZh1lX.wTVeEWaq/H5gki/5EnlsA5/K2Z0ZNwG','',NULL,'{\"language\": \"en\", \"last_name\": \"Admin\", \"first_name\": \"Kora\", \"onboarding\": 0, \"logo_target\": 2, \"profile_pic\": \"\", \"organization\": \"Kora User\", \"use_dashboard\": 1, \"form_tab_selection\": 2, \"proj_tab_selection\": 2}',NULL,'2020-03-26 13:18:22','2020-03-26 13:25:40');
/*!40000 ALTER TABLE `kora_users` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `kora_versions`
--

DROP TABLE IF EXISTS `kora_versions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `kora_versions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `version` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `kora_versions`
--

LOCK TABLES `kora_versions` WRITE;
/*!40000 ALTER TABLE `kora_versions` DISABLE KEYS */;
INSERT INTO `kora_versions` VALUES (1,'3.0.0','2020-03-26 13:18:22','2020-03-26 13:18:22');
/*!40000 ALTER TABLE `kora_versions` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2020-03-27 17:33:01
