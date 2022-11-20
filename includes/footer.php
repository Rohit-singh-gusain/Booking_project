    </div>
</div>
    <footer class="footer text-center">
        <br>
        <div><img src="images/logo-small.png"></div>
        <a href="https://www.linkedin.com/in/chbandis/" target="_blank">Christos Bandis</a> - Metropolitan College 2021 
    </footer>

<script> //Javascript για τη σωστή λειτουργία του sticky header
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
$db->close(); //Τερματισμός της σύνδεσης με τη βάση
?>
</body>    
</html>