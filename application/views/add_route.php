<?php
$user=$this->session->userdata('user');
$option_html='';
$complete_html='';

if(count($locations)>0)
{
	foreach($locations as $location)
	{
		$option_html.='<option value="'.$location['int_location_id'].'">'.$location['txt_location'].'</option>';
	}
	for($i=1;$i<=count($locations);$i++)
	{
		$complete_html.='<div class="form-group">
						  <label class="col-sm-4 control-label" for="inputEmail3">Stopage '.$i.'</label>
						  <div class="col-sm-8">
							<select id="stopage_'.$i.'" name="stopage_'.$i.'" class="form-control">
								<option value="">Select Stopage</option>
									'.$option_html.'
								</option>
							</select>
						  </div>
						</div>';
	}
}
?>
<div class="content-wrapper">
<div class="row">
    <div class="col-md-8">
      <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Add Route</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form method="post" action="<?php echo site_url();?>/route/save" enctype="multipart/form-data">
                    <div class="box-body">
					<div class="form-group">
					  <label class="col-sm-4 control-label" for="inputEmail3">Name</label>
					  <div class="col-sm-8">
						<input type="hidden" id="stopage_count" name="stopage_count" value="<?php echo count($locations);?>">
						<input type="text" id="name" name="name" value="" class="form-control">
					  </div>
					</div>
					<?php echo $complete_html;?>
				  </div><!-- /.box-body -->
				  <div class="box-footer">
                    <button id="save_route" class="btn btn-info pull-right" type="submit">Save</button>
                  </div><!-- /.box-footer -->
                </form>
              </div>
			  </div>
          </div>
      </div>
</div>
<script>
$(document).ready(function(){
  $("#save_route").click(function(){
	if($("#name").val()==""){alert("Please enter route name");$("#name").focus();return false;}
  });
});
</script>