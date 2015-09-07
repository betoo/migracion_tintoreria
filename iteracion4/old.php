<?php 
	$db_new =[
		'tintoreriaCI'=>''
		];


	$db_old =[
		'tintoreria'=>[
				
			'master_tinenres'=>[
						'Receta'	=>'Receta',
						'Descrip'	=>'Descrip',
						'Costo'		=>'Costo',
						'Fibra'		=>'Fibra',
						'Por1'		=>'Por1',
						'Por2'		=>'Por2',
						'Costop'	=>'Costop',
						'Manual'	=>'Manual',
						'Valcos'	=>'Valcos',
						'Unialt'	=>'Unialt',
						'num_consultas'	=>50,
						'new_table'		=>'master_tinenres',
						'is_document'	=>true,

				],
			'master_tinhispr'=>[
				'Comprob'	=> null,
				'Fecha'		=> 'fecha____doc',
				'Declara'	=> null,
				'Tipo'		=> null,
				'Producto'	=> 'producto_id_______prd',
				'Cantidad'	=> 'cantidad_doc',
				'Costo'		=> null,
				'Modi'		=> null,
				'num_consultas'	=>3,
				'is_document'	=>'true',
			],

/*
				
				'master_tinprod'=>[
						'Producto'	=>'codigo___prd', //nombre campo en db antigua => nombre campo en db nueva
						'Descrip'	=>'nombre___prd',
						'Stockact'	=>null,//los campos que estan en NULL no son migrados
						'Stockneces'=>null,
						'Stockini'	=>null,
						'Costo'		=>null,
						'Costoppp'	=>null,
						'Rutpro1'	=>null,
						'Rutpro2'	=>null,
						'Stockmin'	=>null,
						'Ubicacion'	=>null,
						'Cosini'	=>null,
						'Inicial'	=>null,
						'Unidad'	=>[//nombre de campo en bd antigua
									'meta_data_new_table'=>[
										'table_name'			=>'medidas',//nombre tabla en db nueva
										'field_name'			=>'abreviadomed',//nombre campo en db nueva
										'pk_name'				=> 'id_______med',//nombre de llave primaria para la tabla 
										'fk_name'				=> 'medidas_id_______med', // nombre de llave forarea en tabla antigua (en la tabla cliente la llave foranea se llama transporte_id_______tra)
										'num_consultas'			=>1,//cantidad de insert 
										'insert_if_not_exist'	=> false, //al generar la relación, si el registro no existe, lo agrega a la db  y genere relación 
										'not_in'				=> false,//no genera relacion para los registros (busca sobre el campo field_name)
										
									],
								],
						'is_document'	=>'false',
						'num_consultas'	=>3,
						'new_table'		=>null,

				], 

				'master_cliente' =>[//nombre tabla en db antigua

					'Rut'		=>'rut______cli',//nombre campo en db antigua => nombre campo en db nueva
					'Codigo'	=>'codigo___cli',
					'Razon'		=>'razon____cli',
					'Direccion'	=>'direccioncli',
					'Encargado'	=>null,//los campos que estan en NULL no son migrados
					'Ciudad'	=>null,
					'Vendedor'	=>null,
					'Transporte'=>[//nombre de campo en bd antigua
									'meta_data_new_table'=>[
										'table_name'=>'transporte',//nombre tabla en db nueva
										'field_name'=>'nombre___tra',//nombre campo en db nueva
										'pk_name'	=> 'id_______tra',//nombre de llave primaria para la tabla 
										'fk_name'	=> 'transporte_id______tra', // nombre de llave forarea en tabla antigua (en la tabla cliente la llave foranea se llama transporte_id_______tra)
										'num_consultas'	=>1,//cantidad de insert 
									],
								],
					'Condicion' => [//nombre de campo en bd antigua
									'meta_data_new_table'=>[
										'table_name'=>'condicion',//nombre tabla en db nueva
										'field_name'=>'nombre___con',//nombre campo en db nueva
										'pk_name'	=> 'id_______con',
										'fk_name'	=> 'condicion_id_______con', // nombre de llave forarea en tabla (en la tabla cliente la llave foranea se llama transporte_id_______tra)
										'num_consultas'	=>2,//cantidad de insert 
									],
								],
					'num_consultas'	=>4,//cantidad de insert para cada tabla 
					'new_table'		=>'cliente',//nombre tabla en db nueva
					'is_document'	=>false,

						
				],
				

				'master_tinenree'=>[
						'Recetacor'	=> 'Recetacor',
						'Clasific'	=> 'Clasific',
						'Kg1fib'	=> 'Kg1fib',
						'Kg2fib'	=> 'Kg2fib',
						'Descrip'	=> 'Descrip',
						'Fecha'		=> 'Fecha',
						'Costotot'	=> 'Costotot',
						'Flag'		=> 'Flag',
						'Hora'		=> 'Hora',
						'Litros'	=> 'Litros',
						'Reproceso'	=> 'Reproceso',
						'Clarepro'	=> 'Clarepro',
						'Unialt'	=> 'Unialt',
						'Reccli'	=> 'Reccli',
						'num_consultas'	=>40,
						'new_table'		=>'master_tinenree',
						'is_document'	=>false,
				],


				'master_tinderes'=>[

						'Receta'	=>'Receta',
						'Linea1'	=>'Linea1',
						'Producto'	=>[
										'relations'=>[
											'table_name'			=>'producto',//nombre tabla en db nueva
											'field_name'			=>'codigo___prd',//nombre campo en db nueva
											'pk_name'				=> 'id_______prd',//nombre de llave primaria para la tabla 
											'fk_name'				=> 'Producto', // nombre de llave forarea en tabla antigua (en la tabla cliente la llave foranea se llama transporte_id_______tra)
											'insert_if_not_exist'	=> true, //al generar la relación, si el registro no existe, lo agrega a la db  y genere relación 
											'not_in'				=> ['#'],//no genera relacion para los registros (busca sobre el campo field_name)
										],
									],
						'Cantidad'	=>'Cantidad',
						'Incidencia'=>'Incidencia',
						'Comentario'=>'Comentario',
						'num_consultas'	=>100,
						'new_table'		=>'master_tinderes',
						'is_document'	=>false,
						
				],
				
				'master_tinderee'=>[

						'Recetacor'	=>'Recetacor',
						'Linea1'	=>'Linea1',
						'Producto'	=>[
										'relations'=>[
											'table_name'=>'producto',//nombre tabla en db nueva
											'field_name'=>'codigo___prd',//nombre campo en db nueva
											'pk_name'	=> 'id_______prd',//nombre de llave primaria para la tabla 
											'fk_name'	=> 'Producto', // nombre de llave forarea en tabla antigua (en la tabla cliente la llave foranea se llama transporte_id_______tra)
											'insert_if_not_exist'	=> true, //al generar la relación, si el registro no existe, lo agrega a la db  y genere relación 
											'not_in'				=> ['#'],//no genera relacion para los registros (busca sobre el campo field_name)
										],
									],
						'Cantidad'	=>'Cantidad',
						'Incidencia'=>'Incidencia',
						'Comentario'=>'Comentario',
						'Costo'		=>'Costo',
						'Costo5'	=>'Costo5',
						'num_consultas'	=>700,
						'new_table'		=>'master_tinderee',
						'is_document'	=>false,
						
				],
			
				'master_piezas'=>[
						'Pi_ordtrab'=>null,
						'Pi_linea'=>null,
						'Pi_cliente'=>null,
						'Pi_pieza'=>null,
						'Pi_fibra'=>null,
						'Pi_porc1'=>'proporci1pza',
						'Pi_porc2'=>'proporci2pza',
						'Pi_tejido'=>[
									'meta_data_new_table'=>[
										'table_name'=>'tejido',//nombre tabla en db nueva
										'field_name'=>'nombre___tej',//nombre campo en db nueva
										'pk_name'	=> 'id_______tej',
										'fk_name'	=> 'tejido_id_______tej', // nombre de llave forarea en tabla (en la tabla cliente la llave foranea se llama transporte_id_______tra)
										'num_consultas'	=>10,//cantidad de insert 
									],
							],
						'num_consultas'	=>50,
						'new_table'		=>'piezas',
						'is_document'	=>false,
				],
				

				'master_fibras'=>[
					'Fi_fibra'=>'id_______fib',
					'Fi_nomabre'=>'abreviadofib',
					'Fi_nomexte'=>'nombre___fib',
					'Fi_porc1'=>null,
					'Fi_porc2'=>null,
					'num_consultas'	=>10,
					'new_table'		=>'fibras',
					'is_document'	=>false,

				],


				'master_oper'=>[
					'Op_oper'	=>'id_______per',
					'Op_nombre'	=>'nombre___per',
					'num_consultas'	=>2,//cantidad de insert para cada tabla 
					'new_table'		=>'personal',
					'is_document'	=>false,
				],
				


*/
/*
			

				'master_tinenree'=>[
						'Recetacor'	=>['type'=>'varchar(6)'],
						'Clasific'	=>['type'=>'char(2)'],
						'Kg1fib'	=>['type'=>'decimal(9,2)'],
						'Kg2fib'	=>['type'=>'decimal(9,2)'],
						'Descrip'	=>['type'=>'varchar(30)'],
						'Fecha'		=>['type'=>'date'],
						'Costotot'	=>['type'=>'decimal(11,3)'],
						'Flag'		=>['type'=>'char(1)'],
						'Hora'		=>['type'=>'varchar(8)'],
						'Litros'	=>['type'=>'int(5)'],
						'Reproceso'	=>['type'=>'char(1)'],
						'Clarepro'	=>['type'=>'char(2)'],
						'Unialt'	=>['type'=>'decimal(9,2)']	,	
						'Reccli'	=>['type'=>'varchar(20)'],
				],
	
*/
				
				


				
				
			]
		];


/*

truncate tintoreriaCI.producto;
truncate tintoreriaCI.cliente;
truncate tintoreriaCI.master_tinenres;
truncate tintoreriaCI.master_tinenree;
truncate tintoreriaCI.master_tinderes;
truncate tintoreriaCI.master_tinderee;
truncate tintoreriaCI.piezas;
truncate tintoreriaCI.fibras;
truncate tintoreriaCI.personal;
truncate tintoreriaCI.transporte;
truncate tintoreriaCI.condicion;
truncate tintoreriaCI.medidas;
truncate tintoreriaCI.tejido;
truncate tintoreriaCI.categoria;
truncate tintoreriaCI.upriv_groups_ugrp_fk;

 select count(*) from cliente;
 select count(*) from producto;
 select count(*) from master_tinenres;
 select count(*) from master_tinenree;
 select count(*) from master_tinderes;
 select count(*) from master_tinderee;
 select count(*) from piezas;
 select count(*) from fibras;
 select count(*) from personal;
 select count(*) from transporte;
 select count(*) from condicion;
 select count(*) from medidas;
 select count(*) from tejido;
 select count(*) from categoria;




*/

?>