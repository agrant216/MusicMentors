<?php
	$option = $_GET["option"];
	echo '<p class="formItem"><select name="'.$option.'[]">';
	foreach (getAllOptions($option) as $g)
	{
		echo '<option value="'.$g["id"].'">'.$g["name"].'</option>';
	}
	echo '</select> <a class="removeItem">Remove</a></p>';

	function getAllOptions($x)
		{
			$options = array();
			try
			{
				$pdo = new PDO("mysql:host=localhost;dbname=znewman","znewman","1ofoH7pC");
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				//Prepare a statement by setting parameters
				$sql = 'SELECT id, '.$x.' FROM mm_'.$x.'s';
				$statement = $pdo->prepare($sql);
				$statement->execute();

				while ($row =  $statement->fetch())
				{
					$options[] = ["id"=>$row["id"], "name"=>$row[$x]];
				}
				$pdo = null;
			}

			catch (PDOException $e) {
				die( $e->getMessage() );
			}
			return $options;
	}
?>