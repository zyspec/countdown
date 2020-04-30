<div class="container">
	<div>
		<h2><{$smarty.const._CD_TEXT_ADD_EVENT}></h2>
	</div>
	<div class="col">
		<div class="row">
			<div id="countdown_edit_form" class="col">
				<form method="post" action="<{$cd_current_file}>">
					<{* $cd_datetimejs *}>
					<{securityToken}>
					<div class="form-group">
						<label for="txtName"><{$smarty.const._CD_TEXT_NAME}></label>
						<input type="text" class="form-control" id="txtName" name="txtName" value="" placeholder="Enter Countdown Name" required>
					</div>
					<div class="form-group">
						<label for="txtDescription"><{$smarty.const._CD_TEXT_DESCRIPTION}></label>
						<textarea class="form-control" name="txtDescription" id="txtDescription" rows="10" cols="50" placeholder="Enter Description" required></textarea>
					</div>
					<div class="form-group">
						<label for="txtTime"><{$smarty.const._CD_TEXT_CURRENTTIME}></label>
						<div id="txtTime"><{$cd_current_time}></div>
					</div>
					<div class="form-group">
						<label for="txtExpires"><{$smarty.const._CD_TEXT_EXPIRATION}></label>
						<div id="txtExpires"><{$cal_element}></div>
						<{$hour_dropdown}> <{$minute_dropdown}> <{$ampm_dropdown}>
					</div>

					<div class="foot">
						<button class="btn btn-primary" type="submit" name="cmdAddCountdown" id="cmdAddCountdown"><{$smarty.const._CD_TEXT_ADD_COUNTDOWN}></button>
						<button type="reset" class="btn btn-primary" name="cmdReset" id="cmdReset"><{$smarty.const._RESET}></button>
						<button type="button" class="btn btn-primary" name="cmdCancel" id="cmdCancel" onClick="history.go(-1);return true;"><{$smarty.const._CANCEL}></button>
						<{*<input type="submit" name="cmdAddCountdown" id="cmdAddCountdown" value="<{$smarty.const._CD_TEXT_ADD_COUNTDOWN}>" class="formButton">*}>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
