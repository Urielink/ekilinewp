<?php
/**
 * Template Name: Contacto
 * 
 * Esta pagina de contacto, utiliza el motor de wp por default.
 * Solo se debe elegir el template.
 * El texto en la edicion aparece de manera independiente al formulario.
 * 
 * @package ekiline
 */

  //response generation function

  $response = "";

  //function to generate response
  function my_contact_form_generate_response($type, $message){

    global $response;

    if($type == "success") $response = "<div class='alert alert-success alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>x</span></button>{$message}</div>";
    else $response = "<div class='alert alert-danger alert-dismissible'><button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>x</span></button>{$message}</div>";

  }

  //response messages
  $not_human       = "Verificacion incorrecta. Intentalo nuevamente";
  $missing_content = "Por favor incluye toda la informacion solicitada en los campos.";
  $email_invalid   = "Correo electronico invalido.";
  $message_unsent  = "El mensaje no se ha enviado. Por favor intentalo nuevamente.";
  $message_sent    = "Gracias! tu mensaje se envio con exito.";

  //user posted variables
  $name = $_POST['message_name'];
  $email = $_POST['message_email'];
  $message = $_POST['message_text'];
  $empresa = $_POST['message_empresa'];
  $telefono = $_POST['message_telefono'];
  $human = $_POST['message_human'];
    
  //php mailer variables
  $to = get_option('admin_email');
  $subject = "Mensaje de contacto desde ".get_bloginfo('name');
  $headers = 'From: '. $email . "\r\n" .
    'Reply-To: ' . $email . "\r\n";

  if(!$human == 0){
    if($human != 5) my_contact_form_generate_response("error", $not_human); //not human!
    else {

      //validate email
      if(!filter_var($email, FILTER_VALIDATE_EMAIL))
        my_contact_form_generate_response("error", $email_invalid);
      else //email is valid
      {
        //validate presence of name and message
        if(empty($name) || empty($message) || empty($empresa) || empty($telefono)){
          my_contact_form_generate_response("error", $missing_content);
        }
        else //ready to go!
        {
          $sent = wp_mail($to, $subject, strip_tags('Nombre: '.$name."\n\n".'Empresa: '.$empresa."\n\n".'Telefono: '.$telefono."\n\n".'E-mail: '.$email."\n\n".'Mensaje:'."\n".$message), $headers);
          if($sent) my_contact_form_generate_response("success", $message_sent); //message sent!
          else my_contact_form_generate_response("error", $message_unsent); //message wasn't sent
        }
      }
    }
  }
  else if ($_POST['submitted']) my_contact_form_generate_response("error", $missing_content);

?>

<?php get_header(); ?>

    <div id="primary" class="content-area col-md-7 col-md-offset-1 <?php //sideOn(); ?>">
        <main id="main" class="site-main" role="main">


      <?php while ( have_posts() ) : the_post(); ?>

          <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

            <header class="entry-header">
              <h1 class="entry-title"><?php the_title(); ?></h1>
            </header>

            <div class="entry-content">
              <?php the_content(); ?>
            </div><!-- .entry-content -->
              
            
          </article><!-- #post -->

      <?php endwhile; // end of the loop. ?>
      
        </main><!-- #main -->
    </div><!-- #primary -->


              <div id="respond" class="widget-area col-md-3" role="complementary">
                <div class="panel panel-default formulario">
                    <div class="panel-heading">
                        <h4>Ingresa tus datos</h4>
                    </div>
                    <div class="panel-body">
                    <?php echo $response; ?>
                    <form action="<?php the_permalink(); ?>" method="post" role="form">
                      <div class="form-group">
                        <label for="name">Nombre: <span>*</span></label>
                        <input class="form-control" type="text" name="message_name" value="<?php echo esc_attr($_POST['message_name']); ?>">
                      </div>
                      <div class="form-group">
                        <label for="empresa">Empresa: <span>*</span></label>
                        <input class="form-control" type="text" name="message_empresa" value="<?php echo esc_attr($_POST['message_empresa']); ?>">
                      </div>                  
                      <div class="form-group">
                        <label for="message_email">E-mail: <span>*</span></label>
                        <input class="form-control" type="text" name="message_email" value="<?php echo esc_attr($_POST['message_email']); ?>">
                      </div>
                      <div class="form-group">
                        <label for="telefono">Telefono: <span>*</span></label>
                        <input class="form-control" type="text" name="message_telefono" value="<?php echo esc_attr($_POST['message_telefono']); ?>">
                      </div>                  
                      <div class="form-group">
                        <label for="message_text">Mensaje: <span>*</span></label>
                        <textarea class="form-control" type="text" name="message_text"><?php echo esc_textarea($_POST['message_text']); ?></textarea>
                      </div>
                      <div class="form-group row">
                        <label class="control-label col-sm-12" for="message_human">Realiza esta suma:<span>*</span></label>
                        <div class="col-xs-5 text-right"><p class="lead">2 + 3 =</p></div>
                        <div class="col-xs-6">
                            <input class="form-control" type="text" name="message_human">
                        </div>
                      </div>
                      <input type="hidden" name="submitted" value="1">
                      <div class="form-group">
                            <!-- input type="submit" class="btn btn-info btn-lg"-->
                            <button type="submit" class="btn btn-info btn-lg btn-block">Contactar</button>
                      </div>
                    </form>
                    </div>
                </div>                
              </div>
                    

<?php //get_sidebar(); ?>
<?php get_footer(); ?>