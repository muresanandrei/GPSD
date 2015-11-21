<?php
/**
 * Created by PhpStorm.
 * User: Andrei
 * Date: 2/21/14
 * Time: 11:23 AM
 */
namespace CoreApp\Website\Models\Item;

use \DB;

class Items {

    protected $table = 'items';


     public function get_all_items()
     {
        return DB::table($this->table)
                  ->join('categories as c','c.id','=',"{$this->table}.category_id")
                  ->orderBy("{$this->table}.date", 'desc')
                  ->remember(120)
                  ->get(array(
                                "{$this->table}.id",
                                'c.name as category_name',
                                'title',
                                'featured',
                                'date'
                    ));

    }//get_all_items


    public function get_all_items_by_take($take)
    {
        return  DB::table($this->table)
                  ->orderBy("{$this->table}.id",'asc')
                  ->take($take)
                  ->get(array(
                                     "{$this->table}.id",
                                     "{$this->table}.item_url",
                                     "{$this->table}.title",
                                     "{$this->table}.description",
                                     "{$this->table}.item_image_name",
                                     "{$this->table}.downloads",
                                     "{$this->table}.likes",
                                     "{$this->table}.date"
                  ));
 
    }//get_all_items_by_take

    public function get_all_items_by_take_offset($take,$offset)
    {
        return  DB::table($this->table)
                  ->orderBy("{$this->table}.id",'asc')
                  ->take($take)
                  ->skip($offset)
                  ->get(array(
                                     "{$this->table}.id",
                                     "{$this->table}.item_url",
                                     "{$this->table}.title",
                                     "{$this->table}.description",
                                     "{$this->table}.item_image_name",
                                     "{$this->table}.downloads",
                                     "{$this->table}.likes",
                                     "{$this->table}.date"
                  ));
 
    }//get_all_items_by_take_offset

    public function count_items()
    {
          return DB::table($this->table)
                   ->count();
    }//count items


    public function insert_item_get_id($data)
    {

        return DB::table($this->table)
                 ->insertGetId($data);

    }//insert_item_get_id

    public function check_id_exists($item_id)
    {

        return DB::table($this->table)
                 ->where('id','=',$item_id)
                 ->take(1)
                 ->pluck('id');

    }//check_id_exists


    public function get_item_by_id($item_id)
    {

        return DB::table($this->table)
                 ->where('id','=',$item_id)
                 ->get();

    }//get_item_by_id

    public function update_item($data,$id)
    {

        return DB::table($this->table)
                 ->where('id','=',$id)
                 ->update($data);

    }//update item


    public function delete($id)
    { 

        return DB::table($this->table)
                 ->where('id','=',$id)
                 ->delete();

     }//delete

     public function get_item_tags_by_item_id($item_id)
     {
         $tags_obj = DB::table($this->table)
                   ->join('item_tags as it','it.item_id','=',"{$this->table}.id")
                   ->join('tags as t','t.id','=','it.tag_id')
                   ->where("it.item_id",'=',$item_id)
                   ->get(array(
                                  "t.id",
                                  "t.name",
                                  "t.tag_url"
                    ));

         $tags = array();
                   
         foreach($tags_obj as $t)
         {
            $tags[] = $t;

         }//foreach tags

         return $tags;

     }//get_item_tags_by_item_id


    public function get_single_item_by_id($item_id)
    {
       return DB::table($this->table)
                ->join('categories as c','c.id','=',"{$this->table}.category_id")
                ->join('item_tags as it','it.item_id','=',"{$this->table}.id")
                ->join('tags as t','t.id','=','it.tag_id')
                ->where("{$this->table}.id",'=',$item_id)
                ->take(1)
                ->get();
                
    }//get_single_item_by_id


    public function increment_downloads_by_item_id($item_id)
    {
           return DB::table($this->table)
                    ->where('id','=',$item_id)
                    ->increment('downloads');

    }//increment_comments_by_item_id


    public function increment_likes_by_item_id($item_id)
    {
        return DB::table($this->table)
                  ->where('id','=',$item_id)
                  ->increment('likes');

    }//increment_likes_by_item_id

    public function get_likes_by_item_id($item_id)
    {

        return DB::table($this->table)
                 ->where('id','=',$item_id)
                 ->take(1)
                 ->pluck('likes');

    }//get_likes_by_item_id


    public function get_latest_5_items()
    {
        return DB::table($this->table)
                 ->orderBy("date",'desc')
                 ->take(5)
                 ->get(array(
                              'id',
                              'item_url',
                              'title',
                              'item_image_name',
                              'date'
                  ));

    }//get_latest_5_items

    public function get_popular_5_items()
    {
        return DB::table($this->table)
                 ->orderBy("downloads",'desc')
                 ->take(5)
                 ->get(array(
                              'id',
                              'item_url',
                              'title',
                              'item_image_name',
                              'downloads'
                  ));

    }//get_popular_5_items


    public function get_most_liked_5_items()
    {
        return DB::table($this->table)
                 ->orderBy("likes",'desc')
                 ->take(5)
                 ->get(array(
                              'id',
                              'item_url',
                              'title',
                              'item_image_name',
                              'likes'
                  ));

    }//get_most_liked_5_items


    public function get_next_item_id($item_id)
    {

        return DB::table($this->table)
                 ->where('id','>',$item_id)
                 ->min('id');

    }//get_next_item_id

    public function get_previous_item_id($item_id)
    { 

          return DB::table($this->table)
                 ->where('id','<',$item_id)
                 ->max('id');

    }//get_previous_item_id

     public function get_next_item_url($next_id)
     {

        return DB::table($this->table)
                 ->where('id','=',$next_id)
                 ->take(1)
                 ->pluck('item_url');

     }//get_next_item_url

    public function get_previous_item_url($previous_id)
    { 

          return DB::table($this->table)
                   ->where('id','=',$previous_id)
                   ->take(1)
                   ->pluck('item_url');

    }//get_previous_item_url    

//Items by category
    public function get_all_items_by_category_id_by_take($category_id,$take)
    {

        return  DB::table($this->table)
                  ->join('categories as c','c.id','=',"{$this->table}.category_id")
                  ->where("c.id",'=',$category_id)
                  ->orderBy("{$this->table}.id",'asc')
                  ->take($take)
                  ->get(array(
                                   "{$this->table}.id",
                                   "{$this->table}.item_url",
                                   "{$this->table}.title",
                                   "{$this->table}.description",
                                   "{$this->table}.item_image_name",
                                   "{$this->table}.downloads",
                                   "{$this->table}.likes",
                                   "{$this->table}.date"
                ));

    }//get_all_items_by_category_id_by_take

    public function get_all_items_by_category_id_take_offset($category_id,$take,$offset)
    {
        return  DB::table($this->table)
                  ->join('categories as c','c.id','=',"{$this->table}.category_id")
                  ->where("c.id",'=',$category_id)
                  ->orderBy("{$this->table}.id",'asc')
                  ->take($take)
                  ->skip($offset)
                  ->get(array(
                                     "{$this->table}.id",
                                     "{$this->table}.item_url",
                                     "{$this->table}.title",
                                     "{$this->table}.description",
                                     "{$this->table}.item_image_name",
                                     "{$this->table}.downloads",
                                     "{$this->table}.likes",
                                     "{$this->table}.date"
                  ));
 
    }//get_all_items_by_category_id_take_offset

    public function count_items_by_category_id($category_id)
    {
          return DB::table($this->table)
                   ->join('categories as c','c.id','=',"{$this->table}.category_id")
                   ->where("c.id",'=',$category_id)
                   ->count();

    }//count_items_by_category_id

//End items by category


    //Items by Tag
    public function get_all_items_by_tag_id_by_take($tag_id,$take)
    {

      return    DB::table($this->table)
                  ->join('item_tags as it','it.item_id','=',"{$this->table}.id")
                  ->join('tags as t','t.id','=','it.tag_id')
                  ->where("t.id",'=',$tag_id)
                  ->orderBy("{$this->table}.id",'asc')
                  ->take($take)
                  ->get(array(
                                   "{$this->table}.id",
                                   "{$this->table}.item_url",
                                   "{$this->table}.title",
                                   "{$this->table}.description",
                                   "{$this->table}.item_image_name",
                                   "{$this->table}.downloads",
                                   "{$this->table}.likes",
                                   "{$this->table}.date"
                ));

    }//get_all_items_by_tag_id_by_take

    public function get_all_items_by_tag_id_take_offset($tag_id,$take,$offset)
    {
        return  DB::table($this->table)
                  ->join('item_tags as it','it.item_id','=',"{$this->table}.id")
                  ->join('tags as t','t.id','=','it.tag_id')
                  ->where("t.id",'=',$tag_id)
                  ->orderBy("{$this->table}.id",'asc')
                  ->take($take)
                  ->skip($offset)
                  ->get(array(
                                     "{$this->table}.id",
                                     "{$this->table}.item_url",
                                     "{$this->table}.title",
                                     "{$this->table}.description",
                                     "{$this->table}.item_image_name",
                                     "{$this->table}.downloads",
                                     "{$this->table}.likes",
                                     "{$this->table}.date"
                  ));
 
    }//get_all_items_by_tag_id_take_offset

    public function count_items_by_tag_id($tag_id)
    {
          return DB::table($this->table)
                   ->join('item_tags as it','it.item_id','=',"{$this->table}.id")
                   ->join('tags as t','t.id','=','it.tag_id')
                   ->where("t.id",'=',$tag_id)
                   ->count();

    }//count_items_by_tag_id

    //End items by tag


    public function search_and_take($search,$take)
    {

        $query = DB::table($this->table)
                   ->join('categories as c','c.id','=',"{$this->table}.category_id")
                   ->join('item_tags as it','it.item_id','=',"{$this->table}.id")
                   ->join('tags as t','t.id','=','it.tag_id')
                   ->orderBy("{$this->table}.id", 'asc');


        if( $search != '' )
        {

            $query->where( function($query) use ($search)
            {

                $query->where("{$this->table}.title", 'LIKE', "%{$search}%");
                $query->OrWhere("{$this->table}.author_name",'LIKE', "%{$search}%");
                $query->OrWhere("{$this->table}.photoshop_version",'LIKE', "%{$search}%");
                $query->OrWhere('c.name', 'LIKE', "%{$search}%");
                $query->OrWhere('t.name', 'LIKE', "%{$search}%");

            });//
           
       
              return $query->take($take)->get(array(
                                                 "{$this->table}.id",
                                                 "{$this->table}.item_url",
                                                 "{$this->table}.title",
                                                 "{$this->table}.description",
                                                 "{$this->table}.item_image_name",
                                                 "{$this->table}.downloads",
                                                 "{$this->table}.likes",
                                                 "{$this->table}.date"
                                          ));

             }//if we need to search

            if($search == '')
            {

                 return  DB::table($this->table)
                           ->orderBy("{$this->table}.id",'asc')
                           ->take($take)
                           ->get(array(
                                             "{$this->table}.id",
                                             "{$this->table}.item_url",
                                             "{$this->table}.title",
                                             "{$this->table}.description",
                                             "{$this->table}.item_image_name",
                                             "{$this->table}.downloads",
                                             "{$this->table}.likes",
                                             "{$this->table}.date"
                          ));

            }//search == ''

    }//search_and_take

    public function count_items_by_search($search)
    {
        $query =  DB::table($this->table)
                    ->join('categories as c','c.id','=',"{$this->table}.category_id")
                    ->join('item_tags as it','it.item_id','=',"{$this->table}.id")
                    ->join('tags as t','t.id','=','it.tag_id');


        if( $search != '' )
        {

            $query->where( function($query) use ($search)
            {

                $query->where("{$this->table}.title", 'LIKE', "%{$search}%");
                $query->OrWhere("{$this->table}.author_name",'LIKE', "%{$search}%");
                $query->OrWhere("{$this->table}.photoshop_version",'LIKE', "%{$search}%");
                $query->OrWhere('c.name', 'LIKE', "%{$search}%");
                $query->OrWhere('t.name', 'LIKE', "%{$search}%");

            });//

           return $query->count(); 

        }//if we need to search
        if( $search == '')
        {
          return DB::table($this->table)
                   ->count();

         }//if search == ''
               

    }//count_items_by_search    


       public function get_items_by_search_take_offset($search,$take,$offset)
       {

            $query = DB::table($this->table)
                       ->join('categories as c','c.id','=',"{$this->table}.category_id")
                       ->join('item_tags as it','it.item_id','=',"{$this->table}.id")
                       ->join('tags as t','t.id','=','it.tag_id')
                       ->orderBy("{$this->table}.id", 'asc');


        if( $search != '' )
        {

            $query->where( function($query) use ($search)
            {

                $query->where("{$this->table}.title", 'LIKE', "%{$search}%");
                $query->OrWhere("{$this->table}.author_name",'LIKE', "%{$search}%");
                $query->OrWhere("{$this->table}.photoshop_version",'LIKE', "%{$search}%");
                $query->OrWhere('c.name', 'LIKE', "%{$search}%");
                $query->OrWhere('t.name', 'LIKE', "%{$search}%");

              });//


                return $query->take($take)->skip($offset)->get(array(
                                                                       "{$this->table}.id",
                                                                       "{$this->table}.item_url",
                                                                       "{$this->table}.title",
                                                                       "{$this->table}.description",
                                                                       "{$this->table}.item_image_name",
                                                                       "{$this->table}.downloads",
                                                                       "{$this->table}.likes",
                                                                       "{$this->table}.date"
                                                ));

            }//if we need to search

        if($search == '')
        {

                 return  DB::table($this->table)
                           ->orderBy("{$this->table}.id",'asc')
                           ->take($take)
                           ->skip($offset)
                           ->get(array(
                                             "{$this->table}.id",
                                             "{$this->table}.item_url",
                                             "{$this->table}.title",
                                             "{$this->table}.description",
                                             "{$this->table}.item_image_name",
                                             "{$this->table}.downloads",
                                             "{$this->table}.likes",
                                             "{$this->table}.date"
                          ));

          }//search == ''

       }//get_items_by_search_take_offset            
    

}//end Items