<form method="post" action="<{$cd_current_file}>">
    <{$cd_datetimejs}>
    <table width="100%" border="1" cellpadding="0" cellspacing="2" class="formButton">
        <tr>
            <th colspan="2">
                <{$smarty.const._CD_TEXT_ADD_EVENT}>
            </th>
        </tr>

        <tr>
            <td class="head">
                <{$smarty.const._CD_TEXT_NAME}>
            </td>
            <td class="<{cycle name=' columnclass' values='odd,even'}>">
                <input type="text" id="txtName" name="txtName" class="formButton" maxlength="50" size="50" value=""/>
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
                <input type='text' name='dtDateTime' id='dtDateTime' size='10' maxlength='10' value='<{$current_date}>'/>
                <input type='button' value=' ... ' onclick='return showCalendar("dtDateTime");'/> <br/><br/> <{$hour_dropdown}> <{$minute_dropdown}> <{$ampm_dropdown}>
            </td>
        </tr>

        <tr>
            <td class="foot" colspan="2">
                <input type="submit" name="cmdAddCountdown" id="cmdAddCountdown" value="<{$smarty.const._CD_TEXT_ADD_COUNTDOWN}>" class="formButton"/>
            </td>
        </tr>
    </table>
</form>
