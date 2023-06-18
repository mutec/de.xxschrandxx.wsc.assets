{include file='header' pageTitle="wcf.page.assetList.title"}

<header class="contentHeader">
	<div class="contentHeaderTitle">
		<h1 class="contentTitle">{lang}wcf.page.assetList.title{/lang}</h1>
	</div>

	<nav class="contentHeaderNavigation">
		<ul>
			<li>
				<a href="{link controller='AssetAdd'}{/link}" class="button">
					<span class="icon icon16 fa-plus"></span>
				{* TODO
				<span>{lang}wcf.menu.link.application.assets.asset.add{/lang}</span>
				*}
				</a>
			</li>
			{event name='contentHeaderNavigation'}
		</ul>
	</nav>
</header>

{hascontent}
<div class="paginationTop">
	{content}
		{pages print=true assign=pagesLinks controller="{\assets\page\AssetListPage::class}" link="pageNo=%d"}
	{/content}
</div>
{/hascontent}

{if $objects|count}
	<div class="section tabularBox">
		<table class="table jsObjectActionContainer" data-object-action-class-name="assets\data\assets\AssetAction">
			<thead>
				<tr>
					<th colspan="2">{lang}wcf.global.objectID{/lang}</th>
					<th>{lang}wcf.global.title{/lang}</th>
					<th>{lang}wcf.page.assetList.category{/lang}</th>
					<th>{lang}wcf.page.assetList.amount{/lang}</th>
					<th>{lang}wcf.page.assetList.location{/lang}</th>
					<th>{lang}wcf.page.assetList.creationDate{/lang}</th>
				</tr>
			</thead>
			<tbody>
				{foreach from=$objects item=object}
					<tr class="jsObjectActionObject" data-object-id="{@$object->getObjectID()}">
						<td class="columnIcon">
							<a href="{link controller='AssetEdit' id=$object->getObjectID()}{/link}" title="{lang}wcf.global.button.edit{/lang}" class="jsTooltip">
								<span class="icon icon16 fa-pencil"></span>
							</a>
							{objectAction action="delete" objectTitle=$object->getTitle()}
							{event name='rowButtons'}
						</td>
						{if ASSETS_LEGACYID_ENABLED}
							<td class="columnID">{$object->getLegacyID()}</td>
						{else}
							<td class="columnID">{#$object->getObjectID()}</td>
						{/if}
						<td class="columnTitle">{$object->getTitle()}</td>
						<td class="columnText">{$object->getCategory()->getTitle()}</td>
						<td class="columnInt">{$object->getAmount()}</td>
						{if $object->isBorrowed()}
							<td class="columnUser">{user object=$object->getUserProfile()}</td>
						{else}
							<td class="columnText">{$object->getLocation()->getTitle()}</td>
						{/if}
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
