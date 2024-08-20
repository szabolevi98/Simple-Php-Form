<?php /** @var FormHandler $formHandler */ ?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Contact Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .form-container {
            max-width: 800px;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container form-container p-4 mt-5 bg-white shadow rounded">
        <h1 class="fw-light mb-3">Contact Us</h1>
        <?php if ($formHandler->getSuccessMessage()): ?>
            <div class="alert alert-success"><?php echo $formHandler->getSuccessMessage(); ?></div>
        <?php elseif ($formHandler->getErrorMessage()): ?>
            <div class="alert alert-danger"><?php echo $formHandler->getErrorMessage(); ?></div>
        <?php endif; ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-floating mb-3">
                <input type="text" placeholder="Your name" class="form-control <?php echo $formHandler->getNameError() ? 'is-invalid' : ''; ?>" id="name" name="name" value="<?php echo $formHandler->getName() ? htmlspecialchars($formHandler->getName()) : ''; ?>" minlength="2" maxlength="100" required>
                <label for="name">Name</label>
                <div class="invalid-feedback"><?php echo $formHandler->getNameError() ?? ""; ?></div>
            </div>
            <div class="form-floating mb-3">
                <input type="email" placeholder="Your email" class="form-control <?php echo $formHandler->getEmailError() ? 'is-invalid' : ''; ?>" id="email" name="email" value="<?php echo $formHandler->getEmail() ? htmlspecialchars($formHandler->getEmail()) : ''; ?>" maxlength="255" required>
                <label for="email">Email address</label>
                <div class="invalid-feedback"><?php echo $formHandler->getEmailError() ?? ""; ?></div>
            </div>
            <div class="form-floating mb-3">
                <input type="text" placeholder="your phone" class="form-control <?php echo $formHandler->getPhoneError() ? 'is-invalid' : ''; ?>" id="phone" name="phone" value="<?php echo $formHandler->getPhone() ? htmlspecialchars($formHandler->getPhone()) : ''; ?>" minlength="7" maxlength="15" required>
                <label for="phone">Phone number</label>
                <div class="invalid-feedback"><?php echo $formHandler->getPhoneError() ?? ""; ?></div>
            </div>
            <div class="form mb-3">
                <label for="message" class="d-none">Message</label>
                <textarea placeholder="Type your message" class="form-control <?php echo $formHandler->getMessageError() ? 'is-invalid' : ''; ?>" id="message" name="message" minlength="10" maxlength="1000" rows="3" required><?php echo $formHandler->getMessage() ? htmlspecialchars($formHandler->getMessage()) : ''; ?></textarea>
                <div class="invalid-feedback"><?php echo $formHandler->getMessageError() ?? ""; ?></div>
            </div>
            <button type="submit" class="btn btn-primary px-3">Send</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
