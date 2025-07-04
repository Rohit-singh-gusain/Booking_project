    </div>
</div>
    <footer class="footer text-center">
        <br>
        <div><img src="images/logo-small.png"></div>
        <a href="https://www.linkedin.com/in/chbandis/" target="_blank"></a> - dbuu college 
    </footer>

<script> //Javascript for sticky header to work properly
    window.onscroll = function() {myFunction()};

    var header = document.getElementById("header");
    var sticky = header.offsetTop;

    function myFunction() {
    if (window.pageYOffset > sticky) {
        header.classList.add("sticky");
    } else {
        header.classList.remove("sticky");
    }
    }
</script>
<?php 
$db->close(); //End the connection to the database
?>
</body>    
</html>
