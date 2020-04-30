<table id="countdown_list" name="countdown_list">
    <thead>
    <tr>
        <th colspan="4">
            <{$smarty.const._CD_TEXT_COUNTDOWNS}> <span style='font-style: italic;'>(<{$sub_title}>)</span>
        </th>
    </tr>
    </thead>
    <tbody>
    <{foreach from=$cd_events item=event name=event_list}>
    <{if $smarty.foreach.event_list.first}>
    <tr>
        <td class="head width25 bottom">
            <a href="./index.php?sort=name&order=<{$cd_sort_order}>"><{$smarty.const._CD_TEXT_NAME}></a>
        </td>
        <td class="head bottom">
            <a href="./index.php?sort=description&order=<{$cd_sort_order}>"><{$smarty.const._CD_TEXT_DESCRIPTION}></a>
        </td>
        <td class="head width20 bottom">
            <a href="./index.php?sort=enddatetime&order=<{$cd_sort_order}>"><{$smarty.const._CD_TEXT_EXPIRATION}></a>
        </td>
        <td class="head width20 bottom">
            <a href="./index.php?sort=remaining&order=<{$cd_sort_order}>"><{$smarty.const._CD_TEXT_REMAINING}></a>
        </td>
    </tr>
    <{/if}>
        <tr class="<{cycle values=' odd, even'}>">
            <td>
                <a href="./index.php?op=edit&amp;id=<{$event.id}>"><{$event.name}></a>
            </td>
            <td>
                <{$event.description}>
            </td>
            <td>
                <{$event.enddatetime}>
            </td>
            <td>
                <{$event.remainingtime}>
            </td>
        </tr>
    <{foreachelse}>
        <tr><td class="line150" colspan="4"><{$smarty.const._COUNTDOWN_MSG_NO_EVENTS}></td></tr>
    <{/foreach}>
    <tr>
        <th colspan="4">
        </th>
    </tr>
    </tbody>
    <tfoot>
    <tr>
        <td colspan="4">
            <a href="./index.php?op=add"><{$smarty.const._CD_TEXT_ADD_EVENT}></a>
        </td>
    </tr>
    </tfoot>
</table>
