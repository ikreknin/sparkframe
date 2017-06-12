SparkFrame CMS 3.0.0

Installation Instructions:
1. Edit in upload/application/config/config.php this code:

	$config['db_user'] = '';
	$config['db_pass'] = '';
	$config['db_name'] = '';

For example:

	$config['db_user'] = 'root';
	$config['db_pass'] = '';
	$config['db_name'] = 'sparkframe2';

2. Edit in upload/system/libraries/crypter.php this code:

	public $password = "Any password here";

For example:

	public $password = "afasbfvcabvcbakfhb243ksadjbkjb";


3. Edit in upload/index.php this code:

	define('FWURL', 'http://localhost/sparkframe/');
	define('SUBDIR', '');

For example:

	define('FWURL', 'http://sparkframe.id.lv/');
	define('SUBDIR', '');

4. Edit in upload/install/install.php this code:

	define('FWURL', 'http://localhost/sparkframe/');
	define('SUBDIR', '');

(like in the previous item)

5. Upload all files from /upload/ directory

6. Run /install/install.php

7. Specify the following parameters during the installation:

	User Name:
	Password:

	Full Name:
	E-mail:
	PayPal E-mail: 

and click 'Submit'

7.1. Run /install/update.php to update the system

8. Delete /install/ directory

9. Modify attributes of the following directories (they should be 777):

	/files/
	/images/
	/media/
	/system/database/cache/

10. Modify attributes of the following files (they should be 666):

	application/extensions/ratings_init_extension/ratings.data.txt
	

11. Log in and go to:

	Admin Control Panel -> System -> Modules

and install all Modules (click 'Install')

12. Go to:

	Admin Control Panel -> System -> Modules

and install all Extensions except one of these:

	foreign_title_url_extension (removes Cyrillic) OR foreign_title_url_cyrillic_extension (transliterates Cyrillic)

AND except one of these:

	ratings_extension (uses File for data) OR advanced_ratings_init_extension (uses MySQL DB for data)

13. To use Aksimet SPAM Protection Extension
	12.1. Enter WordPress API Key (you can get it free here: http://akismet.com/wordpress/ ) in Aksimet field in Admin Settings Section
	12.2. switch on aksimet_comment_extension in Admin Extensions Section

14. Go to http://code.google.com/apis/maps/signup.html and get API Key.

Open /application/widgets/googlemaps_widget/googlemaps_widget.php and insert your API Key between ''

	$Google_Maps_API_Key = '';

to get something like

	$Google_Maps_API_Key = 'ABQIAAAAAmhvxhIWHpBCOO5MkdOFTxTxd-aqZqWY-ego0JHiTJQIWzqduhRFeMc4kbkF2wKZjFiy1dfIx1YjKw';

15. Edit the following file

	/application/widgets/ajaxemailsignup_widget/ajaxemailsignup_widget.php

to insert the real domain in the code:

	$result .= '<link rel="stylesheet" href="http://localhost/application/widgets/ajaxemailsignup_widget/css/ajaxemailsignup_widget.css" type="text/css" media="screen" />';

AND

	$result .= '<form id="newsletter-signup" action="http://localhost/ajaxemailsignup_module/add" method="post">

to get sometning like

	$result .= '<link rel="stylesheet" href="http://sparkframe.id.lv/application/widgets/ajaxemailsignup_widget/css/ajaxemailsignup_widget.css" type="text/css" media="screen" />';

AND

	$result .= '<form id="newsletter-signup" action="http://sparkframe.id.lv/ajaxemailsignup_module/add" method="post">


NOTE: Switch on the Poll module to see the blog page (or delete {poll_widget} in application/views/default/site.tpl).

Version history:
- 3.0.1
1. rutube.ru support added
- 3.0.2
1. Widget support added in user profiles
- 3.0.3
1. Jssor Slider added (www.jssor.com)
- 3.0.4
1. 1 Tags Module added (creates tables in MySQL) ('art_tags' field is dropped in 'articles' table;
   now 'art_tags' is created by Tags Module)
2. 6 Tags Extensions added (to create/edit/delete articles).
3. 2 Tags Widgets added (to show tag list and tag cloud)
- 3.0.5
1. latest_articles_frontpage_widget can display tags.
- 3.0.6
1. Added Simple theme (Admin Control Panel)
2. sanitizeDataX($data) function added (database.php) to prevent XSS attacks
- 3.0.7
1. CKEditor (4.4.7) updated
2. TinyMCE (4.1.7) updated
3. KCFinder (3.12) added
4. SyntaxHighlighter (3.0.83) updated (with SH4TinyMCE)
- 3.0.8
1. Table with ISO 4217 Currency Codes added
- 3.0.9
1. Currency selection in Settings
2. PayPal uses the currency set in Settings
- 3.1.0
1. Front-end 'Bootstrap' skin added.
2. Typical names for .tpl files now:
	top_1_tpl
	top_2_tpl
	sidebar_1_tpl
	sidebar_2_tpl
	sidebar_3_tpl
	sidebar_4_tpl
	bottom_top_tpl
	bottom_1_tpl
	bottom_2_tpl
	top_bar_tpl
	top_menu_tpl
	bottom_bar_tpl
	slider_tpl
3. Javascript for TAGs improved (now it can delete tags in the input lines by clicking them)
