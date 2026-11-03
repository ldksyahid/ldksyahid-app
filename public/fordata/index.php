<?php
// Redirect direct folder access to Laravel /fordata route
header('Location: /fordata', true, 301);
exit;
