{include file='header'}

<header class="contentHeader">
	<div class="contentHeaderTitle">
		<h1 class="contentTitle">{lang}wcf.acp.page.assetLocationList.title{/lang}</h1>
	</div>

	<nav class="contentHeaderNavigation">
		<ul>
			<li>
				<a href="{link controller='AssetLocationAdd' application='assets'}{/link}" class="button">
					<span class="icon icon16 fa-plus"></span>
					<span>{lang}wcf.acp.menu.link.application.assets.asset.location.add{/lang}</span>
				</a>
			</li>
			{event name='contentHeaderNavigation'}
		</ul>
	</nav>
</header>

{hascontent}
<div class="paginationTop">
	{content}
		{pages print=true assign=pagesLinks controller="AssetLocationList" application="assets" link="pageNo=%d"}
	{/content}
</div>
{/hascontent}

{if $objects|count}
	<div class="section tabularBox">
		<table class="table jsObjectActionContainer" data-object-action-class-name="assets\data\assets\AssetLocationAction">
			<thead>
				<tr>
					<th colspan="2">{lang}wcf.global.objectID{/lang}</th>
					<th>{lang}wcf.global.title{/lang}</th>
					<th>{lang}wcf.acp.page.assetLocationList.address{/lang}</th>
					<th>{lang}wcf.acp.page.assetLocationList.creationDate{/lang}</th>
				</tr>
			</thead>
			<tbody>
				{foreach from=$objects item=object}
					<tr class="jsObjectActionObject" data-object-id="{@$object->getObjectID()}">
						<td class="columnIcon">
							<a href="{link controller='AssetLocationEdit' application='assets' id=$object->getObjectID()}{/link}" title="{lang}wcf.global.button.edit{/lang}" class="jsTooltip">
								<span class="icon icon16 fa-pencil"></span>
							</a>
							{objectAction action="delete" objectTitle=$object->getTitle()}
							{event name='rowButtons'}
						</td>
						<td class="columnID">{#$object->getObjectID()}</td>
						<td class="columnTitle">{$object->getTitle()}</td>
						<td class="columnText">{$object->getAddress()}</td>
						<td class="columnDate">{@$object->getCreatedTimestamp()|time}</td>
					</tr>
				{/foreach}
			</tbody>
		</table>
	</div>
{else}
	<p class="info">{lang}wcf.global.noItems{/lang}</p>
{/if}

{include file='footer'}
