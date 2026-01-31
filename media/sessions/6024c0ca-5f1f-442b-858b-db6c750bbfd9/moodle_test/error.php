<?php
/**
 * @package     Joomla.Site
 * @subpackage  Templates.moodle_test
 * @copyright   Copyright (C) 2026. All rights reserved.
 * @license     GNU General Public License version 2 or later
 */

defined('_JEXEC') or die;

use Joomla\CMS\Language\Text;

/** @var Joomla\CMS\Document\ErrorDocument $this */

$errorCode    = $this->error->getCode();
$errorMessage = $this->error->getMessage();
?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo $errorCode; ?> - <?php echo htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8'); ?></title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            margin: 0; padding: 0;
            display: flex; justify-content: center; align-items: center;
            min-height: 100vh; background: #f5f5f5; color: #333;
        }
        .error-container { text-align: center; padding: 2rem; max-width: 600px; }
        .error-code { font-size: 6rem; font-weight: 700; color: #e74c3c; margin: 0; line-height: 1; }
        .error-message { font-size: 1.5rem; margin: 1rem 0; }
        .error-link {
            display: inline-block; margin-top: 1.5rem; padding: 0.75rem 2rem;
            background: #3498db; color: #fff; text-decoration: none;
            border-radius: 4px; transition: background 0.3s;
        }
        .error-link:hover { background: #2980b9; }
    </style>
</head>
<body>
    <div class="error-container">
        <h1 class="error-code"><?php echo $errorCode; ?></h1>
        <p class="error-message"><?php echo htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8'); ?></p>
        <a href="<?php echo $this->baseurl; ?>/index.php" class="error-link">
            <?php echo Text::_('JERROR_LAYOUT_GO_TO_THE_HOME_PAGE'); ?>
        </a>
    </div>
</body>
</html>
