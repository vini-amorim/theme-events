<?php

/**
 * Template Name: Listagem de Eventos
 */

get_header();
?>

<div class="container mt-5">
  <div class="row">
    <?php
    $events = new WP_Query(array(
      'post_type' => 'evento',
      'posts_per_page' => -1,
    ));

    if ($events->have_posts()) :
      while ($events->have_posts()) :
        $events->the_post();
        $event_id = get_the_ID();
        $event_title = get_the_title();
        $event_date_time = get_field('data_e_horario', $event_id);
        $event_date_time_formatted = date('d/m/Y H:i', strtotime($event_date_time));
        $event_responsavel = get_field('responsavel');
        $event_telefone = get_field('telefone', $event_id);
        $event_endereco = get_field('localizacao')['endereco'];
        $event_numero = get_field('localizacao')['numero'];
        $event_cidade = get_field('localizacao')['cidade'];
        $event_estado = get_field('localizacao')['estado'];
        $event_complemento = get_field('localizacao')['complemento'];
    ?>

        <div class="col-md-6 mb-4">
          <div class="card h-100">
            <div class="card-header bg-primary text-white">
              <h5 class="card-title"><?php echo esc_html($event_title); ?></h5>
            </div>
            <div class="card-body">
              <p><strong>Data e Horário:</strong> <?php echo esc_html($event_date_time_formatted); ?></p>
              <p><strong>Responsável:</strong> <?php echo esc_html($event_responsavel); ?></p>
              <p><strong>Telefone:</strong> <?php echo esc_html($event_telefone); ?></p>
              <p><strong>Localização:</strong><br>
                <?php echo esc_html($event_endereco); ?><?php echo esc_html($event_numero); ?><br>
                <?php echo esc_html($event_cidade); ?> - <?php echo esc_html($event_estado); ?><br>
                <?php echo esc_html($event_complemento); ?>
              </p>
            </div>
            <div class="card-footer">
              <a href="<?php the_permalink(); ?>" class="btn btn-primary btn-sm">Ver Detalhes</a>
            </div>
          </div>
        </div>

    <?php
      endwhile;
      wp_reset_postdata();
    else :
      echo '<p class="text-center">Nenhum evento encontrado.</p>';
    endif;
    ?>
  </div>
</div>

<?php
get_footer();
?>