<?php
class Fare_model extends CI_Model{
	

	function fare_model(){
		parent::__construct();
	}

	function save($data)
	{
		$sql_product="insert into tab_fare values(DEFAULT,'".$data['source']."','".$data['destination']."','".$data['fare']."')";
		$query=$this->db->query($sql_product);
		return 1;
	}

	function get_all_fares()
	{
		
		$sql="select a.int_fare_id, a.float_fare as fare,b.txt_location as source,c.txt_location as destination from tab_fare as a join tab_locations as b ON a.int_source=b.int_location_id join tab_locations as c ON a.int_destination=c.int_location_id";
		$query=$this->db->query($sql);
		$result=$query->result_array();
		return $result;
	}
	
	function save_transaction($data)
	{
		$sql_product="insert into tab_transactions values(DEFAULT,'".$data['source']."','".$data['destination']."','".$data['quantity']."','".$data['fare']."','".$data['organization']."','".$data['secret']."','".$data['datetime']."','".$data['vehicle']."')";
		$query=$this->db->query($sql_product);
		return 1;
	}
	
	function import_org_data($data)
	{
		$filepath='uploads/'.$data['filename'];
		$final_array=array();
		if (($handle = fopen($filepath, "r")) !== FALSE) {
			while (($data1 = fgetcsv($handle, 1000, ",")) !== FALSE) {
				$temp_array=array();
				$temp_array['source']=$data1[0];
				$temp_array['destination']=$data1[1];
				$temp_array['fare']=$data1[2];
				$final_array[]=$temp_array;
			}
			fclose($handle);
		}
		$counter=0;
		$id_array=array();
		for($i=0;$i<count($final_array);$i++)
		{
			$temp_id_array=array();
			if($i==0)
			{
				$insert1="insert into tab_locations values(DEFAULT,'".$final_array[$i]['source']."','".$data['org_id']."')";
				$query1=$this->db->query($insert1);
				$source_id=$this->db->insert_id();
				$insert2="insert into tab_locations values(DEFAULT,'".$final_array[$i]['destination']."','".$data['org_id']."')";
				$query2=$this->db->query($insert2);
				$destination_id=$this->db->insert_id();
				$temp_id_array['source']=$source_id;
				$temp_id_array['destination']=$destination_id;
				$temp_id_array['fare']=$final_array[$i]['fare'];
				$sql_fare="insert into tab_fare values(DEFAULT,'".$source_id."','".$destination_id."','".$final_array[$i]['fare']."')";
				$query_fare=$this->db->query($sql_fare);
			}
			else
			{
				$insert2="insert into tab_locations values(DEFAULT,'".$final_array[$i]['destination']."','".$data['org_id']."')";
				$query1=$this->db->query($insert2);
				$destination_id=$this->db->insert_id();
				$sql_fare="insert into tab_fare values(DEFAULT,'".$id_array[0]['source']."','".$destination_id."','".$final_array[$i]['fare']."')";
				$query_fare=$this->db->query($sql_fare);
				for($j=0;$j<$i;$j++)
				{
					$intermediate_cost=$final_array[$i]['fare']-$final_array[$j]['fare'];
					$source_id=$id_array[$j]['destination'];
					$sql_fare="insert into tab_fare values(DEFAULT,'".$source_id."','".$destination_id."','".$intermediate_cost."')";
					$query_fare=$this->db->query($sql_fare);
				}
				$temp_id_array['source']=$id_array[0]['source'];
				$temp_id_array['destination']=$destination_id;
				$temp_id_array['fare']=$final_array[$i]['fare'];
			}
			$id_array[]=$temp_id_array;
		}
		return 1;
	}
	
	function get_transaction_data($data)
	{
		$start_dt=date("Y-m-d",strtotime($data['selected_date']))." 00:00:00";
		$end_dt=date("Y-m-d",strtotime($data['selected_date']))." 23:59:59";
		$sql="select a.int_transaction_id, a.int_quantity, a.fl_cost as fare,b.txt_location as source,c.txt_location as destination,a.dt_issue from tab_transactions as a join tab_locations as b ON a.int_source=b.int_location_id join tab_locations as c ON a.int_destination=c.int_location_id where a.int_vehicle_id='".$data['vehicle']."' and dt_issue>='".$start_dt."' and dt_issue<='".$end_dt."'";
		$query=$this->db->query($sql);
		$result=$query->result_array();
		return $result;
	}
	
	function get_org_transaction($data)
	{
		$extra_query1='';
		$extra_query2='';
		$extra_query3='';
		if(isset($data['time_period']) && $data['time_period']!='')
		{
			$end_dt='';
			$start_dt='';
			if($data['time_period']=='l7')
			{
				$end_dt=date("Y-m-d")." 23:59:59";
				$start_dt=date('Y-m-d', strtotime('-7 day', strtotime($end_dt)))." 00:00:00";
			}
			else if($data['time_period']=='l30')
			{
				$end_dt=date("Y-m-d")." 23:59:59";
				$start_dt=date('Y-m-d', strtotime('-30 day', strtotime($end_dt)))." 00:00:00";
			}
			else if($data['time_period']=='cm')
			{
				$end_dt=date("Y-m-d")." 23:59:59";
				$start_dt=date("Y-m-01")." 00:00:00";
			}
			else if($data['time_period']=='l30')
			{
				$end_dt=date("Y-m-d")." 23:59:59";
				$start_dt=date("Y-01-01")." 00:00:00";
			}
			if($start_dt!='' && $start_dt!='')
			{
				$extra_query1="and a.dt_issue>='".$start_dt."' and a.dt_issue<='".$end_dt."'";
			}
		}
		else if($data['start']!='' && $data['end']!='')
		{
			$start_dt=date("Y-m-d",strtotime($data['start']))." 00:00:00";
			$end_dt=date("Y-m-d",strtotime($data['end']))." 23:59:59";
			$extra_query1="and a.dt_issue>='".$start_dt."' and a.dt_issue<='".$end_dt."'";
		}
		if($data['vehicle_id']!='')
		{
			$extra_query2="and a.int_vehicle_id>='".$data['vehicle_id']."'";
		}
		if(isset($data['route_id']) && $data['route_id']!='')
		{
			$extra_query3="and a.int_source IN(select int_location_id from tab_route_locations where int_route_id IN(".$data['route_id'].")) and a.int_destination IN(select int_location_id from tab_route_locations where int_route_id IN(".$data['route_id']."))";
		}
		
		$sql="select a.int_transaction_id, a.int_quantity, a.fl_cost as fare,b.txt_location as source,c.txt_location as destination,a.dt_issue,d.txt_license_plate from tab_transactions as a join tab_locations as b ON a.int_source=b.int_location_id join tab_locations as c ON a.int_destination=c.int_location_id left join tab_vehicle as d ON a.int_vehicle_id=d.int_vehicle_id where a.int_organization_id='".$data['org_id']."' ".$extra_query1." ".$extra_query2."  ".$extra_query3." order by dt_issue desc";
		$query=$this->db->query($sql);
		$result=$query->result_array();
		return $result;
	}
	
	function get_org_fares($org_id)
	{
		
		$sql="select a.int_fare_id, a.float_fare as fare,b.txt_location as source,c.txt_location as destination from tab_fare as a join tab_locations as b ON a.int_source=b.int_location_id join tab_locations as c ON a.int_destination=c.int_location_id where b.int_organization_id='".$org_id."'";
		$query=$this->db->query($sql);
		$result=$query->result_array();
		return $result;
	}
	
	function get_org_fares_device($org_id)
	{
		
		$sql="select a.int_fare_id, a.float_fare as fare,b.int_location_id as source,c.int_location_id as destination from tab_fare as a join tab_locations as b ON a.int_source=b.int_location_id join tab_locations as c ON a.int_destination=c.int_location_id where b.int_organization_id='".$org_id."'";
		$query=$this->db->query($sql);
		$result=$query->result_array();
		return $result;
	}
	
	function calculate($data)
	{
		$sql="select * from tab_fare where (int_source='".$data['source']."' and int_destination='".$data['destination']."') OR (int_source='".$data['destination']."' and int_destination='".$data['source']."')";
		$query=$this->db->query($sql);
		$result=$query->result_array();
		$fare_amt=$result[0]['float_fare'];
		if($fare_amt!='' || $fare_amt!='0')
		{
			$total=$fare_amt*$data['quantity'];
		}
		else
		{
			$total=0;
		}
		return $total;
	}
	

	function delete_fare($id)
	{
		$sql="delete from tab_fare where int_fare_id=".$id."";
		$query=$this->db->query($sql);
		return $query;
	}
	
	function get_fare_details($id)
	{
		$sql="select * from tab_fare where int_fare_id=".$id."";
		$query=$this->db->query($sql);
		$result=$query->result_array();
		return $result;
	}
	
	function update_fare($data)
	{
		$sql_product="update tab_fare set float_fare='".$data['fare']."' where int_fare_id='".$data['fare_id']."'";
		$query=$this->db->query($sql_product);
		return 1;
	}
	
}

?>