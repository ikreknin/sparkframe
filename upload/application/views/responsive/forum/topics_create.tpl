
{top_bar_tpl}

{top_menu_tpl}

				<!-- BEGIN CONTENT WRAPPER -->
				<div id="content-wrapper" class="content-wrapper">
					<div class="container">
						<div class="clearfix">
							<div class="grid_12">

{if '{error_message}'!=''}
<h3>{error_message}</h3>
{/if}

<form action="{site_url}{FORUM0}/creating_topic/{forum_id}" method="post">

<input type="hidden" name="forumID" value="{forum_id}" />

{title_text}:<br />
<input style="width: 500px" type='text' name='topic_title' value='{topic_title}' />
<br /><br />

{topic_text}:<br />
<br />
<textarea name="body" style="width: 500px" rows="20">{topic_body}</textarea>
<br /><br />

<p><input type='submit' value='{submit}'/></p>

</form>

<br /><br />

<div class="preview"></div>

							</div>
						</div>
					</div>
				</div>
				<!-- END CONTENT WRAPPER -->
