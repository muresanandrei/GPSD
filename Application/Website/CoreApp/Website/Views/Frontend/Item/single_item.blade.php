@extends('Templates.Frontend.main')

@section('header')

<!-- Start Content Holder -->
<div class= "content-holder">

      <!-- Commercial -->
      <div class="top-commercial">Advertisment</div>
    <!--End Commercial  -->


  <!-- Start item area -->
  <div class="row main-item-container">
        <!-- Top title and date -->
        <div class="title"><h1>{{ $item->title }}</h1></div>
        <p class="date"> {{ $date_format->format_date_month_day_year($item->date) }}&nbsp;&nbsp; /@foreach($item_tags as $t) <a href="{{ Request::root() }}/tag/{{ $t->tag_url }}/{{ $t->id }}">{{ $t->name }}</a>,@endforeach
        <!-- End top title and date -->


        <!-- Start item content -->
        <div class="main-item-content">

        <!-- Item image -->
          <div class="item-image">
            <img src="{{ Request::root() }}/items_photos/{{ $item_id }}/{{ $item->main_item_image_name }}" class="img-responsive" alt="{{ $item->main_item_image_name }}">
          </div>
        <!-- End item image -->


            <!-- Start item social buttons -->
              <div class="main-item-social">
                
                 <a href="https://twitter.com/gpsdco" class="twitter-follow-button" data-show-count="false">Follow @gpsdco</a>
                         <a href="https://twitter.com/share" class="twitter-share-button" data-url="http://gpsd.co" data-text="I joined the @Gpsd community. Check these design resources out! #freebie #graphicdesign" data-via="Gpsdco" data-related="Gpsdco" data-hashtags="design" data-dnt="true">Tweet</a>
                         <iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.facebook.com%2Fgpsdco&amp;width=100&amp;layout=button_count&amp;action=like&amp;show_faces=true&amp;share=true&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:125px; height:21px;" allowTransparency="true"></iframe>
                         <iframe src="http://www.facebook.com/plugins/like.php?href=http%3A%2F%2Fwww.facebook.com%2Fgpsdco&amp;width=100&amp;layout=button_count&amp;action=like&amp;show_faces=true&amp;share=true&amp;height=21" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:125px; height:21px;" allowTransparency="true"></iframe>

              </div>
            <!-- End item social buttons -->

            <!-- Start main item content -->
             <div class="main-item-info">
                <h2>Description & details </h2>
                <p>{{ $item->description }}</p>
                  <br />
                  <br />
                <div class="item-left-info">
                    <p>Author: <a target="_blank" href="{{ $item->author_link }}" class="author">{{ $item->author_name }}</a></p>
                    <p>Format: {{ $item->format }}</p>
                    <p>Smart Objects: {{ $item->smart_objects }}</p>
                    <p>Dimensions: {{ $item->dimensions }}</p>
                    <p>Minimum Photoshop Version: {{ $item->photoshop_version }}</p>
                    <p>File Size: {{ $item->file_size }}</p>
                    <br />
                    <!-- Buttons -->
                   <p><a href="{{ Request::root() }}/download/item/{{$item_id}}" class="download-button buzz">Download({{ number_format($item->downloads) }})</a></p>
                   <p><a href="#" class="like-button glow" id="like_item"><span class="glyphicon glyphicon-heart-empty"> {{ number_format($item->likes) }}</span></a></p>

                </div>
                <!-- Ad -->
                 <div class="item-right-ad">300x250 Ad</div>
                <!-- End Ad -->

             </div>
            <!-- End main item content -->

             <!-- Item right sidebar -->
                <div class="item-sidebar-wrapper">
                  <div class="item-sidebar">

                    <!-- Navigation -->
                        <div class="item-nav">
                            @if($previous_item_id != '')
                              <div class="item-prev push"><a href="{{ Request::root() }}/{{ $previous_item_url }}/{{ $previous_item_id }}">Previous</a> </div>
                            @endif  
                                <div class="item-next push"><a href="{{ Request::root() }}/{{ $next_item_url }}/{{ $next_item_id }}">Next</a> </div>
                        </div>
                    <!-- End navigation -->

                    <!-- Ad -->
                      <div class="sidebar-ad">Advertisment</div>
                    <!-- End Ad -->

                    <!-- Tabs -->
                      <div class="hash-tabs">
                        <article class="tab-container">
                          <nav class="tab-nav" role="tablist">
                              <li><a href="#tab1" title="Latest" id="0" role="tab" aria-selected="true" aria-expanded="true" aria-controls="#tab1" tab-index="0" class="active">Latest</a></li>
                              <li><a href="#tab2" title="Popular" id="1" role="tab" aria-selected="false" aria-expanded="false" aria-controls="#tab2" tab-index="-1" class="">Popular</a></li>
                              <li><a href="#tab3" title="Most Liked" id="2" role="tab" aria-selected="false" aria-expanded="false" aria-controls="#tab3" tab-index="-1" class="">Most Liked</a></li>
                            </nav>
                          <div class="tab-pane-container">
                          <section id="tab1" role="tabpanel" aria-labeledby="0" style="display: block;">
                            @foreach($latest_5_items as $li)

                              <a href="{{ Request::root() }}/{{ $li->item_url }}/{{ $li->id }}"><img src="{{ Request::root() }}/item_photos/{{ $li->id }}/{{ $li->item_image_name }}" alt="{{ $li->item_image_name }}">
                                <div class="content-inner-tab">
                                  <h4>{{ $li->title }}</h4>
                                  <span>{{ $date_format->format_date_month_day_year($li->date) }}</span>
                                </div>
                             </a>

                            <br />

                            @endforeach
                          </section>
                           <section id="tab2" role="tabpanel" aria-labeledby="1" style="display: none;">
                            @foreach($popular_5_items as $pi)

                                <a href="{{ Request::root() }}/{{ $pi->item_url }}/{{ $pi->id }}"><img src="{{ Request::root() }}/item_photos/{{ $pi->id }}/{{ $pi->item_image_name }}" alt="{{ $pi->item_image_name }}">
                                <div class="content-inner-tab">
                                  <h4>{{ $pi->title }}</h4>
                                  <span>{{ number_format($pi->downloads) }} Downloads</span>
                                </div>
                             </a>
                            <br />

                           @endforeach 
                           </section>
                            <section id="tab3" role="tabpanel" aria-labeledby="2" style="display: none;">
                            @foreach($most_liked_5_items as $mli)

                                 <a href="{{ Request::root() }}/{{ $mli->item_url }}/{{ $mli->id }}"><img src="{{ Request::root() }}/item_photos/{{ $mli->id }}/{{ $mli->item_image_name }}" alt="{{ $mli->item_image_name }}">
                                <div class="content-inner-tab">
                                  <h4>{{ $mli->title }}</h4>
                                  <span>{{ number_format($mli->likes) }} Likes</span>
                                </div>
                               </a> 
                               <br />

                            @endforeach  
                            </section>
                            </div>
                          </article>
                    </div>
                    <!-- End Tabs -->

                    <!-- Ad -->
                      <div class="sidebar-ad">Advertisment</div>
                    <!-- End Ad -->
                  </div>
              </div>
            <!-- End item right sidebar -->
        </div>
        <!-- End item content -->

  </div>
  <!-- End item area -->

    <div class="clearfix"></div>

    <!-- Comments -->
    <div id="disqus_thread"></div>

@include('Templates/Frontend/footer')
    
@stop

@section('footer_js')

@parent

<script>
jQuery(function($) {
  $(".hash-tabs").hashTabs();
});
</script>
     
<script>
        
        //Likes
        $('#like_item').click(function(e) {

            e.preventDefault();

            $.ajax({
                url: gpsd.base_url+"/item/{{ $item_id }}/like",
                method: 'POST',
                processData:false,
                contentType: false,
                cache: false,
                dataType: 'json',
                data: false,
                success:function(data){
                                  
                                if(!data.success)
                                {                
                                    //Console log error
                                    console.log(data.error);
                                   
                                }//if error
                                else
                                {

                                    $('.like-button span').empty();
                                    $('.like-button span').append(' '+data.likes);

                                }//else success
                        
                }

            });
             return false;
        });


</script>

<script>
   /* * * CONFIGURATION VARIABLES: EDIT BEFORE PASTING INTO YOUR WEBPAGE * * */
        var disqus_shortname = 'gpsdco'; // required: replace example with your forum shortname
        var disqus_identifier = 'a unique identifier for each page where Disqus is present';
        var disqus_title = 'a unique title for each page where Disqus is present';
        var disqus_url = 'a unique URL for each page where Disqus is present';

        /* * * DON'T EDIT BELOW THIS LINE * * */
        (function() {
            var dsq = document.createElement('script'); dsq.type = 'text/javascript'; dsq.async = true;
            dsq.src = '//' + disqus_shortname + '.disqus.com/embed.js';
            (document.getElementsByTagName('head')[0] || document.getElementsByTagName('body')[0]).appendChild(dsq);
        })();
</script>

@stop