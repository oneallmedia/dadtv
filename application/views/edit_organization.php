<?php
$user=$this->session->userdata('user');
$org=$details[0];
?>
<div class="content-wrapper">
<div class="row">
    <div class="col-md-8">
      <div class="box box-info">
                <div class="box-header with-border">
                  <h3 class="box-title">Edit Organization</h3>
                </div><!-- /.box-header -->
                <!-- form start -->
                <form method="post" action="<?php echo site_url();?>/organization/update" enctype="multipart/form-data">
                    <div class="box-body">
					<div class="form-group">
                      <label class="col-sm-4 control-label" for="inputEmail3">Name</label>
                      <div class="col-sm-8">
						<input type="hidden" id="organization_id" name="organization_id" value="<?php echo $org['int_organization_id']; ?>">
                        <input type="text" placeholder="Organization Name" id="org_name" name="org_name" value="<?php echo $org['txt_name']; ?>" class="form-control">
                      </div>
                    </div>
					<div class="form-group">
                      <label class="col-sm-4 control-label" for="inputEmail3">Contact</label>
                      <div class="col-sm-8">
                        <input type="text" placeholder="Contact" id="contact" name="contact" value="<?php echo $org['txt_contact']; ?>" class="form-control">
                      </div>
                    </div>
					<div class="form-group">
                      <label class="col-sm-4 control-label" for="inputEmail3">Address</label>
                      <div class="col-sm-8">
						<textarea id="address" name="address"  value="" class="form-control"><?php echo $org['txt_address']; ?></textarea>
                      </div>
                    </div>
					<div class="form-group">
                      <label class="col-sm-4 control-label" for="inputEmail3">Zip</label>
                      <div class="col-sm-8">
                        <input type="text" placeholder="Zipcode" id="zipcode" name="zipcode" value="<?php echo $org['int_zip']; ?>" class="form-control">
                      </div>
                    </div>
				  </div><!-- /.box-body -->
				  <div class="box-footer">
                    <button id="save_organization" class="btn btn-info pull-right" type="submit">Update</button>
                  </div><!-- /.box-footer -->
                </form>
              </div>
			  </div>
          </div>
      </div>
</div>
<script>
$(document).ready(function(){
  $("#save_organization").click(function(){
    if($("#org_name").val()==""){alert("Please enter Name");$("#org_name").focus();return false;}
	if($("#contact").val()==""){alert("Please enter contact number");$("#contact").focus();return false;}
	if($("#address").val()==""){alert("Please enter address");$("#address").focus();return false;}
	if($("#zipcode").val()==""){alert("Please enter zipcode");$("#zipcode").focus();return false;}
  });
});
</script>