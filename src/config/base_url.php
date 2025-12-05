<?php
// Detecta dinámicamente la carpeta del proyecto
define("BASE_URL", rtrim(dirname($_SERVER["SCRIPT_NAME"]), "/") . "/");
