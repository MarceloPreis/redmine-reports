<?php 
function _get($param) {
    return isset($_GET[$param]) ? $_GET[$param] : '';
}
?>