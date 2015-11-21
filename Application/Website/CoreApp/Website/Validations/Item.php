<?php
/**
 * User: andrei
 * Date: 14/09/14
 * Time: 18:05 AM
 */
namespace CoreApp\Website\Validations;

class Item extends \Abstracts\Validation {


    public $rules = array(

        'create' => array(

                            'meta_description'     => 'required|max:200',
                            'meta_keywords'        => 'required|max:200',
                            'item_url'             => 'required|max:500',
                            'categories'           => 'required|not_in:0',
                            'tags'                 => 'required|not_in:0',
                            'title'                => 'required|max:150',
                            'description'          => 'required|max:500',
                            'author-name'          => 'required|max:250',
                            'author-link'          => 'required|max:250',
                            'format'               => 'required|max:300',
                            'smart-objects'        => 'required|max:300',
                            'dimensions'           => 'required|max:300',
                            'photoshop-version'    => 'required|max:300',
                            'file-size'            => 'max:300',
                            'link'                 => 'max:500',
                            'main_item_image'      => 'required|mimes:jpeg,bmp,png,jpg|max:10000',
                            'item_image'           => 'required|mimes:jpeg,bmp,png,jpg|max:10000'


        ),
        'update' => array(

                            'meta_description'     => 'required|max:200',
                            'meta_keywords'        => 'required|max:200',
                            'item_url'             => 'required|max:500',
                            'categories'           => 'required|not_in:0',
                            'tags'                 => 'required|not_in:0',
                            'title'                => 'required|max:150',
                            'description'          => 'required|max:500',
                            'author-name'          => 'required|max:250',
                            'author-link'          => 'required|max:250',
                            'format'               => 'required|max:300',
                            'smart-objects'        => 'required|max:300',
                            'dimensions'           => 'required|max:300',
                            'photoshop-version'    => 'required|max:300',
                            'file-size'            => 'max:300',
                            'link'                 => 'max:500',
                            'main_item_image'      => 'mimes:jpeg,bmp,png,jpg|max:10000',
                            'item_image'           => 'mimes:jpeg,bmp,png,jpg|max:10000'

        )

    );


}//class Item