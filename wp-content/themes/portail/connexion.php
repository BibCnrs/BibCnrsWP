<?php
/*Template Name: Connexion*/
?>
<!doctype html>
<html dir="ltr" lang="fr">

<!-- begin head -->
<head>
	<title>Service d'authentification de l'Inist-CNRS</title>
	<link rel="stylesheet" media="all" href="<?php bloginfo('template_url'); ?>/style.css" type="text/css">
</head>

<body>
<?php
//$recherche=$_GET["recherche"];
?>

  <div id="login">
      <div id="form">
          <h1>Connexion s&eacute;curis&eacute;e</h1>
          <img id="keyicon" src="<?php bloginfo('template_url'); ?>/images/cas/key.png" alt="" />
          <form id="form" class="fm-v clearfix" action="<?php bloginfo('url')?>/search/" method="post">

              <ul>
                  <li class="input">
                      <label>Identifiant :<br/>
                      <input id="username" name="username" class="required" tabindex="1" type="text" value="" size="25"/>
                      </label>
                  </li>
                  <li class="input">
                      <label>Mot de passe :<br/>
                      <input id="password" name="password" class="required" tabindex="2" type="password" value="" size="25"/>
                      </label>
                  </li>
                  <li>
                      <input type="hidden" name="recherche" value="<?php echo $_POST["recherche"]; ?>" />
                      <input type="submit" name="submit" value="Se connecter" />
                      <p class="help-container">
                        <a href="help.html" rel="help.html" class="help"><img src="<?php bloginfo('template_url'); ?>/images/cas/aide.gif" alt=""> Aide</a> -
                        <a href="help2.html" rel="help2.html" class="help2">Aide portails</a>
                      </p>
                  </li>
              </ul>
          </form>
      </div>
 </div>
<div id="logo">
  <ul>
      <li><a href="http://www.inist.fr"><img src="<?php bloginfo('template_url'); ?>/images/cas/inist.png" alt="Inist-CNRS" /></a></li>
      <li><a href="http://www.cnrs.fr"><img src="<?php bloginfo('template_url'); ?>/images/cas/cnrs.png" alt="CNRS" /></a></li>
      <li><a href="http://www.inserm.fr"><img src="<?php bloginfo('template_url'); ?>/images/cas/inserm.png" alt="Inserm" /></a></li>
  </ul>
</div>



</body>
</html>
