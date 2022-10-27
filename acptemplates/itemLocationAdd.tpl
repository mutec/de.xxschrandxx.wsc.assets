{include file='header' pageTitle='wcf.acp.form.itemLocation.formTitle.'|concat:$action}

<header class="contentHeader">
	<div class="contentHeaderTitle">
		<h1 class="contentTitle">{lang}wcf.acp.form.itemLocation.formTitle.{$action}{/lang}</h1>
	</div>
</header>

{@$form->getHtml()}

{include file='footer'}