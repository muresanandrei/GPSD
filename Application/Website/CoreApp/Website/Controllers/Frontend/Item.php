<?php
/**
 * User: andrei
 * Date: 2/8/14
 * Time: 8:40 PM
 */
namespace CoreApp\Website\Controllers\Frontend;

use \View, \App,\Event,\Response,\Input,\Request;

class Item extends \Controller {


    public function single_item($item_url,$item_id)
    {


        //GET Website Items Model
        $website_items_model = App::make('WebsiteItemsModel');

        //Check if id exists
       if($website_items_model->check_id_exists($item_id) == false) return App::abort('404'); 

        //movie category model
        $item_category_model = App::make('WebsiteItemCategoryModel'); 

        $item = $website_items_model->get_single_item_by_id($item_id)[0];

        //Get next and previous item id
        $next_item_id = $website_items_model->get_next_item_id($item_id);

        $previous_item_id = $website_items_model->get_previous_item_id($item_id);

        //Format date 
        $date_format_object = new \SystemTools\Tools;

        $data = array(

                        'meta_description'          => $item->meta_description,
                        'meta_keywords'             => $item->meta_keywords,
                        'meta_title'                => $item->title,
                        "item_id"                   => $item_id,
                        'item'                      => $item,
                        'date_format'               => $date_format_object,
                        'categories'                => $item_category_model->all(),
                        'item_tags'                 => $website_items_model->get_item_tags_by_item_id($item_id),
                        'previous_item_id'          => $previous_item_id,
                        'previous_item_url'         => $website_items_model->get_previous_item_url($previous_item_id),
                        'next_item_id'              => $next_item_id,
                        'next_item_url'             => $website_items_model->get_next_item_url($next_item_id),
                        'latest_5_items'            => $website_items_model->get_latest_5_items(),
                        'popular_5_items'           => $website_items_model->get_popular_5_items(),
                        'most_liked_5_items'        => $website_items_model->get_most_liked_5_items()
        );
        
      
        return View::make('CoreApp/Website/Views/Frontend/Item/single_item',$data);

    }//single_movie


    public function items_by_category_id($category_url,$category_id)
    {
       
        //Get category model
        $category_model = App::make('WebsiteItemCategoryModel');

        //Check if id exists
       if($category_model->check_category_id_exists($category_id) == false) return App::abort('404'); 

        //Get items model
        $items_model = App::make('WebsiteItemsModel');
        
        $category_items = $items_model->get_all_items_by_category_id_by_take($category_id,12);

        //Category meta
        $category_meta = $category_model->get_category_by_id($category_id)[0];

        //Format date 
        $date_format_object = new \SystemTools\Tools;

        $data = array(

                        'category_id'                     => $category_id,
                        'items'                           => $category_items,
                        'date_format'                     => $date_format_object,
                        'total_items'                     => $items_model->count_items_by_category_id($category_id),
                        'meta_description'                => $category_meta->meta_description,
                        'meta_keywords'                   => $category_meta->meta_keywords,
                        'meta_title'                      => $category_meta->name,
                        'categories'                      => $category_model->all()
        );

        return View::make('CoreApp/Website/Views/Frontend/Item/items_category',$data);

    }//items_by_category_id

    public function item_data_category($category_id)
    {

         //Load more items on scroll
        if(\Request::ajax())
        {       

                //Take more items
                $requested_page = $_POST['page_num'];

                $offset = (($requested_page - 1) * 12) . ",12";

                //Get items model
                $items_model = App::make('WebsiteItemsModel');

                 //Format date 
                $date_format_object = new \SystemTools\Tools;

                $items = $items_model->get_all_items_by_category_id_take_offset($category_id,12,$offset);

                $data['items'] = $items;

                $data['date_format'] = $date_format_object;

                $html = View::make('CoreApp/Website/Views/Frontend/Item/items_ajax', $data)->render();

                echo $html;exit;

        }//if request ajax  

    }//item_data_category

    public function items_by_tag_id($tag_url,$tag_id)
    {
       
        //Get tag model
        $tag_model = App::make('WebsiteItemTagModel');

        //Check if id exists
       if($tag_model->check_tag_id_exists($tag_id) == false) return App::abort('404'); 

        //Get category model
        $category_model = App::make('WebsiteItemCategoryModel');

        //Get Items model
        $items_model = App::make('WebsiteItemsModel');

        $tag_items = $items_model->get_all_items_by_tag_id_by_take($tag_id,12);

        //Category meta
        $tag_meta = $tag_model->get_tag_by_id($tag_id)[0];

        //Format date 
        $date_format_object = new \SystemTools\Tools;

        $data = array(

                        'tag_id'                         => $tag_id,
                        'items'                          => $tag_items,
                        'date_format'                    => $date_format_object,
                        'total_items'                    => $items_model->count_items_by_tag_id($tag_id),
                        'meta_description'               => $tag_meta->meta_description,
                        'meta_keywords'                  => $tag_meta->meta_keywords,
                        'meta_title'                     => $tag_meta->name,
                        'categories'                     => $category_model->all()
        );

        return View::make('CoreApp/Website/Views/Frontend/Item/items_tag',$data);

    }//Items_by_tag_id


    public function item_data_tag($tag_id)
    {

         //Load more items on scroll
        if(\Request::ajax())
        {       

                //Take more items
                $requested_page = $_POST['page_num'];

                $offset = (($requested_page - 1) * 12) . ",12";

                //Get items model
                $items_model = App::make('WebsiteItemsModel');

                 //Format date 
                $date_format_object = new \SystemTools\Tools;

                $items = $items_model->get_all_items_by_tag_id_take_offset($tag_id,12,$offset);

                $data['items'] = $items;

                $data['date_format'] = $date_format_object;

                $html = View::make('CoreApp/Website/Views/Frontend/Item/items_ajax', $data)->render();

                echo $html;exit;

        }//if request ajax  

    }//item_data_tag

    public function search()
    {

         //GET Items Model
        $items_model = App::make('WebsiteItemsModel');

        //Get categories
        $category_model = App::make('WebsiteItemCategoryModel');

        //All categories
        $categories = $category_model->all();

        //Search
        $search = \Input::get('search');

        //Search results
        $search_result = $items_model->search_and_take($search, 12);

         //Get meta
        $meta_pages_model = App::make('WebsiteMetaPagesModel');

        $meta = $meta_pages_model->get_meta_by_id(2)[0];

        //Format date 
        $date_format_object = new \SystemTools\Tools;


        $data = array(
                        'meta_description'        => $meta->meta_description,
                        'meta_keywords'           => $meta->meta_keywords,
                        'meta_title'              => $meta->page_name,
                        'categories'              => $categories,
                        'items'                   => $search_result,
                        'date_format'             => $date_format_object,
                        'search_name'             => $search,
                        'total_items'             => $items_model->count_items_by_search($search)
        );

        return View::make('CoreApp/Website/Views/Frontend/Item/search',$data);

    }//search


    public function item_data_search()
    {

         //Load more items on scroll
        if(\Request::ajax())
        {       

                //Take more items
                $requested_page = $_POST['page_num'];

                $offset = (($requested_page - 1) * 12) . ",12";

                $search = $_POST['search'];

                //Get items model
                $items_model = App::make('WebsiteItemsModel');

                 //Format date 
                $date_format_object = new \SystemTools\Tools;

                $items = $items_model->get_items_by_search_take_offset($search,12,$offset);

                $data['items'] = $items;

                $data['date_format'] = $date_format_object;

                $html = View::make('CoreApp/Website/Views/Frontend/Item/items_ajax', $data)->render();

                echo $html;exit;

        }//if request ajax  

    }//item_data_search

    public function download($item_id)
    {

         //User ip downloads model
        $user_ip_downloads_model = App::make('UserIpDownloadsModel');

        //GET Items Model
        $items_model = App::make('WebsiteItemsModel');

        //System tools
        $system_tools = new \SystemTools\Tools;

        //get client ip
        $ip = $system_tools->get_client_ip();

        //Agent user
        $agent = $_SERVER["HTTP_USER_AGENT"];

        //add ip and increment downloads if ip doesn't exists for specified item page
        if(!$user_ip_downloads_model->get_ip_by_item_id($item_id))
        {
            $user_ip_downloads_model->insert_ip($ip,$agent,$item_id);

            $items_model->increment_downloads_by_item_id($item_id);

        }//if there isn't an ip for the specified item page

        //Get item link to check if link exists else download from server 
        $item = $items_model->get_single_item_by_id($item_id)[0];

        if(trim($item->link) == '')
        {
            //Get item file name
            //Path to item file
            $path = 'item_files/'.$item_id.'/';

            //Filter array to remove . and ..
            $file = array_filter(scandir($path), function($item) use ($item_id) {

                return !is_dir("item_files/".$item_id.'/'.$item);
            });

            $link = $_SERVER['DOCUMENT_ROOT'].'/gpsd/public/item_files/'.$item_id.'/'.$file[2];

            return Response::download($link);

        }//if item link == empty
        else
        {
            $link = $item->link;

            $link_headers = get_headers($link);

            //Headers
            header($link_headers[0]);
            header($link_headers[1]);
            header($link_headers[2]);
            header($link_headers[3]);
            header($link_headers[4]);
            header($link_headers[5]);
            header($link_headers[6]);
            header($link_headers[7]);
            header($link_headers[8]);
            
            readfile($link);

        }//else link == item database link        

    }//download

    public function like($item_id)
    {

        //Likes model
        $likes_user_ip_model = App::make('UserIpLikesModel');

         //GET Website Items Model
        $website_items_model = App::make('WebsiteItemsModel');

        //System tools
        $system_tools = new \SystemTools\Tools;

        //get client ip
        $ip = $system_tools->get_client_ip();

        $agent = $_SERVER["HTTP_USER_AGENT"];

        //add ip and increment likes if ip doesn't exists for specified item page
        if(!$likes_user_ip_model->get_ip_by_item_id($item_id))
        {
            $likes_user_ip_model->insert_ip($ip,$agent,$item_id);

            $website_items_model->increment_likes_by_item_id($item_id);

            $likes = $website_items_model->get_likes_by_item_id($item_id);

            return Response::json(['success' => true, 'likes' => $likes]);

        }//if there isn't an ip for the specified item page
        else
        {
            return Response::json(['success' => false, 'error' => '<h4>Item has been liked once</h4>']);
           
        }//else return liked already 


    }//like

}//end Item