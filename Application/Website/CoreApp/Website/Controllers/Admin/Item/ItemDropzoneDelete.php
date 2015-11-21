<?php
/**
 * User: andrei
 * Date: 2/8/14
 * Time: 9:00 PM
 */
namespace CoreApp\Website\Controllers\Admin\Item;

use \App,\Input,\Request,\Response;

class ItemDropzoneDelete extends \BaseControllers\Webrising {


    public function item_file($item_id)
    {

       $file = Input::get('id');

       if($file) {


                unlink('item_files/'.$item_id.'/'.$file);

            return Response::json(['delete' => true ]);
        }//return sucess 
        else {
            return Response::json('error', 400);
        }//else return error
    

    }//item_file

}//end item