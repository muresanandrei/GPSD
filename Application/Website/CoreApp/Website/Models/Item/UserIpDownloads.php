<?php
/**
 * Created by PhpStorm.
 * User: Andrei
 * Date: 2/21/14
 * Time: 11:23 AM
 */
namespace CoreApp\Website\Models\Item;

use \DB;

class UserIpDownloads {

    protected $table = 'user_ip_downloads';


    public function insert_ip($ip,$user_agent,$item_id)
    {

        return DB::table($this->table)
                 ->insert(array(
                                    'ip'            => $ip,
                                    'user_agent'    => $user_agent,
                                    'item_id'       => $item_id,
                                    'date'          => date("Y/m/d H:i:s")
            ));

    }//insert_ip

    public function get_ip_by_item_id($item_id)
    {

        return DB::table($this->table)
                 ->where('item_id','=',$item_id)
                 ->take(1)
                 ->get();

    }//get_ip_by_item_id

}//end UserIpDownloads