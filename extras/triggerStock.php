DELIMITER //
CREATE TRIGGER tr_updStockIngreso AFTER INSERT ON detalle_ingresos
 FOR EACH ROW BEGIN
 UPDATE articulos SET stock = stock + NEW.cantidad 
 WHERE articulos.id = NEW.idarticulo;
END
//
DELIMITER ;


//al crear un ingreso actualiza la base de datos 


DELIMITER //
CREATE TRIGGER tr_updStockIngresoAnular AFTER UPDATE ON ingresos FOR EACH ROW 
BEGIN
  UPDATE articulos a
    JOIN detalle_ingresos di
      ON di.idarticulo = a.id
     AND di.idingreso = new.id
     set a.stock = a.stock - di.cantidad;
end;
//
DELIMITER ;


//Triger que actualiza cuando cancelas un ingreso