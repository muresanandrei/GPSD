<?php
/**
 * User: andrei
 * Date: 1/25/14
 * Time: 12:25 AM
 */

/*
 * Meta Pages
 */
App::bind('WebsiteMetaPagesModel', 'CoreApp\Website\Models\MetaPages');

/*
 * Items
 */
App::bind('WebsiteItemsModel', 'CoreApp\Website\Models\Item\Items');


/*
 * Item categories
 */
App::bind('WebsiteItemCategoryModel','CoreApp\Website\Models\Item\ItemCategories');


/*
 * Item tag
 */
App::bind('WebsiteItemTagModel','CoreApp\Website\Models\Item\ItemTag');

 /*
 * Item tags
 */
 App::bind('WebsiteItemTagsModel','CoreApp\Website\Models\Item\ItemTags');

 /*
  * User ip for downloads
  */
 App::bind('UserIpDownloadsModel','CoreApp\Website\Models\Item\UserIpDownloads');

 /*
  * User ip for likes
  */
 App::bind('UserIpLikesModel','CoreApp\Website\Models\Item\UserIpLikes');