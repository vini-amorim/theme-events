<?php get_header(); ?>

<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-8">
      <?php while (have_posts()) : the_post(); ?>
        <article id="post-<?php the_ID(); ?>" <?php post_class('card mb-4'); ?>>
          <header class="entry-header card-header bg-light">
            <h1 class="entry-title text-center"><?php the_title(); ?></h1>
          </header>

          <div class="card-body">
            <?php
            $data_e_horario = get_field('data_e_horario');
            $responsavel = get_field('responsavel');
            $telefone = get_field('telefone');
            $localizacao = get_field('localizacao');
            $endereco = $localizacao['endereco'];
            $numero = $localizacao['numero'];
            $cidade = $localizacao['cidade'];
            $estado = $localizacao['estado'];
            $complemento = $localizacao['complemento'];

            if ($data_e_horario) {
              echo '<p class="card-text"><strong>Data e Horário:</strong> ' . date('d/m/Y g:i a', strtotime($data_e_horario)) . '</p>';
            }

            if ($responsavel) {
              echo '<p class="card-text"><strong>Responsável:</strong> ' . $responsavel . '</p>';
            }

            if ($telefone) {
              echo '<p class="card-text"><strong>Telefone:</strong> ' . $telefone . '</p>';
            }

            if ($localizacao) {
              echo '<p class="card-text"><strong>Endereço:</strong> ' . $endereco . ', ' . $numero . ' - ' . $complemento . '</p>';
              echo '<p class="card-text"><strong>Cidade/Estado:</strong> ' . $cidade . ', ' . $estado . '</p>';
            }
            ?>

            <hr>

            <div>
              <?php the_content(); ?>
            </div>
          </div>

          <footer class="entry-footer card-footer">
            <?php
            if (current_user_can('administrator')) {
              $edit_post_url = get_edit_post_link();
              $delete_post_url = get_delete_post_link(get_the_ID(), '', true);

              echo '<hr>';
              echo '<div class="text-right">';
              echo '<a href="' . esc_url($edit_post_url) . '" class="btn btn-primary mr-2">Editar</a>';
              echo '</div>';
            }
            ?>
          </footer>
        </article>
      <?php endwhile; ?>
    </div>
  </div>
</div>

<?php
if (isset($_GET['delete_event']) && $_GET['delete_event'] == 'true') {
  $redirect_url = get_post_type_archive_link('evento');
  wp_redirect($redirect_url);
  exit;
}
?>

<?php get_footer(); ?>