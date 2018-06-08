<table id="countdown_list" name="countdown_list">
    <tr>
        <th colspan="4">
            <{$smarty.const._CD_TEXT_COUNTDOWNS}>
        </th>
    </tr>

    <tr>
        <td class="head">
            <a href="./index.php?sort=name&order=<{$cd_sort_order}>"><{$smarty.const._CD_TEXT_NAME}></a>
        </td>
        <td class="head">
            <a href="./index.php?sort=description&order=<{$cd_sort_order}>"><{$smarty.const._CD_TEXT_DESCRIPTION}></a>
        </td>
        <td class="head">
            <a href="./index.php?sort=enddatetime&order=<{$cd_sort_order}>"><{$smarty.const._CD_TEXT_EXPIRATION}></a>
        </td>
        <td class="head">
            <a href="./index.php?sort=remaining&order=<{$cd_sort_order}>"><{$smarty.const._CD_TEXT_REMAINING}></a>
        </td>
    </tr>

    <{foreach from=$cd_events item=event}>
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
    <{/foreach}>

    <tr>
        <th colspan="4">
        </th>
    </tr>
    <tr>
        <td>
            <a href="./index.php?op=add"><{$smarty.const._CD_TEXT_ADD_EVENT}></a>
        </td>
    </tr>
</table>

