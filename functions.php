<?php
function load_bootstrap()
{
  wp_enqueue_style('bootstrap-css', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css');
  wp_enqueue_script('bootstrap-js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js', array('jquery'), null, true);
}
add_action('wp_enqueue_scripts', 'load_bootstrap');



add_action('admin_post_create_event', 'create_event_callback');
add_action('admin_post_nopriv_create_event', 'create_event_callback');
add_action('admin_post_submit_event_form', 'handle_submit_event_form');
add_action('admin_post_nopriv_submit_event_form', 'handle_submit_event_form');

function handle_submit_event_form()
{
  $event_data = array(
    'post_title' => sanitize_text_field($_POST['event_title']),
    'post_content' => '',
    'post_status' => 'publish',
    'post_type' => 'evento'
  );

  $event_id = wp_insert_post($event_data);

  if ($event_id) {
    update_field('event_descricao', sanitize_text_field($_POST['event_descricao']), $event_id);
    update_field('data_e_horario', sanitize_text_field($_POST['data_e_horario']), $event_id);
    update_field('responsavel', sanitize_text_field($_POST['responsavel']), $event_id);
    update_field('telefone', sanitize_text_field($_POST['telefone']), $event_id);
    update_field('localizacao', array(
      'endereco' => sanitize_text_field($_POST['endereco']),
      'cidade' => sanitize_text_field($_POST['cidade']),
      'estado' => sanitize_text_field($_POST['estado']),
    ), $event_id);

    wp_redirect(get_permalink($event_id));
    exit;
  }
}

// plugins
function check_required_plugins_on_theme_activation()
{
  if (!is_plugin_active('advanced-custom-fields-pro/acf.php') && current_user_can('activate_plugins')) {
    $install_url = wp_nonce_url(
      admin_url('update.php?action=install-plugin&plugin=advanced-custom-fields-pro'),
      'install-plugin_advanced-custom-fields-pro'
    );

    $message = sprintf(
      'O tema requer o plugin <strong>Advanced Custom Fields (ACF)</strong> para funcionar corretamente. <a href="wp-admin/update.php?action=install-plugin&plugin=advanced-custom-fields&_wpnonce=3348e29c27">Clique aqui</a> para instalar o plugin.',
      $install_url
    );

    // Exibe o aviso
    echo '<div class="notice notice-warning is-dismissible"><p>' . $message . '</p></div>';
  }
}
add_action('admin_notices', 'check_required_plugins_on_theme_activation');

// paginas
function create_eventos_page_on_activation()
{

  $page_title = 'Eventos';
  $page_check = get_page_by_title($page_title);

  if (!isset($page_check->ID)) {
    $page_content = '';

    $page = array(
      'post_title'   => $page_title,
      'post_content' => $page_content,
      'post_status'  => 'publish',
      'post_author'  => 1, // ID do autor (geralmente o administrador é 1)
      'post_type'    => 'page',
    );

    $page_id = wp_insert_post($page);

    if ($page_id && !is_wp_error($page_id)) {
      update_post_meta($page_id, '_wp_page_template', 'listagem-de-eventos.php');
    }
  }
}
add_action('after_switch_theme', 'create_eventos_page_on_activation');
