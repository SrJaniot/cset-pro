<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sin título</title>
</head>

<body>
<!-- select input y boton *************************************************************************--> 
        <form action="controlador/validarInicioSesion.php" method="get">
          <div class="col-xs-3">
            <select class="form-control">
              <option>columna</option>
            </select>
          </div>
          <div class="col-xs-6">
            <div class="input-group input-group-lg">
              <input type="text" class="form-control" placeholder="buscar en la tabla...">
              <span class="input-group-btn">
              <button class="btn btn-default" type="button">Buscar</button>
              </span> </div>
          </div>
          <div class="col-xs-3">
            <button type="submit" class="botonStandar" style="float:right">
            <h4> &nbsp;&nbsp;Anadir&nbsp;&nbsp; </h4>
            </button>
          </div>
        </form>

<!-- barra lateral con botones *************************************************************************--> 


    <aside class="col-xs-3">
        <div class="lateral">
          <ul>
            <li>Fichas</li>
            </a> <a href="">
            <li>Usuarios</li>
            </a>
            <? //acceso a la tabla 'institucionUsuario' ?>
            <div class="separador"></div>
            <a href="">
            <li>Pruebas</li>
            </a>
            <? //acceso a las tablas 'pruebaPreguntas' y 'pruebausuarios' ?>
            <a href="">
            <li>Areas de Preguntas</li>
            </a> <a href="">
            <li>Preguntas</li>
            </a>
            <? //acceso a las tablas 'opciones' y 'contexto',?>
            <div class="separador"></div>
            <a href="">
            <li class="lateral-off">Centros de Formacion</li>
            </a> <a href=""> <a href="">
            <li>Intituciones</li>
            </a> <a href="">
            <li>Municipios</li>
            </a>
          </ul>
        </div>
      </aside>
</body>
</html>