<?php
session_destroy();
header("Location: ".$url->getBase());
?>