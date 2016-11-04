<?php

define('TITLE','Post Único');

include('includes/navbar.php');

if(isset($_GET['id'])) {
  $id = $_GET['id'];
} else {
  echo "<script>location.href='index.php'</script>";
}

$sql = "SELECT * FROM tb_postagens WHERE id=:id";

try {
$stmt = $PDO->prepare($sql);
$stmt->bindParam(':id',$id, PDO::PARAM_INT);
$stmt->execute();
} catch(PDOException $erro) {
    echo $erro;
}

while ($postagem = $stmt->fetch(PDO::FETCH_ASSOC)) {
       $id = $postagem["id"];
       $titulo = $postagem["titulo"];
       $imagem = $postagem["imagem"];
       $conteudo = $postagem["conteudo"];
    }

?>
<div class="container">
<div class="post-unico" style="margin-top:100px;">
  <div class="col-md-8">
    <div class="thumbnail">
      <h1 class="text-center main-title"><?php echo $titulo; ?></h1>
      <img src="upload/postagens/<?php echo $imagem; ?>" alt="">
      <div class="caption">

        <p><?php echo $conteudo; ?></p>
      </div>
    </div>
    <br>
    <hr>
    <br>
    <div id="disqus_thread"></div>
    <script>
        /**
         *  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
         *  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables */

        var disqus_config = function () {
            this.page.url = 'http://jediazzidev.tk/postagem.php?id=<?php echo $id; ?>';
            this.page.identifier = 'http://jediazzidev.tk/postagem.php?id=<?php echo $id; ?>';
        };

        (function () { // DON'T EDIT BELOW THIS LINE
            var d = document,
                s = d.createElement('script');
            s.src = '//jediazzi.disqus.com/embed.js';
            s.setAttribute('data-timestamp', +new Date());
            (d.head || d.body).appendChild(s);
        })();
    </script>
    <noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>
  </div>
</div>

<?php

  include ("includes/sidebar.php");

  include ("includes/footer.php");

?>
