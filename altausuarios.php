<?php
$nombre = "";
$email = "";
$pass = "";
$tipo = "";
if (isset($_POST['altaUser'])) {
    $nombre = $_POST['nombre_usuario'];
    $email = $_POST['email_usuario'];
    $pass = $_POST['pass_usuario'];
    $tipo = $_POST['tipo_usuario'];
    $usuario = new Usuario();
    $usuario->set($_POST);
    $error = $usuario->error;
    $msg = $usuario->msg;
}

?>

<form action="index.php?p=au" method="POST" enctype="multipart/form-data" name="formAltaUsuario">

    <table class="tabla">
        <tr>
            <td class="tabla"><label>Nombre:</label></td>
            <td><input type="text" name="nombre_usuario" maxlength="30" size="40" /></td>
        </tr>
        <tr>
            <td class="tabla"><label>E-mail:</label></td>
            <td><input type="text" name="email_usuario" maxlength="30" size="40" /></td>
        </tr>
        <tr>
            <td class="tabla"><label>Contraseña:</label></td>
            <td><input type="text" name="pass_usuario" size="40" maxlength="30" /></td>
        </tr>
        <tr>
            <td class="tabla"><label>Tipo:</label></td>
            <td><select name="tipo_usuario" id="tipo_usuario">
                    <option value="adm">Administrador</option>
                    <option value="col">Colaborador</option>
                    <option value="usr">Usuario</option>
                </select></td>
        </tr>
        <tr>
            <td class="boton" colspan="2">
                <input type="submit" value="Alta Usuario" name="altaUser" />
            </td>
        </tr>
    </table>

</form>