@extends('Templates.Backend.main')

@section('content')

<!-- Validation errors -->
<div class="alert alert-danger info" style="display:none;">
    <ul></ul>

</div>


<!-- On success -->
<div class="alert alert-success success_message" style="display:none;">
       Item has been updated succesfully!
</div>


<!-- Db errors -->
<div class="alert alert-danger db_error" style="display:none">
   <ul></ul>
</div>

<!-- Dropzone -->
<div class="alert alert-success info_file" style="display:none;">
    File was uploaded succesfully
</div>

<div class="alert alert-success file_deleted" style="display:none;">
    File was deleted successfully
</div>

{{ Form::open(array('admin/item/'.$item_id.'/update', 'POST', 'class' => 'form-horizontal','id' => 'ajaxform' ,'files' => true)) }}
 
 <!--Meta  -->
<div class="form-group">
  <label class="col-lg-2 control-label"></label>
    <div class="col-lg-10">

 <div class="panel-group" id="accordion">
  <div class="panel panel-default">
    <div class="panel-heading">
      <h4 class="panel-title">
        <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
          <h4>Meta & Item url</h4>
        </a>
      </h4>
    </div>
        <div id="collapseOne" class="panel-collapse collapse">
          <div class="panel-body">
                <div class="form-group">
          <label class="col-lg-2 control-label">Meta Description</label>
            <div class="col-lg-10">
                <textarea class="form-control"  name="meta_description" rows="3" maxlength="200">{{ $item->meta_description }}</textarea>
            </div>
        </div>

        <div class="form-group">
          <label class="col-lg-2 control-label">Meta Keywords</label>
            <div class="col-lg-10">
                <textarea class="form-control" name="meta_keywords" rows="3" maxlength="200">{{ $item->meta_keywords }}</textarea>
            </div>
        </div>

        <div class="form-group">
         <label class="col-lg-2 control-label">Movie url</label>
            <div class="col-lg-10">
                <input type="text" class="form-control" name="item_url" value="{{ $item->item_url }}" maxlength="500" placeholder="Movie url" />
            </div>
    </div>

      </div>
    </div>
  </div>
  
</div>

</div>
  
</div>
<!-- End meta section -->

    <br />

    <div class="form-group">
        <label class="col-lg-2 control-label">Select Item Category</label>
        <div class="col-lg-10">
            <select class="form-control" name="categories">

                @foreach($categories as $c)

                  <option value="{{ $c->id }}" <?php if($c->id == $item->category_id) echo 'selected="selected"' ?> >{{ $c->name }}</option>

                @endforeach

            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-lg-2 control-label">Select Item Tags</label>
        <div class="col-lg-10">
            <select multiple class="form-control select-tag" name="tags[]" data-placeholder='Select tag'>

                @foreach($tags as $t)

                    <option value="{{ $t->id }}" <?php if(in_array($t->id, $item_tags_id, true)) echo 'selected="selected"' ?> >{{ $t->name }}</option>

                @endforeach

            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-lg-2 control-label">Item Title</label>
        <div class="col-lg-10">
            <input type="text" class="form-control" name="title" maxlength="150" value="{{ $item->title }}" placeholder="Title" />
        </div>
    </div>


    <div class="form-group">
        <label class="col-lg-2 control-label">Item Description</label>
        <div class="col-lg-10">
            <input type="text" class="form-control" name="description" maxlength="500" value="{{ $item->description }}" placeholder="Description" />
        </div>
    </div>

    <div class="form-group">
        <label class="col-lg-2 control-label">Author Name</label>
        <div class="col-lg-10">
            <input type="text" class="form-control" name="author-name" maxlength="250" value="{{ $item->author_name }}"  placeholder="Author Name" />
        </div>
    </div>


    <div class="form-group">
        <label class="col-lg-2 control-label">Author Link</label>
        <div class="col-lg-10">
            <input type="text" class="form-control" name="author-link" maxlength="250" value="{{ $item->author_link }}" placeholder="Author Link" />
        </div>
    </div>


    <div class="form-group">
        <label class="col-lg-2 control-label">Format</label>
        <div class="col-lg-10">
            <input type="text" class="form-control" name="format" maxlength="300" value="{{ $item->format }}" placeholder="Format" />
        </div>
    </div>

    <div class="form-group">
        <label class="col-lg-2 control-label">Smart Objects</label>
        <div class="col-lg-10">
            <input type="text" class="form-control" name="smart-objects" maxlength="300" value="{{ $item->smart_objects }}" placeholder="Smart Objects" />
        </div>
    </div>

    <div class="form-group">
        <label class="col-lg-2 control-label">Dimensions</label>
        <div class="col-lg-10">
            <input type="text" class="form-control" name="dimensions" maxlength="300" value="{{ $item->dimensions }}" placeholder="Dimensions" />
        </div>
    </div>

    <div class="form-group">
        <label class="col-lg-2 control-label">Photoshop Version</label>
        <div class="col-lg-10">
            <input type="text" class="form-control" name="photoshop-version" maxlength="300" value="{{ $item->photoshop_version }}" placeholder="Photoshop Version" />
        </div>
    </div>

    <div class="form-group">
        <label class="col-lg-2 control-label">File Size</label>
        <div class="col-lg-10">
            <input type="text" class="form-control" name="file-size" maxlength="300" value="{{ $item->file_size }}" placeholder="File Size" />
        </div>
    </div>
    
   @if(!trim($item->link) == '') 
    <div class="form-group">
        <label class="col-lg-2 control-label">Download Link</label>
        <div class="col-lg-10">
            <input type="text" class="form-control" name="link" maxlength="500" value="{{ $item->link }}" placeholder="Link" />
        </div>
    </div>

    @endif

     <div class="form-group">
        <label class="col-lg-2 control-label">Main item image</label>
        <div class="col-lg-10">
            {{ Form::file('main_item_image') }}

          <br />
          <img src="{{ Request::root() }}/items_photos/{{$item_id}}/{{ $item->main_item_image_name }}" alt="{{ $item->main_item_image_name }}" width="300" height="250" />
    
        </div>
    </div>

    <div class="form-group">
        <label class="col-lg-2 control-label">Item image</label>
        <div class="col-lg-10">
            {{ Form::file('item_image') }}

            <br />
           <img src="{{ Request::root() }}/items_photos/{{$item_id}}/{{ $item->item_image_name }}" alt="{{ $item->item_image_name }}" width="300" height="250" />
        </div>
    </div>

    <div class="form-group">

      <label class="col-lg-2 control-label">Featured</label>
      <div class="col-lg-10">
        <label class="checkbox-inline">
          <input type="checkbox" id="inlineCheckbox1" name="featured" value="2" <?php if($item->featured == 2) echo 'checked="checked"' ?> /> 
          Yes

        </div>

    </div>


    @if(trim($item->link == ''))

        <div class="form-group">
            <label class="col-lg-2 control-label" style="margin-left:107px;margin-top:15px;">Item file</label>
            <div class="dropzone" id="my-awesome-dropzone" style="width:84%;left:10%;margin-top:74px;">
            
                {{ Form::file('item-file', ['style' => 'display:none']) }}

            </div>
        </div>

    @endif



<!--Div so button stays down-->
<div style="height:70px;"></div>

<button type="submit" id="submit" class="btn btn-primary">Update item</button>

</form>

@stop

@section('footer_javascript')

@parent

{{ HTML::script('assets/chosen/chosen.jquery.min.js') }}

{{ HTML::script('assets/admin_theme_js/drop-zone.js') }}

<script type="text/javascript">

        $(".select-tag").chosen();

        var item_id = {{ $item_id }};

        //Form
        $('form').submit(function(e) {

            e.preventDefault();

            $.ajax({
                url: webrising.base_url+"/admin/item/{{ $item_id }}/update",
                method: 'post',
                processData:false,
                contentType: false,
                cache: false,
                dataType: 'json',
                data: new FormData(this),
                beforeSend: function() { 

                    $('.info').hide().find('ul').empty(); 

                    $('.success_message').hide().find('ul').empty();

                    $('.db_error').hide().find('ul').empty();
                },
                success:function(data){

                    if(!data.success) {
                            
                        $.each(data.error,function(index, val) {
                                
                                $('.info').find('ul').append('<li>'+val+'</li>');

                        });

                        scrollTo(0,0);
                        $('.info').slideDown();

                    }else {
                        scrollTo(0,0);
                        $('.success_message').slideDown();
                      
                    }
                    
                },
                error:function(){
                                    //db error
                                    $('.db_error').append('<li>Something went wrong, please try again!</li>');
                                    scrollTo(0,0);
                                    $('.db_error').slideDown();
                                //Hide error message after 5 seconds
                                setTimeout(function(){$(".db_error").hide();},5000);
  
                }
            });
             return false;
        });

        //Dropzone
         Dropzone.options.myAwesomeDropzone = {
            paramName: "item-file",
            url: webrising.base_url+"/item_dropzone/"+item_id,
            addRemoveLinks: true,
            maxFiles: 1,
            maxFilesize:50,
            uploadMultiple: false,
            parallelUploads: 10,
            autoProcessQueue:true,
            success: function() {
                    $('.success_message').hide();
                    $('.file_deleted').hide();
                    $('.info_file').slideDown();
            },//success
            removedfile: function(file) {
                var name = file.name;
                $.ajax({
                    type: 'POST',
                    url: webrising.base_url+'/item_dropzone/delete/' +item_id,
                    data: "id="+name,
                    dataType: 'html'
                });
                $('.info_file').hide();
                $('.file_deleted').slideDown();
            var _ref;

            return (_ref = file.previewElement) != null ? _ref.parentNode.removeChild(file.previewElement) : void 0;
            
            },//remove file
            init: function() {

            var thisDropzone = this;

            $.getJSON(webrising.base_url+'/admin/item/'+item_id+'/file', function(data) { // get the json response

            $.each(data, function(key,value){ //loop through it

                var mockFile = { name: value.name, size: value.size }; // here we get the file name and size as response 

                thisDropzone.options.addedfile.call(thisDropzone, mockFile);

                thisDropzone.options.thumbnail.call(thisDropzone, mockFile, webrising.base_url+"/item_files/"+item_id+'/'+value.name);//item files is the folder where you have all those uploaded files

            });

        });

    }//get file

};
    
</script>

@stop