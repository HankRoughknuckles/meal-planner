-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Aug 29, 2013 at 11:53 PM
-- Server version: 5.5.24-log
-- PHP Version: 5.4.3

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `meal_planner`
--

-- --------------------------------------------------------

--
-- Table structure for table `t_foods`
--

CREATE TABLE IF NOT EXISTS `t_foods` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `user_def_food_name` varchar(255) NOT NULL,
  `serving_size` decimal(10,5) DEFAULT NULL,
  `serving_units_esha` varchar(255) NOT NULL,
  `cost` decimal(10,3) NOT NULL,
  `json_esha` blob NOT NULL,
  `esha_food_id` varchar(255) NOT NULL,
  `calories` decimal(10,2) NOT NULL COMMENT 'Calories per serving (the serving specified in the serving_size column)',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=54 ;

--
-- Dumping data for table `t_foods`
--

INSERT INTO `t_foods` (`id`, `user_id`, `user_def_food_name`, `serving_size`, `serving_units_esha`, `cost`, `json_esha`, `esha_food_id`, `calories`) VALUES
(31, -1, 'Milk, 2%, w/add vit A & D', '1.00000', 'urn:uuid:dfad1d25-17ff-4201-bba0-0711e8b88c65', '2.000', 0x7b5c2269645c223a5c2275726e3a757569643a37636331336433392d656236332d346561612d623130372d6562313834306663363962615c222c5c226465736372697074696f6e5c223a5c224d696c6b2c2032252c20775c5c2f616464207669742041202620445c222c5c2267726f75705c223a5c224d696c6b732026204e6f6e2d4461697279204d696c6b2053756273746974757465735c222c5c227175616e746974795c223a312c5c22737570706c6965725c223a5c22555344412053522d32345c222c5c22756e69745c223a5c2275726e3a757569643a64666164316432352d313766662d343230312d626261302d3037313165386238386336355c222c5c22756e6974735c223a5b5c2275726e3a757569643a64666164316432352d313766662d343230312d626261302d3037313165386238386336355c222c5c2275726e3a757569643a63326131386333352d663465372d343239372d623864652d3165306631626431366366625c222c5c2275726e3a757569643a31633864343362332d366231392d343361622d393566302d3830336133376664663466315c222c5c2275726e3a757569643a65306164313930612d643438622d343433652d623633372d6531636630356462326364625c222c5c2275726e3a757569643a33653833383466302d656134372d346664652d623765312d6131323734376232386133305c222c5c2275726e3a757569643a64336265363834632d656266612d343836312d393234662d3838343036303064316538345c222c5c2275726e3a757569643a30653566346464322d333335332d343737662d393737332d3065643131366339336532655c222c5c2275726e3a757569643a32303334363337382d316531662d346436352d383833332d3631313932323865383633395c222c5c2275726e3a757569643a61356239663863302d373766622d343063302d393031382d3433363738373130663865375c222c5c2275726e3a757569643a39366238373434622d366462372d343434382d623166622d3633613263383639356130655c222c5c2275726e3a757569643a34353739323333632d346463642d343666362d613065632d6532666632383930363865345c222c5c2275726e3a757569643a33663266306262342d643562322d346564642d626530342d3533373163363636633363325c222c5c2275726e3a757569643a37633433383631612d326466362d343662632d616234392d6538333166373637643639655c222c5c2275726e3a757569643a65316437393337352d313564622d346564372d386561642d6636346463323331393039315c222c5c2275726e3a757569643a39656461366434312d346662622d346139372d623034362d3436616565386130383664655c225d2c5c226d6f6469666965645c223a5c22323031312d31302d30345c227d, 'urn:uuid:7cc13d39-eb63-4eaa-b107-eb1840fc69ba', '122.00'),
(32, -1, 'Egg', '12.00000', 'urn:uuid:85562e85-ba37-4e4a-8400-da43170204a7', '3.000', 0x7b5c2269645c223a5c2275726e3a757569643a66666637323137352d313138662d346237612d613165652d3962613135646561393031395c222c5c226465736372697074696f6e5c223a5c224567672c2077686f6c652c207261772c206c72675c222c5c2267726f75705c223a5c22456767732026204567672053756273746974757465735c222c5c227175616e746974795c223a312c5c22737570706c6965725c223a5c22555344412053522d32345c222c5c22756e69745c223a5c2275726e3a757569643a38353536326538352d626133372d346534612d383430302d6461343331373032303461375c222c5c22756e6974735c223a5b5c2275726e3a757569643a38353536326538352d626133372d346534612d383430302d6461343331373032303461375c222c5c2275726e3a757569643a65316437393337352d313564622d346564372d386561642d6636346463323331393039315c222c5c2275726e3a757569643a39656461366434312d346662622d346139372d623034362d3436616565386130383664655c222c5c2275726e3a757569643a65306164313930612d643438622d343433652d623633372d6531636630356462326364625c222c5c2275726e3a757569643a33653833383466302d656134372d346664652d623765312d6131323734376232386133305c222c5c2275726e3a757569643a64336265363834632d656266612d343836312d393234662d3838343036303064316538345c222c5c2275726e3a757569643a30653566346464322d333335332d343737662d393737332d3065643131366339336532655c225d2c5c226d6f6469666965645c223a5c22323031312d31302d30345c227d, 'urn:uuid:fff72175-118f-4b7a-a1ee-9ba15dea9019', '858.00'),
(33, -1, 'Celery Stalks, 4', '2.00000', 'urn:uuid:33379b7d-cf8d-4fda-b99d-40372492aafd', '2.000', 0x7b5c2269645c223a5c2275726e3a757569643a62383366306139612d643730302d346466662d623962392d3361626661663530396335345c222c5c226465736372697074696f6e5c223a5c2243656c6572792c207374726970732c20345c5c5c22206c6f6e672c2066726573685c222c5c2267726f75705c223a5c22467265736820566567657461626c65732026204c6567756d65735c222c5c227175616e746974795c223a312c5c22737570706c6965725c223a5c22555344412053522d32345c222c5c22756e69745c223a5c2275726e3a757569643a33333337396237642d636638642d346664612d623939642d3430333732343932616166645c222c5c22756e6974735c223a5b5c2275726e3a757569643a33333337396237642d636638642d346664612d623939642d3430333732343932616166645c222c5c2275726e3a757569643a65316437393337352d313564622d346564372d386561642d6636346463323331393039315c222c5c2275726e3a757569643a39656461366434312d346662622d346139372d623034362d3436616565386130383664655c222c5c2275726e3a757569643a65306164313930612d643438622d343433652d623633372d6531636630356462326364625c222c5c2275726e3a757569643a33653833383466302d656134372d346664652d623765312d6131323734376232386133305c222c5c2275726e3a757569643a64336265363834632d656266612d343836312d393234662d3838343036303064316538345c222c5c2275726e3a757569643a30653566346464322d333335332d343737662d393737332d3065643131366339336532655c225d2c5c226d6f6469666965645c223a5c22323031312d31302d30345c227d, 'urn:uuid:b83f0a9a-d700-4dff-b9b9-3abfaf509c54', '1.28'),
(34, -1, 'Cheddar Cheese', '0.50000', 'urn:uuid:3e8384f0-ea47-4fde-b7e1-a12747b28a30', '3.000', 0x7b5c2269645c223a5c2275726e3a757569643a63376330333636312d306166342d346634332d393432352d3837373266376361316161355c222c5c226465736372697074696f6e5c223a5c224368656573652c20636865646461722c2073687265646465645c222c5c2267726f75705c223a5c22436865657365202d204e61747572616c5c222c5c227175616e746974795c223a302e32352c5c22737570706c6965725c223a5c22555344412053522d32345c222c5c22756e69745c223a5c2275726e3a757569643a64666164316432352d313766662d343230312d626261302d3037313165386238386336355c222c5c22756e6974735c223a5b5c2275726e3a757569643a64666164316432352d313766662d343230312d626261302d3037313165386238386336355c222c5c2275726e3a757569643a63326131386333352d663465372d343239372d623864652d3165306631626431366366625c222c5c2275726e3a757569643a31633864343362332d366231392d343361622d393566302d3830336133376664663466315c222c5c2275726e3a757569643a65306164313930612d643438622d343433652d623633372d6531636630356462326364625c222c5c2275726e3a757569643a33653833383466302d656134372d346664652d623765312d6131323734376232386133305c222c5c2275726e3a757569643a64336265363834632d656266612d343836312d393234662d3838343036303064316538345c222c5c2275726e3a757569643a30653566346464322d333335332d343737662d393737332d3065643131366339336532655c222c5c2275726e3a757569643a32303334363337382d316531662d346436352d383833332d3631313932323865383633395c222c5c2275726e3a757569643a61356239663863302d373766622d343063302d393031382d3433363738373130663865375c222c5c2275726e3a757569643a39366238373434622d366462372d343434382d623166622d3633613263383639356130655c222c5c2275726e3a757569643a34353739323333632d346463642d343666362d613065632d6532666632383930363865345c222c5c2275726e3a757569643a33663266306262342d643562322d346564642d626530342d3533373163363636633363325c222c5c2275726e3a757569643a37633433383631612d326466362d343662632d616234392d6538333166373637643639655c222c5c2275726e3a757569643a65316437393337352d313564622d346564372d386561642d6636346463323331393039315c222c5c2275726e3a757569643a39656461366434312d346662622d346139372d623034362d3436616565386130383664655c225d2c5c226d6f6469666965645c223a5c22323031312d31302d30345c227d, 'urn:uuid:c7c03661-0af4-4f43-9425-8772f7ca1aa5', '913.93'),
(35, -1, 'Multigrain Bread', '30.00000', 'urn:uuid:3340624b-f24d-4997-9ca6-11221b22008e', '1.000', 0x7b5c2269645c223a5c2275726e3a757569643a62326162393031312d333434382d343931352d623435312d6239396232633438383936375c222c5c226465736372697074696f6e5c223a5c2242726561642c206d756c7469677261696e5c222c5c2267726f75705c223a5c22427265616473202620526f6c6c735c222c5c227175616e746974795c223a312c5c2270726f647563745c223a5c2250657070657269646765204661726d5c222c5c22737570706c6965725c223a5c2243616d7062656c6c5c277320536f757020436f6d70616e795c222c5c22756e69745c223a5c2275726e3a757569643a33333430363234622d663234642d343939372d396361362d3131323231623232303038655c222c5c22756e6974735c223a5b5c2275726e3a757569643a33333430363234622d663234642d343939372d396361362d3131323231623232303038655c222c5c2275726e3a757569643a65316437393337352d313564622d346564372d386561642d6636346463323331393039315c222c5c2275726e3a757569643a39656461366434312d346662622d346139372d623034362d3436616565386130383664655c222c5c2275726e3a757569643a65306164313930612d643438622d343433652d623633372d6531636630356462326364625c222c5c2275726e3a757569643a33653833383466302d656134372d346664652d623765312d6131323734376232386133305c222c5c2275726e3a757569643a64336265363834632d656266612d343836312d393234662d3838343036303064316538345c222c5c2275726e3a757569643a30653566346464322d333335332d343737662d393737332d3065643131366339336532655c225d2c5c226d6f6469666965645c223a5c22323031312d30382d33305c227d, 'urn:uuid:b2ab9011-3448-4915-b451-b99b2c488967', '2700.00'),
(37, -1, 'Chocolate Bar', '1.00000', 'urn:uuid:85562e85-ba37-4e4a-8400-da43170204a7', '1.000', 0x7b5c2269645c223a5c2275726e3a757569643a30616339303430342d356637352d343332642d613531662d6432646339616664326363315c222c5c226465736372697074696f6e5c223a5c2243686f636f6c617465204261722c206d696c6b5c222c5c2267726f75705c223a5c2243616e646965732c20436f6e66656374696f6e732c20262047756d735c222c5c227175616e746974795c223a312c5c2270726f647563745c223a5c22486572736865795c27735c222c5c22737570706c6965725c223a5c224865727368657920436f6d70616e795c222c5c22756e69745c223a5c2275726e3a757569643a38353536326538352d626133372d346534612d383430302d6461343331373032303461375c222c5c22756e6974735c223a5b5c2275726e3a757569643a38353536326538352d626133372d346534612d383430302d6461343331373032303461375c222c5c2275726e3a757569643a65316437393337352d313564622d346564372d386561642d6636346463323331393039315c222c5c2275726e3a757569643a39656461366434312d346662622d346139372d623034362d3436616565386130383664655c222c5c2275726e3a757569643a65306164313930612d643438622d343433652d623633372d6531636630356462326364625c222c5c2275726e3a757569643a33653833383466302d656134372d346664652d623765312d6131323734376232386133305c222c5c2275726e3a757569643a64336265363834632d656266612d343836312d393234662d3838343036303064316538345c222c5c2275726e3a757569643a30653566346464322d333335332d343737662d393737332d3065643131366339336532655c225d2c5c226d6f6469666965645c223a5c22323031322d30322d31345c227d, 'urn:uuid:0ac90404-5f75-432d-a51f-d2dc9afd2cc1', '210.00'),
(38, -1, 'Romaine Lettuce', '1.00000', 'urn:uuid:3e8384f0-ea47-4fde-b7e1-a12747b28a30', '2.000', 0x7b5c2269645c223a5c2275726e3a757569643a34653033663331362d356238612d343030612d393261352d3163316665626461316237315c222c5c226465736372697074696f6e5c223a5c224c6574747563652c20726f6d61696e652c2066726573682c2073687265645c222c5c2267726f75705c223a5c22467265736820566567657461626c65732026204c6567756d65735c222c5c227175616e746974795c223a312c5c22737570706c6965725c223a5c22555344412053522d32345c222c5c22756e69745c223a5c2275726e3a757569643a64666164316432352d313766662d343230312d626261302d3037313165386238386336355c222c5c22756e6974735c223a5b5c2275726e3a757569643a64666164316432352d313766662d343230312d626261302d3037313165386238386336355c222c5c2275726e3a757569643a63326131386333352d663465372d343239372d623864652d3165306631626431366366625c222c5c2275726e3a757569643a31633864343362332d366231392d343361622d393566302d3830336133376664663466315c222c5c2275726e3a757569643a65306164313930612d643438622d343433652d623633372d6531636630356462326364625c222c5c2275726e3a757569643a33653833383466302d656134372d346664652d623765312d6131323734376232386133305c222c5c2275726e3a757569643a64336265363834632d656266612d343836312d393234662d3838343036303064316538345c222c5c2275726e3a757569643a30653566346464322d333335332d343737662d393737332d3065643131366339336532655c222c5c2275726e3a757569643a32303334363337382d316531662d346436352d383833332d3631313932323865383633395c222c5c2275726e3a757569643a61356239663863302d373766622d343063302d393031382d3433363738373130663865375c222c5c2275726e3a757569643a39366238373434622d366462372d343434382d623166622d3633613263383639356130655c222c5c2275726e3a757569643a34353739323333632d346463642d343666362d613065632d6532666632383930363865345c222c5c2275726e3a757569643a33663266306262342d643562322d346564642d626530342d3533373163363636633363325c222c5c2275726e3a757569643a37633433383631612d326466362d343662632d616234392d6538333166373637643639655c222c5c2275726e3a757569643a65316437393337352d313564622d346564372d386561642d6636346463323331393039315c222c5c2275726e3a757569643a39656461366434312d346662622d346139372d623034362d3436616565386130383664655c222c5c2275726e3a757569643a63376232373765642d323035392d346333332d393430622d3865356337616135633932325c225d2c5c226d6f6469666965645c223a5c22323031312d31302d30345c227d, 'urn:uuid:4e03f316-5b8a-400a-92a5-1c1febda1b71', '77.11'),
(42, -1, 'Bud Light Beer', '12.00000', 'urn:uuid:20346378-1e1f-4d65-8833-6119228e8639', '1.000', 0x7b5c2269645c223a5c2275726e3a757569643a61383139393363352d376466612d343536652d383234382d3736613532303633353264665c222c5c226465736372697074696f6e5c223a5c22426565722c20427564204c696768745c222c5c2267726f75705c223a5c22416c636f686f6c6963204265766572616765732026204d697865735c222c5c227175616e746974795c223a31322c5c2270726f647563745c223a5c22416e6865757365722d42757363685c222c5c22737570706c6965725c223a5c22555344412053522d32345c222c5c22756e69745c223a5c2275726e3a757569643a32303334363337382d316531662d346436352d383833332d3631313932323865383633395c222c5c22756e6974735c223a5b5c2275726e3a757569643a32303334363337382d316531662d346436352d383833332d3631313932323865383633395c222c5c2275726e3a757569643a63326131386333352d663465372d343239372d623864652d3165306631626431366366625c222c5c2275726e3a757569643a31633864343362332d366231392d343361622d393566302d3830336133376664663466315c222c5c2275726e3a757569643a64666164316432352d313766662d343230312d626261302d3037313165386238386336355c222c5c2275726e3a757569643a38353536326538352d626133372d346534612d383430302d6461343331373032303461375c222c5c2275726e3a757569643a65306164313930612d643438622d343433652d623633372d6531636630356462326364625c222c5c2275726e3a757569643a33653833383466302d656134372d346664652d623765312d6131323734376232386133305c222c5c2275726e3a757569643a64336265363834632d656266612d343836312d393234662d3838343036303064316538345c222c5c2275726e3a757569643a30653566346464322d333335332d343737662d393737332d3065643131366339336532655c222c5c2275726e3a757569643a61356239663863302d373766622d343063302d393031382d3433363738373130663865375c222c5c2275726e3a757569643a39366238373434622d366462372d343434382d623166622d3633613263383639356130655c222c5c2275726e3a757569643a34353739323333632d346463642d343666362d613065632d6532666632383930363865345c222c5c2275726e3a757569643a33663266306262342d643562322d346564642d626530342d3533373163363636633363325c222c5c2275726e3a757569643a37633433383631612d326466362d343662632d616234392d6538333166373637643639655c222c5c2275726e3a757569643a65316437393337352d313564622d346564372d386561642d6636346463323331393039315c222c5c2275726e3a757569643a39656461366434312d346662622d346139372d623034362d3436616565386130383664655c222c5c2275726e3a757569643a63376232373765642d323035392d346333332d393430622d3865356337616135633932325c225d2c5c226d6f6469666965645c223a5c22323031322d30322d32315c227d, 'urn:uuid:a81993c5-7dfa-456e-8248-76a5206352df', '109.74'),
(43, -1, 'Veal', '1.00000', 'urn:uuid:3e8384f0-ea47-4fde-b7e1-a12747b28a30', '5.000', 0x7b5c2269645c223a5c2275726e3a757569643a62303034656634362d653333312d343465652d393036302d3962313036363632363363635c222c5c226465736372697074696f6e5c223a5c225665616c2c207369726c6f696e20726f6173742c20627273645c222c5c2267726f75705c223a5c225665616c5c222c5c227175616e746974795c223a332c5c22737570706c6965725c223a5c22555344412053522d32345c222c5c22756e69745c223a5c2275726e3a757569643a65306164313930612d643438622d343433652d623633372d6531636630356462326364625c222c5c22756e6974735c223a5b5c2275726e3a757569643a65306164313930612d643438622d343433652d623633372d6531636630356462326364625c222c5c2275726e3a757569643a65316437393337352d313564622d346564372d386561642d6636346463323331393039315c222c5c2275726e3a757569643a39656461366434312d346662622d346139372d623034362d3436616565386130383664655c222c5c2275726e3a757569643a33653833383466302d656134372d346664652d623765312d6131323734376232386133305c222c5c2275726e3a757569643a64336265363834632d656266612d343836312d393234662d3838343036303064316538345c222c5c2275726e3a757569643a30653566346464322d333335332d343737662d393737332d3065643131366339336532655c222c5c2275726e3a757569643a63376232373765642d323035392d346333332d393430622d3865356337616135633932325c225d2c5c226d6f6469666965645c223a5c22323031322d30382d30345c227d, 'urn:uuid:b004ef46-e331-44ee-9060-9b10666263cc', '1143.04'),
(44, -1, 'Milk Chocolate Bar', '1.00000', 'urn:uuid:85562e85-ba37-4e4a-8400-da43170204a7', '1.500', 0x7b5c2269645c223a5c2275726e3a757569643a30616339303430342d356637352d343332642d613531662d6432646339616664326363315c222c5c226465736372697074696f6e5c223a5c2243686f636f6c617465204261722c206d696c6b5c222c5c2267726f75705c223a5c2243616e646965732c20436f6e66656374696f6e732c20262047756d735c222c5c227175616e746974795c223a312c5c2270726f647563745c223a5c22486572736865795c27735c222c5c22737570706c6965725c223a5c224865727368657920436f6d70616e795c222c5c22756e69745c223a5c2275726e3a757569643a38353536326538352d626133372d346534612d383430302d6461343331373032303461375c222c5c22756e6974735c223a5b5c2275726e3a757569643a38353536326538352d626133372d346534612d383430302d6461343331373032303461375c222c5c2275726e3a757569643a65316437393337352d313564622d346564372d386561642d6636346463323331393039315c222c5c2275726e3a757569643a39656461366434312d346662622d346139372d623034362d3436616565386130383664655c222c5c2275726e3a757569643a65306164313930612d643438622d343433652d623633372d6531636630356462326364625c222c5c2275726e3a757569643a33653833383466302d656134372d346664652d623765312d6131323734376232386133305c222c5c2275726e3a757569643a64336265363834632d656266612d343836312d393234662d3838343036303064316538345c222c5c2275726e3a757569643a30653566346464322d333335332d343737662d393737332d3065643131366339336532655c225d2c5c226d6f6469666965645c223a5c22323031322d30322d31345c227d, 'urn:uuid:0ac90404-5f75-432d-a51f-d2dc9afd2cc1', '210.00'),
(45, -1, 'Feta Cheese', '1.00000', 'urn:uuid:dfad1d25-17ff-4201-bba0-0711e8b88c65', '1.200', 0x7b5c2269645c223a5c2275726e3a757569643a39323564346332622d373738622d343537322d623835312d6162323162333433376439645c222c5c226465736372697074696f6e5c223a5c224368656573652c20666574612c206372756d626c65645c222c5c2267726f75705c223a5c22436865657365202d204e61747572616c5c222c5c227175616e746974795c223a302e32352c5c22737570706c6965725c223a5c22555344412053522d32345c222c5c22756e69745c223a5c2275726e3a757569643a64666164316432352d313766662d343230312d626261302d3037313165386238386336355c222c5c22756e6974735c223a5b5c2275726e3a757569643a64666164316432352d313766662d343230312d626261302d3037313165386238386336355c222c5c2275726e3a757569643a63326131386333352d663465372d343239372d623864652d3165306631626431366366625c222c5c2275726e3a757569643a31633864343362332d366231392d343361622d393566302d3830336133376664663466315c222c5c2275726e3a757569643a65306164313930612d643438622d343433652d623633372d6531636630356462326364625c222c5c2275726e3a757569643a33653833383466302d656134372d346664652d623765312d6131323734376232386133305c222c5c2275726e3a757569643a64336265363834632d656266612d343836312d393234662d3838343036303064316538345c222c5c2275726e3a757569643a30653566346464322d333335332d343737662d393737332d3065643131366339336532655c222c5c2275726e3a757569643a32303334363337382d316531662d346436352d383833332d3631313932323865383633395c222c5c2275726e3a757569643a61356239663863302d373766622d343063302d393031382d3433363738373130663865375c222c5c2275726e3a757569643a39366238373434622d366462372d343434382d623166622d3633613263383639356130655c222c5c2275726e3a757569643a34353739323333632d346463642d343666362d613065632d6532666632383930363865345c222c5c2275726e3a757569643a33663266306262342d643562322d346564642d626530342d3533373163363636633363325c222c5c2275726e3a757569643a37633433383631612d326466362d343662632d616234392d6538333166373637643639655c222c5c2275726e3a757569643a65316437393337352d313564622d346564372d386561642d6636346463323331393039315c222c5c2275726e3a757569643a39656461366434312d346662622d346139372d623034362d3436616565386130383664655c225d2c5c226d6f6469666965645c223a5c22323031312d31302d30345c227d, 'urn:uuid:925d4c2b-778b-4572-b851-ab21b3437d9d', '396.00'),
(46, -1, 'Beef Jerky', '1.00000', 'urn:uuid:3e8384f0-ea47-4fde-b7e1-a12747b28a30', '5.000', 0x7b5c2269645c223a5c2275726e3a757569643a64653762666635622d616132362d343132352d393136362d6534386330323633663534345c222c5c226465736372697074696f6e5c223a5c22426565662c206a65726b792c206c7267207063655c222c5c2267726f75705c223a5c22426565665c222c5c227175616e746974795c223a312c5c22737570706c6965725c223a5c22555344412053522d32345c222c5c22756e69745c223a5c2275726e3a757569643a33333337396237642d636638642d346664612d623939642d3430333732343932616166645c222c5c22756e6974735c223a5b5c2275726e3a757569643a33333337396237642d636638642d346664612d623939642d3430333732343932616166645c222c5c2275726e3a757569643a65316437393337352d313564622d346564372d386561642d6636346463323331393039315c222c5c2275726e3a757569643a39656461366434312d346662622d346139372d623034362d3436616565386130383664655c222c5c2275726e3a757569643a38353536326538352d626133372d346534612d383430302d6461343331373032303461375c222c5c2275726e3a757569643a65306164313930612d643438622d343433652d623633372d6531636630356462326364625c222c5c2275726e3a757569643a33653833383466302d656134372d346664652d623765312d6131323734376232386133305c222c5c2275726e3a757569643a64336265363834632d656266612d343836312d393234662d3838343036303064316538345c222c5c2275726e3a757569643a30653566346464322d333335332d343737662d393737332d3065643131366339336532655c225d2c5c226d6f6469666965645c223a5c22323031312d31302d30345c227d, 'urn:uuid:de7bff5b-aa26-4125-9166-e48c0263f544', '1859.73'),
(50, -1, 'Bud Light Beer', '12.00000', 'urn:uuid:20346378-1e1f-4d65-8833-6119228e8639', '1.000', 0x7b5c2269645c223a5c2275726e3a757569643a61383139393363352d376466612d343536652d383234382d3736613532303633353264665c222c5c226465736372697074696f6e5c223a5c22426565722c20427564204c696768745c222c5c2267726f75705c223a5c22416c636f686f6c6963204265766572616765732026204d697865735c222c5c227175616e746974795c223a31322c5c2270726f647563745c223a5c22416e6865757365722d42757363685c222c5c22737570706c6965725c223a5c22555344412053522d32345c222c5c22756e69745c223a5c2275726e3a757569643a32303334363337382d316531662d346436352d383833332d3631313932323865383633395c222c5c22756e6974735c223a5b5c2275726e3a757569643a32303334363337382d316531662d346436352d383833332d3631313932323865383633395c222c5c2275726e3a757569643a63326131386333352d663465372d343239372d623864652d3165306631626431366366625c222c5c2275726e3a757569643a31633864343362332d366231392d343361622d393566302d3830336133376664663466315c222c5c2275726e3a757569643a64666164316432352d313766662d343230312d626261302d3037313165386238386336355c222c5c2275726e3a757569643a38353536326538352d626133372d346534612d383430302d6461343331373032303461375c222c5c2275726e3a757569643a65306164313930612d643438622d343433652d623633372d6531636630356462326364625c222c5c2275726e3a757569643a33653833383466302d656134372d346664652d623765312d6131323734376232386133305c222c5c2275726e3a757569643a64336265363834632d656266612d343836312d393234662d3838343036303064316538345c222c5c2275726e3a757569643a30653566346464322d333335332d343737662d393737332d3065643131366339336532655c222c5c2275726e3a757569643a61356239663863302d373766622d343063302d393031382d3433363738373130663865375c222c5c2275726e3a757569643a39366238373434622d366462372d343434382d623166622d3633613263383639356130655c222c5c2275726e3a757569643a34353739323333632d346463642d343666362d613065632d6532666632383930363865345c222c5c2275726e3a757569643a33663266306262342d643562322d346564642d626530342d3533373163363636633363325c222c5c2275726e3a757569643a37633433383631612d326466362d343662632d616234392d6538333166373637643639655c222c5c2275726e3a757569643a65316437393337352d313564622d346564372d386561642d6636346463323331393039315c222c5c2275726e3a757569643a39656461366434312d346662622d346139372d623034362d3436616565386130383664655c222c5c2275726e3a757569643a63376232373765642d323035392d346333332d393430622d3865356337616135633932325c225d2c5c226d6f6469666965645c223a5c22323031322d30322d32315c227d, 'urn:uuid:a81993c5-7dfa-456e-8248-76a5206352df', '109.74'),
(51, -1, 'T-bone Steak', '1.00000', 'urn:uuid:85562e85-ba37-4e4a-8400-da43170204a7', '7.000', 0x7b5c2269645c223a5c2275726e3a757569643a66323264333831312d353830612d343537642d616535392d6534666638376439616562345c222c5c226465736372697074696f6e5c223a5c22426565662c20737465616b2c20742d626f6e655c222c5c2267726f75705c223a5c2252657374617572616e743a204d61696e204469736865735c5c2f4d65616c735c222c5c227175616e746974795c223a312c5c2270726f647563745c223a5c2244656e6e795c27735c222c5c22737570706c6965725c223a5c2244656e6e795c27735c222c5c22756e69745c223a5c2275726e3a757569643a38353536326538352d626133372d346534612d383430302d6461343331373032303461375c222c5c22756e6974735c223a5b5c2275726e3a757569643a38353536326538352d626133372d346534612d383430302d6461343331373032303461375c222c5c2275726e3a757569643a65316437393337352d313564622d346564372d386561642d6636346463323331393039315c222c5c2275726e3a757569643a39656461366434312d346662622d346139372d623034362d3436616565386130383664655c222c5c2275726e3a757569643a65306164313930612d643438622d343433652d623633372d6531636630356462326364625c222c5c2275726e3a757569643a33653833383466302d656134372d346664652d623765312d6131323734376232386133305c222c5c2275726e3a757569643a64336265363834632d656266612d343836312d393234662d3838343036303064316538345c222c5c2275726e3a757569643a30653566346464322d333335332d343737662d393737332d3065643131366339336532655c225d2c5c226d6f6469666965645c223a5c22323030372d30352d30375c227d, 'urn:uuid:f22d3811-580a-457d-ae59-e4ff87d9aeb4', '860.00'),
(52, -1, 'Foccacia Bread', '1.00000', 'urn:uuid:33379b7d-cf8d-4fda-b99d-40372492aafd', '1.500', 0x7b5c2269645c223a5c2275726e3a757569643a62663163363537312d646262652d343662302d616562342d3366306238666431313365385c222c5c226465736372697074696f6e5c223a5c2242726561642c20666f6363616369612c206761726c6963206f6c697665206f696c5c222c5c2267726f75705c223a5c224c6162656c20446174613a20457874726173202d2044697368204164642d4f6e735c5c2f4164646974696f6e7320284368656573652c204261636f6e2c20546f6d61746f65732c206574632e295c222c5c227175616e746974795c223a322c5c2270726f647563745c223a5c224a61736f6e5c27732044656c695c222c5c22737570706c6965725c223a5c224a61736f6e5c27732044656c695c222c5c22756e69745c223a5c2275726e3a757569643a33333337396237642d636638642d346664612d623939642d3430333732343932616166645c222c5c22756e6974735c223a5b5c2275726e3a757569643a33333337396237642d636638642d346664612d623939642d3430333732343932616166645c222c5c2275726e3a757569643a65316437393337352d313564622d346564372d386561642d6636346463323331393039315c222c5c2275726e3a757569643a39656461366434312d346662622d346139372d623034362d3436616565386130383664655c222c5c2275726e3a757569643a65306164313930612d643438622d343433652d623633372d6531636630356462326364625c222c5c2275726e3a757569643a33653833383466302d656134372d346664652d623765312d6131323734376232386133305c222c5c2275726e3a757569643a64336265363834632d656266612d343836312d393234662d3838343036303064316538345c222c5c2275726e3a757569643a30653566346464322d333335332d343737662d393737332d3065643131366339336532655c225d2c5c226d6f6469666965645c223a5c22323031312d30352d31385c227d, 'urn:uuid:bf1c6571-dbbe-46b0-aeb4-3f0b8fd113e8', '202.00'),
(53, -1, 'Babyback Ribs', '1.00000', 'urn:uuid:3e8384f0-ea47-4fde-b7e1-a12747b28a30', '13.000', 0x7b5c2269645c223a5c2275726e3a757569643a32663263356533632d643131302d343133622d393263342d6239376361316263313330305c222c5c226465736372697074696f6e5c223a5c22506f726b2c20726962732c206261636b726962732c20727374645c222c5c2267726f75705c223a5c22506f726b20262048616d5c222c5c227175616e746974795c223a332c5c22737570706c6965725c223a5c22555344412053522d32345c222c5c22756e69745c223a5c2275726e3a757569643a65306164313930612d643438622d343433652d623633372d6531636630356462326364625c222c5c22756e6974735c223a5b5c2275726e3a757569643a65306164313930612d643438622d343433652d623633372d6531636630356462326364625c222c5c2275726e3a757569643a65316437393337352d313564622d346564372d386561642d6636346463323331393039315c222c5c2275726e3a757569643a39656461366434312d346662622d346139372d623034362d3436616565386130383664655c222c5c2275726e3a757569643a33653833383466302d656134372d346664652d623765312d6131323734376232386133305c222c5c2275726e3a757569643a64336265363834632d656266612d343836312d393234662d3838343036303064316538345c222c5c2275726e3a757569643a30653566346464322d333335332d343737662d393737332d3065643131366339336532655c222c5c2275726e3a757569643a63376232373765642d323035392d346333332d393430622d3865356337616135633932325c225d2c5c226d6f6469666965645c223a5c22323031312d31302d30345c227d, 'urn:uuid:2f2c5e3c-d110-413b-92c4-b97ca1bc1300', '1297.28');

-- --------------------------------------------------------

--
-- Table structure for table `t_ingredients`
--

CREATE TABLE IF NOT EXISTS `t_ingredients` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'The unique identifier for the ingredient',
  `recipe_id` int(11) NOT NULL COMMENT 'Foreign key for the recipe this ingredient is in',
  `food_id` int(11) NOT NULL COMMENT 'Foreign key for the type of food this ingredient is',
  `name` varchar(255) NOT NULL COMMENT 'Name of the ingredient',
  `amount` decimal(10,0) NOT NULL COMMENT 'The amount of the ingredient',
  `unit` varchar(25) NOT NULL COMMENT 'The measurement units that ''amount'' is denominated in',
  `calories` decimal(10,0) NOT NULL COMMENT 'The number of calories in this ingredient amount',
  `cost` decimal(10,0) NOT NULL COMMENT 'The monetary cost of the ingredient',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=29 ;

--
-- Dumping data for table `t_ingredients`
--

INSERT INTO `t_ingredients` (`id`, `recipe_id`, `food_id`, `name`, `amount`, `unit`, `calories`, `cost`) VALUES
(10, 83, 51, 'T-bone Steak', '3', 'Each', '2580', '21'),
(11, 83, 32, 'Egg', '2', 'Each', '143', '1'),
(12, 84, 37, 'Chocolate Bar', '1', 'Pound', '2215', '11'),
(13, 84, 44, 'Milk Chocolate Bar', '2', 'Each', '420', '3'),
(14, 85, 33, 'Celery Stalks, 4', '1', 'Piece', '1', '1'),
(15, 85, 32, 'Egg', '1', 'Each', '72', '0'),
(16, 86, 33, 'Celery Stalks, 4', '1', 'Piece', '1', '1'),
(17, 86, 32, 'Egg', '3', 'Each', '215', '1'),
(18, 87, 50, 'Bud Light Beer', '2', 'Cup', '146', '1'),
(19, 87, 34, 'Cheddar Cheese', '50', 'Gram', '201', '1'),
(20, 88, 34, 'Cheddar Cheese', '1', 'Cup', '455', '1'),
(21, 88, 50, 'Bud Light Beer', '1', 'Each', '110', '1'),
(22, 88, 53, 'Babyback Ribs', '1', 'Pound', '1297', '13'),
(23, 89, 35, 'Multigrain Bread', '1', 'Slice', '90', '0'),
(24, 89, 34, 'Cheddar Cheese', '5', 'Tablespoon', '142', '0'),
(25, 89, 45, 'Feta Cheese', '2', 'Tablespoon', '49', '0'),
(26, 1, 33, 'Celery Stalks, 4', '2', 'Piece', '1', '2'),
(27, 1, 38, 'Romaine Lettuce', '3', 'Cup', '24', '1'),
(28, 1, 35, 'Multigrain Bread', '1', 'Slice', '90', '0');

-- --------------------------------------------------------

--
-- Table structure for table `t_recipes`
--

CREATE TABLE IF NOT EXISTS `t_recipes` (
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'The unique identifier for the recipe',
  `name` varchar(255) NOT NULL COMMENT 'The name of the recipe',
  `user_id` int(11) NOT NULL COMMENT 'foreign key to user',
  `recipe_object` blob NOT NULL COMMENT 'The PHP recipe object for the recipe.  Stored as JSON',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=97 ;

--
-- Dumping data for table `t_recipes`
--

INSERT INTO `t_recipes` (`id`, `name`, `user_id`, `recipe_object`) VALUES
(95, 'Bread sops', -1, 0x4f3a363a22526563697065223a393a7b733a373a22002a006e616d65223b733a31303a22427265616420736f7073223b733a383a22002a0064625f6964223b4e3b733a31343a22002a00696e6772656469656e7473223b613a333a7b693a303b4f3a31303a22496e6772656469656e74223a393a7b733a32333a2200496e6772656469656e74007265636970655f6e616d65223b733a31303a22427265616420736f7073223b733a32343a2200496e6772656469656e74007265636970655f64625f6964223b4e3b733a32333a2200496e6772656469656e74007072657061726174696f6e223b4e3b733a31363a2200496e6772656469656e74006e616d65223b733a31363a224d756c7469677261696e204272656164223b733a31393a2200496e6772656469656e7400666f6f645f6964223b733a323a223335223b733a32303a2200496e6772656469656e740063616c6f72696573223b693a3138303b733a31353a2200496e6772656469656e7400616d74223b733a313a2232223b733a31363a2200496e6772656469656e7400756e6974223b733a353a22536c696365223b733a31363a2200496e6772656469656e7400636f7374223b643a302e3037303030303030303030303030303030363636313333383134373735303933393234323534313739303030383534343932313837353b7d693a313b4f3a31303a22496e6772656469656e74223a393a7b733a32333a2200496e6772656469656e74007265636970655f6e616d65223b733a31303a22427265616420736f7073223b733a32343a2200496e6772656469656e74007265636970655f64625f6964223b4e3b733a32333a2200496e6772656469656e74007072657061726174696f6e223b4e3b733a31363a2200496e6772656469656e74006e616d65223b733a31343a22466f636361636961204272656164223b733a31393a2200496e6772656469656e7400666f6f645f6964223b733a323a223532223b733a32303a2200496e6772656469656e740063616c6f72696573223b693a3630363b733a31353a2200496e6772656469656e7400616d74223b733a313a2233223b733a31363a2200496e6772656469656e7400756e6974223b733a353a225069656365223b733a31363a2200496e6772656469656e7400636f7374223b643a342e353b7d693a323b4f3a31303a22496e6772656469656e74223a393a7b733a32333a2200496e6772656469656e74007265636970655f6e616d65223b733a31303a22427265616420736f7073223b733a32343a2200496e6772656469656e74007265636970655f64625f6964223b4e3b733a32333a2200496e6772656469656e74007072657061726174696f6e223b4e3b733a31363a2200496e6772656469656e74006e616d65223b733a32353a224d696c6b2c2032252c20772f61646420766974204120262044223b733a31393a2200496e6772656469656e7400666f6f645f6964223b733a323a223331223b733a32303a2200496e6772656469656e740063616c6f72696573223b693a3438383b733a31353a2200496e6772656469656e7400616d74223b733a313a2234223b733a31363a2200496e6772656469656e7400756e6974223b733a333a22437570223b733a31363a2200496e6772656469656e7400636f7374223b643a383b7d7d733a31353a22002a00696e737472756374696f6e73223b733a32303a22736f616b20697420757020616e6420656e6a6f79223b733a31313a22002a0063616c6f72696573223b693a313237343b733a373a22002a00636f7374223b643a31322e35373030303030303030303030303032383432313730393433303430343030373433343834343937303730333132353b733a31303a22002a00757365725f6964223b733a323a222d31223b733a383a22002a007969656c64223b693a313b733a31333a22002a007969656c645f756e6974223b733a373a22706f7274696f6e223b7d),
(96, 'The Adonis', -1, 0x4f3a363a22526563697065223a393a7b733a373a22002a006e616d65223b733a31303a225468652041646f6e6973223b733a383a22002a0064625f6964223b4e3b733a31343a22002a00696e6772656469656e7473223b613a323a7b693a303b4f3a31303a22496e6772656469656e74223a393a7b733a32333a2200496e6772656469656e74007265636970655f6e616d65223b733a31303a225468652041646f6e6973223b733a32343a2200496e6772656469656e74007265636970655f64625f6964223b4e3b733a32333a2200496e6772656469656e74007072657061726174696f6e223b4e3b733a31363a2200496e6772656469656e74006e616d65223b733a31323a22542d626f6e6520537465616b223b733a31393a2200496e6772656469656e7400666f6f645f6964223b733a323a223531223b733a32303a2200496e6772656469656e740063616c6f72696573223b693a323538303b733a31353a2200496e6772656469656e7400616d74223b733a313a2233223b733a31363a2200496e6772656469656e7400756e6974223b733a343a2245616368223b733a31363a2200496e6772656469656e7400636f7374223b643a32313b7d693a313b4f3a31303a22496e6772656469656e74223a393a7b733a32333a2200496e6772656469656e74007265636970655f6e616d65223b733a31303a225468652041646f6e6973223b733a32343a2200496e6772656469656e74007265636970655f64625f6964223b4e3b733a32333a2200496e6772656469656e74007072657061726174696f6e223b4e3b733a31363a2200496e6772656469656e74006e616d65223b733a333a22456767223b733a31393a2200496e6772656469656e7400666f6f645f6964223b733a323a223332223b733a32303a2200496e6772656469656e740063616c6f72696573223b693a3134333b733a31353a2200496e6772656469656e7400616d74223b733a313a2232223b733a31363a2200496e6772656469656e7400756e6974223b733a343a2245616368223b733a31363a2200496e6772656469656e7400636f7374223b643a302e353b7d7d733a31353a22002a00696e737472756374696f6e73223b733a31373a2245617420666f7220427265616b66617374223b733a31313a22002a0063616c6f72696573223b693a323732333b733a373a22002a00636f7374223b643a32312e353b733a31303a22002a00757365725f6964223b733a323a222d31223b733a383a22002a007969656c64223b693a313b733a31333a22002a007969656c645f756e6974223b733a373a22706f7274696f6e223b7d);

-- --------------------------------------------------------

--
-- Table structure for table `t_users`
--

CREATE TABLE IF NOT EXISTS `t_users` (
  `name` varchar(255) NOT NULL COMMENT 'The username',
  `id` int(11) NOT NULL AUTO_INCREMENT COMMENT 'Unique id for the user in the db',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='Stores the users and their account information' AUTO_INCREMENT=1 ;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;