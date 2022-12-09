<?php require_once './database/database.php'; ?>
<?php

$error = $success = '';

if(isset($_GET['id']) && !empty($_GET)) {
    $student_id = $_GET['id'];
} else {
    header('location: ./index.php');
}

$student = $db->show_single('students', $student_id);
$name = $student['name'];
$email = $student['email'];

if(isset($_POST['submit'])) {
	$name = htmlspecialchars($_POST['name']);
	$email = htmlspecialchars($_POST['email']);

	if(empty($name)) {
		$error = "Please provide your name!";
	} elseif(empty($email)) {
		$error = "Please provide your email!";
	} else {
		if($db->update_email_exist('students', $email, $student_id)) {
			$error = "Email already exists!";
		} else {
			$student_data = [
				'name' => $name,
				'email' => $email
			];
			if($db->update('students', $student_data, $student_id)) {
				$success = "Magic has been spelled";
			} else {
				$error = "Magic has failed to spell";
			}
		}
	}
}
?>
<!DOCTYPE html>
<html lang="en">

<?php require_once './includes/head.php'; ?>

<body>
	<div class="wrapper">

		<?php require_once './includes/sidebar.php'; ?>

		<div class="main">

			<?php require_once './includes/navbar.php'; ?>

			<main class="content">
				<div class="container-fluid p-0">
					<div class="row">
						<div class="col-6">
							<h1 class="h3 mb-3">Edit Student</h1>
						</div>
						<div class="col-6 text-end">
							<a href="./index.php" class="btn btn-dark">Back</a>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-body">
									<?php
									if ($error) { ?>
										<div class="alert alert-danger alert-dismissible fade show" role="alert">
											<?php echo $error; ?>
											<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
										</div>
									<?php
									} elseif ($success) { ?>
										<div class="alert alert-success alert-dismissible fade show" role="alert">
										<?php echo $success; ?>
											<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
										</div>
									<?php
									}
									?>

									<form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>?id=<?php echo $student_id; ?>" method="post">
										<div class="mb-3">
											<label for="name">Name</label>
											<input type="text" name="name" id="name" class="form-control" placeholder="Please enter your name!" value="<?php echo $name; ?>">
										</div>
										<div class="mb-3">
											<label for="email">Email</label>
											<input type="text" name="email" id="email" class="form-control" placeholder="Please enter your email!" value="<?php echo $email; ?>">
										</div>
										<div>
											<input type="submit" name="submit" value="Submit" class="btn btn-primary">
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>

				</div>
			</main>

			<?php require_once './includes/footer.php'; ?>

		</div>
	</div>

	<?php require_once './includes/modals.php'; ?>

	<?php require_once './includes/script.php'; ?>

    

</body>

</html>