<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div>
        <div>
            <form action="" method="POST">
                <h2>Update password</h2>

				<div>
					<label for="currentPassword">Current password</label>
					<input type="password" name="currentPassword" id="currentPassword">
				</div>

                <div>
					<label for="password">New password</label>
					<input type="password" name="password" id="password">
				</div>

                <div>
					<label for="confirmPassword">Confirm new password</label>
					<input type="password" name="confirmPassword" id="confirmPassword">
				</div>

                <div class="form__field">
					<input type="submit" value="Update password">	
				</div>

            </form>
        </div>
    </div>
</body>
</html>