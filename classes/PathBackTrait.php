<?php
trait PathBackTrait {

    /**
     * Removes the specified number of parent directories
     *
     * @param int $num The number of parent directories to remove
     * @return string The path after removing the specified number of parent directories
     */
    public function pathBack($num) {
        // Get the plugin directory path
        $root_path = plugin_dir_path( __FILE__ );

        // Remove the specified number of parent directories
        for ($i=0; $i<=$num; $i++) {
            $root_path = dirname($root_path);
        }
        return $root_path;
    }
}