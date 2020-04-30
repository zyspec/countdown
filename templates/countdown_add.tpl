<form method="post" action="<{$cd_current_file}>">
    <{* $cd_datetimejs *)}>
    <table border="1" cellpadding="0" cellspacing="2" class="formButton width100">
        <thead>
        <tr>
            <th colspan="2">
                <{$smarty.const._CD_TEXT_ADD_EVENT}>
            </th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="head">
                <{$smarty.const._CD_TEXT_NAME}>
            </td>
            <td class="<{cycle name=' columnclass' values='odd,even'}>">
                <input type="text" id="txtName" name="txtName" class="formButton" maxlength="50" size="50" value="">
            </td>
        </tr>

        <tr>
            <td class="head">
                <{$smarty.const._CD_TEXT_DESCRIPTION}>
            </td>
            <td class="<{cycle name=' columnclass'}>">
                <textarea name="txtDescription" id="txtDescription" rows="10" cols="50"></textarea>
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
<{*
                <input type='text' name='dtDateTime' id='dtDateTime' size='10' maxlength='10' value='<{$current_date}>'>
                <input type='button' value=' ... ' onclick='return showCalendar("dtDateTime");'><br><br>
*}>
                <{$hour_dropdown}> <{$minute_dropdown}> <{$ampm_dropdown}>
            </td>
        </tr>
        </tbody>
        <tfoot>
        <tr>
            <td class="foot" colspan="2">
                <input type="submit" name="cmdAddCountdown" id="cmdAddCountdown" value="<{$smarty.const._CD_TEXT_ADD_COUNTDOWN}>" class="formButton">
                <input type="reset" name="cmdReset" value="<{$smarty.const._RESET}>" class="formButton"/>
                <input type="button" value="<{$smarty.const._CANCEL}>" onClick="history.go(-1);return true;" class="formButton"/>
                <{$security_token}>
            </td>
        </tr>
        </tfoot>
    </table>
</form>
