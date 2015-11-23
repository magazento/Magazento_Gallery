<?php
/*
* Created on Nov 16, 2012
*  Author Ivan Proskuryakov - volgodark@gmail.com - Magazento.com
*  Copyright Proskuryakov Ivan. Magazento.com © 2012. All Rights Reserved.
*  Single Use, Limited Licence and Single Use No Resale Licence ["Single Use"]
*/
?>
<?php

$installer = $this;
$installer->startSetup();
$installer->run("


CREATE TABLE IF NOT EXISTS `{$this->getTable('magazento_gallery_category')}` (
  `category_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `catalog_id` int(11) NOT NULL,
  `title` varchar(255) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL,
  `url` text NOT NULL,
  `position` tinyint(4) NOT NULL DEFAULT '1',
  `item_address` text NOT NULL,
  `align_category` varchar(10) NOT NULL DEFAULT 'left',
  `align_content` varchar(10) NOT NULL DEFAULT 'right',
  `content_top` text CHARACTER SET utf8 COLLATE utf8_bin,
  `content_bottom` text CHARACTER SET utf8 COLLATE utf8_bin,
  `from_time` datetime DEFAULT NULL,
  `to_time` datetime DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `products` text NOT NULL,
  `category_ids` text NOT NULL,
  `page_ids` text NOT NULL,
  PRIMARY KEY (`category_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=12 ;


INSERT INTO `{$this->getTable('magazento_gallery_category')}` (`category_id`, `catalog_id`, `title`, `url`, `position`, `item_address`, `align_category`, `align_content`, `content_top`, `content_bottom`, `from_time`, `to_time`, `is_active`, `products`, `category_ids`, `page_ids`) VALUES
(8, 0, 'Restaurant & Painting', '', 1, '85fb89cc5d1b1933796866c7bd692e71.jpg', 'left', 'right', NULL, NULL, '2012-11-07 10:19:23', NULL, 1, '', '', '7'),
(10, 0, 'Abstract painting', '', 1, 'b09dcbb82fa38ec471aa253e8e88fef8.JPG', 'left', 'right', NULL, NULL, '2012-11-07 22:10:44', NULL, 1, '', '', '3'),
(11, 0, 'Axe commercials', '', 2, 'c90cfdfe87d21b60a49790eafdaef8fb.jpg', 'left', 'right', NULL, NULL, '2012-11-09 00:05:36', NULL, 1, '161,162,163,164,165,166', ',3,10,18,5,17', '');

-- --------------------------------------------------------


CREATE TABLE IF NOT EXISTS `{$this->getTable('magazento_gallery_category_store')}` (
  `category_id` smallint(6) unsigned DEFAULT NULL,
  `store_id` smallint(6) unsigned DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `{$this->getTable('magazento_gallery_category_store')}` (`category_id`, `store_id`) VALUES
(11, 0),
(10, 0),
(8, 0);

-- --------------------------------------------------------


CREATE TABLE IF NOT EXISTS `{$this->getTable('magazento_gallery_item')}` (
  `item_id` smallint(6) NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `url` text NOT NULL,
  `position` tinyint(10) NOT NULL DEFAULT '0',
  `content` text NOT NULL,
  `from_time` datetime DEFAULT NULL,
  `to_time` datetime DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `item_type` varchar(10) NOT NULL,
  `item_address` text NOT NULL,
  `products` text NOT NULL,
  `category_ids` text NOT NULL,
  `page_ids` text NOT NULL,
  PRIMARY KEY (`item_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=46 ;


INSERT INTO `{$this->getTable('magazento_gallery_item')}` (`item_id`, `title`, `url`, `position`, `content`, `from_time`, `to_time`, `is_active`, `item_type`, `item_address`, `products`, `category_ids`, `page_ids`) VALUES
(21, 'Image #001', '#', 1, '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus nibh nisi, aliquam at volutpat vel, suscipit sed ante. Sed eu velit et orci luctus euismod. Donec velit tellus, semper vel suscipit a, porta ac tortor. Sed ac enim nulla, eu fringilla elit. Pellentesque porttitor tempor mattis. Sed dictum semper orci, at volutpat metus convallis fringilla. Proin aliquam rutrum lorem, nec semper orci accumsan in. Morbi a leo eu velit dignissim molestie non quis dui. Ut ut imperdiet tortor. Pellentesque fringilla lacus id mi placerat id luctus lacus dapibus. Nullam faucibus laoreet quam et vestibulum.</p>\r\n<p><strong><br /></strong></p>', '2012-11-16 10:18:10', NULL, 1, 'image', '4dbe5f9d9e528a1ec82afd8341bd3c10.jpg', '165', ',22', '3'),
(23, 'Axe commercial #001', '', 1, '<p><span>Sed porttitor convallis lectus in accumsan. Nunc enim tellus, ullamcorper vel interdum id, rutrum vel dui. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Integer tincidunt, augue a eleifend iaculis, leo erat varius metus, non sagittis libero diam eget tellus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. In libero ligula, ornare at ultrices ut, viverra luctus ligula. Donec imperdiet enim ut orci ultricies feugiat. In hac habitasse platea dictumst. Integer vehicula, purus a ornare vehicula, elit est eleifend sem, eu gravida nisi nisi iaculis diam. Pellentesque nunc metus, porta id viverra sit amet, consequat sed tellus. </span></p>\r\n<p><span><strong>Praesent arcu erat, congue ac placerat eget, aliquam sed velit. Maecenas vitae lectus at ipsum rutrum molestie vel sed diam. Vivamus nunc ipsum, tristique ut mollis a, ultrices quis erat. Nulla interdum nibh vitae mi aliquet dapibus. Etiam at orci et quam euismod condimentum. Sed justo tellus, congue sit amet molestie quis, hendrerit at justo.</strong></span></p>', '2012-11-16 12:42:07', NULL, 1, 'youtube', 'mPwhMoQBg_8', '', '', ''),
(24, 'Lynx Excite - \"Fallen Angels\"', 'http://vimeo.com/19121097', 1, '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam turpis purus, tincidunt nec rutrum sed, porta quis erat. Integer bibendum adipiscing euismod. Nulla ornare, orci ac condimentum commodo, lorem nisl faucibus quam, et adipiscing nunc velit a nibh. Vivamus gravida dictum nisi, quis bibendum urna mattis a. Praesent sed ligula mauris, eu cursus urna. Nam viverra est molestie orci aliquam cursus. Proin vitae velit leo, quis porttitor felis. Nunc aliquam hendrerit volutpat. Praesent convallis porttitor lorem et consequat.</p>', '2012-11-16 12:54:56', NULL, 1, 'vimeo', '19121097', '', '', ''),
(27, 'Video file (SWF)', '', 1, '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum adipiscing turpis ac neque pulvinar viverra. Donec vestibulum pulvinar odio, sit amet luctus nibh sollicitudin pellentesque. Integer bibendum aliquam viverra. Sed id ipsum diam. Quisque rhoncus gravida felis, et porttitor est vestibulum tincidunt. Maecenas viverra elementum sollicitudin. Curabitur tortor ipsum, auctor venenatis suscipit sit amet, varius sed erat. In a turpis eget arcu bibendum gravida et vel neque. Aenean fermentum magna ut mauris scelerisque eu vehicula augue placerat. Sed sodales vulputate sollicitudin. Vestibulum egestas laoreet ante ut ultrices. Sed at elit augue. Sed volutpat nisi non ligula fermentum gravida. Nam fringilla lobortis augue, feugiat pulvinar sapien venenatis quis.</p>\r\n<p>Nullam sed ligula eu nunc mollis rutrum. Curabitur blandit enim id turpis hendrerit sollicitudin. Proin eu molestie nibh. Donec non sapien in nisl ultricies fringilla. Proin accumsan quam id risus semper consequat. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Cras ultr</p>', '2012-11-12 10:05:56', NULL, 1, 'video', '15f2648cd9c0eaaa2f070fcb125942e6.flv', '', '', ''),
(28, 'Image #002', '', 1, '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus nibh nisi, aliquam at volutpat vel, suscipit sed ante. Sed eu velit et orci luctus euismod. Donec velit tellus, semper vel suscipit a, porta ac tortor. Sed ac enim nulla, eu fringilla elit. Pellentesque porttitor tempor mattis. Sed dictum semper orci, at volutpat metus convallis fringilla. Proin aliquam rutrum lorem, nec semper orci accumsan in. Morbi a leo eu velit dignissim molestie non quis dui. Ut ut imperdiet tortor. Pellentesque fringilla lacus id mi placerat id luctus lacus dapibus. Nullam faucibus laoreet quam et vestibulum.</p>', '2012-11-16 10:18:35', NULL, 1, 'image', 'a59a48596925efbaf61149ef1dd93e5c.jpg', '', '', ''),
(29, 'Image #004', '', 1, '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus nibh nisi, aliquam at volutpat vel, suscipit sed ante. Sed eu velit et orci luctus euismod. Donec velit tellus, semper vel suscipit a, porta ac tortor. Sed ac enim nulla, eu fringilla elit. Pellentesque porttitor tempor mattis. Sed dictum semper orci, at volutpat metus convallis fringilla. Proin aliquam rutrum lorem, nec semper orci accumsan in. Morbi a leo eu velit dignissim molestie non quis dui. Ut ut imperdiet tortor. Pellentesque fringilla lacus id mi placerat id luctus lacus dapibus. Nullam faucibus laoreet quam et vestibulum.</p>', '2012-11-16 10:20:07', NULL, 1, 'image', '5066c8eb192295f0b0f2f2dd6037d3f9.jpg', '', '', ''),
(30, 'Image #003', '', 1, '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus nibh nisi, aliquam at volutpat vel, suscipit sed ante. Sed eu velit et orci luctus euismod. Donec velit tellus, semper vel suscipit a, porta ac tortor. Sed ac enim nulla, eu fringilla elit. Pellentesque porttitor tempor mattis. Sed dictum semper orci, at volutpat metus convallis fringilla. Proin aliquam rutrum lorem, nec semper orci accumsan in. Morbi a leo eu velit dignissim molestie non quis dui. Ut ut imperdiet tortor. Pellentesque fringilla lacus id mi placerat id luctus lacus dapibus. Nullam faucibus laoreet quam et vestibulum.</p>', '2012-11-16 10:19:42', NULL, 1, 'image', '9e3a0357172edaea7864427d69c91b0e.jpg', '', '', ''),
(31, 'Image #005', '', 1, '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus nibh nisi, aliquam at volutpat vel, suscipit sed ante. Sed eu velit et orci luctus euismod. Donec velit tellus, semper vel suscipit a, porta ac tortor. Sed ac enim nulla, eu fringilla elit. Pellentesque porttitor tempor mattis. Sed dictum semper orci, at volutpat metus convallis fringilla. Proin aliquam rutrum lorem, nec semper orci accumsan in. Morbi a leo eu velit dignissim molestie non quis dui. Ut ut imperdiet tortor. Pellentesque fringilla lacus id mi placerat id luctus lacus dapibus. Nullam faucibus laoreet quam et vestibulum.</p>', '2012-11-16 10:20:31', NULL, 1, 'image', 'd8a786ba1441b1fc68e61010af1ba956.jpg', '', '', ''),
(32, 'Image #006', '', 1, '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus nibh nisi, aliquam at volutpat vel, suscipit sed ante. Sed eu velit et orci luctus euismod. Donec velit tellus, semper vel suscipit a, porta ac tortor. Sed ac enim nulla, eu fringilla elit. Pellentesque porttitor tempor mattis. Sed dictum semper orci, at volutpat metus convallis fringilla. Proin aliquam rutrum lorem, nec semper orci accumsan in. Morbi a leo eu velit dignissim molestie non quis dui. Ut ut imperdiet tortor. Pellentesque fringilla lacus id mi placerat id luctus lacus dapibus. Nullam faucibus laoreet quam et vestibulum.</p>', '2012-11-16 10:20:53', NULL, 1, 'image', '1002a0093b0ced6907f4ea236485d5fb.jpg', '', '', ''),
(33, 'Image #007', '', 1, '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus nibh nisi, aliquam at volutpat vel, suscipit sed ante. Sed eu velit et orci luctus euismod. Donec velit tellus, semper vel suscipit a, porta ac tortor. Sed ac enim nulla, eu fringilla elit. Pellentesque porttitor tempor mattis. Sed dictum semper orci, at volutpat metus convallis fringilla. Proin aliquam rutrum lorem, nec semper orci accumsan in. Morbi a leo eu velit dignissim molestie non quis dui. Ut ut imperdiet tortor. Pellentesque fringilla lacus id mi placerat id luctus lacus dapibus. Nullam faucibus laoreet quam et vestibulum.</p>', '2012-11-16 10:22:03', NULL, 1, 'image', 'ef4ca8ead01111eec345fbce9371852e.jpg', '', '', ''),
(34, 'Image #008', '', 1, '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus nibh nisi, aliquam at volutpat vel, suscipit sed ante. Sed eu velit et orci luctus euismod. Donec velit tellus, semper vel suscipit a, porta ac tortor. Sed ac enim nulla, eu fringilla elit. Pellentesque porttitor tempor mattis. Sed dictum semper orci, at volutpat metus convallis fringilla. Proin aliquam rutrum lorem, nec semper orci accumsan in. Morbi a leo eu velit dignissim molestie non quis dui. Ut ut imperdiet tortor. Pellentesque fringilla lacus id mi placerat id luctus lacus dapibus. Nullam faucibus laoreet quam et vestibulum.</p>', '2012-11-16 10:22:31', NULL, 1, 'image', '28750c05f45c646d385e5e6a686464a4.jpg', '', '', ''),
(35, 'Image #009', '', 1, '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus nibh nisi, aliquam at volutpat vel, suscipit sed ante. Sed eu velit et orci luctus euismod. Donec velit tellus, semper vel suscipit a, porta ac tortor. Sed ac enim nulla, eu fringilla elit. Pellentesque porttitor tempor mattis. Sed dictum semper orci, at volutpat metus convallis fringilla. Proin aliquam rutrum lorem, nec semper orci accumsan in. Morbi a leo eu velit dignissim molestie non quis dui. Ut ut imperdiet tortor. Pellentesque fringilla lacus id mi placerat id luctus lacus dapibus. Nullam faucibus laoreet quam et vestibulum.</p>', '2012-11-16 10:22:55', NULL, 1, 'image', '4f8291ad682e1e671442c22efd4d56b9.jpg', '', '', ''),
(36, 'Abstract #001', '', 1, '<p><span>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In in erat eu sapien blandit imperdiet in gravida elit. Nulla luctus tellus vehicula velit consequat feugiat. Etiam at est nec justo congue fermentum eget sit amet eros. Suspendisse magna sem, pretium quis feugiat sit amet, ornare ut mauris. Vestibulum fringilla ligula sed odio tempor vestibulum. Donec sapien elit, accumsan non cursus nec, convallis eget risus. Nunc vitae sapien eros, a laoreet ligula. Nunc lectus est, rhoncus id commodo a, malesuada at dui. Curabitur vitae turpis vel felis tempus suscipit a sit amet diam. Morbi in venenatis nisl. Fusce vitae quam ut enim cursus dictum. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aenean condimentum volutpat leo, vel mattis tortor hendrerit quis. Aenean sed gravida mi. Maecenas sagittis velit eu tortor eleifend dapibus egestas ante laoreet. Integer porttitor feugiat vestibulum.</span></p>', '2012-11-16 11:56:34', NULL, 1, 'image', '7bd886da5e4ce46595cf033a58ac305f.jpg', '', '', ''),
(37, 'Abstract #002', '', 1, '<p><span>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In in erat eu sapien blandit imperdiet in gravida elit. Nulla luctus tellus vehicula velit consequat feugiat. Etiam at est nec justo congue fermentum eget sit amet eros. Suspendisse magna sem, pretium quis feugiat sit amet, ornare ut mauris. Vestibulum fringilla ligula sed odio tempor vestibulum. Donec sapien elit, accumsan non cursus nec, convallis eget risus. Nunc vitae sapien eros, a laoreet ligula. Nunc lectus est, rhoncus id commodo a, malesuada at dui. Curabitur vitae turpis vel felis tempus suscipit a sit amet diam. Morbi in venenatis nisl. Fusce vitae quam ut enim cursus dictum. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aenean condimentum volutpat leo, vel mattis tortor hendrerit quis. Aenean sed gravida mi. Maecenas sagittis velit eu tortor eleifend dapibus egestas ante laoreet. Integer porttitor feugiat vestibulum.</span></p>', '2012-11-16 11:57:07', NULL, 1, 'image', 'c4d81e75f66b4b22a2f7ca6820351613.jpg', '', '', ''),
(38, 'Abstract #003', '', 1, '<p><span>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In in erat eu sapien blandit imperdiet in gravida elit. Nulla luctus tellus vehicula velit consequat feugiat. Etiam at est nec justo congue fermentum eget sit amet eros. Suspendisse magna sem, pretium quis feugiat sit amet, ornare ut mauris. Vestibulum fringilla ligula sed odio tempor vestibulum. Donec sapien elit, accumsan non cursus nec, convallis eget risus. Nunc vitae sapien eros, a laoreet ligula. Nunc lectus est, rhoncus id commodo a, malesuada at dui. Curabitur vitae turpis vel felis tempus suscipit a sit amet diam. Morbi in venenatis nisl. Fusce vitae quam ut enim cursus dictum. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aenean condimentum volutpat leo, vel mattis tortor hendrerit quis. Aenean sed gravida mi. Maecenas sagittis velit eu tortor eleifend dapibus egestas ante laoreet. Integer porttitor feugiat vestibulum.</span></p>', '2012-11-16 11:57:52', NULL, 1, 'image', 'fc161ec068db324e27786c45c1630990.JPG', '', '', ''),
(39, 'Abstract #004', '', 1, '<p><span>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In in erat eu sapien blandit imperdiet in gravida elit. Nulla luctus tellus vehicula velit consequat feugiat. Etiam at est nec justo congue fermentum eget sit amet eros. Suspendisse magna sem, pretium quis feugiat sit amet, ornare ut mauris. Vestibulum fringilla ligula sed odio tempor vestibulum. Donec sapien elit, accumsan non cursus nec, convallis eget risus. Nunc vitae sapien eros, a laoreet ligula. Nunc lectus est, rhoncus id commodo a, malesuada at dui. Curabitur vitae turpis vel felis tempus suscipit a sit amet diam. Morbi in venenatis nisl. Fusce vitae quam ut enim cursus dictum. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aenean condimentum volutpat leo, vel mattis tortor hendrerit quis. Aenean sed gravida mi. Maecenas sagittis velit eu tortor eleifend dapibus egestas ante laoreet. Integer porttitor feugiat vestibulum.</span></p>', '2012-11-16 11:58:22', NULL, 1, 'image', 'b47c8225367f37e15ef0dd6b3c3f85dd.jpg', '', '', ''),
(40, 'Abstract #005', '', 1, '<p><span>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In in erat eu sapien blandit imperdiet in gravida elit. Nulla luctus tellus vehicula velit consequat feugiat. Etiam at est nec justo congue fermentum eget sit amet eros. Suspendisse magna sem, pretium quis feugiat sit amet, ornare ut mauris. Vestibulum fringilla ligula sed odio tempor vestibulum. Donec sapien elit, accumsan non cursus nec, convallis eget risus. Nunc vitae sapien eros, a laoreet ligula. Nunc lectus est, rhoncus id commodo a, malesuada at dui. Curabitur vitae turpis vel felis tempus suscipit a sit amet diam. Morbi in venenatis nisl. Fusce vitae quam ut enim cursus dictum. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aenean condimentum volutpat leo, vel mattis tortor hendrerit quis. Aenean sed gravida mi. Maecenas sagittis velit eu tortor eleifend dapibus egestas ante laoreet. Integer porttitor feugiat vestibulum.</span></p>', '2012-11-16 11:58:54', NULL, 1, 'image', 'b828337b9e8abc872b8197c4281ffc03.jpg', '', '', ''),
(41, 'Abstract #006', '', 1, '<p><span>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In in erat eu sapien blandit imperdiet in gravida elit. Nulla luctus tellus vehicula velit consequat feugiat. Etiam at est nec justo congue fermentum eget sit amet eros. Suspendisse magna sem, pretium quis feugiat sit amet, ornare ut mauris. Vestibulum fringilla ligula sed odio tempor vestibulum. Donec sapien elit, accumsan non cursus nec, convallis eget risus. Nunc vitae sapien eros, a laoreet ligula. Nunc lectus est, rhoncus id commodo a, malesuada at dui. Curabitur vitae turpis vel felis tempus suscipit a sit amet diam. Morbi in venenatis nisl. Fusce vitae quam ut enim cursus dictum. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aenean condimentum volutpat leo, vel mattis tortor hendrerit quis. Aenean sed gravida mi. Maecenas sagittis velit eu tortor eleifend dapibus egestas ante laoreet. Integer porttitor feugiat vestibulum.</span></p>', '2012-11-16 11:59:16', NULL, 1, 'image', '3fb8ce65e808b38bd47ba43a46d7eded.jpg', '', '', ''),
(42, 'Abstract #007', '', 1, '<p><span>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In in erat eu sapien blandit imperdiet in gravida elit. Nulla luctus tellus vehicula velit consequat feugiat. Etiam at est nec justo congue fermentum eget sit amet eros. Suspendisse magna sem, pretium quis feugiat sit amet, ornare ut mauris. Vestibulum fringilla ligula sed odio tempor vestibulum. Donec sapien elit, accumsan non cursus nec, convallis eget risus. Nunc vitae sapien eros, a laoreet ligula. Nunc lectus est, rhoncus id commodo a, malesuada at dui. Curabitur vitae turpis vel felis tempus suscipit a sit amet diam. Morbi in venenatis nisl. Fusce vitae quam ut enim cursus dictum. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aenean condimentum volutpat leo, vel mattis tortor hendrerit quis. Aenean sed gravida mi. Maecenas sagittis velit eu tortor eleifend dapibus egestas ante laoreet. Integer porttitor feugiat vestibulum.</span></p>', '2012-11-16 11:59:37', NULL, 1, 'image', 'e2526a18fa737ab3beb57e9c38fa4c05.jpg', '', '', ''),
(43, 'Abstract #007', '', 1, '<p><span>Lorem ipsum dolor sit amet, consectetur adipiscing elit. In in erat eu sapien blandit imperdiet in gravida elit. Nulla luctus tellus vehicula velit consequat feugiat. Etiam at est nec justo congue fermentum eget sit amet eros. Suspendisse magna sem, pretium quis feugiat sit amet, ornare ut mauris. Vestibulum fringilla ligula sed odio tempor vestibulum. Donec sapien elit, accumsan non cursus nec, convallis eget risus. Nunc vitae sapien eros, a laoreet ligula. Nunc lectus est, rhoncus id commodo a, malesuada at dui. Curabitur vitae turpis vel felis tempus suscipit a sit amet diam. Morbi in venenatis nisl. Fusce vitae quam ut enim cursus dictum. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Aenean condimentum volutpat leo, vel mattis tortor hendrerit quis. Aenean sed gravida mi. Maecenas sagittis velit eu tortor eleifend dapibus egestas ante laoreet. Integer porttitor feugiat vestibulum.</span></p>', '2012-11-16 12:00:03', NULL, 1, 'image', 'a2df77430b3ce77c712c22d0d49007d2.jpg', '', '', ''),
(45, 'Axe commercial #002', '', 1, '<p><span>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Quisque diam nibh, vestibulum quis blandit id, dictum vitae magna. Quisque turpis purus, hendrerit quis gravida et, venenatis quis erat. Nam varius feugiat felis nec cursus. Fusce viverra aliquam fermentum. Nam ante nisl, egestas eu vulputate vel, auctor in odio. Integer fermentum felis quis justo euismod posuere. Nulla facilisi. Vivamus in odio at urna pretium dignissim eget quis diam. Vestibulum vitae justo non odio tempor tincidunt lobortis non dolor. Etiam nisl justo, ultricies sed suscipit eget, sollicitudin tempus tortor. Mauris eget felis id velit tincidunt volutpat.</span></p>', '2012-11-16 12:46:49', NULL, 1, 'youtube', 'I9tWZB7OUSU', '', '', '');

-- --------------------------------------------------------


CREATE TABLE IF NOT EXISTS `{$this->getTable('magazento_gallery_item_category')}` (
  `item_id` smallint(6) unsigned DEFAULT NULL,
  `category_id` smallint(6) unsigned DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `{$this->getTable('magazento_gallery_item_category')}` (`item_id`, `category_id`) VALUES
(21, 8),
(28, 8),
(30, 8),
(29, 8),
(31, 8),
(32, 8),
(33, 8),
(34, 8),
(35, 8),
(36, 8),
(36, 10),
(37, 8),
(37, 10),
(38, 8),
(38, 10),
(39, 8),
(39, 10),
(40, 8),
(40, 10),
(41, 8),
(41, 10),
(42, 8),
(42, 10),
(43, 8),
(43, 10),
(23, 11),
(45, 11),
(24, 11);

-- --------------------------------------------------------


CREATE TABLE IF NOT EXISTS `{$this->getTable('magazento_gallery_item_store')}` (
  `item_id` smallint(6) unsigned DEFAULT NULL,
  `store_id` smallint(6) unsigned DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


INSERT INTO `{$this->getTable('magazento_gallery_item_store')}` (`item_id`, `store_id`) VALUES
(25, 0),
(26, 0),
(27, 0),
(21, 0),
(28, 0),
(30, 0),
(29, 0),
(31, 0),
(32, 0),
(33, 0),
(34, 0),
(35, 0),
(36, 0),
(37, 0),
(38, 0),
(39, 0),
(40, 0),
(41, 0),
(42, 0),
(43, 0),
(23, 0),
(45, 0),
(24, 0);


");

$installer->endSetup();
?>