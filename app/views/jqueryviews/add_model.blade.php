<?php

foreach ($models as $model) {
    echo '<option value="' . $model['model'] . '=' . $model['generation'] . '">' . $model['model'] . ' (' . $model['generation'] . ')</option>';
}
?>