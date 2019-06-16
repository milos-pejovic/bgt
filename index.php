<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
</head>
<body>
<header>

</header>
    
<main>
    <h2 class="no-users">No users found.</h2>
    
    <table border="1px" cellpadding="5" class="all-users">
    </table>
    
    <form class="signup-form">
        <label>
            <p>First name</p>
            <input type="text" name="first-name" />
        </label>
        
        <label>
            <p>Last name</p>
            <input type="text" name="last-name" />
        </label>
        
        <label>
            <p>Image</p>
            <input type="file" name="image" />
        </label>
        
        <br /><br />
        
        <input type="submit" value="Submit" />
    </form>
    
    <div class="errorsWrapper">
        <ul class="errors">
        
        </ul>
    </div>
    
    <button class="dw">Download CSV list of users.</button>
    
</main>    
    
<footer>
    <script src="js/main.js"></script>
</footer>
    
</body>
</html>
