@extends('Templates.Backend.main')

@section('content')


<!-- Item Delete Success Message -->
<div class="alert alert-success modal-alert-success" style="display:none;">
    The item has been deleted successfully
</div>
<!-- End Item Delete Success Message-->

<!-- Item Delete Error Message -->
<div class="alert alert-danger modal-alert-fail" style="display:none;">
      An error ocurred please try again
</div>
<!-- End Item Delete Error Message -->

 <div class="widget">

                <div class="widget-head">
                  <div class="pull-left">Items</div>  
                  <div class="clearfix"></div>
                </div>

                  <div class="widget-content">

                    <table id="datatable" class="table table-striped table-bordered table-hover">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Category</th>
                          <th>Title</th>
                          <th>Featured</th>
                          <th>Date</th>
                          <th>Control</th>
                        </tr>
                      </thead>
                      <tbody>

				@foreach($items as $i)

                        <tr>
                          <td>{{ $i->id }}</td>
                          <td>{{ $i->category_name }}</td>
                          <td>{{ $i->title }}</td>
                          <td>@if($i->featured == 1) No @elseif($i->featured == 2) Yes @endif</td>
                          <td>{{ $i->date }}</td>
                          <td>

                              <a href="{{ Request::root() }}/admin/item/{{ $i->id }}/update"><button class="btn btn-xs btn-default"><i class="fa fa-pencil"></i>Edit </button></a>
                              <button class="btn btn-xs btn-default" onclick="modal_confirmation('Delete item','Are you sure you want to delete this item?','{{ $i->id }}/delete')";><i class="fa fa-times"></i>Delete</button>
                              
                          </td>
                        </tr>

				 @endforeach

                      </tbody>

                    
                    </table>

                    <div class="widget-foot">

                      <div class="clearfix"></div> 

                    </div>

                  </div>

                </div>


              </div>

            </div>


@stop

@include('Templates.Modals.modal')

@section('footer_javascript')

@parent

<script src="{{ Request::root() }}/assets/admin_theme_js/jquery.dataTables.js"></script>

<script src="{{ Request::root() }}/assets/admin_theme_js/custom.js"></script>

<script type="text/javascript">

    //Datatables
		$('#datatable').dataTable({"sPaginationType": "full_numbers","iDisplayLength": 10});

    
</script>

@stop