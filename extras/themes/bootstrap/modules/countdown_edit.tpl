<div class="container">
	<div>
		<h2><{$smarty.const._CD_TEXT_UPDATE_EVENT}></h2>
	</div>
	<div class="row">
		<div class="col">
			<div id="countdown_edit_form" class="col">
				<form method="post" action="<{$cd_current_file}>">
					<{* $cd_datetimejs *}>
					<div class="form-group">
						<label for="txtName"><{$smarty.const._CD_TEXT_NAME}></label>
						<input type="text" class="form-control" id="txtName" name="txtName" maxlength="50" size="50" value="<{$countdown_name}>" placeholder="Enter Countdown Name" required/>
					</div>
					<div class="form-group">
						<label for="txtDescription"><{$smarty.const._CD_TEXT_DESCRIPTION}></label>
						<textarea class="form-control" name="txtDescription" id="txtDescription" rows="10" cols="50" placeholder="Enter Description" required><{$countdown_description}></textarea>
					</div>
					<div class="form-group">
						<label for="txtExpires"><{$smarty.const._CD_TEXT_EXPIRATION}></label>
						<div id="txtExpires"><{$cal_element}></div>
						<{$hour_dropdown}> <{$minute_dropdown}> <{$ampm_dropdown}>
					</div>
					<div class="foot">
						<button type="submit" class="btn btn-primary" name="cmdEditCountdown" id="cmdEditCountdown"><{$smarty.const._CD_TEXT_UPDATE_COUNTDOWN}></button>
						<button type="submit" class="btn btn-primary" name="cmdRemoveCountdown" id="cmdRemoveCountdown"><{$smarty.const._CD_TEXT_REMOVE_COUNTDOWN}></button>
						<button type="reset" class="btn btn-primary" name="cmdReset" id="cmdReset"><{$smarty.const._RESET}></button>
						<button type="button" class="btn btn-primary" name="cmdCancel" id="cmdCancel" onClick="history.go(-1);return true;"><{$smarty.const._CANCEL}></button>
						<input type="hidden" name="txtCountdownID" value="<{$countdown_id}>"/>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

