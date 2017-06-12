<?php
//
class U308{
	
	private $registry;
	private $prefix;
	private $cms_sys;
	private $seg_1;
	private $db_host;
	private $db_user;
	private $db_pass;
	private $db_name;
	
	public function __construct(Registry $registry, $directCall)
	{
		$this->registry = $registry;
		if($directCall == true)
		{
			$this->prefix = $this->registry->library('db')->getPrefix();
			$this->sys_cms = '1';

			include(APPPATH . 'config/config.php');
			if($config['db_prefix'] == '') { $prefix = NULL; }
			else { $prefix = $config['db_prefix']; }
			$registry->library('db')->newConnection($config['db_host'], $config['db_user'], $config['db_pass'], $config['db_name'], $prefix, $sys_cms);

			$this->db_host = $config['db_host'];
			$this->db_user = $config['db_user'];
			$this->db_pass = $config['db_pass'];
			$this->db_name = $config['db_name'];
			$this->prefix = $config['db_prefix'];

			$urlSegments = $this->registry->getURLSegments();
			$this->seg_1 = $this->registry->library('db')->sanitizeData($urlSegments[1]);

			$this->registry->library('template')->page()->addTag('charset', 'utf-8');

			if($_POST['processing'] != 'processing')
			{
				$this->index();
			}
			else
			{
				$this->processing();
			}
		}
	}

	private function index()
	{
//
		$text = 'SparkFrame Update from 3.0.7 to 3.0.8';
		$this->registry->library('template')->page()->addTag('pagetitle', $text);
		$this->registry->library('template')->page()->addTag('heading', $text);
		
		$this->registry->library('template')->page()->addTag('stage', '1');

		$this->registry->library('template')->build('/admin/update.tpl');
	}


	private function processing()
	{
		$this->registry->library('template')->page()->addTag('pagetitle', 'Processing');
		$this->registry->library('template')->page()->addTag('heading', 'Processing...');
		
		$stage = 2;
		$this->registry->library('template')->page()->addTag('stage', $stage);

$prefix = $this->prefix;

$message = '';

//
$sql2 = "UPDATE `{$prefix}cms` SET ver='308' WHERE cms_id='1'";
$this->registry->library('db')->execute($sql2);


$sql2 = "CREATE TABLE IF NOT EXISTS `{$prefix}currency_list` (
  `currency_id` int(11) NOT NULL auto_increment,
  `currency_code` varchar(5) character set utf8 collate utf8_unicode_ci NOT NULL,
  `currency_name` varchar(50) character set utf8 collate utf8_unicode_ci NOT NULL,
  `currency_active` enum('0','1') NOT NULL default '0',
  PRIMARY KEY (`currency_id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
$this->registry->library('db')->execute($sql2);

$sql2 = "INSERT INTO `{$prefix}currency_list` (`currency_id`, `currency_code`, `currency_name`, `currency_active`) VALUES
(1, 'AED', 'United Arab Emirates Dirham', '0'),
(2, 'AFN', 'Afghanistan Afghani', '0'),
(3, 'ALL', 'Albania Lek', '0'),
(4, 'AMD', 'Armenia Dram', '0'),
(5, 'ANG', 'Netherlands Antilles Guilder', '0'),
(6, 'AOA', 'Angola Kwanza', '0'),
(7, 'ARS', 'Argentina Peso', '0'),
(8, 'AUD', 'Australia Dollar', '0'),
(9, 'AWG', 'Aruba Guilder', '0'),
(10, 'AZN', 'Azerbaijan New Manat', '0'),
(11, 'BAM', 'Bosnia and Herzegovina Convertible Marka', '0'),
(12, 'BBD', 'Barbados Dollar', '0'),
(13, 'BDT', 'Bangladesh Taka', '0'),
(14, 'BGN', 'Bulgaria Lev', '0'),
(15, 'BHD', 'Bahrain Dinar', '0'),
(16, 'BIF', 'Burundi Franc', '0'),
(17, 'BMD', 'Bermuda Dollar', '0'),
(18, 'BND', 'Brunei Darussalam Dollar', '0'),
(19, 'BOB', 'Bolivia Boliviano', '0'),
(20, 'BRL', 'Brazil Real', '0'),
(21, 'BSD', 'Bahamas Dollar', '0'),
(22, 'BTN', 'Bhutan Ngultrum', '0'),
(23, 'BWP', 'Botswana Pula', '0'),
(24, 'BYR', 'Belarus Ruble', '0'),
(25, 'BZD', 'Belize Dollar', '0'),
(26, 'CAD', 'Canada Dollar', '0'),
(27, 'CDF', 'Congo/Kinshasa Franc', '0'),
(28, 'CHF', 'Switzerland Franc', '0'),
(29, 'CLP', 'Chile Peso', '0'),
(30, 'CNY', 'China Yuan Renminbi', '0'),
(31, 'COP', 'Colombia Peso', '0'),
(32, 'CRC', 'Costa Rica Colon', '0'),
(33, 'CUC', 'Cuba Convertible Peso', '0'),
(34, 'CUP', 'Cuba Peso', '0'),
(35, 'CVE', 'Cape Verde Escudo', '0'),
(36, 'CZK', 'Czech Republic Koruna', '0'),
(37, 'DJF', 'Djibouti Franc', '0'),
(38, 'DKK', 'Denmark Krone', '0'),
(39, 'DOP', 'Dominican Republic Peso', '0'),
(40, 'DZD', 'Algeria Dinar', '0'),
(41, 'EGP', 'Egypt Pound', '0'),
(42, 'ERN', 'Eritrea Nakfa', '0'),
(43, 'ETB', 'Ethiopia Birr', '0'),
(44, 'EUR', 'Euro Member Countries', '1'),
(45, 'FJD', 'Fiji Dollar', '0'),
(46, 'FKP', 'Falkland Islands (Malvinas) Pound', '0'),
(47, 'GBP', 'United Kingdom Pound', '0'),
(48, 'GEL', 'Georgia Lari', '0'),
(49, 'GGP', 'Guernsey Pound', '0'),
(50, 'GHS', 'Ghana Cedi', '0'),
(51, 'GIP', 'Gibraltar Pound', '0'),
(52, 'GMD', 'Gambia Dalasi', '0'),
(53, 'GNF', 'Guinea Franc', '0'),
(54, 'GTQ', 'Guatemala Quetzal', '0'),
(55, 'GYD', 'Guyana Dollar', '0'),
(56, 'HKD', 'Hong Kong Dollar', '0'),
(57, 'HNL', 'Honduras Lempira', '0'),
(58, 'HRK', 'Croatia Kuna', '0'),
(59, 'HTG', 'Haiti Gourde', '0'),
(60, 'HUF', 'Hungary Forint', '0'),
(61, 'IDR', 'Indonesia Rupiah', '0'),
(62, 'ILS', 'Israel Shekel', '0'),
(63, 'IMP', 'Isle of Man Pound', '0'),
(64, 'INR', 'India Rupee', '0'),
(65, 'IQD', 'Iraq Dinar', '0'),
(66, 'IRR', 'Iran Rial', '0'),
(67, 'ISK', 'Iceland Krona', '0'),
(68, 'JEP', 'Jersey Pound', '0'),
(69, 'JMD', 'Jamaica Dollar', '0'),
(70, 'JOD', 'Jordan Dinar', '0'),
(71, 'JPY', 'Japan Yen', '0'),
(72, 'KES', 'Kenya Shilling', '0'),
(73, 'KGS', 'Kyrgyzstan Som', '0'),
(74, 'KHR', 'Cambodia Riel', '0'),
(75, 'KMF', 'Comoros Franc', '0'),
(76, 'KPW', 'Korea (North) Won', '0'),
(77, 'KRW', 'Korea (South) Won', '0'),
(78, 'KWD', 'Kuwait Dinar', '0'),
(79, 'KYD', 'Cayman Islands Dollar', '0'),
(80, 'KZT', 'Kazakhstan Tenge', '0'),
(81, 'LAK', 'Laos Kip', '0'),
(82, 'LBP', 'Lebanon Pound', '0'),
(83, 'LKR', 'Sri Lanka Rupee', '0'),
(84, 'LRD', 'Liberia Dollar', '0'),
(85, 'LSL', 'Lesotho Loti', '0'),
(86, 'LYD', 'Libya Dinar', '0'),
(87, 'MAD', 'Morocco Dirham', '0'),
(88, 'MDL', 'Moldova Leu', '0'),
(89, 'MGA', 'Madagascar Ariary', '0'),
(90, 'MKD', 'Macedonia Denar', '0'),
(91, 'MMK', 'Myanmar (Burma) Kyat', '0'),
(92, 'MNT', 'Mongolia Tughrik', '0'),
(93, 'MOP', 'Macau Pataca', '0'),
(94, 'MRO', 'Mauritania Ouguiya', '0'),
(95, 'MUR', 'Mauritius Rupee', '0'),
(96, 'MVR', 'Maldives (Maldive Islands) Rufiyaa', '0'),
(97, 'MWK', 'Malawi Kwacha', '0'),
(98, 'MXN', 'Mexico Peso', '0'),
(99, 'MYR', 'Malaysia Ringgit', '0'),
(100, 'MZN', 'Mozambique Metical', '0'),
(101, 'NAD', 'Namibia Dollar', '0'),
(102, 'NGN', 'Nigeria Naira', '0'),
(103, 'NIO', 'Nicaragua Cordoba', '0'),
(104, 'NOK', 'Norway Krone', '0'),
(105, 'NPR', 'Nepal Rupee', '0'),
(106, 'NZD', 'New Zealand Dollar', '0'),
(107, 'OMR', 'Oman Rial', '0'),
(108, 'PAB', 'Panama Balboa', '0'),
(109, 'PEN', 'Peru Nuevo Sol', '0'),
(110, 'PGK', 'Papua New Guinea Kina', '0'),
(111, 'PHP', 'Philippines Peso', '0'),
(112, 'PKR', 'Pakistan Rupee', '0'),
(113, 'PLN', 'Poland Zloty', '0'),
(114, 'PYG', 'Paraguay Guarani', '0'),
(115, 'QAR', 'Qatar Riyal', '0'),
(116, 'RON', 'Romania New Leu', '0'),
(117, 'RSD', 'Serbia Dinar', '0'),
(118, 'RUB', 'Russia Ruble', '0'),
(119, 'RWF', 'Rwanda Franc', '0'),
(120, 'SAR', 'Saudi Arabia Riyal', '0'),
(121, 'SBD', 'Solomon Islands Dollar', '0'),
(122, 'SCR', 'Seychelles Rupee', '0'),
(123, 'SDG', 'Sudan Pound', '0'),
(124, 'SEK', 'Sweden Krona', '0'),
(125, 'SGD', 'Singapore Dollar', '0'),
(126, 'SHP', 'Saint Helena Pound', '0'),
(127, 'SLL', 'Sierra Leone Leone', '0'),
(128, 'SOS', 'Somalia Shilling', '0'),
(129, 'SPL*', 'Seborga Luigino', '0'),
(130, 'SRD', 'Suriname Dollar', '0'),
(131, 'STD', 'S&atilde;o Tom&eacute; and Pr&iacute;ncipe Dobra', '0'),
(132, 'SVC', 'El Salvador Colon', '0'),
(133, 'SYP', 'Syria Pound', '0'),
(134, 'SZL', 'Swaziland Lilangeni', '0'),
(135, 'THB', 'Thailand Baht', '0'),
(136, 'TJS', 'Tajikistan Somoni', '0'),
(137, 'TMT', 'Turkmenistan Manat', '0'),
(138, 'TND', 'Tunisia Dinar', '0'),
(139, 'TOP', 'Tonga Pa\'anga', '0'),
(140, 'TRY', 'Turkey Lira', '0'),
(141, 'TTD', 'Trinidad and Tobago Dollar', '0'),
(142, 'TVD', 'Tuvalu Dollar', '0'),
(143, 'TWD', 'Taiwan New Dollar', '0'),
(144, 'TZS', 'Tanzania Shilling', '0'),
(145, 'UAH', 'Ukraine Hryvnia', '0'),
(146, 'UGX', 'Uganda Shilling', '0'),
(147, 'USD', 'United States Dollar', '1'),
(148, 'UYU', 'Uruguay Peso', '0'),
(149, 'UZS', 'Uzbekistan Som', '0'),
(150, 'VEF', 'Venezuela Bolivar', '0'),
(151, 'VND', 'Viet Nam Dong', '0'),
(153, 'VUV', 'Vanuatu Vatu', '0'),
(154, 'WST', 'Samoa Tala', '0'),
(155, 'XAF', 'Communaut&eacute; Financi&egrave;re Africaine (BEAC) CFA Franc BEAC', '0'),
(156, 'XCD', 'East Caribbean Dollar', '0'),
(157, 'XDR', 'International Monetary Fund (IMF) Special Drawing Rights', '0'),
(158, 'XOF', 'Communaut&eacute; Financi&egrave;re Africaine (BCEAO) Franc', '0'),
(159, 'XPF', 'Comptoirs Fran&ccedil;ais du Pacifique (CFP) Franc', '0'),
(160, 'YER', 'Yemen Rial', '0'),
(161, 'ZAR', 'South Africa Rand', '0'),
(162, 'ZMW', 'Zambia Kwacha', '0') ;";
$this->registry->library('db')->execute($sql2);


$message .= 'Updated successfully.<br />Click NEXT button.<br /><br />
	<FORM action="" method="post">
	<INPUT type="submit" value="Next">
</FORM>';

$this->registry->library('template')->page()->addTag('message', $message);
$this->registry->library('template')->build('/admin/update.tpl');

	}



}


?>