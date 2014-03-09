<div id="moteur">
    <script type="text/javascript">
        function send(motcle){
            var ajax = document.createElement("script");
            ajax.src = "ajax.php?motcle = "+motcle;
            ajax.type = "text/javascript";
            document.body.appendChild(ajax);
            document.body.removeChild(ajax);
        }
        
        function callback(motcle){
            alert(motcle);
        }
        
        function recupMotCle()
        {
            var motcle = document.getElementById('motcle');
            send(motcle.value);
        }
    </script>
    <h1>rechercher pièce</h1>
    <input id="motcle" type="text" name="motcle" onkeyup="recupMotCle()" />
</div>