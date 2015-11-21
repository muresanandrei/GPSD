<?php
/**
 * User: andrei
 * Date: 2/8/14
 * Time: 9:00 PM
 */
namespace CoreApp\Website\Controllers\Admin\Item;

use \View, \App,\Input,\DB,\Image,\Response;

class ItemUpdate extends \BaseControllers\Webrising {


    public function update($item_id)
    {

        //Item model
        $item_model = App::make('WebsiteItemsModel');

        //Check if id exists
        if($item_model->check_id_exists($item_id) == false) return App::abort('404');

        //Item Category Model
        $website_item_category_model = App::make('WebsiteItemCategoryModel');

        //Item tag model
        $website_item_tag_model = App::make('WebsiteItemTagModel'); 

         //Movie Tags model
        $item_tags_model = App::make('WebsiteItemTagsModel');

        
        //item
        $item = $item_model->get_item_by_id($item_id)[0];


        $data = array(
            'page_title'  => trans('common.item'),
            'breadcrumbs' => array(
                'admin/home'                       => trans('common.dashboard'),
                'admin/item/all'                   => trans('common.items'),
                'admin/item/'.$item_id.'/update'   => $item->title,
                '!'                                => trans('common.update')
            ),
                'item_id'               => $item_id,
                'item'                  => $item,
                'categories'            => $website_item_category_model->all(),
                'tags'                  => $website_item_tag_model->all(),
                'item_tags_id'          => $item_tags_model->get_tags_by_item_id($item_id)

        );


        return View::make('CoreApp/Website/Views/Backend/Item/update',$data);

    }//update


    public function file($item_id)
    {
        //Path to item file
        $path = 'item_files/'.$item_id.'/';

        //Filter array to remove . and ..
        $file = array_filter(scandir($path), function($item) use ($item_id) {

            return !is_dir("item_files/".$item_id.'/'.$item);
        });


        $obj['name'] = $file[2]; //get the filename in array
        $obj['size'] = filesize("item_files/".$item_id.'/'.$file[2]); //get the flesize in array
        $result[] = $obj; // copy it to another array
        

       header('Content-Type: application/json');
       echo json_encode($result); // now you have a json response which you can use in client side 

    }//get item file


    public function process_update($item_id)
    {

        $inputs = array(
                        
                        'meta_description'      => Input::get('meta_description'),
                        'meta_keywords'         => Input::get('meta_keywords'),
                        'item_url'              => Input::get('item_url'),
                        'categories'            => (int)Input::get('categories'),
                        'tags'                  => Input::get('tags'),
                        'title'                 => Input::get('title'),
                        'description'           => Input::get('description'),
                        'author-name'           => Input::get('author-name'),
                        'author-link'           => Input::get('author-link'),
                        'format'                => Input::get('format'),
                        'smart-objects'         => Input::get('smart-objects'),
                        'dimensions'            => Input::get('dimensions'),
                        'photoshop-version'     => Input::get('photoshop-version'),
                        'file-size'             => Input::get('file-size'),
                        'link'                  => Input::get('link'),
                        'main_item_image'       => Input::file('main_item_image'),
                        'item_image'            => Input::file('item_image'),
                        'featured'              => (int)Input::get('featured',1)              
        );

        /*
        * Validate customer
        */
        $validator = new \CoreApp\Website\Validations\Item(array(
                                                                        'meta_description'     => $inputs['meta_description'],
                                                                        'meta_keywords'        => $inputs['meta_keywords'],
                                                                        'item_url'             => $inputs['item_url'],
                                                                        'categories'           => $inputs['categories'],
                                                                        'tags'                 => $inputs['tags'],
                                                                        'title'                => $inputs['title'],
                                                                        'description'          => $inputs['description'],
                                                                        'author-name'          => $inputs['author-name'],
                                                                        'author-link'          => $inputs['author-link'],
                                                                        'format'               => $inputs['format'],
                                                                        'smart-objects'        => $inputs['smart-objects'],
                                                                        'dimensions'           => $inputs['dimensions'],
                                                                        'photoshop-version'    => $inputs['photoshop-version'],
                                                                        'file-size'            => $inputs['file-size'],
                                                                        'link'                 => $inputs['link'],
                                                                        'main_item_image'      => $inputs['main_item_image'],
                                                                        'item_image'           => $inputs['item_image']

        ), 'update');


 
            
        /*
         * Check if the validation passes
         */
        if( ! $validator->passes() )
        {
             
                return Response::json(['success' => false,'error' => $validator->errors()->toArray()]);
             
        }//if validation didn't pass
        

        $item_model = App::make('WebsiteItemsModel');


        $item_tags_model = App::make('WebsiteItemTagsModel'); 


        //Try to make the transaction
        try{

            DB::transaction(function() use($item_id,$item_model,$item_tags_model,$inputs)
            {
         

                //GET item image name from database
                $item = $item_model->get_item_by_id($item_id)[0];

                //If Main item image isset
                if(isset($inputs['main_item_image'])) $main_item_image_name = $inputs['main_item_image']->getClientOriginalName();

                //If item image isset
                if(isset($inputs['item_image'])) $item_image_name = $inputs['item_image']->getClientOriginalName();

                //Get Main item image name for update from input if new picture is selected else same name remains
                if( Input::file('main_item_image') )
                {
                    $item_main_image_name = $inputs['main_item_image']->getClientOriginalName();

                }//if new picture is selected
                else
                {

                    $item_main_image_name = $item->main_item_image_name;

                }//else same picture extension remains


                //Get item image extension for update from input if new picture is selected else same name remains
                if( Input::file('item_image') )
                {
                    $update_item_image_name = $inputs['item_image']->getClientOriginalName();

                }//if new picture is selected
                else
                {

                    $update_item_image_name = $item->item_image_name;

                }//else same picture extension remains


                //Update movie
                $item_data = array(
                                        'category_id'           => $inputs['categories'],
                                        'meta_description'      => $inputs['meta_description'],
                                        'meta_keywords'         => $inputs['meta_keywords'],
                                        'item_url'              => $inputs['item_url'],
                                        'link'                  => $inputs['link'],
                                        'title'                 => $inputs['title'],
                                        'description'           => $inputs['description'],
                                        'author_name'           => $inputs['author-name'],
                                        'author_link'           => $inputs['author-link'],
                                        'format'                => $inputs['format'],
                                        'smart_objects'         => $inputs['smart-objects'],
                                        'dimensions'            => $inputs['dimensions'],
                                        'photoshop_version'     => $inputs['photoshop-version'],
                                        'file_size'             => $inputs['file-size'],
                                        'featured'              => $inputs['featured'],
                                        'main_item_image_name'  => $item_main_image_name,
                                        'item_image_name'       => $update_item_image_name,
                                        'date'                  => date("Y-m-d")
                                        
                );

                 $item_model->update_item($item_data,$item_id);


                 //If new main item image is added
                if( Input::file('main_item_image') )
                {
                    /*
                     * Upload images
                     */

                    if(is_dir('items_photos/'.$item_id))
                    {


                         if(is_file('items_photos/'.$item_id.'/'.$item->main_item_image_name)) {
                            unlink('items_photos/'.$item_id.'/'.$item->main_item_image_name);
                        }

                    }//if has item main picture


                        //Add main item image
                        $inputs['main_item_image']->move('items_photos/'.$item_id, '/'.$main_item_image_name);

                        Image::make('items_photos/'.$item_id.'/'.$main_item_image_name)->save('items_photos/'.$item_id.'/'.$main_item_image_name);

                }//if a new picture was added

                 //If new item image is added
                if( Input::file('item_image') )
                {
                    /*
                     * Upload images
                     */

                    if(is_dir('items_photos/'.$item_id))
                    {


                         if(is_file('items_photos/'.$item_id.'/'.$item->item_image_name)) {
                            unlink('items_photos/'.$item_id.'/'.$item->item_image_name);
                        }

                    }//if has item picture


                        //Add item image
                        $inputs['item_image']->move('items_photos/'.$item_id, '/'.$item_image_name);

                        Image::make('items_photos/'.$item_id.'/'.$item_image_name)->resize(300,224,false)->save('items_photos/'.$item_id.'/'.$item_image_name);

                }//if a new picture was added


                 //Delete tags than insert new ones
                 $item_tags_model->delete($item_id);

                //Insert batch movie tags
                $item_tags = array();

                foreach($inputs['tags'] as $t)
                {

                    $item_tags[] = array(
                                                'tag_id'              => (int)$t,
                                                'item_id'             => (int)$item_id,
                    );


                }//foreach tag

                $item_tags_model->insert_item_tags($item_tags);

              
            });//End transaction

        }//Try to make the transaction

            //Catch exception
        catch(\Exception $err){

            return Response::json('error', 400);

        }//Catch exception
    


        //Flush cache
        \Cache::flush();


        /*
         * If we got here everything went good
         */
        return Response::json(['success' => true]);


    }//process update

}//end item