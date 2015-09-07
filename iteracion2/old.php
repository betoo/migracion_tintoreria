<?php 

	$db_old =[
		'tintoreria'=>[
				'master_cliente' =>[

						'Rut'		=>'rut______cli',//nombre campo en db antigua => nombre campo en db nueva
						'Codigo'	=>'codigo___cli',
						'Razon'		=>'razon____cli',
						'Direccion'	=>'direccioncli',
						'Encargado'	=>null,//los campos que estan en NULL no son migrados
						'Ciudad'	=>null,
						'Transporte'=>null,
						'Vendedor'	=>null,
						'Condicion'	=>null,
						'num_consultas'	=>1,//cantidad de insert para cada tabla 
						'tabla_new'		=>'cliente',
						'create_table'	=>[//array para crear nueva tabla (transforma una columna en una tabla)
									'Transporte' => [//nombre de campo en bd antigua
													'table_name'=>'transporte',//nombre tabla en db nueva
													'field_name'=>'nombre___tra',//nombre campo en db nueva
													'pk_name'	=> 'id_______tra',//nombre de llave primaria para la tabla 
													'fk_name'	=> 'transporte_id_______tra', // nombre de llave forarea en tabla antigua (en la tabla cliente la llave foranea se llama transporte_id_______tra)
													'num_consultas'	=>1,//cantidad de insert 
												],
									'Condicion' => [//nombre de campo en bd antigua
													'table_name'=>'condicion',//nombre tabla en db nueva
													'field_name'=>'nombre___con',//nombre campo en db nueva
													'pk_name'	=> 'id_______con',
													'fk_name'	=> 'condicion_id______con', // nombre de llave forarea en tabla (en la tabla cliente la llave foranea se llama transporte_id_______tra)
													'num_consultas'	=>1,//cantidad de insert 
												],
						]
				],
				
				/*
				'master_tinprod'=>[
						'Producto'	=>'codigo___prd', //nombre campo en db antigua => nombre campo en db nueva
						'Descrip'	=>'nombre___prd',
						'Stockact'	=>null,//los campos que estan en NULL no son migrados
						'Stockneces'=>null,
						'Stockini'	=>null,
						'Unidad'	=>null,
						'Costo'		=>null,
						'Costoppp'	=>null,
						'Rutpro1'	=>null,
						'Rutpro2'	=>null,
						'Stockmin'	=>null,
						'Ubicacion'	=>null,
						'Cosini'	=>null,
						'Inicial'	=>null,
						'num_consultas'	=>5,
						'tabla_new'		=>'producto',
						'create_table'	=>[//array para nueva tabla
									'Unidad' => 'medidas'  //nombre de campos en db antigua => nombre tabla en db nueva
						]
				],
				'master_tinderee'=>[

						'Recetacor'	=>'Recetacor',
						'Linea1'	=>'Linea1',
						'Producto'	=>'Producto',
						'Cantidad'	=>'Cantidad',
						'Incidencia'=>'Incidencia',
						'Comentario'=>'Comentario',
						'Costo'		=>'Costo',
						'Costo5'	=>'Costo5',
						'num_consultas'	=>1200,
						'tabla_new'		=>'master_tinderee',
						
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