<?php namespace Cms\Modules\Core\Models;

use File;
use Config;

class Theme
{
    protected static $themes = array();

    /**
     * Retrieves all the info required from the themes.
     */
    public static function gatherInfo()
    {
        if (count(self::$themes)) {
            return;
        }

        // get a list of theme directories
        $themeDir = public_path(config('theme.themeDir'));
        $directories = File::directories($themeDir);
        foreach ($directories as $dir) {
            if (!File::isFile($dir.'/theme.json')) {
                continue;
            }
            $options = json_decode(File::get($dir.'/theme.json'), true);

            $options['dir'] = str_replace('\\', '/', $dir);
            $options['dir'] = explode('/', $options['dir']);
            $options['dir'] = end($options['dir']);

            self::$themes[$dir] = (object)array_only($options, ['name', 'author', 'site', 'type', 'dir', 'version']);
        }

    }

    /**
     * Returns all the info.
     *
     * @return array
     */
    public static function all()
    {
        self::gatherInfo();
        return self::$themes;
    }

    /**
     * Filters out all the frontend themes
     *
     * @return array
     */
    public static function getFrontend()
    {
        self::gatherInfo();
        return array_filter(self::$themes, function ($theme) {
            return $theme->type == 'frontend';
        });
    }

    /**
     * Filters out all the backend themes
     *
     * @return array
     */
    public static function getBackend()
    {
        self::gatherInfo();
        return array_filter(self::$themes, function ($theme) {
            return $theme->type == 'backend';
        });
    }

    /**
     * Returns a list of all the layouts in this theme
     *
     * @return array
     */
    public static function getLayouts()
    {
        $theme = self::themeInfo(config('cms.core.app.themes.frontend', 'default'));
        $dir = key($theme);

        if (!File::isDirectory($dir)) {
            return [];
        }

        $files = File::glob($dir.'/layouts/*.blade.php');
        $files = array_map(function ($filename) {
            $fn = explode('/', $filename);
            return str_replace('.blade.php', '', end($fn));
        }, $files);

        return array_combine($files, $files) ?: [];
    }

    /**
     * Returns info about a single theme
     *
     * @return array
     */
    private static function themeInfo($name)
    {
        self::gatherInfo();
        return array_filter(self::$themes, function ($theme) use ($name) {
            return $theme->dir == $name;
        });
    }
}