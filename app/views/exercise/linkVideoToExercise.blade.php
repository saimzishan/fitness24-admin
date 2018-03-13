@extends('common_templates.basic_template')
@section('content')
<div class="page-content-wrapper">
    <div class="page-content">
         <?php
            if (Session::has('message')) {
                echo CommonHelper::generateHtmlAlert(Session::get('message'));
            }
            ?>
        <!-- BEGIN PAGE HEADER-->
        <div class="row">
        	<div class="col-md-12">
                <!-- BEGIN PAGE TITLE & BREADCRUMB-->
                <h3 class="page-title">
                    Videos <small>Link videos to Exercise</small>
                </h3>
                <ul class="page-breadcrumb breadcrumb">
                    <li>
                        <i class="fa fa-home"></i>
                        <a href="<?php echo route("home"); ?>">Home</a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                   
                </ul>
                <!-- END PAGE TITLE & BREADCRUMB-->
            </div>
        </div>
        <div class="row">
			<div class="col-md-12">
				<input type="hidden" name="exID" id="exID" value="{{$exID}}">
			    <label>Select Video(s)</label>
			    <table id="sample_1" class="table table-striped table-bordered table-hover">
			        <thead>
			        <tr>
			            <th class="hidden">id</th>
			            <th>Select/Un-Select</th>
			            <th>Title</th>
			            <th>Image</th>
			        </tr>
			        </thead>
			        <tbody>
			            @foreach($videos as $row)
			                <tr>
			                    <td class="hidden">
			                        {{$row->id}}
			                    </td>
			                    <td>
			                    	<?php $check = -1?>
			                    	@foreach($relatedVideoData as $val)
			                    		@if($val->id == $row->id)
			                    			<?php $check = 1;?>
			                    		@endif
			                    	@endforeach
			                    	@if($check === 1)
			                        <input type="checkbox" checked="true" class="videoCheckbox" id="{{$row->id}}">
			                        @else 
			                         <input type="checkbox" class="videoCheckbox" id="{{$row->id}}">
			                        @endif
			                    </td>
			                    <td>
			                       {{$row->title_en}}
			                    </td>
			                    <td>
			                        <img src="{{CommonHelper::$driver['s3_uploads'] . 'Images/'.$row->thumb}}" width="80"/>
			                    </td>
			                </tr>
			             @endforeach
			        </tbody>
			    </table>

			</div>
		</div>	
		<input type="button" id="SubmitForm" class="btn green" value="Save">	
	</div>
</div>

<script>
 
      $(document).ready(function () {
            var table = $('#sample_1');
            // begin first table
            table.dataTable({
                "columns": [{
                    "orderable": true
                }, {
                    "orderable": true
                }, {
                    "orderable": true
                }, {
                    "orderable": true
                }, 
                ],
                "lengthMenu": [
                    [10, 15, 20, -1],
                    [10, 15, 20, "All"] // change per page values here
                ],
                // set the initial value
                "pageLength": 10,
                "pagingType": "bootstrap_full_number",
                "language": {
                    "lengthMenu": "_MENU_ records",
                    "paginate": {
                        "previous": "Prev",
                        "next": "Next",
                        "last": "Last",
                        "first": "First"
                    }
                },
                "columnDefs": [{// set default column settings
                    'orderable': false,
                    'targets': [0]
                }, {
                    "searchable": false,
                    "targets": [0]
                }],
                "order": [
                    [1, "asc"]
                ] // set first column as a default sort by asc
            });

        });
        $("#SubmitForm").click(function() {

            var checkedValue = [];
            var inputElements = document.getElementsByClassName('videoCheckbox');
            for (var i = 0; i< inputElements.length; ++i) {
                if (inputElements[i].checked) {
                    checkedValue.push(inputElements[i].id);
                }
            }
            var exerciseID = document.getElementById('exID').value;
            var body = JSON.stringify({ exerciseIDs: checkedValue})
            $.ajax({
                type: "POST",
                url: '/postlinkedVideos/'+exerciseID,
                data: {body: body},
                dataType: 'json',
                success: function( msg ) {
                   // console.log(msg);
                    window.location = "/listAllExercise";
                },
                error: function(data){
                    console.log(errors);
                    // Render the errors with js ...
                }
            });
        
    } );

</script>
@stop