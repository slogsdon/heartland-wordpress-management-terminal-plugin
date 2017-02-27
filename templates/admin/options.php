<?php require 'header.php'; ?>

<form action="options.php" method="post">
<?php
// output security fields for the registered setting `$this->code`
settings_fields($this->code);
// output setting sections and their fields
// (sections are registered for `$this->code`, each field is registered to a specific section)
do_settings_sections($this->code);
// output save settings button
submit_button('Save Settings');
?>
</form>

<?php require 'footer.php'; ?>
