<?php


spl_autoload_register(function ($class) {
    require strtolower($class) . '.php';
});

class Request
{
}

class RequestException extends Exception
{
}

$request = new Request();

$request->method = $_SERVER['REQUEST_METHOD'];

//When a Get request is sent
if (($request->method == "GET") &&  (isset($_SERVER['PATH_INFO']))) {
    $request->path = array();
    $request->path = explode('/', $_SERVER['PATH_INFO']);

    if (isset($request->path[1])) {
        $controller_name = ucfirst($request->path[1]) . "Controller";
        if (class_exists($controller_name)) {
            $controller = new $controller_name();

            if (isset($request->path[2])) {
                if (isset($request->path[3])) {
                    $response = $controller->getCategory($request->path[3], $request->path[2]);
                } else {
                    $response = $controller->getMenu($request->path[2]);
                }
            } else {
                $response = $controller->getFullMenu();
            }
        } else {
            header('HTTP/1.0 400 Controller does not exist');
            throw new RequestException('The ' . $controller_name .' does not exist');
        }
    } else {
        header('HTTP/1.0 400 Bad Request');
        $response = "Unknown response for the path";
    }
} elseif ($request->method == "POST") {
} elseif ($request->method == "PUT") {
} elseif ($request->method == "DELETE") {
} else {
    if (!isset($request->method)) {
        header('HTTP/1.0 400 Bad Method. Not supported');
    }
}

?>

<!DOCTYPE html>
	<html lang="en">
	<head>
		<title><?=$controller_name . ' results'?></title>
		<style type="text/css">
			
		</style>
		<script type="text/javascript">

		</script>
	</head>
	<body>
		<h1> Welcome to Wonderland</h1>

		<pre>
			<?php echo json_encode($response); ?>
		</pre>

		<form method="post" action="">
			<div>
				<label for="name" id="name">Name</label>
				<input type="input" name="name">
			</div>
			<div>
				<label for="country" id="country">Country</label>
				<input type="input" name="country">
			</div>
			<div>
				<label for="feature" id="feature">Feature</label>
				<input type="input" name="feature">
			</div>
			<div>
				<input type="submit" name="submit" value="Submit">
			</div>

		</form>

	</body>
	</html>