
<nav>
  <div class="container">
    <ul>
      <?php 
switch ($_SESSION['rol']) {
    case "admin":?>
      <a href="index.php">
      <li class="lin <?php if($nav==10){echo ' li-off';} ?>" >Solicitudes</li>
      </a> <a href="log.php">
      <li class="lin <?php if($nav==11){echo ' li-off';} ?>">Log</li>
      </a>
      <div class="dropdown " style="float:left">
        <li class="lin <?php if($nav==12){echo ' li-off';} ?> dropdown-toggle" data-toggle="dropdown" aria-expanded="true"> Gestion &nbsp; <span class="caret"></span> </li>
        
        <ul class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
          <li role="presentation"><a role="menuitem" tabindex="-1" href="cruds.php?tab=ficha">Fichas</a></li>
          <li role="presentation"><a role="menuitem" tabindex="-1" href="cruds.php?tab=usuario">Usuarios</a></li>
          <li role="presentation" class="divider"></li>
          <li role="presentation"><a role="menuitem" tabindex="-1" href="cruds.php?tab=prueba">Pruebas</a></li>
          <li role="presentation"><a role="menuitem" tabindex="-1" href="cruds.php?tab=pregunta">Pregunta</a></li>
          <li role="presentation" class="divider"></li>
          <li role="presentation"><a role="menuitem" tabindex="-1" href="cruds.php?tab=centroFormacion">Centro de Formacion</a></li>
          <li role="presentation"><a role="menuitem" tabindex="-1" href="cruds.php?tab=institucion">Instituciones Educativas</a></li>
          <li role="presentation"><a role="menuitem" tabindex="-1" href="cruds.php?tab=sede">Instituciones Sedes</a></li>
          <li role="presentation"><a role="menuitem" tabindex="-1" href="cruds.php?tab=municipio">Municipios</a></li>
          <li role="presentation"><a role="menuitem" tabindex="-1" href="cruds.php?tab=auxiliar">Tablas Auxiliares</a></li>

        </ul>
        
      </div>
      <?php break;
     case "instructor":?>
      <a href="index.php">
      <li class="lin <?php if($nav==10){echo ' li-off';} ?>" >Pruebas</li>
      </a> <a href="pregunta.php">
      <li class="lin <?php if($nav==21){echo ' li-off';} ?>" >Preguntas</li>
      </a> <a href="contexto.php">
      <li class="lin <?php if($nav==22){echo ' li-off';} ?>" >Contextos</li>
      </a> <a href="consultarAprendices.php">
      <li class="lin <?php if($nav==23){echo ' li-off';} ?>" >Aprendices</li>
      </a> <a href="consultarFichas.php">
      <li class="lin <?php if($nav==24){echo ' li-off';} ?>" >Fichas</li>
      </a>
      <?php break;
      case "aprendiz":?>
	  <a href="index.php">
      <li class="lin <?php if($nav==10){echo ' li-off';} ?>" >Pruebas</li>
      </a>
      <?php break;
      case "consultor":?>
      <a href="index.php">
      <li class="lin <?php if($nav==10){echo ' li-off';} ?>"> Pruebas</li>
      </a> 
      <a href="consultarInstructores.php">
      <li class="lin <?php if($nav==31){echo ' li-off';} ?>"> Instructores</li>
      </a> 
      <a href="consultarAprendices.php">
      <li class="lin <?php if($nav==23){echo ' li-off';} ?>"> Aprendices</li>
      </a> <a href="consultarFichas.php">
      <li class="lin <?php if($nav==24){echo ' li-off';} ?>" >Fichas</li>
      </a>
      <?php break;
 
}

 ?>
    </ul>
  </div>
  </div>
</nav>
