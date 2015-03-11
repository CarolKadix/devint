<?php
/**
 * ==================================================
 * ASSOCIE-SE :: LOGIN ==============================
 * ==================================================
 * 
 * 
 * 
 */

add_action( 'init', 'devint_form_cadastro' );
function devint_form_cadastro(){
	
	$frontend_forms_test_mode = false;
	if( isset($_GET['test_mode']) and $_GET['test_mode'] == 1 ){
		$frontend_forms_test_mode = true;
	}
	
	/**
	 * Definir valores padrão ou valores de teste
	 * 
	 */
	if( $frontend_forms_test_mode == true ){
		$fake_person = new ProfileGen();
		$fake_person->set_localhost_config( $full_email = false, $email_prefix = 'dev.alexkoti+', $service = 'gmail.com' );
		$profile_data = $fake_person->profile(); //pre($profile_data);
		
		$empresa               = $profile_data['empresa'];
		$fornecedor_url        = 'http://google.com.br';
		$fornecedor_email      = $profile_data['email'];
		$fornecedor_telefone   = $profile_data['telefone_format'];
		$fornecedor_cidade     = $profile_data['cidade'];
		$fornecedor_atividades = $profile_data['mensagem_small'];
	}
	else{
		$empresa               = '';
		$fornecedor_url        = '';
		$fornecedor_email      = '';
		$fornecedor_telefone   = '';
		$fornecedor_cidade     = '';
		$fornecedor_atividades = '';
	}
	
	$block_1 = array(
		array(
			'std' => $empresa,
			'name' => 'post_title',
			'type' => 'text',
			'attr' => array(
				'elem_class' => 'col-md-12',
				'class' => 'form-control',
				'placeholder' => 'Empresa',
			),
			'validate' => array(
				'required' => array(
					'rule' => 'required',
					'message' => 'É preciso preencher o nome da Empresa',
				),
			),
		),
		array(
			'std' => $fornecedor_url,
			'name' => 'fornecedor_url',
			'type' => 'text',
			'attr' => array(
				'elem_class' => 'col-md-12',
				'class' => 'form-control',
				'placeholder' => 'Site',
			),
			'validate' => array(
				'required' => array(
					'rule' => 'required',
					'message' => 'É preciso preencher o site da Empresa',
				),
			),
		),
		array(
			'std' => '',
			'name' => 'tax_input[fornecedor_categoria]',
			'type' => 'taxonomy_select',
			'attr' => array(
				'elem_class' => 'col-md-12',
				'class' => 'form-control',
				'id' => 'select_fornecedor_categoria',
			),
			'validate' => array(
				'required' => array(
					'rule' => 'required',
					'message' => 'É preciso preencher a Categoria',
				),
			),
			'options' => array(
				'type' => 'post_meta',
				'taxonomy' => 'fornecedor_categoria',
				'show_option_all' => 'Categoria',
			),
		),
		array(
			'std' => $fornecedor_email,
			'name' => 'fornecedor_email',
			'type' => 'text',
			'attr' => array(
				'elem_class' => 'col-md-12',
				'class' => 'form-control',
				'placeholder' => 'E-mail',
			),
			'validate' => array(
				'required' => array(
					'rule' => 'required',
					'message' => 'É preciso preencher seu e-mail.',
				),
				'email' => array(
					'rule' => 'email',
					'message' => 'É preciso preencher um e-mail válido.',
				),
			),
		),
		array(
			'std' => $fornecedor_telefone,
			'name' => 'fornecedor_telefone',
			'type' => 'text',
			'attr' => array(
				'elem_class' => 'col-md-12',
				'class' => 'form-control',
				'placeholder' => 'Telefone',
			),
			'validate' => array(
				'required' => array(
					'rule' => 'required',
					'message' => 'É preciso preencher seu telefone.',
				),
			),
		),
		array(
			'std' => $fornecedor_cidade,
			'name' => 'fornecedor_cidade',
			'type' => 'text',
			'attr' => array(
				'elem_class' => 'col-md-7',
				'class' => 'form-control',
				'placeholder' => 'Cidade',
			),
			'validate' => array(
				'required' => array(
					'rule' => 'required',
					'message' => 'É preciso preencher sua cidade.',
				),
			),
		),
		array(
			'std' => '',
			'name' => 'tax_input[estado_fornecedor]',
			'type' => 'taxonomy_select',
			'attr' => array(
				'elem_class' => 'col-md-5',
				'class' => 'form-control',
				'id' => 'select_estado_fornecedor',
			),
			'validate' => array(
				'required' => array(
					'rule' => 'required',
					'message' => 'É preciso preencher o seu estado',
				),
			),
			'options' => array(
				'type' => 'post_meta',
				'taxonomy' => 'estado_fornecedor',
				'show_option_all' => 'UF',
			),
		),
	);
	
	$block_2 = array();
	$block_2[] = array(
		'std' => $fornecedor_atividades,
		'name' => 'fornecedor_atividades',
		'type' => 'textarea',
		'attr' => array(
			'elem_class' => 'col-md-12',
			'class' => 'form-control',
			'placeholder' => 'Descreva aqui a atuação e atividades da sua empresa',
		),
		'validate' => array(
			'required' => array(
				'rule' => 'required',
				'message' => 'É preciso preencher a atuação e atividades da sua empresa',
			),
		),
	);
	
	$block_3 = array();
	$block_3[] = array(
		'name' => 'fornecedor_termos',
		'type' => 'checkbox',
		'input_helper' => 'Confirmo que as informações contidas nesse formulário são verdadeiras e aceito que elas sejam divulgadas caso aprovada',
		'attr' => array(
			'elem_class' => 'col-md-12',
		),
		'validate' => array(
			'required' => array(
				'rule' => 'required',
				'message' => 'É preciso aceitar os termos de uso',
			),
		),
	);
	$block_3[] = array(
		'name' => 'submit',
		'type' => 'submit',
		'std' => 'ENVIAR DADOS',
		'attr' => array(
			'elem_class' => 'col-md-12',
			'class' => 'btn btn-primary btn-block',
		),
	);
	
	
	$elements = array(
		array(
			'id' => 'fornecedor_block_1',
			'class' => 'col-md-4',
			'itens' => $block_1,
		),
		array(
			'id' => 'fornecedor_block_2',
			'class' => 'col-md-4',
			'itens' => $block_2,
		),
		array(
			'id' => 'fornecedor_block_3',
			'class' => 'col-md-4',
			'itens' => $block_3,
		),
	);
	
	// definir se o form foi enviado e mostrar o modal automaticamente
	$class = isset($_GET['mostrar_form']) ? 'show-modal' : 'hide-modal';
	
	$config = array(
		'form_name' => 'devint_form_cadastro',
		'core_post_fields' => array(
			'post_type' => 'supplier',
			'post_author' => 1,
			'post_status' => 'draft',
		),
		'accepted_metas' => array(
			'fornecedor_url' => '',
			'fornecedor_telefone' => '',
			'fornecedor_email' => '',
			'fornecedor_cidade' => '',
			'fornecedor_atividades' => '',
			'fornecedor_termos' => '',
		),
		'accepted_taxonomies' => array(
			'fornecedor_categoria' => array(),
			'estado_fornecedor' => array(),
		),
		'form_id' => 'formulario',
		'action_append' => array('mostrar_form' => true),
		'output_function' => 'bootstrap3',
		'class' => $class,
		'login_required' => false,
		'redirect_on_sucess' => false,
		'messages' => array(
			'success' => 'Cadastro enviado com sucesso!',
			'error' => 'Ocorreram algun(s) erro(s), por favor verifique.',
		),
	);
	
	$context = array(
		'type' => 'frontend',
		'object_type' => 'post',
		'object_id' => 0, // 0 new post
	);
	
	$my_frontend_form = new BorosFrontendForm( $config, $context, $elements );
}









