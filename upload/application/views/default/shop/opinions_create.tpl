
		<div id="main">

			{top_bar_tpl}

			{top_menu_tpl}
			
			<div id="content" class="container">

<br />

{if '{error_message}'!=''}
<h3>{error_message}</h3>
{/if}

<form action="{site_url}{SHOP0}/creating_opinion/{product_id}" method="post">

<input type="hidden" name="productID" value="{product_id}" />

<h3>{opinion_text}:</h3>
<div class="btn bold" title="bold"></div><div class="btn italic"></div><div class="btn underline"></div><div class="btn link"></div><div class="btn quote"></div>
<div class="btn code"></div><div class="btn image"></div><div class="btn usize"></div><div class="btn dsize"></div><div class="btn nlist"></div>
<div class="btn blist"></div><div class="btn litem"></div><div class="btn back"></div><div class="btn forward"></div>
<br />
<textarea id="message" style="width: 500px" name='body' rows='10'>{opinion_body}</textarea>
<br /><br />

<p><input type='submit' value='{submit}'/></p>

</form>

<br /><br />

<div class="preview"></div>

			</div><!-- end content -->
		
		</div><!-- end main -->
