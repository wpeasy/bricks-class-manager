<?php

namespace WPG_BSC;

class Class_Model
{
    public static function get_bricks_global_class_list()
    {
        return get_option('bricks_global_classes', []);
    }

    public static function update_bricks_global_class_list($new_class_array)
    {
        update_option('bricks_global_classes', $new_class_array);
    }

    public static function add_to_imported_class_list($parsed_css_array)
    {
        $imported_classes = get_option(WPG_BSC_IMPORTED_CLASSES_OPTION, []);
        $set_name = array_key_first($parsed_css_array);

        //unset any old value
        unset($imported_classes[$set_name]);

        $imported_classes = array_merge($imported_classes, $parsed_css_array);
        update_option(WPG_BSC_IMPORTED_CLASSES_OPTION, $imported_classes);
        self::_update_imported_set_status($set_name, ['enabled'=> false, 'local'=>false,'enqueue'=>false]); /* Disabled by default */
    }

    public static function get_imported_class_list()
    {
        return get_option(WPG_BSC_IMPORTED_CLASSES_OPTION);
    }

    public static function delete_from_imported_class_list($set_name)
    {
        $imported_classes = get_option(WPG_BSC_IMPORTED_CLASSES_OPTION, []);
        if(!key_exists($set_name,$imported_classes))
            return __('Not Deleted, The set does not exist');

        unset($imported_classes[$set_name]);
        update_option(WPG_BSC_IMPORTED_CLASSES_OPTION, $imported_classes);

        //Also delete from Bricks Globals
        self::_remove_from_global_class_list($set_name);
        return true;
    }

    public static function update_status($set_name, $status_array)
    {
        self::_update_imported_set_status($set_name,$status_array);

        if($status_array['enabled'] == true){
            self::_add_to_global_class_list($set_name);
        }else{
            self::_remove_from_global_class_list($set_name);
        }
      }




    /* PRIVATE UTILS */
    private static function _add_to_global_class_list($set_name)
    {
        /*
         * Add Class List to Bricks
         */
        $filtered_global_classes = self::_filter_set_from_global_class_list($set_name);
        $class_list_to_add = self::_get_imported_set_by_name($set_name);

        if(is_wp_error($class_list_to_add))
            return $class_list_to_add;

        update_option(WPG_BSC_BRICKS_GLOBAL_CLASSES_OPTION, array_merge($filtered_global_classes, $class_list_to_add));
        return true;
    }


    private static function _update_imported_set_status($set_name, $status)
    {
        $all_classes = get_option(WPG_BSC_IMPORTED_CLASSES_OPTION, []);
        $all_classes[$set_name]['status'] = $status;
        update_option(WPG_BSC_IMPORTED_CLASSES_OPTION, $all_classes);
    }

    private static function _remove_from_global_class_list($set_name)
    {
        $filtered_global_classes = self::_filter_set_from_global_class_list($set_name);
        update_option(WPG_BSC_BRICKS_GLOBAL_CLASSES_OPTION, $filtered_global_classes);

    }

    private static function _filter_set_from_global_class_list($set_name)
    {
        $global_classes = self::get_bricks_global_class_list();


        if(empty($set_name))
            return $global_classes;



        $filtered = [];
        array_walk($global_classes, function ($value) use($set_name, &$filtered) {
            if($value['set_name'] !== $set_name)
                $filtered[] = $value;
        });
        return $filtered;
    }

    private static function _get_imported_set_by_name($set_name)
    {
        $imported_classes = get_option(WPG_BSC_IMPORTED_CLASSES_OPTION, []);
        if(isset($imported_classes[$set_name]))
            return $imported_classes[$set_name]['classes'];

        return new \WP_Error(400, __METHOD__ . " {$set_name} does not exist in imported classes");
    }
}