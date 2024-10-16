<?php 
function _get($param, $default = '') {
    return isset($_GET[$param]) ? $_GET[$param] : $default;
}
?>