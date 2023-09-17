<?php



$connect = mysqli_connect('localhost', 'root', '1234', 'formulario');

$empleados_SoporteTecnico= array("Jaime Rubiano", "Maria Garcia", "Pedro Sanchez", "Arley Ramirez");

$empleados_AtencionalCliente= array("Jaime Raul", "Maira Garcia", "Raul Sanchez", "Andrey Ramirez");

$empleados_Facturacion= array("Jairo Rubiano", "Maria Gracia", "Pedro Diaz", "Arley Sanchez");

$array_Todos = array_merge($empleados_SoporteTecnico,$empleados_AtencionalCliente,$empleados_Facturacion);
$empleado_escogidorandonomicamente =$array_Todos[array_rand($array_Todos, 1)];

$nombreEmpleado = isset( $_POST['nombreEmpleado'] ) ? $_POST['nombreEmpleado'] : '';
$email = isset( $_POST['email'] ) ? $_POST['email'] : '';
$message = isset( $_POST['message'] ) ? $_POST['message'] : '';
$Departamento = isset( $_POST['Departamento'] ) ? $_POST['Departamento'] : '';
// $Empleado_Departamento = isset( $_POST['Empleado_Departamento'] ) ? $_POST['message'] : '';

$email_error = '';
$message_error = '';
$nombreEmpleado_error = '';

if (count($_POST))
{ 
    $errors = 0;

    if ($_POST['email'] == '')
    {
        $email_error = 'Please enter an email address';
        $errors ++;
    }

    if ($_POST['message'] == '')
    {
        $message_error = 'Please enter a message';
        $errors ++;
    }
    if ($_POST['nombreEmpleado'] == '')
    {
        $nombreEmpleado_error = 'Please enter a message';
        $errors ++;
    }


    if ($errors == 0)
    {

        $query = 'INSERT INTO contact (
                email,
                message,
                nombreEmpleado,
                Departamento,
                Empleado_Departamento
            ) VALUES (
                "'.addslashes($_POST['email']).'",
                "'.addslashes($_POST['message']).'"
                "'.addslashes($_POST['nombreEmpleado']).'"
                "'.addslashes($_POST['Departamento']).'"
                "'.($empleado_escogidorandonomicamente).'"
                
                
            )';
        mysqli_query($connect, $query);

        $message = 'You have received a contact form submission:
            
Email: '.$_POST['email'].'
Message: '.$_POST['email'].'
nombreEmpleado: '.$_POST['nombreEmpleado'].'
Departamento: '.$_POST['Departamento'];

        mail( 'poveda.geovanny@hotmail.com', 
            'Contact Form Cubmission',
            $message );

        header('Location: thankyou.html');
        die();

    }
}

?>
<!doctype html>
<html>
    <head>
        <title>PHP Contact Form</title>
    </head>
    <body>
    
        <h1>PHP Contact Form</h1>

        <form method="post" action="">
        <label for="nombre">
                    <span>Ingresa tu nombre</span>
                    <br>
                    <input type="text" name="nombreEmpleado"  placeholder="Ingresa tu nombre" autocomplete="name" value="<?php echo $nombreEmpleado;?>"/> 
                    <?php echo $nombreEmpleado_error;?>
                    </label> 
               <br><br>
        
            Email Address:
            <br>
            <input type="text" name="email" value="<?php echo $email; ?>">
            <?php echo $email_error; ?>

            <br><br>

            Message:
            <br>
            <textarea name="message"><?php echo $message; ?></textarea>
            <?php echo $message_error; ?>

            <br><br>

            <label for="departamento">
                    <span>¿Cual es el departamento a consultar?</span>
                    <br>
                    <!-- <input list="Departamentos" name="Departamento" id="Departamento" placeholder="Ingresa el departamento" autocomplete="country" required/>  -->
                    <select name="Departamento">
                        <option value="AtencionalCliente">Atencion al Cliente</option>
                        <option value="SoporteTecnico">Soporte Tecnico</option>
                        <option value="Facturacion">Facturacion</option>
                    </select>
                    </label> 
                   
                    <br><br>

            <input type="submit" value="Submit">
        
        </form>
    
    </body>
</html>