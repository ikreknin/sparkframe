{top_bar_tpl}
{top_menu_tpl}

		<main role="main">
			<div class="container">
				<div class="row">
					<div class="col-sm-12">

<form action="{site_url}admin/updating_settings" method="post">

<!-- START settings -->

<input type="hidden" name='settings_id' value='{settings_id}'>

<h2>{system}</h2>

{settings_cms_title_text}
<br />
<input style="width: 200px" type='text' name='settings_cms_title' value='{settings_cms_title}' />
<br /><br />

{settings_cms_description_text}
<br />
<input style="width: 400px" type='text' name='settings_cms_description' value='{settings_cms_description}' />
<br /><br />

<p class='text'>{settings_site_code}: {settings_sys}</p>
<input type="hidden" name='settings_sys' value='{settings_sys}'>
<br />

{settings_metakeywords_text}
<br />
<input style="width: 200px" type='text' name='settings_metakeywords' value='{settings_metakeywords}' />
<br /><br />

{settings_metadescription_text}
<br />
<input style="width: 200px" type='text' name='settings_metadescription' value='{settings_metadescription}' />
<br /><br />

{settings_charset_text}
<br />
<input style="width: 200px" type='text' name='settings_charset' value='{settings_charset}' />
<br /><br />

{settings_lang_text} ({short_code})
<br />
<input style="width: 200px" type='text' name='settings_lang' value='{settings_lang}' />
<br /><br />

{settings_lang_text} ({full_code})
<br />
<input style="width: 200px" type='text' name='settings_lang_full' value='{settings_lang_full}' />
<br /><br />

{settings_owner_name_text}
<br />
<input style="width: 200px" type='text' name='settings_owner_name' value='{settings_owner_name}' />
<br /><br />

{settings_admin_email_text}
<br />
<input style="width: 200px" type='text' name='settings_admin_email' value='{settings_admin_email}' />
<br /><br />

{settings_cms_enabled_text}
<br />
<select name="settings_cms_enabled">
<option value="y" {if '{settings_cms_enabled}'=='y'}selected="selected"{/if}>{yes}</option>
<option value="n" {if '{settings_cms_enabled}'=='n'}selected="selected"{/if}>{no}</option>
</select>
<br /><br />

{settings_cms_message_text}
<br />
<textarea name="settings_cms_message" cols="50" rows="5">{settings_cms_message}</textarea>
<br /><br />

{settings_cron_enabled_text}
<br />
<select name="settings_cron_enabled">
<option value="y" {if '{settings_cron_enabled}'=='y'}selected="selected"{/if}>{yes}</option>
<option value="n" {if '{settings_cron_enabled}'=='n'}selected="selected"{/if}>{no}</option>
</select>
<br /><br />

{settings_cron_period_text}
<br />
<input style="width: 200px" type='text' name='settings_cron_period' value='{settings_cron_period}' />
<br /><br />

{settings_cron_text}
<br />
<input style="width: 200px" type='text' name='settings_cron' value='{settings_cron}' />
<br /><br />

{settings_notes_text}
<br />
<textarea name="settings_notes" cols="50" rows="5">{settings_notes}</textarea>
<br /><br />

{editor_text}
<br />
<select name="settings_editor">
<option value="n" {if '{settings_editor}'=='n'}selected="selected"{/if}>HTML</option>
<option value="t" {if '{settings_editor}'=='t'}selected="selected"{/if}>TinyMCE</option>
<option value="c" {if '{settings_editor}'=='c'}selected="selected"{/if}>CKEditor</option>
</select>
<br /><br />

{settings_cached_text}
<br />
<select name="settings_cached">
<option value="1" {if '{settings_cached}'=='1'}selected="selected"{/if}>{yes}</option>
<option value="0" {if '{settings_cached}'=='0'}selected="selected"{/if}>{no}</option>
</select>
<br /><br />

<hr>

<h2>{blog_text}</h2>

{settings_guests_allowed_text}
<br />
<select name="settings_guests_allowed">
<option value="1" {if '{settings_guests_allowed}'=='1'}selected="selected"{/if}>{yes}</option>
<option value="0" {if '{settings_guests_allowed}'=='0'}selected="selected"{/if}>{no}</option>
</select>
<br /><br />

{settings_rows_per_page_text}
<br />
<input style="width: 200px" type='text' name='settings_rows_per_page' value='{settings_rows_per_page}' />
<br /><br />

{settings_nested_categories_text}
<br />
<select name="settings_nested_categories">
<option value="1" {if '{settings_nested_categories}'=='1'}selected="selected"{/if}>{yes}</option>
<option value="0" {if '{settings_nested_categories}'=='0'}selected="selected"{/if}>{no}</option>
</select>
<br /><br />

{settings_one_cat_text}
<br />
<select name="settings_one_cat">
<option value="1" {if '{settings_one_cat}'=='1'}selected="selected"{/if}>{yes}</option>
<option value="0" {if '{settings_one_cat}'=='0'}selected="selected"{/if}>{no}</option>
</select>
<br /><br />

{settings_comments_allowed_text}
<br />
<select name="settings_enable_comments">
<option value="1" {if '{settings_enable_comments}'=='1'}selected="selected"{/if}>{yes}</option>
<option value="0" {if '{settings_enable_comments}'=='0'}selected="selected"{/if}>{no}</option>
</select>
<br /><br />

{settings_guests_comments_allowed_text}
<br />
<select name="settings_guests_comments_allowed">
<option value="1" {if '{settings_guests_comments_allowed}'=='1'}selected="selected"{/if}>{yes}</option>
<option value="0" {if '{settings_guests_comments_allowed}'=='0'}selected="selected"{/if}>{no}</option>
</select>
<br /><br />

{settings_comments_per_page_text}
<br />
<input style="width: 200px" type='text' name='settings_comments_per_page' value='{settings_comments_per_page}' />
<br /><br />

Aksimet
<br />
<input style="width: 200px" type='text' name='spam_api_key' value='{spam_api_key}' />
<br /><br />

{settings_comments_tree_text}
<br />
<select name="settings_comments_tree">
<option value="y" {if '{settings_comments_tree}'=='y'}selected="selected"{/if}>{yes}</option>
<option value="n" {if '{settings_comments_tree}'=='n'}selected="selected"{/if}>{no}</option>
</select>
<br /><br />

{settings_settings_start_seg_1_text}
<br />
<input style="width: 200px" type='text' name='settings_start_seg_1' value='{settings_start_seg_1}' />
<br /><br />

<hr>

<h2>{users_text}</h2>

{settings_users_per_page_text}
<br />
<input style="width: 200px" type='text' name='settings_users_per_page' value='{settings_users_per_page}' />
<br /><br />

{settings_enable_registration_text}
<br />
<select name="settings_enable_registration">
<option value="1" {if '{settings_enable_registration}'=='1'}selected="selected"{/if}>{yes}</option>
<option value="0" {if '{settings_enable_registration}'=='0'}selected="selected"{/if}>{no}</option>
</select>
<br /><br />

{settings_email_registration_text}
<br />
<select name="settings_email_registration">
<option value="y" {if '{settings_email_registration}'=='y'}selected="selected"{/if}>{yes}</option>
<option value="n" {if '{settings_email_registration}'=='n'}selected="selected"{/if}>{no}</option>
</select>
<br /><br />

{settings_ban_masks_text}
<br />
<select name="settings_ban_masks">
<option value="y" {if '{settings_ban_masks}'=='y'}selected="selected"{/if}>{yes}</option>
<option value="n" {if '{settings_ban_masks}'=='n'}selected="selected"{/if}>{no}</option>
</select>
<br /><br />

{settings_banned_emails_text}
<br />
<textarea name="settings_banned_emails" cols="50" rows="5">{settings_banned_emails}</textarea>
<br /><br />

<hr>

<h2>{forum_text}</h2>

{settings_forum_topics_per_page_text}
<br />
<input style="width: 200px" type='text' name='settings_forum_topics_per_page' value='{settings_forum_topics_per_page}' />
<br /><br />

{settings_forum_posts_per_page_text}
<br />
<input style="width: 200px" type='text' name='settings_forum_posts_per_page' value='{settings_forum_posts_per_page}' />
<br /><br />

<hr>

<h2>{shop_text}</h2>

{settings_dl_period_text}
<br />
<input style="width: 200px" type='text' name='settings_dl_period' value='{settings_dl_period}' />
<br /><br />

PayPal Sandbox
<br />
<select name="settings_paypal_sandbox">
<option value="1" {if '{settings_paypal_sandbox}'=='1'}selected="selected"{/if}>{yes}</option>
<option value="0" {if '{settings_paypal_sandbox}'=='0'}selected="selected"{/if}>{no}</option>
</select>
<br /><br />

{settings_seller_email_text}
<br />
<input style="width: 200px" type='text' name='settings_seller_email' value='{settings_seller_email}' />
<br /><br />

{settings_shop_nested_categories_text}
<br />
<select name="settings_shop_nested_categories">
<option value="1" {if '{settings_shop_nested_categories}'=='1'}selected="selected"{/if}>{yes}</option>
<option value="0" {if '{settings_shop_nested_categories}'=='0'}selected="selected"{/if}>{no}</option>
</select>
<br /><br />

{settings_shop_rows_per_page_text}
<br />
<input style="width: 200px" type='text' name='settings_shop_rows_per_page' value='{settings_shop_rows_per_page}' />
<br /><br />

{static_page_header}
<br />
<input style="width: 200px" type='text' name='settings_st_header' value='{settings_st_header}' />
<br /><br />

{static_page_main}
<br />
<input style="width: 200px" type='text' name='settings_st_main' value='{settings_st_main}' />
<br /><br />

{static_page_footer}
<br />
<input style="width: 200px" type='text' name='settings_st_footer' value='{settings_st_footer}' />
<br /><br />

{pp_available_text}
<br />
<select name="pp_av">
<option value="y" {if '{pp_av}'=='y'}selected="selected"{/if}>{yes}</option>
<option value="n" {if '{pp_av}'=='n'}selected="selected"{/if}>{no}</option>
</select>
<br /><br />

{cart_available_text}
<br />
<select name="cart_av">
<option value="y" {if '{cart_av}'=='y'}selected="selected"{/if}>{yes}</option>
<option value="n" {if '{cart_av}'=='n'}selected="selected"{/if}>{no}</option>
</select>
<br /><br />

<!-- END settings -->

{currency_text}
<br />
<select name="def_curr">
<!-- START currency_list_select -->
<option value="{currency_id}">{currency_code} - {currency_name} </option>
<!-- END currency_list_select -->
</select>
<br /><br />

<p><input type='submit' value='{submit}'/></p>
</form>

					</div>
				</div><!-- /.row -->
			</div><!-- /.container -->

		</main>
