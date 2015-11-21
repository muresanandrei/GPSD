<?php
/**
 * User: andrei
 * Date: 1/25/14
 * Time: 12:26 AM
 */


/*
 * Website frontend routes
 */

//Change language
Route::get('lang/{lang}',function($lang)
{
	$l = new \SystemTools\WebsiteLanguage();

	$l->set_language($lang);

	return Redirect::back();

});

//Home
Route::get('home', 'CoreApp\Website\Controllers\Frontend\Home@index');

//Default
Route::get('/','CoreApp\Website\Controllers\Frontend\Home@index');


/*
 * Item Routes
 */
//Items
Route::get('{item_url}/{item_id}','CoreApp\Website\Controllers\Frontend\Item@single_item');

Route::post('item-data','CoreApp\Website\Controllers\Frontend\Home@item_data');


// Item category
Route::get('category/{cat_url}/{cat_id}','CoreApp\Website\Controllers\Frontend\Item@items_by_category_id');
Route::post('item-data-category/{cat_id}','CoreApp\Website\Controllers\Frontend\Item@item_data_category');

// Item tag
Route::get('tag/{tag_url}/{tag_id}','CoreApp\Website\Controllers\Frontend\Item@items_by_tag_id');
Route::post('item-data-tag/{tag_id}','CoreApp\Website\Controllers\Frontend\Item@item_data_tag');

// Item search
Route::get('search','CoreApp\Website\Controllers\Frontend\Item@search');
Route::post('item-data-search','CoreApp\Website\Controllers\Frontend\Item@item_data_search');

//Download item
Route::get('download/item/{item_id}','CoreApp\Website\Controllers\Frontend\Item@download');

//Like item
Route::post('item/{item_id}/like','CoreApp\Website\Controllers\Frontend\Item@like');

/*
 * Admin Routes
 */

//Item
Route::get('admin/item/create','CoreApp\Website\Controllers\Admin\Item\ItemCreate@create');
Route::post('admin/item/create','CoreApp\Website\Controllers\Admin\Item\ItemCreate@process_create');

Route::get('admin/item/{item_id}/update','CoreApp\Website\Controllers\Admin\Item\ItemUpdate@update');
Route::post('admin/item/{item_id}/update','CoreApp\Website\Controllers\Admin\Item\ItemUpdate@process_update');

Route::get('admin/item/{item_id}/file','CoreApp\Website\Controllers\Admin\Item\ItemUpdate@file');

Route::get('admin/item/all','CoreApp\Website\Controllers\Admin\Item\ItemAll@all');

Route::get('admin/item/{item_id}/delete','CoreApp\Website\Controllers\Admin\Item\ItemDelete@delete');


//Item dropzone
Route::post('item_dropzone/{item_id}','CoreApp\Website\Controllers\Admin\Item\ItemCreate@add_file');

//Delete item dropzone files
Route::post('item_dropzone/delete/{item_id}','CoreApp\Website\Controllers\Admin\Item\ItemDropzoneDelete@item_file');


//Meta
Route::get('admin/meta_pages/all','CoreApp\Website\Controllers\Admin\MetaPages@all');

Route::get('admin/meta_page/{page_id}/update','CoreApp\Website\Controllers\Admin\MetaPages@update');

Route::post('admin/meta_page/{page_id}/update','CoreApp\Website\Controllers\Admin\MetaPages@process_update');