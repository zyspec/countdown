<{if !empty($block)}>
    <{if $block.show_active}><span class="label label-primary" style="margin-right: 3px;"><{$smarty.const._MB_COUNTDOWN_ACTIVE}>: <span class="green"><{$block.active_count}></span></span><br><{/if}>
    <{if $block.show_inactive}><span class="label label-primary" style="margin-right: 3px;"><{$smarty.const._MB_COUNTDOWN_INACTIVE}>: <span class="red"><{$block.inactive_count}></span></span><br><{/if}>
    <{if $block.show_total}><span class="label label-primary" style="margin-right: 3px;"><{$smarty.const._MB_COUNTDOWN_TOTAL}>: <span class="navy"><{$block.total_count}></span></span><br><{/if}>
    <{if $block.show_users}><span class="label label-primary" style="margin-right: 3px;"><{$smarty.const._MB_COUNTDOWN_USERS}>: <{$block.user_count}></span><{/if}>
<{/if}>
