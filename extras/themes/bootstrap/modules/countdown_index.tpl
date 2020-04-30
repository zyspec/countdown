<div class="container">
	<div>
		<h2><{$smarty.const._CD_TEXT_COUNTDOWNS}> <span style='font-style: italic;'>(<{$sub_title}>)</span></h2>
	</div>
	<table id="countdown_list" name="countdown_list" class="table table-hover">
		<{*
		<thead>
		<tr>
			<th colspan="4">
				<{$smarty.const._CD_TEXT_COUNTDOWNS}> <span style='font-style: italic;'>(<{$sub_title}>)</span>
			</th>
		</tr>
		</thead>
		*}>
		<tbody>
		<{foreach from=$cd_events item=event name=event_list}>
		<{if $smarty.foreach.event_list.first}>
		<tr>
			<td class="bottom">
				<a href="./index.php?sort=name&order=<{$cd_sort_order}>"><{$smarty.const._CD_TEXT_NAME}></a>
			</td>
			<td class="bottom">
				<a href="./index.php?sort=description&order=<{$cd_sort_order}>"><{$smarty.const._CD_TEXT_DESCRIPTION}></a>
			</td>
			<td class="bottom d-none d-sm-table-cell">
				<a href="./index.php?sort=enddatetime&order=<{$cd_sort_order}>"><{$smarty.const._CD_TEXT_EXPIRATION}></a>
			</td>
			<td class="bottom">
				<a href="./index.php?sort=remaining&order=<{$cd_sort_order}>"><{$smarty.const._CD_TEXT_REMAINING}></a>
			</td>
		</tr>
		<{/if}>
		<tr>
			<td class="middle">
				<a href="./index.php?op=edit&amp;id=<{$event.id}>"><{$event.name}></a>
			</td>
			<td class="middle">
				<{$event.description}>
			</td>
			<td class="middle d-none d-sm-table-cell">
				<{$event.enddatetime}>
			</td>
			<td class="middle">
				<{$event.remainingtime}>
			</td>
		</tr>
		<{foreachelse}>
			<tr><td class="line150" colspan="4"><{$smarty.const._COUNTDOWN_MSG_NO_EVENTS}></td></tr>
		<{/foreach}>
		</tbody>
		<tfoot>
		<tr>
			<td colspan="4">
				<form>
					<button type="submit" class="btn btn-primary" name="cmdEditCountdown" id="cmdEditCountdown"><{$smarty.const._CD_TEXT_ADD_EVENT}></button>
					<input type="hidden" name="op" value="add" />
<{*  				<a href="./index.php?op=add"><{$smarty.const._CD_TEXT_ADD_EVENT}></a> *}>
				</form>
			</td>
		</tr>
		</tfoot>
	</table>
</div>
