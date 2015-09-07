<?php 
	
	
	$db_new =[
		'tintoreriaCI'=>[//nombre db
		

			'producto'=>[//nombre tabla
				//nombre columnas 	=> nombre de columna en db antigua
 				//'id_______prd'			=> 
				'nombre___prd'			=> 'Descrip',
				//'categoria_id_______cat'=>['type'=>'int(11)'],
				//'moneda_id_______mon'	=>['type'=>'int(11)'],
				//'observaciprd'			=>['type'=>'text'],
				//'stock_minprd'			=>['type'=>'int(11)'],
				'codigo___prd'			=>'Producto',
				//'medidas_id_______med'	=>['type'=>'int(11)'],	 
			],
			/*
			'master_tinenree'=>[//nombre tabla
					'Recetacor'	=>'Recetacor',  //campo_nuevo => campo antiguo
					'Clasific'	=>'Clasific',
					'Kg1fib'	=>'Kg1fib',
					'Kg2fib'	=>'Kg2fib',
					'Descrip'	=>'Descrip',
					'Fecha'		=>'Fecha',
					'Costotot'	=>'Costotot',
					'Flag'		=>'Flag',
					'Hora'		=>'Hora',
					'Litros'	=>'Litros',
					'Reproceso'	=>'Reproceso',
					'Clarepro'	=>'Clarepro',
					'Unialt'	=>'Unialt',
					'Reccli'	=>'Reccli',
			],

			'master_tinderee'=>[
					'Recetacor'	=>'Recetacor',
					'Producto'	=>'Producto',
					'Linea1'	=>'Linea1',
					'Cantidad'	=>'Cantidad',
					'Incidencia'=>'Incidencia',
					'Comentario'=>'Comentario',
					'Costo'		=>'Costo',
					'Costo5'	=>'Costo5',
			],

			'cliente'=>[
				//'id_______cli'=>'int(11)',
				'rut______cli'=>'Rut',
				'razon____cli'=>'Razon',
				'codigo___cli'=>'Codigo',
				//'encargadocli'=>'varchar(20)',
				'direccioncli'=>'Direccion',
				//'transportcli'=>'varchar(20)',
				//'comuna_id_______com'=>'int(11)',
				//'transporte_id______tra'=>'int(11)',
				//'email____cli'=>'varchar(100)',
				//'condicion_id_______con'=>'int(11)',
				//'telefono_cli'=>'int(11)',
			],
			'personal'=>[
				'id_______per'	=>'Op_oper',
				'nombre___per'	=>'Op_nombre',
			],
			'fibras'=>[
					//'id_______fib'=>'Fi_fibra',
					'nombre___fib'=>'Fi_nomexte',
					'abreviadofib'=>'Fi_nomabre',
										//Fi_porc1
										//Fi_porc2
			],
			*/
			//TABLAS CARGADAS CON DATOS DE OTRAS TABLAS
			'transporte'=>[
				//'id_______tra'=>'',
				'nombre___tra'=>'Transporte'
			],
			'condicion'=>[
				//'id_______con'=>'',
				'nombre___con'=>'Condicion'
			],
			'medidas'=>[
				//'id_______con'=>'',
				'nombre___med'=>'Unidad'
			],
			'piezas' => [
				//'id_______pza'	=>
				//'nombre___pza'	=>
				//'medidas_id_______med'	=>
				//'fibras_id_______fib'	=> 'Pi_fibra',
				//'titulo_id______tit'	=>
				'tejido_id_______tej'	=> 'Pi_tejido',
				//'punto_id_______pun'	=>
				//'entrega_id_______ent'	=>
			],
			'tejido'=>[
				/*'id_______tej'=>'',*/
				'nombre___tej'=>'Pi_tejido'
			],
		]
	];
	



	
	

	/*



tejido
+--------------+-------------+------+-----+---------+----------------+
| Field        | Type        | Null | Key | Default | Extra          |
+--------------+-------------+------+-----+---------+----------------+
| id_______tej | int(11)     | NO   | PRI | NULL    | auto_increment |
| nombre___tej | varchar(20) | YES  |     | NULL    |                |
+--------------+-------------+------+-----+---------+----------------+


piezas
+----------------------+-------------+------+-----+---------+----------------+
| Field                | Type        | Null | Key | Default | Extra          |
+----------------------+-------------+------+-----+---------+----------------+
| id_______pza         | int(11)     | NO   | PRI | NULL    | auto_increment |
| nombre___pza         | varchar(45) | YES  |     | NULL    |                |
| medidas_id_______med | int(11)     | YES  | MUL | NULL    |                |
| fibras_id_______fib  | int(11)     | NO   | MUL | NULL    |                |
| titulo_id______tit   | int(11)     | YES  | MUL | NULL    |                |
| tejido_id_______tej  | int(11)     | NO   | MUL | NULL    |                |
| punto_id_______pun   | int(11)     | NO   | MUL | NULL    |                |
| entrega_id_______ent | int(11)     | YES  | MUL | NULL    |                |
| proporci1pza         | double      | YES  |     | NULL    |                |
| proporci2pza         | double      | YES  |     | NULL    |                |
| observaciopza        | text        | YES  |     | NULL    |                |
+----------------------+-------------+------+-----+---------+----------------+


fibras

+--------------+-------------+------+-----+---------+----------------+
| Field        | Type        | Null | Key | Default | Extra          |
+--------------+-------------+------+-----+---------+----------------+
| id_______fib | int(11)     | NO   | PRI | NULL    | auto_increment |
| nombre___fib | varchar(20) | YES  |     | NULL    |                |
| abreviadofib | varchar(45) | YES  |     | NULL    |                |
+--------------+-------------+------+-----+---------+----------------+

personal
+---------------------------+-------------+------+-----+---------+----------------+
| Field                     | Type        | Null | Key | Default | Extra          |
+---------------------------+-------------+------+-----+---------+----------------+
| id_______per              | int(11)     | NO   | PRI | NULL    | auto_increment |
| rut______per              | int(11)     | YES  |     | NULL    |                |
| nombre___per              | varchar(45) | YES  |     | NULL    |                |
| apellido_per              | varchar(45) | YES  |     | NULL    |                |
| telefono_per              | varchar(45) | YES  |     | NULL    |                |
| email____per              | varchar(45) | YES  |     | NULL    |                |
| direccionper              | varchar(45) | YES  |     | NULL    |                |
| observaciper              | text        | YES  |     | NULL    |                |
| empresa_id_______emp      | int(11)     | NO   | MUL | NULL    |                |
| maquinaria_id_______maq   | int(11)     | NO   | MUL | NULL    |                |
| nacionalidad_id_______nac | int(11)     | NO   | MUL | NULL    |                |
| cargo_id_______car        | int(11)     | NO   | MUL | NULL    |                |
| comuna_id_______com       | int(11)     | NO   | MUL | NULL    |                |
| turno_id_______tur        | int(11)     | NO   | MUL | NULL    |                |
+---------------------------+-------------+------+-----+---------+----------------+


master_oper
-----------+-------------+------+-----+---------+-------+
| Field     | Type        | Null | Key | Default | Extra |
+-----------+-----------_--+------+-----+---------+-------+
| Op_oper   | char(2)     | NO   | PRI | NULL    |       |
| Op_nombre | varchar(40) | NO   |     | NULL    |       |
+-----------+-------------+------+-----+---------+-------+


producto
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



+------------------------+--------------+------+-----+---------+----------------+
| Field                  | Type         | Null | Key | Default | Extra          |
+------------------------+--------------+------+-----+---------+----------------+
| id_______cli           | int(11)      | NO   | PRI | NULL    | auto_increment |
| rut______cli           | int(11)      | YES  |     | NULL    |                |
| razon____cli           | varchar(30)  | YES  |     | NULL    |                |
| codigo___cli           | int(11)      | YES  |     | NULL    |                |
| encargadocli           | varchar(20)  | YES  |     | NULL    |                |
| direccioncli           | varchar(20)  | YES  |     | NULL    |                |
| transportcli           | varchar(20)  | YES  |     | NULL    |                |
| comuna_id_______com    | int(11)      | YES  | MUL | NULL    |                |
| transporte_id______tra | int(11)      | YES  | MUL | NULL    |                |
| email____cli           | varchar(100) | YES  |     | NULL    |                |
| condicion_id_______con | int(11)      | NO   | MUL | NULL    |                |
| telefono_cli           | int(11)      | YES  |     | NULL    |                |
+------------------------+--------------+------+-----+---------+----------------+





+------------------------+-------------+------+-----+---------+----------------+
| Field                  | Type        | Null | Key | Default | Extra          |
+------------------------+-------------+------+-----+---------+----------------+
| id_______prd           | int(11)     | NO   | PRI | NULL    | auto_increment |
| nombre___prd           | varchar(45) | YES  |     | NULL    |                |
| categoria_id_______cat | int(11)     | YES  | MUL | NULL    |                |
| moneda_id_______mon    | int(11)     | YES  | MUL | NULL    |                |
| observaciprd           | text        | YES  |     | NULL    |                |
| stock_minprd           | int(11)     | YES  |     | NULL    |                |
| codigo___prd           | varchar(20) | YES  |     | NULL    |                |
| medidas_id_______med   | int(11)     | YES  | MUL | NULL    |                |
+------------------------+-------------+------+-----+---------+----------------+


	*/

 ?>

 <?php 



/*

<?php 
	
	// migracion para recetas estandar (master_tinenree y master_tinderee)

	$db_new =[
		'tintoreriaCI'=>[
			'producto'=>[
				'id_______prd'			=>['type'=>'int(11)'],
				'nombre___prd'			=>['type'=>'varchar(45)'],
				'categoria_id_______cat'=>['type'=>'int(11)'],
				'moneda_id_______mon'	=>['type'=>'int(11)'],
				'observaciprd'			=>['type'=>'text'],
				'stock_minprd'			=>['type'=>'int(11)'],
				'codigo___prd'			=>['type'=>'varchar(20)'],
				'medidas_id_______med'	=>['type'=>'int(11)'],	 
			],

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
					'Producto'=>[
						'type'		=>'varchar(10)',
						'relacion'	=>[
										'table'	=>'producto',
										'fiel'	=>'id_______prd',
									],
					],
					'Linea1'	=>['type'=>'int(3)'],
					'Cantidad'	=>['type'=>'decimal(12,5)'],
					'Incidencia'=>['type'=>'char(1)'],
					'Comentario'=>['type'=>'varchar(25)'],
					'Costo'		=>['type'=>'decimal(13,3)'],
					'Costo5'	=>['type'=>'decimal(15,5)'],
			]
		]
	];
	
	

	/*

+------------------------+-------------+------+-----+---------+----------------+
| Field                  | Type        | Null | Key | Default | Extra          |
+------------------------+-------------+------+-----+---------+----------------+
| id_______prd           | int(11)     | NO   | PRI | NULL    | auto_increment |
| nombre___prd           | varchar(45) | YES  |     | NULL    |                |
| categoria_id_______cat | int(11)     | YES  | MUL | NULL    |                |
| moneda_id_______mon    | int(11)     | YES  | MUL | NULL    |                |
| observaciprd           | text        | YES  |     | NULL    |                |
| stock_minprd           | int(11)     | YES  |     | NULL    |                |
| codigo___prd           | varchar(20) | YES  |     | NULL    |                |
| medidas_id_______med   | int(11)     | YES  | MUL | NULL    |                |
+------------------------+-------------+------+-----+---------+----------------+


	*/

 ?>



