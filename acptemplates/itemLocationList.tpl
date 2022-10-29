{include file='header'}

<header class="contentHeader">
	<div class="contentHeaderTitle">
		<h1 class="contentTitle">{lang}wcf.acp.page.itemLocationList.title{/lang}</h1>
	</div>

	<nav class="contentHeaderNavigation">
		<ul>
			<li>
				<a href="{link controller='ItemLocationAdd'}{/link}" class="button">
					<span class="icon icon16 fa-plus"></span>
				<span>{lang}wcf.acp.menu.link.configuration.inventory.item.location.add{/lang}</span>
				</a>
			</li>
			{event name='contentHeaderNavigation'}
		</ul>
	</nav>
</header>

{hascontent}
<div class="paginationTop">
	{content}
		{pages print=true assign=pagesLinks controller="ItemLocationList" link="pageNo=%d"}
	{/content}
</div>
{/hascontent}

{if $objects|count}
	<div class="section tabularBox">
		<table class="table jsObjectActionContainer" data-object-action-class-name="wcf\data\inventory\ItemLocationAction">
			<thead>
				<tr>
					<th></th>
					<th>{lang}wcf.global.objectID{/lang}</th>
					<th>{lang}wcf.global.title{/lang}</th>
					<th>{lang}wcf.acp.page.itemLocationList.creationDate{/lang}</th>
				</tr>
			</thead>
			<tbody>
				{foreach from=$objects item=object}
					<tr class="jsObjectActionObject" data-object-id="{@$object->getObjectID()}">
						<td class="columnIcon">
							<a href="{link controller='ItemLocationEdit' id=$object->getObjectID()}{/link}" title="{lang}wcf.global.button.edit{/lang}" class="jsTooltip">
								<span class="icon icon16 fa-pencil"></span>
							</a>
							{objectAction action="delete" objectTitle=$object->getTitle()}
							{event name='rowButtons'}
						</td>
						{if INVENTORY_LEGACYID_ENABLED}
							<td class="columnID">{$object->getLegacyID()}</td>
						{else}
							<td class="columnID">{#$object->getObjectID()}</td>
						{/if}
						<td class="columnTitle">{$object->getTitle()}</td>
						<td class="columnText">{$object->getCategory()->getTitle()}</td>
						{if $object->isBorrowed()}
							<td class="columnUser">{user object=$object->getUser()}</td>
						{else}
							<td class="columnText">{user object=$object->getLocation()->getTitle()}</td>
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
