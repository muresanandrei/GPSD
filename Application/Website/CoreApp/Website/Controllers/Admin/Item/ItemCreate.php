<?php
/**
 * User: andrei
 * Date: 2/8/14
 * Time: 9:00 PM
 */
namespace CoreApp\Website\Controllers\Admin\Item;

use \View, \App,\Input,\DB,\Image,\Response;

class ItemCreate extends \BaseControllers\Webrising {


    public function create()
    {


        //item Category Model
        $website_item_category_model = App::make('WebsiteItemCategoryModel');

        //item tag model
        $website_item_tag_model = App::make('WebsiteItemTagModel'); 


        //Get all categories 
        $categories = $website_item_category_model->all();

        //Tags
        $tags = $website_item_tag_model->all();

               
        $data = array(
            'page_title'  => trans('common.item'),
            'breadcrumbs' => array(
                'admin/home'        => trans('common.dashboard'),
                'admin/item/all'    => trans('common.items'),
                '!'                 => trans('common.create')
            ),
                'categories'        => $categories,
                'tags'              => $tags
        );


        return View::make('CoreApp/Website/Views/Backend/Item/create',$data);

    }//create


    public function process_create()
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
                        'featured'              => (int)Input::get('featured',1),
                        
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

        ), 'create');


 
            
        /*
         * Check if the validation passes
         */
        if( ! $validator->passes() )
        {
             
                 return \Redirect::to('admin/item/create')->withErrors($validator->errors())->withInput();
             
        }//if validation didn't pass
        

        $item_model = App::make('WebsiteItemsModel');


        $item_tags_model = App::make('WebsiteItemTagsModel'); 


        //Try to make the transaction
        try{

            DB::transaction(function() use($item_model,$item_tags_model,$inputs)
            {

                //Images name

                //Main item image name
                $main_image_name = $inputs['main_item_image']->getClientOriginalName();

                //Item image name
                $item_image_name = $inputs['item_image']->getClientOriginalName();

                //Item data to insert
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
                                        'main_item_image_name'  => $main_image_name,
                                        'item_image_name'       => $item_image_name,
                                        'date'                  => date("Y-m-d")
                                        
                );


                //GET item id
                $item_id = $item_model->insert_item_get_id($item_data);

                //Store item id for file if needed 
                \Session::flash('item_id',$item_id);



                //Insert item images
                
                //Main item image
                $inputs['main_item_image']->move('items_photos/'.$item_id, '/'.$main_image_name);

                Image::make('items_photos/'.$item_id.'/'.$main_image_name)->save('items_photos/'.$item_id.'/'.$main_image_name);

                //Item image
                $inputs['item_image']->move('items_photos/'.$item_id, '/'.$item_image_name);

                Image::make('items_photos/'.$item_id.'/'.$item_image_name)->resize(300,224,false)->save('items_photos/'.$item_id.'/'.$item_image_name);

                //Insert batch item tags
                $item_tags = array();

                foreach($inputs['tags'] as $t)
                {

                    $item_tags[] = array(
                                                'tag_id'           => (int)$t,
                                                'item_id'          => (int)$item_id,
                    );


                }//foreach tag

                $item_tags_model->insert_item_tags($item_tags);

              
            });//End transaction

        }//Try to make the transaction

            //Catch exception
        catch(\Exception $err){

            return \Redirect::to('admin/item/create')->with('db_errors', true)->withInput();

        }//Catch exception
    


        //Flush cache
        \Cache::flush();

    //If no download link is provided then redirect to create item with dropzone activated
    if(!isset($inputs['link']) || trim($inputs['link']) == '')
    {
    
        
        return \Redirect::to('admin/item/create')->with('item_success',true);

    }//if link is empty
    else {

        return \Redirect::to('admin/item/all');

    }//else return to all items


    }//process create

    public function add_file($item_id)
    {

        //First we need to create the directory if it doesn't exists
        if (!file_exists($_SERVER['DOCUMENT_ROOT'].'/gpsd/public/item_files/'.$item_id)) {

            mkdir($_SERVER['DOCUMENT_ROOT'].'/gpsd/public/item_files/'.$item_id, 0777, true);

        }//if folder doesn't exists
       
        $upload_dir = $_SERVER['DOCUMENT_ROOT'].'/gpsd/public/item_files/'.$item_id;

        if (!empty($_FILES)) {

         $tempFile = $_FILES['item-file']['tmp_name'];

         // using DIRECTORY_SEPARATOR constant is a good practice, it makes your code portable.

         $targetPath = $upload_dir;

         // Adding timestamp with image's name so that files with same name can be uploaded easily.

         $mainFile = $targetPath.'/'.$_FILES['item-file']['name'];

         move_uploaded_file($tempFile,$mainFile);

            return Response::json(['success' => true ]);
        }//return sucess 
        else {
            return Response::json('error', 400);
        }//else return error
    

    }//add_file

}//end item