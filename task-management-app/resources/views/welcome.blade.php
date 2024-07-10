<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2XXr2" crossorigin="anonymous">
    <!-- Font Awesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Task Management App</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:wght@300;400;600;700;800&family=Poppins:wght@300;400;500;600;700;800;900&family=Raleway:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
</head>
<style>
    * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

a {
    text-decoration: none;
}

a:hover {
    text-decoration: none;
}

h1, h2, h3, h4, h5, h6 {
    font-family: 'Raleway', sans-serif;
}

section {
    padding: 60px 0;
    overflow: hidden;
}

#hero {
    width: 100%;
    height: 100vh;
    background-image: url('https://img.freepik.com/free-vector/gradient-abstract-background-design_23-2149070220.jpg?t=st=1720579103~exp=1720582703~hmac=23d2773e45eb259516f4b1fc62d4848c2460d7228e0fb0a233b5ec51b6a68646&w=900');
    background-size: cover;
    background-repeat: no-repeat;
    background-position: center;
    display: flex;
    align-items: center;
    justify-content: center;
}

#hero .container{
    padding-top: 80px;
    text-align: center;
}

#hero h1{
    font-size: 48px;
    font-weight: 700;
    line-height:  56px;
    color: #fff;
    margin: 0 0 10px 0;
}

#hero h2{
    font-size: 15px;
    color: #eee;
    margin-bottom: 40px;
    font-weight: 400;
    font-family: 'Open Sans', sans-serif;
    letter-spacing: 0.5px;
    text-transform: uppercase;
    padding-left: 20%;
    padding-right: 20%;
    text-align: justify;
}

#hero .btn-get-started {
    font-family: 'Raleway', sans-serif;
    font-weight: 500;
    font-size: 14px;
    letter-spacing: 1px;
    display: inline-block;
    padding: 8px 28px;
    text-transform: uppercase;
    border-radius: 50px;
    margin: 10px;
    border:2px solid #fff;
    background-color: transparent;
    color: #fff;
    transition: 0.6s all;
    
}


#hero .btn-get-started:hover {
    background-color: #009970;
    border: 2px solid #009970;
}

.logo {
    max-width: 20%; /* Adjust the size as needed */
    background-color: transparent;
}
</style>
<body>
    <section id="hero" class="d-flex align-items-center">
        <div class="container text-center">
            <img src="{{ asset('logo.png') }}" class="img-fluid logo" alt="Task Mind Logo">
            <h1>TaskMinder</h1>
            <h2>The ultimate task management app designed to help you stay organized, boost productivity, and achieve your goals effortlessly. Whether you're managing personal to-dos or coordinating team projects, TaskMinder provides the tools you need to streamline your workflow and keep everything on track.</h2>

            
                <a href="{{ route('login') }}" class="btn-get-started">Log in</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn-get-started">Register</a>
                @endif
              
        </div>
    </section>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH01sSSs5nCTpuj/zy4C+0GpamoFVy38MVBNE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MOK7ZeZDyx" crossorigin="anonymous"></script>
    <script type="text/javascript" src="script.js"></script>
</body>
</html>
