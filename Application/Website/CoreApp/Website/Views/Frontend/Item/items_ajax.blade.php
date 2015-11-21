@foreach($items as $i)

        <!-- Start item -->
          <div class="col-xs-6 col-md-4-s scroll">
       
                <figure>
                    <a href="{{  Request::root() }}/{{ $i->item_url }}/{{ $i->id }}" class="item-hover" id="{{ $i->id }}" onmouseover="hover_item_info({{ $i->id }})" onmouseout="unhover_item_info({{ $i->id }})">

                    <!-- Item like and downloads info -->
                      <div class="hide" id="item-info{{$i->id}}">
                        
                          <span class="glyphicon glyphicon-heart red"> {{ $i->likes }}</span>&nbsp;
                          <span class="glyphicon glyphicon-cloud-download green"> {{ $i->downloads }}</span>
                        
                      </div>   

                        <img src="{{ Request::root() }}/items_photos/{{ $i->id }}/{{ $i->item_image_name }}" 
                             class="img-rounded-top" alt="{{ $i->item_image_name }}" />         
                      </a> 

                     <!--Item content  -->
                    <div class="content-info">
                      
                        <a href="{{  Request::root() }}/{{ $i->item_url }}/{{ $i->id }}"><h4>{{ $i->title }}</h4></a>
                         <span>{{ $date_format->format_date_month_day_year($i->date) }}</span>
                        <p>{{ $i->description }}</p>
                    </div>
                </figure>
          </div>
        <!-- End item -->
@endforeach