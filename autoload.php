<?php

$cache_file = __DIR__ . DIRECTORY_SEPARATOR . "cache" . DIRECTORY_SEPARATOR . "cache.php";

// Including cache file
include_once $cache_file;

$autoloading_map = array();

/**
 * Autoloader - use, depending of state of the application, of a caching file, an autoload map or search for a class
 * file under the app directories
 * @param $className
 */
$closure = function($className) use ($autoloading_map, $cache_file, $cache_map) {

    $realName = str_replace('/',DIRECTORY_SEPARATOR, $className);

    if(!empty($cache_map) && array_key_exists($realName, $cache_map))
    {
        // If the class is already in cache, then juste require it
        require_once $cache_map[$realName];
        return;
    }
    else if(!empty($autoloading_map) && array_key_exists($realName, $autoloading_map))
    {
        // else if the class is not loaded from cache, it can be from a simple array declared above, then it add it
        // to the cache
        if(!$cache_map)
        {
            $cache_map =  array();
        }

        $cache_map[$realName] = $autoloading_map[$realName];

        file_put_contents($cache_file, "<?php \n $cache_map = ". var_export($cache_map) . ";");

        require_once $autoloading_map[$realName];
        return;
    }
    else
    {
        // else, if it is neither in cache nor in $array variable, then juste search for it in the app files
        searchFile(__DIR__, $className);

        /** Old Simple way of loading classes */
        //require_once __DIR__ . "/src/" . $realName . '.php';
    }
};
spl_autoload_register($closure);

/**
 * Generating cache file with $cache_map content
 * @param $className    Complete namespace of the class
 * @param $path         Complete path to the file containing the class definition
 */
function add_to_cache($className, $path)
{
    global $cache_map, $cache_file;

    if(!empty($className))
    {
        if(!$cache_map)
            $cache_map = array();

        $cache_map[$className] = $path;

        file_put_contents($cache_file, '<?php ' . "\n" . '$cache_map = ' ."\n" . var_export($cache_map, true) . ';' );

    }
}

/**
 * Recursive function allowing for finding a class definition file
 * @param $directory    Current analysed directory
 * @param $file         Current searched file
 */
function searchFile($directory, $file)
{
    // Blacklisted directory names - not doing so will provoke an endless loop
    $blacklist = array ( '.idea', '.git', '.', '..');

    // Getting a handle on the directory
    $dir_handle = opendir($directory);

    // Looping on all the directorie's entry to find the right file
    while(false !== ($entry = readdir($dir_handle)))
    {
        //if($entry != '.' && $entry != '..' && $entry != '.idea' && $entry != '.git')
        if(!in_array($entry, $blacklist))
        {
            // if it's a directory - call back the same function recursively
            if(is_dir($directory. DIRECTORY_SEPARATOR .$entry))
            {
                searchFile($directory . DIRECTORY_SEPARATOR . $entry, $file);
            }
            // If it's a file, test against class name to know if it is the right file
            else if(str_replace(".php", "", $entry) == get_class_name($file))
            {
                $path = $directory . DIRECTORY_SEPARATOR . $entry;
                add_to_cache($file, $path);

                return;
            }
        }
    }

    closedir($dir_handle);


}

/**
 * Give the simple name - without namespaces - of a full namespaced class
 * @param $realName     Full name of the class - OS Format dependent
 * @return $to_search   Real simple name of the class to compare with file name (without extension)
 */
function get_class_name($realName)
{
    $file_components = explode("\\", $realName);
    $to_search = end($file_components);
    return $to_search;
}
