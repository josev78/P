<head>
  <meta charset="utf-8">
  <title><?php echo $site_name; ?></title>
  <link rel="stylesheet" href="<?=$url_site?>css/estilo_menuvertical.css">
  <link rel="stylesheet" href="<?=$url_site?>img/style.css">
</head>
<form id="eliminarDatos" accept-charset="utf-8">
<div class="modal fade" id="dataDelete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <input type="hidden" id="id_pais" name="id_pais">
      <h2 class="text-center text-muted">Estas seguro?</h2>
	  <p class="lead text-muted text-center" style="display: block;margin:10px">Esta acción eliminará de forma permanente el registro. Deseas continuar?</p>
      <div class="modal-footer">
        <button type="button" class="btn btn-lg btn-default" data-dismiss="modal">Cancelar</button>
        <button type="submit" class="btn btn-lg btn-primary">Aceptar</button>
      </div>
    </div>
  </div>
</div>
</form>