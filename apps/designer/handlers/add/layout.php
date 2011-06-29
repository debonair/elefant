<?php

$page->layout = 'admin';

if (! User::require_admin ()) {
	header ('Location: /admin');
	exit;
}

$f = new Form ('post', 'designer/addlayout');
if ($f->submit ()) {
	if (@file_put_contents ('layouts/' . $_POST['name'] . '.html', $_POST['body'])) {
		$page->title = i18n_get ('Layout Added');
		echo '<p><a href="/designer">' . i18n_get ('Continue') . '</a></p>';
		@chmod ('layouts/' . $_POST['name'] . '.html', 0777);
		return;
	}
	$page->title = 'Saving Layout Failed';
	echo '<p>Check that your permissions are correct and try again.</p>';
} else {
	$page->title = i18n_get ('New Layout');
}

$o = new StdClass;

$o->failed = $f->failed;
$o = $f->merge_values ($o);
echo $tpl->render ('designer/add/layout', $o);

?>