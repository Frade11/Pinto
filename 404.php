<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>404 Not Found</title>
  <style>
    body {
      margin: 0;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      background: linear-gradient(135deg, #1e1e1e 0%, #252525 50%, #2d2d2d 100%);
      font-family: Arial, sans-serif;
      color: #fff;
      overflow: hidden;
    }

    .error-container {
      text-align: center;
      padding: 40px;
      background: #2a2a2a;
      border-radius: 20px;
      box-shadow: 0 8px 25px rgba(0,0,0,0.6);
      max-width: 500px;
      width: 90%;
    }

    .error-code {
      font-size: 120px;
      font-weight: bold;
      color: #e60023;
    }

    .error-message {
      font-size: 28px;
      margin: 20px 0;
      color: #fff;
    }

    .error-description {
      font-size: 16px;
      color: #aaa;
      margin-bottom: 30px;
    }

    .home-btn {
      display: inline-block;
      padding: 12px 28px;
      background: linear-gradient(135deg, #5b5bff, #9b6bff);
      color: #fff;
      text-decoration: none;
      font-weight: 500;
      border-radius: 25px;
      transition: all 0.3s ease;
    }

    .home-btn:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 14px rgba(91, 91, 255, 0.4);
      background: linear-gradient(135deg, #4747ff, #b394ff);
    }
    .error-container img{
        width: 200px;
    }

    @media (max-width: 600px) {
      .error-code {
        font-size: 80px;
      }
      .error-message {
        font-size: 22px;
      }
      .error-description {
        font-size: 14px;
      }
    }
  </style>
</head>
<body>
  <div class="error-container">
    <div class="error-code">404</div>
    <img src="/Pinto/assets/images/404bg.png" alt="">
    <div class="error-message">Page Not Found</div>
    <div class="error-description">
      Sorry, the page you are looking for doesn't exist.<br>
      It might have been removed or the URL is incorrect.
    </div>
   <a href="/Pinto/pages/home.php" class="home-btn">Go Home</a>
  </div>
</body>
</html>
