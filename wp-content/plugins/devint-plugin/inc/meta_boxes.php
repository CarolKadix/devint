<?php
/**
 * ==================================================
 * META BOXES CONFIGURAÇÂO ==========================
 * ==================================================
 * 
 */
add_action( 'admin_init', 'my_meta_boxes' );
function my_meta_boxes(){
	$meta_boxes = array();
	
	/**
	 * EVENTOS
	 * 
	 */
	$meta_boxes['events_box'] = array(
		'id' => 'events_box', 
		'title' => 'Detalhes do Evento', 
		'post_type' => array('evento'), 
		'context' => 'normal', 
		'priority' => 'default',
		'itens' => array(
			array(
				'name' => 'event_excerpt',
				'type' => 'textarea',
				'label' => 'Descrição curta',
				'label_helper' => 'Será usada no popup do calendário',
				'attr' => array('class' => 'ipth_tiny'),
			),
		)
	);
	$meta_boxes['events_box2'] = array(
		'id' => 'events_box2', 
		'title' => 'Data do Evento', 
		'post_type' => array('evento'), 
		'context' => 'normal', 
		'priority' => 'default',
		'itens' => array(
			array(
				'name' => 'event_date_string',
				'type' => 'textarea',
				'label' => 'Data por extenso',
				'size' => 'full',
				'attr' => array('class' => 'ipth_tiny'),
				'input_helper' => '<br />ex: 27 de novembro, das 10 às 17h, última semana de abril, último final de semana de julho',
			),
			array(
				'name' => 'event_date',
				'type' => 'date_picker',
				'label' => 'Data',
				'options' => array(
					'date_format' => 'dd/mm/yy',
					'picker_type' => 'datetime',
					'split_time' => true,
					'date_range' => true,
				),
				'callbacks' => array(
					'devint_save_event_date',
				),
			),
		)
	);
	$meta_boxes['events_box3'] = array(
		'id' => 'events_box3', 
		'title' => 'Local do Evento', 
		'post_type' => array('evento'), 
		'context' => 'normal', 
		'priority' => 'default',
		'itens' => array(
			array(
				'name' => 'event_location_name',
				'type' => 'text',
				'label' => 'Nome do local',
				'size' => 'medium',
			),
			array(
				'name' => 'event_location_address',
				'type' => 'text',
				'label' => 'Endereço completo do local',
				'size' => 'full',
			),
			array(
				'name' => 'event_location_address_excerpt',
				'type' => 'text',
				'label' => 'Endereço resumido do local',
				'label_helper' => 'Será usada no popup do calendário',
				'input_helper' => 'ex: SP - Campinas',
				'size' => 'medium',
			),
		)
	);
	$meta_boxes['events_box4'] = array(
		'id' => 'events_box4', 
		'title' => 'Preço do Evento', 
		'post_type' => array('evento'), 
		'context' => 'normal', 
		'priority' => 'default',
		'itens' => array(
			array(
				'name' => 'event_price',
				'type' => 'text',
				'label' => 'Preço',
				'size' => 'small',
			),
			array(
				'name' => 'event_ticket_url',
				'type' => 'text',
				'label' => 'Link para a inscrição',
				'size' => 'small',
			),
		)
	);
	$my_meta_boxes = new BorosMetaBoxes( $meta_boxes );
	
	/**
	 * VÍDEOS
	 * 
	 */
	$meta_boxes['video_url_box'] = array(
		'id' => 'video_url_box', 
		'title' => 'Endereço do vídeo', 
		'post_type' => array('video'), 
		'context' => 'normal', 
		'priority' => 'default',
		'itens' => array(
			array(
				'name' => 'video_url',
				'type' => 'text',
				'label' => 'URL',
				'label_helper' => 'YouTube, Vimeo',
				'size' => 'full',
			),
		)
	);
	
	/**
	 * FORNECEDORES
	 * 
	 */
	$meta_boxes['supplier_info_box'] = array(
		'id' => 'supplier_info_box', 
		'title' => 'Dados do fornecedor', 
		'post_type' => array('supplier'), 
		'context' => 'normal', 
		'priority' => 'default',
		'itens' => array(
			array(
				'std' => 'comum',
				'name' => 'fornecedor_tipo',
				'type' => 'radio',
				'label' => 'Tipo de fornecedor',
				'options' => array(
					'values' => array(
						'comum' => 'Comum',
						'destacado' => 'Destacado',
					),
				),
			),
			array(
				'name' => 'fornecedor_imagem',
				'type' => 'special_image',
				'label' => 'Logotipo',
				'attr' => array('elem_class' => 'destacado'),
			),
			array(
				'name' => 'fornecedor_texto',
				'type' => 'textarea',
				'label' => 'Texto promocional',
				'attr' => array('elem_class' => 'destacado'),
				'validate' => array(
					array(
						'rule' => 'string_limit',
						'args' => 39,
						'message' => 'Limite máximo de 36 caracteres. O campo foi corrigido automaticamente',
					)
				),
			),
			array(
				'name' => 'fornecedor_url',
				'type' => 'text',
				'size' => 'large',
				'label' => 'URL',
			),
			array(
				'name' => 'fornecedor_telefone',
				'type' => 'text',
				'size' => 'medium',
				'label' => 'Telefone',
			),
			array(
				'name' => 'fornecedor_email',
				'type' => 'text',
				'size' => 'medium',
				'label' => 'Email',
			),
			array(
				'name' => 'fornecedor_cidade',
				'type' => 'text',
				'size' => 'medium',
				'label' => 'Cidade',
			),
			array(
				'name' => 'fornecedor_atividades',
				'type' => 'textarea',
				'size' => 'full',
				'label' => 'Atuação e atividades da empresa',
			),
		)
	);
	
	$my_meta_boxes = new BorosMetaBoxes( $meta_boxes );
}

function devint_save_event_date( $post, $element_config, $value ){
	//pre($post, 'post');
	//pre($element_config, 'element_config');
	//pre($value, 'value');
	//die();
	
	devint_set_events_in_years($value['start_iso'], $value['end_iso'], $post->ID);
	
	update_post_meta( $post->ID, 'event_start_year', date('Y', strtotime($value['start_iso'])) );
	update_post_meta( $post->ID, 'event_start_month', date('m', strtotime($value['start_iso'])) );
	update_post_meta( $post->ID, 'event_end_year', date('Y', strtotime($value['end_iso'])) );
	update_post_meta( $post->ID, 'event_end_month', date('m', strtotime($value['end_iso'])) );
	
	update_post_meta( $post->ID, 'event_start', $value['start_iso'] );
	update_post_meta( $post->ID, 'event_end', $value['end_iso'] );
	return $value;
}

function devint_set_events_in_years( $start, $end, $post_id, $add = true ){
	
	$events_in_years = get_option('events_in_years');
	if( empty($events_in_years) ){
		$events_in_years = array();
	}
	
	/**
	 * Duração do evento em dias - PHP 5.3
	 * @link http://stackoverflow.com/a/3207849
	 * 
	 */
	$s = new DateTime($start); 
	$e = new DateTime($end);
	$e->modify('+1 day');
	$interval = DateInterval::createFromDateString('1 day');
	$period = new DatePeriod($s, $interval, $e);
	$event_days = array();
	foreach( $period as $ed ){
		$y = $ed->format('Y');
		$m = $ed->format('m');
		$d = $ed->format('d');
		
		// adicionar evento ao dia
		if( $add == true ){
			if( isset($events_in_years[$y][$m][$d]) ){
				if( !in_array( $post_id, $events_in_years[$y][$m][$d] ) ){
					$events_in_years[$y][$m][$d][] = $post_id;
				}
			}
			else{
				$events_in_years[$y][$m][$d][] = $post_id;
			}
		}
		// remover evento do dia
		else{
			$events_in_years[$y][$m][$d] = array_diff($events_in_years[$y][$m][$d], array($post_id));
		}
	}
	$events_in_years = boros_trim_array($events_in_years);
	ksortRecursive($events_in_years);
	update_option('events_in_years', $events_in_years);
}

add_action( 'trashed_post', 'devint_trashed_post', 11, 2 );
function devint_trashed_post( $post_id, $post = null ){
	if( isset($post->post_type) && $post->post_type == 'evento' ){
		$event_date = get_post_meta($post_id, 'event_date', true);
		devint_set_events_in_years($event_date['start_iso'], $event_date['end_iso'], $post_id, false);
	}
}

add_action( 'untrashed_post', 'devint_untrashed_post', 11, 2 );
function devint_untrashed_post( $post_id, $post = null ){
	if( $post->post_type == 'evento' ){
		$event_date = get_post_meta($post_id, 'event_date', true);
		devint_set_events_in_years($event_date['start_iso'], $event_date['end_iso'], $post_id);
	}
}

/**
 * ksort() recursive
 * @link https://gist.github.com/cdzombak/601849
 * 
 */
function ksortRecursive(&$array, $sort_flags = SORT_REGULAR) {
	if (!is_array($array)) return false;
	ksort($array, $sort_flags);
	foreach ($array as &$arr) {
		ksortRecursive($arr, $sort_flags);
	}
	return true;
}
