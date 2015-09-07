<?php 
	
	//nombres de tableas para la nueva db
	$relations_table=[
		'master_tinprod'=>'producto',
		'master_cliente'=>'cliente',
		'master_oper'	=>'personal',

	];

	//para generar consulta buscando id de tablas 
	$fk_for_pk=[
		'master_tinderee'=>[
			'producto'=>['id_______prd'=>'codigo___prd'],
		],
		'master_cliente'=>[
			'Transporte'=>['id_______cli'=>'transporte_id______tra'],
			'Condicion'=>['id_______cli'=>'condicion_id______con'],
		],
		'master_tinprod'=>[
			'Unidad'	=> ['medidas'],
		],

		'master_piezas'=>[
			'Pi_tejido'	=>['id_______tej'],
			'Pi_fibra'	=>['id_______fib'],
		]
	];

	//crear nuevas tablas a parti de otras
	$new_table=[
		'master_cliente'=>[
			'Transporte'	=> 'transporte',
			'Condicion'		=>'condicion'	
		],

		'master_tinprod'=>[
			'Unidad'	=> 'medidas',
		],

		'master_piezas'=>[
			'Pi_tejido'=>'tejido',
			'Pi_fibra'=>'fibras',
		],
	];
	/*
	$new_table=[
		'TABLA_ANTIGUA'=>[
			'CAMPO ANTIGUO'	=> 'TABLA NUEVA',
		]
	];
	*/

	$db_old =[
		'tintoreria'=>[


				'master_tinprod'=>[
						'Producto'	=>['type'=> 'varchar(10)'],
						'Descrip'	=>['type'=> 'varchar(30)'],
						'Stockact'	=>['type'=> 'decimal(13,3)'],
						'Stockneces'=>['type'=> 'decimal(13,3)'],
						'Stockini'	=>['type'=> 'decimal(13,3)'],
						'Unidad'	=>['type'=> 'char(2)'],
						'Costo'		=>['type'=> 'decimal(11,2)'],
						'Costoppp'	=>['type'=> 'decimal(11,2)'],
						'Rutpro1'	=>['type'=> 'varchar(11)'],
						'Rutpro2'	=>['type'=> 'varchar(10)'],
						'Stockmin'	=>['type'=> 'decimal(11,3)'],
						'Ubicacion'	=>['type'=> 'varchar(5)'],
						'Cosini'	=>['type'=> 'decimal(11,3)'],
						'Inicial'	=>['type'=> 'decimal(11,3)'],
					],
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
	
				'master_tinderee'=>[

						'Recetacor'=>[
							'type'=>'varchar(6)',
							'relacion'=>[
											'table'=>'master_tinderee',
											'fiel'=>'Recetacor',
										],
						],
						'Linea1'=>[
							'type'=>'int(3)',
							'relacion'=>''
						],
						'Producto'=>[
							'type'=>'varchar(10)',
							'relacion'=>[
											'table'=>'master_tinprod',
											'fiel'=>'Producto',
										],
						],
						'Cantidad'	=>['type'=>'decimal(12,5)'],
						'Incidencia'=>['type'=>'char(1)'],
						'Comentario'=>['type'=>'varchar(25)'],
						'Costo'		=>['type'=>'decimal(13,3)'],
						'Costo5'	=>['type'=>'decimal(15,5)'],
				],

				'master_cliente' =>[

						'Rut'=>'varchar(10)',
						'Codigo'=>'char(3)',
						'Razon'=>'varchar(40)',
						'Encargado'=>'varchar(40)',
						'Direccion'=>'varchar(40)',
						'Ciudad'=>'varchar(15)',
						'Transporte'=>'varchar(30)',
						'Vendedor'=>'char(2)',
						'Condicion'	=>'varchar(30)',
				],
				'master_oper'=>[
					'Op_oper'	=>'',
					'Op_nombre'	=>'',
				],
				'master_fibras'=>[
					'Fi_fibra'=>'',
					'Fi_nomabre'=>'',
					'Fi_nomexte'=>'',
					'Fi_porc1'=>'',
					'Fi_porc2'=>'',

				],
				'master_piezas'=>[
						'Pi_ordtrab'=>'',
						'Pi_linea'=>'',
						'Pi_cliente'=>'',
						'Pi_pieza'=>'',
						'Pi_fibra'=>'',
						'Pi_porc1'=>'',
						'Pi_porc2'=>'',
						'Pi_tejido'=>'',
				],
				*/
			]
		];

/*



piezas

+------------+--------------+------+-----+---------+-------+
| Field      | Type         | Null | Key | Default | Extra |
+------------+--------------+------+-----+---------+-------+
| Pi_ordtrab | varchar(5)   | NO   | PRI | NULL    |       |
| Pi_linea   | int(2)       | NO   | PRI | NULL    |       |
| Pi_cliente | char(3)      | NO   |     | NULL    |       |
| Pi_pieza   | varchar(5)   | NO   |     | NULL    |       |
| Pi_fibra   | char(3)      | NO   |     | NULL    |       |
| Pi_porc1   | decimal(5,1) | NO   |     | NULL    |       |
| Pi_porc2   | decimal(5,1) | NO   |     | NULL    |       |
| Pi_tejido  | varchar(8)   | NO   |     | NULL    |       |
| Pi_ancho   | decimal(4,2) | NO   |     | NULL    |       |
| Pi_pesoini | decimal(6,2) | NO   |     | NULL    |       |
| Guia       | varchar(6)   | NO   |     | NULL    |       |
+------------+--------------+------+-----+---------+-------+



fibras
+------------+--------------+------+-----+---------+-------+
| Field      | Type         | Null | Key | Default | Extra |
+------------+--------------+------+-----+---------+-------+
| Fi_fibra   | char(3)      | NO   | PRI | NULL    |       |
| Fi_nomabre | varchar(10)  | NO   |     | NULL    |       |
| Fi_nomexte | varchar(30)  | NO   |     | NULL    |       |
| Fi_porc1   | decimal(5,1) | NO   |     | NULL    |       |
| Fi_porc2   | decimal(5,1) | NO   |     | NULL    |       |
+------------+--------------+------+-----+---------+-------+



//clientes
+------------+--------------+------+-----+---------+-------+
| Field      | Type         | Null | Key | Default | Extra |
+------------+--------------+------+-----+---------+-------+
| Rut        | varchar(10)  | NO   |     | NULL    |       |
| Codigo     | char(3)      | NO   | PRI | NULL    |       |
| Razon      | varchar(40)  | NO   |     | NULL    |       |
| Encargado  | varchar(40)  | NO   |     | NULL    |       |
| Direccion  | varchar(40)  | NO   |     | NULL    |       |
| Ciudad     | varchar(15)  | NO   |     | NULL    |       |
| Transporte | varchar(30)  | NO   |     | NULL    |       |
| Vendedor   | char(2)      | NO   |     | NULL    |       |
| Condicion  | varchar(30)  | NO   |     | NULL    |       |
| Fono       | varchar(15)  | NO   |     | NULL    |       |
| Zona       | char(2)      | NO   |     | NULL    |       |






+------------+---------------+------+-----+---------+-------+
| Field      | Type          | Null | Key | Default | Extra |
+------------+---------------+------+-----+---------+-------+
| Producto   | varchar(10)   | NO   | PRI | NULL    |       |
| Descrip    | varchar(30)   | NO   |     | NULL    |       |
| Stockact   | decimal(13,3) | NO   |     | NULL    |       |
| Stockneces | decimal(13,3) | NO   |     | NULL    |       |
| Stockini   | decimal(13,3) | NO   |     | NULL    |       |
| Unidad     | char(2)       | NO   |     | NULL    |       |
| Costo      | decimal(11,2) | NO   |     | NULL    |       |
| Costoppp   | decimal(11,2) | NO   |     | NULL    |       |
| Rutpro1    | varchar(11)   | NO   |     | NULL    |       |
| Rutpro2    | varchar(10)   | NO   |     | NULL    |       |
| Stockmin   | decimal(11,3) | NO   |     | NULL    |       |
| Ubicacion  | varchar(5)    | NO   |     | NULL    |       |
| Cosini     | decimal(11,3) | NO   |     | NULL    |       |
| Inicial    | decimal(11,3) | NO   |     | NULL    |       |
+------------+---------------+------+-----+---------+-------+



	
	//master_tinenree

+-----------+---------------+------+-----+---------+-------+
| Field     | Type          | Null | Key | Default | Extra |
+-----------+---------------+------+-----+---------+-------+
| Recetacor | varchar(6)    | NO   | PRI | NULL    |       |
| Clasific  | char(2)       | NO   |     | NULL    |       |
| Kg1fib    | decimal(9,2)  | NO   |     | NULL    |       |
| Kg2fib    | decimal(9,2)  | NO   |     | NULL    |       |
| Descrip   | varchar(30)   | NO   |     | NULL    |       |
| Fecha     | date          | NO   |     | NULL    |       |
| Costotot  | decimal(11,3) | NO   |     | NULL    |       |
| Flag      | char(1)       | NO   |     | NULL    |       |
| Hora      | varchar(8)    | NO   |     | NULL    |       |
| Litros    | int(5)        | NO   |     | NULL    |       |
| Reproceso | char(1)       | NO   |     | NULL    |       |
| Clarepro  | char(2)       | NO   |     | NULL    |       |
| Unialt    | decimal(9,2)  | NO   |     | NULL    |       |
| Reccli    | varchar(20)   | NO   |     | NULL    |       |
+-----------+---------------+------+-----+---------+-------+



	//master_tinderee
+------------+---------------+------+-----+---------+-------+
| Field      | Type          | Null | Key | Default | Extra |
+------------+---------------+------+-----+---------+-------+
| Recetacor  | varchar(6)    | NO   | PRI | NULL    |       |
| Linea1     | int(3)        | NO   | PRI | NULL    |       |
| Producto   | varchar(10)   | NO   |     | NULL    |       |
| Cantidad   | decimal(12,5) | NO   |     | NULL    |       |
| Incidencia | char(1)       | NO   |     | NULL    |       |
| Comentario | varchar(25)   | NO   |     | NULL    |       |
| Costo      | decimal(13,3) | NO   |     | NULL    |       |
| Costo5     | decimal(15,5) | NO   |     | NULL    |       |
+------------+---------------+------+-----+---------+-------+
	*/

 ?>