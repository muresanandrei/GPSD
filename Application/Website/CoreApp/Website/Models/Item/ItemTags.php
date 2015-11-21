<?php
/**
 * Created by PhpStorm.
 * User: Andrei
 * Date: 2/21/14
 * Time: 11:23 AM
 */
namespace CoreApp\Website\Models\Item;

use \DB;

class ItemTags {

    public $table = 'item_tags';

    public function insert_item_tags($tags)
    {

        return DB::table($this->table)
                 ->insert($tags);
            
    }//insert_item_tags


     public function get_tags_by_item_id($item_id)
     {

        $tags_obj = DB::table($this->table)
                      ->where('item_id','=',$item_id)
                      ->get(array('tag_id'));

        $tags_array = array();

        foreach($tags_obj as $t)
        {

            $tags_array[] = $t->tag_id;

        }//foreach tags object

        return $tags_array;

      }//get_tags_by_item_id



    public function update_tags($item_id,$tags)
    {

        return DB::table($this->table)
                 ->where('item_id','=',$item_id)
                 ->update($tags);
            
    }//update_tags



    public function delete($id)
    {

        return DB::table($this->table)
                 ->where('item_id','=',$id)
                 ->delete();

     }//delete

}//end ItemTags