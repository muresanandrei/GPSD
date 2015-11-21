<?php
/**
 * User: andrei
 * Date: 2/8/14
 * Time: 9:00 PM
 */
namespace CoreApp\Website\Controllers\Admin\Item;

use \View, \App,\Input;

class ItemAll extends \Controller
{

	public function all()
	{


        //GET WebsitejournalModel
        $website_item_model = App::make('WebsiteItemsModel');


        $items = $website_item_model->get_all_items();

		$data = array(
            'page_title'  => trans('common.item'),
            'breadcrumbs' => array(
                'admin/home'        => trans('common.dashboard'),
                '!'    				=> trans('common.items'),

            ),
                'items'             => $items
        );



        return View::make('CoreApp/Website/Views/Backend/Item/all',$data);

	}//all


}//end class