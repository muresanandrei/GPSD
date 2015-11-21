<?php
/**
 * User: andrei
 * Date: 8/19/14
 * Time: 1:49 PM
 */
namespace CoreApp\Website\Controllers\Admin\Item;

use \App,\Input,\DB,\Cache;

class ItemDelete extends \BaseControllers\Webrising
{

	function delete($id)
    {

        $return_data = array('error' => 1, 'message' => 'Item could not be deleted please try again');

        //Get Item Model
        $item_model = App::make('WebsiteItemsModel');

        //Item tags model
        $item_tags_model = App::make('WebsiteItemTagsModel');

        if( $item_model->delete($id) && $item_tags_model->delete($id))
        {

            //System Tools
            $tools = new \SystemTools\Tools;

            $tools->rrmdir('item_files/'.$id);

            $tools->rrmdir('items_photos/'.$id);

            $return_data['error'] = 0;
            $return_data['message'] = 'Item has been deleted succesfully';


            //Flush cache
            Cache::flush();

        }//if the movie was deleted


        /*
         * If we got this far, everything is ok
         */
        return \Response::json( $return_data );

    }//delete


}//end class