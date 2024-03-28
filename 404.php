<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?= lang('Errors.pageNotFound') ?></title>

    <style>
        body {
            height: 100%;
            background: #f5f5f5;
            font-family: Arial, sans-serif;
            color: #444;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            text-align: center;
        }
        .logo {
            margin-bottom: 20px;
        }
        h1 {
            font-size: 3em;
            font-weight: bold;
            color: #dd4814;
            margin: 0;
        }
        p {
            font-size: 1.2em;
            margin-top: 20px;
            color: #666;
        }
        .footer {
            margin-top: 50px;
            font-size: 0.8em;
            color: #888;
        }
        a:active, a:link, a:visited {
            color: #dd4814;
        }
    </style>
</head>
<body style="background-color: #f9f9f9; font-family: Arial, sans-serif;">

    <div class="container" style="max-width: 600px; margin: 0 auto; padding: 50px; text-align: center; background-color: #fff; border-radius: 10px; box-shadow: 0px 0px 20px rgba(0, 0, 0, 0.1);">
        <img class="logo" src="logo.png" alt="Logo" style="width: 100px; margin-bottom: 30px;">
        <h1 style="color: #333; font-size: 3em; margin: 0;">404 Not Found</h1>
        <p style="font-size: 1.2em; margin-top: 20px; color: #666;">
            <?php if (ENVIRONMENT !== 'production') : ?>
                <?= nl2br(esc($message)) ?>
            <?php else : ?>
                <?= lang('Errors.sorryCannotFind') ?>
            <?php endif; ?>
        </p>
        <p style="font-size: 1em; margin-top: 30px; color: #777;">Back to <a href="/" style="color: #dd4814; text-decoration: none;">Home</a></p>
        <div class="footer" style="margin-top: 50px; font-size: 0.8em; color: #888;">
            &copy; <?= date('Y') ?> Your Company. All rights reserved.
        </div>
    </div>

</body>
</html>
