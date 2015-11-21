<?php

/**
 * User: andrei
 * Date: 08/11/14
 * Time: 18:07 AM
 */
namespace CoreApp\Website\Controllers\Frontend;

use \View,\App;

class Home extends \Controller {


    public function index()
    {

		//Get meta
		$meta_pages_model = App::make('WebsiteMetaPagesModel');

        //Get categories
        $category_model = App::make('WebsiteItemCategoryModel');

        $categories = $category_model->all();

        //Get items
        $items_model = App::make('WebsiteItemsModel');

        //Items array
        $items = $items_model->get_all_items_by_take(12);

		$meta = $meta_pages_model->get_meta_by_id(1)[0];

        //Format date 
        $date_format_object = new \SystemTools\Tools;


    	$data = array(

    					'meta_description' 	      => $meta->meta_description,
    					'meta_keywords'		      => $meta->meta_keywords,
                        'meta_title'              => $meta->page_name,
                        'current_page'            => 'home',
                        'categories'              => $categories,
                        'items'                   => $items,
                        'date_format'             => $date_format_object,
                        'total_items'             => $items_model->count_items()

    				 );

        return View::make('CoreApp/Website/Views/Frontend/home',$data);

    }//index

    public function item_data()
    {

         //Get items
        $items_model = App::make('WebsiteItemsModel');

         //Format date 
        $date_format_object = new \SystemTools\Tools;

         //Load more items on scroll
        if(\Request::ajax())
        {       

                //Take more items
                $requested_page = $_POST['page_num'];

                $offset = (($requested_page - 1) * 12) . ",12";

                $items = $items_model->get_all_items_by_take_offset(12,$offset);

                $data['items'] = $items;

                $data['date_format'] = $date_format_object;

                $html = View::make('CoreApp/Website/Views/Frontend/Item/items_ajax', $data)->render();

                echo $html;exit;

        }//if request ajax   

    }//item data

}//end Home