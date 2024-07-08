<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>
  <meta charset="<?php bloginfo('charset'); ?>">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php wp_title(); ?></title>
  <?php wp_head(); ?>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body <?php body_class(); ?>>

  <nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container">
      <a class="navbar-brand" href="<?php echo esc_url(home_url('/')); ?>">Eventos</a>

      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav mr-auto">
        </ul>

        <?php if (is_user_logged_in()) : ?>
          <a href="<?php echo esc_url(home_url('wp-admin/post-new.php?post_type=evento')); ?>" class="btn btn-primary mr-2">Criar Evento</a>
        <?php else : ?>
          <a href="<?php echo esc_url(wp_registration_url()); ?>" class="btn btn-primary mr-2">Criar Conta</a>
        <?php endif; ?>
      </div>
      <?php if (!is_user_logged_in()) : ?>
        <a href="<?php echo esc_url(wp_login_url()); ?>" class="btn btn-primary ml-2">Entrar</a>
      <?php endif; ?>
    </div>
  </nav>

  <div class="container mt-5">
    <?php if (is_page('login')) : ?>
      <div class="row justify-content-center">
        <div class="col-md-6">
          <h2 class="text-center mb-4">Login</h2>
          <?php wp_login_form(); ?>
          <p class="mt-3">Não tem uma conta? <a href="<?php echo esc_url(wp_registration_url()); ?>">Registre-se</a></p>
        </div>
      </div>
    <?php endif; ?>
  </div>

  <?php wp_footer(); ?>
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>

</html>