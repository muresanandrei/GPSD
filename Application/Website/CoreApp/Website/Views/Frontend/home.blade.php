@extends('Templates.Frontend.main')

@section('header')

 
<!-- Start Content Holder -->
<div class= "content-holder">

      <!-- Title -->
      <div class="top-title"><h1>The pixel community.<br />
        <span>Free for both personal & commercial use.</span>
        </h1>
      </div>
    <!--End title  -->

    <!-- Start items area -->
    <div class="row" id="result">
      @foreach($items as $i)

        <!-- Start item -->
          <div class="col-xs-6 col-md-4-s scroll">
       
                <figure>
                    <a href="{{  Request::root() }}/{{ $i->item_url }}/{{ $i->id }}" class="item-hover" id="{{ $i->id }}" onmouseover="hover_item_info({{ $i->id }})" onmouseout="unhover_item_info({{ $i->id }})">

                    <!-- Item like and downloads info -->
                      <div class="hide" id="item-info{{$i->id}}">
                        
                          <span class="glyphicon glyphicon-heart red"> {{ number_format($i->likes) }}</span>&nbsp;
                          <span class="glyphicon glyphicon-cloud-download green"> {{ number_format($i->downloads) }}</span>
                        
                      </div>   

                        <img src="{{ Request::root() }}/items_photos/{{ $i->id }}/{{ $i->item_image_name }}" 
                             class="img-rounded-top" alt="{{ $i->item_image_name }}" />         
                      </a> 

                     <!--Item content  -->
                    <div class="content-info">
                      
                        <a href="{{  Request::root() }}/{{ $i->item_url }}/{{ $i->id }}"><h4>{{ $i->title }}</h4></a>
                         <span>{{ $date_format->format_date_month_day_year($i->date) }}</span>
                        <p>{{ substr($i->description,0,117) }}</p>
                    </div>
                </figure>
          </div>
        <!-- End item -->
      @endforeach
      
    </div>
    <!-- End items area -->

      <div class="row">
         <!-- Scroll loading  -->
         <img id="more" src="{{ Request::root() }}/assets/images/loading.gif">

     </div>

    <div class="clearfix"></div>
    
@include('Templates/Frontend/footer')
    
@stop

@section('footer_js')

@parent

<script type="text/javascript">

// Infinite scroll

  var page = 1;

  $(window).scroll(function () {
      $('#more').hide();

      if($(window).scrollTop() + $(window).height() > $(document).height() - 200) {
          $('#more').show();
      }
      if($(window).scrollTop() + $(window).height() == $(document).height()) {

          $('#more').hide();
          page++;
          var data = {
              page_num: page
          };

          var actual_count = {{ $total_items }};

          if((page-1)* 12 > actual_count){
            console.log('You\'ve reached the end BOB');
           
          }else{
              $.ajax({
                  type: "POST",
                  url: gpsd.base_url+"/item-data",
                  data:data,
                  success: function(res) {
                      $("#result").append(res);
                      console.log(res);
                  }
              });
          }

      }

  });

  
//Display item info on hover
function hover_item_info(id)
{ 

        $('#item-info'+id).css({'position': 'absolute',
                                'top':'27px',
                                'left':'65px',
                                'padding': '6px 10px',
                                'height': '17px',
                                'line-height': '1px',
                                'font-size': '14px',
                                'color':'red',
                                'background-color':'#f2f2f2',
                                'border-radius':'6px'}).show(); 


}//hover item info

function unhover_item_info(id)
{ 

        $('#item-info'+id).hide(); 
    
}//unhover_item_info


</script>

@stop