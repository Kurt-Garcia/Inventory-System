<?php 

	include('connect.php');


		$id = $_POST['id'];
		$query = "delete from tbl_user where id = $id";
		$result = odbc_exec($connect,$query);
		if (!$result)
		{
			echo "failed to remove data";
		}
		elseif ($result)
		{
			header ('location: /engineering/users.php');
		}

 ?>