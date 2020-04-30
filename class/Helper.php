<?php

namespace XoopsModules\Countdown;

/*
 You may not change or alter any portion of this comment or credits of
 supporting developers from this source code or any supporting source code
 which is considered copyrighted (c) material of the original comment or credit
 authors.

 This program is distributed in the hope that it will be useful, but
 WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */
/**
 * Module: Countdown
 *
 * @package   \XoopsModules\Countdown
 * @license   https://www.gnu.org/licenses/gpl-2.0.html GNU Public License
 * @copyright Copyright (c) 2001-2020 {@link https://xoops.org XOOPS Project}
 * @author    XOOPS Module Development Team
 * @link      https://github.com/XoopsModules25x/countdown
 * @since     0.30
 */

/**
 * Class Helper
 */
class Helper extends \Xmf\Module\Helper
{
    /**
     * @var bool $debug true if debug enable | false if not
     */
    public $debug = false;

    /**
     * @param string|null $dirname the module's directory/folder name for the helper, this module if null
     * @return void
     */
    public function __construct($dirname = null)
    {
        if (null === $dirname) {
            $dirname = basename(dirname(__DIR__));
            $this->dirname = $dirname;
        }
        parent::__construct($dirname);
    }

    /**
     * Instantiate the helper
     *
     * @param string $dirname module directory name
     * @return \Xmf\Module\Helper
     */
    public static function getInstance($dirname = null)
    {
        static $instance;
        if (null === $instance) {
            $instance = new static($dirname);
        }
        return $instance;
    }

    /**
     * Get the helper's directory/folder name
     *
     * @return string directory/folder name for this helper
     */
    public function getDirname()
    {
        return $this->dirname;
    }

    /**
     * Get an Object Handler
     *
     * @param string $name name of handler to load
     *
     * @return bool|\XoopsObjectHandler|\XoopsPersistableObjectHandler
     */
    public function getHandler($name)
    {
        $db    = \XoopsDatabaseFactory::getDatabaseConnection();
        $class = __NAMESPACE__ . '\\' . ucfirst($name) . 'Handler';

        return new $class($db);
    }

    /**
     * Return absolute upload folder URL for a module's relative URL
     *
     * @param string $url module relative URL
     *
     * @return string
     */
    public function uploadUrl($url = '')
    {
        $rc = new \ReflectionClass("\Xmf\Module\Helper");

        $ret = XOOPS_UPLOAD_URL . '/' . $this->dirname . '/' . $url;
        if ($rc->hasMethod('uploadUrl')) {
            $ret = parent::uploadUrl();
        }
        return $ret;
    }

    /**
     * Return absolute upload folder path for a module's relative path
     *
     * @param string $path module relative file system path
     *
     * @return string
     */
    public function uploadPath($path = '')
    {
        $rc = new \ReflectionClass("\Xmf\Module\Helper");

        $ret = XOOPS_UPLOAD_PATH . '/' . $this->dirname . '/' . $path;
        if ($rc->hasMethod('uploadPath')) {
            $ret = parent::uploadPath();
        }
        return $ret;
    }
}
