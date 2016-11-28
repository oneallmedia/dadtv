<?php
$complete_structure='';
$org_selected=isset($org_id)?$org_id:'';
if(count($vehicles)>0)
{
	foreach($vehicles as $vehicle)
	{
	  $status=$vehicle['is_approved']=='1'?'Approved':'Unapproved';
	  $cstatus_name=$vehicle['is_approved']=='1'?'Unapprove':'Approve';
	  $cstatus_type=$vehicle['is_approved']=='1'?'0':'1';
	  $complete_structure.='<tr role="row" class="odd">
							<td>'.$vehicle['int_year'].'</td>
							<td>'.$vehicle['txt_model'].'</td>
							<td>'.$vehicle['txt_manufacturer'].'</td>
							<td>'.$vehicle['txt_license_plate'].'</td>
							<td>'.$vehicle['members'].'</td>
							<td>'.$status.'</td>
							<td>
								<a  class="status_confirm" href="'.site_url().'/vehicle/change_status?id='.$vehicle['int_vehicle_id'].'&status='.$cstatus_type.'">'.$cstatus_name.'</a>

							</td>
						  </tr>';
	}
}
$option_html='';
if(count($organizations)>0)
{
	foreach($organizations as $organization)
	{
		if($organization['int_organization_id']==$org_selected)
		{
			$option_html.='<option value="'.$organization['int_organization_id'].'" selected="selected">'.$organization['txt_name'].'</option>';
		}
		else
		{
			$option_html.='<option value="'.$organization['int_organization_id'].'">'.$organization['txt_name'].'</option>';
		}
	}
}
?>
<div class="content-wrapper">
  <div class="row">
    <div class="box">
                <div class="box-header">
                  <h3 class="box-title">Vehicle List</h3>
                </div><!-- /.box-header -->
				<form method="post" action="" enctype="multipart/form-data">
                    <div class="box-body">
					<div class="form-group">
                      <label class="col-sm-2 control-label" for="inputEmail3">Organization</label>
                      <div class="col-sm-6">
                        <select id="org_id" name="org_id" class="form-control">
							<option value="">Select Organization</option>
							<?php echo $option_html; ?>
						</select>
                      </div>
					  <div class="col-sm-4">
                        <button id="search_location" class="btn btn-info pull-right" type="submit">Search</button>
                      </div>
                    </div>
				  </div>
                </form>
                <div class="box-body">
                  <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap"><div class="row"><div class="col-sm-6"></div><div class="col-sm-6"></div></div><div class="row"><div class="col-sm-12"><table class="table table-bordered table-hover dataTable" id="example2" role="grid" aria-describedby="example2_info">
                    <thead>
                      <tr role="row">
                        <th class="sorting_asc" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">Year</th>
                        <th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">Model</th>
						<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">Manufacturer</th>
						<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">License Plate</th>
						<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">Assignees</th>
						<th class="sorting" tabindex="0" aria-controls="example2" rowspan="1" colspan="1">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                      <?php echo $complete_structure; ?>
                    </tbody>
                  </table></div>
                </div><!-- /.box-body -->
              </div>
  </div>
</div>
</div>
</div>
<script>
$(document).ready(function(){
  $(".status_confirm").click(function(){
    if(confirm("Are you sure you wish to change the status?"))
    {
      return true;
    }
    else
    {
      return false;
    }
  });
  $("#search_location").click(function(){
    if($("#org_id").val()==""){alert("Please select Organization");$("#org_id").focus();return false;}
  });
});
</script>