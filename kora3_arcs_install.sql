# ************************************************************
# Sequel Pro SQL dump
# Version 4541
#
# http://www.sequelpro.com/
# https://github.com/sequelpro/sequelpro
#
# Host: rush.matrix.msu.edu (MySQL 5.5.46-0+deb8u1-log)
# Database: arcs_install_scratch
# Generation Time: 2018-09-11 14:24:55 +0000
# ************************************************************


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


# Dump of table kora3_associations
# ------------------------------------------------------------

LOCK TABLES `kora3_associations` WRITE;
/*!40000 ALTER TABLE `kora3_associations` DISABLE KEYS */;

INSERT INTO `kora3_associations` (`id`, `dataForm`, `assocForm`, `created_at`, `updated_at`)
VALUES
	(1,6,3,'2018-08-28 15:19:30','2018-08-28 15:19:30'),
	(2,4,5,'2018-08-28 15:20:10','2018-08-28 15:20:10'),
	(3,1,2,'2018-08-28 15:20:33','2018-08-28 15:20:33'),
	(4,3,4,'2018-08-28 15:21:01','2018-08-28 15:21:01'),
	(5,2,3,'2018-08-28 15:21:35','2018-08-28 15:21:35'),
	(6,2,6,'2018-08-28 15:21:40','2018-08-28 15:21:40'),
	(7,5,5,'2018-08-28 15:22:23','2018-08-28 15:22:23');

/*!40000 ALTER TABLE `kora3_associations` ENABLE KEYS */;
UNLOCK TABLES;

# Dump of table kora3_fields
# ------------------------------------------------------------

LOCK TABLES `kora3_fields` WRITE;
/*!40000 ALTER TABLE `kora3_fields` DISABLE KEYS */;

INSERT INTO `kora3_fields` (`flid`, `pid`, `fid`, `page_id`, `sequence`, `type`, `name`, `slug`, `desc`, `required`, `searchable`, `advsearch`, `extsearch`, `viewable`, `viewresults`, `extview`, `default`, `options`, `created_at`, `updated_at`)
VALUES
	(1,1,1,1,0,'Text','Name','Name_1_1_','Titles, identifying phrases, or names given to an archaeological \nspace.',0,1,0,1,1,1,1,'','[!Regex!][!Regex!][!MultiLine!]0[!MultiLine!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(2,1,1,1,1,'List','Country','Country_1_1_','A type of ',0,0,0,0,1,1,1,'','[!Options!][!Options!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(3,1,1,1,2,'List','Region','Region_1_1_','Geographic area where the project is located (modern)',0,0,0,0,1,1,1,'','[!Options!][!Options!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(4,1,1,1,3,'List','Modern Name','Modern_Name_1_1_','The modern toponym of the geographic location of the project',0,0,0,0,1,1,1,'','[!Options!][!Options!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(5,1,1,1,4,'Text','Location Identifier','Location_Identifier_1_1_','Systematically assigned alphanumeric code identifying project location, if applicable',0,0,0,0,1,1,1,'','[!Regex!][!Regex!][!MultiLine!]0[!MultiLine!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(6,1,1,1,5,'Text','Location Identifier Scheme','Location_Identifier_Scheme_1_1_','Scheme used to generate identification code in Location Identifier, if applicable.',0,0,0,0,1,1,1,'','[!Regex!][!Regex!][!MultiLine!]0[!MultiLine!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(7,1,1,1,6,'Generated List','Geolocation','Geolocation_1_1_','Coordinate pair(s) (latitude and longitude) that establishes a general location of project. \n\nFormatting: Latitude,Longitude for example: 41.255678,13.435335\n\n',0,0,0,0,1,1,1,'','[!Regex!][!Regex!][!Options!][!Options!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(8,1,1,1,7,'Text','Elevation','Elevation_1_1_','Highest and lowest recorded altitudes of the project location, expressed as a range in meters according to the WGS 84 system.',0,0,0,0,1,1,1,'','[!Regex!][!Regex!][!MultiLine!]0[!MultiLine!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(9,1,1,1,8,'Date','Earliest Date','Earliest_Date_1_1_','Earliest date associated with project activity, expressed in yyyy/mm/dd format',0,0,0,0,1,1,1,'[M]0[M][D]0[D][Y]0[Y]','[!Circa!]No[!Circa!][!Start!]1930[!Start!][!End!]2020[!End!][!Format!]YYYYMMDD[!Format!][!Era!]No[!Era!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(10,1,1,1,9,'Date','Latest Date','Latest_Date_1_1_','Latest date associated with project activity, expressed in yyyy/mm/dd format',0,0,0,0,1,1,1,'[M]0[M][D]0[D][Y]0[Y]','[!Circa!]No[!Circa!][!Start!]1930[!Start!][!End!]2020[!End!][!Format!]YYYYMMDD[!Format!][!Era!]No[!Era!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(11,1,1,1,10,'Multi-Select List','Records Archive','Records_Archive_1_1_','Location(s) of project documentation and records. Uniform name of the physical repository or repositories with full address.',0,0,0,0,1,1,1,'','[!Options!][!Options!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(12,1,1,1,11,'Text','Persistent Name','Persistent_Name_1_1_','Name by which the location of the project is traditionally known.',0,0,0,0,1,1,1,'','[!Regex!][!Regex!][!MultiLine!]1[!MultiLine!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(13,1,1,1,12,'Text','Complex Title','Complex_Title_1_1_','The name of the complex of which the work is a part, if applicable.',0,0,0,0,1,1,1,'','[!Regex!][!Regex!][!MultiLine!]1[!MultiLine!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(14,1,1,1,13,'Date','Terminus Ante Quem','Terminus_Ante_Quem_1_1_','Date at which the project location begins to exhibit evidence of human activity.',0,0,0,0,1,1,1,'[M]0[M][D]0[D][Y]0[Y]','[!Circa!]No[!Circa!][!Start!]1[!Start!][!End!]9999[!End!][!Format!]MMDDYYYY[!Format!][!Era!]Yes[!Era!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(15,1,1,1,14,'Date','Terminus Post Quem','Terminus_Post_Quem_1_1_','Date at which the project location ceases to exhibit evidence of human activity.',0,0,0,0,1,1,1,'[M]0[M][D]0[D][Y]0[Y]','[!Circa!]No[!Circa!][!Start!]1[!Start!][!End!]9999[!End!][!Format!]MMDDYYYY[!Format!][!Era!]Yes[!Era!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(16,1,1,1,15,'Multi-Select List','Period','Period_1_1_','Term that identifies the named, defined period(s) whose characteristics are represented in the project location.',0,0,0,0,1,1,1,'','[!Options!][!Options!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(17,1,1,1,16,'Multi-Select List','Archaeological Culture','Archaeological_Culture_1_1_','Recognizable and recurring assemblage of artifacts from a specific time and place. Thought to constitute the material remains of a particular past human society or group',0,0,0,0,1,1,1,'','[!Options!][!Options!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(18,1,1,1,17,'Text','Description','Description_1_1_','Concise narrative outlining the project, its goals, duration, etc.',0,0,0,0,1,1,1,'','[!Regex!][!Regex!][!MultiLine!]1[!MultiLine!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(19,1,1,1,18,'Text','Brief Description','Brief_Description_1_1_','2 sentence narrative describing the project. Will appear on the home page of the public site.',0,0,0,0,1,1,1,'','[!Regex!][!Regex!][!MultiLine!]1[!MultiLine!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(20,1,1,1,19,'Multi-Select List','Permitting Heritage Body','Permitting_Heritage_Body_1_1_','Name of the heritage body granting permission for project',0,0,0,0,1,1,1,'','[!Options!][!Options!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(21,1,2,2,0,'Associator','Project Associator','Project_Associator_1_2_','KORA identifier for the Project record that describes the overarching archaeological enterprise when this field research season or campaign took place.',0,0,0,0,1,1,1,'','[!SearchForms!][fid]1[fid][search]1[search][flids]1[flids][!SearchForms!]','2018-08-28 13:24:05','2018-08-28 15:23:42'),
	(22,1,2,2,1,'Text','Title','Title_1_2_','Title given to a particular physical configuration of the named project in an officially-defined short span of time',0,1,0,1,1,1,1,'','[!Regex!][!Regex!][!MultiLine!]0[!MultiLine!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(23,1,2,2,2,'Multi-Select List','Type','Type_1_2_','Particular type of campaign (e.g. session, excavation, study)',0,1,0,1,1,1,1,'Excavation','[!Options!]Excavation[!]Study[!]Survey[!Options!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(24,1,2,2,3,'Multi-Select List','Director','Director_1_2_','Person(s) who bear responsibility for the execution of the season',0,1,0,1,1,1,1,'','[!Options!][!Options!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(25,1,2,2,4,'Multi-Select List','Registrar','Registrar_1_2_','Person(s) in an official position responsible for accurately recording season data',0,1,0,1,1,1,1,'','[!Options!][!Options!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(26,1,2,2,5,'Multi-Select List','Sponsor','Sponsor_1_2_','Entity/entities supporting the season',0,1,0,1,1,1,1,'','[!Options!][!Options!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(27,1,2,2,6,'List','Contributor','Contributor_1_2_','Person who participated in the project during this particular season.\n\nIdentify the role(s) this contributor played during this season in the Contributor Role field.',0,1,0,1,1,1,1,' ','[!Options!][!Options!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(28,1,2,2,7,'Multi-Select List','Contributor Role','Contributor_Role_1_2_','Part(s) or role(s) played by person identified in Contributor field.',0,0,0,0,1,1,1,'','[!Options!][!Options!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(29,1,2,2,8,'List','Contributor 2','Contributor_2_1_2_','Person who participated in the project during season and the part played by the contributor. \n\nIdentify the role(s) this contributor played during this season in the Contributor Role 2 field.',0,0,0,0,1,1,1,'','[!Options!][!Options!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(30,1,2,2,9,'Multi-Select List','Contributor Role 2','Contributor_Role_2_1_2_','Part(s) or role(s) played by person identified in Contributor 2 field.',0,0,0,0,1,1,1,'','[!Options!][!Options!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(31,1,2,2,10,'List','Contributor 3','Contributor_3_1_2_','Person who participated in the project during season and the part played by the contributor. \n\nIdentify the role(s) this contributor played during this season in the Contributor Role 3 field.',0,0,0,0,1,1,1,'','[!Options!][!Options!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(32,1,2,2,11,'Multi-Select List','Contributor Role 3','Contributor_Role_3_1_2_','Part(s) or role(s) played by person identified in Contributor 3 field.',0,0,0,0,1,1,1,'','[!Options!][!Options!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(33,1,2,2,12,'List','Contributor 4','Contributor_4_1_2_','Person who participated in the project during season and the part played by the contributor. \n\nIdentify the role(s) this contributor played during this season in the Contributor Role 4 field.',0,0,0,0,1,1,1,'','[!Options!][!Options!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(34,1,2,2,13,'Multi-Select List','Contributor Role 4','Contributor_Role_4_1_2_','Part(s) or role(s) played by person identified in Contributor 4 field.',0,0,0,0,1,1,1,'','[!Options!][!Options!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(35,1,2,2,14,'List','Contributor 5','Contributor_5_1_2_','Person who participated in the project during season and the part played by the contributor. \n\nIdentify the role(s) this contributor played during this season in the Contributor Role 5 field.',0,0,0,0,1,1,1,'','[!Options!][!Options!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(36,1,2,2,15,'Multi-Select List','Contributor Role 5','Contributor_Role_5_1_2_','Part(s) or role(s) played by person identified in Contributor 5 field.',0,0,0,0,1,1,1,'','[!Options!][!Options!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(37,1,2,2,16,'List','Contributor 6','Contributor_6_1_2_','Person who participated in the project during season and the part played by the contributor. \n\nIdentify the role(s) this contributor played during this season in the Contributor Role 6 field.',0,0,0,0,1,1,1,'','[!Options!][!Options!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(38,1,2,2,17,'Multi-Select List','Contributor Role 6','Contributor_Role_6_1_2_','Part(s) or role(s) played by person identified in Contributor 6 field.',0,0,0,0,1,1,1,'','[!Options!][!Options!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(39,1,2,2,18,'List','Contributor 7','Contributor_7_1_2_','Person who participated in the project during season and the part played by the contributor. \n\nIdentify the role(s) this contributor played during this season in the Contributor Role 7 field.',0,0,0,0,1,1,1,'','[!Options!][!Options!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(40,1,2,2,19,'Multi-Select List','Contributor Role 7','Contributor_Role_7_1_2_','Part(s) or role(s) played by person identified in Contributor 7 field.',0,0,0,0,1,1,1,'','[!Options!][!Options!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(41,1,2,2,20,'List','Contributor 8','Contributor_8_1_2_','Person who participated in the project during season and the part played by the contributor. \n\nIdentify the role(s) this contributor played during this season in the Contributor Role 8 field.',0,0,0,0,1,1,1,'','[!Options!][!Options!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(42,1,2,2,21,'Multi-Select List','Contributor Role 8','Contributor_Role_8_1_2_','Part(s) or role(s) played by person identified in Contributor 8 field.',0,0,0,0,1,1,1,'','[!Options!][!Options!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(43,1,2,2,22,'List','Contributor 9','Contributor_9_1_2_','Person who participated in the project during season and the part played by the contributor. \n\nIdentify the role(s) this contributor played during this season in the Contributor Role 9 field.',0,0,0,0,1,1,1,'','[!Options!][!Options!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(44,1,2,2,23,'Multi-Select List','Contributor Role 9','Contributor_Role_9_1_2_','Part(s) or role(s) played by person identified in Contributor 9 field.',0,0,0,0,1,1,1,'','[!Options!][!Options!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(45,1,2,2,24,'Date','Earliest Date','Earliest_Date_1_2_','Earliest date associated with project activity in this particular season, expressed in yyyy/mm/dd format',0,0,0,0,1,1,1,'[M]0[M][D]0[D][Y]0[Y]','[!Circa!]No[!Circa!][!Start!]1940[!Start!][!End!]2020[!End!][!Format!]YYYYMMDD[!Format!][!Era!]No[!Era!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(46,1,2,2,25,'Date','Latest Date','Latest_Date_1_2_','Latest date associated with project activity in this particular season, expressed in yyyy/mm/dd format',0,0,0,0,1,1,1,'[M]0[M][D]0[D][Y]0[Y]','[!Circa!]No[!Circa!][!Start!]1940[!Start!][!End!]2020[!End!][!Format!]YYYYMMDD[!Format!][!Era!]No[!Era!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(47,1,2,2,26,'Date','Terminus Ante Quem','Terminus_Ante_Quem_1_2_','Date at which the project location studied in this season begins to exhibit evidence of human activity.',0,0,0,0,1,1,1,'[M]0[M][D]0[D][Y]0[Y]','[!Circa!]No[!Circa!][!Start!]1[!Start!][!End!]9999[!End!][!Format!]MMDDYYYY[!Format!][!Era!]Yes[!Era!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(48,1,2,2,27,'Date','Terminus Post Quem','Terminus_Post_Quem_1_2_','Date at which the project location studied in this season ceases to exhibit evidence of human activity.',0,0,0,0,1,1,1,'[M]0[M][D]0[D][Y]0[Y]','[!Circa!]No[!Circa!][!Start!]1[!Start!][!End!]9999[!End!][!Format!]MMDDYYYY[!Format!][!Era!]Yes[!Era!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(49,1,2,2,28,'Text','Description','Description_1_2_','Concise narrative outlining the season, its goals, duration, outputs, etc.',0,0,0,0,1,1,1,'','[!Regex!][!Regex!][!MultiLine!]1[!MultiLine!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(50,1,2,2,29,'List','Orphan','Orphan_1_2_','Indicates that the Season record is not associated or linked to the appropriate Project record.\r\n\r\nTRUE=Not Associated to Project record\r\nFALSE=Associated to appropriate Project record',0,0,0,0,1,0,0,'','[!Options!]TRUE[!]FALSE[!Options!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(51,1,2,2,30,'Text','Project Name','Project_Name_1_2_','Include the name given to the project exactly as it is recorded in the Name field in the Project scheme. This will create a link between this Season record and the appropriate Project record it belongs to.\n\nRedundant data for batch upload.',0,0,0,0,1,0,0,'','[!Regex!][!Regex!][!MultiLine!]0[!MultiLine!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(52,1,3,3,0,'Associator','Excavation - Survey Associator','Excavation_-_Survey_Associator_1_3_','KORA identifier for the Excavation / Survey record that describes the field data collection unit when the archival object described in this Resource record was found.',0,0,0,0,1,1,1,'','[!SearchForms!][fid]6[fid][search]1[search][flids]139[flids][!SearchForms!]','2018-08-28 13:24:05','2018-08-28 15:24:20'),
	(53,1,3,3,1,'Associator','Season Associator','Season_Associator_1_3_','KORA identifier for the Season record that describes the period of time (season/campaign) when the archival object described in this Resource record was found.\r\n\r\nOnly use for Resources like surface finds that are not tied to an Excavation / Survey.',0,0,0,0,1,1,1,'','[!SearchForms!][fid]2[fid][search]1[search][flids]22[flids][!SearchForms!]','2018-08-28 13:24:05','2018-08-28 15:24:46'),
	(54,1,3,3,2,'Text','Resource Identifier','Resource_Identifier_1_3_','Unambiguous reference to a resource with in a given context.\r\n\r\nIsthmia: resource dependent code that uniquely identifies a an artifact or archival document',0,1,1,1,1,1,1,'','[!Regex!][!Regex!][!MultiLine!][!MultiLine!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(55,1,3,3,3,'List','Type','Type_1_3_','Classification of an original archival document that has been digitized (e.g. drawing, photograph, report, etc.)',0,0,1,1,1,1,1,' ','[!Options!][!Options!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(56,1,3,3,4,'Text','Title','Title_1_3_','Titles, identifying phrases, or names given to an original archival document that has been digitized\r\n\r\nUse only for titled pieces. \r\nARCS will NOT use an invented or created title for untitled resources.\r\n',0,1,1,1,1,1,1,'','[!Regex!][!Regex!][!MultiLine!]1[!MultiLine!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(57,1,3,3,5,'Text','Sub-title','Sub-title_1_3_','Subordinate title that provides additional information about the contents of original archival document that has been digitized ',0,0,0,0,1,1,1,'','[!Regex!][!Regex!][!MultiLine!]0[!MultiLine!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(58,1,3,3,6,'Multi-Select List','Creator','Creator_1_3_','Name or other unique identification of a known person or persons who created an original archival document that has been digitized',0,0,0,0,1,1,1,'','[!Options!][!Options!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(59,1,3,3,7,'Multi-Select List','Creator Role','Creator_Role_1_3_','Part played by resource creator.\n\nRole must be ordered appropriately to correspond with person identified in \"Creator\" field.',0,0,0,0,1,1,1,'','[!Options!][!Options!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(60,1,3,3,8,'Date','Earliest Date','Earliest_Date_1_3_','Production date of an original archival document that has been digitized, expressed in yyyy/mm/dd format',0,0,0,1,1,1,1,'[M]0[M][D]0[D][Y]0[Y]','[!Circa!]No[!Circa!][!Start!]1900[!Start!][!End!]2020[!End!][!Format!]YYYYMMDD[!Format!][!Era!]No[!Era!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(61,1,3,3,9,'Date','Latest Date','Latest_Date_1_3_','Latest date for the creation of an original archival document that has been digitized, expressed in yyyy/mm/dd format.\n\nThis is used for archival documents created during a span of time, for example field notebooks.\n',0,0,0,1,1,1,1,'[M]0[M][D]0[D][Y]0[Y]','[!Circa!]No[!Circa!][!Start!]1900[!Start!][!End!]2070[!End!][!Format!]YYYYMMDD[!Format!][!Era!]No[!Era!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(62,1,3,3,10,'Generated List','Dimensions','Dimensions_1_3_','Measured size of an original archival document that has been digitized\n\nIsthmia: Measurements for photographs, slides, negatives, maps and books are in meters written as whole numbers or decimal fractions to the nearest millimeter.',0,0,0,0,1,1,1,'','[!Regex!][!Regex!][!Options!][!Options!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(63,1,3,3,11,'Multi-Select List','Language','Language_1_3_','Language(s) of the resource itself.',0,0,0,0,1,1,1,'','[!Options!][!Options!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(64,1,3,3,12,'Text','Description','Description_1_3_','Characteristics of an original archival document that has been digitized',0,0,0,0,1,1,1,'','[!Regex!][!Regex!][!MultiLine!]1[!MultiLine!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(65,1,3,3,13,'Text','Transcription','Transcription_1_3_','Typed representation of words written in and/or on the document or resource.',0,0,0,0,1,1,1,'','[!Regex!][!Regex!][!MultiLine!]0[!MultiLine!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(66,1,3,3,14,'Text','Pages','Pages_1_3_','Number of pages in the document or resource.\n\nUse numeric expression only.\n\nUse for all resources in repository including documents, images, maps, and photographs.',0,0,0,0,1,1,1,'','[!Regex!][!Regex!][!MultiLine!]0[!MultiLine!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(67,1,3,3,15,'List','Condition','Condition_1_3_','Description of damage to an original archival document that has been digitized',0,0,0,0,1,1,1,'Good','[!Options!]Good[!]Fair[!]Poor[!Options!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(68,1,3,3,16,'Text','Rights','Rights_1_3_','Information about rights management; may include copyright and other intellectual property statements required for use regarding the resource and/or its associated electronic file.\n\nDefault: Creative Commons Attribution-NonCommercial 4.0 International',0,0,0,0,1,1,1,'','[!Regex!][!Regex!][!MultiLine!]1[!MultiLine!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(69,1,3,3,17,'Multi-Select List','Rights Holder','Rights_Holder_1_3_','Person or organization owning or managing rights over the resource.',0,0,0,0,1,1,1,'','[!Options!][!Options!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(70,1,3,3,18,'List','Permissions','Permissions_1_3_','Specifies the type of users who can access this Resource record. Choices: Public [open web]; Member [logged into ARCS]; Special [designated by Admin]',0,0,0,0,1,1,1,'','[!Options!]Public[!]Member[!]Special[!Options!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(71,1,3,3,19,'Text','Special User','Special_User_1_3_','Information about the person or people who have rights to access record and related metadata and digital files.\r\n\r\nARCS Admin designates \"Special Permission\" users.',0,0,0,0,1,1,1,'','[!Regex!][!Regex!][!MultiLine!]0[!MultiLine!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(72,1,3,3,20,'List','Repository','Repository_1_3_','The name of the repository that is currently responsible for the resource including general institutional address (state/region, country)\n\n',0,0,0,0,1,1,1,'','[!Options!][!Options!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(73,1,3,3,21,'Text','Accession Number','Accession_Number_1_3_','Any unique identifiers assigned to an original archival document that has been digitized by the current or last known repository',0,0,0,1,1,1,1,'','[!Regex!][!Regex!][!MultiLine!]0[!MultiLine!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(74,1,3,3,22,'Text','Date Range','Date_Range_1_3_','Production date of an original archival document that has been digitized, expressed in a range for documents created during a span of time, for example field notebooks, expressed in yyyy/mm/dd - yyyy/mm/dd format. [USE ONLY FOR ISTHMIA ARCS.1 DATA]',0,0,0,0,1,1,1,'','[!Regex!][!Regex!][!MultiLine!]0[!MultiLine!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(75,1,3,3,23,'Generated List','Creator2','Creator2_1_3_','For creators with initials only',0,0,0,0,1,1,1,'','[!Regex!][!Regex!][!Options!][!Options!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(76,1,3,3,24,'Text','id','id_1_3_','Administrative field for ARCS to record legacy database id',0,0,0,0,1,1,1,'','[!Regex!][!Regex!][!MultiLine!]0[!MultiLine!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(78,1,3,3,25,'Multi-Select List','Creator Role 2','Creator_Role_2_1_3_','',0,0,0,0,1,1,1,'','[!Options!][!Options!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(79,1,3,3,26,'List','Test','Test_1_3_','',0,0,0,0,1,0,0,'','[!Options!][!Options!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(80,1,3,3,27,'List','Orphan','Orphan_1_3_','Indicates that the Resource record is not associated or linked to the appropriate Excavation - Survey or Season record. \r\n\r\nTRUE=Not Associated to  Excavation - Survey or Season record \r\nFALSE=Associated to appropriate  Excavation - Survey or Season recor',0,1,0,1,1,0,0,'','[!Options!]TRUE[!]FALSE[!Options!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(81,1,3,3,28,'Text','Excavation - Survey Name','Excavation_-_Survey_Name_1_3_','Include the name given to the excavation exactly as it is recorded in the Name field in the Excavation - Survey scheme. This will create a link b/w this Resource and the appropriate Excavation record it belongs to.\n\nRedundant data for batch upload.',0,0,0,0,1,0,0,'','[!Regex!][!Regex!][!MultiLine!]0[!MultiLine!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(82,1,3,3,29,'Text','Season Title','Season_Title_1_3_','Include the name given to the season exactly as it is recorded in the Title field in the Season scheme. This will create a link b/w this Resource and the appropriate Season it belongs to.\r\n\r\nRedundant data for batch upload.',0,0,0,0,1,0,0,'','[!Regex!][!Regex!][!MultiLine!]0[!MultiLine!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(83,1,4,4,0,'Text','Resource Identifier','Resource_Identifier_1_4_','Unique identifier given to the original archival resource that has been scanned. This is the same as RESOURCE.Resource Identifier\n\nIsthmia: resource dependent code that uniquely identifies a an artifact or archival document',0,1,1,1,1,1,1,'','[!Regex!][!Regex!][!MultiLine!]0[!MultiLine!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(84,1,4,4,1,'Associator','Resource Associator','Resource_Associator_1_4_','KORA identifier for the Resource record that this Pages record is part of.\r\n\r\nThis Pages record contains a digital file and technical metadata for 1 scanned page of the referenced Resource.',0,1,0,1,1,1,1,'','[!SearchForms!][fid]3[fid][search]1[search][flids]56[flids][!SearchForms!]','2018-08-28 13:24:05','2018-08-28 15:25:17'),
	(85,1,4,4,2,'List','Format','Format_1_4_','Digital or electronic format of the access or distribution file of the resource.',0,0,0,0,1,0,0,'','[!Options!]jpeg[!Options!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(86,1,4,4,3,'List','Type','Type_1_4_','Broad term describing the nature or genre of digital file\n\nStillImage = Static visual representation other than text (used for drawings, plans, maps)\n\nText = Consisting primary of words for reading',0,0,0,0,1,0,0,'','[!Options!]StillImage[!]Text[!Options!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(87,1,4,4,4,'Text','Page Identifier','Page_Identifier_1_4_','Unique numeric or alphanumeric identification\n\nAlpha/numeric character string of file name for page including file extension.',0,1,0,1,1,1,1,'','[!Regex!][!Regex!][!MultiLine!]0[!MultiLine!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(88,1,4,4,5,'Number','Scan Number','Scan_Number_1_4_','Number indicating the scan sequence for a resource\r\n\r\nBegin sequence with 1, for the first scan of resource, followed by 2, 3, and 4',1,1,1,1,1,1,1,'1','[!Max!][!Max!][!Min!]1[!Min!][!Increment!]1[!Increment!][!Unit!][!Unit!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(89,1,4,4,6,'Gallery','Image Upload','Image_Upload_1_4_','Upload jpeg image file of scanned archival document.',0,0,0,0,1,1,1,'','[!FieldSize!]0[!FieldSize!][!ThumbSmall!]125x125[!ThumbSmall!][!ThumbLarge!]250x250[!ThumbLarge!][!MaxFiles!]0[!MaxFiles!][!FileTypes!]image/bmp[!]image/gif[!]image/jpeg[!]image/png[!FileTypes!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(90,1,4,4,7,'Text','Scan Specifications','Scan_Specifications_1_4_','Description of the dimensions, resolution, type of digitization and any other information pertinent to the creation of the electronic file.\nData types and formats:\nBit-depth (e.g., 8-bit, 16-bit, 24-bit, etc.); \ncolor mode (e.g., RGB, CMYK, or grayscale);',0,0,0,0,1,1,1,'','[!Regex!][!Regex!][!MultiLine!]0[!MultiLine!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(91,1,4,4,8,'Text','Scan Equipment','Scan_Equipment_1_4_','Name or other unique identifier of the device used to create an electronic file.\n\nData types and formats:\nScanner or digital camera brand, name, and model number; \nsoftware name and version',0,0,0,0,1,1,1,'','[!Regex!][!Regex!][!MultiLine!]0[!MultiLine!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(92,1,4,4,9,'Date','Scan Date','Scan_Date_1_4_','\r\nProduction date of the electronic file, expressed in yyyy/mm/dd format',0,0,0,0,1,0,0,'[M]0[M][D]0[D][Y]0[Y]','[!Circa!]No[!Circa!][!Start!]1970[!Start!][!End!]2070[!End!][!Format!]YYYYMMDD[!Format!][!Era!]No[!Era!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(93,1,4,4,10,'Text','Scan Creator','Scan_Creator_1_4_','Name or other unique identification of a known person responsible for the creation of the electronic file.',0,1,0,1,1,1,1,'','[!Regex!][!Regex!][!MultiLine!]0[!MultiLine!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(94,1,4,4,11,'List','Scan Creator Status','Scan_Creator_Status_1_4_','Information concerning whether the identification of a known person may appear in a publicly accessible format.\r\n\r\nPublic = Display name on website\r\nPrivate = Do not display name',0,0,0,0,1,1,1,'Public','[!Options!]Public[!]Private[!Options!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(95,1,4,4,12,'List','Orphan','Orphan_1_4_','Used during batch upload of image files to indicate that the Pages record is not associated or linked to the appropriate Resource record.\n\nTRUE=Not Associated to Resource record\nFALSE=Associated to appropriate Resource record',0,1,0,1,1,0,0,'','[!Options!]TRUE[!]FALSE[!Options!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(96,1,4,4,13,'Text','id','id_1_4_','Administrative field for ARCS to record  legacy database id',0,0,0,0,1,0,0,'','[!Regex!][!Regex!][!MultiLine!]0[!MultiLine!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(99,1,5,7,0,'Text','id','id_1_5_','',0,0,0,1,1,0,1,'','[!Regex!][!Regex!][!MultiLine!]0[!MultiLine!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(100,1,5,6,0,'Text','Artifact - Structure Title','Artifact_-_Structure_Title_1_5_','Titles, identifying phrases, or names given to an artifact or structure.',0,0,0,1,1,1,1,'','[!Regex!][!Regex!][!MultiLine!]1[!MultiLine!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(101,1,5,5,0,'Associator','Pages Associator','Pages_Associator_1_5_','KORA identifier for the specific page of the Resource that this Subject of Observation record describes.',0,1,0,1,1,1,1,'','[!SearchForms!][fid]4[fid][search]1[search][flids]83[flids][!SearchForms!]','2018-08-28 13:24:05','2018-08-28 15:25:49'),
	(103,1,5,6,1,'List','Artifact - Structure Current Location','Artifact_-_Structure_Current_Location_1_5_','The geographic location of the repository that is currently responsible for the artifact or structure',0,0,0,1,1,0,1,'','[!Options!][!Options!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(104,1,5,5,1,'Text','Resource Identifier','Resource_Identifier_1_5_','Unique identifier given to the original archival resource that has been scanned. This is the same as RESOURCE.Resource Identifier.\n\nIsthmia: resource dependent code that uniquely identifies a an artifact or archival document ',0,1,0,1,1,1,1,'','[!Regex!][!Regex!][!MultiLine!]0[!MultiLine!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(106,1,5,6,2,'List','Artifact - Structure Repository','Artifact_-_Structure_Repository_1_5_','The name of the repository that is currently responsible for the artifact or structure.',0,0,0,1,1,0,1,'','[!Options!][!Options!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(107,1,5,5,2,'Associator','Subject of Observation Associator','Subject_of_Observation_Associator_1_5_','KORA identifier for the Subject of Observations record(s) that describe the exact same artifact/structure.',0,1,0,1,1,1,1,'','[!SearchForms!][fid]5[fid][search]1[search][flids]99[flids][!SearchForms!]','2018-08-28 13:24:05','2018-08-28 15:26:08'),
	(108,1,5,5,3,'List','Artifact - Structure Classification','Artifact_-_Structure_Classification_1_5_','Specific category of artifact or structure according to a stated system.',0,1,0,1,1,1,1,'','[!Options!][!Options!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(109,1,5,6,3,'Text','Artifact - Structure Repository Accession Number','Artifact_-_Structure_Repository_Accession_Number_1_5_','Any unique identifiers assigned to an artifact or structure by the current or last known repository',0,0,0,1,1,0,1,'','[!Regex!][!Regex!][!MultiLine!]0[!MultiLine!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(110,1,5,5,4,'Multi-Select List','Artifact - Structure Type','Artifact_-_Structure_Type_1_5_','Physical characteristic of artifact or structure.',0,1,0,1,1,1,1,'','[!Options!][!Options!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(111,1,5,6,4,'Multi-Select List','Artifact - Structure Creator','Artifact_-_Structure_Creator_1_5_','Name or other unique identification of a known creator of the artifact or structure.',0,0,0,1,1,0,1,'','[!Options!][!Options!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(112,1,5,5,5,'Text','Artifact - Structure Type Qualifier','Artifact_-_Structure_Type_Qualifier_1_5_','Common and/or published system according to which an Artifact - Structure type has been determined.',0,0,0,1,1,0,1,'','[!Regex!][!Regex!][!MultiLine!]0[!MultiLine!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(113,1,5,6,5,'Multi-Select List','Artifact - Structure Creator Role','Artifact_-_Structure_Creator_Role_1_5_','Part played by artifact or structure creator.',0,1,1,1,1,1,1,'','[!Options!][!Options!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(114,1,5,5,6,'Multi-Select List','Artifact - Structure Material','Artifact_-_Structure_Material_1_5_','Matter from which the artifact or structure has been produced.',0,0,0,1,1,0,1,'','[!Options!][!Options!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(115,1,5,6,6,'Generated List','Artifact - Structure Dimensions','Artifact_-_Structure_Dimensions_1_5_','Measured size or scale of the artifact or structure.\n\nIsthmia: Measurements for walls, coins, etc. are in meters written as whole numbers or decimal fractions to the nearest millimeter.\n\nRequired format: \nheight: 0.280 m',0,0,0,0,1,0,0,'','[!Regex!][!Regex!][!Options!][!Options!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(116,1,5,5,7,'Multi-Select List','Artifact - Structure Technique','Artifact_-_Structure_Technique_1_5_','Manner of production of artifact or structure',0,0,0,1,1,0,1,'','[!Options!][!Options!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(117,1,5,6,7,'Generated List','Artifact - Structure Geolocation','Artifact_-_Structure_Geolocation_1_5_','Coordinate pair(s) (latitude and longitude) that establish a general location of project. \n\nFormatting: Latitude,Longitude for example: 41.255678,13.435335',0,0,0,0,1,1,1,'','[!Regex!][!Regex!][!Options!][!Options!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(118,1,5,5,8,'Multi-Select List','Artifact - Structure Archaeological Culture','Artifact_-_Structure_Archaeological_Culture_1_5_','Recognizable and recurring assemblage of artifacts from a specific time and place. Thought to constitute the material remains of a particular past human society or group',0,0,0,1,1,1,1,'','[!Options!][!Options!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(119,1,5,6,8,'Multi-Select List','Artifact - Structure Excavation Unit','Artifact_-_Structure_Excavation_Unit_1_5_','Pre-declared unit of excavated soil, known by a systematically assigned unique identifier.\n\nNot using for Isthmia.',0,0,0,0,1,1,1,'','[!Options!][!Options!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(120,1,5,5,9,'Multi-Select List','Artifact - Structure Period','Artifact_-_Structure_Period_1_5_','Named, defined portion of time whose characteristics are represented in the artifact or structure.',0,0,0,1,1,0,1,'','[!Options!][!Options!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(121,1,5,6,9,'Multi-Select List','Artifact - Structure Location','Artifact_-_Structure_Location_1_5_','Project specific name for spatial location of artifact / structure was first discovered',0,0,0,0,1,1,1,'','[!Options!][!Options!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(122,1,5,5,10,'Date','Artifact - Structure Terminus Ante Quem','Artifact_-_Structure_Terminus_Ante_Quem_1_5_','Date(s) before which an artifact  or structure could not have been produced',0,1,0,1,1,1,1,'[M]0[M][D]0[D][Y]0[Y]','[!Circa!]No[!Circa!][!Start!]1[!Start!][!End!]9999[!End!][!Format!]MMDDYYYY[!Format!][!Era!]Yes[!Era!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(123,1,5,6,10,'Text','Artifact - Structure Description','Artifact_-_Structure_Description_1_5_','General characteristics of an artifact or structure.',0,0,0,0,1,1,1,'','[!Regex!][!Regex!][!MultiLine!]1[!MultiLine!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(124,1,5,5,11,'Date','Artifact - Structure Terminus Post Quem','Artifact_-_Structure_Terminus_Post_Quem_1_5_','Date(s) after which an artifact or structure could not have been produced',0,1,0,1,1,1,1,'[M]0[M][D]0[D][Y]0[Y]','[!Circa!]No[!Circa!][!Start!]1[!Start!][!End!]9999[!End!][!Format!]MMDDYYYY[!Format!][!Era!]Yes[!Era!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(125,1,5,6,11,'Multi-Select List','Artifact - Structure Condition','Artifact_-_Structure_Condition_1_5_','Description of current physical state of artifact or structure',0,0,0,0,1,0,0,'','[!Options!][!Options!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(126,1,5,5,12,'List','Orphan','Orphan_1_5_','Indicates that the Subject of Observation record is not associated or linked to the appropriate Resource record. \r\n\r\nTRUE=Not Associated to Resource record \r\nFALSE=Associated to appropriate Resource record',0,0,0,1,1,0,1,'','[!Options!]TRUE[!]FALSE[!Options!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(127,1,5,6,12,'Text','Artifact - Structure Inscription','Artifact_-_Structure_Inscription_1_5_','Lettering marked on artifact, especially for documentation or commemoration',0,0,0,0,1,0,0,'','[!Regex!][!Regex!][!MultiLine!]1[!MultiLine!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(128,1,5,6,13,'Text','Artifact - Structure Munsell Number','Artifact_-_Structure_Munsell_Number_1_5_','Index number for artifact or structure color.',0,0,0,0,1,0,0,'','[!Regex!][!Regex!][!MultiLine!]0[!MultiLine!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(129,1,5,6,14,'Date','Artifact - Structure Date','Artifact_-_Structure_Date_1_5_','Production date of object; only to be used when a specific date is known.  Otherwise, Terminus ante and post quem should be used',0,0,0,0,1,0,0,'[M]0[M][D]0[D][Y]0[Y]','[!Circa!]No[!Circa!][!Start!]1[!Start!][!End!]2020[!End!][!Format!]MMDDYYYY[!Format!][!Era!]Yes[!Era!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(130,1,5,6,15,'Multi-Select List','Artifact - Structure Subject','Artifact_-_Structure_Subject_1_5_','General term(s) that identity the content or topic of a work of art; it is what is depicted in and by a work of art. It can also identify the function of an artifact or structure (architecture) that does not have narrative content.',0,0,1,1,1,1,1,'','[!Options!][!Options!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(131,1,5,6,16,'List','Artifact - Structure Origin','Artifact_-_Structure_Origin_1_5_','Original production location of artifact or structure.',0,0,0,0,1,0,0,'','[!Options!][!Options!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(132,1,5,6,17,'Text','Artifact - Structure Comparanda','Artifact_-_Structure_Comparanda_1_5_','Published examples of other artifacts or structures that are similar in type or style.',0,0,0,0,1,0,0,'','[!Regex!][!Regex!][!MultiLine!]1[!MultiLine!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(133,1,5,6,18,'Text','Artifact - Structure Archaeological Context','Artifact_-_Structure_Archaeological_Context_1_5_','Three dimensional position of find, and its relationship to other elements in the site\'s archaeological record',0,0,0,0,1,0,0,'','[!Regex!][!Regex!][!MultiLine!]1[!MultiLine!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(134,1,5,6,19,'Text','Artifact - Structure Shelving Location','Artifact_-_Structure_Shelving_Location_1_5_','Shelf mark or other shelving designation that indicates the location where the physical artifact/structure is available (on a shelf or in cabinet, for example).',0,0,0,0,1,0,0,'','[!Regex!][!Regex!][!MultiLine!]0[!MultiLine!]','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(135,1,5,6,20,'Generated List','Trench','Trench_1_5_','For Isthmia, redundant reference for Name of Trench found in Excavation - Survey scheme ',0,0,0,1,1,0,1,'','[!Regex!][!Regex!][!Options!][!Options!]','2018-08-28 13:24:06','2018-08-28 13:24:06'),
	(136,1,5,6,21,'Text','Page Identifier','Page_Identifier_1_5_','Include the unique identifier given to the the scanned page exactly as recorded in the Page Identifier field in the Pages scheme. This will create a link between this SOO record and the Pages record it describes.\r\n\r\nRedundant data for batch upload.',0,0,0,1,1,0,1,'','[!Regex!][!Regex!][!MultiLine!]0[!MultiLine!]','2018-08-28 13:24:06','2018-08-28 13:24:06'),
	(137,1,6,8,0,'Associator','Season Associator','Season_Associator_1_6_','KORA identifier for the Season record that describes the period of time (season/campaign) during which this Excavation - Survey took place.',0,0,0,0,1,1,1,'','[!SearchForms!][fid]2[fid][search]1[search][flids]22[flids][!SearchForms!]','2018-08-28 13:24:06','2018-08-28 15:26:35'),
	(139,1,6,8,1,'Text','Name','Name_1_6_','Spatial section composed of material items and features, within codes developed for the project.\n\nUse a consistent format.\n\nIsthmia: YY-XXX-NN\nYY is 2-digit code for year of excavation, XXX is 2 or 3 letter code for location, and NN is trench number',0,1,1,1,1,1,1,'','[!Regex!][!Regex!][!MultiLine!]0[!MultiLine!]','2018-08-28 13:24:06','2018-08-28 13:24:06'),
	(140,1,6,8,2,'List','Type','Type_1_6_','Type of excavation or survey (e.g. open area, test trench, intensive)',0,0,0,1,1,1,1,'Trench','[!Options!]Trench[!]Survey[!]Study/Lab[!Options!]','2018-08-28 13:24:06','2018-08-28 13:24:06'),
	(141,1,6,8,3,'Multi-Select List','Supervisor','Supervisor_1_6_','Person or persons who directly supervised the excavation or survey of a spatial section ',0,1,1,1,1,1,1,'','[!Options!][!Options!]','2018-08-28 13:24:06','2018-08-28 13:24:06'),
	(142,1,6,8,4,'Date','Earliest Date','Earliest_Date_1_6_','Earliest date associated with project activity for this particular excavation/survey, expressed in yyyy/mm/dd format',0,0,0,0,1,1,1,'[M]0[M][D]0[D][Y]1970[Y]','[!Circa!]No[!Circa!][!Start!]1960[!Start!][!End!]2020[!End!][!Format!]MMDDYYYY[!Format!][!Era!]No[!Era!]','2018-08-28 13:24:06','2018-08-28 13:24:06'),
	(143,1,6,8,5,'Date','Latest Date','Latest_Date_1_6_','Latest date associated with project activity for this particular excavation/survey, expressed in yyyy/mm/dd format',0,0,0,0,1,1,1,'[M]0[M][D]0[D][Y]1970[Y]','[!Circa!]No[!Circa!][!Start!]1960[!Start!][!End!]2020[!End!][!Format!]MMDDYYYY[!Format!][!Era!]No[!Era!]','2018-08-28 13:24:06','2018-08-28 13:24:06'),
	(144,1,6,8,6,'Date','Terminus Ante Quem','Terminus_Ante_Quem_1_6_','Date at which the excavation/survey unit begins to exhibit evidence of human activity.',0,0,0,0,1,1,1,'[M]0[M][D]0[D][Y]0[Y]','[!Circa!]No[!Circa!][!Start!]1[!Start!][!End!]9999[!End!][!Format!]MMDDYYYY[!Format!][!Era!]Yes[!Era!]','2018-08-28 13:24:06','2018-08-28 13:24:06'),
	(145,1,6,8,7,'Date','Terminus Post Quem','Terminus_Post_Quem_1_6_','Date at which the excavation/survey unit ceases to exhibit evidence of human activity.',0,0,0,0,1,1,1,'[M]0[M][D]0[D][Y]0[Y]','[!Circa!]No[!Circa!][!Start!]1[!Start!][!End!]9999[!End!][!Format!]MMDDYYYY[!Format!][!Era!]Yes[!Era!]','2018-08-28 13:24:06','2018-08-28 13:24:06'),
	(146,1,6,8,8,'Text','Excavation Stratigraphy','Excavation_Stratigraphy_1_6_','Concise narrative description of the successive levels of excavated material',0,0,0,0,1,1,1,'','[!Regex!][!Regex!][!MultiLine!]1[!MultiLine!]','2018-08-28 13:24:06','2018-08-28 13:24:06'),
	(147,1,6,8,9,'Text','Survey Conditions','Survey_Conditions_1_6_','Concise narrative description of the condition of the surveyed area (e.g. terrain, ground cover)',0,0,0,0,1,1,1,'','[!Regex!][!Regex!][!MultiLine!]1[!MultiLine!]','2018-08-28 13:24:06','2018-08-28 13:24:06'),
	(148,1,6,8,10,'Text','Post Dispositional Transformation','Post_Dispositional_Transformation_1_6_','Concise narrative description of anthropogenic alterations to the excavation / survey unit.',0,0,0,0,1,1,1,'','[!Regex!][!Regex!][!MultiLine!]1[!MultiLine!]','2018-08-28 13:24:06','2018-08-28 13:24:06'),
	(149,1,6,8,11,'List','Orphan','Orphan_1_6_','Indicates that the Excavation - Survey record is not associated or linked to the appropriate Season record. \r\n\r\nTRUE=Not Associated to Season record \r\nFALSE=Associated to appropriate Season record',0,0,0,0,1,0,0,'','[!Options!]TRUE[!]FALSE[!Options!]','2018-08-28 13:24:06','2018-08-28 13:24:06'),
	(150,1,6,8,12,'Text','Season Title','Season_Title_1_6_','Include the name given to the season exactly as it is recorded in the Title field in the Season scheme. This will create a link between this Excavation - Survey record and the appropriate Season record it belongs to.\r\n\r\nThis is redundant data for batch up',0,0,0,0,1,0,0,'','[!Regex!][!Regex!][!MultiLine!]0[!MultiLine!]','2018-08-28 13:24:06','2018-08-28 13:24:06');

/*!40000 ALTER TABLE `kora3_fields` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table kora3_form_custom
# ------------------------------------------------------------

LOCK TABLES `kora3_form_custom` WRITE;
/*!40000 ALTER TABLE `kora3_form_custom` DISABLE KEYS */;

INSERT INTO `kora3_form_custom` (`id`, `uid`, `pid`, `fid`, `sequence`, `created_at`, `updated_at`)
VALUES
	(1,1,1,1,0,'2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(2,1,1,2,1,'2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(3,1,1,3,2,'2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(4,1,1,4,3,'2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(5,1,1,5,4,'2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(6,1,1,6,5,'2018-08-28 13:24:06','2018-08-28 13:24:06');

/*!40000 ALTER TABLE `kora3_form_custom` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table kora3_form_group_user
# ------------------------------------------------------------

LOCK TABLES `kora3_form_group_user` WRITE;
/*!40000 ALTER TABLE `kora3_form_group_user` DISABLE KEYS */;

INSERT INTO `kora3_form_group_user` (`form_group_id`, `user_id`)
VALUES
	(1,1),
	(3,1),
	(5,1),
	(7,1),
	(9,1),
	(11,1);

/*!40000 ALTER TABLE `kora3_form_group_user` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table kora3_form_groups
# ------------------------------------------------------------

LOCK TABLES `kora3_form_groups` WRITE;
/*!40000 ALTER TABLE `kora3_form_groups` DISABLE KEYS */;

INSERT INTO `kora3_form_groups` (`id`, `name`, `fid`, `create`, `edit`, `delete`, `ingest`, `modify`, `destroy`, `created_at`, `updated_at`)
VALUES
	(1,'Project Admin Group',1,1,1,1,1,1,1,'2018-08-28 13:24:04','2018-08-28 13:24:05'),
	(2,'Project Default Group',1,0,0,0,0,0,0,'2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(3,'Season Admin Group',2,1,1,1,1,1,1,'2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(4,'Season Default Group',2,0,0,0,0,0,0,'2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(5,'Resource Admin Group',3,1,1,1,1,1,1,'2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(6,'Resource Default Group',3,0,0,0,0,0,0,'2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(7,'Pages Admin Group',4,1,1,1,1,1,1,'2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(8,'Pages Default Group',4,0,0,0,0,0,0,'2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(9,'Subject of Observation Admin Group',5,1,1,1,1,1,1,'2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(10,'Subject of Observation Default Group',5,0,0,0,0,0,0,'2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(11,'Excavation - Survey Admin Group',6,1,1,1,1,1,1,'2018-08-28 13:24:06','2018-08-28 13:24:06'),
	(12,'Excavation - Survey Default Group',6,0,0,0,0,0,0,'2018-08-28 13:24:06','2018-08-28 13:24:06');

/*!40000 ALTER TABLE `kora3_form_groups` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table kora3_forms
# ------------------------------------------------------------

LOCK TABLES `kora3_forms` WRITE;
/*!40000 ALTER TABLE `kora3_forms` DISABLE KEYS */;

INSERT INTO `kora3_forms` (`fid`, `pid`, `adminGID`, `name`, `slug`, `description`, `preset`, `public_metadata`, `lod_resource`, `created_at`, `updated_at`)
VALUES
	(1,1,1,'Project','Project','Information about the overarching archaeological enterprise, including data that define the project in the modern era and the project location in antiquity',0,0,'','2018-08-28 13:24:04','2018-08-28 13:24:05'),
	(2,1,3,'Season','Season','Information about the period of time (season/campaign) during which archaeological research was conducted',0,0,'','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(3,1,5,'Resource','Resource','Information about 1 archival object (document, map, photograph, etc.) created during the archaeological field research process',1,0,'','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(4,1,7,'Pages','Pages','Technical and organizational information about a single scanned page of the digitized archival document',1,0,'','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(5,1,9,'Subject of Observation','Subject_of_Observation','Information about the archeological item that is the topic of study in the original archival document (i.e. topic or subject of the inventory card).',1,0,'','2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(6,1,11,'Excavation - Survey','Excavation_-_Survey','Information about 1 field data collection unit when archaeological research was conducted',1,0,'','2018-08-28 13:24:06','2018-08-28 13:24:06');

/*!40000 ALTER TABLE `kora3_forms` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table kora3_migrations
# ------------------------------------------------------------

LOCK TABLES `kora3_migrations` WRITE;
/*!40000 ALTER TABLE `kora3_migrations` DISABLE KEYS */;

INSERT INTO `kora3_migrations` (`id`, `migration`, `batch`)
VALUES
	(1,'2015_00_00_000000_create_combo_list_fields_table',1),
	(2,'2015_00_00_000001_create_datefields_table',1),
	(3,'2015_00_00_000002_create_documentsfields_table',1),
	(4,'2015_00_00_000003_create_galleryfields_table',1),
	(5,'2015_00_00_000004_create_generatedlistfields_table',1),
	(6,'2015_00_00_000005_create_geolocatorfields_table',1),
	(7,'2015_00_00_000006_create_listfields_table',1),
	(8,'2015_00_00_000007_create_modelfields_table',1),
	(9,'2015_00_00_000008_create_multiselectlistfields_table',1),
	(10,'2015_00_00_000009_create_numberfields_table',1),
	(11,'2015_00_00_000010_create_playlistfields_table',1),
	(12,'2015_00_00_000011_create_richtextfields_table',1),
	(13,'2015_00_00_000012_create_schedulefields_table',1),
	(14,'2015_00_00_000013_create_textfields_table',1),
	(15,'2015_00_00_000014_create_videofields_table',1),
	(16,'2015_04_03_151510_CreateProjectsTable',1),
	(17,'2015_04_03_151648_create_password_resets_table',1),
	(18,'2015_04_03_152745_CreateFormsTable',1),
	(19,'2015_05_01_140126_CreateFieldsTable',1),
	(20,'2015_05_18_173954_create_records_table',1),
	(21,'2015_06_17_134524_CreateUsersTable',1),
	(22,'2015_06_19_152400_CreateTokensTable',1),
	(23,'2015_07_01_122103_CreateMetadataTable',1),
	(24,'2015_07_09_171601_create_project_groups_table',1),
	(25,'2015_07_15_172743_create_form_groups_table',1),
	(26,'2015_07_23_181833_create_revisions_table',1),
	(27,'2015_08_21_154839_create_recordpresets_table',1),
	(28,'2015_08_21_194838_create_associatorfields_table',1),
	(29,'2015_09_14_201213_create_optionpresets_table',1),
	(30,'2015_10_07_175909_create_associations_table',1),
	(31,'2015_11_23_193021_create_versions_table',1),
	(32,'2016_05_10_205219_backup_support',1),
	(33,'2016_05_20_204314_create_backup_progress_tables',1),
	(34,'2016_05_23_204821_create_jobs_table',1),
	(35,'2016_05_23_204859_create_failed_jobs_table',1),
	(36,'2016_08_16_180221_create_plugins_table',1),
	(37,'2016_09_23_162317_create_download_trackers_table',1),
	(38,'2016_10_27_193957_CreateRestoreProgressTables',1),
	(39,'2016_12_08_171347_CreateExodusProgressTables',1),
	(40,'2017_01_12_190618_CreateDashboardTables',1),
	(41,'2017_03_28_185021_CreatePagesTable',1),
	(42,'2017_08_10_175125_CreateGlobalCacheTable',1),
	(43,'2017_08_25_171638_CreateProjectCustomTable',1),
	(44,'2017_08_30_171426_CreateFormCustomTable',1),
	(45,'9999_99_99_999999_create_preferences_table',1),
	(46,'9999_99_99_999999_create_scripts_table',1);

/*!40000 ALTER TABLE `kora3_migrations` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table kora3_pages
# ------------------------------------------------------------

LOCK TABLES `kora3_pages` WRITE;
/*!40000 ALTER TABLE `kora3_pages` DISABLE KEYS */;

INSERT INTO `kora3_pages` (`id`, `fid`, `title`, `sequence`, `created_at`, `updated_at`)
VALUES
	(1,1,'Project',0,'2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(2,2,'Season',0,'2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(3,3,'Resource',0,'2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(4,4,'Pages',0,'2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(5,5,'General Description',0,'2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(6,5,'Detailed Description',1,'2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(7,5,'Legacy',2,'2018-08-28 13:24:05','2018-08-28 13:24:05'),
	(8,6,'Excavation - Survey',0,'2018-08-28 13:24:06','2018-08-28 13:24:06'),
	(9,6,'Reference',1,'2018-08-28 13:24:06','2018-08-28 13:24:06');

/*!40000 ALTER TABLE `kora3_pages` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table kora3_project_custom
# ------------------------------------------------------------

LOCK TABLES `kora3_project_custom` WRITE;
/*!40000 ALTER TABLE `kora3_project_custom` DISABLE KEYS */;

INSERT INTO `kora3_project_custom` (`id`, `uid`, `pid`, `sequence`, `created_at`, `updated_at`)
VALUES
	(1,1,1,0,'2018-08-28 13:24:04','2018-08-28 13:24:04');

/*!40000 ALTER TABLE `kora3_project_custom` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table kora3_project_group_user
# ------------------------------------------------------------

LOCK TABLES `kora3_project_group_user` WRITE;
/*!40000 ALTER TABLE `kora3_project_group_user` DISABLE KEYS */;

INSERT INTO `kora3_project_group_user` (`project_group_id`, `user_id`)
VALUES
	(1,1);

/*!40000 ALTER TABLE `kora3_project_group_user` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table kora3_project_groups
# ------------------------------------------------------------

LOCK TABLES `kora3_project_groups` WRITE;
/*!40000 ALTER TABLE `kora3_project_groups` DISABLE KEYS */;

INSERT INTO `kora3_project_groups` (`id`, `name`, `pid`, `create`, `edit`, `delete`, `created_at`, `updated_at`)
VALUES
	(1,'ARCS Project Admin Group',1,1,1,1,'2018-08-28 13:24:04','2018-08-28 16:48:59'),
	(2,'ARCS Project Default Group',1,0,0,0,'2018-08-28 13:24:04','2018-08-28 16:48:59');

/*!40000 ALTER TABLE `kora3_project_groups` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table kora3_project_token
# ------------------------------------------------------------

LOCK TABLES `kora3_project_token` WRITE;
/*!40000 ALTER TABLE `kora3_project_token` DISABLE KEYS */;

INSERT INTO `kora3_project_token` (`project_pid`, `token_id`)
VALUES
	(1,1);

/*!40000 ALTER TABLE `kora3_project_token` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table kora3_projects
# ------------------------------------------------------------

LOCK TABLES `kora3_projects` WRITE;
/*!40000 ALTER TABLE `kora3_projects` DISABLE KEYS */;

INSERT INTO `kora3_projects` (`pid`, `name`, `slug`, `description`, `adminGID`, `active`, `created_at`, `updated_at`)
VALUES
	(1,'ARCS Project','ARCS_Project','Archaeological Resource Cataloging System',1,1,'2018-08-28 13:24:04','2018-08-28 16:48:59');

/*!40000 ALTER TABLE `kora3_projects` ENABLE KEYS */;
UNLOCK TABLES;


# Dump of table kora3_tokens
# ------------------------------------------------------------

LOCK TABLES `kora3_tokens` WRITE;
/*!40000 ALTER TABLE `kora3_tokens` DISABLE KEYS */;

INSERT INTO `kora3_tokens` (`id`, `token`, `title`, `search`, `create`, `edit`, `delete`, `created_at`, `updated_at`)
VALUES
	(1,'WTI4VtJabtjOcpt4ke0OgPvU','ARCS',1,1,1,1,'2018-08-29 13:35:46','2018-08-29 13:35:46');

/*!40000 ALTER TABLE `kora3_tokens` ENABLE KEYS */;
UNLOCK TABLES;


/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;
/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
