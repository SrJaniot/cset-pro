<header >
  <div id="loadingAjax"><center><nobr>
  <span class="glyphicon glyphicon-refresh"></span> &nbsp;<span id="loadingText">Cargando...</span></nobr></center></div>
  <div class="container">
    <div class="row">
      <div id="index1" class="col-xs-5 index "><a href="index.php"><img src="img/logoCP.png" alt="logo"></a></div>
      <div class="col-xs-7">
        <div class="dropdown">
          <div class="sesion dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="true">
            <div class="usuario"><?php echo $_SESSION['nombre']; ?></div>
            <div id="foto"><img src="img/fperfil/<?php echo $_SESSION['foto']; ?>" alt="foto">
              <div id="fotob"></div>
            </div>
            <div class="usuario"><?php echo $_SESSION['rol']; ?></div>
          </div>
          <ul class="dropdown-menu menu-derecha" role="menu" aria-labelledby="dropdownMenu1">
          
            <li role="presentation">
            <a role="menuitem" tabindex="-1" href="perfil.php">
            <span class="glyphicon glyphicon-user"></span> &nbsp;Perfil</a></li>
            
            <li role="presentation">
            <a role="menuitem" tabindex="-1" href="ayuda.php">
            <span class="glyphicon glyphicon-question-sign"></span> &nbsp;Ayuda</a></li>
            
            <li role="presentation">
            <a role="menuitem" tabindex="-1" href="controlador/cerrarSesion.php">
            <span class="glyphicon glyphicon-log-out"></span> &nbsp;Cerrar Sesion</a></li>
            
          </ul>
        </div>
      </div>
    </div>
  </div>
</header>
