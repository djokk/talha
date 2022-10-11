<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header('Access-Control-Max-Age: 1000');
header("Access-Control-Allow-Methods: POST, GET, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Accept, Content-Type, Content-Length, Accept-Encoding, X-CSRF-Token, Authorization");
header("Content-type: application/json");

$connect = new PDO('mysql:dbhost=127.0.0.1:3306; dbname=talha_db', 'root', '');//подключения БД 
//$connect = new PDO('mysql:dbhost=localhost:3306; dbname=barakatexnika_uz_navbat', 'barak_navbat2', 'i1716O8XsbU7zeuywUb9');//подключения БД 
// $connect = new PDO('mysql:dbhost=localhost:3306; dbname=barakatexnika_uz_navbat', 'barak_navbat2', 'i1716O8XsbU7zeuywUb9');//подключения БД 
if(!$connect) {
  echo "EROR Connect";
}

date_default_timezone_set('Asia/Tashkent');

$method = $_SERVER['REQUEST_METHOD'];
$type = $_GET['q'];
$Id = $_GET['Id'];
$Code = $_GET['Code'];
$Token = $_GET['Token'];

function random_token() {
	$arr = array(
		'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 
		'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 
		'1', '2', '3', '4', '5', '6', '7', '8', '9', '0'
	);
	
	$res = '';
	for ($i = 0; $i < 10; $i++) {
		$res = $res . $arr[rand(0, 36)];
	}
	
	return $res;
	// print_r($codeText);
}

if($method == 'GET') {

	switch ($type) {
		case "model":
			$sql = "SELECT * FROM model WHERE Id";
			$query = $connect->prepare($sql);
			$query->execute(); ///Выполниние запроса
			$array = $query->fetchAll(PDO::FETCH_ASSOC);
			echo json_encode($array);
			// if(empty($Id)) {
			// } else {
			// 	$sql = "SELECT * FROM org WHERE id=$Id";
			// 	$query = $connect->prepare($sql);
			// 	$query->execute(); ///Выполниние запроса
			// 	$array = $query->fetch(PDO::FETCH_ASSOC);
			// 	echo json_encode($array);
			// }
			break;
		case "modelCode":
			$Code = rand(1000000,9999999);
			$array = 'M' . $Code;

			echo json_encode($array);
			break;
		case "modelDelete":
			if(isset($Id)) {
				$sql = "DELETE FROM model WHERE `Id`= $Id";///Строка с запросом (для удобство)
				$query = $connect->prepare($sql);//Подготовка запроса к выполнегию
				$query->execute();///Выполниние запроса

				$res = array(
					"Status" => true,
					"info" => "deleted",
					"Id" => $Id
				);
				echo json_encode($res);
			}
			break;
		case "color":
			$sql = "SELECT * FROM color WHERE Id";
			$query = $connect->prepare($sql);
			$query->execute(); ///Выполниние запроса
			$array = $query->fetchAll(PDO::FETCH_ASSOC);
			echo json_encode($array);
			break;
		case "colorCode":
			$Code = rand(1000000,9999999);
			$array = 'C' . $Code;

			echo json_encode($array);
			break;
		case "colorDelete":
			if(isset($Id)) {
				$sql = "DELETE FROM color WHERE `Id`= $Id";///Строка с запросом (для удобство)
				$query = $connect->prepare($sql);//Подготовка запроса к выполнегию
				$query->execute();///Выполниние запроса

				$res = array(
					"Status" => true,
					"info" => "deleted",
					"Id" => $Id
				);
				echo json_encode($res);
			}
			break;
		case "store":
			$sql = "SELECT * FROM store WHERE Id";
			$query = $connect->prepare($sql);
			$query->execute(); ///Выполниние запроса
			$arrayAll = $query->fetchAll(PDO::FETCH_ASSOC);
			$array = [];
			for ($i=0; $i < count($arrayAll); $i++) { 
				array_push($array, [
					"Id" => intval($arrayAll[$i]["Id"]),
					"Code" => $arrayAll[$i]["Code"],
					"Name" => $arrayAll[$i]["Name"],
					"Color" => $arrayAll[$i]["Color"],
					"ColorId" => intval($arrayAll[$i]["ColorId"]),
					"ColorCode" => $arrayAll[$i]["ColorCode"],
					"Counts" => intval($arrayAll[$i]["Counts"]),
					"Dates" => $arrayAll[$i]["Dates"],
					"Times" => $arrayAll[$i]["Times"]
				]);
			}
			echo json_encode($array);
			break;
		case "history":
			$sql = "SELECT * FROM history WHERE Id";
			$query = $connect->prepare($sql);
			$query->execute(); ///Выполниние запроса
			$array = $query->fetchAll(PDO::FETCH_ASSOC);
			echo json_encode(array_reverse($array));
			break;
		case "users":
			$sql = "SELECT * FROM users WHERE Id";
			$query = $connect->prepare($sql);
			$query->execute(); ///Выполниние запроса
			$array = $query->fetchAll(PDO::FETCH_ASSOC);
			echo json_encode(array_reverse($array));
			break;
		case "usersDelete":
			if(isset($Id)) {
				if($Id != 1 || $Id != '1') {
					$sql = "DELETE FROM users WHERE `Id`= $Id";///Строка с запросом (для удобство)
					$query = $connect->prepare($sql);//Подготовка запроса к выполнегию
					$query->execute();///Выполниние запроса
					
					if($query->rowCounts() > 0) {
						$res = array(
							"Status" => true,
							"info" => "deleted",
							"Id" => $Id
						);
					} else {
						$res = array(
							"Status" => false,
							"info" => "not deleted",
							"Id" => $Id
						);
					}
					echo json_encode($res);
				} else {
					$res = array(
						"Status" => false,
						"info" => "not deleted",
						"Id" => $Id
					);
					echo json_encode($res);
				}
			}
			break;
	}
} elseif($method === 'POST') {
	switch ($type) {
		case "auth":
			$data = file_get_contents('php://input');
			$data = json_decode($data, true);
			$Login = $data['Login'];
			$Password = $data['Password'];
			$sql = "SELECT * FROM users WHERE Login=:Login AND Password=:Password";
			$query = $connect->prepare($sql);
			$query->execute([
				'Login' => $Login,
				'Password' => $Password
			]); ///Выполниние запроса
			$array = $query->fetch(PDO::FETCH_ASSOC); ////Получаем все запросы
			$Token = random_token();
			if($array['Login'] === $Login and $array['Password'] === $Password) {
				$res = array(
					"Status" => true,
					"Message" => "ok",
					"Login" => $array['Login'],
					"Password" => $array['Password'],
					"FullName" => $array['FullName'],
					'Token' => $Token
				);
				echo json_encode($res);
			} else {
				$res = array(
					"Status" => false,
					"Message" => "not auth",
					"Login" => $Login,
					"Password" => $Password
				);
				echo json_encode($res);
			}
			break;
		case "saveStore":
			$data = file_get_contents('php://input');
			$data = json_decode($data, true);
			$Code = $data["Code"];
			$Name = $data["Name"];
			$Color = $data["Color"];
			$ColorId = $data["ColorId"];
			$ColorCode = $data["ColorCode"];
			$Counts = $data["Counts"];
			$Dates = date("m/d/y");
	
			$sql = "INSERT INTO `store`(`Code`, `Name`, `Color`, `ColorId`, `ColorCode`, `Counts`, `Dates`) VALUES (:Code, :Name, :Color, :ColorId, :ColorCode, :Counts, :Dates)";
			$query = $connect->prepare($sql);
			$query->execute([
				'Code' => $Code,
				'Name' => $Name,
				'Color' => $Color,
				'ColorId' => $ColorId,
				'ColorCode' => $ColorCode,
				'Counts' => $Counts,
				'Dates' => $Dates
			]); ///Выполниние запроса
			// http_response_code(201);
			if($query->rowCounts() > 0) {
				$res = array(
					"Status" => true,
					"Code" => $Code,
					"Name" => $Name,
					"Color" => $Color,
					"ColorId" => $ColorId,
					"Counts" => $Counts,
					"Dates" => $Dates
				);
			} else {
				$res = array(
					"Status" => false,
					"Code" => $Code,
					"Name" => $Name,
					"Color" => $Color,
					"ColorId" => $ColorId,
					"Counts" => $Counts,
					"Dates" => $Dates
				);
			}
			echo json_encode($res);
			break;
		case "saveModel":
			$data = file_get_contents('php://input');
			$data = json_decode($data, true);
			$Code = $data["Code"];
			$Name = $data["Name"];
			$Color = $data["Color"];
			$ColorId = $data["ColorId"];
			$ColorCode = $data["ColorCode"];
			$Counts = 0;
			$Dates = date("m/d/y");
			$Times = date("H:i");

			$sql = "SELECT * FROM model WHERE Id";
			$query = $connect->prepare($sql);
			$query->execute(); ///Выполниние запроса
			$arrayModel = $query->fetchAll(PDO::FETCH_ASSOC);

			if(count($arrayModel) != 0) {
				for ($i=0; $i < count($arrayModel); $i++) { 
					if($arrayModel[$i]['Code'] != $Code && $arrayModel[$i]['Name'] != $Name && $arrayModel[$i]['ColorCode'] != $ColorCode) {
						$sql = "INSERT INTO `model`(`Code`, `Name`, `Color`, `ColorId`, `ColorCode`) VALUES (:Code, :Name, :Color, :ColorId, :ColorCode)";
						$query = $connect->prepare($sql);
						$query->execute([
							'Code' => $Code,
							'Name' => $Name,
							'Color' => $Color,
							'ColorId' => $ColorId,
							'ColorCode' => $ColorCode
						]); ///Выполниние запроса
						$sql = "INSERT INTO `store`(`Code`, `Name`, `Color`, `ColorId`, `ColorCode`, `Counts`, `Dates`, `Times`) VALUES (:Code, :Name, :Color, :ColorId,:ColorCode, :Counts, :Dates, :Times)";
						$query = $connect->prepare($sql);
						$query->execute([
							'Code' => $Code,
							'Name' => $Name,
							'Color' => $Color,
							'ColorId' => $ColorId,
							'ColorCode' => $ColorCode,
							'Counts' => $Counts,
							'Dates' => $Dates,
							'Times' => $Times
						]); ///Выполниние запроса  				
						$res = array(
							"Status" => true,
							"Code" => $Code,
							"Name" => $Name,
							"Color" => $Color,
							"ColorId" => $ColorId,
							"ColorCode" => $ColorCode,
							"Counts" => $Counts,
							"Dates" => $Dates,
							"Times" => $Times
						);
					} else {
						$res = array(
							"Status" => false,
							"Code" => $Code,
							"Name" => $Name,
							"Color" => $Color,
							"ColorId" => $ColorId,
							"ColorCode" => $ColorCode,
							"Counts" => $Counts,
							"Dates" => $Dates,
							"Times" => $Times
						);
					}
				}
			} else {
				$sql = "INSERT INTO `model`(`Code`, `Name`, `Color`, `ColorId`, `ColorCode`) VALUES (:Code, :Name, :Color, :ColorId, :ColorCode)";
				$query = $connect->prepare($sql);
				$query->execute([
					'Code' => $Code,
					'Name' => $Name,
					'Color' => $Color,
					'ColorId' => $ColorId,
					'ColorCode' => $ColorCode
				]); ///Выполниние запроса
				$sql = "INSERT INTO `store`(`Code`, `Name`, `Color`, `ColorId`, `ColorCode`, `Counts`, `Dates`, `Times`) VALUES (:Code, :Name, :Color, :ColorId,:ColorCode, :Counts, :Dates, :Times)";
				$query = $connect->prepare($sql);
				$query->execute([
					'Code' => $Code,
					'Name' => $Name,
					'Color' => $Color,
					'ColorId' => $ColorId,
					'ColorCode' => $ColorCode,
					'Counts' => $Counts,
					'Dates' => $Dates,
					'Times' => $Times
				]); ///Выполниние запроса  	 
				$res = array(
					"Status" => true,
					"Code" => $Code,
					"Name" => $Name,
					"Color" => $Color,
					"ColorId" => $ColorId,
					"ColorCode" => $ColorCode,
					"Counts" => $Counts,
					"Dates" => $Dates,
					"Times" => $Times
				);
			}
			echo json_encode($res);
			break;
		case "saveColor":
			$data = file_get_contents('php://input');
			$data = json_decode($data, true);
			$Code = $data["Code"];
			$Name = $data["Name"];
	
			$sql = "INSERT INTO `color`(`Code`, `Name`) VALUES (:Code, :Name)";
			$query = $connect->prepare($sql);
			$query->execute([
				'Code' => $Code,
				'Name' => $Name
			]); ///Выполниние запроса
			// http_response_code(201);
			$res = array(
				"Code" => $Code,
				"Name" => $Name
			);
			echo json_encode($res);
			break;
		case "saveUser":
			$data = file_get_contents('php://input');
			$data = json_decode($data, true);
			$Login = $data["Login"];
			$Password = $data["Password"];
			$FullName = $data["FullName"];
	
			$sql = "INSERT INTO `users`(`Login`, `Password`, `FullName`) VALUES (:Login, :Password, :FullName)";
			$query = $connect->prepare($sql);
			$query->execute([
				'Login' => $Login,
				'Password' => $Password,
				'FullName' => $FullName
			]); ///Выполниние запроса
			$res = array(
				"Status" => true,
				"Login" => $Login,
				"Password" => $Password,
				'FullName' => $FullName
			);
			echo json_encode($res);
			break;
	}
} elseif($method === 'PUT') {
	switch ($type) {
		case "model":
			$data = file_get_contents('php://input');
			$data = json_decode($data, true);
			$local = $data["local"];
			$Id = $data["Id"];
			$Code = $data["Code"];
			$Name = $data["Name"];
			$Color = $data["Color"];
			$ColorId = $data["ColorId"];

			$sql = "UPDATE `model` SET `Code`=:Code, `Name`=:Name, `Color`=:Color, `ColorId`=:ColorId WHERE `Id`=:Id";
			$query = $connect->prepare($sql);
			$query->execute([
				':Id' => $Id,
				':Code' => $Code,
				':Name' => $Name,
				':Color' => $Color,
				':ColorId' => $ColorId
			]);
				
			$res = array(
				"Status" => true,
				"info" => "updated",
				"Id" => $Id,
				"Name" => $Name,
				"Color" => $Color,
				"ColorId" => $ColorId
			);
			echo json_encode($res);
			break;
		case "color":
			$data = file_get_contents('php://input');
			$data = json_decode($data, true);
			$Id = $data["Id"];
			$Code = $data["Code"];
			$Name = $data["Name"];

			$sql = "UPDATE `color` SET `Code`=:Code, `Name`=:Name WHERE `Id`=:Id";
			$query = $connect->prepare($sql);
			$query->execute([
				':Id' => $Id,
				':Code' => $Code,
				':Name' => $Name
			]);
			
			$res = array(
				"Status" => true,
				"info" => "updated",
				"Id" => $Id,
				"Name" => $Name
			);
			echo json_encode($res);
			break;
		case "users":
			$data = file_get_contents('php://input');
			$data = json_decode($data, true);
			$local = $data["local"];
			$Id = $data["Id"];
			$Login = $data["Login"];
			$Password = $data["Password"];
			$FullName = $data["FullName"];

			$sql = "UPDATE `users` SET `Login`=:Login, `Password`=:Password, `FullName`=:FullName WHERE `Id`=:Id";
			$query = $connect->prepare($sql);
			$query->execute([
				':Id' => $Id,
				':Login' => $Login,
				':Password' => $Password,
				':FullName' => $FullName
			]);
				
			$res = array(
				"Status" => true,
				"info" => "update",
				"Id" => $Id,
				"FullName" => $FullName
			);
			echo json_encode($res);
			break;
		case "store":
			$data = file_get_contents('php://input');
			$data = json_decode($data, true);
			$Id = $data["Id"];
			$Code = $data["Code"];
			$Name = $data["Name"];
			$Color = $data["Color"];
			$ColorId = $data["ColorId"];
			$ColorCode = $data["ColorCode"];
			$Counts = $data["Counts"];
			$CountEnd = $data["CountEnd"];
			// $CountsModel = $data["CountsModel"];
			$Dates = date("m/d/y");
			$Times = date("H:i");
			$Parametrs = $data["Parametrs"];
			$Login = $data["Login"];
			$FullName = $data["FullName"];

			$sql = "UPDATE `store` SET `Counts` = $Counts WHERE `store`.`Id` = $Id";
			$query = $connect->prepare($sql);
			$query->execute([]);
			
			$sql = "INSERT INTO `history`(`Code`, `Name`, `Color`, `ColorId`, `ColorCode`, `CountEnd`, `Counts`, `Dates`, `Times`, `Parametrs`, `Login`, `FullName`) VALUES (:Code, :Name, :Color, :ColorId, :ColorCode, :CountEnd, :Counts, :Dates, :Times, :Parametrs, :Login, :FullName)";
			$query = $connect->prepare($sql);
			$query->execute([
				'Code' => $Code,
				'Name' => $Name,
				'Color' => $Color,
				'ColorId' => $ColorId,
				'ColorCode' => $ColorCode,
				'CountEnd' => $CountEnd,
				'Counts' => $Counts,
				'Dates' => $Dates,
				'Times' => $Times,
				'Parametrs' => $Parametrs,
				'Login' => $Login,
				'FullName' => $FullName
			]); ///Выполниние запроса
			$res = array(
				"Status" => true,
				"info" => "updated",
				"Id" => $Id,
				"Code" => $Code,
				"Name" => $Name,
				"Color" => $Color,
				"ColorId" => $ColorId,
				"ColorCode" => $ColorCode,
				'CountEnd' => $CountEnd,
				'Counts' => $Counts,
				"Dates" => $Dates,
				"Times" => $Times,
				"Parametrs" => $Parametrs,
				"Login" => $Login,
				"FullName" => $FullName
			);
			echo json_encode($res);
			break;
	}
}

// $sql = "SELECT * FROM model WHERE Id";
// $query = $connect->prepare($sql);
// $query->execute(); ///Выполниние запроса
// $arrayModel = $query->fetchAll(PDO::FETCH_ASSOC);
// print_r(count($arrayModel));
//UPDATE `model` SET `Name` = 'asdasd2' WHERE `model`.`Id` = 3;

// print_r(intval(43));

// $Code = "M2472852";
// $Name = "asd";
// $Color = "Black";
// $ColorId = 1;
// $ColorCode = "C7777777";
// $CountEnd = 2;
// $Counts = 10;
// $Dates = "10/11/22";
// $Times = "19:57";
// $Parametrs = 0;
// $Login = "admin";
// $FullName = "Администратор";

