@extends('Templates.Backend.main')

@section('content')

@if( count($errors->all()) != 0)

    <div class="alert alert-danger">

        @foreach( $errors->all() as $e )

            {{ $e }}<br/>

        @endforeach

    </div>

@endif

@if(Session::has('db_errors'))

    <div class="alert alert-danger">
        Something went wrong, please try again!
    </div>

@endif

@if(Session::has('item_success'))

    <div class="alert alert-success item_success">
            
            Item was added succesfully!<br />
            Now you can add item file.

    </div>

@endif

<!-- Dropzone -->
<div class="alert alert-success info_file" style="display:none;">
    File was uploaded succesfully
</div>

<div class="alert alert-success file_deleted" style="display:none;">
    File was deleted successfully
</div>

{{ Form::open(array('admin/item/create', 'POST', 'class' => 'form-horizontal','files' => true)) }}

@if(!Session::has('item_success') )
 
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
                <textarea class="form-control" id="meta_description" name="meta_description" rows="3" maxlength="200">{{ Input::old('meta_description') }}</textarea>
            </div>
        </div>

        <div class="form-group">
          <label class="col-lg-2 control-label">Meta Keywords</label>
            <div class="col-lg-10">
                <textarea class="form-control" id="meta_keywords" name="meta_keywords" rows="3" maxlength="200">{{ Input::old('meta_keywords') }}</textarea>
            </div>
        </div>

        <div class="form-group">
         <label class="col-lg-2 control-label">Item url</label>
            <div class="col-lg-10">
                <input type="text" class="form-control" name="item_url" value="{{ Input::old('item_url') }}" maxlength="500" placeholder="Item url" />
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

                  <option value="{{ $c->id }}" <?php if($c->id == Input::old('categories')) echo 'selected="selected"' ?> >{{ $c->name }}</option>

                @endforeach

            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-lg-2 control-label">Select Item Tags</label>
        <div class="col-lg-10">
            <select multiple class="form-control select-tag" name="tags[]" data-placeholder='Select tag'>

                @foreach($tags as $t)

                    <option value="{{ $t->id }}" <?php if(in_array($t->id, Input::old('tags',array()), true)) echo 'selected="selected"' ?> >{{ $t->name }}</option>

                @endforeach

            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-lg-2 control-label">Item Title</label>
        <div class="col-lg-10">
            <input type="text" class="form-control" name="title" maxlength="150" value="{{ Input::old('title') }}" placeholder="Title" />
        </div>
    </div>

    <div class="form-group">
        <label class="col-lg-2 control-label">Item Description</label>
        <div class="col-lg-10">
            <input type="text" class="form-control" name="description" maxlength="500" value="{{ Input::old('description') }}" placeholder="Description" />
        </div>
    </div>

    <div class="form-group">
        <label class="col-lg-2 control-label">Author Name</label>
        <div class="col-lg-10">
            <input type="text" class="form-control" name="author-name" maxlength="250" value="{{ Input::old('author-name') }}"  placeholder="Author Name" />
        </div>
    </div>


    <div class="form-group">
        <label class="col-lg-2 control-label">Author Link</label>
        <div class="col-lg-10">
            <input type="text" class="form-control" name="author-link" maxlength="250" value="{{ Input::old('author-link') }}" placeholder="Author Link" />
        </div>
    </div>


    <div class="form-group">
        <label class="col-lg-2 control-label">Format</label>
        <div class="col-lg-10">
            <input type="text" class="form-control" name="format" maxlength="300" value="{{ Input::old('format') }}" placeholder="Format" />
        </div>
    </div>

    <div class="form-group">
        <label class="col-lg-2 control-label">Smart Objects</label>
        <div class="col-lg-10">
            <input type="text" class="form-control" name="smart-objects" maxlength="300" value="{{ Input::old('smart-objects') }}" placeholder="Smart Objects" />
        </div>
    </div>

    <div class="form-group">
        <label class="col-lg-2 control-label">Dimensions</label>
        <div class="col-lg-10">
            <input type="text" class="form-control" name="dimensions" maxlength="300" value="{{ Input::old('dimensions') }}" placeholder="Dimensions" />
        </div>
    </div>

    <div class="form-group">
        <label class="col-lg-2 control-label">Photoshop Version</label>
        <div class="col-lg-10">
            <input type="text" class="form-control" name="photoshop-version" maxlength="300" value="{{ Input::old('photoshop-version') }}" placeholder="Photoshop Version" />
        </div>
    </div>

    <div class="form-group">
        <label class="col-lg-2 control-label">File Size</label>
        <div class="col-lg-10">
            <input type="text" class="form-control" name="file-size" maxlength="300" value="{{ Input::old('file-size') }}" placeholder="File Size" />
        </div>
    </div>
    
    <div class="form-group">
        <label class="col-lg-2 control-label">Download Link(If let empty then you can upload file via dropzone)</label>
        <div class="col-lg-10">
            <input type="text" class="form-control" name="link" maxlength="500" value="{{ Input::old('link') }}" placeholder="Link" />
        </div>
    </div>


     <div class="form-group">
        <label class="col-lg-2 control-label">Main item image</label>
        <div class="col-lg-10">
            {{ Form::file('main_item_image') }}
        </div>
    </div>

    <div class="form-group">
        <label class="col-lg-2 control-label">Item image</label>
        <div class="col-lg-10">
            {{ Form::file('item_image') }}
        </div>
    </div>

    <div class="form-group">

      <label class="col-lg-2 control-label">Featured</label>
      <div class="col-lg-10">
        <label class="checkbox-inline">
          <input type="checkbox" id="inlineCheckbox1" name="featured" value="2" <?php if(Input::old('featured') == 2) echo 'checked="checked"' ?> /> 
          Yes

        </div>

    </div>



@elseif(Session::has('item_success'))

    <div class="form-group">
        <label class="col-lg-2 control-label" style="margin-left:107px;margin-top:15px;">Item file</label>
        <div class="dropzone" id="my-awesome-dropzone" style="width:84%;left:10%;margin-top:74px;">
        
            {{ Form::file('item-file', ['style' => 'display:none']) }}

        </div>
    </div>

@endif

<!--Div so button stays down-->
<div style="height:70px;"></div>

@if(!Session::has('item_success'))
    
    <div class="form-group">
           <label class="col-lg-2 control-label"></label>
            <div class="col-lg-10">
                <button type="submit" id="submit" class="btn btn-primary">Add item</button>
        </div>
    </div>

@endif


@if(Session::has('item_success'))

    <a class="btn btn-primary" href="{{ Request::root() }}/admin/item/all">Go to all items</a>

@endif

</form>



@stop

@section('footer_javascript')

@parent

{{ HTML::script('assets/chosen/chosen.jquery.min.js') }}

{{ HTML::script('assets/admin_theme_js/drop-zone.js') }}

<script type="text/javascript">


        $(".select-tag").chosen();

        //Hide  success messages after 5 seconds
        setTimeout(function(){$(".item_success").hide();},5000);

        //Get item id
        var item_id = @if(!Session::get('item_id')){{ 0 }}@elseif(Session::get('item_id')){{ Session::get('item_id')}} @endif;
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
                    $('.item_success').hide();
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
            
            }//remove file
};
    
</script>

@stop