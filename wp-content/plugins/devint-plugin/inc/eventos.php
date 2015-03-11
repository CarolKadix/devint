<?php
/**
 * EVENTOS
 * Funções para os eventos: criar tabela, gerar dropdown de meses, buscar eventos
 * 
 * 
 */



/**
 * CSS de eventos
 * 
 */
add_action('wp_enqueue_scripts', 'devint_enqueue_event_styles');
function devint_enqueue_event_styles(){
	wp_enqueue_style('event-styles', DEVINT_URL. 'css/event-styles.css');
}

/**
 * Scripts de eventos
 * 
 */
add_action('wp_enqueue_scripts', 'devint_enqueue_event_scripts');
function devint_enqueue_event_scripts(){
	wp_enqueue_script('event-scripts', DEVINT_URL. 'js/event-scripts.js', null, 'jquery', true);
}



function devint_events_table(){
	$events = new Events_Calendar();
	$events->get_table_events();
	$events->show_events_table();
	$events->get_list_events();
	$events->show_events_list();
}

function devint_events_list(){
	$events = new Events_Calendar();
	$events->get_month_events();
	$events->show_month_events();
}

class Events_Calendar {
	
	var $today = 0;
	
	var $day = 0;
	
	var $month = 0;
	
	var $month_number = 0;
	
	var $month_name = '';
	
	var $pmonth = 0;
	
	var $year = 0;
	
	var $days_in_month = 0;
	
	var $first_day = 0;
	
	var $day_of_week = '';
	
	var $start = 0;
	
	var $end = 0;
	
	var $query_table_events;
	
	var $table_events = array();
	
	var $query_list_events;
	
	var $list_events = array();
	
	var $query_month_events = array();
	
	var $month_events = array();
	
	
	function __construct(){
		global $wp_locale; //pre($wp_locale);
		date_default_timezone_set('America/Sao_Paulo');
		
		// hoje, default
		$this->today  = time();
		$this->day   = date('d', $this->today); 
		$this->month = date('m', $this->today); 
		$this->year  = date('Y', $this->today);
		
		// variáveis de url
		if( isset($_GET['em']) ){
			$this->month = (int) $_GET['em'];
		}
		if( isset($_GET['ea']) ){
			$this->year = (int) $_GET['ea'];
		}
		
		//pre($this->year, 'year');
		//pre($this->month, 'month');
		
		// primeiro dia do mês
		$this->first_day = mktime(0,0,0,$this->month, 1, $this->year) ; 
		
		// quantos dias existem neste mês
		$this->days_in_month = cal_days_in_month(0, $this->month, $this->year);
		
		$this->pmonth = sprintf('%02d', $this->month); // format de mês com leading-zero
		$this->month_number = date('m', $this->first_day);
		$this->month_name = $wp_locale->month[$this->month_number];
		
		// dia da semana do primeiro dia
		$this->day_of_week = date('D', $this->first_day) ; 
		
		// início e fim do mês
		$this->start = "{$this->year}-{$this->pmonth}-01";
		$this->end = "{$this->year}-{$this->pmonth}-{$this->days_in_month}";
	}
	
	function get_table_events(){
		$query = array(
			'post_type' => 'evento',
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'meta_query' => array(
				array(
					'key' => 'event_end',
					'value' => $this->start,
					'compare' => '>=',
					'type' => 'DATE',
				),
				array(
					'key' => 'event_start',
					'value' => $this->end,
					'compare' => '<=',
					'type' => 'DATE',
				),
			),
		);
		$this->query_table_events = new WP_Query();
		$this->query_table_events->query($query);
		if( $this->query_table_events->posts ){
			foreach( $this->query_table_events->posts as $post ){
				setup_postdata($post);
				$metas = get_post_custom($post->ID);
				// definir os metas
				$post->metas = $this->set_metas($metas);
				
				/**
				 * Duração do evento em dias - PHP 5.3
				 * @link http://stackoverflow.com/a/3207849
				 * 
				 */
				$s = new DateTime($post->metas['event_date']['start_iso']); 
				$e = new DateTime($post->metas['event_date']['end_iso']);
				$e->modify('+1 day');
				$interval = DateInterval::createFromDateString('1 day');
				$period = new DatePeriod($s, $interval, $e);
				$post->event_days = array();
				foreach( $period as $ed ){
					$post->event_days[] = $ed->format('Y-m-d');
				}
				
				// categoria
				$terms = wp_get_post_terms( $post->ID, 'evento_categoria' );
				$post->evento_categoria = array();
				if( !empty($terms) ){
					foreach( $terms as $t ){
						$post->evento_categoria[] = $t;
					}
				}
				$this->table_events[] = $post;
				//pre($post, 'post', false);
				//pre( date('m', strtotime($post->metas['event_date']['start_iso'])) );
				//pre( date('m', strtotime($post->metas['event_date']['end_iso'])) );
			}
		}
		wp_reset_query();
	}
	
	function set_metas( $meta_values ){
		$meta_keys = array(
			'event_excerpt',
			'event_date_string',
			'event_date',
			'event_start',
			'event_end',
			'event_location_name',
			'event_location_address',
			'event_location_address_excerpt',
			'event_price',
			'event_ticket_url',
		);
		$metas = array();
		foreach( $meta_keys as $key ){
			$metas[$key] = maybe_unserialize($meta_values[$key][0]);
		}
		return $metas;
	}
	
	function show_events_table(){
		global $wp_locale; //pre($wp_locale);
		
		// dias do mês anterior
		switch($this->day_of_week){
			case 'Sun': $blank = 0; break;
			case 'Mon': $blank = 1; break;
			case 'Tue': $blank = 2; break;
			case 'Wed': $blank = 3; break;
			case 'Thu': $blank = 4; break;
			case 'Fri': $blank = 5; break;
			case 'Sat': $blank = 6; break;
			default : $blank = 0;
		}
		
		echo '<div id="events-table-box">';
		
		// nav head
		echo '<div class="eventos-nav row">';
			echo '<div class="col-md-4 col-sm-4">';
				$this->prev_next_month_link();
			echo '</div>';
			echo '<div class="col-md-4 col-sm-4">';
				$this->table_events_dropdown();
			echo '</div>';
			echo '<div class="col-md-4 col-sm-4">';
				$this->prev_next_month_link(false);
			echo '</div>';
		echo '</div>';
		
		// criar array de mes > semanas > dias, para que possa ser duplicado, a primeira é para os cabeçalhos 
		// com dia e o segundo para os eventos do dia
		$month_table = array();
		$week_count = 0;
		$month_table[$week_count] = array();

		// comtador dia da semana
		$day_count = 1;

		// espaço dos dias do mês anterior
		while( $blank > 0 ){
			//echo "\t\t<td class='blank-day'><div class='cell-header'></div></td>\n";
			$month_table[$week_count][] = array(
				'day_num' => ' &nbsp; ',
				'day_pad' => ' &nbsp; ',
				'class' => 'blank-day',
				'active' => false,
			);
			$blank = ($blank - 1);
			$day_count++;
		}
		
		// primeiro dia do mês
		$day_num = 1;
		
		while ( $day_num <= $this->days_in_month ){
			$today = date('Ymd');
			$day_pad = sprintf('%02d', $day_num);
			
			if( "{$this->year}{$this->pmonth}{$day_pad}" < $today ){
				$active = false;
				$class = 'past_day';
			}
			elseif( "{$this->year}{$this->pmonth}{$day_pad}" == $today ){
				$active = true;
				$class = 'today';
			}
			else{
				$active = true;
				$class = 'future_day';
			}
			
			// identificar se é sexta ou sábado - precisam de class para o posicionamento do popup
			if( $day_count >= 5 ){
				$class .= ' last-days';
			}
			
			$month_table[$week_count][] = array(
				'day_num' => $day_num,
				'day_pad' => $day_pad,
				'class' => $class,
				'active' => $active,
			);
			
			$day_num++;
			$day_count++;
			
			// uma linha por semana
			if ($day_count > 7){
				$day_count = 1;
				$week_count++;
			}
		}
		
		// dias do próximo mês
		while( $day_count > 1 && $day_count <= 7 ){ 
			$month_table[$week_count][] = array(
				'day_num' => ' &nbsp ',
				'day_pad' => ' &nbsp ',
				'class' => 'blank-day',
				'active' => false,
			);
			$day_count++; 
		}
		
		//pre($month_table);
		
		// iniciar tabela
		echo "\n<table id='eventos-table' cellspacing='0' cellpadding='0'>\n";
		echo "\t<tr>\n\t\t<th>Domingo</th><th>Segunda</th><th>Terça</th><th>Quarta</th><th>Quinta</th><th>Sexta</th><th>Sábado</th>\n\t</tr>\n";
		
		// loop
		foreach( $month_table as $windex => $week ){
			// primeiro loop, head de dias
			echo "\t<tr class='week-{$windex}'>\n";
			foreach( $week as $day ){
				echo "\t\t<td class='cell-header {$day['class']}'>{$day['day_pad']}</td>\n";
			}
			echo "\t</tr>\n";
			
			// segundo loop, eventos
			echo "\t<tr class='week-{$windex}'>\n";
			foreach( $week as $day ){
				echo "\t\t<td class='cell-events {$day['class']}'>\n\t\t";
				$this->show_day_events($day['day_num'], $day['active']);
				echo "</td>\n";
			}
			echo "\t</tr>\n";
		}
		
		echo "\t</tr>\n</table>";
		
		// nav footer
		echo '<div class="eventos-nav row">';
			echo '<div class="col-md-4 col-sm-4">';
				$this->prev_next_month_link();
			echo '</div>';
			echo '<div class="col-md-4 col-sm-4">';
				$this->table_events_dropdown();
			echo '</div>';
			echo '<div class="col-md-4 col-sm-4">';
				$this->prev_next_month_link(false);
			echo '</div>';
		echo '</div>';
		
		echo '</div>';
	}
	
	function show_day_events( $day, $active ){
		$day = sprintf('%02d', $day);
		$day_index = "{$this->year}-{$this->pmonth}-{$day}";
		
		foreach( $this->table_events as $evt ){
			if( in_array($day_index, $evt->event_days) ){
				?>
				<div class="single_event">
					<div class="event-btn-ovelay"></div>
					<div class="event-location"><?php echo $evt->metas['event_location_address_excerpt']; ?></div>
					<div class="event-title"><?php echo $evt->post_title; ?></div>
					<div class="event-popup">
						<div class="event-popup-arrow"></div>
						<div class="event-popup-arrow2"></div>
						<div class="event-popup-inner">
							<div class="event-btn-close"></div>
							<?php if( !empty($evt->evento_categoria) ){ echo "<div class='event-popup-category'>{$evt->evento_categoria[0]->name}</div>";} ?>
							<div class="event-popup-title"><?php echo $evt->post_title; ?></div>
							<div class="event-popup-item event-popup-excerpt"><?php echo apply_filters('the_content', $evt->metas['event_excerpt']); ?></div>
							<div class="event-popup-item event-popup-date"><?php echo apply_filters('the_content', $evt->metas['event_date_string']) ?></div>
							<div class="event-popup-item event-popup-location">
								<strong><?php echo $evt->metas['event_location_name']; ?></strong><br />
								<?php echo $evt->metas['event_location_address']; ?>
							</div>
							<div class="event-popup-item event-popup-price"><?php echo $evt->metas['event_price']; ?></div>
							<?php if( $active == true ){ ?> 
							<div class="event-popup-item event-popup-ticket"><a href="<?php echo $evt->metas['event_ticket_url']; ?>" target="_blank">Faça sua inscrição</a></div>
							<?php } ?>
						</div>
					</div>
				</div>
				<?php
			}
		}
	}
	
	function prev_next_month_link( $prev = true ){
		global $wp_locale;
		
		if( $prev == true ){
			$modifier = '-1 month';
			$class = 'prev';
		}
		else{
			$modifier = '+1 month';
			$class = 'next';
		}
		$prev_next = new DateTime("{$this->year}-{$this->month}");
		$prev_next->modify($modifier);
		$link = add_query_arg( array('ea' => $prev_next->format('Y'), 'em' => $prev_next->format('n')) );
		echo "<a href='{$link}' class='prev-next-month {$class}'>{$wp_locale->month[$prev_next->format('m')]}</a>";
	}
	
	function get_list_events(){
		// pegar todos os eventos do ano
		$query = array(
			'post_type' => 'evento',
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'meta_query' => array(
				array(
					'key' => 'event_end',
					'value' => "{$this->year}-01-01",
					'compare' => '>=',
					'type' => 'DATE',
				),
				array(
					'key' => 'event_start',
					'value' => "{$this->year}-12-31",
					'compare' => '<=',
					'type' => 'DATE',
				),
				
				//'relation' => 'OR',
				//array(
				//	'key' => 'event_start_year',
				//	'value' => $this->year,
				//),
				//array(
				//	'key' => 'event_end_year',
				//	'value' => $this->year,
				//),
			),
		);
		$this->query_list_events = new WP_Query();
		$this->query_list_events->query($query);
		if( $this->query_list_events->posts ){
			$year_events = array();
			foreach( $this->query_list_events->posts as $post ){
				setup_postdata($post);
				$metas = get_post_custom($post->ID);
				// definir os metas
				$post->metas = $this->set_metas($metas);
				
				/**
				 * Duração do evento em dias, mas considerando apenas o mês atual
				 * @link http://stackoverflow.com/a/3207849
				 * 
				 */
				$s = new DateTime($post->metas['event_date']['start_iso']); 
				$e = new DateTime($post->metas['event_date']['end_iso']);
				$e->modify('+1 day');
				$interval = DateInterval::createFromDateString('1 day');
				$period = new DatePeriod($s, $interval, $e);
				$post->event_days = array();
				foreach( $period as $ed ){
					if( $ed->format('Y') == $this->year ){
						$post->event_days[] = $ed->format('Y-m-d');
					}
				}
				
				// categoria
				$terms = wp_get_post_terms( $post->ID, 'evento_categoria' );
				$post->evento_categoria = array();
				if( !empty($terms) ){
					foreach( $terms as $t ){
						$post->evento_categoria[] = $t;
					}
				}
				$year_events[] = $post;
			}
			//pre($this->list_events);
			//pre($year_events);
			
			foreach( $year_events as $evt ){
				$evt_month = date('m', strtotime($evt->event_days[0]));
				$this->list_events[$evt_month][] = $evt;
			}
			ksort($this->list_events);
			//pre($this->list_events, 'list_events', false);
		}
	}
	
	function show_events_list(){
		global $wp_locale;
		?>
		<div id="events-list-box">
			<div id="events-list-header">
				Eventos em 
				<?php $this->month_events_dropdown(); ?>
			</div>
			<div id="events-list-months">
			<?php
			foreach( $this->list_events as $month => $events ){
				$month_name = $wp_locale->month[$month];
				echo "<div class='events-list-month' id='eventos-list-mont-{$month}'>";
				echo "<div class='events-list-month-name'>{$month_name}</div><div class='event-list-items'>";
				ksort($events);
				foreach( $events as $evt_date => $evt ){
					?>
					<div class="event-list-item">
						<div class="event-list-item-title"><div><?php echo $evt->post_title; ?></div></div>
						<div class="event-list-item-details" data-run-toggle="0">
							<div class="event-list-item-details-info">
								<div class="event-list-item-details-info-head"><?php echo $evt->metas['event_date_string']; ?></div>
								<div class="event-list-item-details-info-body">
									<p><strong><?php echo $evt->metas['event_location_name']; ?></strong> - <?php echo $evt->metas['event_location_address']; ?></p>
									<p><strong>Valor:</strong> <?php echo $evt->metas['event_price']; ?></p>
								</div>
							</div>
							<div class="event-list-item-details-description">
								<?php echo apply_filters('the_content', $evt->post_content); ?>
							</div>
							<div class="event-list-item-details-ticket">
								<a href="<?php echo $evt->metas['event_ticket_url']; ?>" target="_blank">Faça sua inscrição aqui</a>
							</div>
						</div>
					</div>
					<?php
				}
				echo '</div></div>';
			}
			?>
			</div><!-- events-list-months -->
		</div>
		<?php
	}
	
	function get_month_events(){
		// pegar todos os eventos do mes
		$query = array(
			'post_type' => 'evento',
			'post_status' => 'publish',
			'posts_per_page' => -1,
			'meta_query' => array(
				array(
					'key' => 'event_end',
					'value' => $this->start,
					'compare' => '>=',
					'type' => 'DATE',
				),
				array(
					'key' => 'event_start',
					'value' => $this->end,
					'compare' => '<=',
					'type' => 'DATE',
				),
			),
		);
		$this->query_month_events = new WP_Query();
		$this->query_month_events->query($query);
		if( $this->query_month_events->posts ){
			$month_events = array();
			foreach( $this->query_month_events->posts as $post ){
				setup_postdata($post);
				$metas = get_post_custom($post->ID);
				// definir os metas
				$post->metas = $this->set_metas($metas);
				
				/**
				 * Duração do evento em dias, mas considerando apenas o mês atual
				 * @link http://stackoverflow.com/a/3207849
				 * 
				 */
				$s = new DateTime($post->metas['event_date']['start_iso']); 
				$e = new DateTime($post->metas['event_date']['end_iso']);
				$e->modify('+1 day');
				$interval = DateInterval::createFromDateString('1 day');
				$period = new DatePeriod($s, $interval, $e);
				$post->event_days = array();
				foreach( $period as $ed ){
					if( $ed->format('m') == $this->pmonth ){
						$post->event_days[] = $ed->format('Y-m-d');
					}
				}
				
				// categoria
				$terms = wp_get_post_terms( $post->ID, 'evento_categoria' );
				$post->evento_categoria = array();
				if( !empty($terms) ){
					foreach( $terms as $t ){
						$post->evento_categoria[] = $t;
					}
				}
				$month_events[] = $post;
			}
			
			foreach( $month_events as $evt ){
				$this->month_events[$evt->event_days[0]] = $evt;
			}
			ksort($this->month_events);
			//pre($this->month_events);
		}
	}
	
	function show_month_events(){
		global $wp_locale; //pre($wp_locale->weekday);
		$events_in_years = get_option('events_in_years'); //pre($events_in_years, 'events_in_years', false);
		?>
		<div id="month-events-box">
			<div id="month-events-box-index">
				<div id="month-events-header">
					Eventos em 
					<?php $this->month_events_dropdown(); ?>
				</div>
				<div id="month-events-month-list">
					<ul>
						<li><a href="<?php $this->month_events_next_month_link(1); ?>">Jan</a></li>
						<li class="separator"></li>
						<li><a href="<?php $this->month_events_next_month_link(2); ?>">Fev</a></li>
						<li class="separator"></li>
						<li><a href="<?php $this->month_events_next_month_link(3); ?>">Mar</a></li>
						<li class="separator three"></li>
						<li><a href="<?php $this->month_events_next_month_link(4); ?>">Abr</a></li>
						<li class="separator four"></li>
						<li><a href="<?php $this->month_events_next_month_link(5); ?>">Mai</a></li>
						<li class="separator"></li>
						<li><a href="<?php $this->month_events_next_month_link(6); ?>">Jun</a></li>
						<li class="separator three"></li>
						<li><a href="<?php $this->month_events_next_month_link(7); ?>">Jul</a></li>
						<li class="separator"></li>
						<li><a href="<?php $this->month_events_next_month_link(8); ?>">Ago</a></li>
						<li class="separator four"></li>
						<li><a href="<?php $this->month_events_next_month_link(9); ?>">Set</a></li>
						<li class="separator three"></li>
						<li><a href="<?php $this->month_events_next_month_link(10); ?>">Out</a></li>
						<li class="separator"></li>
						<li><a href="<?php $this->month_events_next_month_link(11); ?>">Nov</a></li>
						<li class="separator"></li>
						<li><a href="<?php $this->month_events_next_month_link(12); ?>">Dez</a></li>
					</ul>
					<span></span>
				</div>
			</div>
			<div id="month-events-list">
				<?php
				if( empty($this->month_events) ){
					echo '<h2>Ainda não temos eventos programados para essa data</h2>';
					echo '<p>Mas fique ligado! Cadastre-se em nossa Newsletter e receba informações sobre nossos eventos, assim como dicas e atualizações para ajudar na sua carreira</p>';
				}
				else {
					//pre( $this->month_events, 'month_events', false );
					echo '<div class="month-events-list-items">';
					foreach( $this->month_events as $evt ){
						//pre($evt, 'evt', false);
						$weekday = str_replace('-feira', '', $wp_locale->weekday[date('w', strtotime($evt->event_days[0]))]);
						$day = date('j', strtotime($evt->event_days[0]));
						
						?>
						<div class="month-events-list-item">
							<div class="month-events-list-item-date">
								<div class="month-events-list-item-date-weekday"><?php echo $weekday; ?></div>
								<div class="month-events-list-item-date-day"><?php echo $day; ?></div>
							</div>
							<div class="month-events-list-item-desc">
								<div class="month-events-list-item-desc-title"><h2><?php echo $evt->post_title; ?> <a href="<?php echo $evt->metas['event_ticket_url']; ?>" target="_blank">Faça sua inscrição</a></h2></div>
								<div class="month-events-list-item-desc-info">
									<div class="month-events-list-item-desc-info-date"><?php echo $evt->metas['event_date_string']; ?></div>
									<div class="month-events-list-item-desc-info-location"><strong><?php echo $evt->metas['event_location_name']; ?></strong> <?php echo $evt->metas['event_location_address']; ?></div>
								</div>
								<div class="month-events-list-item-desc-text">
									<?php echo apply_filters('the_content', $evt->post_content); ?>
								</div>
							</div>
						</div>
						<?php
					}
					echo '</div>';
				}
				?>
			</div>
		</div>
		<?php
	}
	
	function month_events_next_month_link( $n ){
		$next = new DateTime("{$this->year}-{$n}");
		echo add_query_arg( array('ea' => $next->format('Y'), 'em' => $next->format('n')) );
	}
	
	function month_events_dropdown(){
		$events_in_years = get_option('events_in_years');
		if( !empty($events_in_years) ){
			echo "<select id='month-events-dropdown' class='month-events-dropdown'>";
			foreach( $events_in_years as $year => $months ){
				$selected = ($this->year == $year) ? ' selected="selected"' : '';
				$link = add_query_arg( array('ea' => $year, 'em' => 1) );
				echo "<option value='{$link}' {$selected}>{$year}</option>";
			}
			echo '</select>';
		}
	}
	
	function table_events_dropdown(){
		global $wp_locale; //pre($wp_locale, 'wp_locale', false);
		$events_in_years = get_option('events_in_years');
		if( !empty($events_in_years) ){
			echo "<select id='table-events-dropdown' class='form-control input-lg table-events-dropdown'>";
			foreach( $events_in_years as $year => $months ){
				foreach( $months as $month => $events ){
					$selected = ($this->year == $year and $this->month == $month ) ? ' selected="selected"' : '';
					$month_name = ucfirst($wp_locale->month[$month]);
					$date = new DateTime("{$year}-{$month}");
					$link = add_query_arg( array('ea' => $date->format('Y'), 'em' => $date->format('n')) );
					echo "<option value='{$link}' {$selected}>{$month_name} de {$year}</option>";
				}
			}
			echo '</select>';
		}
	}
}






