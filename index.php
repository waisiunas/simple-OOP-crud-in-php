<?php require_once './database/database.php'; ?>
<?php
$students = $db->show('students');
session_start();
$class = $message = '';
if (isset($_SESSION['success'])) {
	// echo $_SESSION['success'];
	$class = 'success';
	$message = $_SESSION['success'];
	unset($_SESSION['success']);
} elseif (isset($_SESSION['error'])) {
	$class = 'danger';
	$message = $_SESSION['error'];
	unset($_SESSION['error']);
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
							<h1 class="h3 mb-3">Students</h1>
						</div>
						<div class="col-6 text-end">
							<a href="./add_student.php" class="btn btn-primary">Add Student</a>
						</div>
					</div>

					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-body">

									<?php
									if ($class) { ?>

										<div class="alert alert-<?php echo $class ?> alert-dismissible fade show" role="alert">
											<?php echo $message; ?>
											<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
										</div>
									<?php
									}

									if ($students) { ?>
										<div class="table-responsive">
											<table class="table">
												<thead>
													<tr>
														<th>Name</th>
														<th>Email</th>
														<th>Created at</th>
														<th>Action</th>
													</tr>
												</thead>
												<tbody>
													<?php
													foreach ($students as $student) { ?>
														<tr>
															<td><?php echo $student['name']; ?></td>
															<td><?php echo $student['email']; ?></td>
															<td> <?php echo date('d-M-Y H:i', strtotime($student['created_at'])); ?></td>
															<td>
																<a href="./edit_student.php?id=<?php echo $student['id']; ?>" class="btn btn-info">Edit</a>
																<button type="button" class="btn btn-danger" onclick="deleteStudent(<?php echo $student['id']; ?>)" data-bs-toggle="modal" data-bs-target="#deleteStudent">
																	Delete
																</button>
															</td>
														</tr>
													<?php
													}
													?>

												</tbody>
											</table>
										</div>
									<?php
									} else { ?>
										<div class="row">
											<div class="col-auto mx-auto">
												<div class="alert alert-danger" role="alert">
													No student found!
												</div>
											</div>
										</div>
									<?php
									}
									?>

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

	<script>
		function deleteStudent(id) {
			const btnDelete = document.getElementById('btn-delete');
			btnDelete.setAttribute('href', './delete_student.php?id=' + id);
		}
	</script>


</body>

</html>