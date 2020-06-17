
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
DROP TABLE IF EXISTS `be_permissions`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `be_permissions` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `be_permissions` WRITE;
/*!40000 ALTER TABLE `be_permissions` DISABLE KEYS */;
/*!40000 ALTER TABLE `be_permissions` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `be_roles`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `be_roles` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `permissions` blob DEFAULT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `be_roles` WRITE;
/*!40000 ALTER TABLE `be_roles` DISABLE KEYS */;
/*!40000 ALTER TABLE `be_roles` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `be_users`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `be_users` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `be_users` WRITE;
/*!40000 ALTER TABLE `be_users` DISABLE KEYS */;
INSERT INTO `be_users` VALUES (1,'admin','password',NULL,NULL);
/*!40000 ALTER TABLE `be_users` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `centauri_frontend_boxitems`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `centauri_frontend_boxitems` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lid` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `hidden` int(11) NOT NULL DEFAULT 0,
  `sorting` int(11) NOT NULL,
  `parent_uid` int(11) DEFAULT NULL,
  `icon` int(11) DEFAULT NULL,
  `header` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bgcolor_start` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bgcolor_end` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `col_desktop` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '3',
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `centauri_frontend_boxitems` WRITE;
/*!40000 ALTER TABLE `centauri_frontend_boxitems` DISABLE KEYS */;
INSERT INTO `centauri_frontend_boxitems` VALUES (1,1,'2020-05-10 10:40:39','2020-05-13 08:48:55',NULL,0,1,10,1,'Multisites ?','<p>Your website requires multi-domain sites for e.g. subdomains?<br>CentauriCMS got you covered - with its <strong>powerful Domains-Module </strong>you can easily manage all your domains with ease!</p>','#ff5abc','#6c66ff','4'),(2,1,'2020-05-10 10:41:08','2020-05-13 08:48:55',NULL,0,2,10,NULL,'Multilingual ','<p>We love localizations - you also might love Centauri when you see its <strong>Multilingual feature</strong>. It\'s easy to manage your elements while also in the same moment being able to localize them or general manage languages for your website-content.</p>','#ff5abc','#6c66ff','4'),(3,1,'2020-05-10 11:40:13','2020-05-13 08:48:55',NULL,0,3,10,NULL,'SEO-Friendly-URLs ?','<p>No need for third-party-plugins for SEO friendly URLs - Centauri does it out-of-box as main feature.<br>Manage whether a page should get indexed, follows links or changing the slug of a page by some clicks in the <strong>Backend</strong> with the powerful <strong>Editor-Component</strong>.</p>','#ff5abc','#6c66ff','4'),(4,1,'2020-05-10 12:15:20','2020-05-10 12:33:05',NULL,0,4,10,NULL,'Ultra fast & modern Backend UI/UX ?','<p>Since the main idea of Centauri was being a CMS which is performance on a high-level aswell on an easy-level of extending itself or updating its core without getting an unreachable website e.g. other CMS could have when updating, this will never be the case with Centauri. <strong>Its Backend has been built for performance - the fastest is the best</strong>.</p>','#ff5abc','#6c66ff','5'),(5,1,'2020-05-10 12:30:31','2020-05-13 08:48:55',NULL,0,5,10,NULL,'Easily Extendable ?','<p>Thanks to Centauri\'s well-documented Guide how to extend it - whether by yourself as/an external developer or using third-party-extensions for Centauri</p>','#ff5abc','#6c66ff','4'),(6,1,'2020-05-13 12:24:42','2020-05-13 20:57:40',NULL,0,6,14,NULL,'STARTER','<h1 style=\"text-align:center;\">4€/monthly</h1><p style=\"text-align:center;\">this plan is perfect for users who meeting CentauriCMS for the very first time.</p><p style=\"text-align:center;\">You might consider to upgrade your plan to the <strong>Premium </strong>which has some better features aswell as far more support than the <strong>Starter</strong>.</p>','#ff5abc 66%','white 35%','4');
/*!40000 ALTER TABLE `centauri_frontend_boxitems` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `centauri_frontend_slideritem_buttons`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `centauri_frontend_slideritem_buttons` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lid` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `hidden` int(11) NOT NULL DEFAULT 0,
  `sorting` int(11) NOT NULL,
  `parent_uid` int(11) DEFAULT NULL,
  `label` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `bgcolor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `centauri_frontend_slideritem_buttons` WRITE;
/*!40000 ALTER TABLE `centauri_frontend_slideritem_buttons` DISABLE KEYS */;
INSERT INTO `centauri_frontend_slideritem_buttons` VALUES (2,1,'2020-05-08 18:54:10','2020-05-09 19:23:41',NULL,1,2,1,'sdfdsf','sfdsf',''),(22,1,'2020-05-08 13:25:03','2020-05-09 19:42:29',NULL,0,1,1,'Learn more','/about','#00c851');
/*!40000 ALTER TABLE `centauri_frontend_slideritem_buttons` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `centauri_frontend_slideritems`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `centauri_frontend_slideritems` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lid` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `hidden` int(11) NOT NULL DEFAULT 0,
  `sorting` int(11) NOT NULL,
  `parent_uid` int(11) DEFAULT NULL,
  `image` int(11) DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `teasertext` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `bgcolor` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `centauri_frontend_slideritems` WRITE;
/*!40000 ALTER TABLE `centauri_frontend_slideritems` DISABLE KEYS */;
INSERT INTO `centauri_frontend_slideritems` VALUES (1,1,'2020-05-08 06:39:55','2020-05-27 19:16:20',NULL,0,2,1,8,'Centauri CMS is here','Not only for large entrepreneurs - Centauri also covers the small with low-budgets!','','rgba(0, 0, 0, 0.9)'),(2,1,'2020-05-08 06:40:21','2020-05-28 07:36:42',NULL,0,3,1,4,'3aaaaaaaaaaaaaaaaaaaaaaaaaaa4','bnbbbbb','','');
/*!40000 ALTER TABLE `centauri_frontend_slideritems` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `centauri_jobs`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `centauri_jobs` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lid` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `hidden` int(11) NOT NULL DEFAULT 0,
  `sorting` int(11) NOT NULL DEFAULT 0,
  `headerimage` int(11) DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `centauri_jobs` WRITE;
/*!40000 ALTER TABLE `centauri_jobs` DISABLE KEYS */;
INSERT INTO `centauri_jobs` VALUES (1,1,'2020-06-01 10:39:36','2020-06-03 07:16:24',NULL,0,0,8,'Core Developer (Fullstack)','<p>We are still looking for atleast one more active core developer (as fullstack - means he/she is included in frontend aswell in backend tasks for the CMS itself and for the live site both) who can work in their own free-time (!) since the CMS is still in a beta phase and a startup at the moment, which means it makes no profit at the moment.</p><p><u>Your tasks mainly includes:</u></p><ul><li>Making new concepts with core team</li><li>Implementation of those concepts/features</li><li>Improvements how customers and developers could both benefit</li><li>Obiviously as a fullstack also having expertise knowledge in HTML, CSS (SASS/SCSS), JS (jQuery), PHP, SQL, JSON and OOP.</li><li>Laravel experience (Modelling, Templating (Blade-Engine) are depending on Laravel</li></ul><p>Working remotely from home is appreciated during current circumstances.</p><p>When you feel like those tasks fits your profile feel free to contact and apply<br>for the given job as <strong>Core Developer</strong> for Centauri to:<br><a href=\"mailto:contact@centauricms.de\">contact@centauricms.de</a>.&nbsp;</p>','core-developer-fullstack');
/*!40000 ALTER TABLE `centauri_jobs` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `centauri_news`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `centauri_news` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `lid` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `author` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `hidden` int(11) NOT NULL DEFAULT 0,
  `sorting` int(11) NOT NULL DEFAULT 0,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `headerimage` int(11) DEFAULT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `centauri_news` WRITE;
/*!40000 ALTER TABLE `centauri_news` DISABLE KEYS */;
INSERT INTO `centauri_news` VALUES (1,1,'2020-05-30 21:46:46','2020-06-03 08:42:03',NULL,'Centauri Release Date','Centauri Core Team','centauri-release-date',0,0,'<p>The targeted release date for Centauri - which is yet in a beta phase - will be around <strong>end of the year 2020</strong>.</p><p>This date has been picked since until that Centauri will add several features which will be:</p><ul><li><strong>Schedulers</strong> (<strong>centauri_scheduler</strong> - core extension - will be shipped-in when installing the CMS)</li><li><strong>Index-Search</strong> and <strong>Crawler</strong> (<strong>centauri_search</strong> &amp; <strong>centauri_crawler</strong><i>)</i></li><li>Better overview of the System-Module in the backend</li><li>Finishing <strong>centauri_tracker</strong> core extension for the Dashboard-Module.</li></ul>',NULL);
/*!40000 ALTER TABLE `centauri_news` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `elements`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `elements` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `lid` int(11) NOT NULL,
  `rowPos` int(11) NOT NULL,
  `colPos` int(11) NOT NULL,
  `sorting` int(11) NOT NULL,
  `ctype` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `plugin` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `hidden` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `grid` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grids_parent` int(11) DEFAULT NULL,
  `grids_sorting_rowpos` int(11) DEFAULT NULL,
  `grids_sorting_colpos` int(11) DEFAULT NULL,
  `header` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `slideritems` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `slideritems_buttons` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '0',
  `file` int(11) DEFAULT NULL,
  `image` int(11) DEFAULT NULL,
  `htag` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `subheader` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '',
  `RTE` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grid_container_fullwidth` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grid_space_top` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grid_space_left` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grid_space_bottom` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `grid_space_right` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `colorpicker` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `elements` WRITE;
/*!40000 ALTER TABLE `elements` DISABLE KEYS */;
INSERT INTO `elements` VALUES (1,1,1,0,0,4,'slider',NULL,0,'2020-05-08 08:39:51','2020-06-02 15:00:42',NULL,NULL,NULL,NULL,NULL,'','0','0',NULL,NULL,'','',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(2,1,1,0,0,1,'headerimage',NULL,0,'2020-05-09 06:44:23','2020-05-09 09:12:35','2020-05-13 12:05:39',NULL,NULL,NULL,NULL,'CentauriCMS','0','0',NULL,8,'','',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(3,2,1,0,0,2,'headerimage',NULL,0,'2020-05-09 09:27:16','2020-06-03 08:31:19','2020-06-03 08:31:19',NULL,16,0,0,'Centauri News','0','0',NULL,NULL,'','','<h3>Make sure to <a href=\"/newsletter\">subscribe to our newsletter here</a>!</h3>',NULL,NULL,NULL,NULL,NULL,NULL),(4,1,1,0,0,9,'headerimage',NULL,1,'2020-05-09 22:33:02','2020-06-02 15:00:42',NULL,NULL,NULL,NULL,NULL,'Features','0','0',NULL,8,'','Ready - Set - Go!','<p><br data-cke-filler=\"true\"></p>',NULL,NULL,NULL,NULL,NULL,NULL),(5,1,1,0,0,4,'headerdescription',NULL,0,'2020-05-09 22:34:29','2020-06-02 15:00:42',NULL,NULL,6,0,0,'','0','0',NULL,NULL,'h1','','<h3>You may asking right now, why Centauri?</h3><p>Well, you <strong>could</strong>​​​​​​​ simply compare features between Centauri with other CMS - but you\'ll quickly notice that CentauriCMS is the better choice - why? Take a look below ?</p>',NULL,NULL,NULL,NULL,NULL,NULL),(6,1,1,0,0,5,'grids',NULL,0,'2020-05-09 22:36:15','2020-06-02 15:00:42',NULL,'onecol',NULL,NULL,NULL,'','0','0',NULL,NULL,'','',NULL,'0','mt-5','','mb-5','',NULL),(7,4,1,0,0,3,'headerdescription',NULL,0,'2020-05-10 07:24:35','2020-06-02 15:00:42',NULL,NULL,8,0,0,'','0','0',NULL,NULL,'h1','','<h2><strong>CentauriCMS » Legal notice</strong></h2><p>Last updated: May 10th, 2020</p><p><strong>Information provided according to § 5 TMG:</strong><br>Matiula Sediqi<br>Balthasar-Neumann-Straße 97<br>70437 Stuttgart<br>Deutschland</p><p><strong>Contact:</strong><br>E-Mail (Requests / General): info@centauricms.de<br>Telefon: +491791209506</p><p><strong>VAT:</strong><br>VAT id number according §27 a Umsatzsteuergesetz:<br>DE0000000000</p>',NULL,NULL,NULL,NULL,NULL,NULL),(8,4,1,0,0,4,'grids',NULL,0,'2020-05-10 08:07:33','2020-06-02 15:00:42',NULL,'onecol',NULL,NULL,NULL,'','0','0',NULL,NULL,'','',NULL,'0','mt-5','','mb-5','',NULL),(9,1,1,0,0,7,'titleteaser',NULL,0,'2020-05-11 11:18:20','2020-06-02 15:00:42',NULL,NULL,NULL,NULL,NULL,'Features ?','0','0',NULL,NULL,'','',NULL,NULL,NULL,NULL,NULL,NULL,'#ff5abc'),(10,1,1,0,0,3,'boxitems',NULL,0,'2020-05-11 11:24:13','2020-06-02 15:00:42',NULL,NULL,11,0,0,'','0','0',NULL,NULL,'','',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(11,1,1,0,0,11,'grids',NULL,0,'2020-05-11 17:39:59','2020-06-02 15:00:42',NULL,'onecol',NULL,NULL,NULL,'','0','0',NULL,NULL,'','',NULL,'0','','','mb-5','',NULL),(12,1,1,0,0,13,'titleteaser',NULL,0,'2020-05-13 10:49:20','2020-06-02 15:00:42',NULL,NULL,NULL,NULL,NULL,'Plans ?','0','0',NULL,NULL,'','',NULL,NULL,NULL,NULL,NULL,NULL,'hotpink'),(13,1,1,0,0,15,'grids',NULL,0,'2020-05-13 10:50:15','2020-06-02 15:00:42',NULL,'onecol',NULL,NULL,NULL,'','0','0',NULL,NULL,'','',NULL,'0','mt-5','','','',NULL),(14,1,1,0,0,13,'boxitems',NULL,0,'2020-05-13 12:10:15','2020-06-02 15:00:42',NULL,NULL,13,0,0,'','0','0',NULL,NULL,'','',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(15,2,1,0,0,3,'plugin','\\Centauri\\Extension\\News\\Plugin\\NewsPlugin',0,'2020-05-30 15:29:02','2020-06-02 15:00:42',NULL,NULL,16,0,0,'News','0','0',NULL,NULL,'','',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(16,2,1,0,0,3,'grids',NULL,0,'2020-05-31 08:15:30','2020-06-03 08:31:06',NULL,'onecol',NULL,NULL,NULL,'','0','0',NULL,NULL,'','',NULL,NULL,'mt-5','','mb-4','',NULL),(17,12,1,0,0,2,'plugin','\\Centauri\\Extension\\Jobs\\Plugin\\JobsPlugin',0,'2020-06-01 10:36:31','2020-06-02 15:00:42',NULL,NULL,18,0,0,'Jobs','0','0',NULL,NULL,'','',NULL,NULL,NULL,NULL,NULL,NULL,NULL),(18,12,1,0,0,3,'grids',NULL,0,'2020-06-01 10:40:56','2020-06-02 15:00:42',NULL,'onecol',NULL,NULL,NULL,'','0','0',NULL,NULL,'','',NULL,NULL,'mt-5','','mb-5','',NULL),(19,13,1,0,0,1,'headerdescription',NULL,0,'2020-06-02 15:00:19','2020-06-02 15:14:46',NULL,NULL,20,0,0,'History','0','0',NULL,NULL,'h2','','<p>CentauriCMS was initially kickstarted back in summer \'18 with a name which stopped existing after some time at its development time.<br>At this time it had a completely different backend aspect aswell its dependencies which were for the moment quite good but not \"future-secured\".</p><p>Born as \"VecthorCMS\" which went through multiple new re-builds (deleted everything and started it over again new from scratch) at some point Vecthor just died and the work on a CMS was over - \'till past summer \'19 - at this time I got bored and wanted to get better in php and general educate more programming languages - especially into web (e.g. PageSpeed, SEO, php/js frameworks etc.) - at this point I\'ve heard from Laravel.</p><p><a href=\"https://laravel.com/\"><strong>Laravel</strong></a> is the main-dependency in CentauriCMS - thanks to its great MVC (Model-View-Controller) concept, built-in Routing, ultra fast Blades and much more features its the main reason why it has been used as core.</p><p>The first version of CentauriCMS has been built using Laravel 5.4 - it was the only version until I noticed that I didn\'t liked the Backend style at all, the way Centauri\'s core was working and much more - it was the last time I\'ve rebuild everything from scratch using Laravel 5.6.</p><p>At the 5.6 version Centauri updated successfully 2 major versions - up to the 6.x serie aswell to Laravel 7.<br>Centauri is planned to be updated always Laravel releases an update - which means in a 1.5 years update circle.</p>',NULL,NULL,NULL,NULL,NULL,NULL),(20,13,1,0,0,2,'grids',NULL,0,'2020-06-02 15:00:42','2020-06-02 15:01:26',NULL,'onecol',NULL,NULL,NULL,'','0','0',NULL,NULL,'','',NULL,NULL,'mt-5','','mb-5','',NULL),(21,14,1,0,0,0,'headerdescription',NULL,0,'2020-06-02 19:28:59','2020-06-02 19:34:13',NULL,NULL,NULL,NULL,NULL,'aaaaaa','0','0',NULL,NULL,'h1','bbbbbb','<p>ccccccccc 55dsfsdf</p>',NULL,NULL,NULL,NULL,NULL,NULL),(22,15,1,0,0,0,'grids',NULL,0,'2020-06-03 06:52:34','2020-06-03 06:54:19',NULL,'onecol',NULL,NULL,NULL,'','0','0',NULL,NULL,'','',NULL,NULL,'mt-5','','mb-5','',NULL),(23,15,1,0,0,1,'headerdescription',NULL,0,'2020-06-03 06:53:53','2020-06-03 06:54:29',NULL,NULL,22,0,0,'Page not found','0','0',NULL,NULL,'h2','','<p>Sorry but the page you were looking for seems to be not existing - try using our search.</p><p><a class=\"ck-link_selected\" href=\"/\">Back to home</a></p>',NULL,NULL,NULL,NULL,NULL,NULL),(24,17,1,0,0,0,'grids',NULL,0,'2020-06-03 06:52:34','2020-06-05 16:59:04',NULL,'onecol',NULL,NULL,NULL,'','0','0',NULL,NULL,'','',NULL,NULL,'','','','',NULL),(25,17,1,0,0,1,'headerdescription',NULL,0,'2020-06-03 06:53:53','2020-06-05 16:59:04',NULL,NULL,24,0,0,'Page not foundddd (CE)','0','0',NULL,NULL,'h1','','<p>Sorry but the page you were looking for seems to be not existing - try using our search.</p><p><a href=\"/\">Back to home</a></p>',NULL,NULL,NULL,NULL,NULL,NULL);
/*!40000 ALTER TABLE `elements` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `files`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `files` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `path` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `cropable` int(11) NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `link` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=27 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `files` WRITE;
/*!40000 ALTER TABLE `files` DISABLE KEYS */;
INSERT INTO `files` VALUES (1,'1.png','image/png','\\storage\\Centauri\\Filelist\\1.png',1,'','','','2020-06-04 07:35:55','2020-06-04 07:35:55',NULL),(2,'2.png','image/png','\\storage\\Centauri\\Filelist\\2.png',1,'','','','2020-06-04 07:35:55','2020-06-04 07:35:55',NULL),(3,'__flat-rocket.jpeg','image/jpeg','\\storage\\Centauri\\Filelist\\__flat-rocket.jpeg',1,'','','','2020-06-04 07:35:55','2020-06-04 07:35:55',NULL),(4,'_flat-rocket.jpeg','image/jpeg','\\storage\\Centauri\\Filelist\\_flat-rocket.jpeg',1,'','','','2020-06-04 07:35:55','2020-06-04 07:35:55',NULL),(5,'a.png','image/png','\\storage\\Centauri\\Filelist\\a.png',1,'','','','2020-06-04 07:35:56','2020-06-04 07:35:56',NULL),(6,'a_croppedRTop.png','image/jpeg','\\storage\\Centauri\\Filelist\\a_croppedRTop.png',1,'','','','2020-06-04 07:35:56','2020-06-04 07:35:56',NULL),(7,'aaaaa.png','image/png','\\storage\\Centauri\\Filelist\\aaaaa.png',1,'','','','2020-06-04 07:35:56','2020-06-04 07:35:56',NULL),(8,'ayy.jpg','image/jpeg','\\storage\\Centauri\\Filelist\\ayy.jpg',1,'','','','2020-06-04 07:35:56','2020-06-04 07:35:56',NULL),(9,'ayy.png','image/png','\\storage\\Centauri\\Filelist\\ayy.png',1,'','','','2020-06-04 07:35:56','2020-06-04 07:35:56',NULL),(10,'b.png','image/png','\\storage\\Centauri\\Filelist\\b.png',1,'','','','2020-06-04 07:35:56','2020-06-04 07:35:56',NULL),(11,'Bg1.jpeg','image/jpeg','\\storage\\Centauri\\Filelist\\Bg1.jpeg',1,'','','','2020-06-04 07:35:56','2020-06-04 07:35:56',NULL),(12,'centauri-signature.png','image/png','\\storage\\Centauri\\Filelist\\centauri-signature.png',1,'','','','2020-06-04 07:35:56','2020-06-04 07:35:56',NULL),(13,'CMS Bild.png','image/png','\\storage\\Centauri\\Filelist\\CMS Bild.png',1,'','','','2020-06-04 07:35:56','2020-06-04 07:35:56',NULL),(14,'cropped_test.png','image/jpeg','\\storage\\Centauri\\Filelist\\cropped_test.png',1,'','','','2020-06-04 07:35:56','2020-06-04 07:35:56',NULL),(15,'Download.png','image/png','\\storage\\Centauri\\Filelist\\Download.png',1,'','','','2020-06-04 07:35:56','2020-06-04 07:35:56',NULL),(16,'dsf.png','image/png','\\storage\\Centauri\\Filelist\\dsf.png',1,'','','','2020-06-04 07:35:56','2020-06-04 07:35:56',NULL),(17,'dummy.pdf','application/pdf','\\storage\\Centauri\\Filelist\\dummy.pdf',0,'','','','2020-06-04 07:35:56','2020-06-04 07:35:56',NULL),(18,'flat-rocket.jpeg','image/jpeg','\\storage\\Centauri\\Filelist\\flat-rocket.jpeg',1,'','','','2020-06-04 07:35:56','2020-06-04 07:35:56',NULL),(19,'Konditionen-MBG.pdf','application/pdf','\\storage\\Centauri\\Filelist\\Konditionen-MBG.pdf',0,'','','','2020-06-04 07:35:56','2020-06-04 07:35:56',NULL),(20,'message.txt','text/plain','\\storage\\Centauri\\Filelist\\message.txt',0,'','','','2020-06-04 07:35:56','2020-06-04 07:35:56',NULL),(21,'mountains.jpg','image/jpeg','\\storage\\Centauri\\Filelist\\mountains.jpg',1,'','','','2020-06-04 07:35:56','2020-06-04 07:35:56',NULL),(22,'mvske.png','image/png','\\storage\\Centauri\\Filelist\\mvske.png',1,'','','','2020-06-04 07:35:56','2020-06-04 07:35:56',NULL),(23,'Senior-Front-End-Developer-1080x675.jpg','image/jpeg','\\storage\\Centauri\\Filelist\\Senior-Front-End-Developer-1080x675.jpg',1,'','','','2020-06-04 07:35:56','2020-06-04 07:35:56',NULL),(24,'t.png','image/png','\\storage\\Centauri\\Filelist\\t.png',1,'','','','2020-06-04 07:35:56','2020-06-04 07:35:56',NULL),(25,'test.png','image/png','\\storage\\Centauri\\Filelist\\test.png',1,'','','','2020-06-04 07:35:56','2020-06-04 07:35:56',NULL),(26,'uff.jpg.jpeg','image/jpeg','\\storage\\Centauri\\Filelist\\uff.jpg.jpeg',1,'','','','2020-06-04 07:35:56','2020-06-04 07:35:56',NULL);
/*!40000 ALTER TABLE `files` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `languages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `languages` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `lang_code` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slug` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `flagsrc` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `languages` WRITE;
/*!40000 ALTER TABLE `languages` DISABLE KEYS */;
INSERT INTO `languages` VALUES (1,'English','en-EN','/','/CentauriCMS/public/images/flags/UK.jpg',NULL,NULL,NULL);
/*!40000 ALTER TABLE `languages` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `migrations`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `migrations` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `migrations` WRITE;
/*!40000 ALTER TABLE `migrations` DISABLE KEYS */;
INSERT INTO `migrations` VALUES (1,'2019_11_24_141222_pages',1),(2,'2019_11_24_180321_elements',1),(3,'2019_11_24_183953_be_users',1),(4,'2019_12_07_100736_languages',1),(5,'2019_12_17_202307_notifications',1),(6,'2019_12_26_182608_files',1),(7,'2020_01_03_015450_ir_files',1);
/*!40000 ALTER TABLE `migrations` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `notifications`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `notifications` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `severity` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `text` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `notifications` WRITE;
/*!40000 ALTER TABLE `notifications` DISABLE KEYS */;
/*!40000 ALTER TABLE `notifications` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `pages`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `pages` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `pid` int(11) NOT NULL,
  `lid` int(11) NOT NULL,
  `backend_layout` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `slugs` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `hidden` int(11) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `seo_keywords` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `seo_description` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
  `seo_robots_indexpage` tinyint(1) NOT NULL DEFAULT 1,
  `seo_robots_followpage` tinyint(1) NOT NULL DEFAULT 1,
  `hidden_inpagetree` tinyint(1) NOT NULL DEFAULT 0,
  `page_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `storage_id` int(11) DEFAULT NULL,
  `domain_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=18 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `pages` WRITE;
/*!40000 ALTER TABLE `pages` DISABLE KEYS */;
INSERT INTO `pages` VALUES (1,0,1,'default','Home','/',0,'2020-05-08 08:39:40','2020-05-23 22:26:51',NULL,'Centauri, CMS, Laravel, Content, Management, System, Agentur, Agenture','',1,1,0,'rootpage',NULL,0),(2,1,1,'default','News','/news',0,'2020-05-08 15:23:30','2020-05-09 20:53:17',NULL,'','',1,1,0,'page',NULL,1),(3,1,1,'default','Footer','/footer',0,'2020-05-10 07:10:56','2020-05-31 11:22:34',NULL,'','',1,1,0,'storage',NULL,1),(4,3,1,'default','Legal notice','/legal-notice',0,'2020-05-10 07:17:11','2020-05-10 07:17:11',NULL,'','',1,1,0,'page',3,1),(5,0,1,'docs','Docs','docs.centauri.msediqi.lan',0,'2020-05-10 07:40:22','2020-05-10 07:40:22',NULL,'','',1,1,0,'rootpage',NULL,0),(6,3,1,'default','Policy','/policy',0,'2020-05-10 08:44:41','2020-05-10 08:44:41',NULL,'','',1,1,0,'page',3,1),(8,2,1,'default','Subtest','/content-test/test2',0,'2020-05-08 15:23:30','2020-06-04 11:45:55',NULL,'','',1,1,1,'page',NULL,1),(9,8,1,'default','NewsTest2','/news/newstest/newstest2',0,'2020-05-08 15:23:30','2020-05-30 15:18:25','2020-05-30 15:18:25','','',1,1,0,'page',NULL,1),(12,1,1,'default','Jobs','/jobs',0,'2020-06-01 08:22:21','2020-06-01 08:22:21',NULL,'','',1,1,0,'page',NULL,1),(13,1,1,'default','About us','/about-us',0,'2020-06-02 14:57:11','2020-06-02 15:19:10',NULL,'','',1,1,0,'page',NULL,1),(14,1,1,'default','Content-Test','/content-test',0,'2020-06-02 19:28:39','2020-06-03 06:37:24',NULL,'','',1,1,0,'page',NULL,1),(15,1,1,'default','404','/404',0,'2020-06-03 06:50:29','2020-06-05 12:51:58',NULL,'','',1,1,1,'page',NULL,1),(16,5,1,'docs','Start','/start',0,'2020-06-04 09:50:14','2020-06-04 09:50:14',NULL,'','',1,1,0,'page',NULL,5),(17,5,1,'docs','404','/404',0,'2020-06-05 12:40:55','2020-06-05 16:48:28',NULL,'','',1,1,1,'page',NULL,5);
/*!40000 ALTER TABLE `pages` ENABLE KEYS */;
UNLOCK TABLES;
DROP TABLE IF EXISTS `schedulers`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `schedulers` (
  `uid` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  `deleted_at` timestamp NULL DEFAULT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `namespace` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `state` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT '-',
  `last_runned` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `time` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`uid`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

LOCK TABLES `schedulers` WRITE;
/*!40000 ALTER TABLE `schedulers` DISABLE KEYS */;
INSERT INTO `schedulers` VALUES (1,'2020-06-06 21:30:27','2020-06-11 16:00:01',NULL,'DB-Backup','\\Centauri\\CMS\\Scheduler\\BackupScheduler','Running...','11.06.2020 - 16:00:01','hourly');
/*!40000 ALTER TABLE `schedulers` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

