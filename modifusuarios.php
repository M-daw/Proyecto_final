<?php
$usuario = new Usuario();
$usuario->get($_GET['m']);
$id = $usuario->id_usuario;
$nombre = $usuario->nombre_usuario;
$email = $usuario->email_usuario;
$pass = $usuario->pass_usuario;
$tipo = $usuario->tipo_usuario;

?>
<form action="index.php?p=gu" method="POST" enctype="multipart/form-data" name="formModiusuario">

    <input type="hidden" name="id_usuario" maxlength="10" size="40" <?php if (isset($id)) {
                                                                        echo "value='$id'";
                                                                    } ?> /></td>
    <table class="tabla">
        <tr>
            <td class="tabla"><label>Nombre:</label></td>
            <td><input type="text" name="nombre_usuario" maxlength="10" size="40" <?php if (isset($nombre)) {
                                                                                        echo "value='$nombre'";
                                                                                    } ?> /></td>
        </tr>
        <tr>
            <td class="tabla"><label>E-mail</label></td>
            <td><input type="text" name="email_usuario" maxlength="40" size="40" <?php if (isset($email)) {
                                                                                        echo "value='$email'";
                                                                                    } ?> /></td>
        </tr>
        <tr>
            <td class="tabla"><label>Contraseña:</label></td>
            <td><input type="text" name="pass_usuario" size="40" maxlength="15" <?php if (isset($pass)) {
                                                                                    echo "value='$pass'";
                                                                                } ?> /></td>
        </tr>
        <tr>
            <td class="tabla"><label>Tipo:</label></td>
            <td><input type="text" name="tipo_usuario" size="40" maxlength="40" <?php if (isset($tipo)) {
                                                                                    echo "value='$tipo'";
                                                                                } ?> /></td>
        </tr>
        <tr>
            <td class="boton" colspan="2">
                <input type="submit" value="Modificar Usuario" name="modifUser" />
            </td>
        </tr>
    </table>

</form>