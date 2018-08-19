<?php

// Declaration of variables
$error = '';
$name = '';
$last_name = '';
$email = '';
$subject = '';
$message = '';


//Remove space, special characters and \
function clean_text($string)
{
	$string = trim($string);
	$string = stripslashes($string);
	$string = htmlspecialchars($string);
	return $string;
}


//Check Submit
if(isset($_POST["submit"]))
{

	//Validation name
	if(empty($_POST["name"]))
	{
		$error .= '<p><label class="text-danger">Please Enter your Name</label></p>';
	}
	else
	{
		$name = clean_text($_POST["name"]);
		if(!preg_match("/^[a-zA-Z ]*$/",$name))
		{
			$error .= '<p><label class="text-danger">Only letters and white space allowed</label></p>';
		}
	}

	//Validation last_name
	if(empty($_POST["last_name"]))
	{
		$error .= '<p><label class="text-danger">Please Enter your Last Name</label></p>';
	}
	else
	{
		$last_name = clean_text($_POST["last_name"]);
		if(!preg_match("/^[a-zA-Z ]*$/",$last_name))
		{
			$error .= '<p><label class="text-danger">Only letters and white space allowed</label></p>';
		}
	}

	//Validation email
	if(empty($_POST["email"]))
	{
		$error .= '<p><label class="text-danger">Please Enter your Email</label></p>';
	}
	else
	{
		$email = clean_text($_POST["email"]);
		if(!filter_var($email, FILTER_VALIDATE_EMAIL))
		{
			$error .= '<p><label class="text-danger">Invalid email format</label></p>';
		}
	}

	//Validation message
	if(empty($_POST["message"]))
	{
		$error .= '<p><label class="text-danger">Message is required</label></p>';
	}
	else
	{
		$message = clean_text($_POST["message"]);
	}

	//Create file.csv
	if($error == '')
	{
		$file_open = fopen("example_data.csv", "a");
		$no_rows = count(file("example_data.csv"));
		if($no_rows > 1)
		{
			$no_rows = ($no_rows - 1) + 1;
		}

		$form_data = array(
			'sr_no'		=>	$no_rows,
			'name'		=>	$name,
			'last_name'		=>	$last_name,
			'email'		=>	$email,
			'message'	=>	$message
		);

		//Save data in file
		fputcsv($file_open, $form_data);

		//Feedback
		$error = '<label class="text-success">Stored data!</label>';
		$name = '';
		$last_name = '';
		$email = '';
		$message = '';

		//optional
		//fclose($file_open);
	}
}

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Store Form data in CSV File using PHP</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
	</head>
	<body>
		<br />
		<div class="container">
			<h2 align="center">Store Form data in CSV File using PHP</h2>
			<br />
			<div class="col-md-6" style="margin:0 auto; float:none;">
				<form method="post">
					<h3 align="center">Example Form</h3>
					<br />
					<?php echo $error; ?>
					<div class="form-group">
						<label>Enter Name</label>
						<input type="text" name="name" placeholder="Enter Name" class="form-control" value="<?php echo $name; ?>" />
					</div>
					<div>
						<label>Enter Last Name</label>
						<input type="text" name="last_name" placeholder="Enter Last Name" class="form-control" value="<?php echo $last_name; ?>" />
					</div>	
					<div class="form-group">
						<label>Enter Email</label>
						<input type="text" name="email" class="form-control" placeholder="Enter Email" value="<?php echo $email; ?>" />
					</div>
					<div class="form-group">
						<label>Enter Message</label>
						<textarea  style="max-width: 100%; max-height: 50px;" name="message" class="form-control" placeholder="Enter Message"><?php echo $message; ?></textarea>
					</div>
					<br />
					<div class="form-group" align="center">
						<input type="submit" name="submit" class="btn btn-info" value="Submit" />
					</div>
				</form>
			</div>
		</div>
	</body>
</html>
