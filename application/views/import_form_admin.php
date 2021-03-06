<?php
$user=$this->session->userdata('user');

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
    <div class="col-md-8">
      <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Import Fare</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form method="post" action="<?php echo site_url();?>/fare/save_import_admin" enctype="multipart/form-data">
                    <div class="box-body">
					<div class="form-group">
                      <label class="col-sm-4 control-label" for="inputEmail3">Organization</label>
                      <div class="col-sm-8">
                        <select id="org_id" name="org_id" class="form-control">
							<option value="">Select Organization</option>
							<?php echo $option_html;?>
						</select>
                      </div>
                    </div>
					<div class="form-group">
                      <label class="col-sm-4 control-label" for="inputEmail3">File(CSV)</label>
                      <div class="col-sm-8">
						<input type="file" id="fare_chart" name="fare_chart" value="" class="form-control">
                      </div>
                    </div>
				  </div><!-- /.box-body -->
				  <div class="box-footer">
                    <button id="save_fare_chart" class="btn btn-info pull-right" type="submit">Save</button>
                  </div><!-- /.box-footer -->
                </form>
              </div>
			  </div>
          </div>
      </div>
</div>
<script>
$(document).ready(function(){
  $("#save_fare").click(function(){
    if($("#org_id").val()==""){alert("Please select organization");$("#org_id").focus();return false;}
	if($("#fare_chart").val()==""){alert("Please select file");$("#fare_chart").focus();return false;}
  });
});
</script>