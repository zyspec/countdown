<form method="post" action="<{$cd_current_file}>">
    <table class="formButton width100 bspacing2 pad2 border">
        <thead>
        <tr>
            <th colspan="2">
                <h2><{if 0 == $countdown_id}><{$smarty.const._CD_TEXT_ADD_EVENT}><{else}><{$smarty.const._CD_TEXT_UPDATE_EVENT}><{/if}></h2>
            </th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="head">
                <{$smarty.const._CD_TEXT_NAME}>
            </td>
            <td class="<{cycle name=' columnclass' values='odd,even'}>">
            <input type="text" id="txtName" name="txtName" class="formButton caption-marker" maxlength="50" size="50" value="<{$countdown_name}>" placeholder="<{$smarty.const._CD_TEXT_NAME_PLACEHOLDER}>" required/>
            </td>
        </tr>

        <tr>
            <td class="head">
                <{$smarty.const._CD_TEXT_DESCRIPTION}>
            </td>
            <td class="<{cycle name=' columnclass'}>">
            <textarea name="txtDescription" id="txtDescription" class="caption-marker" rows="10" cols="50" placeholder="<{$smarty.const._CD_TEXT_DESC_PLACEHOLDER}>" required><{$countdown_description}></textarea>
            </td>
        </tr>
        <tr>
            <td class="head">
                <{$smarty.const._CD_TEXT_CURRENTTIME}>
            </td>
            <td class="<{cycle name=' columnclass'}>">
                <{$cd_current_time}>
            </td>
        </tr>
        <tr>
            <td class="head">
                <{$smarty.const._CD_TEXT_EXPIRATION}>
            </td>
            <td class="<{cycle name=' columnclass'}>">
                <{$cal_element}>
                <{$hour_dropdown}> <{$minute_dropdown}> <{$ampm_dropdown}>
            </td>
        </tr>
        </tbody>
        <tfoot>
        <tr>
            <td class="foot" colspan="2">
                <{if 0 == $countdown_id}>
                <input type="submit" name="cmdAddCountdown" id="cmdAddCountdown" value="<{$smarty.const._CD_TEXT_ADD_COUNTDOWN}>" class="formButton">
                <{else}>
                <input type="submit" name="cmdEditCountdown" value="<{$smarty.const._CD_TEXT_UPDATE_COUNTDOWN}>" class="formButton"/>
                <input type="submit" name="cmdRemoveCountdown" value="<{$smarty.const._CD_TEXT_REMOVE_COUNTDOWN}>" class="formButton"/>
                <{/if}>
                <input type="reset" name="cmdReset" value="<{$smarty.const._RESET}>" class="formButton"/>
                <input type="button" value="<{$smarty.const._CANCEL}>" onClick="history.go(-1);return true;" class="formButton"/>
                <input type="hidden" name="txtCountdownID" value="<{$countdown_id}>"/>
                <{$security_token}>
            </td>
        </tr>
        </tfoot>
    </table>
</form>
