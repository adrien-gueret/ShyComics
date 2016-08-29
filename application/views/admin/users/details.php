<h2><?= $view->user->prop('username'); ?></h2>
<p>
	<form action="<?= $view->base_url; ?>admin/users" method="post">
		<fieldset>
			<p>
				<input type="hidden" name="__method__" value="update" />
				<input type="hidden" name="id_user" value="<?= $view->user->getId(); ?>" />
				<?= Library_i18n::get('admin.users.ban'); ?>
				<?php if($view->user->prop('is_banned')): ?>
					<input type="radio" name="banned" value="0" /><?= Library_i18n::get('global.no'); ?>&nbsp;
					<input type="radio" name="banned" value="1" checked="checked" /><?= Library_i18n::get('global.yes'); ?>
				<?php else: ?>
					<input type="radio" name="banned" value="0" checked="checked" /><?= Library_i18n::get('global.no'); ?>&nbsp;
					<input type="radio" name="banned" value="1" /><?= Library_i18n::get('global.yes'); ?>
				<?php endif; ?>
				<br />
				<?= Library_i18n::get('admin.users.group'); ?><br />
				<select name="id_group">
					<?php foreach($view->groups as $group): ?>
						<?php if($group->equals($view->user->load('user_group'))): ?>
							<option value="<?= $group->getId(); ?>" selected="selected"><?= $group->prop('name'); ?></option>
						<?php else: ?>
							<option value="<?= $group->getId(); ?>"><?= $group->prop('name'); ?></option>
						<?php endif; ?>
					<?php endforeach; ?>
				</select>
				<hr />
				<?= Library_i18n::get('admin.users.about'); ?><br />
				<textarea name="about"><?= $view->user->prop('about'); ?></textarea>
			</p>
			<button><i class="fa fa-check" aria-hidden="true"></i></button>
		</fieldset>
	</form>
</p>